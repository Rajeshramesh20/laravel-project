<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use App\Models\RoleMenuPermission;
use App\Models\Menu;

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
      

        Gate::define('is_superadmin', function ($user) {
            return $user->roles->RoleName == 'superadmin';
        });
        Gate::define('is_admin', function ($user) {
            return $user->roles->RoleName == 'admin';
        });
        Gate::define('is_manager', function ($user) {
            return $user->roles->RoleName == 'manager';
        });
        Gate::define('is_user', function ($user) {
            return $user->roles->RoleName == 'user';
        });
        Gate::define('is_superadmin_or_admin', function ($user) {
            return in_array($user->roles->RoleName, ['superadmin', 'admin']);
        });
        Gate::define('is_superadmin_or_admin_or_manager', function ($user) {
            return in_array($user->roles->RoleName, ['superadmin', 'admin', 'manager']);
        });
        
        Gate::define('is_user_or_manager', function ($user) {
            return in_array($user->roles->RoleName, ['user','manager']);
        });




        Gate::define('access-menu', function ($user, $routeName, $accessType = 'fullaccess') {
            $menu = Menu::where('route', $routeName)->first();
            if (!$menu) return false;

            $permission = RoleMenuPermission::where('role_id', $user->role_id)
                ->where('menu_id', $menu->id)
                ->first();

            if (!$permission) return false;

            return match ($accessType) {
                'fullaccess' => $permission->fullaccess,
                'viewonly' => $permission->viewonly,
                'hidden' => $permission->hidden,
                default => false,
            };
        });

    }
}
