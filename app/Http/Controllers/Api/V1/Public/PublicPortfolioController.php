<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Public\PortfolioService;

class PublicPortfolioController extends Controller
{
    public function show(
        string $username,
        PortfolioService $service
    ) {

        return response()->json([

            'success' => true,

            'data' =>
                $service->getPortfolio(
                    $username
                )

        ]);
    }

    public function projects(
        string $username,
        PortfolioService $service
    ) {

        return response()->json([

            'success' => true,

            'data' =>
                $service->getProjects(
                    $username
                )

        ]);
    }

    public function projectDetail(
        string $username,
        int $projectId,
        PortfolioService $service
    ) {

        return response()->json([

            'success' => true,

            'data' =>
                $service->getProjectDetail(
                    $username,
                    $projectId
                )

        ]);
    }
}
