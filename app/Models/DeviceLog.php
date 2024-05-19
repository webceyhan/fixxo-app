<?php

namespace App\Models;

use App\Enums\DeviceStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $device_id
 * @property int $user_id
 * @property string $message
 * @property DeviceStatus $status
 * @property Carbon $created_at
 * 
 * @property-read Device $device
 * @property-read User $user
 */
class DeviceLog extends Model
{
    use HasFactory;

    /**
     * Disable updated_at timestamp.
     */
    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'device_id', // TODO: remove later! It must be validated by the observer
        'user_id', // TODO: remove later! It must be validated by the observer
        'message',
        'status',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => DeviceStatus::CheckedIn,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => DeviceStatus::class,
        ];
    }

    // RELATIONS ///////////////////////////////////////////////////////////////////////////////////

    /**
     * Get the device that owns the log.
     */
    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    /**
     * Get the user that owns the log.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
