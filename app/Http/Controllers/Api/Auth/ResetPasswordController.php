<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\Auth\PasswordResetService;

class ResetPasswordController extends Controller
{
    public function __invoke(
        ResetPasswordRequest $request,
        PasswordResetService $service
    ) {
        $service->resetPassword(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Password has been reset successfully.',
        ]);
    }
}
