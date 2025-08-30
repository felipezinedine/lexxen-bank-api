<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Transfers\Entities\TransferEntity;
use App\Domain\Transfers\Mappers\TransferMapper;
use App\Domain\Transfers\Repositories\TransfersInterface;
use App\Models\Transfer as TransferModel;

class TransfersRepository implements TransfersInterface
{
    public function store (array $data): ?TransferEntity
    {
        $model = TransferModel::create($data);
        return $model ? TransferMapper::toEntity($model) : null;
    }
}
