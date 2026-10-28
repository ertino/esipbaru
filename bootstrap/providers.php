<?php

/*
|--------------------------------------------------------------------------
| Application service providers
|--------------------------------------------------------------------------
|
| Package providers (Sanctum, Socialite, mews/captcha, Carbon) are discovered
| automatically through composer's package manifest. Only the application
| providers from ijinnakes/config/app.php are registered here.
|
| App\Providers\RouteServiceProvider and App\Providers\BroadcastServiceProvider
| are intentionally not registered:
|   - routing is now declared in bootstrap/app.php (withRouting)
|   - broadcasting was already disabled in ijinnakes (provider commented out)
|
*/

use App\Providers\AppServiceProvider;
use App\Providers\AuthServiceProvider;
use App\Providers\EventServiceProvider;

return [
    AppServiceProvider::class,
    AuthServiceProvider::class,
    EventServiceProvider::class,
];