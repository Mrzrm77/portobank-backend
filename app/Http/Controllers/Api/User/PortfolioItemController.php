<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\PortfolioItem\StorePortfolioItemRequest;
use App\Http\Requests\User\PortfolioItem\UpdatePortfolioItemRequest;
use App\Http\Requests\User\PortfolioItem\UploadPortfolioItemCoverRequest;
use App\Http\Requests\User\PortfolioItem\UploadPortfolioItemGalleryRequest;
use App\Services\User\PortfolioItemService;

class PortfolioItemController extends Controller
{
    public function index(
        PortfolioItemService $service
    ) {
        return response()->json([
            'success' => true,
            'data' => $service->index(auth()->user())
        ]);
    }

    public function store(
        StorePortfolioItemRequest $request,
        PortfolioItemService $service
    ) {
        $item = $service->create(
            auth()->user(),
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Portfolio item created',
            'data' => $item
        ], 201);
    }

    public function show(
        int $id,
        PortfolioItemService $service
    ) {
        $item = $service->show(auth()->user(), $id);

        return response()->json([
            'success' => true,
            'data' => $item
        ]);
    }

    public function update(
        int $id,
        UpdatePortfolioItemRequest $request,
        PortfolioItemService $service
    ) {
        $item = $service->update(
            auth()->user(),
            $id,
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Portfolio item updated',
            'data' => $item
        ]);
    }

    public function destroy(
        int $id,
        PortfolioItemService $service
    ) {
        $service->delete(auth()->user(), $id);

        return response()->json([
            'success' => true,
            'message' => 'Portfolio item deleted'
        ]);
    }

    public function uploadCover(
        UploadPortfolioItemCoverRequest $request,
        PortfolioItemService $service,
        int $id
    ) {
        $item = $service->uploadCover(
            auth()->user(),
            $id,
            $request->file('cover')
        );

        return response()->json([
            'success' => true,
            'message' => 'Portfolio item cover uploaded',
            'data' => $item
        ]);
    }

    public function uploadGallery(
        UploadPortfolioItemGalleryRequest $request,
        PortfolioItemService $service,
        int $id
    ) {
        $item = $service->uploadGallery(
            auth()->user(),
            $id,
            $request->file('gallery_images')
        );

        return response()->json([
            'success' => true,
            'message' => 'Portfolio item gallery images uploaded',
            'data' => $item
        ]);
    }
}
