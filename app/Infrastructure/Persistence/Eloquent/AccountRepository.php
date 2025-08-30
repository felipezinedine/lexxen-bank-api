<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Account\Entities\AccountEntity;
use App\Domain\Account\Mappers\AccountMapper;
use App\Domain\Account\Repositories\AccountInterface;
use App\Models\Account as AccountModel;

class AccountRepository implements AccountInterface
{
    public function store(array $data): ?AccountEntity
    {
        $model = AccountModel::create($data);
        return $model ? AccountMapper::toEntity($model) : null;
    }

    public function getAccountByUserIdAndNumber (int $userId, int $number): ?AccountEntity
    {
        $model = AccountModel::where('user_id', '=', $userId)->where('number', '=', $number)->first();
        return $model ? AccountMapper::toEntity($model) : null;
    }

    public function update (array $data, int $userId, int $number): ?AccountEntity
    {
        $model = AccountModel::where('user_id', '=', $userId)->where('number', '=', $number)->first();
        return $model
            ? AccountMapper::toEntity(tap($model)->update($data) ? $model : $model)
            : null;
    }

    public function getAccountById (int $accountId): ?AccountEntity
    {
        $model = AccountModel::where('id', '=', $accountId)->first();
        return $model ? AccountMapper::toEntity($model) : null;
    }
}
