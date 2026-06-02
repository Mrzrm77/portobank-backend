<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminLogService;
use Illuminate\Http\Request;

class AdminLogController extends Controller
{
    public function index(Request $request, AdminLogService $service)
    {
        $logs = $service->listLogs([
            'action' => $request->query('action'),
            'from' => $request->query('from'),
            'to' => $request->query('to'),
        ]);

        return response()->json([
            'success' => true,
            'data' => $logs,
        ]);
    }
}
