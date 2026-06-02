<?php

namespace App\Repositories\Admin;

use App\Models\Portfolio;
use Illuminate\Database\Eloquent\Collection;

class PortfolioRepository
{
    public function all(): Collection
    {
        return Portfolio::with(['user.profile'])
            ->withCount('items')
            ->latest()
            ->get();
    }

    public function find(int $portfolioId): Portfolio
    {
        return Portfolio::with(['user.profile', 'items'])
            ->findOrFail($portfolioId);
    }

    public function updatePublication(Portfolio $portfolio, bool $isPublished): Portfolio
    {
        $portfolio->update(['is_published' => $isPublished]);

        return $portfolio;
    }

    public function delete(Portfolio $portfolio): void
    {
        $portfolio->delete();
    }
}
