<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\TwoFactorCodeMail;
use App\Models\Account;
use App\Models\VerificationCode;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class TwoFactorController extends Controller
{
    /**
     * Display the two-factor authentication form.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        if (!Session::has('auth.2fa.user_id')) {
            return redirect()->route('login');
        }

        return view('auth.mail.two-factor-verification');
    }

    /**
     * Send a verification code to the user's email.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendCode()
    {
        if (!Session::has('auth.2fa.user_id')) {
            return redirect()->route('login');
        }

        $userId = Session::get('auth.2fa.user_id');
        $user = Account::find($userId);

        if (!$user) {
            Session::forget('auth.2fa.user_id');
            return redirect()->route('login');
        }

        // Generate a new verification code
        $verificationCode = VerificationCode::generateFor($user->account_ID);

        // Send the verification code via email
        Mail::to($user->email)->send(new TwoFactorCodeMail($user, $verificationCode->code));

        return back()->with('status', 'Verification code has been sent to your email.');
    }

    /**
     * Verify the provided code.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(Request $request)
    {
        if (!Session::has('auth.2fa.user_id')) {
            return redirect()->route('login');
        }

        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $userId = Session::get('auth.2fa.user_id');
        $user = Account::find($userId);

        if (!$user) {
            Session::forget('auth.2fa.user_id');
            return redirect()->route('login');
        }

        // Find the verification code
        $verificationCode = VerificationCode::where('account_ID', $user->account_ID)
            ->where('code', $request->code)
            ->first();

        // Verify the code
        if (!$verificationCode || $verificationCode->isExpired()) {
            return back()->withErrors([
                'code' => 'The verification code is invalid or has expired.',
            ]);
        }

        // Delete the code after use
        $verificationCode->delete();

        // Complete the login
        Auth::login($user);
        $request->session()->regenerate();
        Session::forget('auth.2fa.user_id');

        // Log the login activity
        \App\Models\Log::create([
            'account_ID' => $user->account_ID,
            'actions' => 'Login',
            'descriptions' => 'User logged in successfully with 2FA',
            'timestamp' => now(),
        ]);

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}