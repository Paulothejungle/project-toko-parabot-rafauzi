@extends('layouts.pengguna')

@section('page-title', $produk->nama_produk)

@section('content')

<div style="margin-bottom: 24px;">
    <a href="/pengguna/produk" style="display:inline-flex; align-items:center; gap:6px; color:#a5b4fc; text-decoration:none; font-size:14px; font-weight:500; transition:color 0.2s;" onmouseover="this.style.color='#e8e9f5'" onmouseout="this.style.color='#a5b4fc'">
        <span>←</span> Kembali ke Katalog
    </a>
</div>

<div class="content-card">
    <div style="display:flex; flex-wrap:wrap; gap:32px;">
        
        {{-- BAGIAN GAMBAR --}}
        <div class="product-image-container">
            @if($produk->image)
                <img src="{{ asset('storage/'.$produk->image) }}" alt="{{ $produk->nama_produk }}">
            @else
                <div class="img-placeholder">🪑</div>
            @endif
        </div>

        {{-- BAGIAN INFO --}}
        <div class="product-info-container">
            <div style="font-size:12px; font-weight:600; color:#8b5cf6; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px;">
                {{ $produk->kategori->nama_kategori ?? 'Umum' }}
            </div>
            
            <h1 class="product-title">{{ $produk->nama_produk }}</h1>
            
            <div class="product-price">
                Rp {{ number_format($produk->harga, 0, ',', '.') }}
            </div>

            <div style="margin-bottom:24px;">
                @php 
                    $persen = min(($produk->stok / 50) * 100, 100); 
                    $warna = $produk->stok <= 5 ? '#ef4444' : '#10b981'; 
                    $teks_stok = $produk->stok > 0 ? "Tersisa $produk->stok unit" : "Habis Terjual";
                @endphp
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px; font-size:13px; font-weight:500; color:#64748b;">
                    <span style="color:{{ $warna }}">{{ $teks_stok }}</span>
                </div>
                <!-- Progress Bar -->
                <div style="width:100%; height:6px; background:rgba(0,0,0,0.1); border-radius:4px; overflow:hidden;">
                    <div style="width:{{ $persen }}%; height:100%; background:{{ $warna }}; border-radius:4px;"></div>
                </div>
            </div>

            <hr style="border:0; border-top:1px solid rgba(0,0,0,0.06); margin-bottom:24px;">

            <div style="margin-bottom:32px;">
                <h3 class="section-title">Deskripsi Produk</h3>
                <p class="section-desc">{{ $produk->deskripsi ?? 'Belum ada deskripsi mendetail mengenai produk ini.' }}</p>
            </div>

            {{-- FORM PEMESANAN --}}
            @if($produk->stok > 0)
            <form action="/pesan" method="POST" class="order-form-box" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                
                <div style="margin-bottom:16px;">
                    <label for="jumlah" class="qty-label">Kuantitas Pembelian</label>
                    <div style="display:flex; align-items:center; gap:12px;">
                        <input type="number" name="jumlah" id="jumlah" min="1" max="{{ $produk->stok }}" value="1" 
                               class="qty-input" style="width:100px; padding:12px; border-radius:10px; font-size:15px; text-align:center; outline:none;">
                        <span class="qty-max">maks. {{ $produk->stok }}</span>
                    </div>
                </div>

                <div style="margin-bottom:16px; padding:12px; background:rgba(99,102,241,0.1); border:1px solid rgba(99,102,241,0.2); border-radius:10px;">
                    <div style="font-size:13px; font-weight:600; color:#8b5cf6; margin-bottom:4px;">💳 Informasi Pembayaran</div>
                    <div style="font-size:14px; color:#e8e9f5;">Transfer ke Rekening BCA: <strong>1234567890</strong> a.n Toko Parabot Rafauzi</div>
                    <div style="font-size:12px; color:#a5b4fc; margin-top:6px;">*Pengiriman akan diatur langsung oleh pihak toko setelah pembayaran dikonfirmasi.</div>
                </div>

                <div style="margin-bottom:16px;">
                    <label for="bukti_pembayaran" class="qty-label">Unggah Bukti Transfer</label>
                    <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="qty-input" style="width:100%; padding:10px; border-radius:10px; font-size:14px; outline:none;" accept="image/*" required>
                    <div style="font-size:12px; color:#6e70a0; margin-top:4px;">Silakan unggah foto/screenshot bukti transfer (Maks 2MB).</div>
                </div>

                <div style="margin-bottom:24px;">
                    <label for="alamat_pengiriman" class="qty-label">Alamat Pengiriman</label>
                    <textarea name="alamat_pengiriman" id="alamat_pengiriman" rows="3" class="qty-input" style="width:100%; padding:12px; border-radius:10px; font-size:14px; outline:none; resize:none; line-height:1.5;" placeholder="Cantumkan detail alamat rumah Anda..." required>{{ auth()->user()->alamat }}</textarea>
                </div>

                <button type="submit" class="btn-checkout">
                    🛒 Pesan Sekarang
                </button>
            </form>
            @else
            <div style="padding:16px; border-radius:12px; background:rgba(239,68,68,0.1); color:#ef4444; text-align:center; font-weight:600;">
                Maaf, stok produk sedang kosong.
            </div>
            @endif

        </div>
    </div>
</div>

<style>
    .content-card {
        background: #13151f; /* base dark mode, overridden by light mode via body class */
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 24px;
        padding: 32px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }

    .product-image-container {
        flex: 1; min-width: 300px; max-width: 500px;
        border-radius: 20px;
        overflow: hidden;
        background: rgba(255,255,255,0.03);
        aspect-ratio: 1/1;
        display: flex; align-items: center; justify-content: center;
        border: 1px solid rgba(255,255,255,0.05);
    }
    .product-image-container img {
        width: 100%; height: 100%; object-fit: cover;
    }
    .img-placeholder {
        font-size: 84px; opacity: 0.2;
    }

    .product-info-container {
        flex: 1.5; min-width: 300px;
    }
    
    .product-title {
        font-family: 'Sora', sans-serif;
        font-size: 32px; font-weight: 700; color: #e8e9f5;
        margin-bottom: 12px; line-height: 1.2; letter-spacing: -0.5px;
    }
    .product-price {
        font-family: 'Sora', sans-serif;
        font-size: 28px; font-weight: 600; color: #6366f1;
        margin-bottom: 24px;
    }

    .order-form-box {
        background: rgba(0,0,0,0.15); border: 1px solid rgba(255,255,255,0.05);
        padding: 24px; border-radius: 16px;
    }

    .btn-checkout {
        width: 100%; padding: 14px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff; border: none; border-radius: 12px;
        font-size: 15px; font-weight: 600;
        cursor: pointer; transition: 0.2s;
    }
    .btn-checkout:hover { opacity: 0.9; transform: translateY(-2px); }

    /* Layout Typography Default (Dark) */
    .section-title { font-size:15px; font-family:'Sora',sans-serif; color:#e8e9f5; margin-bottom:12px; }
    .section-desc { font-size:14.5px; line-height:1.7; color:#a5b4fc; white-space:pre-wrap; }
    .qty-label { display:block; font-size:13px; font-weight:600; color:#e8e9f5; margin-bottom:8px; }
    .qty-input {
        background: rgba(255,255,255,0.05); 
        border: 1px solid rgba(255,255,255,0.15); 
        color: #e8e9f5;
        transition: border-color 0.2s;
    }
    .qty-input:focus { border-color: rgba(99,102,241,0.5); }
    .qty-max { font-size:13px; color:#6e70a0; }

    /* Light Mode Adjustments */
    body.light-mode .content-card {
        background: #ffffff !important; border-color: rgba(0,0,0,0.08) !important;
        box-shadow: 0 10px 40px rgba(0,0,0,0.04) !important;
    }
    body.light-mode .product-title { color: #0f172a !important; }
    body.light-mode .section-title { color: #0f172a !important; }
    body.light-mode .section-desc { color: #475569 !important; }
    body.light-mode .qty-label { color: #0f172a !important; }
    body.light-mode .qty-input { background: #ffffff !important; border-color: rgba(0,0,0,0.15) !important; color: #0f172a !important; }
    body.light-mode .order-form-box { background: #f8fafc !important; border-color: rgba(0,0,0,0.05) !important; }
    body.light-mode .product-image-container { background: #f1f5f9 !important; border-color: rgba(0,0,0,0.05) !important; }
</style>

@endsection
