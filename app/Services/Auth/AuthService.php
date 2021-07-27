<?php

namespace App\Services\Auth;

use App\Http\Requests\Auth\LoginPostRequest;
use App\Http\Requests\Auth\RegisterPostRequest;
use App\Models\User;
use Auth;
use Hash;

class AuthService
{
    public function Create(RegisterPostRequest $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);

        $token = $user->createToken('auth_token')->plainTextToken;
        return $token;
    }

    public function Login(LoginPostRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['name'] = $user->name;
            $success['success'] = true;

            return $success;
        } else {
            $fail['success'] = false;
            $fail['message'] = 'unauthorized.';
            $fail['error'] = 'unauthorized';

            return $fail;
        }

    }
}
