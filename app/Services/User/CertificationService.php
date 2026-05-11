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
        return $this->repo->create($user, $data);
    }

    public function uploadImage(
        $user,
        int $id,
        $file
    ) {
        $certification = $this->repo
            ->findById($user, $id);

        // hapus file lama jika ada
        if ($certification->certificate_url) {
            Storage::disk('public')
                ->delete($certification->certificate_url);
        }

        // simpan file baru
        $path = $file->store(
            'certificates',
            'public'
        );

        return $this->repo
            ->update(
                $certification,
                [
                    'certificate_url' => $path,
                ]
            );
    }

    public function update(User $user, $id, array $data)
    {
        $certification = $this->repo->findById($user, $id);

        if ($certification->user_id !== $user->id) {
            abort(403, 'Unauthorized');
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