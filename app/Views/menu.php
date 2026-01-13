<?php helper('auth'); ?>
<ul class="menu-inner py-1 mt-3">
    <!-- Dashboard - Semua role -->
    <li class="menu-item">
        <a href="<?= site_url('/dashboard') ?>" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Dashboard">Dashboard</div>
        </a>
    </li>

    <!-- Master (Dropdown) - Admin & Petugas bisa lihat, Pelanggan hanya profil -->
    <?php if (hasRole(['admin', 'petugas'])): ?>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Master">Master</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="<?= site_url('/master/kategori') ?>" class="menu-link">
                        <div data-i18n="Kategori">Kategori</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="<?= site_url('/master/pelaminan') ?>" class="menu-link">
                        <div data-i18n="Pelaminan">Pelaminan</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="<?= site_url('/master/pelanggan') ?>" class="menu-link">
                        <div data-i18n="Pelanggan">Pelanggan</div>
                    </a>
                </li>
                <?php if (isAdmin()): ?>
                    <li class="menu-item">
                        <a href="<?= site_url('/master/users') ?>" class="menu-link">
                            <div data-i18n="Users">Users</div>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </li>
    <?php endif; ?>

    <!-- Transaksi (Dropdown) -->
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-receipt"></i>
            <div data-i18n="Transaksi">Transaksi</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="<?= site_url('/transaksi/penyewaan') ?>" class="menu-link">
                    <div data-i18n="Penyewaan">Penyewaan</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="<?= site_url('/transaksi/pembayaran') ?>" class="menu-link">
                    <div data-i18n="Pembayaran">Pembayaran</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="<?= site_url('/transaksi/pengembalian') ?>" class="menu-link">
                    <div data-i18n="Pengembalian">Pengembalian</div>
                </a>
            </li>
        </ul>
    </li>

    <!-- Laporan (Dropdown) - Admin & Petugas only -->
    <?php if (canViewLaporan()): ?>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-bar-chart"></i>
                <div data-i18n="Laporan">Laporan</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="<?= site_url('/laporan/penyewaan') ?>" class="menu-link">
                        <div data-i18n="Penyewaan">Penyewaan</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="<?= site_url('/laporan/keuangan') ?>" class="menu-link">
                        <div data-i18n="Keuangan">Keuangan</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="<?= site_url('/laporan/logistik') ?>" class="menu-link">
                        <div data-i18n="Logistik">Logistik</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="<?= site_url('/laporan/pelanggan') ?>" class="menu-link">
                        <div data-i18n="Pelanggan">Pelanggan</div>
                    </a>
                </li>
            </ul>
        </li>
    <?php endif; ?>

    <!-- Profil - Pelanggan -->
    <?php if (isPelanggan()): ?>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Akun Saya</span>
        </li>
        <li class="menu-item">
            <a href="<?= site_url('/profil') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Profil">Profil Saya</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="<?= site_url('/riwayat') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-history"></i>
                <div data-i18n="Riwayat">Riwayat Transaksi</div>
            </a>
        </li>
    <?php endif; ?>
</ul>