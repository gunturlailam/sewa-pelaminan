<ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item">
        <a href="/" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Dashboard">Dashboard</div>
        </a>
    </li>

    <!-- Master (Dropdown) -->
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
                <a href="<?= site_url('/master/produk') ?>" class="menu-link">
                    <div data-i18n="Produk">Produk</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="<?= site_url('/master/pelanggan') ?>" class="menu-link">
                    <div data-i18n="Pelanggan">Pelanggan</div>
                </a>
            </li>
        </ul>
    </li>

    <!-- Transaksi (Dropdown) -->
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-receipt"></i>
            <div data-i18n="Transaksi">Transaksi</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="<?= site_url('/transaksi/penjualan') ?>" class="menu-link">
                    <div data-i18n="Penjualan">Penjualan</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="<?= site_url('/transaksi/pembelian') ?>" class="menu-link">
                    <div data-i18n="Pembelian">Pembelian</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="<?= site_url('/transaksi/retur') ?>" class="menu-link">
                    <div data-i18n="Retur">Retur</div>
                </a>
            </li>
        </ul>
    </li>

    <!-- Laporan (Dropdown) -->
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-bar-chart"></i>
            <div data-i18n="Laporan">Laporan</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="<?= site_url('/laporan/penjualan') ?>" class="menu-link">
                    <div data-i18n="Laporan Penjualan">Laporan Penjualan</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="<?= site_url('/laporan/pembelian') ?>" class="menu-link">
                    <div data-i18n="Laporan Pembelian">Laporan Pembelian</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="<?= site_url('/laporan/stok') ?>" class="menu-link">
                    <div data-i18n="Laporan Stok">Laporan Stok</div>
                </a>
            </li>
        </ul>
    </li>
</ul>