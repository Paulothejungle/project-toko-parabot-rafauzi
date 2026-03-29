@extends('layouts.pengguna')

@section('page-title', 'Dashboard Saya')

@section('content')

{{-- HERO SECTION --}}
<div class="hero-section">
  <div class="hero-content">
    <div style="font-size:42px; margin-bottom:16px;">👋</div>
    <h1 style="font-family:'Sora',sans-serif; font-size:32px; font-weight:700; color:#fff; letter-spacing:-0.5px; margin-bottom:8px;">
      Halo, {{ auth()->user()->name }}!
    </h1>
    <p style="font-size:15px; color:#a5b4fc; max-width:500px; margin:0 auto; line-height:1.6; margin-bottom:28px;">
      Selamat datang di Toko Parabot Rafauzi. Temukan berbagai perabotan rumah tangga berkualitas dengan harga terbaik untuk mempercantik rumah Anda.
    </p>

    <div style="display:flex; align-items:center; justify-content:center; gap:16px; flex-wrap:wrap;">
      <a href="/produk-user" class="btn-primary">
        🛍 Mulai Belanja
      </a>
      <a href="/riwayat" class="btn-secondary">
        📋 Cek Pesanan Saya
      </a>
    </div>
  </div>
</div>

{{-- FEATURES --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:20px; margin-top:32px;">

  <div class="feature-card">
    <div class="feature-icon">💎</div>
    <div class="feature-title">Kualitas Premium</div>
    <div class="feature-desc">Barang pilihan dengan material terbaik yang awet dan tahan lama.</div>
  </div>

  <div class="feature-card">
    <div class="feature-icon">🚚</div>
    <div class="feature-title">Pengiriman Cepat</div>
    <div class="feature-desc">Pesanan Anda segera kami proses dan kirimkan ke lokasi Anda.</div>
  </div>

  <div class="feature-card">
    <div class="feature-icon">💯</div>
    <div class="feature-title">Harga Terjangkau</div>
    <div class="feature-desc">Dapatkan harga pabrik termurah langsung dari tangan pertama.</div>
  </div>

</div>


<style>
  .hero-section {
    background: linear-gradient(to bottom, rgba(99,102,241,0.08), rgba(139,92,246,0.03));
    border: 0.5px solid rgba(99,102,241,0.15);
    border-radius: 24px;
    padding: 64px 24px;
    text-align: center;
    position: relative;
    overflow: hidden;
  }
  .hero-section::before {
    content: ''; position: absolute; top: -50px; left: 50%; transform: translateX(-50%);
    width: 60%; height: 200px; background: rgba(99,102,241,0.15);
    filter: blur(80px); border-radius: 50%; z-index: 0; pointer-events: none;
  }
  .hero-content { position: relative; z-index: 1; }

  .btn-primary {
    display: inline-flex; align-items: center; justify-content: center;
    padding: 12px 24px; border-radius: 12px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: #fff; font-size: 14.5px; font-weight: 600;
    text-decoration: none; font-family: 'Plus Jakarta Sans', sans-serif;
    transition: transform 0.2s, opacity 0.2s;
  }
  .btn-primary:hover { transform: translateY(-2px); opacity: 0.9; }

  .btn-secondary {
    display: inline-flex; align-items: center; justify-content: center;
    padding: 12px 24px; border-radius: 12px;
    background: rgba(255,255,255,0.05);
    border: 0.5px solid rgba(255,255,255,0.1);
    color: #d0d1e8; font-size: 14.5px; font-weight: 500;
    text-decoration: none; font-family: 'Plus Jakarta Sans', sans-serif;
    transition: background 0.2s, transform 0.2s;
  }
  .btn-secondary:hover { background: rgba(255,255,255,0.08); transform: translateY(-2px); }

  .feature-card {
    background: #13151f;
    border: 0.5px solid rgba(255,255,255,0.06);
    border-radius: 18px; padding: 24px;
    text-align: center;
    transition: transform 0.3s, border-color 0.3s;
  }
  .feature-card:hover { transform: translateY(-5px); border-color: rgba(99,102,241,0.25); }
  .feature-icon {
    width: 54px; height: 54px; margin: 0 auto 16px;
    background: rgba(255,255,255,0.04);
    border: 0.5px solid rgba(255,255,255,0.08);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px;
  }
  .feature-title { font-family: 'Sora', sans-serif; font-size: 16px; font-weight: 600; color: #e8e9f5; margin-bottom: 8px;}
  .feature-desc { font-size: 13px; color: #6e70a0; line-height: 1.6; }
</style>

@endsection