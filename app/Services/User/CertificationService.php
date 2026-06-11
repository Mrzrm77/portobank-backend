<?php

namespace App\Services\User;

use App\Repositories\User\CertificationRepository;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class CertificationService
{
    protected $repo;

    public function __construct(CertificationRepository $repo)
    {
        $this->repo = $repo;
    }

    public function get(User $user)
    {
        return $this->repo->getByUser($user);
    }

    public function store(User $user, array $data)
    {
        // Cek jika ada file gambar yang diupload
        if (isset($data['certificate_file'])) {
            $path = $data['certificate_file']->store('certificates', 'public');
            $data['certificate_url'] = $path; // Set path ke database
            unset($data['certificate_file']); // Hapus object file dari array data
        }

        return $this->repo->create($user, $data);
    }

    public function update(User $user, $id, array $data)
    {
        $certification = $this->repo->findById($user, $id);

        if ($certification->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        // Cek jika ada file gambar baru yang diupload
        if (isset($data['certificate_file'])) {
            // Hapus file lama jika ada
            if ($certification->certificate_url) {
                Storage::disk('public')->delete($certification->certificate_url);
            }

            // Simpan file baru
            $path = $data['certificate_file']->store('certificates', 'public');
            $data['certificate_url'] = $path;
            unset($data['certificate_file']);
        }

        return $this->repo->update($certification, $data);
    }

    public function delete(User $user, $id)
    {
        $certification = $this->repo->findById($user, $id);

        if ($certification->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        if ($certification->certificate_url){
            Storage::disk('public')->delete($certification->certificate_url);
        }

        return $this->repo->delete($certification);
    }
}