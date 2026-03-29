@extends('layouts.admin')

@section('page-title', 'Edit Produk')

@section('content')

{{-- BREADCRUMB & HEADER --}}
<div style="margin-bottom:24px;">
  <div style="display:flex; align-items:center; gap:6px; font-size:12px; color:#3d3f52; margin-bottom:10px;">
    <a href="/admin/dashboard" style="color:#6e70a0; text-decoration:none;">Dashboard</a> ›
    <a href="/produk" style="color:#6e70a0; text-decoration:none;">Produk</a> ›
    <span style="color:#6e70a0;">Edit</span>
  </div>
  <h1 style="font-family:'Sora',sans-serif; font-size:22px; font-weight:600; color:#e8e9f5; letter-spacing:-0.4px;">
    Edit Produk
  </h1>
  <p style="font-size:13px; color:#4a4c6a; margin-top:3px;">Perbarui informasi produk #PRD-{{ str_pad($produk->id, 3, '0', STR_PAD_LEFT) }}</p>
</div>

<form method="POST" action="/produk/{{ $produk->id }}" enctype="multipart/form-data" id="produkForm" novalidate>
@csrf
@method('PUT')

<div class="form-grid">

  {{-- ===== KOLOM KIRI ===== --}}
  <div style="display:flex; flex-direction:column; gap:14px;">

    {{-- INFORMASI PRODUK --}}
    <div class="form-card">
      <div class="card-header">
        <div class="card-icon icon-purple">📦</div>
        <div>
          <div class="card-title">Informasi Produk</div>
          <div class="card-sub">Detail utama produk</div>
        </div>
      </div>
      <div class="card-body">

        @if($errors->any())
        <div class="alert-error">
          ✕ &nbsp;{{ $errors->first() }}
        </div>
        @endif

        @if(session('success'))
        <div class="alert-success-msg">
          ✓ &nbsp;{{ session('success') }}
        </div>
        @endif

        <div class="field-group">
          <div class="field-label">Nama Produk <span class="field-required">Wajib</span></div>
          <input type="text" name="nama_produk" id="namaProduk"
            value="{{ old('nama_produk', $produk->nama_produk) }}"
            placeholder="Contoh: Sepatu Kulit Premium"
            class="field-input {{ $errors->has('nama_produk') ? 'field-error' : '' }}"
            oninput="updateSummary()" required>
        </div>

        <div class="field-group">
          <div class="field-label">Kategori <span class="field-required">Wajib</span></div>
          <div style="position:relative;">
            <select name="kategori_id" id="kategoriSelect"
              class="field-select {{ $errors->has('kategori_id') ? 'field-error' : '' }}"
              onchange="updateSummary()" style="padding-right:32px;" required>
              <option value="">— Pilih Kategori —</option>
              @foreach($kategori as $k)
              <option value="{{ $k->id }}" {{ old('kategori_id', $produk->kategori_id) == $k->id ? 'selected' : '' }}>
                {{ $k->nama_kategori }}
              </option>
              @endforeach
            </select>
            <span style="position:absolute;right:12px;top:50%;transform:translateY(-50%);pointer-events:none;font-size:11px;color:#4a4c6a;">▼</span>
          </div>
        </div>

        <div class="two-col">
          <div class="field-group">
            <div class="field-label">Harga <span class="field-required">Wajib</span></div>
            <div style="position:relative;">
              <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:13px;color:#4a4c6a;pointer-events:none;">Rp</span>
              <input type="number" name="harga" id="hargaInput"
                value="{{ old('harga', $produk->harga) }}" placeholder="0" min="0"
                class="field-input {{ $errors->has('harga') ? 'field-error' : '' }}"
                style="padding-left:36px;"
                oninput="updateSummary()" required>
            </div>
          </div>
          <div class="field-group">
            <div class="field-label">Stok <span class="field-required">Wajib</span></div>
            <input type="number" name="stok" id="stokInput"
              value="{{ old('stok', $produk->stok) }}" placeholder="0" min="0"
              class="field-input {{ $errors->has('stok') ? 'field-error' : '' }}"
              oninput="updateSummary()" required>
            <div class="field-hint">Unit tersedia saat ini</div>
          </div>
        </div>

        <div class="field-group" style="margin-top: 20px;">
          <div class="field-label">Deskripsi Lengkap</div>
          <textarea name="deskripsi" id="deskripsiInput" rows="3"
            class="field-input {{ $errors->has('deskripsi') ? 'field-error' : '' }}"
            placeholder="Tuliskan spesifikasi, ukuran, atau fitur..."
            style="resize:none; line-height:1.6;">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
        </div>

      </div>
    </div>

    {{-- FOTO PRODUK --}}
    <div class="form-card">
      <div class="card-header">
        <div class="card-icon icon-teal">🖼️</div>
        <div>
          <div class="card-title">Foto Produk</div>
          <div class="card-sub">JPG, PNG, WEBP — maks 2MB</div>
        </div>
      </div>
      <div class="card-body">

        {{-- Gambar yang sudah ada --}}
        @if($produk->image)
        <div id="currentImageWrap" style="margin-bottom:14px;">
          <div class="field-label" style="margin-bottom:8px;">Foto Saat Ini</div>
          <div style="position:relative; display:inline-block;">
            <img src="{{ asset('storage/'.$produk->image) }}"
                 id="currentImage"
                 alt="{{ $produk->nama_produk }}"
                 style="width:100%; max-height:180px; object-fit:cover;
                        border-radius:9px; border:0.5px solid rgba(255,255,255,0.08);">
            <div style="position:absolute; top:8px; right:8px;
                        background:rgba(0,0,0,0.6); border-radius:6px;
                        padding:3px 8px; font-size:10px; color:#a5b4fc;">
              Foto aktif
            </div>
          </div>
          <div style="font-size:11px; color:#4a4c6a; margin-top:6px;">
            Upload foto baru di bawah untuk mengganti foto ini.
          </div>
        </div>
        @endif

        <div class="upload-zone" id="uploadZone">
          <input type="file" name="image" id="imageInput" accept="image/*" onchange="handleFile(this)">
          <div id="uploadPrompt">
            <div style="font-size:28px; margin-bottom:8px;">☁️</div>
            <div style="font-size:13px; color:#6e70a0;">
              Klik atau <span style="color:#a5b4fc;">drag & drop</span> foto baru
            </div>
            <div style="font-size:11px; color:#3d3f52; margin-top:4px;">PNG, JPG, WEBP hingga 2MB</div>
          </div>
          <div class="preview-wrap" id="previewWrap">
            <img src="" alt="preview" class="preview-img" id="previewImg">
            <span class="preview-remove" onclick="removeFile(event)">✕ Batal ganti foto</span>
          </div>
        </div>
      </div>

      {{-- ACTIONS --}}
      <div class="form-actions">
        <a href="/produk" class="btn-back">← Kembali</a>
        <button type="submit" class="btn-save">💾 Simpan Perubahan</button>
      </div>
    </div>

  </div>

  {{-- ===== KOLOM KANAN: SUMMARY ===== --}}
  <div>
    <div class="form-card" style="position:sticky; top:80px;">
      <div class="card-header">
        <div class="card-icon" style="background:rgba(245,158,11,0.15);">📋</div>
        <div>
          <div class="card-title">Ringkasan</div>
          <div class="card-sub">Preview sebelum simpan</div>
        </div>
      </div>
      <div class="card-body">

        <div id="thumbPreview" style="width:100%; height:120px; border-radius:10px;
          background:rgba(255,255,255,0.03); border:0.5px solid rgba(255,255,255,0.07);
          display:flex; align-items:center; justify-content:center;
          font-size:36px; margin-bottom:18px; overflow:hidden;">
          @if($produk->image)
            <img src="{{ asset('storage/'.$produk->image) }}"
                 style="width:100%;height:100%;object-fit:cover;"
                 id="thumbImg">
          @else
            📦
          @endif
        </div>

        <div class="summary-row">
          <span class="summary-label">ID</span>
          <span class="summary-val">#PRD-{{ str_pad($produk->id, 3, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="summary-row">
          <span class="summary-label">Nama</span>
          <span class="summary-val empty" id="sum-nama">{{ $produk->nama_produk }}</span>
        </div>
        <div class="summary-row">
          <span class="summary-label">Kategori</span>
          <span class="summary-val empty" id="sum-kat">{{ $produk->kategori->nama_kategori ?? '—' }}</span>
        </div>
        <div class="summary-row">
          <span class="summary-label">Harga</span>
          <span class="summary-val empty" id="sum-harga">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
          <span class="summary-label">Stok</span>
          <span class="summary-val empty" id="sum-stok">{{ $produk->stok }} unit</span>
        </div>

        <div style="margin-top:14px; padding:10px 12px;
          background:rgba(99,102,241,0.07);
          border:0.5px solid rgba(99,102,241,0.15);
          border-radius:9px;">
          <div style="font-size:11px; color:#6366f1; font-weight:500; margin-bottom:3px; letter-spacing:0.3px;">STATUS</div>
          <div id="sum-status" style="font-size:12px; color:#4a4c6a;">
            Lengkapi form untuk melihat status
          </div>
        </div>

      </div>
    </div>
  </div>

</div>
</form>

{{-- STYLES --}}
<style>
  .form-grid {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 16px;
    align-items: start;
  }
  @media(max-width:768px) { .form-grid { grid-template-columns:1fr; } }

  .form-card {
    background: #13151f;
    border: 0.5px solid rgba(255,255,255,0.07);
    border-radius: 14px;
    overflow: hidden;
  }

  .card-header {
    padding: 18px 22px;
    border-bottom: 0.5px solid rgba(255,255,255,0.05);
    display: flex; align-items: center; gap: 11px;
  }
  .card-icon {
    width: 34px; height: 34px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; flex-shrink: 0;
  }
  .icon-purple { background: rgba(99,102,241,0.15); }
  .icon-teal   { background: rgba(20,184,166,0.15); }

  .card-title { font-family:'Sora',sans-serif; font-size:14px; font-weight:600; color:#d0d1e8; }
  .card-sub   { font-size:11px; color:#4a4c6a; margin-top:2px; }

  .card-body { padding: 22px; }

  .alert-error {
    display: flex; align-items: flex-start; gap: 10px;
    padding: 11px 14px; border-radius: 9px;
    font-size: 13px; font-weight: 500; margin-bottom: 18px;
    background: rgba(248,113,113,0.1);
    border: 0.5px solid rgba(248,113,113,0.25);
    color: #f87171;
  }

  .alert-success-msg {
    display: flex; align-items: flex-start; gap: 10px;
    padding: 11px 14px; border-radius: 9px;
    font-size: 13px; font-weight: 500; margin-bottom: 18px;
    background: rgba(74,222,128,0.1);
    border: 0.5px solid rgba(74,222,128,0.2);
    color: #4ade80;
  }

  .field-group { margin-bottom: 18px; }
  .field-group:last-child { margin-bottom: 0; }

  .field-label {
    display: flex; align-items: center; justify-content: space-between;
    font-size: 11px; font-weight: 500; color: #6e70a0;
    letter-spacing: 0.5px; text-transform: uppercase;
    margin-bottom: 7px;
  }
  .field-required { font-size:10px; color:#f87171; background:rgba(248,113,113,0.1); padding:2px 6px; border-radius:4px; text-transform:none; letter-spacing:0; }
  .field-optional  { font-size:10px; color:#3d3f52; background:rgba(255,255,255,0.04); padding:2px 6px; border-radius:4px; text-transform:none; letter-spacing:0; }

  .field-input, .field-select {
    width: 100%; padding: 10px 14px;
    background: rgba(255,255,255,0.03);
    border: 0.5px solid rgba(255,255,255,0.1);
    border-radius: 9px;
    font-size: 13.5px; color: #e8e9f5;
    font-family: 'DM Sans', sans-serif;
    outline: none;
    transition: border-color 0.15s, background 0.15s, box-shadow 0.15s;
    appearance: none;
  }
  .field-input::placeholder { color: #3d3f52; }
  .field-input:focus, .field-select:focus {
    border-color: rgba(99,102,241,0.5);
    background: rgba(99,102,241,0.04);
    box-shadow: 0 0 0 3px rgba(99,102,241,0.08);
  }
  .field-error { border-color: rgba(248,113,113,0.5) !important; }
  .field-select option { background: #13151f; }
  .field-hint { font-size: 11px; color: #3d3f52; margin-top: 5px; }

  .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

  .upload-zone {
    border: 1px dashed rgba(255,255,255,0.1);
    border-radius: 10px; padding: 28px 16px;
    text-align: center; cursor: pointer;
    transition: border-color 0.15s, background 0.15s;
    position: relative; overflow: hidden;
  }
  .upload-zone:hover { border-color:rgba(99,102,241,0.4); background:rgba(99,102,241,0.03); }
  .upload-zone input[type=file] { position:absolute; inset:0; opacity:0; cursor:pointer; }

  .preview-wrap { display:none; flex-direction:column; align-items:center; gap:10px; }
  .preview-wrap.visible { display:flex; }
  .preview-img { width:100%; max-height:180px; object-fit:cover; border-radius:9px; border:0.5px solid rgba(255,255,255,0.08); }
  .preview-remove {
    font-size:11px; color:#f87171; cursor:pointer;
    background:rgba(248,113,113,0.1);
    border:0.5px solid rgba(248,113,113,0.2);
    padding:4px 10px; border-radius:6px;
    position: relative; z-index: 1;
  }

  .summary-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 9px 0;
    border-bottom: 0.5px solid rgba(255,255,255,0.05);
  }
  .summary-row:last-of-type { border-bottom: none; }
  .summary-label { font-size:12px; color:#4a4c6a; }
  .summary-val { font-size:13px; color:#c4c5e8; font-weight:500; text-align:right; max-width:60%; }
  .summary-val.empty { color:#3d3f52; font-style:italic; font-weight:400; }

  .form-actions {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 22px;
    border-top: 0.5px solid rgba(255,255,255,0.05);
    background: rgba(0,0,0,0.15);
  }

  .btn-back {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 13px; font-weight: 500; color: #6e70a0;
    background: rgba(255,255,255,0.04);
    border: 0.5px solid rgba(255,255,255,0.08);
    padding: 9px 16px; border-radius: 9px;
    text-decoration: none; transition: all 0.15s;
  }
  .btn-back:hover { background:rgba(255,255,255,0.08); color:#8889a4; }

  .btn-save {
    display: inline-flex; align-items: center; gap: 7px;
    font-size: 13px; font-weight: 500; color: #fff;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border: none; padding: 9px 20px; border-radius: 9px;
    cursor: pointer; transition: opacity 0.15s;
  }
  .btn-save:hover { opacity: 0.88; }
</style>

{{-- SCRIPT --}}
<script>
  // Inisialisasi nilai awal dari produk existing
  const initNama   = @json($produk->nama_produk);
  const initKat    = @json($produk->kategori->nama_kategori ?? '');
  const initHarga  = @json($produk->harga);
  const initStok   = @json($produk->stok);

  function updateSummary() {
    const nama  = document.getElementById('namaProduk').value.trim();
    const kat   = document.getElementById('kategoriSelect');
    const katText = kat.options[kat.selectedIndex]?.text || '';
    const harga = document.getElementById('hargaInput').value;
    const stok  = document.getElementById('stokInput').value;

    const setVal = (id, val, fallback) => {
      const el = document.getElementById(id);
      el.textContent = val || fallback;
      el.className = 'summary-val' + (val ? '' : ' empty');
    };

    setVal('sum-nama',  nama,  'Belum diisi');
    setVal('sum-kat',   kat.value ? katText : '', '—');
    setVal('sum-harga', harga ? 'Rp ' + Number(harga).toLocaleString('id-ID') : '', '—');
    setVal('sum-stok',  stok  ? stok + ' unit' : '', '—');

    const statusEl = document.getElementById('sum-status');
    if (nama && kat.value && harga && stok) {
      statusEl.textContent = '✓ Siap disimpan';
      statusEl.style.color = '#4ade80';
    } else {
      statusEl.textContent = 'Lengkapi semua field wajib';
      statusEl.style.color = '#4a4c6a';
    }
  }

  function handleFile(input) {
    if (!input.files?.[0]) return;
    const url = URL.createObjectURL(input.files[0]);

    // Sembunyikan foto lama
    const currentWrap = document.getElementById('currentImageWrap');
    if (currentWrap) currentWrap.style.display = 'none';

    // Preview di upload zone
    document.getElementById('uploadPrompt').style.display = 'none';
    const pw = document.getElementById('previewWrap');
    pw.classList.add('visible');
    document.getElementById('previewImg').src = url;

    // Preview di summary card
    const thumb = document.getElementById('thumbPreview');
    thumb.innerHTML = '';
    const img = document.createElement('img');
    img.src = url;
    img.style.cssText = 'width:100%;height:100%;object-fit:cover;';
    thumb.appendChild(img);
  }

  function removeFile(e) {
    e.stopPropagation();
    e.preventDefault();
    document.getElementById('imageInput').value = '';
    document.getElementById('uploadPrompt').style.display = 'block';
    document.getElementById('previewWrap').classList.remove('visible');

    // Tampilkan kembali foto lama jika ada
    const currentWrap = document.getElementById('currentImageWrap');
    if (currentWrap) currentWrap.style.display = 'block';

    // Restore thumbnail summary
    const thumb = document.getElementById('thumbPreview');
    const thumbImg = document.getElementById('thumbImg');
    if (thumbImg) {
      thumb.innerHTML = '';
      const img = thumbImg.cloneNode(true);
      thumb.appendChild(img);
    } else {
      thumb.innerHTML = '📦';
    }
  }

  document.addEventListener('DOMContentLoaded', updateSummary);
</script>

@endsection