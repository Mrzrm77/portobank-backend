<?php

namespace App\Repositories\Search;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ProfileSearchRepository
{
    public function search(array $filters = []): Collection
    {
        $query = Profile::select('profiles.*')
            ->with('skills')
            ->where('is_public', true)
            ->where('is_active', true)
            ->whereHas('user', function ($query) {
                $query->where('role', '!=', 'admin');
            })
            ->withCount('likes');

        if (! empty($filters['query'])) {
            $query->where(function ($query) use ($filters) {
                $search = trim($filters['query']);
                $query->where('full_name', 'LIKE', "%{$search}%")
                    ->orWhere('username', 'LIKE', "%{$search}%")
                    ->orWhere('profession', 'LIKE', "%{$search}%")
                    ->orWhereHas('skills', function ($skillQuery) use ($search) {
                        $skillQuery->where('skill_name', 'LIKE', "%{$search}%");
                    });
            });
        }

        if (! empty($filters['profession'])) {
            $query->where('profession', $filters['profession']);
        }

        if (! empty($filters['location'])) {
            $query->where('location', $filters['location']);
        }

        if (! empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        // If a viewer_id is provided, add a boolean selected column `liked_by_me`
        if (! empty($filters['viewer_id'])) {
            $viewerId = (int) $filters['viewer_id'];
            $query->selectRaw('(exists(select 1 from likes join portfolios on likes.portfolio_id = portfolios.id where portfolios.user_id = profiles.user_id and likes.user_id = ?)) as liked_by_me', [$viewerId]);
        }

        if (! empty($filters['page']) && ! empty($filters['limit'])) {
            $query->offset($filters['page'] * $filters['limit'])
                ->limit($filters['limit']);
        }

        $results = $query->orderBy('created_at', 'desc')->get();

        // Ensure liked_by_me is present as boolean for all results
        return $results->map(function ($r) {
            if (! isset($r->liked_by_me)) {
                $r->liked_by_me = false;
            } else {
                $r->liked_by_me = (bool) $r->liked_by_me;
            }
            // expose likes_count consistent with frontend naming
            $r->likes_count = $r->likes_count ?? ($r->likes_count ?? 0);
            return $r;
        });
    }
}
