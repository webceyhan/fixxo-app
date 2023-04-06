<?php

namespace App\Observers;

use App\Models\Transaction;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     */
    public function created(Transaction $transaction): void
    {
        $transaction->ticket->updateAggregateFields();
    }

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(Transaction $transaction): void
    {
        // update ticket's aggregate fields if applicable
        if ($transaction->wasChanged('amount')) {
            $transaction->ticket->updateAggregateFields();
        }
    }

    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        $transaction->ticket->updateAggregateFields();
    }
}
