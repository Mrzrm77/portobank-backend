<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Repositories\Auth\VerifyEmailRepository;

class VerifyEmailService
{
    protected $repository;

    public function __construct(
        VerifyEmailRepository $repository
    ) {
        $this->repository = $repository;
    }

    public function verify(
        int $id,
        string $hash
    ): void
    {
        $user =
            $this->repository
                ->findUserById($id);

        if (
            ! hash_equals(
                sha1($user->email),
                $hash
            )
        ) {
            abort(
                403,
                'Invalid verification link.'
            );
        }

        if (
            ! $user->hasVerifiedEmail()
        ) {
            $this->repository
                ->markAsVerified($user);
        }
    }

    public function resend(
        User $user
    ): void
    {
        if (
            $user->hasVerifiedEmail()
        ) {
            abort(
                422,
                'Email already verified.'
            );
        }

        $this->repository
            ->sendVerificationEmail(
                $user
            );
    }
}