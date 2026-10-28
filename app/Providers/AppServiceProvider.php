<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Migrated from App\Providers\RouteServiceProvider::configureRateLimiting().
        // The "api" limiter is required by $middleware->throttleApi() in
        // bootstrap/app.php.
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });

        // The views were written for Bootstrap; AdminLTE 4 / Bootstrap 5 is the
        // target UI, so pagination links must use the Bootstrap 5 markup.
        Paginator::useBootstrapFive();

        // Migrated from routes/web.php: \URL::forceScheme('https');
        if (config('app.force_https')) {
            URL::forceScheme('https');
        }
    }
}
