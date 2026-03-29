@extends('layouts.pengguna')

@section('page-title', 'Produk')

@section('content')

{{-- HEADER --}}
<div style="margin-bottom: 28px;">
  <h1 style="font-family:'Sora',sans-serif; font-size:24px; font-weight:700; color:#e8e9f5; letter-spacing:-0.5px;">
    Pilih Produk 🛍
  </h1>
  <p style="font-size:13.5px; color:#6e70a0; margin-top:4px;">
    Temukan furnitur dan parabot berkualitas untuk rumah Anda
  </p>
</div>

{{-- SEARCH & FILTER --}}
<div style="display:flex; align-items:center; gap:10px; margin-bottom:24px; flex-wrap:wrap;">
  <div style="display:flex; align-items:center; gap:8px;
    background:rgba(255,255,255,0.04); border:0.5px solid rgba(255,255,255,0.09);
    border-radius:10px; padding:0 14px; flex:1; min-width:200px;">
    <span style="font-size:14px; color:#3d3f52;">🔍</span>
    <input type="text" id="searchInput" placeholder="Cari produk..." oninput="filterProduk()"
      style="background:none; border:none; outline:none; font-size:13.5px; color:#e8e9f5;
             font-family:'Plus Jakarta Sans',sans-serif; padding:11px 0; width:100%;">
  </div>
  <select id="filterKat" onchange="filterProduk()"
    style="background:rgba(255,255,255,0.04); border:0.5px solid rgba(255,255,255,0.09);
           border-radius:10px; padding:10px 14px; font-size:13px; color:#8889a4;
           font-family:'Plus Jakarta Sans',sans-serif; outline:none; cursor:pointer; appearance:none;
           min-width:160px;">
    <option value="">Semua Kategori</option>
    @foreach($kategoriList as $kat)
      <option value="{{ strtolower($kat) }}">{{ $kat }}</option>
    @endforeach
  </select>
  <span id="produkCount" style="font-size:12px; color:#3d3f52; white-space:nowrap;">
    {{ $produk->count() }} produk
  </span>
</div>

{{-- PRODUCT GRID --}}
<div id="produkGrid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(260px, 1fr)); gap:16px;">

  @forelse($produk as $p)
  <div class="produk-card" data-nama="{{ strtolower($p->nama_produk) }}" data-kat="{{ strtolower($p->kategori->nama_kategori ?? '') }}">

    {{-- IMAGE --}}
    <a href="/pengguna/produk/{{ $p->id }}" style="display:block; text-decoration:none;">
      <div class="card-img-wrap">
        @if($p->image)
          <img src="{{ asset('storage/'.$p->image) }}" alt="{{ $p->nama_produk }}" class="card-img">
        @else
          <div class="card-img-placeholder">🪑</div>
        @endif
        {{-- Badge stok --}}
        @if($p->stok <= 5)
          <span class="stok-badge badge-low">Stok Sedikit</span>
        @endif
      </div>
    </a>

    {{-- CONTENT --}}
    <div class="card-body">
      <div style="font-size:10px; color:#a5b4fc; font-weight:500; letter-spacing:0.5px;
                  text-transform:uppercase; margin-bottom:5px;">
        {{ $p->kategori->nama_kategori ?? '—' }}
      </div>
      <div style="font-size:15px; font-weight:600; color:#e8e9f5; margin-bottom:4px; line-height:1.3;">
        {{ $p->nama_produk }}
      </div>
      <div style="font-family:'Sora',sans-serif; font-size:18px; font-weight:700;
                  color:#a5b4fc; margin-bottom:12px;">
        Rp {{ number_format($p->harga, 0, ',', '.') }}
      </div>

      <div style="display:flex; align-items:center; gap:6px; margin-bottom:14px;">
        @php $persen = min(($p->stok / 50) * 100, 100); $warna = $p->stok <= 5 ? '#f87171' : '#4ade80'; @endphp
        <div style="flex:1; height:3px; background:rgba(255,255,255,0.06); border-radius:2px; overflow:hidden;">
          <div style="width:{{ $persen }}%; height:100%; background:{{ $warna }}; border-radius:2px;"></div>
        </div>
        <span style="font-size:11px; color:{{ $warna }};">{{ $p->stok }} stok</span>
      </div>

      {{-- TOMBOL PESAN (Redirect ke Detail) --}}
      <div style="display:flex; align-items:center;">
        <a href="/pengguna/produk/{{ $p->id }}" class="btn-pesan" style="flex:1; text-decoration:none; justify-content:center;">
          🛒 Pesan
        </a>
      </div>
    </div>

  </div>
  @empty
  <div style="grid-column:1/-1; text-align:center; padding:64px 24px;">
    <div style="font-size:48px; margin-bottom:12px;">🪑</div>
    <div style="font-size:15px; color:#6e70a0;">Belum ada produk tersedia saat ini.</div>
  </div>
  @endforelse

</div>

{{-- STYLES --}}
<style>
  .produk-card {
    background: #13151f;
    border: 0.5px solid rgba(255,255,255,0.07);
    border-radius: 16px;
    overflow: hidden;
    transition: transform 0.2s, border-color 0.2s, box-shadow 0.2s;
  }
  .produk-card:hover {
    transform: translateY(-3px);
    border-color: rgba(99,102,241,0.25);
    box-shadow: 0 8px 32px rgba(99,102,241,0.08);
  }

  .card-img-wrap {
    position: relative;
    width: 100%; height: 180px;
    background: rgba(255,255,255,0.03);
    overflow: hidden;
  }
  .card-img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform 0.3s;
  }
  .produk-card:hover .card-img { transform: scale(1.04); }
  .card-img-placeholder {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    font-size: 52px; color: rgba(255,255,255,0.1);
  }
  .stok-badge {
    position: absolute; top: 10px; right: 10px;
    font-size: 10px; font-weight: 600; padding: 3px 8px;
    border-radius: 20px; backdrop-filter: blur(8px);
  }
  .badge-low {
    background: rgba(251,146,60,0.85); color: #fff;
  }

  .card-body { padding: 16px; }

  .qty-input {
    width: 100%; padding: 9px 12px;
    background: rgba(255,255,255,0.05);
    border: 0.5px solid rgba(255,255,255,0.1);
    border-radius: 9px;
    font-size: 13.5px; color: #e8e9f5;
    font-family: 'Plus Jakarta Sans', sans-serif;
    outline: none;
    transition: border-color 0.15s;
    appearance: textfield;
  }
  .qty-input::-webkit-inner-spin-button { -webkit-appearance: none; }
  .qty-input:focus { border-color: rgba(99,102,241,0.45); }

  .btn-pesan {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 9px 16px; border-radius: 9px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: #fff; font-size: 13px; font-weight: 600;
    border: none; cursor: pointer;
    white-space: nowrap;
    transition: opacity 0.15s, transform 0.15s;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }
  .btn-pesan:hover { opacity: 0.88; transform: scale(0.98); }
  .btn-pesan:active { transform: scale(0.95); }

  @media (max-width: 640px) {
    #produkGrid { grid-template-columns: 1fr; }
  }
</style>

{{-- SCRIPT --}}
<script>
  function filterProduk() {
    const q   = document.getElementById('searchInput').value.toLowerCase();
    const kat = document.getElementById('filterKat').value.toLowerCase();
    const cards = document.querySelectorAll('.produk-card');
    let count = 0;
    cards.forEach(c => {
      const nm = c.dataset.nama || '';
      const kt = c.dataset.kat  || '';
      const show = nm.includes(q) && (!kat || kt === kat);
      c.style.display = show ? '' : 'none';
      if (show) count++;
    });
    document.getElementById('produkCount').textContent = count + ' produk';
  }
</script>

@endsection