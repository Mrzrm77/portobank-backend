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
            'user.portfolio.items',
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

    public function getPortfolioItems(
        string $username
    ) {
        $profile =
            $this->repo
                ->findPublicProfile(
                    $username
                );

        return $this->repo
            ->getPortfolioItems($profile);
    }

    public function getPortfolioItemDetail(
        string $username,
        int $itemId
    ) {
        $profile =
            $this->repo
                ->findPublicProfile(
                    $username
                );

        return $this->repo
            ->findPortfolioItem(
                $profile,
                $itemId
            );
    }

    public function getCertificates(
        string $username
    ) {

        $profile =
            $this->repo
                ->findPublicProfile(
                    $username
                );

        return $this->repo
            ->getCertificates($profile);
    }

    public function getCertificateDetail(
        string $username,
        int $certificateId
    ) {

        $profile =
            $this->repo
                ->findPublicProfile(
                    $username
                );

        return $this->repo
            ->findCertificate(
                $profile,
                $certificateId
            );
    }
}