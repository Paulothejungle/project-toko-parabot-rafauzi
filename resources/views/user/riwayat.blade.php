@extends('layouts.pengguna')

@section('page-title', 'Pesanan Saya')

@section('content')

{{-- HEADER --}}
<div style="margin-bottom:28px;">
  <h1 style="font-family:'Sora',sans-serif; font-size:24px; font-weight:700; color:#e8e9f5; letter-spacing:-0.5px;">
    Pesanan Saya 📋
  </h1>
  <p style="font-size:13.5px; color:#6e70a0; margin-top:4px;">
    Riwayat semua pesanan yang pernah kamu buat
  </p>
</div>

@forelse($pesanan as $p)
@php
  $detail   = $p->detailPesanan->first();
  $produk   = $detail?->produk;
  $isPending = $p->status_pesanan === 'pending';
@endphp
<div class="order-card">
  <div class="order-header">
    <div style="display:flex; align-items:center; gap:10px;">
      <div class="order-id">#PSN-{{ str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</div>
      <span class="status-badge {{ $isPending ? 'badge-pending' : 'badge-done' }}">
        {{ $isPending ? '⏳ Pending' : '✅ Selesai' }}
      </span>
    </div>
    <div style="font-size:12px; color:#3d3f52;">
      {{ \Carbon\Carbon::parse($p->tanggal_pesanan)->format('d M Y, H:i') }}
    </div>
  </div>

  <div class="order-body">
    {{-- Produk image --}}
    <div class="order-thumb">
      @if($produk?->image)
        <img src="{{ asset('storage/'.$produk->image) }}" alt="{{ $produk->nama_produk }}">
      @else
        🪑
      @endif
    </div>

    {{-- Detail --}}
    <div style="flex:1;">
      <div style="font-size:14px; font-weight:600; color:#d0d1e8; margin-bottom:4px;">
        {{ $produk?->nama_produk ?? 'Produk tidak tersedia' }}
      </div>
      <div style="font-size:12px; color:#6e70a0; margin-bottom:8px;">
        {{ $produk?->kategori?->nama_kategori ?? '—' }}
      </div>
      <div style="display:flex; gap:20px; flex-wrap:wrap;">
        <div>
          <div style="font-size:10px; color:#3d3f52; text-transform:uppercase; letter-spacing:0.5px;">Jumlah</div>
          <div style="font-size:13px; color:#c4c5e8; font-weight:600;">{{ $detail?->jumlah ?? 0 }} unit</div>
        </div>
        <div>
          <div style="font-size:10px; color:#3d3f52; text-transform:uppercase; letter-spacing:0.5px;">Harga Satuan</div>
          <div style="font-size:13px; color:#c4c5e8; font-weight:600;">
            Rp {{ number_format($produk?->harga ?? 0, 0, ',', '.') }}
          </div>
        </div>
        <div>
          <div style="font-size:10px; color:#3d3f52; text-transform:uppercase; letter-spacing:0.5px;">Subtotal</div>
          <div style="font-size:14px; color:#a5b4fc; font-weight:700; font-family:'Sora',sans-serif;">
            Rp {{ number_format($detail?->subtotal ?? 0, 0, ',', '.') }}
          </div>
        </div>
      </div>

      {{-- Logistic Info Box --}}
      <div class="logistic-box">
        <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
          <span style="font-size:11px; color:var(--muted); font-weight:500;">💳 Pembayaran</span>
          <span style="font-size:12px; color:var(--text); font-weight:600;">{{ $p->metode_pembayaran ?? 'Manual' }}</span>
        </div>
        <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
          <span style="font-size:11px; color:var(--muted); font-weight:500;">🚚 Pengiriman</span>
          <span style="font-size:12px; color:var(--text); font-weight:600;">{{ $p->jasa_pengiriman ?? '—' }}</span>
        </div>
        <div style="display:flex; justify-content:space-between; gap:16px;">
          <span style="font-size:11px; color:var(--muted); font-weight:500;">📍 Alamat</span>
          <span style="font-size:12px; color:var(--text); text-align:right; line-height:1.4;">{{ $p->alamat_pengiriman ?? 'Belum ada data alamat.' }}</span>
        </div>
      </div>

    </div>

    {{-- Status indicator --}}
    <div class="order-status-wrap">
      @if($isPending)
        <div style="text-align:center;">
          <div style="font-size:24px; margin-bottom:4px;">⏳</div>
          <div style="font-size:11px; color:#fbbf24; font-weight:500;">Menunggu<br>Konfirmasi</div>
        </div>
      @else
        <div style="text-align:center;">
          <div style="font-size:24px; margin-bottom:4px;">✅</div>
          <div style="font-size:11px; color:#4ade80; font-weight:500;">Transaksi<br>Selesai</div>
        </div>
      @endif
    </div>
  </div>
</div>
@empty
<div style="text-align:center; padding:80px 24px;">
  <div style="font-size:56px; margin-bottom:16px;">📋</div>
  <div style="font-size:16px; font-weight:600; color:#6e70a0; margin-bottom:8px;">Belum ada pesanan</div>
  <div style="font-size:13px; color:#3d3f52; margin-bottom:20px;">Yuk mulai belanja produk kami!</div>
  <a href="/produk-user" style="display:inline-flex; align-items:center; gap:7px;
    padding:10px 20px; border-radius:10px;
    background:linear-gradient(135deg,#6366f1,#8b5cf6);
    color:#fff; font-size:13px; font-weight:600; text-decoration:none;
    transition:opacity 0.15s;" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
    🛍 Lihat Produk
  </a>
</div>
@endforelse

<style>
  .order-card {
    background: #13151f;
    border: 0.5px solid rgba(255,255,255,0.07);
    border-radius: 14px; overflow: hidden;
    margin-bottom: 14px;
    transition: border-color 0.2s;
  }
  .order-card:hover { border-color: rgba(99,102,241,0.2); }

  .order-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 14px 18px;
    border-bottom: 0.5px solid rgba(255,255,255,0.05);
    background: rgba(0,0,0,0.15);
    flex-wrap: wrap; gap: 8px;
  }
  .order-id { font-size: 12px; font-weight: 600; color: #6e70a0; font-family: 'Sora', sans-serif; }
  .status-badge {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 20px;
  }
  .badge-pending { background: rgba(251,191,36,0.12); border: 0.5px solid rgba(251,191,36,0.25); color: #fbbf24; }
  .badge-done    { background: rgba(74,222,128,0.1);  border: 0.5px solid rgba(74,222,128,0.2);  color: #4ade80; }

  .order-body {
    display: flex; align-items: center; gap: 16px;
    padding: 18px; flex-wrap: wrap;
  }
  .order-thumb {
    width: 70px; height: 70px; border-radius: 10px;
    background: rgba(255,255,255,0.04);
    border: 0.5px solid rgba(255,255,255,0.07);
    display: flex; align-items: center; justify-content: center;
    font-size: 28px; overflow: hidden; flex-shrink: 0;
  }
  .order-thumb img { width: 100%; height: 100%; object-fit: cover; }

  .order-status-wrap {
    flex-shrink: 0; padding: 12px 16px;
    background: rgba(255,255,255,0.02);
    border: 0.5px solid rgba(255,255,255,0.05);
    border-radius: 10px;
  }
  
  .logistic-box {
    margin-top:16px; padding:12px; 
    background:rgba(255,255,255,0.03); 
    border:0.5px dashed rgba(255,255,255,0.1); 
    border-radius:10px;
  }

  body.light-mode .logistic-box {
    background: #f8fafc !important; border-color: rgba(0,0,0,0.1) !important;
  }
</style>

@endsection