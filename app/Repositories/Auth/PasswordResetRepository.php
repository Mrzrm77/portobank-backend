<?php

namespace App\Repositories\Auth;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PasswordResetRepository
{
    public function createToken(string $email): string
    {
        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert([
            'email' => $email,
        ], [
            'token' => $token,
            'created_at' => now(),
        ]);

        return $token;
    }

    public function findByToken(string $token)
    {
        return DB::table('password_reset_tokens')
            ->where('token', $token)
            ->first();
    }

    public function deleteToken(string $email): void
    {
        DB::table('password_reset_tokens')->where('email', $email)->delete();
    }

    public function findUserByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }
}
