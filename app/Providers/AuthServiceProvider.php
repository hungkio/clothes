<?php

namespace App\Providers;

use App\Domain\Acl\Models\Role;
use App\Domain\Admin\Models\Admin;
use App\Domain\Admin\Policies\AdminPolicy;
use App\Domain\Acl\Policies\RolePolicy;
use App\Domain\Post\Models\Post;
use App\Domain\Post\Policies\PostPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Models\Activity;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Role::class => RolePolicy::class,
        Admin::class => AdminPolicy::class,
        Post::class => PostPolicy::class,
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

//        Gate::define('settings', function ($user) {
//            return $user->isAdmin;
//        });

        Gate::before(function (Admin $admin, $ability) {
            return $admin->email == config('ecc.admin_email') || $admin->hasRole('superadmin') ? true : null;
        });
    }
}
