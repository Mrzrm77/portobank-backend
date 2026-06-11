<?php

namespace App\Repositories\Admin;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    public function all(array $filters = []): Collection
    {
        $query = Profile::with('user');

        if (! empty($filters['status'])) {
            if ($filters['status'] === 'active') {
                $query->where('is_active', true);
            } elseif ($filters['status'] === 'suspended') {
                $query->where('is_active', false);
            }
        }

        if (! empty($filters['search'])) {
            $search = trim($filters['search']);
            $query->where(function ($query) use ($search) {
                $query->where('full_name', 'LIKE', "%{$search}%")
                    ->orWhere('username', 'LIKE', "%{$search}%");
            });
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function findByUserId(int $userId): ?Profile
    {
        return Profile::where('user_id', $userId)->with('user')->first();
    }

    public function updateStatus(Profile $profile, bool $active): Profile
    {
        $profile->is_active = $active;
        $profile->save();

        return $profile;
    }

    public function deleteUserByUserId(int $userId): void
    {
        $user = $this->findByUserId($userId)?->user;

        if (! $user) {
            abort(404, 'User not found.');
        }

        $user->delete();
    }
}
