<?php

namespace App\Services\User;

use App\Repositories\User\SocialRepository;
use App\Models\User;

class SocialService
{
    protected $repo;

    public function __construct(SocialRepository $repo)
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
        $social = $this->repo->findById($id);

        if ($social->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        return $this->repo->update($social, $data);
    }

    public function delete(User $user, $id)
    {
        $social = $this->repo->findById($id);

        if ($social->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        return $this->repo->delete($social);
    }
}