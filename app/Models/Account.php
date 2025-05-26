<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Fortify\TwoFactorAuthenticatable; // Add this line

class Account extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable; // Add TwoFactorAuthenticatable

    protected $primaryKey = 'account_ID';

    protected $fillable = [
        'role_ID',
        'branch_ID',
        'last_name',
        'first_name',
        'contact_number',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes', // Add this line
        'two_factor_secret', // Add this line
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the role associated with the account.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(AccountRole::class, 'role_ID', 'role_ID');
    }

    /**
     * Get the branch associated with the account.
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_ID', 'branch_ID');
    }

    /**
     * Get account's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}