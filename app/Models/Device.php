<?php

namespace App\Models;

use App\Enums\DeviceStatus;
use App\Enums\TicketStatus;
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
        'status' => DeviceStatus::CheckedIn,
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
     * @see DeviceStatus::CheckedIn
     */
    public function scopeCheckedIn(Builder $query): void
    {
        $query->where('status', DeviceStatus::CheckedIn);
    }

    /**
     * Scope a query to only include in-repair devices.
     * 
     * @see DeviceStatus::InRepair
     */
    public function scopeInRepair(Builder $query): void
    {
        $query->where('status', DeviceStatus::InRepair);
    }

    /**
     * Scope a query to only include on-hold devices.
     * 
     * @see DeviceStatus::OnHold
     */
    public function scopeOnHold(Builder $query): void
    {
        $query->where('status', DeviceStatus::OnHold);
    }

    /**
     * Scope a query to only include finished devices.
     * 
     * @see DeviceStatus::Finished
     */
    public function scopeFixed(Builder $query): void
    {
        $query->where('status', DeviceStatus::Finished);
    }

    /**
     * Scope a query to only include checked-out devices.
     * 
     * @see DeviceStatus::CheckedOut
     */
    public function scopeCheckedOut(Builder $query): void
    {
        $query->where('status', DeviceStatus::CheckedOut);
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
        $query->where('status', '!=', DeviceStatus::CheckedOut);
    }

    /**
     * Scope a query to only include devices with valid warranty date.
     * 
     * @see WarrantyStatus::Valid
     * @ignore This is a virtual status.
     */
    public function scopeWithWarranty(Builder $query): void
    {
        $query->where('warranty_expire_date', '>=', now());
    }

    /**
     * Scope a query to only include devices with expired warranty date.
     * 
     * @see WarrantyStatus::Expired
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

        $this->inprogress_tickets_count = $this->tickets->where('status', TicketStatus::InProgress)->count();
        $this->onhold_tickets_count = $this->tickets->where('status', TicketStatus::OnHold)->count();
        $this->resolved_tickets_count = $this->tickets->where('status', TicketStatus::Resolved)->count();
        $this->closed_tickets_count = $this->tickets->where('status', TicketStatus::Closed)->count();

        return $this;
    }
}
