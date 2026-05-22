<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Produk;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /**
     * Bangun query transaksi dengan filter bulan & tahun.
     * Diekstrak agar tidak ada duplikasi antara index() dan exportPdf().
     */
    private function buildQuery(Request $request)
    {
        $query = Transaksi::with(['pesanan.user', 'pesanan.detailPesanan.produk'])
                          ->orderBy('created_at', 'desc');

        if ($request->filled('bulan')) {
            $query->where(function ($q) use ($request) {
                $q->whereMonth('tanggal_transaksi', $request->bulan)
                  ->orWhere(function ($sub) use ($request) {
                      $sub->whereNull('tanggal_transaksi')
                          ->whereMonth('created_at', $request->bulan);
                  });
            });
        }

        if ($request->filled('tahun')) {
            $query->where(function ($q) use ($request) {
                $q->whereYear('tanggal_transaksi', $request->tahun)
                  ->orWhere(function ($sub) use ($request) {
                      $sub->whereNull('tanggal_transaksi')
                          ->whereYear('created_at', $request->tahun);
                  });
            });
        }

        return $query;
    }

    public function index(Request $request)
    {
        $transaksi = $this->buildQuery($request)->get();
        $total     = $transaksi->sum('total_harga');

        $bulanSelected = $request->bulan;
        $tahunSelected = $request->tahun;

        // Fix: gunakan now()->copy() agar Carbon tidak termutasi
        $years = collect([
            now()->copy()->year,
            now()->copy()->subYear()->year,
            now()->copy()->subYears(2)->year,
        ])->unique()->sort()->values();

        return view('owner.laporan', compact('transaksi', 'total', 'bulanSelected', 'tahunSelected', 'years'));
    }

    public function stok()
    {
        $produk = Produk::with('kategori')->orderBy('stok', 'asc')->get();

        return view('owner.stok', compact('produk'));
    }

    public function exportPdf(Request $request)
    {
        $transaksi = $this->buildQuery($request)->get();
        $total     = $transaksi->sum('total_harga');

        $namaBulan = [
            '1'  => 'Januari',  '2'  => 'Februari', '3'  => 'Maret',
            '4'  => 'April',    '5'  => 'Mei',       '6'  => 'Juni',
            '7'  => 'Juli',     '8'  => 'Agustus',   '9'  => 'September',
            '10' => 'Oktober',  '11' => 'November',  '12' => 'Desember',
        ];

        $filterBulan = $request->filled('bulan') ? $namaBulan[$request->bulan] : 'Semua Bulan';
        $filterTahun = $request->filled('tahun') ? $request->tahun : 'Semua Tahun';

        $pdf = Pdf::loadView('owner.laporan-pdf', compact('transaksi', 'total', 'filterBulan', 'filterTahun'));

        $filename = 'laporan-penjualan-' . strtolower(str_replace(' ', '-', $filterBulan)) . '-' . $filterTahun . '.pdf';

        return $pdf->download($filename);
    }
}