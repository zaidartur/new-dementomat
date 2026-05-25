<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(\App\Providers\TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // A general limit for API requests
        RateLimiter::for('api', function (Request $request) {
            return $request->user()
                ? Limit::perMinute(60)->by($request->user()->id) // 60 for logged-in users
                : Limit::perMinute(10)->by($request->ip());      // 10 for guests
        });

        // A strict limit for login attempts
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        // Restrict Pulse dashboard access to administrators only
        Gate::define('viewPulse', function (User $user) {
            return $user->hasAnyRole(['superadmin', 'admin']);
        });

        // Define the security gate for user monitoring
        Gate::define('viewUserMonitoring', function (User $user) {
            // Only allow specific admin emails to access the logs
            return $user->hasAnyRole(['superadmin']);
        });
    }
}
