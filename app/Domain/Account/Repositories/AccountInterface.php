<?php

namespace App\Domain\Account\Repositories;

use App\Domain\Account\Entities\AccountEntity;

interface AccountInterface
{
    public function store (array $data): ?AccountEntity;
    public function getAccountByUserIdAndNumber (int $userId, int $number): ?AccountEntity;
    public function update (array $data, int $userId, int $number): ?AccountEntity;
    public function getAccountById (int $accountId): ?AccountEntity;
}
