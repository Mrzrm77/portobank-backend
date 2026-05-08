<?php

namespace App\Services\User;

use App\Repositories\User\CertificationRepository;
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

    public function update(User $user, $id, array $data)
    {
        $certification = $this->repo->findById($id);

        if ($certification->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        return $this->repo->update($certification, $data);
    }

    public function delete(User $user, $id)
    {
        $certification = $this->repo->findById($id);

        if ($certification->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        return $this->repo->delete($certification);
    }
}