<?php

namespace App\Services\User;

use App\Repositories\User\EducationRepository;
use App\Models\User;

class EducationService
{
    protected $repo;

    public function __construct(EducationRepository $repo)
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
        $education = $this->repo->findById($id);

        if ($education->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        return $this->repo->update($education, $data);
    }

    public function delete(User $user, $id)
    {
        $education = $this->repo->findById($id);

        if ($education->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        return $this->repo->delete($education);
    }
}