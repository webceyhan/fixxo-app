<?php

namespace App\Models;

use App\Enums\TaskStatus;
use App\Enums\TaskType;
use App\Models\Concerns\HasSince;
use App\Observers\TaskObserver;
use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $ticket_id
 * @property string $description
 * @property float $cost
 * @property TaskType $type
 * @property TaskStatus $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property-read Ticket $ticket
 * 
 * @method static TaskFactory factory(int $count = null, array $state = [])
 * @method static Builder|static new()
 * @method static Builder|static completed()
 * @method static Builder|static cancelled()
 * @method static Builder|static valid()
 * @method static Builder|static pending()
 */
#[ObservedBy([TaskObserver::class])]
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
        'status' => TaskStatus::New,
        'type' => TaskType::Repair,
    ];

    /**
     * The attributes that should be appended to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'is_completed',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'type' => TaskType::class,
        'status' => TaskStatus::class,
    ];

    // ACCESSORS ///////////////////////////////////////////////////////////////////////////////////

    /**
     * Get the task's status.
     */
    protected function isCompleted(): Attribute
    {
        return Attribute::make(
            get: fn () => in_array($this->status, TaskStatus::completedCases()),
            set: fn (mixed $value) => ['status' => $value ? TaskStatus::Completed : TaskStatus::New]
        );
    }

    // RELATIONS ///////////////////////////////////////////////////////////////////////////////////

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    // LOCAL SCOPES ////////////////////////////////////////////////////////////////////////////////

    /**
     * Scope a query to only include new tasks.
     * 
     * @see TaskStatus::New
     */
    public function scopeNew(Builder $query): void
    {
        $query->where('status', TaskStatus::New);
    }

    /**
     * Scope a query to only include completed tasks.
     * 
     * @see TaskStatus::Completed
     */
    public function scopeCompleted(Builder $query): void
    {
        $query->whereIn('status', TaskStatus::Completed);
    }

    /**
     * Scope a query to only include cancelled tasks.
     * 
     * @see TaskStatus::Cancelled
     */
    public function scopeCancelled(Builder $query): void
    {
        $query->where('status', TaskStatus::Cancelled);
    }

    /**
     * Scope a query to only include valid tasks which are not cancelled.
     * 
     * @ignore This is a virtual status.
     */
    public function scopeValid(Builder $query): void
    {
        $query->whereNot('status', TaskStatus::Cancelled);
    }

    /**
     * Scope a query to only include pending tasks.
     * 
     * @ignore This is a virtual status.
     */
    public function scopePending(Builder $query): void
    {
        $query->where('status', TaskStatus::New);
    }
}
