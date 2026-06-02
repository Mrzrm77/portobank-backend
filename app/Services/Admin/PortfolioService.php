<?php

namespace App\Services\Admin;

use App\Repositories\Admin\PortfolioRepository;

class PortfolioService
{
    protected PortfolioRepository $repository;

    public function __construct(PortfolioRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listPortfolios()
    {
        return $this->repository->all();
    }

    public function updatePublication(int $portfolioId, bool $isPublished)
    {
        $portfolio = $this->repository->find($portfolioId);

        return $this->repository->updatePublication(
            $portfolio,
            $isPublished
        );
    }

    public function deletePortfolio(int $portfolioId): void
    {
        $portfolio = $this->repository->find($portfolioId);

        $this->repository->delete($portfolio);
    }
}
