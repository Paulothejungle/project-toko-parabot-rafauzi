@extends('layouts.owner')

@section('page-title', 'Dashboard')

@section('content')

{{-- WELCOME BANNER --}}
<div style="background:linear-gradient(135deg, rgba(245,158,11,0.1), rgba(239,68,68,0.05));
            border:0.5px solid rgba(245,158,11,0.2); border-radius:18px; padding:32px;
            margin-bottom:32px; display:flex; align-items:center; gap:24px; flex-wrap:wrap;">
  <div style="width:72px; height:72px; border-radius:50%; background:linear-gradient(135deg, #f59e0b, #ef4444);
              display:flex; align-items:center; justify-content:center; font-size:32px;
              box-shadow:0 8px 32px rgba(245,158,11,0.2); flex-shrink:0;">
    👑
  </div>
  <div>
    <h1 style="font-family:'Sora',sans-serif; font-size:26px; font-weight:700; color:#e8e9f5; margin-bottom:8px;">
      Selamat Datang, {{ auth()->user()->name }}
    </h1>
    <p style="font-size:14px; color:#a5a6c1; max-width:600px; line-height:1.6;">
      Sebagai Owner, Anda dapat memantau seluruh performa penjualan Toko Parabot Rafauzi dan ketersediaan stok produk secara real-time.
    </p>
  </div>
</div>

{{-- QUICK ACTION CARDS --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:20px;">

  <a href="/laporan" style="display:block; text-decoration:none; background:#13151f;
    border:0.5px solid rgba(255,255,255,0.06); border-radius:16px; padding:24px;
    transition:transform 0.2s, border-color 0.2s;"
    onmouseover="this.style.borderColor='rgba(245,158,11,0.3)'; this.style.transform='translateY(-4px)';"
    onmouseout="this.style.borderColor='rgba(255,255,255,0.06)'; this.style.transform='none';">
    <div style="width:48px; height:48px; border-radius:12px; background:rgba(245,158,11,0.1);
                color:#fcd34d; display:flex; align-items:center; justify-content:center; font-size:24px; margin-bottom:16px;">
      📊
    </div>
    <div style="font-family:'Sora',sans-serif; font-size:16px; font-weight:600; color:#e8e9f5; margin-bottom:6px;">Laporan Penjualan</div>
    <div style="font-size:13px; color:#6e70a0; line-height:1.5;">Lihat grafik pendapatan dan riwayat seluruh transaksi penjualan yang telah berhasil.</div>
  </a>

  <a href="/laporan/stok" style="display:block; text-decoration:none; background:#13151f;
    border:0.5px solid rgba(255,255,255,0.06); border-radius:16px; padding:24px;
    transition:transform 0.2s, border-color 0.2s;"
    onmouseover="this.style.borderColor='rgba(74,222,128,0.3)'; this.style.transform='translateY(-4px)';"
    onmouseout="this.style.borderColor='rgba(255,255,255,0.06)'; this.style.transform='none';">
    <div style="width:48px; height:48px; border-radius:12px; background:rgba(74,222,128,0.1);
                color:#4ade80; display:flex; align-items:center; justify-content:center; font-size:24px; margin-bottom:16px;">
      📦
    </div>
    <div style="font-family:'Sora',sans-serif; font-size:16px; font-weight:600; color:#e8e9f5; margin-bottom:6px;">Pantau Stok Produk</div>
    <div style="font-size:13px; color:#6e70a0; line-height:1.5;">Monitoring dan awasi seluruh ketersediaan / sisa barang di gudang toko Anda.</div>
  </a>

</div>

@endsection