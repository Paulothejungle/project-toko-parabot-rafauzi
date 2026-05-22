<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $search  = $request->input('search', '');
        $katId   = $request->input('kategori', '');

        $query = Produk::with('kategori')->where('stok', '>', 0);

        if ($search) {
            $query->where('nama_produk', 'like', "%{$search}%");
        }

        if ($katId) {
            $query->where('kategori_id', $katId);
        }

        $produk = $query->orderBy('nama_produk')->get();

        // Untuk dropdown filter: ambil semua kategori yang punya produk stok > 0
        $kategoriList = \App\Models\Kategori::whereHas('produk', function ($q) {
            $q->where('stok', '>', 0);
        })->orderBy('nama_kategori')->get();

        return view('user.produk', compact('produk', 'kategoriList', 'search', 'katId'));
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

        // Upload bukti pembayaran sebelum masuk transaction
        $buktiPath = $request->file('bukti_pembayaran')
                             ->store('bukti_pembayaran', 'public');

        try {
            DB::transaction(function () use ($request, $buktiPath) {
                // lockForUpdate: kunci baris produk agar tidak ada race condition stok
                $produk = Produk::lockForUpdate()->findOrFail($request->produk_id);

                if ($produk->stok < $request->jumlah) {
                    throw new \Exception("Stok tidak mencukupi. Stok tersedia: {$produk->stok}");
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

                // Kurangi stok secara atomik saat checkout (bukan saat admin proses)
                $produk->decrement('stok', $request->jumlah);
            });
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

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

    public function invoice($id)
    {
        // Pastikan pengguna hanya bisa cetak invoice miliknya sendiri
        $pesanan = Pesanan::with([
            'user',
            'detailPesanan.produk.kategori',
            'transaksi',
        ])->where('user_id', auth()->id())
          ->where('status_pesanan', 'selesai')
          ->findOrFail($id);

        $pdf = Pdf::loadView('admin.invoice', compact('pesanan'))
                  ->setPaper('a4', 'portrait');

        $filename = 'Invoice-PSN-' . str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) . '.pdf';

        return $pdf->download($filename);
    }
}
