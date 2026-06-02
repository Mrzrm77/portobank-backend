<?php

namespace App\Services\Admin;

use App\Repositories\Admin\UserRepository;

class UserService
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listUsers(array $filters = [])
    {
        return $this->repository->all($filters);
    }

    public function setUserStatus(int $userId, bool $active)
    {
        $profile = $this->repository->findByUserId($userId);

        if (! $profile) {
            abort(404, 'User profile not found.');
        }

        return $this->repository->updateStatus($profile, $active);
    }

    public function deleteUser(int $userId)
    {
        $this->repository->deleteUserByUserId($userId);
    }
}
