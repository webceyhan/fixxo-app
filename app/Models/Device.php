<?php

namespace App\Models;

use App\Enums\DeviceStatus;
use App\Enums\TicketStatus;
use App\Traits\Model\HasSince;
use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    protected $appends = [];

    /**
     * Index to use for full-text search.
     *
     * @var string
     */
    protected $searchIndex = 'name,brand,type,serial';

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
     * Scope a query to retrieve all brands sorted by their frequency.
     */
    public function scopeBrands(Builder $query): void
    {
        $query->select('brand')
            ->whereNotNull('brand')
            ->groupBy('brand')
            ->orderByRaw('COUNT(brand) DESC');
    }

    // HELPERS /////////////////////////////////////////////////////////////////////////////////////

    /**
     * Calculate total and closed ticket counters.
     */
    public function calculateTicketCounters(): void
    {
        $tickets = $this->tickets;

        $this->total_tickets_count = $tickets->count();
        $this->inprogress_tickets_count = $tickets->where('status', TicketStatus::IN_PROGRESS)->count();
        $this->onhold_tickets_count = $tickets->where('status', TicketStatus::ON_HOLD)->count();
        $this->resolved_tickets_count = $tickets->where('status', TicketStatus::RESOLVED)->count();
        $this->closed_tickets_count = $tickets->where('status', TicketStatus::CLOSED)->count();
    }

    /**
     * Calculate device status based on its tickets.
     */
    public function calculateStatus(): void
    {
        $this->calculateTicketCounters();

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
        // - fixed
        // - defect
        // - checked_out

        // When a new ticket is created, the device state can remain the same.
        // When a ticket is in progress, the device state can remain the same.
        // When a ticket is put on hold, the device state can be changed to "on_hold".
        // When a ticket is resolved, the device state can remain the same.
        // When a ticket is closed, the device state can be changed to "fixed" if there are no other pending tickets for the device.
        // Overall, the device state can only move to "on_hold" or "in_repair" when there is at least one pending ticket for the device.

        switch ($this->status) {
            case DeviceStatus::CHECKED_IN:
            case DeviceStatus::ON_HOLD:
                // if the device has pending tickets, it is still in repair and needs further action
                if ($hasPendingTickets) {
                    $this->status = DeviceStatus::IN_REPAIR;
                }
                // if the device has tickets but no more pending tickets and no tickets in progress,
                // it means that all tickets are completed (resolved / closed), so the device is now fixed
                if ($hasTickets && !$hasPendingTickets && !$inProgressTicketsCount) {
                    $this->status = DeviceStatus::FIXED;
                }
                break;

            case DeviceStatus::IN_REPAIR:
                // if the device has no tickets or all tickets are on hold,
                // it means that there is nothing left to do for now, so the device is put on hold
                if (!$hasTickets || $hasPendingTickets && !$inProgressTicketsCount) {
                    $this->status = DeviceStatus::ON_HOLD;
                }
                // if the device has tickets but no pending tickets or tickets on-hold,
                // it means that all tickets are completed, so the device is now fixed
                if ($hasTickets && !$hasPendingTickets && !$onHoldTicketsCount) {
                    $this->status = DeviceStatus::FIXED;
                }
                break;

            case DeviceStatus::FIXED:
            case DeviceStatus::DEFECT:
            case DeviceStatus::CHECKED_OUT:
                // if the device has no tickets or all tickets are on-hold,
                // it means that there is nothing left to do for now, so the device is put on hold
                if (!$hasTickets || $hasPendingTickets && !$inProgressTicketsCount) {
                    $this->status = DeviceStatus::ON_HOLD;
                }
                // if the device has pending tickets or tickets in progress, it means that there are still
                // tickets left to do, so the device is still in progress and needs further action
                if ($hasPendingTickets && $inProgressTicketsCount) {
                    $this->status = DeviceStatus::IN_REPAIR;
                }
                break;
        }
    }
}
