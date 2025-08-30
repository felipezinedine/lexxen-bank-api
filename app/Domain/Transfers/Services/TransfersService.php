<?php

namespace App\Domain\Transfers\Services;

use App\Application\DTOs\Account\UpdateDTO;
use App\Application\DTOs\Transfers\CreateDTO;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Domain\User\Repositories\UserInterface;
use App\Domain\Account\Repositories\AccountInterface;
use App\Domain\Transfers\Repositories\TransfersInterface;

class TransfersService
{
    protected UserInterface $userRepository;
    protected AccountInterface $accountRepository;
    protected TransfersInterface $transfersInterface;

    public function __construct (AccountInterface $accountRepository, UserInterface $userRepository, TransfersInterface $transfersInterface)
    {
        $this->accountRepository = $accountRepository;
        $this->userRepository = $userRepository;
        $this->transfersInterface = $transfersInterface;
    }

    public function transfer (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from_account_id' => 'required',
            'to_account_id' => 'required',
            'value' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $from_account = $this->checkAccountByType($request->from_account_id); // quem está enviando
        $to_account = $this->checkAccountByType($request->to_account_id, 'Conta destinatária'); // quem está recebendo
        $this->checkAccountValue($from_account, $request->value);

        $dto = new CreateDTO($from_account->id, $to_account->id, $request->value);
        $transfer = $this->transfersInterface->store($dto->toArray());

        $dtoUpdateAccount = new UpdateDTO([
            'balance' => $from_account->balance - $request->value,
        ]);
        $this->accountRepository->update($dtoUpdateAccount->toArray(), $request->user_id, $from_account->number);

        $dtoUpdateAccountRecipient = new UpdateDTO([
            'balance' => $to_account->balance + $request->value,
        ]);
        $this->accountRepository->update($dtoUpdateAccountRecipient->toArray(), $to_account->userId, $to_account->number);

        return [
            'success' => true,
            'message' => 'Transferência feita com sucesso!',
            'transfer' => $transfer,
        ];
    }

    private function checkAccountByType($accountId, $type = 'Sua conta')
    {
        $account = $this->accountRepository->getAccountById($accountId);

        if (!$account) {
            throw new Exception("$type não foi encontrada!");
        } elseif ($account->status === 'blocked') {
            throw new Exception($type === 'Sua conta'
                ? 'Você não pode fazer transferência, sua conta está bloqueada!'
                : 'A conta destinatária não pode receber transferência, a conta está bloqueada!');
        }

        return $account;
    }

    private function checkAccountValue ($account, $valueTransfer)
    {
        if ($account->balance < $valueTransfer) {
            throw new Exception('Saldo insuficiente para fazer transferência');
        }

        return true;
    }
}
