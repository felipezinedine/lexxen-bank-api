<?php

namespace App\Observers;

use App\Models\Transfer;

class TransferObserver
{
    /**
     * Handle the Transfer "created" event.
     */
    public function created(Transfer $transfer): void
    {
        \App\Models\Statement::create([
            'account_id' => $transfer->from_account_id,
            'value'      => $transfer->amount,
            'description'=> "Transferência para conta {$transfer->to_account_id}",
            'balance'    => $transfer->fromAccount->balance,
        ]);

        \App\Models\Statement::create([
            'account_id' => $transfer->to_account_id,
            'value'      => $transfer->amount,
            'description'=> "Recebido da conta {$transfer->from_account_id}",
            'balance'    => $transfer->toAccount->balance,
        ]);
    }
}
