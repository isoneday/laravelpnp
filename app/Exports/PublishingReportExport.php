<?php

namespace App\Exports;

use App\Models\PublishingReport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PublishingReportExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return PublishingReport::with('book')->get()->map(function ($r) {
            return [
                $r->book->title,
                $r->published_by,
                $r->created_at->format('d-m-Y'),
            ];
        });
    }

    public function headings(): array
    {
        return ['Judul Buku', 'Diterbitkan Oleh', 'Tanggal'];
    }
}

