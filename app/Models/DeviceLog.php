<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceLog extends Model
{
    use HasFactory;

    /**
     * Disable updated_at timestamp.
     */
    const UPDATED_AT = null;

    /**
     * Enable mass assignment.
     */
    protected $guarded = [];

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
