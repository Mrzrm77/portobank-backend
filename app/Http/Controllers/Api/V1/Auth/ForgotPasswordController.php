<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Services\Auth\PasswordResetService;

class ForgotPasswordController extends Controller
{
    public function __invoke(
        ForgotPasswordRequest $request,
        PasswordResetService $service
    ) {
        $token = $service->requestReset(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Password reset token generated.',
            'data' => [
                'token' => $token,
            ],
        ]);
    }
}
