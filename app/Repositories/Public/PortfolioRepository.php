<?php

namespace App\Repositories\Public;

use App\Models\Profile;

class PortfolioRepository
{
    public function findPublicProfile(
        string $username
    ) {

        return Profile::where(
                'username',
                $username
            )
            ->where('is_public', true)
            ->where('is_active', true)
            ->firstOrFail();

    }

    public function findProfileForViewer(string $username, $authUser = null)
    {
        $query = Profile::where('username', $username)->where('is_active', true);

        if ($authUser && $authUser->profile && $authUser->profile->username === $username) {
            // Viewer is the owner, do not filter by is_public
        } else {
            // Guest or other user, strictly require is_public = true
            $query->where('is_public', true);
        }

        return $query->firstOrFail();
    }

    public function getProjects(
        Profile $profile
    ) {

        $portfolio = $this->getPublicPortfolio($profile);

        if (! $portfolio) {
            return collect();
        }

        return $portfolio->items()
            ->latest()
            ->get();

    }

    public function findProject(
        Profile $profile,
        int $projectId
    ) {

        $portfolio = $this->getPublicPortfolio($profile);

        if (! $portfolio) {
            abort(404, 'Portfolio not found or not published.');
        }

        return $portfolio->items()
            ->where('id', $projectId)
            ->firstOrFail();

    }

    
    public function getCertificates(
        Profile $profile
    ) {

        return $profile->user
            ->certifications()
            ->latest()
            ->get();

    }

    public function getPublicPortfolio(
        Profile $profile
    ) {
        return $profile->user
            ->portfolio()
            ->latest()
            ->first();
    }

    public function getPortfolioItems(
        Profile $profile
    ) {
        $portfolio = $this->getPublicPortfolio($profile);

        if (! $portfolio) {
            return collect();
        }

        return $portfolio->items()
            ->latest()
            ->get();
    }

    public function findPortfolioItem(
        Profile $profile,
        int $itemId
    ) {
        $portfolio = $this->getPublicPortfolio($profile);

        if (! $portfolio) {
            abort(404, 'Portfolio not found or not published.');
        }

        return $portfolio->items()
            ->where('id', $itemId)
            ->firstOrFail();
    }

    public function findCertificate(
        Profile $profile,
        int $certificateId
    ) {

        return $profile->user
            ->certifications()
            ->where('id', $certificateId)
            ->firstOrFail();

    }
}