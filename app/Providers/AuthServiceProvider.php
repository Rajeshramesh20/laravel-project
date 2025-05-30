<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Passport::personalAccessTokensExpireIn(now()->addMinutes(30));
        // Passport::tokensExpireIn(now()->addMinutes(1));
        // Passport::refreshTokensExpireIn(now()->addMinutes(1));

        Gate::define('is_superadmin',function($user){
            return $user->role == 'superadmin';
        });
        Gate::define('is_admin', function ($user) {
            return $user->role == 'admin';
        });
        Gate::define('is_manager', function ($user) {
            return $user->role == 'manager';
        });
        Gate::define('is_user', function ($user) {
            return $user->role == 'user';
        });
        Gate::define('is_superadmin_or_admin', function($user) {
        return in_array($user->role, ['superadmin', 'admin']);
        });
        Gate::define('is_superadmin_or_admin_or_manager', function ($user) {
            return in_array($user->role, ['superadmin', 'admin','manager']);
        });
 
    }
}
    

