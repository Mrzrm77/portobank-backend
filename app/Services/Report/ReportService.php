<?php

namespace App\Services\Report;

use App\Repositories\Report\ReportRepository;

class ReportService
{
    protected ReportRepository $repo;

    public function __construct(ReportRepository $repo)
    {
        $this->repo = $repo;
    }

    public function createReport(array $data)
    {
        return $this->repo->create($data);
    }

    public function getAllReports()
    {
        return $this->repo->all();
    }

    public function updateReportStatus(int $id, string $status)
    {
        $report = $this->repo->find($id);

        if (! $report) {
            abort(404, 'Report not found.');
        }

        if ($status === 'dismissed') {
            $status = 'rejected';
        }

        return $this->repo->updateStatus($report, $status);
    }
}
