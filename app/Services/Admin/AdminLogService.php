<?php

namespace App\Services\Admin;

use App\Repositories\Admin\AdminLogRepository;

class AdminLogService
{
    protected AdminLogRepository $repository;

    public function __construct(AdminLogRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listLogs(array $filters = [])
    {
        return $this->repository->all($filters);
    }
}
