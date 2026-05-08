<?php

namespace App\Services\User;

use App\Repositories\User\ExperienceRepository;
use App\Models\User;

class ExperienceService
{
    protected $repo;

    public function __construct(ExperienceRepository $repo)
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
        $experience = $this->repo->findById($id);

        if ($experience->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        return $this->repo->update($experience, $data);
    }

    public function delete(User $user, $id)
    {
        $experience = $this->repo->findById($id);

        if ($experience->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        return $this->repo->delete($experience);
    }
}