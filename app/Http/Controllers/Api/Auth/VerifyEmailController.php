<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\VerifyEmailService;

class VerifyEmailController extends Controller
{
    public function __invoke(
        int $id,
        string $hash,
        VerifyEmailService $service
    ) {

        $service->verify(
            $id,
            $hash
        );

        return response()->json([
            'success' => true,
            'message' =>
                'Email verified successfully.'
        ]);
    }
}