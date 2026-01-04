<?= $this->extend('index') ?>
<?= $this->section('content') ?>

<style>
    .history-header {
        background: linear-gradient(135deg, #696cff 0%, #8b5cf6 50%, #a855f7 100%);
        border-radius: 20px;
        padding: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .history-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .history-header h2 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .history-header p {
        opacity: 0.9;
        margin-bottom: 0;
        position: relative;
        z-index: 1;
    }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 992px) {
        .stats-row {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .stats-row {
            grid-template-columns: 1fr;
        }
    }

    .stat-box {
        background: #fff;
        border: 1px solid rgba(148, 163, 184, 0.1);
        border-radius: 16px;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
    }

    .stat-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }

    .stat-box-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stat-box-icon.purple {
        background: rgba(105, 108, 255, 0.1);
        color: #696cff;
    }

    .stat-box-icon.blue {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
    }

    .stat-box-icon.green {
        background: rgba(34, 197, 94, 0.1);
        color: #22c55e;
    }

    .stat-box-icon.orange {
        background: rgba(249, 115, 22, 0.1);
        color: #f97316;
    }

    .stat-box-content h4 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        color: #1e293b;
    }

    .stat-box-content span {
        font-size: 0.8rem;
        color: #64748b;
    }

    .history-card {
        background: #fff;
        border: 1px solid rgba(148, 163, 184, 0.1);
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    .history-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.1);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .history-card-header h5 {
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .history-card-header h5 i {
        color: #696cff;
    }

    .table-modern {
        margin: 0;
    }

    .table-modern thead th {
        background: rgba(105, 108, 255, 0.04);
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        padding: 1rem 1.25rem;
        border-bottom: 2px solid rgba(148, 163, 184, 0.1);
    }

    .table-modern tbody td {
        padding: 1rem 1.25rem;
        vertical-align: middle;
        border-bottom: 1px solid rgba(148, 163, 184, 0.08);
        color: #1e293b;
    }

    .table-modern tbody tr {
        transition: background 0.2s;
    }

    .table-modern tbody tr:hover {
        background: rgba(105, 108, 255, 0.02);
    }

    .nota-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.4rem 0.75rem;
        background: rgba(105, 108, 255, 0.1);
        color: #696cff;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .status-badge {
        padding: 0.4rem 0.85rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .status-badge.lunas {
        background: rgba(34, 197, 94, 0.15);
        color: #16a34a;
    }

    .status-badge.belum {
        background: rgba(239, 68, 68, 0.15);
        color: #dc2626;
    }

    .status-sewa {
        padding: 0.35rem 0.75rem;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.75rem;
    }

    .status-sewa.booking {
        background: rgba(59, 130, 246, 0.15);
        color: #2563eb;
    }

    .status-sewa.berjalan {
        background: rgba(234, 179, 8, 0.15);
        color: #ca8a04;
    }

    .status-sewa.selesai {
        background: rgba(34, 197, 94, 0.15);
        color: #16a34a;
    }

    .status-sewa.batal {
        background: rgba(239, 68, 68, 0.15);
        color: #dc2626;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }

    .empty-state i {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 1rem;
    }

    .empty-state h5 {
        color: #64748b;
        font-weight: 600;
    }

    .empty-state p {
        color: #94a3b8;
        font-size: 0.9rem;
    }

    .btn-detail {
        padding: 0.4rem 0.75rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 500;
        background: rgba(105, 108, 255, 0.1);
        color: #696cff;
        border: none;
        transition: all 0.2s;
    }

    .btn-detail:hover {
        background: #696cff;
        color: white;
    }

    /* Dark mode */
    [data-theme="dark"] .stat-box,
    [data-theme="dark"] .history-card {
        background: #1e293b;
    }

    [data-theme="dark"] .stat-box-content h4,
    [data-theme="dark"] .table-modern tbody td {
        color: #f1f5f9;
    }

    [data-theme="dark"] .table-modern thead th {
        background: rgba(105, 108, 255, 0.08);
        color: #94a3b8;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="history-header animate-fade-in">
        <h2><i class='bx bx-history me-2'></i>Riwayat Transaksi Saya</h2>
        <p>Lihat semua riwayat penyewaan dan status pembayaran Anda</p>
    </div>

    <!-- Stats Row -->
    <div class="stats-row">
        <div class="stat-box animate-fade-in" style="animation-delay: 0.1s">
            <div class="stat-box-icon purple">
                <i class='bx bx-receipt'></i>
            </div>
            <div class="stat-box-content">
                <h4><?= $totalTransaksi ?></h4>
                <span>Total Transaksi</span>
            </div>
        </div>

        <div class="stat-box animate-fade-in" style="animation-delay: 0.2s">
            <div class="stat-box-icon blue">
                <i class='bx bx-wallet'></i>
            </div>
            <div class="stat-box-content">
                <h4>Rp <?= number_format($totalNilai, 0, ',', '.') ?></h4>
                <span>Total Nilai</span>
            </div>
        </div>

        <div class="stat-box animate-fade-in" style="animation-delay: 0.3s">
            <div class="stat-box-icon green">
                <i class='bx bx-check-circle'></i>
            </div>
            <div class="stat-box-content">
                <h4><?= $lunas ?></h4>
                <span>Lunas</span>
            </div>
        </div>

        <div class="stat-box animate-fade-in" style="animation-delay: 0.4s">
            <div class="stat-box-icon orange">
                <i class='bx bx-time-five'></i>
            </div>
            <div class="stat-box-content">
                <h4><?= $belumLunas ?></h4>
                <span>Belum Lunas</span>
            </div>
        </div>
    </div>

    <!-- History Table -->
    <div class="history-card animate-fade-in" style="animation-delay: 0.5s">
        <div class="history-card-header">
            <h5><i class='bx bx-list-ul'></i> Daftar Transaksi</h5>
        </div>

        <?php if (empty($riwayat)): ?>
            <div class="empty-state">
                <i class='bx bx-inbox'></i>
                <h5>Belum Ada Transaksi</h5>
                <p>Anda belum memiliki riwayat transaksi penyewaan</p>
                <a href="<?= site_url('transaksi/penyewaan/create') ?>" class="btn btn-primary mt-3">
                    <i class='bx bx-plus me-1'></i> Buat Penyewaan Baru
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th>No. Nota</th>
                            <th>Tanggal Sewa</th>
                            <th>Tanggal Kembali</th>
                            <th>Total Harga</th>
                            <th>Dibayar</th>
                            <th>Sisa</th>
                            <th>Status Sewa</th>
                            <th>Status Bayar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($riwayat as $item): ?>
                            <tr>
                                <td>
                                    <span class="nota-badge">
                                        <i class='bx bx-receipt'></i>
                                        #<?= str_pad($item['id_sewa'], 5, '0', STR_PAD_LEFT) ?>
                                    </span>
                                </td>
                                <td>
                                    <i class='bx bx-calendar text-muted me-1'></i>
                                    <?= date('d M Y', strtotime($item['tanggal_sewa'])) ?>
                                </td>
                                <td>
                                    <i class='bx bx-calendar-check text-muted me-1'></i>
                                    <?= date('d M Y', strtotime($item['tanggal_kembali'])) ?>
                                </td>
                                <td>
                                    <strong>Rp <?= number_format($item['total_bayar'], 0, ',', '.') ?></strong>
                                </td>
                                <td>
                                    <span class="text-success">Rp <?= number_format($item['total_dibayar'], 0, ',', '.') ?></span>
                                </td>
                                <td>
                                    <?php if ($item['sisa_bayar'] > 0): ?>
                                        <span class="text-danger">Rp <?= number_format($item['sisa_bayar'], 0, ',', '.') ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="status-sewa <?= $item['status_sewa'] ?>">
                                        <?= ucfirst($item['status_sewa']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($item['status_bayar'] == 'Lunas'): ?>
                                        <span class="status-badge lunas">
                                            <i class='bx bx-check-circle'></i> Lunas
                                        </span>
                                    <?php else: ?>
                                        <span class="status-badge belum">
                                            <i class='bx bx-time-five'></i> Belum Lunas
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= site_url('transaksi/penyewaan/detail/' . $item['id_sewa']) ?>" class="btn-detail">
                                        <i class='bx bx-show'></i> Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>