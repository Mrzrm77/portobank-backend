<?php

namespace App\Services\Search;

use App\Repositories\Search\ProfileSearchRepository;

class ProfileSearchService
{
    protected ProfileSearchRepository $repository;

    public function __construct(ProfileSearchRepository $repository)
    {
        $this->repository = $repository;
    }

    public function search(array $filters = [])
    {
        return $this->repository->search($filters);
    }
}
