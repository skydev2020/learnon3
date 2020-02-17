<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
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

        Gate::define('manage-users', function($user) {
            return $user->hasAnyRoles(['admin','tutor']);
        });

        Gate::define('edit-users', function($user) {
            return $user->hasAnyRoles(['admin','tutor']);
        });

        Gate::define('delete-users', function($user) {
            return $user->hasRole('admin');
        });

        Gate::define('manage-students', function($user) {
            return $user->hasRole('admin');
        });

        Gate::define('manage-tutors', function($user) {
            return $user->hasRole('admin');
        });

        Gate::define('manage-payments', function($user) {
            return $user->hasRole('admin');
        });

        Gate::define('manage-cms', function($user) {
            return $user->hasRole('admin');
        });

        Gate::define('manage-reports', function($user) {
            return $user->hasRole('admin');
        });

        Gate::define('manage-system', function($user) {
            return $user->hasRole('admin');
        });

        Gate::define('manage-tutoring-resource', function($user) {
            return $user->hasRole('admin, student');
        });
        //
    }
}
