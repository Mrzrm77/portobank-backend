<?php

namespace App\Repositories\Auth;

use App\Models\User;
use App\Models\Profile;

class AuthRepository
{
    public function createUser(
        array $data
    ) {

        return User::create([

            'email'=> $data['email'],
            'password'=> $data['password']
        ]);

    }

    public function createProfile(
        $user,
        array $data
    ) {

        return Profile::create([

            'user_id'=> $user->id,

            'is_active'=> true,

            'is_public'=> true
        ]);

    }

    public function findByEmail(
        string $email
    ) {

        return User::where(
            'email',$email
        )->first();

    }
}