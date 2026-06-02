<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;

use App\Services\Auth\AuthService;

class LogoutController extends Controller
{
    public function __invoke(
        AuthService $authService
    ) {

        $authService->logout(
            auth()->user()
        );

        return response()->json([

            'success' => true,

            'message' => 'Logout success',

            'data' => auth()->user()

        ]);

    }
}