<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\Concerns\Contactable;
use App\Models\Concerns\HasSince;
use App\Models\Concerns\Searchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use  HasFactory, Notifiable, Searchable, HasSince, Contactable;

    /**
     * Searchable attributes.
     *
     * @var array<int, string>
     */
    protected $searchable = [
        'name',
        'email',
        'phone',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'status',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'role' => UserRole::Technician,
        'status' => UserStatus::Active,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'role' => UserRole::class,
            'status' => UserStatus::class,
            'email_verified_at' => 'datetime',
        ];
    }

    // RELATIONS ///////////////////////////////////////////////////////////////////////////////////

    public function assignedTickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'assignee_id');
    }

    // SCOPES //////////////////////////////////////////////////////////////////////////////////////

    /**
     * Scope a query to only include users with the specified role.
     */
    public function scopeOfRole(Builder $query, UserRole $role): void
    {
        $query->where('role', $role->value);
    }

    /**
     * Scope a query to only include users with the specified status.
     */
    public function scopeOfStatus(Builder $query, UserStatus $status): void
    {
        $query->where('status', $status->value);
    }

    /**
     * Scope a query to only include administrators.
     */
    public function scopeAdmins(Builder $query): void
    {
        $query->ofRole(UserRole::Admin);
    }

    /**
     * Scope a query to only include managers.
     */
    public function scopeManagers(Builder $query): void
    {
        $query->ofRole(UserRole::Manager);
    }

    /**
     * Scope a query to only include technicians.
     */
    public function scopeTechnicians(Builder $query): void
    {
        $query->ofRole(UserRole::Technician);
    }

    // METHODS /////////////////////////////////////////////////////////////////////////////////////

    /**
     * Determine if the user is an administrator.
     */
    public function isAdmin(): bool
    {
        return $this->role->isAdmin();
    }

    /**
     * Determine if the user is active.
     */
    public function isActive(): bool
    {
        return $this->status->isActive();
    }
}
