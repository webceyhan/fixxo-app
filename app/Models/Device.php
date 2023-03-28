<?php

namespace App\Models;

use App\Enums\DeviceStatus;
use App\Traits\Model\HasSince;
use App\Traits\Model\Searchable;
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
}
