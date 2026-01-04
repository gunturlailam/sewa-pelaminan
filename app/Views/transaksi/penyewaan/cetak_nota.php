<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #<?= str_pad($penyewaan['id_sewa'], 5, '0', STR_PAD_LEFT) ?> - Mandah Pelaminan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            background: #f5f5f5;
        }

        .invoice-container {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 25px;
            border-bottom: 3px solid #696cff;
            margin-bottom: 30px;
        }

        .company-info h1 {
            font-size: 28px;
            color: #696cff;
            margin-bottom: 5px;
            font-weight: 700;
        }

        .company-info p {
            color: #666;
            font-size: 11px;
            line-height: 1.6;
        }

        .invoice-title {
            text-align: right;
        }

        .invoice-title h2 {
            font-size: 32px;
            color: #333;
            font-weight: 300;
            letter-spacing: 2px;
        }

        .invoice-number {
            background: linear-gradient(135deg, #696cff 0%, #8b5cf6 100%);
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
            margin-top: 10px;
        }

        /* Info Section */
        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .info-box {
            width: 48%;
        }

        .info-box h3 {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #999;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
        }

        .info-box p {
            margin-bottom: 3px;
            color: #333;
        }

        .info-box .label {
            color: #666;
            font-size: 10px;
        }

        .info-box .value {
            font-weight: 600;
            font-size: 13px;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-booking {
            background: #e0f2fe;
            color: #0369a1;
        }

        .status-berjalan {
            background: #fef3c7;
            color: #b45309;
        }

        .status-selesai {
            background: #dcfce7;
            color: #15803d;
        }

        .status-batal {
            background: #fee2e2;
            color: #dc2626;
        }

        /* Table */
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .invoice-table thead {
            background: linear-gradient(135deg, #696cff 0%, #8b5cf6 100%);
            color: white;
        }

        .invoice-table th {
            padding: 12px 15px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .invoice-table th:last-child,
        .invoice-table td:last-child {
            text-align: right;
        }

        .invoice-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .invoice-table tbody tr:hover {
            background: #f9fafb;
        }

        .item-name {
            font-weight: 600;
            color: #333;
        }

        .item-desc {
            font-size: 10px;
            color: #666;
            margin-top: 2px;
        }

        /* Totals */
        .invoice-totals {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 30px;
        }

        .totals-box {
            width: 300px;
        }

        .totals-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .totals-row.total {
            border-bottom: none;
            border-top: 2px solid #696cff;
            margin-top: 10px;
            padding-top: 15px;
        }

        .totals-row.total .label,
        .totals-row.total .value {
            font-size: 16px;
            font-weight: 700;
            color: #696cff;
        }

        .totals-row .label {
            color: #666;
        }

        .totals-row .value {
            font-weight: 600;
        }

        .totals-row.paid .value {
            color: #15803d;
        }

        .totals-row.due .value {
            color: #dc2626;
        }

        /* Payment Status */
        .payment-status {
            text-align: center;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .payment-status.lunas {
            background: #dcfce7;
            border: 1px solid #86efac;
        }

        .payment-status.lunas h4 {
            color: #15803d;
        }

        .payment-status.belum {
            background: #fef3c7;
            border: 1px solid #fcd34d;
        }

        .payment-status.belum h4 {
            color: #b45309;
        }

        /* Notes */
        .invoice-notes {
            background: #f8fafc;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            border-left: 4px solid #696cff;
        }

        .invoice-notes h4 {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #696cff;
            margin-bottom: 10px;
        }

        .invoice-notes p {
            color: #666;
            font-size: 11px;
        }

        /* Signatures */
        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
            padding-top: 30px;
        }

        .signature-box {
            text-align: center;
            width: 200px;
        }

        .signature-box .title {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 60px;
        }

        .signature-line {
            border-top: 1px solid #333;
            padding-top: 10px;
        }

        .signature-name {
            font-weight: 600;
            font-size: 12px;
        }

        .signature-role {
            font-size: 10px;
            color: #666;
        }

        /* Footer */
        .invoice-footer {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid #eee;
            margin-top: 30px;
        }

        .invoice-footer p {
            color: #999;
            font-size: 10px;
        }

        .invoice-footer .thank-you {
            font-size: 14px;
            color: #696cff;
            font-weight: 600;
            margin-bottom: 10px;
        }

        /* Print Styles */
        @media print {
            body {
                background: white;
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }

            .invoice-container {
                box-shadow: none;
                margin: 0;
                padding: 20px;
                max-width: 100%;
            }

            .no-print {
                display: none !important;
            }

            /* .invoice-table thead {
                background: #696cff !important;
                -webkit-print-color-adjust: exact;
            } */
        }

        /* Print Button */
        .print-actions {
            text-align: center;
            margin-bottom: 20px;
        }

        .btn-print {
            background: linear-gradient(135deg, #696cff 0%, #8b5cf6 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            margin: 0 5px;
            transition: all 0.2s;
        }

        .btn-print:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(105, 108, 255, 0.4);
        }

        .btn-back {
            background: #f1f5f9;
            color: #64748b;
        }

        .btn-back:hover {
            background: #e2e8f0;
            box-shadow: none;
            transform: none;
        }
    </style>
</head>

<body>
    <!-- Print Actions -->
    <div class="print-actions no-print">
        <button class="btn-print btn-back" onclick="window.history.back()">
            ← Kembali
        </button>
        <button class="btn-print" onclick="window.print()">
            🖨️ Cetak Invoice
        </button>
    </div>

    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <div class="company-info">
                <h1>👑 Mandah Pelaminan</h1>
                <p>
                    Jl. Contoh Alamat No. 123, Kota<br>
                    Telp: (021) 1234-5678 | WA: 0812-3456-7890<br>
                    Email: info@mandahpelaminan.com
                </p>
            </div>
            <div class="invoice-title">
                <h2>INVOICE</h2>
                <div class="invoice-number">#<?= str_pad($penyewaan['id_sewa'], 5, '0', STR_PAD_LEFT) ?></div>
            </div>
        </div>

        <!-- Info Section -->
        <div class="invoice-info">
            <div class="info-box">
                <h3>Ditagihkan Kepada</h3>
                <p class="value"><?= esc($penyewaan['nama_pelanggan']) ?></p>
                <p><span class="label">NIK:</span> <?= esc($penyewaan['nik'] ?? '-') ?></p>
                <p><span class="label">Telp:</span> <?= esc($penyewaan['telepon'] ?? '-') ?></p>
                <p><span class="label">Alamat:</span> <?= esc($penyewaan['alamat'] ?? '-') ?></p>
            </div>
            <div class="info-box" style="text-align: right;">
                <h3>Detail Invoice</h3>
                <p>
                    <span class="label">Tanggal Invoice:</span><br>
                    <span class="value"><?= date('d F Y', strtotime($penyewaan['created_at'] ?? 'now')) ?></span>
                </p>
                <p style="margin-top: 10px;">
                    <span class="label">Periode Sewa:</span><br>
                    <span class="value"><?= date('d M Y', strtotime($penyewaan['tanggal_sewa'])) ?> - <?= date('d M Y', strtotime($penyewaan['tanggal_kembali'])) ?></span>
                </p>
                <p style="margin-top: 10px;">
                    <span class="label">Status:</span><br>
                    <span class="status-badge status-<?= $penyewaan['status_sewa'] ?>"><?= ucfirst($penyewaan['status_sewa']) ?></span>
                </p>
            </div>
        </div>

        <!-- Alamat Acara -->
        <?php if (!empty($penyewaan['alamat_acara'])): ?>
            <div class="invoice-notes" style="margin-bottom: 20px;">
                <h4>📍 Alamat Acara</h4>
                <p style="font-size: 12px; color: #333;"><?= esc($penyewaan['alamat_acara']) ?></p>
            </div>
        <?php endif; ?>

        <!-- Items Table -->
        <table class="invoice-table">
            <thead>
                <tr>
                    <th style="width: 40px;">No</th>
                    <th>Item Pelaminan</th>
                    <th style="width: 80px; text-align: center;">Qty</th>
                    <th style="width: 120px;">Harga</th>
                    <th style="width: 130px;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($detail as $item): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td>
                            <div class="item-name"><?= esc($item['nama_pelaminan']) ?></div>
                            <div class="item-desc"><?= esc($item['jenis'] ?? '') ?> <?= !empty($item['warna']) ? '• ' . esc($item['warna']) : '' ?></div>
                        </td>
                        <td style="text-align: center;"><?= $item['jumlah'] ?></td>
                        <td>Rp <?= number_format($item['harga_sewa'] ?? ($item['subtotal'] / $item['jumlah']), 0, ',', '.') ?></td>
                        <td>Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Totals -->
        <div class="invoice-totals">
            <div class="totals-box">
                <div class="totals-row">
                    <span class="label">Subtotal</span>
                    <span class="value">Rp <?= number_format($penyewaan['total_bayar'], 0, ',', '.') ?></span>
                </div>
                <?php if (!empty($pembayaran)): ?>
                    <div class="totals-row paid">
                        <span class="label">Total Dibayar</span>
                        <span class="value">Rp <?= number_format($totalDibayar, 0, ',', '.') ?></span>
                    </div>
                    <div class="totals-row due">
                        <span class="label">Sisa Pembayaran</span>
                        <span class="value">Rp <?= number_format($sisaBayar, 0, ',', '.') ?></span>
                    </div>
                <?php endif; ?>
                <div class="totals-row total">
                    <span class="label">TOTAL</span>
                    <span class="value">Rp <?= number_format($penyewaan['total_bayar'], 0, ',', '.') ?></span>
                </div>
            </div>
        </div>

        <!-- Payment Status -->
        <?php if ($sisaBayar <= 0): ?>
            <div class="payment-status lunas">
                <h4>✅ LUNAS</h4>
                <p>Pembayaran telah diterima dengan lengkap</p>
            </div>
        <?php else: ?>
            <div class="payment-status belum">
                <h4>⏳ BELUM LUNAS</h4>
                <p>Sisa pembayaran: <strong>Rp <?= number_format($sisaBayar, 0, ',', '.') ?></strong></p>
            </div>
        <?php endif; ?>

        <!-- Payment History -->
        <?php if (!empty($pembayaran)): ?>
            <div class="invoice-notes">
                <h4>💳 Riwayat Pembayaran</h4>
                <table style="width: 100%; font-size: 11px; margin-top: 10px;">
                    <?php foreach ($pembayaran as $bayar): ?>
                        <tr>
                            <td style="padding: 5px 0;"><?= date('d/m/Y', strtotime($bayar['tanggal_bayar'])) ?></td>
                            <td style="padding: 5px 0;"><?= ucfirst($bayar['metode_bayar'] ?? 'Tunai') ?></td>
                            <td style="padding: 5px 0;"><?= esc($bayar['keterangan'] ?? '-') ?></td>
                            <td style="padding: 5px 0; text-align: right; font-weight: 600;">Rp <?= number_format($bayar['jumlah_bayar'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>

        <!-- Notes -->
        <?php if (!empty($penyewaan['catatan'])): ?>
            <div class="invoice-notes">
                <h4>📝 Catatan</h4>
                <p><?= esc($penyewaan['catatan']) ?></p>
            </div>
        <?php endif; ?>

        <!-- Terms -->
        <div class="invoice-notes">
            <h4>📋 Syarat & Ketentuan</h4>
            <p>
                1. Barang yang disewa harus dikembalikan dalam kondisi baik.<br>
                2. Kerusakan atau kehilangan menjadi tanggung jawab penyewa.<br>
                3. Pembatalan H-3 dikenakan biaya 50% dari total sewa.<br>
                4. Invoice ini sah sebagai bukti transaksi.
            </p>
        </div>

        <!-- Signatures -->
        <div class="signatures">
            <div class="signature-box">
                <div class="title">Penyewa</div>
                <div class="signature-line">
                    <div class="signature-name"><?= esc($penyewaan['nama_pelanggan']) ?></div>
                    <div class="signature-role">Pelanggan</div>
                </div>
            </div>
            <div class="signature-box">
                <div class="title">Hormat Kami</div>
                <div class="signature-line">
                    <div class="signature-name">Mandah Pelaminan</div>
                    <div class="signature-role">Admin</div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="invoice-footer">
            <p class="thank-you">Terima kasih atas kepercayaan Anda! 🙏</p>
            <p>
                Invoice ini dicetak pada <?= date('d F Y, H:i') ?> WIB<br>
                © <?= date('Y') ?> Mandah Pelaminan - All Rights Reserved
            </p>
        </div>
    </div>

    <script>
        // Auto print when page loads (optional - uncomment to enable)
        // window.onload = function() { window.print(); }
    </script>
</body>

</html>