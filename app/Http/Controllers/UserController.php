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

    public function update(Request $request) {
        return response()->json(['error' => 'Token is invalid.'], 401);

        $validatorRules = [
            'name' => 'required|min:3|max:255'
        ];

        $user = $request->user;
        if ($user->email != $request->input('email')) {
            $validatorRules['email'] = 'required|email|unique:users,email|min:3|max:255';
        }

        $validator = Validator::make($request->all(), $validatorRules);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        return response()->json([
            'name' => $user->name,
            'email' => $user->email
        ]);
    }

}
