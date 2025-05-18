<?php

namespace App\Models\Patients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'prescription_ID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'visit_ID',
        'medication_name',
        'timestamp',
        'dosage',
        'frequency',
        'duration',
        'note',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'timestamp' => 'datetime',
    ];

    /**
     * Get the visit that this prescription belongs to.
     */
    public function visit()
    {
        return $this->belongsTo(VisitHistory::class, 'visit_ID', 'visit_ID');
    }
}