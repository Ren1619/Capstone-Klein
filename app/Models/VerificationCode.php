<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class VerificationCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_ID',
        'code',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * Check if the verification code is expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->expires_at->isPast();
    }

    /**
     * Generate a random verification code for a user.
     *
     * @param int $account_ID
     * @return self
     */
    public static function generateFor($account_ID)
    {
        // Delete any existing codes for the user
        self::where('account_ID', $account_ID)->delete();

        // Create a new verification code
        return self::create([
            'account_ID' => $account_ID,
            'code' => sprintf('%06d', mt_rand(0, 999999)), // 6-digit code
            'expires_at' => Carbon::now()->addMinutes(15), // Expires in 15 minutes
        ]);
    }
}