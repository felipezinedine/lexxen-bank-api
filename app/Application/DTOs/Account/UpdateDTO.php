<?php

namespace App\Application\DTOs\Account;

class UpdateDTO
{
    public ?float $balance;
    public ?string $status;

    public function __construct(array $data)
    {
        $this->balance = $data['balance'] ?? null;
        $this->status = $data['status'] ?? null;
    }

    public function toArray (): array
    {
        return array_filter([
            'balance' => $this->balance,
            'status' => $this->status,
        ], fn($value) => $value !== null);
    }
}
