<?php

namespace App\Domain\Account\Services;

use App\Application\DTOs\Account\CreateDTO;
use App\Application\DTOs\Account\UpdateDTO;
use App\Domain\Account\Repositories\AccountInterface;
use App\Domain\User\Repositories\UserInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AccountService
{
    protected $accountRepository, $userRepository;

    public function __construct(AccountInterface $accountRepository, UserInterface $userRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->userRepository = $userRepository;
    }

    public function store (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $user = $this->userRepository->fetchUserById($request->user_id);

        $dto = new CreateDTO($request->user_id);

        if (!$user) {
            throw new Exception('A conta não pôde ser criada porque o usuário informado não existe');
        }

        return [
            'success' => true,
            'message' => 'Conta criada com sucesso!',
            'account' => $this->accountRepository->store($dto->toArray())
        ];
    }

    public function alterStatus (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'number' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $account = $this->accountRepository->getAccountByUserIdAndNumber($request->user_id, $request->number);

        if (!$account) {
            throw new Exception('Não foi possível localizar a conta com os dados fornecidos.');
        }

        $dto = new UpdateDTO($request->all());

        return [
            'success' => true,
            'message' => 'Informações da conta atualizada com sucesso!',
            'account' => $this->accountRepository->update($dto->toArray(), $request->user_id, $request->number)
        ];

    }
}
