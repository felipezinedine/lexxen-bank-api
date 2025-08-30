<?php

namespace App\Domain\Account\Entities;

class AccountEntity
{
    public function __construct (
        public int $id,
        public int $userId,
        public string $number,
        public string $status,
        public float $balance,
    ) {}
}
