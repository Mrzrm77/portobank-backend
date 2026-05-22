<?php

namespace App\Services\Auth;

use App\Repositories\Auth\PasswordResetRepository;
use Illuminate\Support\Hash;

class PasswordResetService
{
    protected $repository;

    public function __construct(PasswordResetRepository $repository)
    {
        $this->repository = $repository;
    }

    public function requestReset(array $data): string
    {
        $user = $this->repository->findUserByEmail($data['email']);

        if (! $user) {
            abort(404, 'User not found.');
        }

        return $this->repository->createToken($data['email']);
    }

    public function resetPassword(array $data): void
    {
        $entry = $this->repository->findByToken($data['token']);

        if (! $entry || $entry->email !== $data['email']) {
            abort(422, 'Invalid token or email.');
        }

        if (now()->subMinutes(60)->gt($entry->created_at)) {
            abort(422, 'Token expired.');
        }

        $user = $this->repository->findUserByEmail($data['email']);

        if (! $user) {
            abort(404, 'User not found.');
        }

        $user->password = $data['password'];
        $user->save();

        $this->repository->deleteToken($data['email']);
    }
}
