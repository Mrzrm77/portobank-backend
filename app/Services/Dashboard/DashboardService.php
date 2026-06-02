<?php

namespace App\Services\Dashboard;

use App\Models\Certification;
use App\Models\Like;
use App\Models\Portfolio;
use App\Models\PortfolioItem;
use App\Models\Profile;

class DashboardService
{
    public function getStats($user = null): array
    {
        return [
            'global' => $this->getGlobalStats(),
            'personal' => $user ? $this->getPersonalStats($user) : null,
        ];
    }

    public function getGlobalStats(): array
    {
        $users = Profile::where('is_public', true)
            ->where('is_active', true)
            ->whereHas('user', function ($query) {
                $query->where('role', '!=', 'admin');
            })
            ->count();

        $portfolios = Portfolio::where('is_published', true)->count();

        $professions = Profile::where('is_active', true)
            ->whereNotNull('profession')
            ->whereHas('user', function ($query) {
                $query->where('role', '!=', 'admin');
            })
            ->distinct('profession')
            ->count('profession');

        return [
            'users' => $users,
            'portfolios' => $portfolios,
            'professions' => $professions,
        ];
    }

    public function getPersonalStats($user): array
    {
        $portfolioViews = Portfolio::where('user_id', $user->id)->sum('view_count');

        $portfolioIds = Portfolio::where('user_id', $user->id)->pluck('id');
        $totalLikes = Like::whereIn('portfolio_id', $portfolioIds)->count();

        $totalCertificates = Certification::where('user_id', $user->id)->count();
        $totalPortfolioItems = PortfolioItem::whereHas('portfolio', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();

        return [
            'portfolioViews' => $portfolioViews,
            'totalLikes' => $totalLikes,
            'totalCertificates' => $totalCertificates,
            'totalPortfolioItems' => $totalPortfolioItems,
            'totalProjects' => $totalPortfolioItems,
        ];
    }
}
