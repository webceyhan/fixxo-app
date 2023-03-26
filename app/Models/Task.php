<?php

namespace App\Models;

use App\Enums\TaskStatus;
use App\Traits\Model\HasSince;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory, HasSince;

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
        'price' => 0,
        'completed_at' => null,
    ];

    // RELATIONS ///////////////////////////////////////////////////////////////////////////////////

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    // LOCAL SCOPES ////////////////////////////////////////////////////////////////////////////////

    /**
     * Scope a query to get tasks that are pending.
     */
    public function scopePending(Builder $query): void
    {
        $query->whereNull('completed_at');
    }

    /**
     * Scope a query to get tasks that are completed.
     */
    public function scopeCompleted(Builder $query): void
    {
        $query->whereNotNull('completed_at');
    }

    /**
     * Scope a query to get statistics grouped by status.
     */
    public function scopeStats(Builder $query): void
    {
        $query->selectRaw('COUNT(id) as value, status as label')
            ->groupBy('status');
    }
}
