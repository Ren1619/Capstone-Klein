<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AccountRole extends Model
{
    use HasFactory;

    protected $table = 'accounts_role';
    protected $primaryKey = 'role_ID';
    
    protected $fillable = [
        'role_name',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get all accounts associated with this role.
     */
    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class, 'role_ID', 'role_ID');
    }
}