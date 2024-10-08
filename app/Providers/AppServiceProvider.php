<?php

namespace App\Providers;

use App\Models\Task;
use App\Models\Todo;
use App\Policies\TaskPolicy;
use App\Policies\TodoPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

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

        RateLimiter::for('login-attempt', function (Request $request) {
            $ip = $request->ip();

            // Limit to 5 attempts per minute per email and IP combination
            return Limit::perMinute(5)->by($ip);
        });
    }
}
