<?php

namespace App\Repositories\Admin;

use App\Models\AdminLog;
use Illuminate\Database\Eloquent\Collection;

class AdminLogRepository
{
    public function all(array $filters = []): Collection
    {
        $query = AdminLog::with('admin');

        if (! empty($filters['action'])) {
            $query->where('action', $filters['action']);
        }

        if (! empty($filters['from'])) {
            $query->whereDate('created_at', '>=', $filters['from']);
        }

        if (! empty($filters['to'])) {
            $query->whereDate('created_at', '<=', $filters['to']);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }
}
