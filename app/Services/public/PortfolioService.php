<?php

namespace App\Services\Public;

use App\Repositories\Public\PortfolioRepository;

class PortfolioService
{
    protected $repo;

    public function __construct(
        PortfolioRepository $repo
    ) {
        $this->repo = $repo;
    }

    public function getPortfolio(
        string $username
    ) {

        $profile =
            $this->repo
                ->findPublicProfile(
                    $username
                );

        $profile->skills;

        return $profile->load([
            'user.educations',
            'user.experiences',
            'user.projects',
            'user.socialLinks',
            'user.certifications'
        ]);
    }

    public function getProjects(
        string $username
    ) {

        $profile =
            $this->repo
                ->findPublicProfile(
                    $username
                );

        return $this->repo
            ->getProjects($profile);
    }

    public function getProjectDetail(
        string $username,
        int $projectId
    ) {

        $profile =
            $this->repo
                ->findPublicProfile(
                    $username
                );

        return $this->repo
            ->findProject(
                $profile,
                $projectId
            );
    }
}