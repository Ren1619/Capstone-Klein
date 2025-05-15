<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}