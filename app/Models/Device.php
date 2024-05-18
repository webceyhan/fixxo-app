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
        'model',
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

        $this->status = $this->determineStatus();

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

    /**
     * Determine the device's status based on its ticket counters.
     */
    private function determineStatus(): DeviceStatus
    {
        // get the ticket related counters
        $inProgressTicketsCount = $this->inprogress_tickets_count;
        $onHoldTicketsCount = $this->onhold_tickets_count;
        $resolvedTicketsCount = $this->resolved_tickets_count;
        $closedTicketsCount = $this->closed_tickets_count;
        $totalTicketsCount = $this->total_tickets_count;

        // define completed and pending tickets count
        $completedTicketsCount = $resolvedTicketsCount + $closedTicketsCount;
        $pendingTicketsCount = $totalTicketsCount - $completedTicketsCount;

        // get the boolean flags
        $hasTickets = $totalTicketsCount > 0;
        $hasPendingTickets = $pendingTicketsCount > 0;

        // -------------------- TICKET STATES
        // - new                        -> pending
        // - in_progress                -> pending
        // - on_hold                    -> pending
        // - resolved                   -> completed
        // - closed                     -> completed

        // --------------------- DEVICE STATES
        // - checked_in
        // - in_repair
        // - on_hold
        // - finished
        // - checked_out

        // When a new ticket is created, the device state can remain the same.
        // When a ticket is in progress, the device state can remain the same.
        // When a ticket is put on hold, the device state can be changed to "on_hold".
        // When a ticket is resolved, the device state can remain the same.
        // When a ticket is closed, the device state can be changed to "fixed" if there are no other pending tickets for the device.
        // Overall, the device state can only move to "on_hold" or "in_repair" when there is at least one pending ticket for the device.

        switch ($this->status) {
            case DeviceStatus::CheckedIn:
            case DeviceStatus::OnHold:
                // if the device has pending tickets, it is still in repair and needs further action
                if ($hasPendingTickets) {
                    return DeviceStatus::InRepair;
                }
                // if the device has tickets but no more pending tickets and no tickets in progress,
                // it means that all tickets are completed (resolved / closed), so the device is now fixed
                if ($hasTickets && !$hasPendingTickets && !$inProgressTicketsCount) {
                    return DeviceStatus::Finished;
                }
                break;

            case DeviceStatus::InRepair:
                // if the device has no tickets or all tickets are on hold,
                // it means that there is nothing left to do for now, so the device is put on hold
                if (!$hasTickets || $hasPendingTickets && !$inProgressTicketsCount) {
                    return DeviceStatus::OnHold;
                }
                // if the device has tickets but no pending tickets or tickets on-hold,
                // it means that all tickets are completed, so the device is now fixed
                if ($hasTickets && !$hasPendingTickets && !$onHoldTicketsCount) {
                    return DeviceStatus::Finished;
                }
                break;

            case DeviceStatus::Finished:
            case DeviceStatus::CheckedOut:
                // if the device has no tickets or all tickets are on-hold,
                // it means that there is nothing left to do for now, so the device is put on hold
                if (!$hasTickets || $hasPendingTickets && !$inProgressTicketsCount) {
                    return DeviceStatus::OnHold;
                }
                // if the device has pending tickets or tickets in progress, it means that there are still
                // tickets left to do, so the device is still in progress and needs further action
                if ($hasPendingTickets && $inProgressTicketsCount) {
                    return DeviceStatus::InRepair;
                }
                break;
        }

        return $this->status;
    }
}
