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
 * @property-read float $tasks_cost
 * @property-read float $orders_cost
 * @property-read float $total_cost
 * @property-read float $total_paid
 * @property-read string $qr_url
 * @property-read string $intake_signature_url
 * @property-read string $delivery_signature_url
 * @property-read array<string> $uploaded_urls
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
            'balance' => 'float',
        ];
    }

    // ACCESSORS ///////////////////////////////////////////////////////////////////////////////////

    /**
     * Get total cost of all non-cancelled tasks.
     */
    protected function tasksCost(): Attribute
    {
        return Attribute::get(
            fn () => $this->tasks()->notCancelled()->sum('cost')
        )->shouldCache();
    }

    /**
     * Get total cost of all non-cancelled orders.
     */
    protected function ordersCost(): Attribute
    {
        return Attribute::get(
            fn () => $this->orders()->notCancelled()->sum('cost')
        )->shouldCache();
    }

    /**
     * Get total cost of all tasks and orders.
     */
    protected function totalCost(): Attribute
    {
        return Attribute::get(fn () => $this->tasks_cost + $this->orders_cost);
    }

    /**
     * Get total amount of all transactions.
     */
    protected function totalPaid(): Attribute
    {
        return Attribute::get(
            fn () => $this->transactions()->sum('amount')
        )->shouldCache();
    }

    /**
     * Get URL to qr code or generate if not exists.
     *
     * @return bool
     */
    protected function qrUrl(): Attribute
    {
        return Attribute::get(function () {
            $linkData = route('tickets.show', $this);
            return QRService::urlFor($this->id, $linkData);
        });
    }

    /**
     * Get url to the intake signature.
     */
    protected function intakeSignatureUrl(): Attribute
    {
        return Attribute::get(function () {
            return SignatureService::url($this->id . '-intake');
        });
    }

    /**
     * Get url to the delivery signature.
     */
    protected function deliverySignatureUrl(): Attribute
    {
        return Attribute::get(function () {
            return SignatureService::url($this->id . '-delivery');
        });
    }

    /**
     * Get an array URL's to uploaded files.
     */
    protected function uploadedUrls(): Attribute
    {
        return Attribute::get(function () {
            return UploadService::urls('tickets/' . $this->id);
        });
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
     * Fill the ticket's status automatically.
     */
    public function fillStatus(): self
    {
        $this->status = $this->determineStatus();

        return $this;
    }

    /**
     * Fill the ticket's balance automatically.
     */
    public function fillBalance(): self
    {
        $this->balance = $this->total_cost - $this->total_paid;

        return $this;
    }

    /**
     * Set ticket's task counters.
     */
    public function fillTaskCounters(): self
    {
        $this->total_tasks_count = $this->tasks()->count();
        $this->completed_tasks_count = $this->tasks()->completed()->count();

        return $this;
    }

    /**
     * Set ticket's order counters.
     */
    public function fillOrderCounters(): self
    {
        $this->total_orders_count = $this->orders()->count();
        $this->completed_orders_count = $this->orders()->completed()->count();

        return $this;
    }

    /**
     * Determine the status of the ticket based on its task and order counters.
     */
    private function determineStatus(): TicketStatus
    {
        $pendingTasksCount = $this->total_tasks_count - $this->completed_tasks_count;
        $pendingOrdersCount = $this->total_orders_count - $this->completed_orders_count;

        // Check if there are any pending orders.
        if ($pendingOrdersCount > 0) {
            return TicketStatus::OnHold;
        }

        // Check if there are any pending tasks.
        if ($pendingTasksCount > 0) {
            return TicketStatus::InProgress;
        }

        // Check if there are any tasks.
        if ($this->total_tasks_count > 0) {
            return TicketStatus::Resolved;
        }

        // Default to the current status if no specific conditions are met.
        return $this->status;
    }
}
