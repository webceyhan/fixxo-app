<?php

namespace App\Models;

use App\Enums\Priority;
use App\Enums\TicketStatus;
use App\Models\Concerns\Assignable;
use App\Models\Concerns\Completable;
use App\Models\Concerns\HasDueDate;
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
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int|null $assignee_id
 * @property int $customer_id
 * @property int $device_id
 * @property string $description
 * @property Priority $priority
 * @property TicketStatus $status
 * @property Carbon $due_date
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property-read float $balance
 * @property-read int $total_tasks_count
 * @property-read int $completed_tasks_count
 * @property-read int $total_orders_count
 * @property-read int $completed_orders_count
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
 * @property-read Invoice $invoice
 * 
 * @method static TicketFactory factory(int $count = null, array $state = [])
 * @method static Builder|static ofStatus(TicketStatus $status)
 * @method static Builder|static outstanding()
 */
#[ObservedBy([TicketObserver::class])]
class Ticket extends Model
{
    use HasFactory, Assignable, Searchable, HasSince, Completable, HasPriority, HasDueDate;

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
        'due_date',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
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
            'status' => TicketStatus::class,
            'balance' => 'float',
        ];
    }

    // ACCESSORS ///////////////////////////////////////////////////////////////////////////////////

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

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
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
        // force re-calculation of the invoice balance
        $this->invoice->fillBalance()->save();

        $this->balance = $this->invoice->balance;

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

    protected function overdueCondition(): bool
    {
        return !$this->isCompleted();
    }

    protected function overdueConditionQuery(Builder $query): void
    {
        $query->pending();
    }
}
