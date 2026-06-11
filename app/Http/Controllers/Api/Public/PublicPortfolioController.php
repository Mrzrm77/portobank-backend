<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Public\PortfolioService;

class PublicPortfolioController extends Controller
{
    public function show(
        string $username,
        PortfolioService $service
    ) {
        $authUser = auth('sanctum')->user();
        
        $portfolio = $service->getPortfolio($username,$authUser);
        
        if ($portfolio->avatar_url) {
            $portfolio->avatar_url = asset('storage/' . $portfolio->avatar_url);
        }

        if ($portfolio->user && $portfolio->user->certifications) {
            $portfolio->user->certifications->transform(function ($cert) {
                if ($cert->certificate_url && !str_starts_with($cert->certificate_url, 'http')) {
                    $cert->certificate_url = asset('storage/' . $cert->certificate_url);
                }
                return $cert;
            });
        }

        if ($portfolio->user->portfolio->items) {
            $portfolio->user->portfolio->items->transform(function ($item) {
                if ($item->cover_url && !str_starts_with($item->cover_url, 'http')) {
                    $item->cover_url = asset('storage/' . $item->cover_url);
                }
                
                // Format array gallery_images jika ada
                if (!empty($item->gallery_images) && is_array($item->gallery_images)) {
                    $item->gallery_images = array_map(function ($image) {
                        return !str_starts_with($image, 'http') ? asset('storage/' . $image) : $image;
                    }, $item->gallery_images);
                }
            
                return $item;
            });
        }

        return response()->json([

            'success' => true,

            'data' =>
                $portfolio,
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

    public function portfolioItems(
        string $username,
        PortfolioService $service
    ) {

        return response()->json([
            'success' => true,
            'data' => $service->getPortfolioItems($username),
        ]);
    }

    public function portfolioItemDetail(
        string $username,
        int $itemId,
        PortfolioService $service
    ) {

        return response()->json([
            'success' => true,
            'data' => $service->getPortfolioItemDetail($username, $itemId),
        ]);
    }

    public function certificates(
        string $username,
        PortfolioService $service
    ) {

        return response()->json([

            'success' => true,

            'data' =>
                $service->getCertificates(
                    $username
                )

        ]);
    }

    public function certificateDetail(
        string $username,
        int $certificateId,
        PortfolioService $service
    ) {

        return response()->json([

            'success' => true,

            'data' =>
                $service->getCertificateDetail(
                    $username,
                    $certificateId
                )

        ]);
    }
}
