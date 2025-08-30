<?php

namespace App\Application\DTOs\User;

use App\Infrastructure\ValueObjects\Cpf;

class UpdateDTO
{
    public string|null $name;
    public string|null $email;
    public string|null $password;
    public Cpf|null $cpf;
    public string|null $status;

    public function __construct (array $data)
    {
        $this->name = $data['name'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->cpf = isset($data['cpf']) ? new Cpf($data['cpf']) : null;
        $this->status = $data['status'] ?? null;
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'email' => $this->email,
            'cpf' => $this->cpf ? (string) $this->cpf : null,
            'status' => $this->status,
        ], fn($value) => $value !== null);
    }
}
