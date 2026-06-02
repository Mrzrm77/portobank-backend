<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request, UserService $service)
    {
        $users = $service->listUsers([
            'search' => $request->query('search'),
            'status' => $request->query('status'),
        ]);

        return response()->json([
            'success' => true,
            'data' => $users,
        ]);
    }

    public function updateStatus(int $userId, Request $request, UserService $service)
    {
        $active = $request->boolean('active');
        $profile = $service->setUserStatus($userId, $active);

        return response()->json([
            'success' => true,
            'message' => $active ? 'User activated.' : 'User suspended.',
            'data' => $profile,
        ]);
    }

    public function destroy(int $userId, UserService $service)
    {
        $service->deleteUser($userId);

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully.',
        ]);
    }
}
