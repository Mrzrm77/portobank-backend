<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Hash;

use App\Repositories\Auth\AuthRepository;

class AuthService
{
    protected $authRepository;

    public function __construct(
        AuthRepository $authRepository
    ) {

        $this->authRepository =
            $authRepository;

    }

    public function register(
        array $data
    ) {

        $user =
            $this->authRepository
                ->createUser($data);

        $this->authRepository
            ->createProfile(
                $user,
                $data
            );

        if (method_exists($user, 'sendEmailVerificationNotification')) {
            $user->sendEmailVerificationNotification();
        }

        $token =
            $user->createToken(
                'auth_token'
            )->plainTextToken;

        return [

            'user' => $user
                ->load('profile'),

            'token' => $token

        ];

    }

    public function login(
        array $data
    ) {

        $user =
            $this->authRepository
                ->findByEmail(
                    $data['email']
                );

        if (

            ! $user ||

            ! Hash::check(

                $data['password'],

                $user->password

            )

        ) {

            abort(
                401,
                'Invalid credentials'
            );

        }

        if ($user->email_verified_at === null) {
            abort(403, 'Please verify your email before logging in.');
        }

        $token =
            $user->createToken(
                'auth_token'
            )->plainTextToken;

        return [

            'user' => $user
                ->load('profile'),

            'token' => $token

        ];

    }

    public function logout(
        $user
    ) {

        $user->currentAccessToken()
            ->delete();

    }
}