<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Branch extends Model
{
    protected $primaryKey = 'branch_ID';

    protected $fillable = [
        'name',
        'address',
        'contact',
        'status',
        'operating_days_from',
        'operating_days_to',
        'operating_hours_start',
        'operating_hours_end',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public $timestamps = true;

    // Clear cache after model changes
    protected static function booted()
    {
        static::created(function () {
            Cache::forget('all_branches');
        });

        static::updated(function () {
            Cache::forget('all_branches');
        });

        static::deleted(function () {
            Cache::forget('all_branches');
        });
    }
}