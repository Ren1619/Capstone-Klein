<?php

namespace App\Models\Patients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service;

class VisitService extends Model
{
    use HasFactory;

    protected $table = 'visit_services';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'visit_services_ID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'visit_ID',
        'service_ID',
        'note',
    ];

    /**
     * Get the visit that owns the service.
     */
    public function visit()
    {
        return $this->belongsTo(VisitHistory::class, 'visit_ID', 'visit_ID');
    }

    /**
     * Get the service that is provided.
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_ID', 'service_ID');
    }

    /**
     * Get the patient through the visit.
     */
    public function patient()
    {
        return $this->hasOneThrough(
            Patient::class,
            VisitHistory::class,
            'visit_ID',
            'PID',
            'visit_ID',
            'PID'
        );
    }
}