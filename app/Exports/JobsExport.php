<?php

namespace App\Exports;

use App\Models\Job;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JobsExport implements FromQuery, WithHeadings
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Job::query();
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        return $query;
    }

    public function headings(): array
    {
        return ['ID', 'Title', 'Company', 'Location', 'Status', 'Created At'];
    }
}
