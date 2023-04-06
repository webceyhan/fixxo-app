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
        $order->ticket->hydrateBalance()->hydrateOrderCounters()->save();
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        if ($order->wasChanged('cost')) {
            $order->ticket->hydrateBalance();
        }

        if ($order->wasChanged('status')) {
            $order->ticket->hydrateOrderCounters();
        }

        $order->ticket->isDirty() && $order->ticket->save();
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        $order->ticket->hydrateBalance()->hydrateOrderCounters()->save();
    }
}
