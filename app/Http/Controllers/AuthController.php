<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginPostRequest;
use App\Http\Requests\Auth\RegisterPostRequest;
use App\Services\Auth\AuthService;

class AuthController extends Controller
{
    //
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterPostRequest $request)
    {
        $token = $this->authService->Create($request);
        $result = [
            'access_token' => $token,
            'token_type' => 'Bearer',
        ];

        return response()->json([
            $result, 200,
        ]);
    }

    public function login(LoginPostRequest $request)
    {
        $result = $this->authService->Login($request);
        if ($result['success']) {
            return response()->json([
                $result, 200,
            ]);
        } else {
            return response()->json([
                $result, 400,
            ]);
        }
    }
}
