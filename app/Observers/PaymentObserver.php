<?php

namespace App\Observers;

use App\Models\Payment;

class PaymentObserver
{
    /**
     * Handle the Payment "created" event.
     */
    public function created(Payment $payment): void
    {
        $ticket = $payment->ticket;

        // debit ticket's balance
        $ticket->balance += $payment->amount;

        $ticket->save();
    }

    /**
     * Handle the Payment "updated" event.
     */
    public function updated(Payment $payment): void
    {
        $ticket = $payment->ticket;

        // update ticket's balance if payment amount was changed
        if ($payment->wasChanged('amount')) {
            $ticket->balance -= $payment->getOriginal('amount'); // credit previous
            $ticket->balance += $payment->amount; // debit new payment amount
        }

        $ticket->isDirty() && $ticket->save();
    }

    /**
     * Handle the Payment "deleted" event.
     */
    public function deleted(Payment $payment): void
    {
        $ticket = $payment->ticket;

        // credit ticket's balance
        $ticket->balance -= $payment->amount;

        $ticket->save();
    }

    /**
     * Handle the Payment "restored" event.
     */
    public function restored(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "force deleted" event.
     */
    public function forceDeleted(Payment $payment): void
    {
        //
    }
}
