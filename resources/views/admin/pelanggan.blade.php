@extends('layouts.admin')

@section('page-title', 'Pelanggan')

@section('content')

<div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
  <div>
    <h1 style="font-family:'Sora',sans-serif; font-size:22px; font-weight:600; color:#e8e9f5; letter-spacing:-0.4px;">
      Kelola Pelanggan
    </h1>
    <p style="font-size:13px; color:#4a4c6a; margin-top:3px;">Daftar semua pelanggan terdaftar</p>
  </div>
  <div style="display:flex; align-items:center; gap:8px; padding:8px 14px;
    background:rgba(99,102,241,0.08); border:0.5px solid rgba(99,102,241,0.2);
    border-radius:10px;">
    <span style="font-size:18px;">👥</span>
    <div>
      <div style="font-size:10px; color:#a5b4fc; font-weight:500; letter-spacing:0.5px;">TOTAL</div>
      <div style="font-size:18px; font-weight:700; color:#a5b4fc; font-family:'Sora',sans-serif; line-height:1;">
        {{ $pelanggan->count() }}
      </div>
    </div>
  </div>
</div>

<div class="data-panel">

  {{-- Toolbar --}}
  <div style="padding:14px 20px; border-bottom:0.5px solid rgba(255,255,255,0.05);
    display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
    <div style="display:flex; align-items:center; gap:8px;
      background:rgba(255,255,255,0.04); border:0.5px solid rgba(255,255,255,0.08);
      border-radius:8px; padding:0 12px;">
      <span style="font-size:13px; color:#3d3f52;">🔍</span>
      <input type="text" id="searchInput" placeholder="Cari pelanggan..." oninput="filterTable()"
        style="background:none; border:none; outline:none; font-size:13px;
               color:#8889a4; padding:8px 0; width:180px; font-family:'DM Sans',sans-serif;">
    </div>
    <span id="tableCount" style="font-size:12px; color:#3d3f52; margin-left:auto;">
      {{ $pelanggan->count() }} pelanggan
    </span>
  </div>

  <table class="data-table">
    <thead>
      <tr>
        <th>#</th>
        <th>Pelanggan</th>
        <th>Email</th>
        <th>Terdaftar</th>
        <th style="text-align:center;">Total Pesanan</th>
        <th style="text-align:center;">Status</th>
      </tr>
    </thead>
    <tbody id="tableBody">
      @forelse($pelanggan as $u)
      <tr data-nama="{{ strtolower($u->name) }}" data-email="{{ strtolower($u->email) }}">
        <td class="td-no">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
        <td>
          <div style="display:flex; align-items:center; gap:10px;">
            <div style="width:34px; height:34px; border-radius:50%;
              background:linear-gradient(135deg,#6366f1,#8b5cf6);
              display:flex; align-items:center; justify-content:center;
              font-size:12px; font-weight:700; color:#fff; font-family:'Sora',sans-serif;
              flex-shrink:0;">
              {{ strtoupper(substr($u->name, 0, 2)) }}
            </div>
            <div>
              <div style="font-size:13.5px; font-weight:500; color:#d0d1e8;">{{ $u->name }}</div>
              <div style="font-size:11px; color:#3d3f52;">ID #{{ str_pad($u->id, 4, '0', STR_PAD_LEFT) }}</div>
            </div>
          </div>
        </td>
        <td style="font-size:13px; color:#8889a4;">{{ $u->email }}</td>
        <td style="font-size:12px; color:#6e70a0;">
          {{ \Carbon\Carbon::parse($u->created_at)->format('d M Y') }}
        </td>
        <td style="text-align:center;">
          @php $totalPesanan = $u->pesanan->count(); @endphp
          <span style="font-size:14px; font-weight:700; color:#a5b4fc; font-family:'Sora',sans-serif;">
            {{ $totalPesanan }}
          </span>
          <span style="font-size:11px; color:#4a4c6a;">pesanan</span>
        </td>
        <td style="text-align:center;">
          <span style="font-size:11px; font-weight:600; padding:3px 10px; border-radius:20px;
            background:rgba(74,222,128,0.1); border:0.5px solid rgba(74,222,128,0.2); color:#4ade80;">
            ● Aktif
          </span>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="6" style="text-align:center; padding:48px; color:#3d3f52; font-size:13px;">
          Belum ada pelanggan terdaftar.
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>

</div>

<style>
  .data-panel { background:#13151f; border:0.5px solid rgba(255,255,255,0.07); border-radius:14px; overflow:hidden; }
  .data-table { width:100%; border-collapse:collapse; }
  .data-table thead th {
    font-size:11px; font-weight:500; color:#3d3f52; letter-spacing:0.7px;
    text-transform:uppercase; text-align:left; padding:11px 16px;
    border-bottom:0.5px solid rgba(255,255,255,0.05);
  }
  .data-table tbody tr { border-bottom:0.5px solid rgba(255,255,255,0.04); transition:background 0.12s; }
  .data-table tbody tr:last-child { border-bottom:none; }
  .data-table tbody tr:hover { background:rgba(255,255,255,0.025); }
  .data-table tbody td { padding:13px 16px; font-size:13px; color:#8889a4; vertical-align:middle; }
  .td-no { font-size:11px; color:#3d3f52; font-weight:500; }
</style>

<script>
  function filterTable() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#tableBody tr[data-nama]');
    let count = 0;
    rows.forEach(r => {
      const nm = r.dataset.nama + ' ' + r.dataset.email;
      const show = nm.includes(q);
      r.style.display = show ? '' : 'none';
      if (show) count++;
    });
    document.getElementById('tableCount').textContent = count + ' pelanggan';
  }
</script>

@endsection
