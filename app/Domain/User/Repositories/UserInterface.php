<?php

namespace App\Domain\User\Repositories;

use App\Domain\User\Entities\UserEntity;
use App\Models\User as UserModel;

interface UserInterface
{
    public function fetchAllUsers (): array;
    public function findByEmail (string $email): ?UserModel;
    public function store (array $data): ?UserEntity;
    public function fetchUserById (int $userId): ?UserEntity;
    public function update (array $data, int $userId): ?UserEntity;
    public function delete (int $userId);
}
