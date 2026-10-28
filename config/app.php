<?php

use Illuminate\Support\Facades\Facade;
use Mews\Captcha\Facades\Captcha;

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    */

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    */

    'locale' => env('APP_LOCALE', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    */

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', (string) env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Post-login destination
    |--------------------------------------------------------------------------
    |
    | Replaces the constant App\Providers\RouteServiceProvider::HOME from
    | ijinnakes ("/dashboard"). RouteServiceProvider no longer exists in
    | Laravel 11+, so the value lives in configuration instead.
    |
    */

    'home' => env('APP_HOME', '/dashboard'),

    /*
    |--------------------------------------------------------------------------
    | Force HTTPS scheme on generated URLs
    |--------------------------------------------------------------------------
    |
    | ijinnakes called \URL::forceScheme('https') unconditionally at the top
    | of routes/web.php. That is now opt-in so local/http deployments keep
    | working: set FORCE_HTTPS=true behind a TLS terminating proxy.
    |
    */

    'force_https' => (bool) env('FORCE_HTTPS', false),

    /*
    |--------------------------------------------------------------------------
    | Legacy application endpoints
    |--------------------------------------------------------------------------
    |
    | Custom keys that lived in ijinnakes/config/app.php and are read through
    | config('app.*') by the controllers and models.
    |
    */

    'surat_host' => env('SURAT_HOST'),
    'wa_host' => env('WA_HOST'),
    'wa2_host' => env('WA2_HOST'),
    'no_ptsp' => env('NO_PTSP'),
    'warehouse_host' => env('WAREHOUSE_HOST'),
    'cv2_host' => env('CV2_HOST'),
    'ocr_host' => env('OCR_HOST'),
    'conv_host' => env('CONV_HOST'),
    'summary_host' => env('SUMMARY_HOST'),
    'summary_user' => env('SUMMARY_USER'),
    'summary_pass' => env('SUMMARY_PASS'),

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | Laravel 11+ does not ship a static alias list in this file any more, but
    | RegisterFacades() still reads app.aliases. The ijinnakes Blade views use
    | the short facade names (URL::, Auth::, DB::, ...) directly, so the
    | framework defaults are merged back in here plus the package aliases the
    | old app relied on.
    |
    */

    'aliases' => Facade::defaultAliases()->merge([
        'Captcha' => Captcha::class,
    ])->toArray(),

];