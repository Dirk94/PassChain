<?php

namespace App\Http\Controllers;

use App\Password;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class PasswordController extends Controller {

    public function all(Request $request) {
        $user = $request->user;

        return response()->json([
            'passwords' => $user->passwords()->get(['id', 'url', 'username', 'password'])
        ]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'url' => 'required|max:255',
            'username' => 'required|max:255',
            'password' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $user = $request->user;

        $password = $user->passwords()->create([
            'url' => $request->input('url'),
            'username' => $request->input('username'),
            'password' => $request->input('password')
        ]);

        return response()->json([
            "id" => $password->id
        ]);
    }

    public function delete(Password $passwordObject) {
        $passwordObject->delete();
        return response()->json();
    }

    public function update(Password $passwordObject, Request $request) {
        $validator = Validator::make($request->all(), [
            'url' => 'required|max:255',
            'username' => 'required|max:255',
            'password' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $passwordObject->url = $request->input('url');
        $passwordObject->username = $request->input('username');
        $passwordObject->password = $request->input('password');
        $passwordObject->save();

        return response()->json([
            "id" => $passwordObject->id
        ]);
    }

}
