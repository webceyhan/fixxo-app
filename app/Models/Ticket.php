<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\TicketStatus;
use App\Models\Traits\HasSince;
use App\Models\Traits\Searchable;
use App\Services\QRService;
use App\Services\SignatureService;
use App\Services\UploadService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Ticket extends Model
{
    use HasFactory, Searchable, HasSince;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'note' => null,
        'status' => TicketStatus::NEW,
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * Searchable attributes.
     *
     * @var array<int, string>
     */
    protected $searchable = [
        'description',
    ];

    // ACCESSORS ///////////////////////////////////////////////////////////////////////////////////

    /**
     * Get total cost of all tasks.
     */
    protected function tasksCost(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->tasks->sum('cost')
        )->shouldCache();
    }

    /**
     * Get total cost of all orders (excluding cancelled orders).
     */
    protected function ordersCost(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->orders->sum('cost')
                - $this->orders->where('status', OrderStatus::CANCELLED)->sum('cost'),
        )->shouldCache();
    }

    /**
     * Get total cost of all tasks and orders.
     */
    protected function cost(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->tasks_cost + $this->orders_cost,
        )->shouldCache();
    }

    /**
     * Get total amount of all transactions.
     */
    protected function paid(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->transactions->sum('amount'),
        )->shouldCache();
    }

    /**
     * Get count of all pending (not-completed) tasks.
     */
    protected function pendingTasksCount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->total_tasks_count - $this->completed_tasks_count,
        );
    }

    /**
     * Get count of all pending (not-received) orders.
     */
    protected function pendingOrdersCount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->total_orders_count - $this->received_orders_count
        );
    }

    /**
     * Get URL to qr code or generate if not exists.
     *
     * @return bool
     */
    protected function qrUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                $linkData = route('tickets.show', $this);
                return QRService::urlFor($this->id, $linkData);
            }
        );
    }

    /**
     * Get url to the intake signature.
     */
    protected function intakeSignatureUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => SignatureService::url($this->id . '-intake'),
            // TODO: find a way to make this work!
            // Attribute::make() doesn't support setting value that doesn't exist in the model
            // set: fn ($value) => SignatureService::put($this->id . '-intake', $value),
        );
    }

    /**
     * Get url to the delivery signature.
     */
    protected function deliverySignatureUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => SignatureService::url($this->id . '-delivery'),
            // TODO: see above!
            // set: fn ($value) => SignatureService::put($this->id . '-delivery', $value),
        );
    }

    /**
     * Get an array URL's to uploaded files.
     */
    protected function uploadedUrls(): Attribute
    {
        return Attribute::make(
            get: fn () => UploadService::urls('tickets/' . $this->id)
        );
    }

    // RELATIONS ///////////////////////////////////////////////////////////////////////////////////

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function device(): belongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function customer(): HasOneThrough
    {
        return $this->hasOneThrough(
            Customer::class,
            Device::class,
            'id', // Foreign key on the devices table...
            'id', // Foreign key on the customers table...
            'device_id', // Local key on the tickets table...
            'customer_id' // Local key on the devices table...
        );
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class)->latest();
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class)->latest();
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class)->latest();
    }

    // LOCAL SCOPES ////////////////////////////////////////////////////////////////////////////////

    /**
     * Scope a query to only include new Tickets.
     */
    public function scopeNew(Builder $query): void
    {
        $query->where('status', TicketStatus::NEW);
    }

    /**
     * Scope a query to only include in_progress Tickets.
     */
    public function scopeInProgress(Builder $query): void
    {
        $query->where('status', TicketStatus::IN_PROGRESS);
    }

    /**
     * Scope a query to only include on-hold Tickets.
     */
    public function scopeOnHold(Builder $query): void
    {
        $query->where('status', TicketStatus::ON_HOLD);
    }

    /**
     * Scope a query to only include resolved Tickets.
     */
    public function scopeResolved(Builder $query): void
    {
        $query->where('status', TicketStatus::RESOLVED);
    }

    /**
     * Scope a query to only include closed Tickets.
     */
    public function scopeClosed(Builder $query): void
    {
        $query->where('status', TicketStatus::CLOSED);
    }

    /**
     * Scope a query to only include tickets with outstanding balance.
     */
    public function scopeOutstanding(Builder $query): Builder
    {
        return $query->where('balance', '<', 0);
    }

    /**
     * Scope a query to only include overdue tickets.
     */
    public function scopeOverdue(Builder $query): Builder
    {
        return $query->outstanding()->closed();
    }

    /**
     * Scope a query to get statistics grouped by status.
     */
    public function scopeStats(Builder $query): void
    {
        $query->selectRaw('COUNT(id) as value, status as label')
            ->whereNot('status', TicketStatus::CLOSED)
            ->groupBy('status');
    }


    // HELPERS /////////////////////////////////////////////////////////////////////////////////////

    /**
     * Calculate ticket's balance based on the sum of tasks and transactions.
     */
    public function calculateBalance(): void
    {
        $this->balance = $this->paid - $this->cost;
    }

    /**
     * Calculate total and completed tasks counters.
     */
    public function calculateTaskCounters(): void
    {
        $tasks = $this->tasks;

        $this->total_tasks_count = $tasks->count();
        $this->completed_tasks_count = $tasks->whereNotNull('completed_at')->count();
    }

    /**
     * Calculate total and received orders counters.
     */
    public function calculateOrderCounters(): void
    {
        $orders = $this->orders;

        // we should deduct cancelled orders from the total count
        $cancelled_orders_count = $orders->where('status', OrderStatus::CANCELLED)->count();

        $this->received_orders_count = $orders->where('status', OrderStatus::RECEIVED)->count();
        $this->total_orders_count = $orders->count() - $cancelled_orders_count;
    }

    /**
     * Calculate ticket status based on its tasks.
     */
    public function calculateStatus(): void
    {
        $this->calculateTaskCounters();
        $this->calculateOrderCounters();

        // get the task related counters
        $totalTasksCount = $this->total_tasks_count;
        $completedTasksCount = $this->completed_tasks_count;
        $pendingTasksCount = $totalTasksCount - $completedTasksCount;

        // get the boolean flags
        $hasTasks = $totalTasksCount > 0;
        $hasPendingTasks = $pendingTasksCount > 0;
        $hasPendingOrders = $this->pending_orders_count > 0;

        switch ($this->status) {
            case TicketStatus::NEW:
            case TicketStatus::ON_HOLD:
                // if the ticket has pending tasks, it is still in progress and needs further action
                if ($hasPendingTasks && !$hasPendingOrders) {
                    $this->status = TicketStatus::IN_PROGRESS;
                }
                // if the ticket has no pending tasks but still has tasks, it means that all tasks
                // are completed, so the ticket is now resolved and no further action is needed
                if ($hasTasks && !$hasPendingTasks && !$hasPendingOrders) {
                    $this->status = TicketStatus::RESOLVED;
                }
                break;

            case TicketStatus::IN_PROGRESS:
                // if the ticket has no tasks, it means that there is nothing left 
                // to do for now, so the ticket is put on hold
                if (!$hasTasks || $hasPendingOrders) {
                    $this->status = TicketStatus::ON_HOLD;
                }
                // if the ticket has tasks but no pending tasks, it means that all tasks are completed, 
                // so the ticket is now resolved and no further action is needed
                if ($hasTasks && !$hasPendingTasks && !$hasPendingOrders) {
                    $this->status = TicketStatus::RESOLVED;
                }
                break;

            case TicketStatus::RESOLVED:
            case TicketStatus::CLOSED:
                // if the ticket has no tasks, it means that there is nothing left 
                // to do for now, so the ticket is put on hold
                if (!$hasTasks || $hasPendingOrders) {
                    $this->status = TicketStatus::ON_HOLD;
                }
                // if the ticket has pending tasks, it means that there are still tasks left to do, 
                // so the ticket is still in progress and needs further action
                if ($hasPendingTasks && !$hasPendingOrders) {
                    $this->status = TicketStatus::IN_PROGRESS;
                }
                break;
        }
    }
}
