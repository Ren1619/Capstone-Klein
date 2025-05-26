<?php

namespace App\Models\Patients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patients\Allergy;
use App\Models\Patients\MedicalCondition;
use App\Models\Patients\Medication;
use App\Models\Patients\VisitHistory;
use App\Providers\IdGenerator;
use Carbon\Carbon;

class Patient extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'PID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'address',
        'sex',
        'date_of_birth',
        'contact_number',
        'email',
        'civil_status',
    ];

    /**
     * Get the allergies for the patient.
     */
    public function allergies()
    {
        return $this->hasMany(Allergy::class, 'PID', 'PID');
    }

    /**
     * Get the medical conditions for the patient.
     */
    public function medicalConditions()
    {
        // return $this->hasMany(MedicalCondition::class, 'PID', 'PID');
        return $this->hasMany(MedicalCondition::class, 'PID', 'PID')
            ->orderBy('updated_at', 'desc')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get the medications for the patient.
     */
    public function medications()
    {
        return $this->hasMany(Medication::class, 'PID', 'PID');
    }

    /**
     * Get the visit history for the patient.
     */
    public function visitHistory()
    {
        return $this->hasMany(VisitHistory::class, 'PID', 'PID');
    }


    /**
     * Get the patient's full name.
     */
    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} " . ($this->middle_name ? "{$this->middle_name} " : "") . "{$this->last_name}");
    }

    /**
     * Get the patient's age.
     */
    public function getAgeAttribute()
    {
        return Carbon::parse($this->date_of_birth)->age;
    }

    /**
     * Get the patient's latest visit.
     */
    public function getLatestVisitAttribute()
    {
        return $this->visitHistory()->latest('timestamp')->first();
    }

    /**
     * Get a formatted version of the PID in YYYY-MM-NNNN format for display.
     */
    public function getFormattedPidAttribute()
    {
        $pid = (string) $this->PID;

        // Check if the PID is in the expected format (at least 10 digits)
        if (strlen($pid) >= 10) {
            // Extract year (first 4 digits)
            $year = substr($pid, 0, 4);

            // Extract month (next 2 digits)
            $month = substr($pid, 4, 2);

            // Get month name
            $monthName = strtoupper(date('M', mktime(0, 0, 0, (int) $month, 1)));

            // Extract random number (last 4 digits)
            $randomNumber = substr($pid, -4);

            // Format as YYYY-MM-NNNN or MMM-YYYY-NNNN
            return "{$monthName}-{$year}-{$randomNumber}";
        }

        // If PID is not in the expected format, return it as is
        return $pid;
    }

    // /**
    //  * Generate a patient ID based on the current month and year.
    //  */
    // public static function generatePatientId()
    // {
    //     return IdGenerator::generatePatientId();
    // }
}