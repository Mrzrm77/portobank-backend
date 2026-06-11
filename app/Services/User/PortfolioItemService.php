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
        // 1. Upload Cover jika ada file yang dikirim
        if (isset($data['cover_file'])) {
            $data['cover_url'] = $data['cover_file']->store('portfolio-item-covers', 'public');
            unset($data['cover_file']); // Bersihkan object file dari array
        }

        // 2. Upload Gallery jika ada array file yang dikirim
        if (isset($data['gallery_files'])) {
            $galleryPaths = [];
            foreach ($data['gallery_files'] as $file) {
                $galleryPaths[] = $file->store('portfolio-item-gallery', 'public');
            }
            $data['gallery_images'] = $galleryPaths;
            unset($data['gallery_files']);
        }

        return $this->repository->create($user, $data);
    }

    public function show($user, int $id)
    {
        return $this->repository->findUserPortfolioItem($user, $id);
    }

    public function update($user, int $id, array $data)
    {
        $item = $this->repository->findUserPortfolioItem($user, $id);
        
        // 1. Logika Cover (Sama seperti sebelumnya)
        if (isset($data['cover_file'])) {
            if ($item->cover_url) $this->deleteFileFromStorage($item->cover_url);
            $data['cover_url'] = $data['cover_file']->store('portfolio-item-covers', 'public');
            unset($data['cover_file']);
        }
    
        // 2. Logika Gallery: Menimpa & Membersihkan
        $hasGalleryUpdate = 
            array_key_exists('gallery_images', $data) || 
            array_key_exists('gallery_files', $data);

        if ($hasGalleryUpdate){
            $oldStoredImages = $item->gallery_images ?? [];
        $newImages = [];    
    
        // A. Ambil gambar lama yang masih dikirim oleh frontend (dipertahankan)
        if (isset($data['gallery_images'])) {
            foreach ($data['gallery_images'] as $url) {
                $path = str_contains($url, '/storage/') ? explode('/storage/', $url)[1] : $url;
                $newImages[] = $path;
            }
        }
    
        // B. Tambahkan gambar baru (jika ada upload)
        if (isset($data['gallery_files'])) {
            foreach ($data['gallery_files'] as $file) {
                $newImages[] = $file->store('portfolio-item-gallery', 'public');
            }
            unset($data['gallery_files']);
        }
    
        // C. BANDINGKAN: Cari gambar yang ada di DB tapi tidak ada di $newImages (untuk dihapus)
        foreach ($oldStoredImages as $oldPath) {
            if (!in_array($oldPath, $newImages)) {
                $this->deleteFileFromStorage($oldPath);
            }
        }
    
        // D. Simpan hasil akhir
        $data['gallery_images'] = $newImages;

        }
    
        return $this->repository->update($item, $data);
    }

    private function deleteFileFromStorage($path)
    {
        // Pastikan path bukan URL (jika Model/Accessor memberikan URL)
        $cleanPath = str_contains($path, '/storage/') ? explode('/storage/', $path)[1] : $path;

        if (Storage::disk('public')->exists($cleanPath)) {
            Storage::disk('public')->delete($cleanPath);
        }
    }

    public function delete($user, int $id)
    {
        $item = $this->repository->findUserPortfolioItem($user, $id);

        // Hapus file Cover
        if ($item->cover_url) {
            Storage::disk('public')->delete($item->cover_url);
        }

        // Hapus semua file Gallery
        if (!empty($item->gallery_images) && is_array($item->gallery_images)) {
            foreach ($item->gallery_images as $image) {
                // Pastikan yang dihapus hanya path lokal, bukan URL eksternal (http)
                if (!str_starts_with($image, 'http')) {
                    Storage::disk('public')->delete($image);
                }
            }
        }

        return $this->repository->delete($item);
    }
}