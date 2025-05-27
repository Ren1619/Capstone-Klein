<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\TwoFactorCodeMail;
use App\Models\Log;
use App\Models\Account;
use App\Models\VerificationCode;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class AuthenticatedSessionController extends Controller
{
    // Maximum number of failed login attempts before locking account
    const MAX_FAILED_ATTEMPTS = 5;

    // Duration in minutes for account lockout
    const LOCKOUT_DURATION = 30;

    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        try {
            // Check if account is locked
            $email = $request->input('email');
            $account = Account::where('email', $email)->first();

            if ($account) {
                // Check if account is locked
                if ($account->locked_at) {
                    $lockoutEnd = Carbon::parse($account->locked_at)
                        ->addMinutes(self::LOCKOUT_DURATION);

                    if (now()->lt($lockoutEnd)) {
                        $timeRemaining = now()->diffInMinutes($lockoutEnd);
                        return back()->withErrors([
                            'email' => "This account is temporarily locked due to multiple failed login attempts. Please try again in {$timeRemaining} minutes or contact an administrator."
                        ]);
                    } else {
                        // Lockout period expired, reset the lock
                        $account->locked_at = null;
                        $account->failed_login_attempts = 0;
                        $account->save();
                    }
                }

                // Check password manually to handle failed attempts
                if (!Hash::check($request->password, $account->password)) {
                    // Increment failed attempts
                    $account->failed_login_attempts = ($account->failed_login_attempts ?? 0) + 1;

                    // Lock account if max attempts reached
                    if ($account->failed_login_attempts >= self::MAX_FAILED_ATTEMPTS) {
                        $account->locked_at = now();

                        // Log account lock
                        Log::create([
                            'account_ID' => $account->account_ID,
                            'actions' => 'Account Locked',
                            'descriptions' => 'Account locked due to multiple failed login attempts',
                            'timestamp' => now(),
                        ]);
                    }

                    $account->save();

                    throw ValidationException::withMessages([
                        'email' => __('auth.failed'),
                    ]);
                }
            }

            // Process authentication
            $request->authenticate();

            // For 2FA
            $user = Auth::user();
            Auth::logout();

            // Store user ID in session
            Session::put('auth.2fa.user_id', $user->account_ID);

            // Generate verification code
            $verificationCode = VerificationCode::generateFor($user->account_ID);

            // Send verification code via email
            $account = Account::find($user->account_ID);
            Mail::to($user->email)->send(new TwoFactorCodeMail($account, $verificationCode->code));

            return redirect()->route('two-factor.show');

        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        // Log the logout activity
        if (Auth::check()) {
            Log::create([
                'account_ID' => Auth::user()->account_ID,
                'actions' => 'Logout',
                'descriptions' => 'User logged out',
                'timestamp' => now(),
            ]);
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}