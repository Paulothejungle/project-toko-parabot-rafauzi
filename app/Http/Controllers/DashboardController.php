<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Pesanan;
use App\Models\User;

class DashboardController extends Controller
{
    public function admin()
    {
        $totalProduk    = Produk::count();
        $totalKategori  = Kategori::count();
        $pesananPending = Pesanan::where('status_pesanan', 'pending')->count();

        return view('dashboard.admin', compact('totalProduk', 'totalKategori', 'pesananPending'));
    }

    public function pengguna()
    {
        return view('dashboard.pengguna');
    }

    public function owner()
    {
        return view('dashboard.owner');
    }

    public function pelanggan()
    {
        $pelanggan = User::where('role', 'pengguna')
                         ->with('pesanan')
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('admin.pelanggan', compact('pelanggan'));
    }
}
