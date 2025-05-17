<?php

// namespace App\Models;
namespace App\Models\Patients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patients\Prescription;

class Medication extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'medication_ID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'PID',
        'medication',
        'dosage',
        'frequency',
        'duration',
        'note',
    ];

    /**
     * Get the patient that owns the medication.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'PID', 'PID');
    }

    /**
     * Get the prescriptions for the medication.
     */
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'medication_ID', 'medication_ID');
    }
}