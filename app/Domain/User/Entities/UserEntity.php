<?php

namespace App\Domain\User\Entities;

class UserEntity
{
    public function __construct(
        public int $id,
        public string $name,
        public string $cpf,
        public string $email,
        public string $status,
    ) {}
}
