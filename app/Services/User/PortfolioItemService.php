<?php

namespace App\Services\User;

use App\Repositories\User\PortfolioItemRepository;
use Illuminate\Support\Facades\Storage;

class PortfolioItemService
{
    protected PortfolioItemRepository $repository;

    public function __construct(
        PortfolioItemRepository $repository
    ) {
        $this->repository = $repository;
    }

    public function index($user)
    {
        return $this->repository->getUserPortfolioItems($user);
    }

    public function create($user, array $data)
    {
        return $this->repository->create($user, $data);
    }

    public function show($user, int $id)
    {
        return $this->repository->findUserPortfolioItem($user, $id);
    }

    public function update($user, int $id, array $data)
    {
        $item = $this->repository->findUserPortfolioItem($user, $id);

        return $this->repository->update($item, $data);
    }

    public function delete($user, int $id)
    {
        $item = $this->repository->findUserPortfolioItem($user, $id);

        if ($item->cover_url) {
            Storage::disk('public')->delete($item->cover_url);
        }

        return $this->repository->delete($item);
    }

    public function uploadCover($user, int $itemId, $file)
    {
        $item = $this->repository->findUserPortfolioItem($user, $itemId);

        if ($item->cover_url) {
            Storage::disk('public')->delete($item->cover_url);
        }

        $path = $file->store('portfolio-item-covers', 'public');

        return $this->repository->update($item, [
            'cover_url' => $path
        ]);
    }

    public function uploadGallery($user, int $itemId, array $files)
    {
        $item = $this->repository->findUserPortfolioItem($user, $itemId);

        $galleryImages = $item->gallery_images ?? [];

        foreach ($files as $file) {
            $path = $file->store('portfolio-item-gallery', 'public');
            $galleryImages[] = $path;
        }

        return $this->repository->update($item, [
            'gallery_images' => $galleryImages
        ]);
    }
}
