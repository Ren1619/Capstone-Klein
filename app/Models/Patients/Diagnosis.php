<?php

namespace App\Models\Patients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Account;

class Diagnosis extends Model
{
    use HasFactory;

    protected $table = 'diagnosis';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'diagnosis_ID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'account_ID',
        'visit_ID',
        'note',
    ];

    /**
     * Get the visit that owns the diagnosis.
     */
    public function visit()
    {
        return $this->belongsTo(VisitHistory::class, 'visit_ID', 'visit_ID');
    }

    /**
     * Get the account that created the diagnosis.
     */
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_ID', 'account_ID');
    }

    /**
     * Get the patient through the visit relationship.
     */
    public function patient()
    {
        return $this->hasOneThrough(
            Patient::class,
            VisitHistory::class,
            'visit_ID', // Foreign key on visit_history table
            'PID',      // Foreign key on patients table
            'visit_ID', // Local key on diagnosis table
            'PID'       // Local key on visit_history table
        );
    }
}