<?php

namespace App\Domain\Auth\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Application\DTOs\User\CreateDTO;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Exceptions\AccountNotApprovedException;
use App\Domain\User\Repositories\UserInterface;

class AuthService
{
    protected $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $user = $this->userRepository->findByEmail($request->email);

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['As credenciais estão incorretas.'],
            ]);
        }

        if ($user->status !== 'approved') {
            if ($user->status === 'waiting') {
                throw new AccountNotApprovedException('Sua conta ainda não foi aprovada.');
            } else if ($user->status === 'failed') {
                throw new AccountNotApprovedException('Sua conta não foi aprovada. Por favor entre em contato com o suporte: admin@lexxen.com.br');
            }
        }

        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function register (Request $request)
    {
        $data = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'cpf'      => 'required|unique:users,cpf',
            'password' => 'required|string|min:5|confirmed',
        ]);

        if ($data->fails()) {
            throw new ValidationException($data);
        }

        $dto = new CreateDTO($request->name, $request->email, $request->password, $request->cpf);

        $user = $this->userRepository->store($dto->toArray());

        return [
            'user' => $user,
            'message' => 'Aguarda a aprovação da sua conta!',
        ];
    }
}
