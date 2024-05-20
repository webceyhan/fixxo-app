<?php

namespace App\Models;

use App\Enums\Priority;
use App\Enums\TicketStatus;
use App\Models\Concerns\Completable;
use App\Models\Concerns\HasPriority;
use App\Models\Concerns\HasSince;
use App\Models\Concerns\Searchable;
use App\Observers\TicketObserver;
use App\Services\QRService;
use App\Services\SignatureService;
use App\Services\UploadService;
use Database\Factories\TicketFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int|null $assignee_id
 * @property int $customer_id
 * @property int $device_id
 * @property string $description
 * @property Priority $priority
 * @property TicketStatus $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property-read float $balance
 * @property-read int $total_tasks_count
 * @property-read int $completed_tasks_count
 * @property-read int $total_orders_count
 * @property-read int $completed_orders_count
 * 
 * @property-read User|null $assignee
 * @property-read Customer $customer
 * @property-read Device $device
 * @property-read Collection<int, Task> $tasks
 * @property-read Collection<int, Order> $orders
 * @property-read Collection<int, Transaction> $transactions
 * 
 * @method static TicketFactory factory(int $count = null, array $state = [])
 * @method static Builder|static ofStatus(TicketStatus $status)
 * @method static Builder|static outstanding()
 * @method static Builder|static overdue()
 */
#[ObservedBy([TicketObserver::class])]
class Ticket extends Model
{
    use HasFactory, Searchable, HasSince, Completable, HasPriority;

    /**
     * Searchable attributes.
     *
     * @var array<int, string>
     */
    protected $searchable = [
        'description',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'assignee_id', // TODO: remove later! It must be validated by the controller
        'customer_id', // TODO: remove later! It must be validated by the controller
        'device_id', // TODO: remove later! It must be validated by the controller
        'description',
        'priority',
        'status',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'priority' => Priority::Normal,
        'status' => TicketStatus::New,
        'balance' => 0,
        'total_tasks_count' => 0,
        'completed_tasks_count' => 0,
        'total_orders_count' => 0,
        'completed_orders_count' => 0,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'priority' => Priority::class,
            'status' => TicketStatus::class,
        ];
    }

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
            get: fn () => $this->orders()->notCancelled()->sum('cost')
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

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class)->latest();
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class)->latest();
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class)->latest();
    }

    // SCOPES //////////////////////////////////////////////////////////////////////////////////////

    /**
     * Scope a query to only include tickets of a given status.
     */
    public function scopeOfStatus(Builder $query, TicketStatus $status): void
    {
        $query->where('status', $status->value);
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
        return $query->ofStatus(TicketStatus::Closed)->outstanding();
    }

    // METHODS /////////////////////////////////////////////////////////////////////////////////////

    /**
     * Set ticket status based on counters.
     */
    public function setStatus(): self
    {
        $this->setTaskCounters();
        $this->setOrderCounters();

        $this->status = $this->determineStatus();

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
        $this->total_tasks_count = $this->tasks()->count();
        $this->completed_tasks_count = $this->tasks()->completed()->count();

        return $this;
    }

    /**
     * Set ticket's orders counters.
     */
    public function setOrderCounters(): self
    {
        $this->total_orders_count = $this->orders()->count();
        $this->completed_orders_count = $this->orders()->completed()->count();

        return $this;
    }

    /**
     * Determine the status of the ticket based on the current status and counters.
     */
    private function determineStatus(): TicketStatus
    {
        // get the task related counters
        $totalTasksCount = $this->total_tasks_count;
        $completedTasksCount = $this->completed_tasks_count;
        $totalOrdersCount = $this->total_orders_count;
        $completedOrdersCount = $this->completed_orders_count;

        // get the boolean flags
        $hasTasks = $totalTasksCount > 0;
        $hasPendingTasks = $totalTasksCount - $completedTasksCount > 0;
        $hasPendingOrders = $totalOrdersCount - $completedOrdersCount > 0;

        switch ($this->status) {
            case TicketStatus::New:
            case TicketStatus::OnHold:
                // if the ticket has pending tasks, it is still in progress and needs further action
                if ($hasPendingTasks && !$hasPendingOrders) {
                    return TicketStatus::InProgress;
                }
                // if the ticket has no pending tasks but still has tasks, it means that all tasks
                // are completed, so the ticket is now resolved and no further action is needed
                if ($hasTasks && !$hasPendingTasks && !$hasPendingOrders) {
                    return TicketStatus::Resolved;
                }
                break;

            case TicketStatus::InProgress:
                // if the ticket has no tasks, it means that there is nothing left 
                // to do for now, so the ticket is put on hold
                if (!$hasTasks || $hasPendingOrders) {
                    return TicketStatus::OnHold;
                }
                // if the ticket has tasks but no pending tasks, it means that all tasks are completed, 
                // so the ticket is now resolved and no further action is needed
                if ($hasTasks && !$hasPendingTasks && !$hasPendingOrders) {
                    return TicketStatus::Resolved;
                }
                break;

            case TicketStatus::Resolved:
            case TicketStatus::Closed:
                // if the ticket has no tasks, it means that there is nothing left 
                // to do for now, so the ticket is put on hold
                if (!$hasTasks || $hasPendingOrders) {
                    return TicketStatus::OnHold;
                }
                // if the ticket has pending tasks, it means that there are still tasks left to do, 
                // so the ticket is still in progress and needs further action
                if ($hasPendingTasks && !$hasPendingOrders) {
                    return TicketStatus::InProgress;
                }
                break;
        }

        return $this->status;
    }
}
