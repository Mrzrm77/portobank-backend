<?php

namespace App\Repositories\Search;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Collection;

class ProfileSearchRepository
{
    public function search(array $filters = []): Collection
    {
        $query = Profile::with('skills')
            ->where('is_public', true)
            ->where('is_active', true)
            ->whereHas('user', function ($query) {
                $query->where('role', '!=', 'admin');
            });

        if (! empty($filters['query'])) {
            $query->where(function ($query) use ($filters) {
                $search = trim($filters['query']);
                $query->where('full_name', 'ilike', "%{$search}%")
                    ->orWhere('username', 'ilike', "%{$search}%")
                    ->orWhere('profession', 'ilike', "%{$search}%")
                    ->orWhereHas('skills', function ($skillQuery) use ($search) {
                        $skillQuery->where('name', 'ilike', "%{$search}%");
                    });
            });
        }

        if (! empty($filters['profession'])) {
            $query->where('profession', $filters['profession']);
        }

        if (! empty($filters['location'])) {
            $query->where('location', $filters['location']);
        }

        if (! empty($filters['page']) && ! empty($filters['limit'])) {
            $query->offset($filters['page'] * $filters['limit'])
                ->limit($filters['limit']);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }
}
