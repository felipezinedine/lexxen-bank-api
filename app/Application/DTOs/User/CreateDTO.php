<?php

namespace App\Application\DTOs\User;

use App\Infrastructure\ValueObjects\Cpf;
use Illuminate\Support\Facades\Hash;

class CreateDTO
{
    public string $name;
    public string $email;
    public string $password;
    public Cpf $cpf;

    public function __construct (string $name, string $email, int|string $password, string $cpf)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = Hash::make($password);
        $this->cpf = new Cpf($cpf);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'cpf' => (string) $this->cpf,
            'status' => 'waiting',
        ];
    }
}
