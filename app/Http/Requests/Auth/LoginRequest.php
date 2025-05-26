<?php

namespace App\Http\Requests\Auth;

use App\Models\Account;
use App\Models\Log;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Maximum number of allowed attempts before locking
     */
    protected $maxAttempts = 5;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();
        $this->checkAccountLock();

        $email = $this->input('email');
        $account = Account::where('email', $email)->first();

        if (Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            // Authentication passed, reset failed attempts
            if ($account) {
                $account->failed_login_attempts = 0;
                $account->save();
            }

            RateLimiter::clear($this->throttleKey());
            return;
        }

        // Authentication failed, increment counter
        if ($account) {
            $account->failed_login_attempts += 1;

            // Check if account should be locked
            if ($account->failed_login_attempts >= $this->maxAttempts) {
                $account->locked_at = now();

                // Log account lock
                Log::create([
                    'account_ID' => $account->account_ID,
                    'actions' => 'Account Locked',
                    'descriptions' => 'Account locked due to ' . $this->maxAttempts . ' failed login attempts',
                    'timestamp' => now(),
                ]);
            }

            $account->save();
        }

        RateLimiter::hit($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    /**
     * Check if the account is locked.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function checkAccountLock(): void
    {
        $email = $this->input('email');
        $account = Account::where('email', $email)->first();

        if ($account && $account->locked_at) {
            throw ValidationException::withMessages([
                'email' => 'This account has been locked due to multiple failed login attempts. Please contact an administrator.',
            ]);
        }
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')) . '|' . $this->ip());
    }
}