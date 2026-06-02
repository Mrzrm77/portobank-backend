<?php

namespace App\Repositories\User;

use App\Models\Like;
use App\Models\Portfolio;
use App\Models\Profile;

class ProfileLikeRepository
{
    public function findPublicProfile(
        string $username
    ): Profile {
      return Profile::where(
                'username',
                $username
            )
            ->where('is_public', true)
            ->where('is_active', true)
            ->firstOrFail();
    }

    protected function getPortfolioForProfile(Profile $profile): Portfolio
    {
        return Portfolio::where('user_id', $profile->user_id)->firstOrFail();
    }

    public function like(
        Profile $profile,
        $user
    ): Like {
        $portfolio = $this->getPortfolioForProfile($profile);

        return Like::firstOrCreate([
            'portfolio_id' => $portfolio->id,
            'user_id'      => $user->id,
        ]);
    }

    public function unlike(
        Profile $profile,
        $user
    ): void {
        $portfolio = $this->getPortfolioForProfile($profile);

        Like::where(
                'portfolio_id',
                $portfolio->id
            )->where(
                'user_id',
                $user->id
            )->delete();
    }

    public function getLikesCount(
        Profile $profile
    ): int {
        return $profile->likes()->count();
    }

    public function isLikedByUser(
        Profile $profile,
        $user = null
    ): bool {
        if (! $user) {
            return false;
        }

        $portfolio = $this->getPortfolioForProfile($profile);

        return Like::where(
                'portfolio_id',
                $portfolio->id
            )->where(
                'user_id',
                $user->id
            )->exists();
    }

    public function getTopLikedProfiles(int $limit = 6)
    {
        return Profile::with(['skills'])
            ->where('is_public', true)
            ->where('is_active', true)
            ->whereHas('user', function ($query) {
                $query->where('role', '!=', 'admin');
            })
            ->withCount('likes')
            ->orderByDesc('likes_count')
            ->limit($limit)
            ->get();
    }
}