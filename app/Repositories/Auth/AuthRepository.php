<?php

namespace App\Repositories\Auth;

use App\Models\User;
use App\Models\Profile;
use App\Models\Portfolio;

class AuthRepository
{
    public function createUser(
        array $data
    ) {

        $user = User::create([

            'email' => $data['email'],
            'password' => $data['password'],

        ]);

        $user->markEmailAsVerified();
        return $user;

    }

    public function createProfile(
        $user,
        array $data
    ) {

        $profile = Profile::create([

            'user_id' => $user->id,
            'username' => $data['username'] ?? null,
            'full_name' => $data['full_name'] ?? null,
            'is_active' => true,
            'is_public' => false,

        ]);

        // Ensure the user has a portfolio record created when their profile is created.
        Portfolio::firstOrCreate([
            'user_id' => $user->id,
        ], [
            'title' => 'Portfolio',
            'description' => null,
            'view_count' => 0,
        ]);

        return $profile;

    }

    public function findByEmail(
        string $email
    ) {

        return User::where(
            'email',$email
        )->first();

    }
}