<?= $this->extend('index') ?>
<?= $this->section('content') ?>
<?php helper('auth'); ?>

<style>
    .welcome-banner {
        background: linear-gradient(135deg, #696cff 0%, #8b5cf6 50%, #a855f7 100%);
        border-radius: 20px;
        padding: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .welcome-banner::after {
        content: '';
        position: absolute;
        bottom: -30%;
        right: 10%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .welcome-banner h2 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .welcome-banner p {
        opacity: 0.9;
        margin-bottom: 0;
        position: relative;
        z-index: 1;
    }

    .welcome-date {
        margin-top: 1rem;
        font-size: 0.85rem;
        opacity: 0.8;
        position: relative;
        z-index: 1;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }

    .stat-card {
        background: #fff;
        border: 1px solid rgba(148, 163, 184, 0.1);
        border-radius: 16px;
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(135deg, #696cff 0%, #8b5cf6 100%);
        border-radius: 4px 0 0 4px;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .stat-icon.purple {
        background: rgba(105, 108, 255, 0.1);
        color: #696cff;
    }

    .stat-icon.green {
        background: rgba(34, 197, 94, 0.1);
        color: #22c55e;
    }

    .stat-icon.orange {
        background: rgba(249, 115, 22, 0.1);
        color: #f97316;
    }

    .stat-icon.blue {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
    }

    .stat-label {
        font-size: 0.8rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e293b;
    }

    .content-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 992px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    .list-item {
        display: flex;
        align-items: center;
        padding: 0.875rem 0;
        border-bottom: 1px solid rgba(148, 163, 184, 0.1);
    }

    .list-item:last-child {
        border-bottom: none;
    }

    .list-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.1rem;
    }

    .list-icon.purple {
        background: rgba(105, 108, 255, 0.1);
        color: #696cff;
    }

    .list-icon.green {
        background: rgba(34, 197, 94, 0.1);
        color: #22c55e;
    }

    .list-icon.orange {
        background: rgba(249, 115, 22, 0.1);
        color: #f97316;
    }

    .list-content {
        flex: 1;
    }

    .list-title {
        font-weight: 600;
        font-size: 0.9rem;
        color: #1e293b;
        margin-bottom: 0.15rem;
    }

    .list-subtitle {
        font-size: 0.8rem;
        color: #94a3b8;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
    }

    @media (max-width: 768px) {
        .quick-actions {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .action-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 1.5rem 1rem;
        background: #fff;
        border: 1px solid rgba(148, 163, 184, 0.1);
        border-radius: 16px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .action-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        border-color: #696cff;
    }

    .action-card i {
        font-size: 1.75rem;
        margin-bottom: 0.75rem;
        color: #696cff;
    }

    .action-card span {
        font-size: 0.85rem;
        font-weight: 500;
        color: #1e293b;
    }

    .badge-primary {
        background: rgba(105, 108, 255, 0.15);
        color: #696cff;
    }

    .badge-success {
        background: rgba(34, 197, 94, 0.15);
        color: #16a34a;
    }

    .badge-warning {
        background: rgba(234, 179, 8, 0.15);
        color: #ca8a04;
    }

    /* Dark mode support */
    [data-theme="dark"] .stat-card,
    [data-theme="dark"] .action-card {
        background: #1e293b;
    }

    [data-theme="dark"] .stat-value,
    [data-theme="dark"] .list-title,
    [data-theme="dark"] .action-card span {
        color: #f1f5f9;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Welcome Banner -->
    <div class="welcome-banner animate-fade-in">
        <h2>Halo, <?= session()->get('nama') ?>! 👋</h2>
        <p>Selamat datang di Mandah Pelaminan. Anda login sebagai <?= ucfirst(session()->get('role')) ?>.</p>
        <div class="welcome-date">
            <i class='bx bx-calendar'></i> <?= date('l, d F Y') ?>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card animate-fade-in" style="animation-delay: 0.1s">
            <div class="stat-icon purple"><i class='bx bx-crown'></i></div>
            <div class="stat-label">Total Pelaminan</div>
            <div class="stat-value"><?= $totalPelaminan ?? 0 ?></div>
        </div>

        <div class="stat-card animate-fade-in" style="animation-delay: 0.2s">
            <div class="stat-icon green"><i class='bx bx-check-circle'></i></div>
            <div class="stat-label">Tersedia</div>
            <div class="stat-value"><?= $pelaminanTersedia ?? 0 ?></div>
        </div>

        <div class="stat-card animate-fade-in" style="animation-delay: 0.3s">
            <div class="stat-icon orange"><i class='bx bx-time-five'></i></div>
            <div class="stat-label">Sedang Disewa</div>
            <div class="stat-value"><?= $pelaminanDisewa ?? 0 ?></div>
        </div>

        <div class="stat-card animate-fade-in" style="animation-delay: 0.4s">
            <div class="stat-icon blue"><i class='bx bx-user'></i></div>
            <div class="stat-label">Pelanggan</div>
            <div class="stat-value"><?= $totalPelanggan ?? 0 ?></div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="content-grid">
        <!-- Paket Pelaminan -->
        <div class="card animate-fade-in" style="animation-delay: 0.5s">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold"><i class='bx bx-package me-2'></i>Paket Pelaminan</h6>
                <a href="<?= site_url('master/paket') ?>" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <?php if (empty($paketTerbaru)): ?>
                    <div class="text-center text-muted py-4">
                        <i class='bx bx-package' style="font-size: 2.5rem; opacity: 0.3;"></i>
                        <p class="mt-2 mb-0">Belum ada data paket</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($paketTerbaru as $paket): ?>
                        <div class="list-item">
                            <div class="list-icon purple"><i class='bx bx-package'></i></div>
                            <div class="list-content">
                                <div class="list-title"><?= esc($paket['nama_paket']) ?></div>
                                <div class="list-subtitle"><?= esc(substr($paket['deskripsi'] ?? '', 0, 35)) ?>...</div>
                            </div>
                            <span class="badge badge-primary">Rp <?= number_format($paket['harga_paket'], 0, ',', '.') ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Daftar Pelaminan -->
        <div class="card animate-fade-in" style="animation-delay: 0.6s">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold"><i class='bx bx-crown me-2'></i>Daftar Pelaminan</h6>
                <a href="<?= site_url('master/pelaminan') ?>" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <?php if (empty($pelaminanList)): ?>
                    <div class="text-center text-muted py-4">
                        <i class='bx bx-crown' style="font-size: 2.5rem; opacity: 0.3;"></i>
                        <p class="mt-2 mb-0">Belum ada data pelaminan</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($pelaminanList as $item): ?>
                        <div class="list-item">
                            <div class="list-icon <?= ($item['status'] ?? '') == 'tersedia' ? 'green' : 'orange' ?>">
                                <i class='bx bx-crown'></i>
                            </div>
                            <div class="list-content">
                                <div class="list-title"><?= esc($item['nama_pelaminan']) ?></div>
                                <div class="list-subtitle"><?= esc($item['jenis'] ?? '') ?> • <?= esc($item['warna'] ?? '') ?></div>
                            </div>
                            <span class="badge <?= ($item['status'] ?? '') == 'tersedia' ? 'badge-success' : 'badge-warning' ?>">
                                <?= ucfirst($item['status'] ?? 'N/A') ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <?php if (hasRole(['admin', 'petugas'])): ?>
        <div class="card animate-fade-in" style="animation-delay: 0.7s">
            <div class="card-header">
                <h6 class="mb-0 fw-semibold"><i class='bx bx-zap me-2'></i>Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <div class="quick-actions">
                    <a href="<?= site_url('transaksi/penyewaan/create') ?>" class="action-card">
                        <i class='bx bx-plus-circle'></i>
                        <span>Penyewaan Baru</span>
                    </a>
                    <a href="<?= site_url('transaksi/pembayaran/create') ?>" class="action-card">
                        <i class='bx bx-money'></i>
                        <span>Input Pembayaran</span>
                    </a>
                    <a href="<?= site_url('transaksi/pengembalian/create') ?>" class="action-card">
                        <i class='bx bx-undo'></i>
                        <span>Pengembalian</span>
                    </a>
                    <a href="<?= site_url('laporan/penyewaan') ?>" class="action-card">
                        <i class='bx bx-bar-chart-alt-2'></i>
                        <span>Lihat Laporan</span>
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>