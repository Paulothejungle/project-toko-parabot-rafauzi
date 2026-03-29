@extends('layouts.admin')

@section('page-title', 'Tambah Kategori')

@section('content')

{{-- BREADCRUMB & HEADER --}}
<div style="margin-bottom:24px;">
  <div style="display:flex; align-items:center; gap:6px; font-size:12px; color:#3d3f52; margin-bottom:10px;">
    <a href="/admin/dashboard" style="color:#6e70a0; text-decoration:none;">Dashboard</a> ›
    <a href="/kategori" style="color:#6e70a0; text-decoration:none;">Kategori</a> ›
    <span style="color:#6e70a0;">Tambah</span>
  </div>
  <h1 style="font-family:'Sora',sans-serif; font-size:22px; font-weight:600; color:#e8e9f5; letter-spacing:-0.4px;">
    Tambah Kategori
  </h1>
  <p style="font-size:13px; color:#4a4c6a; margin-top:3px;">Buat kategori produk baru</p>
</div>

{{-- FORM CARD --}}
<div class="form-card" style="max-width:520px;">

  <div class="form-card-header">
    <div class="form-icon">📁</div>
    <div>
      <div class="form-card-title">Informasi Kategori</div>
      <div class="form-card-sub">Isi detail kategori di bawah ini</div>
    </div>
  </div>

  <form method="POST" action="/kategori" id="kategoriForm" novalidate>
    @csrf

    <div class="form-body">

      {{-- Error --}}
      @if($errors->any())
      <div class="alert-error">
        ✕ &nbsp;{{ $errors->first('nama_kategori') }}
      </div>
      @endif

      {{-- Nama Kategori --}}
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
            value="{{ old('nama_kategori') }}"
            placeholder="Contoh: Alat Pembersih, Aksesori, Alat Masak..."
            class="field-input {{ $errors->has('nama_kategori') ? 'field-input-error' : '' }}"
            oninput="handleInput(this)"
            required
          >
          <span class="char-counter" id="charCounter">
            {{ strlen(old('nama_kategori', '')) }}/50
          </span>
        </div>
        <div class="field-hint">Gunakan nama yang jelas dan mudah dikenali.</div>
      </div>

      {{-- Slug Preview (opsional, read-only) --}}
      <div class="field-group" style="margin-bottom:0;">
        <div class="field-label">Slug <span style="color:#3d3f52; font-weight:400; text-transform:none; letter-spacing:0;">(otomatis)</span></div>
        <input
          type="text"
          id="slugPreview"
          class="field-input"
          placeholder="nama-kategori"
          readonly
          value="{{ Str::slug(old('nama_kategori', '')) }}"
          style="color:#4a4c6a; font-family:monospace; font-size:13px;"
        >
        <div class="field-hint">Dibuat otomatis dari nama kategori.</div>
      </div>

    </div>

    {{-- ACTIONS --}}
    <div class="form-actions">
      <a href="/kategori" class="btn-back">← Kembali</a>
      <button type="submit" class="btn-save">💾 Simpan Kategori</button>
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
    display: flex; align-items: center; gap: 12px;
  }

  .form-icon {
    width: 36px; height: 36px; border-radius: 9px;
    background: rgba(99,102,241,0.15);
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; flex-shrink: 0;
  }

  .form-card-title { font-family:'Sora',sans-serif; font-size:15px; font-weight:600; color:#d0d1e8; }
  .form-card-sub { font-size:12px; color:#4a4c6a; margin-top:2px; }

  .form-body { padding: 24px; }

  .alert-error {
    display: flex; align-items: flex-start; gap: 10px;
    padding: 12px 14px; border-radius: 10px;
    font-size: 13px; font-weight: 500; margin-bottom: 20px;
    background: rgba(248,113,113,0.1);
    border: 0.5px solid rgba(248,113,113,0.25);
    color: #f87171;
  }

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
    width: 100%; padding: 11px 44px 11px 14px;
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
    border-color: rgba(99,102,241,0.5);
    background: rgba(99,102,241,0.04);
    box-shadow: 0 0 0 3px rgba(99,102,241,0.08);
  }
  .field-input-error {
    border-color: rgba(248,113,113,0.5) !important;
  }
  .field-input-error:focus {
    box-shadow: 0 0 0 3px rgba(248,113,113,0.08) !important;
  }

  .char-counter {
    position: absolute; right: 12px; top: 50%;
    transform: translateY(-50%);
    font-size: 11px; color: #3d3f52; pointer-events: none;
  }

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
  function handleInput(el) {
    // Counter
    document.getElementById('charCounter').textContent = el.value.length + '/50';

    // Slug preview
    const slug = el.value
      .toLowerCase()
      .replace(/[^a-z0-9\s-]/g, '')
      .trim()
      .replace(/\s+/g, '-');
    document.getElementById('slugPreview').value = slug;

    // Reset error state saat diketik
    if (el.value.length > 0) {
      el.classList.remove('field-input-error');
    }
  }

  // Init counter dari old value
  document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('namaInput');
    if (input && input.value) handleInput(input);
  });
</script>

@endsection