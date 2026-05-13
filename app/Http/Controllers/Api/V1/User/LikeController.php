<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Services\User\ProfileLikeService;

class LikeController extends Controller
{
    public function like(
        string $username,
        ProfileLikeService $service
    ) {
        $data = $service->like(
            $username,
            auth()->user()
        );

        return response()->json([
            'success' => true,
            'message' => 'Profile liked.',
            'data'    => $data,
        ]);
    }

    public function unlike(
        string $username,
        ProfileLikeService $service
    ) {
        $data = $service->unlike(
            $username,
            auth()->user()
        );

        return response()->json([
            'success' => true,
            'message' => 'Profile unliked.',
            'data'    => $data,
        ]);
    }

    public function stats(
        string $username,
        ProfileLikeService $service
    ) {
        $data = $service->getStats(
            $username,
            auth()->user()
        );

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }
}