<?php

namespace App\Http\Middleware;

use App\Models\UserModel;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| AuthBasic
|--------------------------------------------------------------------------
|
| HTTP Basic authentication against the legacy `users` table (username +
| md5(password)), as used by the ijinnakes API routes. Attached to the "api"
| middleware group in bootstrap/app.php.
|
*/

class AuthBasic
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authorization = $request->header('Authorization');

        // PHP 8: base64_decode(null) is deprecated, so the guard clause runs
        // before the header is decoded (ijinnakes decoded it first).
        if (empty($authorization)) {
            return response()->json(['resp_code' => '401', 'resp_desc' => 'Unauthorized User'], 401);
        }

        $credentials = explode(':', (string) base64_decode(ltrim($authorization, 'Basic ')));

        $user = (new UserModel)->GetUser(
            $credentials[0] ?? '',
            md5($credentials[1] ?? '')
        );

        if ($user) {
            return $next($request);
        }

        return response()->json(['resp_code' => '401', 'resp_desc' => 'User Not Found'], 401);
    }
}