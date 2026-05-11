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

    public function getProjects(
        Profile $profile
    ) {

        return $profile->user
            ->projects()
            ->latest()
            ->get();

    }

    public function findProject(
        Profile $profile,
        int $projectId
    ) {

        return $profile->user
            ->projects()
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