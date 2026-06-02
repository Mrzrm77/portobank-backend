<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePortfolioRequest;
use App\Services\Admin\PortfolioService;

class PortfolioController extends Controller
{
    public function index(PortfolioService $service)
    {
        return response()->json([
            'success' => true,
            'data' => $service->listPortfolios(),
        ]);
    }

    public function update(
        int $portfolioId,
        UpdatePortfolioRequest $request,
        PortfolioService $service
    ) {
        $portfolio = $service->updatePublication(
            $portfolioId,
            $request->validated()['is_published']
        );

        return response()->json([
            'success' => true,
            'message' => 'Portfolio visibility updated.',
            'data' => $portfolio,
        ]);
    }

    public function destroy(
        int $portfolioId,
        PortfolioService $service
    ) {
        $service->deletePortfolio($portfolioId);

        return response()->json([
            'success' => true,
            'message' => 'Portfolio deleted.',
        ]);
    }
}
