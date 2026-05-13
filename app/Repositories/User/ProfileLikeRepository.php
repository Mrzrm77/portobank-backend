<?php

namespace App\Repositories\User;

use App\Models\Like;
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

    public function like(
        Profile $profile,
        $user
    ): Like {
        return Like::firstOrCreate([
            'profile_id' => $profile->id,
            'user_id'    => $user->id,
        ]);
    }

    public function unlike(
        Profile $profile,
        $user
    ): void {
        Like::where(
                'profile_id',
                $profile->id
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

        return Like::where(
                'profile_id',
                $profile->id
            )->where(
                'user_id',
                $user->id
            )->exists();
    }
}