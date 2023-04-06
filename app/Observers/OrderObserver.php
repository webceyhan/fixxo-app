<?php

namespace App\Observers;

use App\Models\Order;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        $order->ticket->updateAggregateFields();
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        // update ticket's aggregate fields if applicable
        if ($order->wasChanged(['cost', 'status'])) {
            $order->ticket->updateAggregateFields();
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        $order->ticket->updateAggregateFields();
    }
}
