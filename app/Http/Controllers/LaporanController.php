<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Produk;

class LaporanController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with(['pesanan.user', 'pesanan.detailPesanan.produk'])
                              ->orderBy('created_at', 'desc')
                              ->get();

        $total = $transaksi->sum('total_harga');

        return view('owner.laporan', compact('transaksi', 'total'));
    }

    public function stok()
    {
        $produk = Produk::with('kategori')->orderBy('stok', 'asc')->get();

        return view('owner.stok', compact('produk'));
    }
}