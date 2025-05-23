<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\TwoFactorCodeMail;
use App\Models\Log;
use App\Models\VerificationCode;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class AuthenticatedSessionController extends Controller
{
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
        $request->authenticate();

        // Instead of completing the login, store the user ID and redirect to 2FA
        $user = Auth::user();
        Auth::logout();

        // Store user ID in session
        Session::put('auth.2fa.user_id', $user->account_ID);

        // Generate verification code
        $verificationCode = VerificationCode::generateFor($user->account_ID);

        // Send verification code via email
        $account = \App\Models\Account::find($user->account_ID);
        Mail::to($user->email)->send(new TwoFactorCodeMail($account, $verificationCode->code));

        return redirect()->route('two-factor.show');
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
            \App\Models\Log::create([
                'account_ID' => Auth::user()->account_ID, // Fixed: was Auth::id()
                'actions' => 'Logout',
                'descriptions' => 'User logged out',
                'timestamp' => now(), // Fixed: was Carbon::now()
            ]);
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}