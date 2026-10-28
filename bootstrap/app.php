<?php

use App\Http\Middleware\AuthBasic;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\TrustProxies;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Http\Middleware\TrustProxies as DefaultTrustProxies;

/*
|--------------------------------------------------------------------------
| Application bootstrap
|--------------------------------------------------------------------------
|
| This file replaces app/Http/Kernel.php, app/Console/Kernel.php and
| app/Exceptions/Handler.php from ijinnakes (Laravel 8). Each block below is
| annotated with the Kernel entry it was migrated from.
|
*/

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        // Old RouteServiceProvider::boot():
        //   Route::middleware('web')->group(base_path('routes/web.php'))
        //   Route::prefix('api')->middleware('api')->group(base_path('routes/api.php'))
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        apiPrefix: 'api',

        // Old Console\Kernel::commands(): require base_path('routes/console.php')
        commands: __DIR__.'/../routes/console.php',

        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Old $middlewareGroups['web']: App\Http\Middleware\VerifyCsrfToken
        // used to replace the framework CSRF middleware.
        $middleware->web(replace: [
            ValidateCsrfToken::class => VerifyCsrfToken::class,
        ]);

        // Old $middlewareGroups['api']: 'throttle:api' + AuthBasic.
        $middleware->throttleApi();
        $middleware->api(append: [
            AuthBasic::class,
        ]);

        // Old global $middleware: App\Http\Middleware\TrustProxies.
        $middleware->replace(DefaultTrustProxies::class, TrustProxies::class);

        // Old $routeMiddleware aliases. Laravel 13 already ships the
        // framework aliases (auth.basic, cache.headers, can, password.confirm,
        // signed, throttle, verified); only the app specific ones are listed.
        $middleware->alias([
            'auth' => Authenticate::class,
            'guest' => RedirectIfAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Old App\Exceptions\Handler only declared $dontFlash, which matches
        // the Laravel 13 default, so nothing needs to be registered here.
    })
    ->create();