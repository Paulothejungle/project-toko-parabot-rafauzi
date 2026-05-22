@extends('layouts.owner')

@section('page-title', 'Laporan Penjualan')

@section('content')

{{-- HEADER --}}
<div style="margin-bottom:24px;">
  <h1 style="font-family:'Sora',sans-serif; font-size:22px; font-weight:600; color:#e8e9f5; letter-spacing:-0.4px;">
    Laporan Penjualan
  </h1>
  <p style="font-size:13px; color:#4a4c6a; margin-top:3px;">Ringkasan seluruh transaksi yang telah selesai</p>
</div>

{{-- FILTER FORM --}}
<div style="background:rgba(255,255,255,0.02); border:0.5px solid rgba(255,255,255,0.06); border-radius:12px; padding:16px; margin-bottom:24px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px;">
  <form method="GET" action="{{ route('laporan.index') }}" style="display:flex; align-items:center; gap:12px; flex-wrap:wrap; flex:1;">
    <div style="display:flex; flex-direction:column; gap:4px;">
      <label style="font-size:11px; color:#4a4c6a; font-weight:500;">Bulan</label>
      <select name="bulan" onchange="this.form.submit()" style="background:#13151f; border:0.5px solid rgba(255,255,255,0.1); border-radius:6px; color:#d0d1e8; padding:8px 12px; font-size:13px; outline:none; cursor:pointer; width:140px;">
        <option value="">Semua Bulan</option>
        @php
          $namaBulan = [
            '1' => 'Januari', '2' => 'Februari', '3' => 'Maret', '4' => 'April',
            '5' => 'Mei', '6' => 'Juni', '7' => 'Juli', '8' => 'Agustus',
            '9' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
          ];
        @endphp
        @foreach($namaBulan as $val => $label)
          <option value="{{ $val }}" {{ $bulanSelected == $val ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
      </select>
    </div>

    <div style="display:flex; flex-direction:column; gap:4px;">
      <label style="font-size:11px; color:#4a4c6a; font-weight:500;">Tahun</label>
      <select name="tahun" onchange="this.form.submit()" style="background:#13151f; border:0.5px solid rgba(255,255,255,0.1); border-radius:6px; color:#d0d1e8; padding:8px 12px; font-size:13px; outline:none; cursor:pointer; width:120px;">
        <option value="">Semua Tahun</option>
        @foreach($years as $yr)
          <option value="{{ $yr }}" {{ $tahunSelected == $yr ? 'selected' : '' }}>{{ $yr }}</option>
        @endforeach
      </select>
    </div>

    <div style="display:flex; align-items:flex-end; height:100%; margin-top: 15px;">
      <button type="submit" style="background:rgba(99,102,241,0.15); border:1px solid rgba(99,102,241,0.3); border-radius:6px; color:#a5b4fc; padding:8px 16px; font-size:13px; font-weight:600; cursor:pointer; transition:all 0.15s;"
              onmouseover="this.style.background='rgba(99,102,241,0.25)'"
              onmouseout="this.style.background='rgba(99,102,241,0.15)'">
        🔍 Filter
      </button>
      @if($bulanSelected || $tahunSelected)
        <a href="{{ route('laporan.index') }}" style="margin-left: 8px; font-size: 13px; color: #4a4c6a; text-decoration: none; display: inline-flex; align-items: center; height: 34px; padding-bottom: 2px;">
          Reset Filter
        </a>
      @endif
    </div>
  </form>

  <div>
    <a href="{{ route('laporan.pdf', ['bulan' => $bulanSelected, 'tahun' => $tahunSelected]) }}" 
       style="display:inline-flex; align-items:center; gap:6px; padding:10px 18px; border-radius:8px; background:linear-gradient(135deg, #ef4444, #dc2626); color:#fff; font-size:13px; font-weight:600; text-decoration:none; transition:opacity 0.15s;"
       onmouseover="this.style.opacity='0.88'"
       onmouseout="this.style.opacity='1'">
      🖨️ Ekspor Laporan PDF
    </a>
  </div>
</div>

{{-- STAT CARDS --}}
@php
  $totalTransaksi  = $transaksi->count();
  $totalPendapatan = $transaksi->sum('total_harga');
  $rataRata        = $totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0;
@endphp

<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:14px; margin-bottom:24px;">

  <div class="stat-card" style="--accent-rgb:245,158,11;">
    <div class="stat-icon">💰</div>
    <div>
      <div class="stat-label">Total Pendapatan</div>
      <div class="stat-value" style="color:#fcd34d;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
    </div>
  </div>

  <div class="stat-card" style="--accent-rgb:74,222,128;">
    <div class="stat-icon">✅</div>
    <div>
      <div class="stat-label">Transaksi Selesai</div>
      <div class="stat-value" style="color:#4ade80;">{{ $totalTransaksi }}</div>
    </div>
  </div>

  <div class="stat-card" style="--accent-rgb:99,102,241;">
    <div class="stat-icon">📊</div>
    <div>
      <div class="stat-label">Rata-rata Transaksi</div>
      <div class="stat-value" style="color:#a5b4fc;">Rp {{ number_format($rataRata, 0, ',', '.') }}</div>
    </div>
  </div>

</div>

{{-- TABEL --}}
<div class="data-panel">
  <div style="padding:16px 20px; border-bottom:0.5px solid rgba(255,255,255,0.05);
    display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;">
    <div style="font-size:14px; font-weight:600; color:#d0d1e8;">Rincian Transaksi</div>
    <div style="font-size:12px; color:#3d3f52;">{{ $totalTransaksi }} transaksi</div>
  </div>

  <table class="data-table">
    <thead>
      <tr>
        <th>#</th>
        <th>Tanggal</th>
        <th>Pelanggan</th>
        <th>Produk</th>
        <th>Jumlah</th>
        <th style="text-align:right; padding-right:20px;">Total</th>
        <th style="text-align:center;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($transaksi as $t)
      @php
        $detail = $t->pesanan?->detailPesanan?->first();
        $produk = $detail?->produk;
        $user   = $t->pesanan?->user;
      @endphp
      <tr>
        <td class="td-no">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
        <td>
          {{ $t->tanggal_transaksi
              ? \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d M Y')
              : \Carbon\Carbon::parse($t->created_at)->format('d M Y') }}
        </td>
        <td>
          <div style="display:flex; align-items:center; gap:8px;">
            <div style="width:28px; height:28px; border-radius:50%;
              background:linear-gradient(135deg,#f59e0b,#ef4444);
              display:flex; align-items:center; justify-content:center;
              font-size:10px; font-weight:700; color:#fff;">
              {{ strtoupper(substr($user?->name ?? 'U', 0, 2)) }}
            </div>
            <span style="font-size:13px; color:#c4c5e8;">{{ $user?->name ?? '—' }}</span>
          </div>
        </td>
        <td>
          <div style="font-size:13px; color:#c4c5e8; font-weight:500;">
            {{ $produk?->nama_produk ?? '—' }}
          </div>
          <div style="font-size:11px; color:#4a4c6a;">{{ $produk?->kategori?->nama_kategori ?? '' }}</div>
        </td>
        <td style="font-size:13px; color:#8889a4;">{{ $detail?->jumlah ?? 0 }} unit</td>
        <td style="text-align:right; padding-right:20px;">
          <span style="font-family:'Sora',sans-serif; font-size:14px; font-weight:600; color:#fcd34d;">
            Rp {{ number_format($t->total_harga, 0, ',', '.') }}
          </span>
        </td>
        <td style="text-align:center;">
          @if($t->pesanan)
            <a href="{{ route('transaksi.invoice', $t->pesanan->id) }}" target="_blank"
               style="display:inline-flex; align-items:center; gap:4px;
                      padding:5px 12px; border-radius:6px;
                      background:rgba(99,102,241,0.12); border:1px solid rgba(99,102,241,0.3);
                      color:#a5b4fc; font-size:11px; font-weight:600; text-decoration:none;
                      transition:all 0.15s;"
               onmouseover="this.style.background='rgba(99,102,241,0.25)'"
               onmouseout="this.style.background='rgba(99,102,241,0.12)'">
              📄 Cetak Invoice
            </a>
          @else
            —
          @endif
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="7" style="text-align:center; padding:48px; color:#3d3f52; font-size:13px;">
          Belum ada transaksi selesai.
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>

  {{-- Total Footer --}}
  @if($totalTransaksi > 0)
  <div style="padding:14px 20px; border-top:0.5px solid rgba(255,255,255,0.07);
    display:flex; justify-content:space-between; align-items:center;
    background:rgba(245,158,11,0.04);">
    <span style="font-size:13px; font-weight:600; color:#d0d1e8;">Total Keseluruhan</span>
    <span style="font-family:'Sora',sans-serif; font-size:18px; font-weight:700; color:#fcd34d;">
      Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
    </span>
  </div>
  @endif
</div>

<style>
  .stat-card {
    background: rgba(var(--accent-rgb),0.06);
    border: 0.5px solid rgba(var(--accent-rgb),0.15);
    border-radius: 14px; padding: 18px;
    display: flex; align-items: center; gap: 14px;
  }
  .stat-icon { font-size: 24px; }
  .stat-label { font-size: 11px; color: #4a4c6a; font-weight: 500; letter-spacing: 0.4px; margin-bottom: 4px; }
  .stat-value { font-family: 'Sora', sans-serif; font-size: 18px; font-weight: 700; line-height: 1; }

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
</style>

@endsection