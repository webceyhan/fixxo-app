<?php

namespace App\Models;

use App\Enums\AssetStatus;
use App\Traits\Model\HasSince;
use App\Traits\Model\Searchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asset extends Model
{
    use HasFactory, Searchable, HasSince;

    /**
     * Index to use for full-text search.
     *
     * @var string
     */
    protected $searchIndex = 'name,serial,problem';

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
