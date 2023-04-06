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

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status' => TicketStatus::class,
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
     * Get total cost of all valid (non-cancelled) orders.
     */
    protected function ordersCost(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->orders()->valid()->sum('cost')
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

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
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
     * Scope a query to only include new tickets.
     * 
     * @see TicketStatus::NEW
     */
    public function scopeNew(Builder $query): void
    {
        $query->where('status', TicketStatus::NEW);
    }

    /**
     * Scope a query to only include in_progress tickets.
     * 
     * @see TicketStatus::IN_PROGRESS
     */
    public function scopeInProgress(Builder $query): void
    {
        $query->where('status', TicketStatus::IN_PROGRESS);
    }

    /**
     * Scope a query to only include on-hold tickets.
     * 
     * @see TicketStatus::ON_HOLD
     */
    public function scopeOnHold(Builder $query): void
    {
        $query->where('status', TicketStatus::ON_HOLD);
    }

    /**
     * Scope a query to only include resolved tickets.
     * 
     * @see TicketStatus::RESOLVED
     */
    public function scopeResolved(Builder $query): void
    {
        $query->where('status', TicketStatus::RESOLVED);
    }

    /**
     * Scope a query to only include closed tickets.
     * 
     * @see TicketStatus::CLOSED
     */
    public function scopeClosed(Builder $query): void
    {
        $query->where('status', TicketStatus::CLOSED);
    }

    /**
     * Scope a query to only include open tickets
     * which is all tickets except closed ones.
     * 
     * @ignore This is a virtual status.
     */
    public function scopeOpen(Builder $query): void
    {
        $query->whereNot('status', TicketStatus::CLOSED);
    }

    /**
     * Scope a query to only include tickets with outstanding balance.
     * 
     * @ignore This is a virtual status.
     */
    public function scopeOutstanding(Builder $query): Builder
    {
        return $query->where('balance', '<', 0);
    }

    /**
     * Scope a query to only include tickets with overdue balance.
     * This is a combination of closed tickets with outstanding balance.
     * 
     * @ignore This is a virtual status.
     */
    public function scopeOverdue(Builder $query): Builder
    {
        return $query->closed()->outstanding();
    }

    // HELPERS /////////////////////////////////////////////////////////////////////////////////////

    /**
     * Update aggregate fields.
     */
    public function updateAggregateFields(): void
    {
        $this->calculateBalance();
        $this->calculateTaskCounters();
        $this->calculateOrderCounters();

        $this->save();
    }

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
        // NOTE: we can't use $this->tasks->completed()->count() here because it's collection of tasks        
        // but can't use $this->tasks()->completed()->count() which has no caching and very slow
        // so we have to use where() instead on the cached collection to get the count
        // $this->total_tasks_count = $this->tasks()->count();
        // $this->completed_tasks_count = $this->tasks()->completed()->count();

        $this->total_tasks_count = $this->tasks->count();
        $this->completed_tasks_count = $this->tasks->where('completed_at', '!=', null)->count();
    }

    /**
     * Calculate total and received orders counters.
     */
    public function calculateOrderCounters(): void
    {
        // @see calculateTaskCounters() for more info
        // $this->total_orders_count = $this->orders()->valid()->count();
        // $this->received_orders_count = $this->orders()->received()->count();

        $this->total_orders_count = $this->orders->where('status', '!=', OrderStatus::CANCELLED)->count();
        $this->received_orders_count = $this->orders->where('status', OrderStatus::RECEIVED)->count();
    }

    /**
     * Calculate ticket status based on its tasks and orders.
     */
    public function calculateStatus(): void
    {
        $this->calculateTaskCounters();
        $this->calculateOrderCounters();

        $this->status = TicketStatus::fromModel($this);
    }
}
