<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\PortfolioItem\StorePortfolioItemRequest;
use App\Http\Requests\User\PortfolioItem\UpdatePortfolioItemRequest;
use App\Services\User\PortfolioItemService;

class PortfolioItemController extends Controller
{
    public function index(PortfolioItemService $service)
    {
        $items = $service->index(auth()->user());

        // Format URL agar bisa langsung dibaca Frontend
        $items->transform(function ($item) {
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

        return response()->json([
            'success' => true,
            'data' => $items
        ]);
    }

    public function store(
        StorePortfolioItemRequest $request,
        PortfolioItemService $service
    ) {
        $data = $request->validated();

        // Tangkap file cover_url tunggal
        if ($request->hasFile('cover_file')) {
            $data['cover_file'] = $request->file('cover_file');
        }

        // Tangkap multiple file untuk gallery_images
        if ($request->hasFile('gallery_files')) {
            $data['gallery_files'] = $request->file('gallery_files');
        }

        $item = $service->create(auth()->user(), $data);

        return response()->json([
            'success' => true,
            'message' => 'Portfolio item created successfully',
            'data' => $item
        ], 201);
    }

    public function show(
        int $id,
        PortfolioItemService $service
    ) {
        $item = $service->show(auth()->user(), $id);

        if ($item) {
            if ($item->cover_url && !str_starts_with($item->cover_url, 'http')) {
                $item->cover_url = asset('storage/' . $item->cover_url);
            }
            
            if (!empty($item->gallery_images) && is_array($item->gallery_images)) {
                $item->gallery_images = array_map(function ($image) {
                    return !str_starts_with($image, 'http') ? asset('storage/' . $image) : $image;
                }, $item->gallery_images);
            }
        }

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
        $data = $request->validated();

        // Tangkap file cover baru jika ada
        if ($request->hasFile('cover_file')) {
            $data['cover_file'] = $request->file('cover_file');
        }

        // Tangkap file gallery baru jika ada
        if ($request->hasFile('gallery_files')) {
            $data['gallery_files'] = $request->file('gallery_files');
        }

        $item = $service->update(auth()->user(), $id, $data);

        return response()->json([
            'success' => true,
            'message' => 'Portfolio item updated successfully',
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
            'message' => 'Portfolio item deleted successfully'
        ]);
    }
}