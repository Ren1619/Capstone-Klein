<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';
    protected $primaryKey = 'feedback_ID';

    protected $fillable = [
        'appointment_ID',
        'description',
        'rating'
    ];

    // Define relationship with Appointment
    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_ID', 'appointment_ID');
    }
}