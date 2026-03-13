<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        // You can register model-specific policies here if needed
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Register any model policies
        $this->registerPolicies();

        /*
        |--------------------------------------------------------------------------
        | Gates
        |--------------------------------------------------------------------------
        | Gates define what users are allowed to do.
        | Example: Admin-only access to routes or controllers
        */

        // Admin Gate: only allow users with is_admin = true
        Gate::define('isAdmin', function (User $user) {
            return $user->isAdmin(); // Uses the method in User model
        });

        // Example: You can add more gates later
        // Gate::define('canTopup', fn(User $user) => !$user->is_admin);
    }
}
