<?php

namespace App\Exports;

use App\Models\SalesReport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesReportExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return SalesReport::with('sale.book')->get()->map(function ($r) {
            return [
                $r->sale->book->title,
                $r->sold_to,
                $r->sale->quantity,
                $r->sale->total_price,
                $r->created_at->format('d-m-Y'),
            ];
        });
    }

    public function headings(): array
    {
        return ['Judul Buku', 'Pembeli', 'Jumlah', 'Total', 'Tanggal'];
    }
}

