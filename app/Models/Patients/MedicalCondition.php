<?php

// namespace App\Models;
namespace App\Models\Patients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalCondition extends Model
{
    use HasFactory;

    protected $table = 'medical_conditions';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'medical_ID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'PID',
        'condition',
        'note',
    ];

    /**
     * Get the patient that owns the medical condition.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'PID', 'PID');
    }



}