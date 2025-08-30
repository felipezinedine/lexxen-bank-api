<?php


namespace App\Domain\User\Services;

use App\Application\DTOs\User\CreateDTO;
use App\Application\DTOs\User\UpdateDTO;
use App\Domain\User\Repositories\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserService
{
    protected UserInterface $repositoryUser;

    public function __construct(UserInterface $repositoryUser)
    {
        $this->repositoryUser = $repositoryUser;
    }

    public function fetchAllUsers ()
    {
        return [
            'success' => true,
            'users' => $this->repositoryUser->fetchAllUsers(),
        ];
    }

    public function findByEmail (string $email)
    {
        return $this->repositoryUser->findByEmail($email);
    }

    public function store (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required',
            'cpf' => 'required'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $dto = new CreateDTO($request->name, $request->email, $request->password, $request->cpf);

        return [
            'success' => true,
            'message' => 'Usuário criado com sucesso!',
            'user' => $this->repositoryUser->store($dto->toArray()),
        ];
    }

    public function fetchUserById (int $userId)
    {
        $user = $this->repositoryUser->fetchUserById ($userId);

        if (!$user) {
            throw new \Exception("Usuário não encontrado");
        }

        return [
            'success' => true,
            'user' => $this->repositoryUser->fetchUserById ($userId)
        ];
    }

    public function update (UpdateDTO $dto, int $userId)
    {
        $user = $this->repositoryUser->fetchUserById ($userId);

        if (!$user) {
            throw new \Exception("Usuário não encontrado");
        }

        return [
            'success' => true,
            'message' => 'Informações atualizadas com sucesso!',
            'user' => $this->repositoryUser->update($dto->toArray(), $userId)
        ];
    }

    public function delete (int $userId)
    {
        $user = $this->repositoryUser->fetchUserById ($userId);

        if (!$user) {
            throw new \Exception("Usuário não encontrado");
        }

        return [
            'success' => true,
            'message' => 'Usuário deletado com sucesso!'
        ];
    }
}
