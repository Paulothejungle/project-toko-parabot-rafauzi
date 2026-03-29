@extends('layouts.admin')

@section('page-title', 'Edit Kategori')

@section('content')

{{-- BREADCRUMB & HEADER --}}
<div style="margin-bottom:24px;">
  <div style="display:flex; align-items:center; gap:6px; font-size:12px; color:#3d3f52; margin-bottom:10px;">
    <a href="/admin/dashboard" style="color:#6e70a0; text-decoration:none;">Dashboard</a> ›
    <a href="/kategori" style="color:#6e70a0; text-decoration:none;">Kategori</a> ›
    <span style="color:#6e70a0;">Edit</span>
  </div>
  <h1 style="font-family:'Sora',sans-serif; font-size:22px; font-weight:600; color:#e8e9f5; letter-spacing:-0.4px;">
    Edit Kategori
  </h1>
  <p style="font-size:13px; color:#4a4c6a; margin-top:3px;">Perbarui informasi kategori yang sudah ada</p>
</div>

{{-- FORM CARD --}}
<div class="form-card" style="max-width:520px;">

  <div class="form-card-header">
    <div style="display:flex; align-items:center; gap:12px;">
      <div class="form-icon">✏️</div>
      <div>
        <div class="form-card-title">Edit Kategori</div>
        <div class="form-card-sub">
          ID #{{ $kategori->id }} · Dibuat {{ $kategori->created_at->format('d M Y') }}
        </div>
      </div>
    </div>
    <span class="edit-badge">Mode Edit</span>
  </div>

  <form method="POST" action="/kategori/{{ $kategori->id }}" id="editForm" novalidate>
    @csrf
    @method('PUT')

    <div class="form-body">

      {{-- Error --}}
      @if($errors->any())
      <div class="alert-error">
        ✕ &nbsp;{{ $errors->first('nama_kategori') }}
      </div>
      @endif

      {{-- Nilai Asli --}}
      <div class="original-val">
        <span class="original-label">Nilai saat ini:</span>
        <span class="original-text">{{ $kategori->nama_kategori }}</span>
      </div>

      {{-- Input --}}
      <div class="field-group">
        <div class="field-label">
          Nama Kategori
          <span class="field-required">Wajib</span>
        </div>
        <div style="position:relative;">
          <input
            type="text"
            name="nama_kategori"
            id="namaInput"
            maxlength="50"
            value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
            class="field-input {{ $errors->has('nama_kategori') ? 'field-input-error' : '' }}"
            oninput="handleInput(this)"
            required
          >
          <span class="char-counter" id="charCounter">
            {{ strlen(old('nama_kategori', $kategori->nama_kategori)) }}/50
          </span>
        </div>
        <div class="changed-indicator" id="changedBadge">
          ⚡ Nilai berubah dari "<span id="fromVal">{{ $kategori->nama_kategori }}</span>"
        </div>
        <div class="field-hint">Gunakan nama yang jelas dan mudah dikenali.</div>
      </div>

      {{-- Slug Preview --}}
      <div class="field-group" style="margin-bottom:0;">
        <div class="field-label">
          Slug
          <span style="color:#3d3f52; font-weight:400; text-transform:none; letter-spacing:0;">(otomatis)</span>
        </div>
        <input
          type="text"
          id="slugPreview"
          class="field-input"
          value="{{ Str::slug(old('nama_kategori', $kategori->nama_kategori)) }}"
          readonly
          style="color:#4a4c6a; font-family:monospace; font-size:13px;"
        >
        <div class="field-hint">Dibuat otomatis dari nama kategori.</div>
      </div>

    </div>

    <div class="form-actions">
      <a href="/kategori" class="btn-back">← Kembali</a>
      <button type="submit" class="btn-update" id="btnUpdate">✔ Update Kategori</button>
    </div>

  </form>
</div>

{{-- STYLES --}}
<style>
  .form-card {
    background: #13151f;
    border: 0.5px solid rgba(255,255,255,0.07);
    border-radius: 16px;
    overflow: hidden;
  }

  .form-card-header {
    padding: 20px 24px;
    border-bottom: 0.5px solid rgba(255,255,255,0.05);
    display: flex; align-items: center; justify-content: space-between;
  }

  .form-icon {
    width: 36px; height: 36px; border-radius: 9px;
    background: rgba(245,158,11,0.15);
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; flex-shrink: 0;
  }

  .form-card-title { font-family:'Sora',sans-serif; font-size:15px; font-weight:600; color:#d0d1e8; }
  .form-card-sub { font-size:12px; color:#4a4c6a; margin-top:2px; }

  .edit-badge {
    font-size: 10px; font-weight: 500;
    padding: 3px 9px; border-radius: 20px;
    background: rgba(245,158,11,0.12);
    border: 0.5px solid rgba(245,158,11,0.25);
    color: #fcd34d;
  }

  .form-body { padding: 24px; }

  .alert-error {
    display: flex; align-items: flex-start; gap: 10px;
    padding: 12px 14px; border-radius: 10px;
    font-size: 13px; font-weight: 500; margin-bottom: 20px;
    background: rgba(248,113,113,0.1);
    border: 0.5px solid rgba(248,113,113,0.25);
    color: #f87171;
  }

  .original-val {
    display: flex; align-items: center; gap: 8px;
    padding: 10px 14px;
    background: rgba(255,255,255,0.02);
    border: 0.5px solid rgba(255,255,255,0.05);
    border-radius: 9px;
    margin-bottom: 20px;
  }
  .original-label { font-size:11px; color:#3d3f52; font-weight:500; white-space:nowrap; }
  .original-text { font-size:13px; color:#4a4c6a; font-family:monospace; }

  .field-group { margin-bottom: 20px; }

  .field-label {
    display: flex; align-items: center; justify-content: space-between;
    font-size: 11px; font-weight: 500; color: #6e70a0;
    letter-spacing: 0.5px; text-transform: uppercase;
    margin-bottom: 8px;
  }

  .field-required {
    font-size: 10px; color: #f87171; font-weight: 500;
    background: rgba(248,113,113,0.1);
    padding: 2px 7px; border-radius: 4px;
    text-transform: none; letter-spacing: 0;
  }

  .field-input {
    width: 100%; padding: 11px 48px 11px 14px;
    background: rgba(255,255,255,0.03);
    border: 0.5px solid rgba(255,255,255,0.1);
    border-radius: 9px;
    font-size: 14px; color: #e8e9f5;
    font-family: 'DM Sans', sans-serif;
    outline: none;
    transition: border-color 0.15s, background 0.15s, box-shadow 0.15s;
  }
  .field-input::placeholder { color: #3d3f52; }
  .field-input:focus {
    border-color: rgba(245,158,11,0.5);
    background: rgba(245,158,11,0.03);
    box-shadow: 0 0 0 3px rgba(245,158,11,0.07);
  }
  .field-input-error { border-color: rgba(248,113,113,0.5) !important; }

  .char-counter {
    position: absolute; right: 12px; top: 50%;
    transform: translateY(-50%);
    font-size: 11px; color: #3d3f52; pointer-events: none;
  }

  .changed-indicator {
    display: none; align-items: center; gap: 6px;
    font-size: 11px; color: #fcd34d; margin-top: 6px;
  }
  .changed-indicator.visible { display: flex; }

  .field-hint { font-size: 12px; color: #3d3f52; margin-top: 6px; }

  .form-actions {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 24px;
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
  .btn-back:hover { background: rgba(255,255,255,0.08); color: #8889a4; }

  .btn-update {
    display: inline-flex; align-items: center; gap: 7px;
    font-size: 13px; font-weight: 500; color: #fff;
    background: linear-gradient(135deg, #f59e0b, #fb923c);
    border: none; padding: 9px 20px; border-radius: 9px;
    cursor: pointer; transition: opacity 0.15s;
    opacity: 0.45; pointer-events: none;
  }
  .btn-update.active { opacity: 1; pointer-events: all; }
  .btn-update.active:hover { opacity: 0.88; }
</style>

{{-- SCRIPT --}}
<script>
  const originalValue = @json($kategori->nama_kategori);

  function handleInput(el) {
    // Update counter
    document.getElementById('charCounter').textContent = el.value.length + '/50';

    // Update slug preview
    const slug = el.value
      .toLowerCase()
      .replace(/[^a-z0-9\s-]/g, '')
      .trim()
      .replace(/\s+/g, '-');
    document.getElementById('slugPreview').value = slug;

    // Deteksi perubahan
    const hasChanged = el.value.trim() !== originalValue.trim();
    document.getElementById('changedBadge').classList.toggle('visible', hasChanged);

    // Aktifkan tombol hanya jika ada perubahan & tidak kosong
    const isValid = hasChanged && el.value.trim().length > 0;
    document.getElementById('btnUpdate').classList.toggle('active', isValid);
  }

  // Init saat halaman load
  document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('namaInput');
    if (input) handleInput(input);
  });
</script>

@endsection