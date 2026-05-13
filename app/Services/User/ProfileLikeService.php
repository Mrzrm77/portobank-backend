<?php

namespace App\Services\User;

use App\Repositories\User\ProfileLikeRepository;

class ProfileLikeService
{
    protected $repo;

    public function __construct(
        ProfileLikeRepository $repo
    ) {
        $this->repo = $repo;
    }

    public function like(
        string $username,
        $user
    ): array {
        $profile =
            $this->repo
                ->findPublicProfile(
                    $username
                );

        if ($profile->user_id === $user->id) {
            abort(
                422,
                'You cannot like your own profile.'
            );
        }

        $this->repo->like(
            $profile,
            $user
        );

        return [
            'likes_count' =>
                $this->repo
                    ->getLikesCount(
                        $profile
                    ),
            'is_liked' => true,
        ];
    }

    public function unlike(
        string $username,
        $user
    ): array {
        $profile =
            $this->repo
                ->findPublicProfile(
                    $username
                );

        $this->repo->unlike(
            $profile,
            $user
        );

        return [
            'likes_count' =>
                $this->repo
                    ->getLikesCount(
                        $profile
                    ),
            'is_liked' => false,
        ];
    }

    public function getStats(
        string $username,
        $user = null
    ): array {
        $profile =
            $this->repo
                ->findPublicProfile(
                    $username
                );

        return [
            'likes_count' =>
                $this->repo
                    ->getLikesCount(
                        $profile
                    ),
            'is_liked' =>
                $this->repo
                    ->isLikedByUser(
                        $profile,
                        $user
                    ),
        ];
    }
}