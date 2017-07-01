<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Closure;

class PasswordPermission {

    public function handle(Request $request, Closure $next) {
        $token = \JWTAuth::getToken();
        $user = \JWTAuth::toUser($token);

        $passwordObject = $request->passwordObject;

        if ($passwordObject->user_id != $user->id) {
            return response()->json([
                'error' => 'You don\'t have permission to change this password.'
            ], 403);
        }

        return $next($request);
    }

}
