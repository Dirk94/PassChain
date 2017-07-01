<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JWTAuth {

    public function handle($request, Closure $next) {
        try {
            $token = \JWTAuth::getToken();
            $request->user = \JWTAuth::toUser($token);
        } catch(JWTException $ex) {
            if ($ex instanceof TokenInvalidException) {
                return response()->json(['error' => 'Token is invalid.'], 401);
            }
            if ($ex instanceof TokenExpiredException) {
                return response()->json(['error' => 'Token has expired.'], 401);
            }
        }

        return $next($request);
    }
}
