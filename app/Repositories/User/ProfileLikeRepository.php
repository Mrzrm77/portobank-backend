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

    protected function getPortfolioForProfile(Profile $profile): ?Portfolio
    {
        return Portfolio::where('user_id', $profile->user_id)->first();
    }


    public function findProfileForViewer(
        string $username,
        $authUser = null
    ): Profile {
        $profile = Profile::where(
                'username',
                $username
            )
            ->where('is_active', true)
            ->firstOrFail();
        
        // owner boleh melihat profile private
        if (
            $authUser &&
            $profile->user_id === $authUser->id
        ) {
            return $profile;
        }
    
        if (! $profile->is_public) {
            abort(404);
        }
    
        return $profile;
    }

    public function like(
        Profile $profile,
        $user
    ): Like {
        $portfolio = $this->getPortfolioForProfile($profile);

        if (! $portfolio) {
            abort(404, 'Portfolio not found.');
        }

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

        if (! $portfolio) {
            return;
        }

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

        if (! $portfolio) {
            return false;
        }

        return Like::where(
                'portfolio_id',
                $portfolio->id
            )->where(
                'user_id',
                $user->id
            )->exists();
    }

    public function getTopLikedProfiles(int $limit = 6, ?int $viewerId = null)
    {
        $query = Profile::with(['skills'])
            ->where('is_public', true)
            ->where('is_active', true)
            ->whereHas('user', function ($query) {
                $query->where('role', '!=', 'admin');
            })
            ->withCount('likes')
            ->orderByDesc('likes_count')
            ->limit($limit);

        if ($viewerId) {
            $query->selectRaw(
                'profiles.*,
                (exists(select 1 from likes join portfolios on likes.portfolio_id = portfolios.id where portfolios.user_id = profiles.user_id and likes.user_id = ?)) as liked_by_me',
                [$viewerId]
            );
        }

        return $query->get()->map(function ($profile) {
            $profile->likes_count = $profile->likes_count ?? 0;
            $profile->liked_by_me = isset($profile->liked_by_me)
                ? (bool) $profile->liked_by_me
                : false;
            return $profile;
        });
    }
}