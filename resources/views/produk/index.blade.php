@extends('layouts.admin')

@section('page-title', 'Produk')

@section('content')

{{-- HEADER --}}
<div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px;">
  <div>
    <h1 style="font-family:'Sora',sans-serif; font-size:22px; font-weight:600; color:#e8e9f5; letter-spacing:-0.4px;">
      Data Produk
    </h1>
    <p style="font-size:13px; color:#4a4c6a; margin-top:3px;">Kelola seluruh produk yang tersedia</p>
  </div>
  <a href="/produk/create" class="btn-primary">＋ Tambah Produk</a>
</div>

{{-- FLASH --}}
@if(session('success'))
<div class="alert-flash alert-success">✓ &nbsp;{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert-flash alert-error">✕ &nbsp;{{ session('error') }}</div>
@endif

{{-- PANEL --}}
<div class="data-panel">

  {{-- Toolbar --}}
  <div class="table-toolbar">
    <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
      <div class="search-wrap">
        <span style="font-size:13px; color:#3d3f52;">🔍</span>
        <input type="text" id="searchInput" placeholder="Cari produk..." oninput="filterTable()">
      </div>
      <select class="filter-select" id="filterKategori" onchange="filterTable()">
        <option value="">Semua Kategori</option>
        @foreach($kategori as $kat)
        <option value="{{ $kat->nama_kategori }}">{{ $kat->nama_kategori }}</option>
        @endforeach
      </select>
    </div>
    <span class="table-meta" id="tableCount">{{ $produk->count() }} produk</span>
  </div>

  {{-- Table --}}
  <table class="data-table">
    <thead>
      <tr>
        <th style="width:40px;">#</th>
        <th>Produk</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Kategori</th>
        <th style="text-align:right; padding-right:16px;">Aksi</th>
      </tr>
    </thead>
    <tbody id="tableBody">
      @forelse($produk as $p)

      @php
        $stokPersen = $p->stok > 0 ? min(($p->stok / 50) * 100, 100) : 0;
        $stokColor  = $p->stok == 0 ? '#f87171' : ($p->stok <= 5 ? '#fb923c' : '#4ade80');
        $catColors  = ['#6366f1','#14b8a6','#f59e0b','#f87171','#8b5cf6','#06b6d4'];
        $catColor   = $catColors[$loop->index % count($catColors)];
      @endphp

      <tr data-nama="{{ strtolower($p->nama_produk) }}"
          data-kategori="{{ $p->kategori->nama_kategori }}">

        <td class="td-no">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>

        {{-- Produk --}}
        <td>
          <div style="display:flex; align-items:center; gap:12px;">
            <div class="product-thumb">
              @if($p->image)
                <img src="{{ asset('storage/'.$p->image) }}" alt="{{ $p->nama_produk }}">
              @else
                📦
              @endif
            </div>
            <div>
              <div style="font-size:13.5px; font-weight:500; color:#d0d1e8;">{{ $p->nama_produk }}</div>
              <div style="font-size:11px; color:#3d3f52;">#PRD-{{ str_pad($p->id, 3, '0', STR_PAD_LEFT) }}</div>
            </div>
          </div>
        </td>

        {{-- Harga --}}
        <td>
          <div style="font-size:13.5px; font-weight:500; color:#c4c5e8; font-family:'Sora',sans-serif;">
            Rp {{ number_format($p->harga, 0, ',', '.') }}
          </div>
        </td>

        {{-- Stok --}}
        <td>
          <div style="display:flex; align-items:center; gap:8px;">
            <div style="width:48px; height:4px; background:rgba(255,255,255,0.06); border-radius:2px; overflow:hidden;">
              <div style="width:{{ $stokPersen }}%; height:100%; background:{{ $stokColor }}; border-radius:2px;"></div>
            </div>
            <span style="font-size:13px; color:{{ $stokColor }};">{{ $p->stok }}</span>
            @if($p->stok == 0)
              <span style="font-size:10px; background:rgba(248,113,113,0.1); color:#f87171; padding:1px 6px; border-radius:4px;">Habis</span>
            @elseif($p->stok <= 5)
              <span style="font-size:10px; background:rgba(251,146,60,0.1); color:#fb923c; padding:1px 6px; border-radius:4px;">Sedikit</span>
            @endif
          </div>
        </td>

        {{-- Kategori --}}
        <td>
          <span style="display:inline-flex; align-items:center; gap:5px; font-size:11px; font-weight:500;
                       padding:3px 8px; border-radius:20px;
                       background:rgba(99,102,241,0.1); border:0.5px solid rgba(99,102,241,0.2); color:#a5b4fc;">
            <span style="width:5px; height:5px; border-radius:50%; background:{{ $catColor }}; display:inline-block;"></span>
            {{ $p->kategori->nama_kategori }}
          </span>
        </td>

        {{-- Aksi --}}
        <td>
          <div style="display:flex; align-items:center; justify-content:flex-end; gap:6px;">
            <a href="/produk/{{ $p->id }}/edit" class="btn-edit">✏ Edit</a>
            <form action="/produk/{{ $p->id }}" method="POST" style="display:inline;"
                  onsubmit="return confirmDelete(event, '{{ $p->nama_produk }}')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn-delete">🗑 Hapus</button>
            </form>
          </div>
        </td>

      </tr>
      @empty
      <tr>
        <td colspan="6" style="text-align:center; padding:48px; color:#3d3f52; font-size:13px;">
          Belum ada produk.
          <a href="/produk/create" style="color:#a5b4fc; text-decoration:none;">Tambah sekarang →</a>
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>

  {{-- Footer --}}
  <div class="table-footer">
    <span class="footer-info">Menampilkan {{ $produk->count() }} produk</span>
    {{ $produk->links('vendor.pagination.custom') }}
  </div>

</div>

{{-- MODAL HAPUS --}}
<div id="deleteModal" style="display:none; position:fixed; inset:0; z-index:999;
     background:rgba(0,0,0,0.65); align-items:center; justify-content:center;">
  <div style="background:#13151f; border:0.5px solid rgba(255,255,255,0.1);
       border-radius:16px; padding:28px; width:360px; max-width:90%;">
    <div style="font-size:32px; text-align:center; margin-bottom:12px;">🗑️</div>
    <h3 style="font-family:'Sora',sans-serif; font-size:16px; font-weight:600;
        color:#e8e9f5; text-align:center; margin-bottom:8px;">Hapus Produk</h3>
    <p style="font-size:13px; color:#6e70a0; text-align:center; margin-bottom:24px; line-height:1.6;">
      Yakin ingin menghapus produk<br>
      <strong id="deleteName" style="color:#c4c5e8;"></strong>?
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
    text-decoration:none; transition:opacity 0.15s;
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
    border-radius:14px; overflow:hidden;
  }

  .table-toolbar {
    display:flex; align-items:center; justify-content:space-between;
    padding:14px 20px; border-bottom:0.5px solid rgba(255,255,255,0.05);
    flex-wrap:wrap; gap:10px;
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
    width:180px; font-family:'DM Sans',sans-serif;
  }
  .search-wrap input::placeholder { color:#3d3f52; }

  .filter-select {
    background:rgba(255,255,255,0.04);
    border:0.5px solid rgba(255,255,255,0.08);
    border-radius:8px; padding:7px 12px;
    font-size:12px; color:#6e70a0;
    font-family:'DM Sans',sans-serif; outline:none; cursor:pointer;
  }

  .table-meta { font-size:12px; color:#3d3f52; }

  .data-table { width:100%; border-collapse:collapse; }
  .data-table thead th {
    font-size:11px; font-weight:500; color:#3d3f52;
    letter-spacing:0.8px; text-transform:uppercase;
    text-align:left; padding:11px 16px;
    border-bottom:0.5px solid rgba(255,255,255,0.05);
  }
  .data-table tbody tr { border-bottom:0.5px solid rgba(255,255,255,0.04); transition:background 0.12s; }
  .data-table tbody tr:last-child { border-bottom:none; }
  .data-table tbody tr:hover { background:rgba(255,255,255,0.025); }
  .data-table tbody td { padding:12px 16px; font-size:13px; color:#8889a4; vertical-align:middle; }

  .td-no { font-size:11px; color:#3d3f52; font-weight:500; }

  .product-thumb {
    width:40px; height:40px; border-radius:8px;
    background:rgba(255,255,255,0.05);
    border:0.5px solid rgba(255,255,255,0.07);
    display:flex; align-items:center; justify-content:center;
    font-size:18px; overflow:hidden; flex-shrink:0;
  }
  .product-thumb img { width:100%; height:100%; object-fit:cover; }

  .btn-edit {
    display:inline-flex; align-items:center; gap:4px;
    font-size:11px; font-weight:500;
    background:rgba(99,102,241,0.12);
    border:0.5px solid rgba(99,102,241,0.25);
    color:#a5b4fc; padding:5px 10px; border-radius:7px;
    text-decoration:none; transition:background 0.15s;
  }
  .btn-edit:hover { background:rgba(99,102,241,0.22); }

  .btn-delete {
    display:inline-flex; align-items:center; gap:4px;
    font-size:11px; font-weight:500;
    background:rgba(248,113,113,0.08);
    border:0.5px solid rgba(248,113,113,0.2);
    color:#f87171; padding:5px 10px; border-radius:7px;
    cursor:pointer; transition:background 0.15s;
  }
  .btn-delete:hover { background:rgba(248,113,113,0.18); }

  .table-footer {
    display:flex; align-items:center; justify-content:space-between;
    padding:13px 20px;
    border-top:0.5px solid rgba(255,255,255,0.05);
  }
  .footer-info { font-size:12px; color:#3d3f52; }
</style>

{{-- SCRIPT --}}
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

  document.getElementById('confirmDeleteBtn').addEventListener('click', () => {
    if (pendingForm) pendingForm.submit();
  });

  document.getElementById('deleteModal').addEventListener('click', function (e) {
    if (e.target === this) cancelDelete();
  });

  function filterTable() {
    const search   = document.getElementById('searchInput').value.toLowerCase();
    const kategori = document.getElementById('filterKategori').value.toLowerCase();
    const rows     = document.querySelectorAll('#tableBody tr[data-nama]');
    let count = 0;

    rows.forEach(row => {
      const nama = row.dataset.nama || '';
      const kat  = (row.dataset.kategori || '').toLowerCase();
      const matchSearch   = nama.includes(search);
      const matchKategori = !kategori || kat === kategori;
      const show = matchSearch && matchKategori;
      row.style.display = show ? '' : 'none';
      if (show) count++;
    });

    document.getElementById('tableCount').textContent = count + ' produk';
  }
</script>

@endsection