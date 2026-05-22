<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Laporan Penjualan - Toko Parabot Rafauzi</title>
  <style>
    body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; font-size: 12px; line-height: 1.5; margin: 0; padding: 0; }
    .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 12px; margin-bottom: 20px; }
    .header h1 { font-size: 20px; margin: 0 0 6px 0; text-transform: uppercase; letter-spacing: 0.5px; }
    .header p { margin: 0; font-size: 12px; color: #666; }
    .meta { display: table; width: 100%; margin-bottom: 20px; font-size: 11px; }
    .meta-row { display: table-row; }
    .meta-col { display: table-cell; padding: 2px 0; }
    .meta-label { font-weight: bold; width: 100px; }
    .table-data { width: 100%; border-collapse: collapse; margin-top: 10px; }
    .table-data th { background: #f3f4f6; font-size: 10px; text-transform: uppercase; font-weight: bold; text-align: left; padding: 8px 10px; border-bottom: 1.5px solid #d1d5db; }
    .table-data td { padding: 8px 10px; border-bottom: 1px solid #e5e7eb; vertical-align: top; }
    .table-data tr:nth-child(even) td { background-color: #fafafa; }
    .total-row { background: #fef3c7 !important; font-weight: bold; font-size: 13px; }
    .total-row td { border-top: 1.5px solid #d1d5db; border-bottom: 1.5px solid #d1d5db; padding: 10px; }
    .text-right { text-align: right; }
    .footer { position: fixed; bottom: 0; left: 0; right: 0; border-top: 1px solid #e5e7eb; padding-top: 8px; text-align: center; font-size: 9px; color: #888; }
  </style>
</head>
<body>

  <div class="header">
    <h1>Toko Parabot Rafauzi</h1>
    <p>Laporan Transaksi Penjualan Barang</p>
    <p style="font-size: 10px; margin-top: 4px;">Tanggal Cetak: {{ now()->format('d M Y H:i') }} | Dicetak Oleh: {{ auth()->user()->name }}</p>
  </div>

  <div class="meta">
    <div class="meta-row">
      <div class="meta-col meta-label">Bulan Laporan:</div>
      <div class="meta-col">{{ $filterBulan }}</div>
    </div>
    <div class="meta-row">
      <div class="meta-col meta-label">Tahun Laporan:</div>
      <div class="meta-col">{{ $filterTahun }}</div>
    </div>
    <div class="meta-row">
      <div class="meta-col meta-label">Total Transaksi:</div>
      <div class="meta-col">{{ $transaksi->count() }} Transaksi</div>
    </div>
  </div>

  <table class="table-data">
    <thead>
      <tr>
        <th style="width: 30px;">#</th>
        <th style="width: 80px;">Tanggal</th>
        <th>Pelanggan</th>
        <th>Produk</th>
        <th style="width: 60px; text-align: center;">Jumlah</th>
        <th style="width: 120px; text-align: right;">Total Harga</th>
      </tr>
    </thead>
    <tbody>
      @forelse($transaksi as $t)
      @php
        $detail = $t->pesanan?->detailPesanan?->first();
        $produk = $detail?->produk;
        $user   = $t->pesanan?->user;
      @endphp
      <tr>
        <td>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
        <td>
          {{ $t->tanggal_transaksi
              ? \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d M Y')
              : \Carbon\Carbon::parse($t->created_at)->format('d M Y') }}
        </td>
        <td>{{ $user?->name ?? '—' }}</td>
        <td>
          <div>{{ $produk?->nama_produk ?? '—' }}</div>
          <div style="font-size: 9px; color: #666;">Kategori: {{ $produk?->kategori?->nama_kategori ?? '—' }}</div>
        </td>
        <td style="text-align: center;">{{ $detail?->jumlah ?? 0 }} unit</td>
        <td class="text-right">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="6" style="text-align: center; padding: 20px;">Tidak ada data transaksi untuk filter terpilih.</td>
      </tr>
      @endforelse

      @if($transaksi->count() > 0)
      <tr class="total-row">
        <td colspan="5" class="text-right">Total Pendapatan:</td>
        <td class="text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
      </tr>
      @endif
    </tbody>
  </table>

  <div class="footer">
    Dokumen ini digenerate secara otomatis oleh Sistem Informasi Toko Parabot Rafauzi.
  </div>

</body>
</html>
