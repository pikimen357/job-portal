<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Events\AfterSheet;

class JobTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
{
    /**
     * Data contoh untuk template
     */
    public function array(): array
    {
        return [
            [
                'Wakil Presiden',
                'Melakukan kegiatan tidak jelas',
                'Solo',
                'PT Milik Keluarga',
                '800000000000000',
            ],
        ];
    }

    /**
     * Headings untuk template
     */
    public function headings(): array
    {
        return [
            'Title',
            'Description',
            'Location',
            'Company',
            'Salary',
        ];
    }

    /**
     * Styling untuk template
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style untuk header row
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 12,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5'], // Indigo color
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
            // Style untuk contoh data (optional)
            '2:4' => [
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'F3F4F6'], // Gray background
                ],
            ],
        ];
    }

    /**
     * Events untuk menambahkan fitur tambahan
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Tambahkan border untuk semua cell
                $sheet->getStyle('A1:E4')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => 'CCCCCC'],
                        ],
                    ],
                ]);

                // Tambahkan komentar/notes untuk panduan
                $sheet->getComment('A1')->getText()->createTextRun(
                    "Masukkan judul lowongan pekerjaan\nContoh: Software Engineer, Data Analyst"
                );

                $sheet->getComment('B1')->getText()->createTextRun(
                    "Deskripsi detail pekerjaan\nContoh: Develop and maintain web applications"
                );

                $sheet->getComment('C1')->getText()->createTextRun(
                    "Lokasi pekerjaan\nContoh: Jakarta, Bandung, Surabaya"
                );

                $sheet->getComment('D1')->getText()->createTextRun(
                    "Nama perusahaan\nContoh: PT Tech Indonesia"
                );

                $sheet->getComment('E1')->getText()->createTextRun(
                    "Gaji (dalam angka tanpa titik/koma)\nContoh: 8000000 untuk Rp 8.000.000"
                );

                // Set row height untuk header
                $sheet->getRowDimension(1)->setRowHeight(25);

                // Set column width minimum
                $sheet->getColumnDimension('B')->setWidth(50); // Description lebih lebar
            },
        ];
    }
}
