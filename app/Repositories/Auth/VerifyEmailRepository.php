<?php

namespace App\Repositories\Auth;

use App\Models\User;

class VerifyEmailRepository
{
    public function findUserById(
        int $id
    ): User
    {
        return User::findOrFail($id);
    }

    public function markAsVerified(
        User $user
    ): void
    {
        $user->markEmailAsVerified();
    }

    public function sendVerificationEmail(
        User $user
    ): void
    {
        $user->sendEmailVerificationNotification();
    }
}