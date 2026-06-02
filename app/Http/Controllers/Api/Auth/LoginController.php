<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;

use App\Http\Requests\Auth\LoginRequest;

use App\Services\Auth\AuthService;

class LoginController extends Controller
{
    public function __invoke(
        LoginRequest $request,
        AuthService $authService
    ) {

        $result = $authService->login(
            $request->validated()
        );

        return response()->json([

            'success' => true,

            'message' => 'Login success',

            'data' => $result

        ]);

    }
}