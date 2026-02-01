<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by(
                $request->ip() . '|' . ($request->email ?? 'no-email')
            );
        });

        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinute(10)->by(
                $request->ip()
            );
        });

        Gate::define('view-post', function ($user, $post) {
            return $user->id === $post->user_id;
        });
    }
}
