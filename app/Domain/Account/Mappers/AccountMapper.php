<?php

namespace App\Domain\Account\Mappers;

use App\Domain\Account\Entities\AccountEntity;
use App\Models\Account as AccountModel;

class AccountMapper
{
    public static function toEntity (AccountModel $model): AccountEntity
    {
        return new AccountEntity(
            $model->id,
            $model->user_id,
            $model->number,
            $model->status,
            $model->balance,
        );
    }

    public static function toModel (AccountEntity $entity): AccountModel
    {
        $model = new AccountModel();

        $model->id = $entity->id;
        $model->user_id = $entity->userId;
        $model->number = $entity->number;
        $model->status = $entity->status;
        $model->balance = $entity->balance;

        return $model;
    }
}
