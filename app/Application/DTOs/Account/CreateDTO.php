<?php

namespace App\Application\DTOs\Account;

use App\Infrastructure\Helpers\NumberAccount;
use Illuminate\Support\Str;

class CreateDTO
{
    public int $userId;
    public int $number;
    public float $balance;
    public string $status;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
        $this->number = NumberAccount::generate();
        $this->balance = 0.00;
        $this->status = 'active';
    }

    public function toArray (): array
    {
        return [
            'user_id' => $this->userId,
            'number' => $this->number,
            'balance' => $this->balance,
            'status' => $this->status,
        ];
    }
}
