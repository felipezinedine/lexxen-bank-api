<?php

namespace App\Application\DTOs\Transfers;

class CreateDTO
{
    public int $fromAccountId;
    public int $toAccountId;
    public float $amount;

    public function __construct (int $fromAccountId, int $toAccountId, float $amount)
    {
        $this->fromAccountId = $fromAccountId;
        $this->toAccountId = $toAccountId;
        $this->amount = floatval($amount);
    }

    public function toArray (): array
    {
        return [
            'from_account_id' => $this->fromAccountId,
            'to_account_id' => $this->toAccountId,
            'amount' => $this->amount,
        ];
    }
}
