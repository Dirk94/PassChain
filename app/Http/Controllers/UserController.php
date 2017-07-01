<?php

namespace App\Http\Controllers;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller {

    public function home(Request $request) {
        $user = $request->user;

        return response()->json([
            'name' => $user->name
        ]);
    }

}
