<?php

namespace App\Models;

use App\Enums\DeviceStatus;
use App\Models\Traits\HasSince;
use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    // HELPERS /////////////////////////////////////////////////////////////////////////////////////

    /**
     * Update aggregate fields.
     */
    public function updateAggregateFields(): void
    {
        $this->calculateTicketCounters();

        $this->save();
    }

    /**
     * Calculate total and closed ticket counters.
     */
    public function calculateTicketCounters(): void
    {
        $this->total_tickets_count = $this->tickets->count();
        $this->inprogress_tickets_count = $this->tickets()->inProgress()->count();
        $this->onhold_tickets_count = $this->tickets()->onHold()->count();
        $this->resolved_tickets_count = $this->tickets()->resolved()->count();
        $this->closed_tickets_count = $this->tickets()->closed()->count();
    }

    /**
     * Calculate device status based on its tickets.
     */
    public function calculateStatus(): void
    {
        $this->calculateTicketCounters();

        $this->status = DeviceStatus::fromModel($this);
    }
}
