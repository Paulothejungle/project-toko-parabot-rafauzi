<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Produk;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::where('status_pesanan', 'pending')
                          ->with(['user', 'detailPesanan.produk'])
                          ->orderBy('created_at', 'desc')
                          ->get();

        return view('admin.transaksi', compact('pesanan'));
    }

    public function proses($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $detail = DetailPesanan::where('pesanan_id', $id)->first();

        $produk = Produk::find($detail->produk_id);

        $total = $detail->subtotal;

        // Simpan transaksi
        Transaksi::create([
            'pesanan_id'        => $id,
            'tanggal_transaksi' => now(),
            'total_harga'       => $total,
            'status_transaksi'  => 'selesai',
        ]);

        // Kurangi stok
        $produk->stok -= $detail->jumlah;
        $produk->save();

        // Update status pesanan
        $pesanan->status_pesanan = 'selesai';
        $pesanan->save();

        return redirect('/transaksi')
            ->with('success', 'Transaksi berhasil diproses');
    }
}