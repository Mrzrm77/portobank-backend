<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Auth\AuthService;
use App\Http\Requests\Auth\RegisterRequest;

class RegisterController extends Controller
{
    public function __invoke(
        RegisterRequest $request,
        AuthService $authService
    ) {

        $result = $authService->register(
            $request->validated()
        );

        return response()->json([

            'success' => true,

            'message' => 'Register success',

            'data' => $result

        ], 201);
    }
}
