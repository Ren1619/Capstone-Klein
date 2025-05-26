<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Models\Account;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Configure the password reset notification to use account_ID
        ResetPassword::createUrlUsing(function ($notifiable, $token) {
            return config('app.url') . '/reset-password/' . $token . '?email=' . urlencode($notifiable->getEmailForPasswordReset());
        });
        
        // Define gates for role-based access if needed
        Gate::define('admin', function (Account $account) {
            return $account->role && $account->role->role_name === 'Admin';
        });
        
        Gate::define('staff', function (Account $account) {
            return $account->role && in_array($account->role->role_name, ['Staff', 'Admin']);
        });
    }
}