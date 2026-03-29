@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')

{{-- BREADCRUMB --}}
<div style="margin-bottom:24px;">
  <h1 style="font-family:'Sora',sans-serif; font-size:22px; font-weight:600; color:#e8e9f5; letter-spacing:-0.4px;">
    Dashboard Admin
  </h1>
  <p style="font-size:13px; color:#4a4c6a; margin-top:3px;">Selamat datang kembali, {{ auth()->user()->name }}</p>
</div>

{{-- STAT CARDS --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:16px; margin-bottom:32px;">

  <div style="background:#13151f; border:0.5px solid rgba(255,255,255,0.06); border-radius:14px; padding:20px;
              display:flex; align-items:center; gap:16px;">
    <div style="width:48px; height:48px; border-radius:12px; background:rgba(99,102,241,0.1);
                color:#a5b4fc; display:flex; align-items:center; justify-content:center; font-size:24px;">
      📦
    </div>
    <div>
      <div style="font-size:11px; font-weight:500; color:#6e70a0; text-transform:uppercase; letter-spacing:0.5px;">Total Produk</div>
      <div style="font-family:'Sora',sans-serif; font-size:20px; font-weight:700; color:#e8e9f5; line-height:1.2;">{{ $totalProduk ?? 0 }}</div>
    </div>
  </div>

  <div style="background:#13151f; border:0.5px solid rgba(255,255,255,0.06); border-radius:14px; padding:20px;
              display:flex; align-items:center; gap:16px;">
    <div style="width:48px; height:48px; border-radius:12px; background:rgba(236,72,153,0.1);
                color:#f472b6; display:flex; align-items:center; justify-content:center; font-size:24px;">
      🏷️
    </div>
    <div>
      <div style="font-size:11px; font-weight:500; color:#6e70a0; text-transform:uppercase; letter-spacing:0.5px;">Kategori</div>
      <div style="font-family:'Sora',sans-serif; font-size:20px; font-weight:700; color:#e8e9f5; line-height:1.2;">{{ $totalKategori ?? 0 }}</div>
    </div>
  </div>

  <div style="background:#13151f; border:0.5px solid rgba(255,255,255,0.06); border-radius:14px; padding:20px;
              display:flex; align-items:center; gap:16px;">
    <div style="width:48px; height:48px; border-radius:12px; background:rgba(245,158,11,0.1);
                color:#fcd34d; display:flex; align-items:center; justify-content:center; font-size:24px;">
      ⏳
    </div>
    <div>
      <div style="font-size:11px; font-weight:500; color:#6e70a0; text-transform:uppercase; letter-spacing:0.5px;">Pesanan Pending</div>
      <div style="font-family:'Sora',sans-serif; font-size:20px; font-weight:700; color:#fcd34d; line-height:1.2;">{{ $pesananPending ?? 0 }}</div>
    </div>
  </div>

</div>

{{-- QUICK INFO PANEL --}}
<div style="background:rgba(99,102,241,0.05); border:1px dashed rgba(99,102,241,0.2); border-radius:16px; padding:24px;">
  <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
    <span style="font-size:20px;">💡</span>
    <h3 style="font-family:'Sora',sans-serif; font-size:15px; font-weight:600; color:#c7d2fe;">Aktivitas Prioritas</h3>
  </div>
  <p style="font-size:13px; color:#a5b4fc; line-height:1.6; margin-bottom:16px; max-width:600px;">
    Pastikan Anda segera memproses {{ $pesananPending ?? 0 }} pesanan dari pelanggan yang berstatus pending, agar stok barang otomatis terpotong dan transaksi tercatat di Owner.
  </p>
  <a href="/transaksi" style="background:#6366f1; color:#fff; display:inline-block;
    padding:8px 16px; border-radius:8px; font-size:13px; font-weight:600; text-decoration:none; transition:opacity 0.2s;"
    onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
    Proses Transaksi Sekarang &rarr;
  </a>
</div>

@endsection