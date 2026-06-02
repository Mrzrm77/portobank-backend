<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Notification\NotificationService;

class NotificationController extends Controller
{
    public function index(NotificationService $service)
    {
        return response()->json([
            'success' => true,
            'data' => $service->getNotifications(auth()->user()),
        ]);
    }

    public function markAllRead(NotificationService $service)
    {
        $service->markAllRead(auth()->user());

        return response()->json([
            'success' => true,
            'message' => 'Notifications marked as read.',
        ]);
    }
}
