<?= $this->extend('index') ?>
<?= $this->section('content') ?>
<?php helper('auth'); ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><?= $title ?></h4>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Pembayaran</h5>
            <?php if (hasRole(['admin', 'petugas'])): ?>
                <a href="<?= site_url('transaksi/pembayaran/create') ?>" class="btn btn-primary">
                    <i class="bx bx-plus me-1"></i> Tambah
                </a>
            <?php endif; ?>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pelanggan</th>
                        <th>Tgl Bayar</th>
                        <th>Metode</th>
                        <th>Jumlah Bayar</th>
                        <th>Status</th>
                        <?php if (isAdmin()): ?>
                            <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pembayaran)): ?>
                        <tr>
                            <td colspan="<?= isAdmin() ? 7 : 6 ?>" class="text-center">Tidak ada data</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1;
                        foreach ($pembayaran as $p): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($p['nama_pelanggan'] ?? '-') ?></td>
                                <td><?= date('d/m/Y', strtotime($p['tanggal_bayar'])) ?></td>
                                <td>
                                    <span class="badge bg-label-<?= $p['metode'] == 'tunai' ? 'success' : 'info' ?>">
                                        <?= ucfirst($p['metode']) ?>
                                    </span>
                                </td>
                                <td>Rp <?= number_format($p['jumlah_bayar'], 0, ',', '.') ?></td>
                                <td>
                                    <span class="badge bg-label-<?= $p['status_bayar'] == 'lunas' ? 'success' : 'warning' ?>">
                                        <?= ucfirst($p['status_bayar']) ?>
                                    </span>
                                </td>
                                <?php if (isAdmin()): ?>
                                    <td>
                                        <a href="<?= site_url('transaksi/pembayaran/edit/' . $p['id_bayar']) ?>" class="btn btn-sm btn-warning">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <a href="<?= site_url('transaksi/pembayaran/delete/' . $p['id_bayar']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">
                                            <i class="bx bx-trash"></i>
                                        </a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>