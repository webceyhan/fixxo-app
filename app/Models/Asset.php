<?php

namespace App\Models;

use App\Enums\AssetStatus;
use App\Enums\AssetType;
use App\Traits\Model\HasSince;
use App\Traits\Model\Searchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asset extends Model
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
        'warranty' => 0,
        'problem' => null,
        'notes' => null,
        'status' => AssetStatus::IN_PROGRESS,
    ];

    /**
     * Index to use for full-text search.
     *
     * @var string
     */
    protected $searchIndex = 'name,serial,problem';

    // ACCESSORS ///////////////////////////////////////////////////////////////////////////////////

    /**
     * Get sum of all tasks prices.
     */
    protected function cost(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->tasks->pluck('price')->sum(),
        )->shouldCache();
    }

    // RELATIONS ///////////////////////////////////////////////////////////////////////////////////

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): belongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class)->latest();
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class)->latest();
    }

    // LOCAL SCOPES ////////////////////////////////////////////////////////////////////////////////

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeInProgress(Builder $query): void
    {
        $query->where('status', AssetStatus::IN_PROGRESS);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeReady(Builder $query): void
    {
        $query->where('status', AssetStatus::READY);
    }
}
