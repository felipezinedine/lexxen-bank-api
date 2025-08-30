<?php

namespace App\Domain\Transfers\Repositories;

use App\Domain\Transfers\Entities\TransferEntity;

interface TransfersInterface
{
    public function store (array $data): ?TransferEntity;
}
