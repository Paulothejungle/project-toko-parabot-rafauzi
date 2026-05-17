@extends('layouts.admin')

@section('page-title', 'Transaksi')

@section('content')

{{-- HEADER --}}
<div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
  <div>
    <h1 style="font-family:'Sora',sans-serif; font-size:22px; font-weight:600; color:#e8e9f5; letter-spacing:-0.4px;">
      Kelola Transaksi
    </h1>
    <p style="font-size:13px; color:#4a4c6a; margin-top:3px;">Proses pesanan yang masuk dari pelanggan</p>
  </div>
  <div style="display:flex; align-items:center; gap:8px; padding:8px 14px;
    background:rgba(251,191,36,0.08); border:0.5px solid rgba(251,191,36,0.2);
    border-radius:10px;">
    <span style="font-size:18px;">⏳</span>
    <div>
      <div style="font-size:10px; color:#fbbf24; font-weight:500; letter-spacing:0.5px;">PENDING</div>
      <div style="font-size:18px; font-weight:700; color:#fbbf24; font-family:'Sora',sans-serif; line-height:1;">
        {{ $pesanan->count() }}
      </div>
    </div>
  </div>
</div>

{{-- FLASH --}}
@if(session('success'))
<div class="alert-flash alert-success">✓ &nbsp;{{ session('success') }}</div>
@endif

{{-- PANEL --}}
<div class="data-panel">

  @forelse($pesanan as $p)
  @php $detail = $p->detailPesanan->first(); $produk = $detail?->produk; @endphp
  <div class="order-row">

    {{-- Kiri: Info Pesanan --}}
    <div style="display:flex; align-items:center; gap:14px; flex:1; min-width:0;">

      {{-- Thumb --}}
      <div class="prod-thumb">
        @if($produk?->image)
          <img src="{{ asset('storage/'.$produk->image) }}" alt="{{ $produk->nama_produk }}">
        @else
          📦
        @endif
      </div>

      {{-- Detail --}}
      <div style="min-width:0;">
        <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap; margin-bottom:4px;">
          <span style="font-size:12px; color:#3d3f52; font-weight:600; font-family:'Sora',sans-serif;">
            #PSN-{{ str_pad($p->id, 4, '0', STR_PAD_LEFT) }}
          </span>
          <span style="font-size:11px; background:rgba(251,191,36,0.1); border:0.5px solid rgba(251,191,36,0.25);
                       color:#fbbf24; padding:2px 8px; border-radius:20px;">
            ⏳ Pending
          </span>
        </div>

        <div style="font-size:14px; font-weight:600; color:#d0d1e8; margin-bottom:3px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
          {{ $produk?->nama_produk ?? 'Produk tidak ada' }}
        </div>

        <div style="display:flex; align-items:center; gap:16px; flex-wrap:wrap;">
          <div style="font-size:12px; color:#6e70a0;">
            👤 {{ $p->user?->name ?? 'Unknown' }}
          </div>
          <div style="font-size:12px; color:#6e70a0;">
            📅 {{ \Carbon\Carbon::parse($p->tanggal_pesanan)->format('d M Y') }}
          </div>
          <div style="font-size:12px; color:#8889a4;">
            📦 Jumlah: <strong style="color:#c4c5e8;">{{ $detail?->jumlah ?? 0 }}</strong>
          </div>
        </div>

        {{-- Logistik Detail Admin --}}
        <div style="margin-top:10px; padding:10px 12px; background:rgba(255,255,255,0.02); border:0.5px dashed rgba(255,255,255,0.08); border-radius:8px;">
          <div style="font-size:11px; color:#fbbf24; font-weight:600; margin-bottom:4px; text-transform:uppercase;">💳 {{ $p->metode_pembayaran ?? 'Manual' }}</div>
          <div style="font-size:12px; color:#a5b4fc; line-height:1.4; margin-bottom: 4px;">📍 {{ $p->alamat_pengiriman ?? 'Belum ada alamat kirim.' }}</div>
          @if($p->bukti_pembayaran)
            <div style="font-size:12px;">
              <a href="{{ asset('storage/'.$p->bukti_pembayaran) }}" target="_blank" style="color:#4ade80; text-decoration:underline;">Lihat Bukti Pembayaran</a>
            </div>
          @else
            <div style="font-size:12px; color:#ef4444;">Belum ada bukti pembayaran</div>
          @endif
        </div>
      </div>
    </div>

    {{-- Tengah: Subtotal --}}
    <div style="text-align:center; padding:0 20px; flex-shrink:0;">
      <div style="font-size:10px; color:#3d3f52; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:3px;">Subtotal</div>
      <div style="font-family:'Sora',sans-serif; font-size:16px; font-weight:700; color:#a5b4fc;">
        Rp {{ number_format($detail?->subtotal ?? 0, 0, ',', '.') }}
      </div>
    </div>

    {{-- Kanan: Tombol Proses --}}
    <div style="flex-shrink:0;">
      <form action="/transaksi/proses/{{ $p->id }}" method="POST"
            onsubmit="return confirmProses(event, '{{ $p->user?->name }}', '{{ $produk?->nama_produk }}')">
        @csrf
        <button type="submit" class="btn-proses">
          ✓ Proses Sekarang
        </button>
      </form>
    </div>

  </div>
  @empty
  <div style="text-align:center; padding:64px 24px;">
    <div style="font-size:48px; margin-bottom:12px;">🎉</div>
    <div style="font-size:14px; font-weight:600; color:#4a4c6a; margin-bottom:4px;">Tidak ada pesanan pending</div>
    <div style="font-size:12px; color:#3d3f52;">Semua pesanan sudah diproses!</div>
  </div>
  @endforelse

</div>

{{-- MODAL KONFIRMASI --}}
<div id="prosesModal" style="display:none; position:fixed; inset:0; z-index:999;
  background:rgba(0,0,0,0.7); align-items:center; justify-content:center;">
  <div style="background:#13151f; border:0.5px solid rgba(255,255,255,0.1);
    border-radius:16px; padding:32px; width:380px; max-width:90%;">
    <div style="font-size:36px; text-align:center; margin-bottom:14px;">✅</div>
    <h3 style="font-family:'Sora',sans-serif; font-size:16px; font-weight:600;
        color:#e8e9f5; text-align:center; margin-bottom:8px;">Proses Transaksi</h3>
    <p id="prosesText" style="font-size:13px; color:#6e70a0; text-align:center; margin-bottom:24px; line-height:1.6;"></p>
    <div style="display:flex; gap:10px;">
      <button onclick="cancelProses()"
        style="flex:1; padding:10px; border-radius:9px; font-size:13px; font-weight:500;
               background:rgba(255,255,255,0.05); border:0.5px solid rgba(255,255,255,0.1);
               color:#8889a4; cursor:pointer;">
        Batal
      </button>
      <button id="confirmProsesBtn"
        style="flex:1; padding:10px; border-radius:9px; font-size:13px; font-weight:500;
               background:linear-gradient(135deg,#6366f1,#8b5cf6);
               border:none; color:#fff; cursor:pointer;">
        Ya, Proses
      </button>
    </div>
  </div>
</div>

<style>
  .alert-flash {
    display:flex; align-items:center; gap:10px;
    padding:12px 16px; border-radius:10px;
    font-size:13px; font-weight:500; margin-bottom:16px;
  }
  .alert-success { background:rgba(74,222,128,0.1); border:0.5px solid rgba(74,222,128,0.2); color:#4ade80; }

  .data-panel {
    background:#13151f;
    border:0.5px solid rgba(255,255,255,0.07);
    border-radius:14px; overflow:hidden;
  }

  .order-row {
    display:flex; align-items:center; gap:16px;
    padding:18px 20px;
    border-bottom:0.5px solid rgba(255,255,255,0.05);
    transition:background 0.12s;
    flex-wrap:wrap;
  }
  .order-row:last-child { border-bottom:none; }
  .order-row:hover { background:rgba(255,255,255,0.02); }

  .prod-thumb {
    width:50px; height:50px; border-radius:9px;
    background:rgba(255,255,255,0.05);
    border:0.5px solid rgba(255,255,255,0.07);
    display:flex; align-items:center; justify-content:center;
    font-size:20px; overflow:hidden; flex-shrink:0;
  }
  .prod-thumb img { width:100%; height:100%; object-fit:cover; }

  .btn-proses {
    display:inline-flex; align-items:center; gap:6px;
    padding:9px 18px; border-radius:9px;
    background:linear-gradient(135deg,#4ade80,#22c55e);
    color:#000; font-size:13px; font-weight:600;
    border:none; cursor:pointer; white-space:nowrap;
    transition:opacity 0.15s;
  }
  .btn-proses:hover { opacity:0.88; }
</style>

<script>
  let pendingForm = null;
  function confirmProses(e, user, produk) {
    e.preventDefault();
    pendingForm = e.target;
    document.getElementById('prosesText').innerHTML =
      `Proses pesanan dari <strong style="color:#c4c5e8;">${user}</strong><br>untuk produk <strong style="color:#c4c5e8;">${produk}</strong>?`;
    document.getElementById('prosesModal').style.display = 'flex';
    return false;
  }
  function cancelProses() {
    pendingForm = null;
    document.getElementById('prosesModal').style.display = 'none';
  }
  document.getElementById('confirmProsesBtn').addEventListener('click', () => {
    if (pendingForm) pendingForm.submit();
  });
  document.getElementById('prosesModal').addEventListener('click', function(e) {
    if (e.target === this) cancelProses();
  });
</script>

@endsection