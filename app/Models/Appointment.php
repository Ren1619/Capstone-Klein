<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';
    protected $primaryKey = 'appointment_ID';    protected $fillable = [
        'branch_ID',
        'last_name',
        'first_name',
        'phone_number',
        'email',
        'date',
        'time',
        'appointment_type',
        'concern',
        'referral_code',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i:s'
    ];

    // Define relationship with Feedback
    public function feedback()
    {
        return $this->hasOne(Feedback::class, 'appointment_ID', 'appointment_ID');
    }

    // Define relationship with Branch
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_ID', 'branch_ID');
    }
}