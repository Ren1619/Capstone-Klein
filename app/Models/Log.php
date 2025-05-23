<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Log extends Model
{
    use HasFactory;

    protected $primaryKey = 'log_ID';
    
    protected $fillable = [
        'account_ID',
        'actions',
        'descriptions',
        'timestamp',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
    ];

    public $timestamps = false; // Since this table doesn't use Laravel's timestamp columns

    /**
     * Get the account that performed the action.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_ID', 'account_ID');
    }

    /**
     * Scope a query to only include logs from a specific date range.
     */
    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('timestamp', [$startDate, $endDate]);
    }

    /**
     * Scope a query to only include logs with specific actions.
     */
    public function scopeWithAction($query, $action)
    {
        return $query->where('actions', $action);
    }
}