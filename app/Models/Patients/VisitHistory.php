<?php

// namespace App\Models;
namespace App\Models\Patients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patients\VisitProduct;
use App\Models\Patients\VisitService;
use App\Models\Patients\Diagnosis;
use App\Models\Patients\Prescription;

class VisitHistory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'visit_history';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'visit_ID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'PID',
        'timestamp',
        'blood_pressure',
        'weight',
        'height',
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
     * Get the patient that owns the visit history.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'PID', 'PID');
    }

    /**
     * Get the products for the visit.
     */
    public function products()
    {
        return $this->hasMany(VisitProduct::class, 'visit_ID', 'visit_ID');
    }

    /**
     * Get the services for the visit.
     */
    public function services()
    {
        return $this->hasMany(VisitService::class, 'visit_ID', 'visit_ID');
    }

    /**
     * Get the diagnosis for the visit.
     */
    public function diagnosis()
    {
        return $this->hasMany(Diagnosis::class, 'visit_ID', 'visit_ID');
    }

    /**
     * Get the prescriptions for the visit.
     */
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'visit_ID', 'visit_ID');
    }

    /**
     * Format the blood pressure for display.
     */
    public function getFormattedBloodPressureAttribute()
    {
        return $this->blood_pressure;
    }
}