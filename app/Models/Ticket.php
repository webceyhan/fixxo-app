<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\TaskStatus;
use App\Enums\TicketStatus;
use App\Models\Traits\HasSince;
use App\Models\Traits\Searchable;
use App\Observers\TicketObserver;
use App\Services\QRService;
use App\Services\SignatureService;
use App\Services\UploadService;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([TicketObserver::class])]
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
        'status' => TicketStatus::New,
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
     * @see TicketStatus::New
     */
    public function scopeNew(Builder $query): void
    {
        $query->where('status', TicketStatus::New);
    }

    /**
     * Scope a query to only include in_progress tickets.
     * 
     * @see TicketStatus::InProgress
     */
    public function scopeInProgress(Builder $query): void
    {
        $query->where('status', TicketStatus::InProgress);
    }

    /**
     * Scope a query to only include on-hold tickets.
     * 
     * @see TicketStatus::OnHold
     */
    public function scopeOnHold(Builder $query): void
    {
        $query->where('status', TicketStatus::OnHold);
    }

    /**
     * Scope a query to only include resolved tickets.
     * 
     * @see TicketStatus::Resolved
     */
    public function scopeResolved(Builder $query): void
    {
        $query->where('status', TicketStatus::Resolved);
    }

    /**
     * Scope a query to only include closed tickets.
     * 
     * @see TicketStatus::Closed
     */
    public function scopeClosed(Builder $query): void
    {
        $query->where('status', TicketStatus::Closed);
    }

    /**
     * Scope a query to only include open tickets
     * which is all tickets except closed ones.
     * 
     * @ignore This is a virtual status.
     */
    public function scopeOpen(Builder $query): void
    {
        $query->whereNot('status', TicketStatus::Closed);
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
     * Set ticket status based on counters.
     */
    public function setStatus(): self
    {
        $this->setTaskCounters();
        $this->setOrderCounters();

        $this->status = TicketStatus::fromModel($this);

        return $this;
    }

    /**
     * Set ticket balance.
     */
    public function setBalance(): self
    {
        $this->balance = $this->paid - $this->cost;

        return $this;
    }

    /**
     * Set ticket's tasks counters.
     */
    public function setTaskCounters(): self
    {
        // NOTE: we can't use $this->tasks->completed()->count() here because it's collection of tasks        
        // but can't use $this->tasks()->completed()->count() which has no caching and very slow
        // so we have to use where() instead on the cached collection to get the count
        // $this->total_tasks_count = $this->tasks()->count();
        // $this->completed_tasks_count = $this->tasks()->completed()->count();

        $this->total_tasks_count = $this->tasks->where('status', '!=', TaskStatus::Cancelled)->count();
        $this->completed_tasks_count = $this->tasks->where('status', TaskStatus::Completed)->count();

        return $this;
    }

    /**
     * Set ticket's orders counters.
     */
    public function setOrderCounters(): self
    {
        // @see setTaskCounters() for more info
        // $this->total_orders_count = $this->orders()->valid()->count();
        // $this->received_orders_count = $this->orders()->received()->count();

        $this->total_orders_count = $this->orders->where('status', '!=', OrderStatus::Cancelled)->count();
        $this->received_orders_count = $this->orders->where('status', OrderStatus::Received)->count();

        return $this;
    }
}
