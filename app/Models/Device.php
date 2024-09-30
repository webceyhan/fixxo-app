<?php

namespace App\Models;

use App\Enums\DeviceStatus;
use App\Enums\DeviceType;
use App\Enums\TicketStatus;
use App\Models\Concerns\Completable;
use App\Models\Concerns\HasSince;
use App\Models\Concerns\HasWarranty;
use App\Models\Concerns\Searchable;
use App\Observers\DeviceObserver;
use Database\Factories\DeviceFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $customer_id
 * @property string $model
 * @property string|null $brand
 * @property string|null $serial_number
 * @property Carbon|null $purchase_date
 * @property Carbon|null $warranty_expire_date
 * @property DeviceType $type
 * @property DeviceStatus $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property-read Customer $customer
 * @property-read Collection<int, Ticket> $tickets
 * @property-read Collection<int, DeviceLog> $logs
 *
 * @method static DeviceFactory factory(int $count = null, array $state = [])
 * @method static Builder|static ofType(DeviceType $type)
 * @method static Builder|static ofStatus(DeviceStatus $status)
 */
#[ObservedBy([DeviceObserver::class])]
class Device extends Model
{
    use HasFactory, Searchable, HasSince, Completable, HasWarranty;

    /**
     * Searchable attributes.
     *
     * @var array<int, string>
     */
    protected $searchable = [
        'model',
        'brand',
        'serial_number',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id', // TODO: remove later! It must be validated by the controller
        'model',
        'brand',
        'serial_number',
        'purchase_date',
        'warranty_expire_date',
        'type',
        'status',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'type' => DeviceType::Other,
        'status' => DeviceStatus::CheckedIn,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'purchase_date' => 'date',
            'warranty_expire_date' => 'date',
            'type' => DeviceType::class,
            'status' => DeviceStatus::class,
        ];
    }

    // RELATIONS ///////////////////////////////////////////////////////////////////////////////////

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(DeviceLog::class);
    }

    // SCOPES //////////////////////////////////////////////////////////////////////////////////////

    /**
     * Scope a query to only include devices of a given type.
     */
    public function scopeOfType(Builder $query, DeviceType $type): void
    {
        $query->where('type', $type->value);
    }

    /**
     * Scope a query to only include devices of a given status.
     */
    public function scopeOfStatus(Builder $query, DeviceStatus $status): void
    {
        $query->where('status', $status->value);
    }

    // METHODS /////////////////////////////////////////////////////////////////////////////////////

    /**
     * Fill the device's status automatically.
     */
    public function fillStatus(): static
    {
        $this->status = $this->determineStatus();

        return $this;
    }

    /**
     * Determine the device's status based on its ticket counters.
     */
    private function determineStatus(): DeviceStatus
    {
        $tickets = $this->tickets()->select('status')->pluck('status');
        $ticketsCountByStatus = $tickets->countBy(fn ($status) => $status->value);

        // Check if there are any tickets on hold.
        if ($ticketsCountByStatus->has(TicketStatus::OnHold->value)) {
            return DeviceStatus::OnHold;
        }

        // Check if there are tickets in progress.
        if ($ticketsCountByStatus->has(TicketStatus::InProgress->value)) {
            return DeviceStatus::InRepair;
        }

        // Check if there are new tickets.
        if ($ticketsCountByStatus->has(TicketStatus::New->value)) {
            return DeviceStatus::CheckedIn;
        }

        // If there are tickets and none are pending, the device is finished.
        if ($tickets->isNotEmpty()) {
            return DeviceStatus::Finished;
        }

        // Default to the current status if no tickets are found.
        return $this->status;
    }
}
