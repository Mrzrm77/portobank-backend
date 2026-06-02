<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Report\StoreReportRequest;
use App\Http\Requests\Report\UpdateReportStatusRequest;
use App\Services\Report\ReportService;

class ReportController extends Controller
{
    public function store(
        StoreReportRequest $request,
        ReportService $service
    ) {
        $report = $service->createReport(array_merge(
            $request->validated(),
            ['reporter_id' => auth()->user()->id, 'status' => 'pending']
        ));

        return response()->json([
            'success' => true,
            'message' => 'Report submitted successfully.',
            'data' => $report,
        ]);
    }

    public function index(
        ReportService $service
    ) {
        return response()->json([
            'success' => true,
            'data' => $service->getAllReports(),
        ]);
    }

    public function updateStatus(
        int $id,
        UpdateReportStatusRequest $request,
        ReportService $service
    ) {
        $report = $service->updateReportStatus(
            $id,
            $request->validated()['status']
        );

        return response()->json([
            'success' => true,
            'message' => 'Report status updated.',
            'data' => $report,
        ]);
    }
}
