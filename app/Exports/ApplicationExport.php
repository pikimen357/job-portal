<?php

namespace App\Exports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ApplicationExport implements FromCollection, WithHeadings, WithMapping
{
    protected $jobId;

    public function __construct($jobId = null)
    {
        $this->jobId = $jobId;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Application::with(['user', 'job']);

        // Filter berdasarkan job_id jika ada
        if ($this->jobId) {
            $query->where('job_id', $this->jobId);
        }

        return $query->get();
    }

    /**
     * Headings for Excel file
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama Pelamar',
            'Email',
            'Lowongan',
            'Status',
            'Tanggal Melamar',
        ];
    }

    /**
     * Mapping data to Excel file
     */
    public function map($application): array
    {
        return [
            $application->id,
            $application->user->name,
            $application->user->email,
            $application->job->title,
            $application->status,
            $application->created_at->format('d-m-Y H:i'),
        ];
    }
}
