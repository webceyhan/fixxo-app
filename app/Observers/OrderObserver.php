<?php

namespace App\Observers;

use App\Enums\OrderStatus;
use App\Models\Order;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        $ticket = $order->ticket;

        // update ticket's balance
        $ticket->calculateBalance();

        // update ticket's order counters accordingly
        $ticket->calculateOrderCounters();

        $ticket->save();
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        $ticket = $order->ticket;

        // update ticket's balance if applicable
        if ($order->wasChanged('cost')) {
            $ticket->calculateBalance();
        }

        // update ticket's order counters if applicable
        if ($order->wasChanged('status')) {
            $ticket->calculateOrderCounters();
            $ticket->calculateBalance(); // in case if order was cancelled
        }

        $ticket->isDirty() && $ticket->save();
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        $ticket = $order->ticket;

        // update ticket's balance
        $ticket->calculateBalance();

        // update ticket's order counters accordingly
        $ticket->calculateOrderCounters();

        $ticket->save();
    }


}
