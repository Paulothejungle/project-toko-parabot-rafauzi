@extends('layouts.owner')

@section('page-title', 'Laporan Stok')

@section('content')

<div style="margin-bottom:24px;">
  <h1 style="font-family:'Sora',sans-serif; font-size:22px; font-weight:600; color:#e8e9f5; letter-spacing:-0.4px;">
    Laporan Stok Produk
  </h1>
  <p style="font-size:13px; color:#4a4c6a; margin-top:3px;">Monitor ketersediaan stok seluruh produk</p>
</div>

{{-- STAT CARDS --}}
@php
  $totalProduk = $produk->count();
  $stokHabis   = $produk->where('stok', 0)->count();
  $stokSedikit = $produk->where('stok', '>', 0)->where('stok', '<=', 5)->count();
  $stokAman    = $produk->where('stok', '>', 5)->count();
@endphp

<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(160px, 1fr)); gap:12px; margin-bottom:24px;">
  <div class="stat-card" style="--acc:99,102,241;">
    <div class="stat-icon">📦</div>
    <div class="stat-label">Total Produk</div>
    <div class="stat-val" style="color:#a5b4fc;">{{ $totalProduk }}</div>
  </div>
  <div class="stat-card" style="--acc:74,222,128;">
    <div class="stat-icon">✅</div>
    <div class="stat-label">Stok Aman</div>
    <div class="stat-val" style="color:#4ade80;">{{ $stokAman }}</div>
  </div>
  <div class="stat-card" style="--acc:251,146,60;">
    <div class="stat-icon">⚠️</div>
    <div class="stat-label">Stok Sedikit</div>
    <div class="stat-val" style="color:#fb923c;">{{ $stokSedikit }}</div>
  </div>
  <div class="stat-card" style="--acc:248,113,113;">
    <div class="stat-icon">🚫</div>
    <div class="stat-label">Stok Habis</div>
    <div class="stat-val" style="color:#f87171;">{{ $stokHabis }}</div>
  </div>
</div>

{{-- TABEL --}}
<div class="data-panel">
  <div style="padding:14px 20px; border-bottom:0.5px solid rgba(255,255,255,0.05);
    display:flex; align-items:center; gap:10px;">
    <div style="font-size:13.5px; font-weight:600; color:#d0d1e8;">Daftar Stok Produk</div>
  </div>

  <table class="data-table">
    <thead>
      <tr>
        <th>#</th>
        <th>Produk</th>
        <th>Kategori</th>
        <th>Harga</th>
        <th>Stok</th>
        <th style="text-align:center;">Status</th>
      </tr>
    </thead>
    <tbody>
      @forelse($produk as $p)
      @php
        $persen = $p->stok > 0 ? min(($p->stok / 50) * 100, 100) : 0;
        if ($p->stok == 0)        { $warna = '#f87171'; $badge = '🚫 Habis'; $bgBadge = 'rgba(248,113,113,0.1)'; $borderBadge = 'rgba(248,113,113,0.25)'; }
        elseif ($p->stok <= 5)    { $warna = '#fb923c'; $badge = '⚠️ Sedikit'; $bgBadge = 'rgba(251,146,60,0.1)';  $borderBadge = 'rgba(251,146,60,0.25)'; }
        else                      { $warna = '#4ade80'; $badge = '✅ Aman';    $bgBadge = 'rgba(74,222,128,0.1)';  $borderBadge = 'rgba(74,222,128,0.2)'; }
      @endphp
      <tr>
        <td class="td-no">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
        <td>
          <div style="display:flex; align-items:center; gap:10px;">
            <div class="prod-thumb">
              @if($p->image)
                <img src="{{ asset('storage/'.$p->image) }}" alt="{{ $p->nama_produk }}">
              @else
                📦
              @endif
            </div>
            <div>
              <div style="font-size:13.5px; font-weight:500; color:#d0d1e8;">{{ $p->nama_produk }}</div>
              <div style="font-size:11px; color:#3d3f52;">#PRD-{{ str_pad($p->id, 3, '0', STR_PAD_LEFT) }}</div>
            </div>
          </div>
        </td>
        <td>
          <span style="font-size:11px; color:#a5b4fc; background:rgba(99,102,241,0.1);
            border:0.5px solid rgba(99,102,241,0.2); padding:3px 8px; border-radius:20px;">
            {{ $p->kategori->nama_kategori ?? '—' }}
          </span>
        </td>
        <td style="font-size:13px; color:#c4c5e8; font-family:'Sora',sans-serif;">
          Rp {{ number_format($p->harga, 0, ',', '.') }}
        </td>
        <td>
          <div style="display:flex; align-items:center; gap:8px;">
            <div style="width:60px; height:5px; background:rgba(255,255,255,0.06); border-radius:3px; overflow:hidden;">
              <div style="width:{{ $persen }}%; height:100%; background:{{ $warna }}; border-radius:3px;"></div>
            </div>
            <span style="font-size:13.5px; font-weight:600; color:{{ $warna }}; font-family:'Sora',sans-serif;">
              {{ $p->stok }}
            </span>
          </div>
        </td>
        <td style="text-align:center;">
          <span style="font-size:11px; font-weight:600; padding:4px 10px; border-radius:20px;
            background:{{ $bgBadge }}; border:0.5px solid {{ $borderBadge }};
            color:{{ $warna }};">
            {{ $badge }}
          </span>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="6" style="text-align:center; padding:48px; color:#3d3f52;">Belum ada produk.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<style>
  .stat-card {
    background: rgba(var(--acc),0.06);
    border: 0.5px solid rgba(var(--acc),0.15);
    border-radius:12px; padding:16px; text-align:center;
  }
  .stat-icon { font-size:22px; margin-bottom:6px; }
  .stat-label { font-size:11px; color:#4a4c6a; margin-bottom:4px; }
  .stat-val { font-family:'Sora',sans-serif; font-size:22px; font-weight:700; }

  .data-panel { background:#13151f; border:0.5px solid rgba(255,255,255,0.07); border-radius:14px; overflow:hidden; }
  .data-table { width:100%; border-collapse:collapse; }
  .data-table thead th {
    font-size:11px; font-weight:500; color:#3d3f52; letter-spacing:0.7px;
    text-transform:uppercase; text-align:left; padding:11px 16px;
    border-bottom:0.5px solid rgba(255,255,255,0.05);
  }
  .data-table tbody tr { border-bottom:0.5px solid rgba(255,255,255,0.04); transition:background 0.12s; }
  .data-table tbody tr:last-child { border-bottom:none; }
  .data-table tbody tr:hover { background:rgba(255,255,255,0.02); }
  .data-table tbody td { padding:13px 16px; font-size:13px; color:#8889a4; vertical-align:middle; }
  .td-no { font-size:11px; color:#3d3f52; font-weight:500; }
  .prod-thumb {
    width:38px; height:38px; border-radius:8px;
    background:rgba(255,255,255,0.05);
    border:0.5px solid rgba(255,255,255,0.07);
    display:flex; align-items:center; justify-content:center;
    font-size:16px; overflow:hidden; flex-shrink:0;
  }
  .prod-thumb img { width:100%; height:100%; object-fit:cover; }
</style>

@endsection
