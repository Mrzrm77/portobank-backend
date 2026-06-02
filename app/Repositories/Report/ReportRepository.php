<?php

namespace App\Repositories\Report;

use App\Models\Report;
use Illuminate\Database\Eloquent\Collection;

class ReportRepository
{
    public function create(array $data): Report
    {
        return Report::create($data);
    }

    public function find(int $id): ?Report
    {
        return Report::find($id);
    }

    public function all(): Collection
    {
        return Report::with(['reporter', 'target'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function updateStatus(Report $report, string $status): Report
    {
        $report->status = $status;
        $report->save();

        return $report;
    }
}
