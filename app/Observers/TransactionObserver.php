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

        // debit ticket's balance
        $ticket->balance += $transaction->amount;

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
            $ticket->balance -= $transaction->getOriginal('amount'); // credit previous
            $ticket->balance += $transaction->amount; // debit new transaction amount
        }

        $ticket->isDirty() && $ticket->save();
    }

    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        $ticket = $transaction->ticket;

        // credit ticket's balance
        $ticket->balance -= $transaction->amount;

        $ticket->save();
    }

    /**
     * Handle the Transaction "restored" event.
     */
    public function restored(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "force deleted" event.
     */
    public function forceDeleted(Transaction $transaction): void
    {
        //
    }
}
