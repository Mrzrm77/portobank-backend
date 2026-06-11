<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\VerifyEmailService;
use Illuminate\Http\Request;

class ResendVerificationEmailController extends Controller
{
    public function __invoke(
        Request $request,
        VerifyEmailService $service
    ) {

        $service->resend(
            $request->user()
        );

        return response()->json([
            'success' => true,
            'message' =>
                'Verification email sent.'
        ]);
    }
}