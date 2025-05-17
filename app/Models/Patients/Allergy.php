<?php

// namespace App\Models;
namespace App\Models\Patients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allergy extends Model
{
    use HasFactory;

    protected $table = 'allergies';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'allergy_ID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'PID',
        'allergies',
        'note',
    ];

    /**
     * Get the patient that owns the allergy.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'PID', 'PID');
    }
}