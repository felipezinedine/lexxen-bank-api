<?php

namespace App\Domain\Transfers\Entities;

class TransferEntity
{
    public function __construct(
        public int $id,
        public int $fromAccountId,
        public int $toAccountId,
        public float $amount,
    ) {}
}
