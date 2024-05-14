<?php

namespace App\Models;

use App\Enums\DeviceStatus;
use App\Enums\TicketStatus;
use App\Enums\WarrantyStatus;
use App\Models\Traits\HasSince;
use App\Models\Traits\Searchable;
use App\Observers\DeviceObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([DeviceObserver::class])]
class Device extends Model
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
        'brand' => null,
        'type' => null,
        'serial' => null,
        'purchase_date' => null,
        'warranty_expire_date' => null,
        'status' => DeviceStatus::CHECKED_IN,
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'warranty_status',
    ];

    /**
     * Searchable attributes.
     *
     * @var array<int, string>
     */
    protected $searchable = [
        'name',
        'brand',
        'type',
        'serial',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'purchase_date' => 'date',
        'warranty_expire_date' => 'date',
        'status' => DeviceStatus::class,
    ];

    // ACCESSORS ///////////////////////////////////////////////////////////////////////////////////

    /**
     * Get count of all pending tickets.
     */
    protected function pendingTicketsCount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->total_tickets_count - $this->closed_tickets_count,
        );
    }

    /**
     * Get warranty status.
     */
    protected function warrantyStatus(): Attribute
    {
        return Attribute::make(
            get: fn () => WarrantyStatus::fromModel($this),
        );
    }

    // RELATIONS ///////////////////////////////////////////////////////////////////////////////////

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(DeviceLog::class);
    }

    // LOCAL SCOPES ////////////////////////////////////////////////////////////////////////////////

    /**
     * Scope a query to only include checked-in devices.
     * 
     * @see DeviceStatus::CHECKED_IN
     */
    public function scopeCheckedIn(Builder $query): void
    {
        $query->where('status', DeviceStatus::CHECKED_IN);
    }

    /**
     * Scope a query to only include in-repair devices.
     * 
     * @see DeviceStatus::IN_REPAIR
     */
    public function scopeInRepair(Builder $query): void
    {
        $query->where('status', DeviceStatus::IN_REPAIR);
    }

    /**
     * Scope a query to only include on-hold devices.
     * 
     * @see DeviceStatus::ON_HOLD
     */
    public function scopeOnHold(Builder $query): void
    {
        $query->where('status', DeviceStatus::ON_HOLD);
    }

    /**
     * Scope a query to only include fixed devices.
     * 
     * @see DeviceStatus::FIXED
     */
    public function scopeFixed(Builder $query): void
    {
        $query->where('status', DeviceStatus::FIXED);
    }

    /**
     * Scope a query to only include defect devices.
     * 
     * @see DeviceStatus::DEFECT
     */
    public function scopeDefect(Builder $query): void
    {
        $query->where('status', DeviceStatus::DEFECT);
    }

    /**
     * Scope a query to only include checked-out devices.
     * 
     * @see DeviceStatus::CHECKED_OUT
     */
    public function scopeCheckedOut(Builder $query): void
    {
        $query->where('status', DeviceStatus::CHECKED_OUT);
    }

    /**
     * Scope a query to only include pending devices.
     * Which is all devices except checked-out ones.
     * 
     * @see DeviceStatus
     * @ignore This is a virtual status.
     */
    public function scopePending(Builder $query): void
    {
        $query->where('status', '!=', DeviceStatus::CHECKED_OUT);
    }

    /**
     * Scope a query to only include devices with valid warranty date.
     * 
     * @see WarrantyStatus::VALID
     * @ignore This is a virtual status.
     */
    public function scopeWithWarranty(Builder $query): void
    {
        $query->where('warranty_expire_date', '>=', now());
    }

    /**
     * Scope a query to only include devices with expired warranty date.
     * 
     * @see WarrantyStatus::EXPIRED
     * @ignore This is a virtual status.
     */
    public function scopeWithoutWarranty(Builder $query): void
    {
        $query->where('warranty_expire_date', '<', now());
    }

    // HELPERS /////////////////////////////////////////////////////////////////////////////////////

    /**
     * Set device's status.
     */
    public function setStatus(): self
    {
        $this->setTicketCounters();

        $this->status = DeviceStatus::fromModel($this);

        return $this;
    }

    /**
     * Set device's ticket counters.
     */
    public function setTicketCounters(): self
    {
        $this->total_tickets_count = $this->tickets->count();
        // @see Ticket::setTaskCounters() for more info
        // $this->inprogress_tickets_count = $this->tickets()->inProgress()->count();
        // $this->onhold_tickets_count = $this->tickets()->onHold()->count();
        // $this->resolved_tickets_count = $this->tickets()->resolved()->count();
        // $this->closed_tickets_count = $this->tickets()->closed()->count();

        $this->inprogress_tickets_count = $this->tickets->where('status', TicketStatus::IN_PROGRESS)->count();
        $this->onhold_tickets_count = $this->tickets->where('status', TicketStatus::ON_HOLD)->count();
        $this->resolved_tickets_count = $this->tickets->where('status', TicketStatus::RESOLVED)->count();
        $this->closed_tickets_count = $this->tickets->where('status', TicketStatus::CLOSED)->count();

        return $this;
    }
}
