<?php

namespace App\Http\Controllers;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller {

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error' => 'Invalid credentials.'
                ], 401);
            }
        } catch(JWTException $ex) {
            return response()->json([
                'error'=> 'Could not create token.'
            ], 500);
        }

        $user = JWTAuth::toUser($token);
        return response()->json([
            'token' => $token,
            'name' => $user->name,
            'email' => $user->email
        ]);
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users,email|min:3|max:255',
            'password' => 'required|min:6|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'token' => $token,
            'name' => $user->name,
            'email' => $user->email
        ]);
    }

}
