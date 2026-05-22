<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #PSN-{{ str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 13px;
            color: #1e1e2e;
            background: #fff;
            padding: 40px;
        }

        /* ---- HEADER ---- */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 32px;
            padding-bottom: 20px;
            border-bottom: 2px solid #6366f1;
        }
        .header-left  { display: table-cell; vertical-align: middle; width: 60%; }
        .header-right { display: table-cell; vertical-align: middle; text-align: right; width: 40%; }

        .brand-name {
            font-size: 26px;
            font-weight: 700;
            color: #6366f1;
            letter-spacing: -0.5px;
        }
        .brand-sub {
            font-size: 12px;
            color: #6b7280;
            margin-top: 3px;
        }

        .invoice-label {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            letter-spacing: -1px;
        }
        .invoice-number {
            font-size: 14px;
            color: #6366f1;
            font-weight: 600;
            margin-top: 4px;
        }
        .invoice-date {
            font-size: 11px;
            color: #9ca3af;
            margin-top: 3px;
        }

        /* ---- STATUS BADGE ---- */
        .status-badge {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-top: 8px;
        }
        .status-selesai { background: #d1fae5; color: #059669; border: 1px solid #6ee7b7; }
        .status-pending { background: #fef3c7; color: #d97706; border: 1px solid #fcd34d; }

        /* ---- INFO GRID ---- */
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 28px;
            gap: 16px;
        }
        .info-box {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 20px;
        }
        .info-box:last-child { padding-right: 0; }
        .info-title {
            font-size: 10px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
            padding-bottom: 5px;
            border-bottom: 1px solid #f3f4f6;
        }
        .info-val { font-size: 13px; color: #111827; line-height: 1.7; }
        .info-val strong { color: #6366f1; }

        /* ---- ITEMS TABLE ---- */
        .items-title {
            font-size: 10px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 10px;
        }
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table.items thead tr {
            background: #6366f1;
            color: #fff;
        }
        table.items thead th {
            padding: 10px 14px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }
        table.items tbody tr {
            border-bottom: 1px solid #f3f4f6;
        }
        table.items tbody tr:last-child { border-bottom: none; }
        table.items tbody td {
            padding: 11px 14px;
            font-size: 13px;
            color: #374151;
        }
        table.items tbody tr:nth-child(even) {
            background: #f9fafb;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        /* ---- TOTALS ---- */
        .totals-wrap {
            width: 280px;
            margin-left: auto;
            margin-bottom: 28px;
        }
        .total-row {
            display: table;
            width: 100%;
            padding: 6px 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .total-row:last-child { border-bottom: none; }
        .total-label { display: table-cell; font-size: 12px; color: #6b7280; }
        .total-value { display: table-cell; text-align: right; font-size: 13px; color: #111827; font-weight: 600; }

        .grand-total-row {
            display: table;
            width: 100%;
            padding: 10px 14px;
            background: #6366f1;
            border-radius: 8px;
            margin-top: 8px;
        }
        .grand-total-label { display: table-cell; font-size: 13px; color: #fff; font-weight: 700; }
        .grand-total-value { display: table-cell; text-align: right; font-size: 16px; color: #fff; font-weight: 700; }

        /* ---- FOOTER ---- */
        .footer {
            margin-top: 36px;
            padding-top: 18px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 11px;
            color: #9ca3af;
            line-height: 1.8;
        }
        .footer strong { color: #6366f1; }

        .watermark {
            font-size: 11px;
            color: #d1d5db;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    {{-- ========== HEADER ========== --}}
    <div class="header">
        <div class="header-left">
            <div class="brand-name">🪑 Toko Parabot Rafauzi</div>
            <div class="brand-sub">Toko Perabot & Furniture Berkualitas</div>
        </div>
        <div class="header-right">
            <div class="invoice-label">INVOICE</div>
            <div class="invoice-number">#PSN-{{ str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) }}</div>
            <div class="invoice-date">
                Tanggal: {{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->format('d F Y') }}
            </div>
            <div>
                @if($pesanan->status_pesanan === 'selesai')
                    <span class="status-badge status-selesai">✓ LUNAS</span>
                @else
                    <span class="status-badge status-pending">⏳ PENDING</span>
                @endif
            </div>
        </div>
    </div>

    {{-- ========== INFO PELANGGAN & PENGIRIMAN ========== --}}
    <div class="info-grid">
        <div class="info-box">
            <div class="info-title">Informasi Pelanggan</div>
            <div class="info-val">
                <strong>{{ $pesanan->user->name ?? '-' }}</strong><br>
                {{ $pesanan->user->email ?? '-' }}<br>
                {{ $pesanan->alamat_pengiriman ?? 'Belum ada alamat.' }}
            </div>
        </div>
        <div class="info-box">
            <div class="info-title">Informasi Pembayaran</div>
            <div class="info-val">
                Metode: <strong>{{ $pesanan->metode_pembayaran ?? 'Transfer Bank' }}</strong><br>
                Pengiriman: <strong>{{ $pesanan->jasa_pengiriman ?? 'Diatur oleh Toko' }}</strong><br>
                @if($pesanan->transaksi)
                    Tanggal Bayar: {{ \Carbon\Carbon::parse($pesanan->transaksi->tanggal_transaksi)->format('d F Y, H:i') }}
                @endif
            </div>
        </div>
    </div>

    {{-- ========== TABEL ITEM ========== --}}
    <div class="items-title">Rincian Pesanan</div>
    <table class="items">
        <thead>
            <tr>
                <th style="width:5%">No</th>
                <th style="width:45%">Nama Produk</th>
                <th class="text-center" style="width:15%">Kategori</th>
                <th class="text-center" style="width:10%">Qty</th>
                <th class="text-right" style="width:12%">Harga Satuan</th>
                <th class="text-right" style="width:13%">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesanan->detailPesanan as $i => $detail)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $detail->produk->nama_produk ?? '-' }}</td>
                <td class="text-center">{{ $detail->produk->kategori->nama_kategori ?? '-' }}</td>
                <td class="text-center">{{ $detail->jumlah }}</td>
                <td class="text-right">Rp {{ number_format($detail->produk->harga ?? 0, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- ========== TOTALS ========== --}}
    <div class="totals-wrap">
        <div class="total-row">
            <span class="total-label">Subtotal</span>
            <span class="total-value">Rp {{ number_format($pesanan->detailPesanan->sum('subtotal'), 0, ',', '.') }}</span>
        </div>
        <div class="total-row">
            <span class="total-label">Biaya Pengiriman</span>
            <span class="total-value">Diatur oleh Toko</span>
        </div>
        <div class="grand-total-row">
            <span class="grand-total-label">TOTAL PEMBAYARAN</span>
            <span class="grand-total-value">Rp {{ number_format($pesanan->detailPesanan->sum('subtotal'), 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- ========== FOOTER ========== --}}
    <div class="footer">
        Terima kasih telah berbelanja di <strong>Toko Parabot Rafauzi</strong>!<br>
        Jika ada pertanyaan mengenai pesanan ini, silakan hubungi kami.<br>
        <span style="font-size:10px;">Invoice ini digenerate secara otomatis oleh sistem pada {{ \Carbon\Carbon::now()->format('d F Y, H:i') }} WIB</span>
    </div>

    <div class="watermark">
        &copy; {{ date('Y') }} Toko Parabot Rafauzi — Sistem Informasi Penjualan
    </div>

</body>
</html>
