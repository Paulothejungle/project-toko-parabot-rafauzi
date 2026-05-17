<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index()
    {
        $produk = Produk::with('kategori')
                        ->where('stok', '>', 0)
                        ->get();

        $kategoriList = $produk->pluck('kategori.nama_kategori')
                               ->filter()
                               ->unique()
                               ->values();

        return view('user.produk', compact('produk', 'kategoriList'));
    }

    public function show($id)
    {
        $produk = Produk::with('kategori')->findOrFail($id);
        return view('user.produk-detail', compact('produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id'         => 'required|exists:produk,id',
            'jumlah'            => 'required|integer|min:1',
            'alamat_pengiriman' => 'required|string',
            'bukti_pembayaran'  => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        if ($produk->stok < $request->jumlah) {
            return back()->with('error', "Stok tidak mencukupi. Stok tersedia: {$produk->stok}");
        }

        $buktiPath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        $pesanan = Pesanan::create([
            'user_id'           => auth()->id(),
            'tanggal_pesanan'   => now(),
            'status_pesanan'    => 'pending',
            'metode_pembayaran' => 'Transfer Bank',
            'jasa_pengiriman'   => 'Diatur oleh Toko',
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'bukti_pembayaran'  => $buktiPath,
        ]);

        DetailPesanan::create([
            'pesanan_id' => $pesanan->id,
            'produk_id'  => $produk->id,
            'jumlah'     => $request->jumlah,
            'subtotal'   => $produk->harga * $request->jumlah,
        ]);

        return redirect('/riwayat')
               ->with('success', 'Pesanan berhasil dibuat! Menunggu konfirmasi admin.');
    }

    public function riwayat()
    {
        $pesanan = Pesanan::where('user_id', auth()->id())
                          ->with(['detailPesanan.produk.kategori'])
                          ->orderBy('created_at', 'desc')
                          ->get();

        return view('user.riwayat', compact('pesanan'));
    }
}
