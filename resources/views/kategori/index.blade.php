@extends('layouts.admin')

@section('page-title', 'Kategori')

@section('content')

{{-- PAGE HEADER --}}
<div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px;">
  <div>
    <h1 style="font-family:'Sora',sans-serif; font-size:22px; font-weight:600; color:#e8e9f5; letter-spacing:-0.4px;">
      Data Kategori
    </h1>
    <p style="font-size:13px; color:#4a4c6a; margin-top:3px;">Kelola semua kategori produk</p>
  </div>
  <a href="/kategori/create" class="btn-primary">
    ＋ Tambah Kategori
  </a>
</div>

{{-- FLASH MESSAGES --}}
@if(session('success'))
<div class="alert-flash alert-success">
  ✓ &nbsp;{{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert-flash alert-error">
  ✕ &nbsp;{{ session('error') }}
</div>
@endif

{{-- TABLE PANEL --}}
<div class="data-panel">

  {{-- Toolbar --}}
  <div class="table-toolbar">
    <div class="search-wrap">
      <span style="font-size:14px; color:#3d3f52;">🔍</span>
      <input type="text" placeholder="Cari kategori..." id="searchInput"
             oninput="filterTable(this.value)">
    </div>
    <span class="table-meta" id="tableCount">
      {{ $kategori->count() }} kategori ditemukan
    </span>
  </div>

  {{-- Table --}}
  <table class="data-table">
    <thead>
      <tr>
        <th style="width:48px;">#</th>
        <th>Nama Kategori</th>
        <th>Slug</th>
        <th style="text-align:right; padding-right:20px;">Aksi</th>
      </tr>
    </thead>
    <tbody id="tableBody">
      @forelse($kategori as $k)
      <tr>
        <td class="td-no">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>

        <td>
          <div style="display:flex; align-items:center; gap:8px;">
            <div style="width:6px; height:6px; border-radius:50%; background:#6366f1; flex-shrink:0;"></div>
            <span style="color:#d0d1e8; font-weight:500;">{{ $k->nama_kategori }}</span>
          </div>
        </td>

        <td>
          <span style="font-size:12px; color:#4a4c6a; font-family:monospace;">
            {{ Str::slug($k->nama_kategori) }}
          </span>
        </td>

        <td>
          <div style="display:flex; align-items:center; justify-content:flex-end; gap:6px;">
            <a href="/kategori/{{ $k->id }}/edit" class="btn-edit">
              ✏ Edit
            </a>
            <form action="/kategori/{{ $k->id }}" method="POST" style="display:inline;" 
                  onsubmit="return confirmDelete(event, '{{ $k->nama_kategori }}')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn-delete">
                🗑 Hapus
              </button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="4" style="text-align:center; padding:40px; color:#3d3f52; font-size:13px;">
          Belum ada kategori. 
          <a href="/kategori/create" style="color:#a5b4fc; text-decoration:none;">Tambah sekarang →</a>
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>

  {{-- Footer --}}
  <div class="table-footer">
    <span class="footer-info">
      Menampilkan {{ $kategori->count() }} data
    </span>
    {{-- Jika pakai pagination: --}}
    {{-- {{ $kategori->links('vendor.pagination.custom') }} --}}
  </div>

</div>

{{-- MODAL KONFIRMASI HAPUS --}}
<div id="deleteModal" style="display:none; position:fixed; inset:0; z-index:999;
     background:rgba(0,0,0,0.6); align-items:center; justify-content:center;">
  <div style="background:#13151f; border:0.5px solid rgba(255,255,255,0.1);
       border-radius:16px; padding:28px; width:360px; max-width:90%;">
    <div style="font-size:32px; text-align:center; margin-bottom:12px;">🗑️</div>
    <h3 style="font-family:'Sora',sans-serif; font-size:16px; font-weight:600;
        color:#e8e9f5; text-align:center; margin-bottom:8px;">Hapus Kategori</h3>
    <p style="font-size:13px; color:#6e70a0; text-align:center; margin-bottom:24px;">
      Yakin ingin menghapus kategori <strong id="deleteName" style="color:#c4c5e8;"></strong>?
      Tindakan ini tidak bisa dibatalkan.
    </p>
    <div style="display:flex; gap:10px;">
      <button onclick="cancelDelete()"
        style="flex:1; padding:10px; border-radius:9px; font-size:13px; font-weight:500;
               background:rgba(255,255,255,0.05); border:0.5px solid rgba(255,255,255,0.1);
               color:#8889a4; cursor:pointer;">
        Batal
      </button>
      <button id="confirmDeleteBtn"
        style="flex:1; padding:10px; border-radius:9px; font-size:13px; font-weight:500;
               background:rgba(248,113,113,0.15); border:0.5px solid rgba(248,113,113,0.3);
               color:#f87171; cursor:pointer;">
        Ya, Hapus
      </button>
    </div>
  </div>
</div>

{{-- STYLES --}}
<style>
  .btn-primary {
    display:inline-flex; align-items:center; gap:6px;
    background:linear-gradient(135deg,#6366f1,#8b5cf6);
    color:#fff; font-size:13px; font-weight:500;
    padding:9px 16px; border-radius:9px;
    text-decoration:none; white-space:nowrap;
    transition:opacity 0.15s;
  }
  .btn-primary:hover { opacity:0.88; }

  .alert-flash {
    display:flex; align-items:center; gap:10px;
    padding:12px 16px; border-radius:10px;
    font-size:13px; font-weight:500; margin-bottom:16px;
  }
  .alert-success { background:rgba(74,222,128,0.1); border:0.5px solid rgba(74,222,128,0.2); color:#4ade80; }
  .alert-error   { background:rgba(248,113,113,0.1); border:0.5px solid rgba(248,113,113,0.2); color:#f87171; }

  .data-panel {
    background:#13151f;
    border:0.5px solid rgba(255,255,255,0.07);
    border-radius:14px;
    overflow:hidden;
  }

  .table-toolbar {
    display:flex; align-items:center; justify-content:space-between;
    padding:16px 20px;
    border-bottom:0.5px solid rgba(255,255,255,0.05);
  }

  .search-wrap {
    display:flex; align-items:center; gap:8px;
    background:rgba(255,255,255,0.04);
    border:0.5px solid rgba(255,255,255,0.08);
    border-radius:8px; padding:0 12px;
  }
  .search-wrap input {
    background:none; border:none; outline:none;
    font-size:13px; color:#8889a4; padding:8px 0;
    width:200px; font-family:'DM Sans',sans-serif;
  }
  .search-wrap input::placeholder { color:#3d3f52; }

  .table-meta { font-size:12px; color:#3d3f52; }

  .data-table { width:100%; border-collapse:collapse; }
  .data-table thead th {
    font-size:11px; font-weight:500; color:#3d3f52;
    letter-spacing:0.8px; text-transform:uppercase;
    text-align:left; padding:12px 20px;
    border-bottom:0.5px solid rgba(255,255,255,0.05);
  }
  .data-table tbody tr { border-bottom:0.5px solid rgba(255,255,255,0.04); transition:background 0.12s; }
  .data-table tbody tr:last-child { border-bottom:none; }
  .data-table tbody tr:hover { background:rgba(255,255,255,0.025); }
  .data-table tbody td { padding:13px 20px; font-size:13.5px; color:#8889a4; vertical-align:middle; }

  .td-no { font-size:12px; color:#3d3f52; font-weight:500; }

  .btn-edit {
    display:inline-flex; align-items:center; gap:5px;
    font-size:12px; font-weight:500;
    background:rgba(99,102,241,0.12);
    border:0.5px solid rgba(99,102,241,0.25);
    color:#a5b4fc; padding:6px 12px; border-radius:7px;
    text-decoration:none; transition:background 0.15s;
  }
  .btn-edit:hover { background:rgba(99,102,241,0.22); }

  .btn-delete {
    display:inline-flex; align-items:center; gap:5px;
    font-size:12px; font-weight:500;
    background:rgba(248,113,113,0.08);
    border:0.5px solid rgba(248,113,113,0.2);
    color:#f87171; padding:6px 12px; border-radius:7px;
    cursor:pointer; transition:background 0.15s;
  }
  .btn-delete:hover { background:rgba(248,113,113,0.18); }

  .table-footer {
    display:flex; align-items:center; justify-content:space-between;
    padding:14px 20px;
    border-top:0.5px solid rgba(255,255,255,0.05);
  }
  .footer-info { font-size:12px; color:#3d3f52; }
</style>

{{-- SCRIPTS --}}
<script>
  let pendingForm = null;

  function confirmDelete(e, name) {
    e.preventDefault();
    pendingForm = e.target;
    document.getElementById('deleteName').textContent = name;
    document.getElementById('deleteModal').style.display = 'flex';
    return false;
  }

  function cancelDelete() {
    pendingForm = null;
    document.getElementById('deleteModal').style.display = 'none';
  }

  document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
    if (pendingForm) pendingForm.submit();
  });

  // Klik backdrop untuk tutup modal
  document.getElementById('deleteModal').addEventListener('click', function (e) {
    if (e.target === this) cancelDelete();
  });

  // Filter tabel live
  function filterTable(query) {
    const rows = document.querySelectorAll('#tableBody tr');
    let count = 0;
    rows.forEach(row => {
      const text = row.textContent.toLowerCase();
      const match = text.includes(query.toLowerCase());
      row.style.display = match ? '' : 'none';
      if (match) count++;
    });
    document.getElementById('tableCount').textContent = count + ' kategori ditemukan';
  }
</script>

@endsection