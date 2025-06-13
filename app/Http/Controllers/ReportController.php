<?php
namespace App\Http\Controllers;

use App\Exports\PublishingReportExport;
use App\Exports\SalesReportExport;
use App\Models\PublishingReport;
use App\Models\SalesReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function publishingIndex()
    {
        $publishingReports = PublishingReport::with('book')->latest()->get();
        return view('publishing_reports.index', compact('publishingReports'));
    }

    public function salesIndex()
    {
        $salesReports = SalesReport::with('sale.book')->latest()->get();
        return view('sales_reports.index', compact('salesReports'));
    }
     public function exportPenerbitanPdf()
    {
        $reports = PublishingReport::with('book')->get();
        $pdf = Pdf::loadView('reports.penerbitan_pdf', compact('reports'));
        return $pdf->download('laporan-penerbitan.pdf');
    }

    public function exportPenjualanPdf()
    {
        $reports = SalesReport::with('sale.book')->get();
        $pdf = Pdf::loadView('reports.penjualan_pdf', compact('reports'));
        return $pdf->download('laporan-penjualan.pdf');
    }

    public function exportPenerbitanExcel()
    {
        return Excel::download(new PublishingReportExport, 'laporan-penerbitan.xlsx');
    }

    public function exportPenjualanExcel()
    {
        return Excel::download(new SalesReportExport, 'laporan-penjualan.xlsx');
    }
}
