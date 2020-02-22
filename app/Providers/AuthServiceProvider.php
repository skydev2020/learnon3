<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

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
            return $user->hasAnyRoles(['admin','tutor']);
        });


        // Tutor Related
        Gate::define('manage-payment-records', function($user) {
            return $user->hasRole('tutor');
        });

        Gate::define('manage-tutor-students', function($user) {
            return $user->hasRole('tutor');
        });

        Gate::define('manage-essay', function($user) {
            return $user->hasRole('tutor');
        });

        Gate::define('manage-sessions', function($user) {
            return $user->hasRole('tutor');
        });

        Gate::define('manage-report-cards', function($user) {
            // return $user->hasRole('tutor');
            return $user->hasAnyRoles(['tutor','student']);
        });

        // Student Related
        Gate::define('manage-student-tutors', function($user) {
            return $user->hasRole('student');
        });

        Gate::define('manage-invoices', function($user) {
            return $user->hasRole('student');
        });

        Gate::define('manage-add-student', function($user) {
            return $user->hasRole('student');
        });

        Gate::define('manage-discount-package', function($user) {
            return $user->hasRole('student');
        });

        Passport::routes();
        Passport::loadKeysFrom(getenv('USERPROFILE').'\secret-keys\oauth');
    }
}
