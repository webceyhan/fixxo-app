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
        $ticket = $transaction->ticket;

        // update ticket's balance
        $ticket->calculateBalance();

        $ticket->save();
    }

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(Transaction $transaction): void
    {
        $ticket = $transaction->ticket;

        // update ticket's balance if transaction amount was changed
        if ($transaction->wasChanged('amount')) {
            $ticket->calculateBalance();
        }

        $ticket->isDirty() && $ticket->save();
    }

    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        $ticket = $transaction->ticket;

        // update ticket's balance
        $ticket->calculateBalance();

        $ticket->save();
    }
}
