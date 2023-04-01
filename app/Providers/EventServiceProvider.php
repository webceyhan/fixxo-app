<?php

namespace App\Providers;

use App\Models\Device;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\Task;
use App\Models\Transaction;
use App\Observers\DeviceObserver;
use App\Observers\OrderObserver;
use App\Observers\TicketObserver;
use App\Observers\TaskObserver;
use App\Observers\TransactionObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Device::observe(DeviceObserver::class);
        Ticket::observe(TicketObserver::class);
        Task::observe(TaskObserver::class);
        Order::observe(OrderObserver::class);
        Transaction::observe(TransactionObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
