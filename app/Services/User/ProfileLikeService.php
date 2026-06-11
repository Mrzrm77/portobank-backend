<?php

namespace App\Services\User;

use App\Repositories\User\ProfileLikeRepository;
use App\Repositories\Public\PortfolioRepository;

class ProfileLikeService
{
    protected $repo;

    public function __construct(
        ProfileLikeRepository $repo,
        PortfolioRepository $publicRepo
    ) {
        $this->repo = $repo;
        $this->publicRepo = $publicRepo;
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
        $viewer = null
    ): array {
    
        $profile = $this->publicRepo
            ->findProfileForViewer(
                $username,
                $viewer
            );
    
        return [
            'likes_count' => $this->repo
                ->getLikesCount($profile),
    
            'is_liked' => $this->repo
                ->isLikedByUser(
                    $profile,
                    $viewer
                ),
        ];
    }

    public function getTopLikedProfiles(int $limit = 6, ?int $viewerId = null)
    {
        return $this->repo->getTopLikedProfiles($limit, $viewerId);
    }
}