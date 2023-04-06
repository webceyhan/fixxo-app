<?php

namespace App\Models;

use App\Enums\TaskStatus;
use App\Models\Attributes\BooleanDateAttribute;
use App\Models\Traits\HasSince;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'cost' => 0,
        'completed_at' => null,
    ];

    /**
     * The attributes that should be appended to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'is_completed',
        'status',
    ];

    // ACCESSORS ///////////////////////////////////////////////////////////////////////////////////

    /**
     * Get the task's status.
     */
    protected function isCompleted(): Attribute
    {
        return BooleanDateAttribute::for('completed_at');
    }

    /**
     * Get the task's status.
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn () => TaskStatus::fromModel($this),
            // TODO: this should be a method on the enum
            // cast doesn't work with 'status' because it's a virtual attribute
            // instead of this setterm we use is_completed attribute
            set: fn (mixed $value) => match ($value) {
                TaskStatus::PENDING, 'pending' => ['completed_at' => null],
                TaskStatus::COMPLETED, 'completed' => ['completed_at' => now()],
            },
        );
    }

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
     * Scope a query to only include pending tasks.
     * 
     * @see TaskStatus::PENDING
     * @ignore This is a virtual status.
     */
    public function scopePending(Builder $query): void
    {
        $query->whereNull('completed_at');
    }

    /**
     * Scope a query to only include completed tasks.
     * 
     * @see TaskStatus::COMPLETED
     * @ignore This is a virtual status.
     */
    public function scopeCompleted(Builder $query): void
    {
        $query->whereNotNull('completed_at');
    }
}
