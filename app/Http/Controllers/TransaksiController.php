<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $pending = Pesanan::where('status_pesanan', 'pending')
                          ->with(['user', 'detailPesanan.produk'])
                          ->orderBy('created_at', 'desc')
                          ->get();

        $selesai = Pesanan::where('status_pesanan', 'selesai')
                          ->with(['user', 'detailPesanan.produk', 'transaksi'])
                          ->orderBy('updated_at', 'desc')
                          ->get();

        return view('admin.transaksi', compact('pending', 'selesai'));
    }

    public function proses($id)
    {
        $pesanan = Pesanan::with('detailPesanan.produk')->findOrFail($id);

        // Pastikan pesanan masih berstatus pending
        if ($pesanan->status_pesanan !== 'pending') {
            return redirect('/transaksi')
                ->with('error', 'Pesanan ini sudah diproses sebelumnya.');
        }

        // Validasi: pesanan harus memiliki minimal 1 item
        if ($pesanan->detailPesanan->isEmpty()) {
            return redirect('/transaksi')
                ->with('error', 'Pesanan tidak memiliki item produk.');
        }

        DB::transaction(function () use ($pesanan) {
            // Hitung total dari SEMUA item pesanan (bukan hanya first())
            $total = $pesanan->detailPesanan->sum('subtotal');

            // Simpan transaksi
            Transaksi::create([
                'pesanan_id'        => $pesanan->id,
                'tanggal_transaksi' => now(),
                'total_harga'       => $total,
                'status_transaksi'  => 'selesai',
            ]);

            // Update status pesanan menjadi selesai
            $pesanan->status_pesanan = 'selesai';
            $pesanan->save();
        });

        return redirect('/transaksi')
            ->with('success', 'Transaksi berhasil diproses');
    }


    public function invoice($id)
    {
        // Pastikan hanya admin dan owner yang bisa mengakses
        $user = auth()->user();
        if ($user->role !== 'admin' && $user->role !== 'owner') {
            abort(403, 'Unauthorized action.');
        }

        $pesanan = Pesanan::with([
            'user',
            'detailPesanan.produk.kategori',
            'transaksi',
        ])->findOrFail($id);

        $pdf = Pdf::loadView('admin.invoice', compact('pesanan'))
                  ->setPaper('a4', 'portrait');

        $filename = 'Invoice-PSN-' . str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) . '.pdf';

        return $pdf->download($filename);
    }
}