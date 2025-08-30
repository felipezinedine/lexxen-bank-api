<?php

namespace App\Domain\Transfers\Mappers;

use App\Domain\Transfers\Entities\TransferEntity;
use App\Models\Transfer as TransferModel;

class TransferMapper
{
    public static function toEntity(TransferModel $model): TransferEntity
    {
        return new TransferEntity(
            $model->id,
            $model->from_account_id,
            $model->to_account_id,
            floatval($model->amount),
            $model->status,
        );
    }

    public static function toModel(TransferEntity $entity): TransferModel
    {
        $model = new TransferModel();

        $model->id = $entity->id;
        $model->from_account_id = $entity->fromAccountId;
        $model->to_account_id = $entity->toAccountId;
        $model->amount = $entity->amount;

        return $model;
    }
}
