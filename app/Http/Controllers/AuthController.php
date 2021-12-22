<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends ApiController
{
    // public function register(NewUserRequest $request)
    // {
    //     $attributes = $request->validated();
    //     $attributes['password'] = Hash::make($attributes['password']);
    //     $user = User::create($attributes);
    //     return (new UserResource($user))
    //         ->response()
    //         ->setStatusCode(201);
    // }

    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return $this->respondError(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token, $request->email);
    }

    protected function respondWithToken($token, $email)
    {
        $user = User::select('menuroles as roles')->where('email', '=', $email)->first();

        $res = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'roles' => $user->roles,
        ];

        return $this->apiResponse($res);
    }
}
