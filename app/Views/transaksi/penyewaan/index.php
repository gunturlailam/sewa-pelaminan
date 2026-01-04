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
            <h5 class="mb-0">Daftar Penyewaan</h5>
            <?php if (hasRole(['admin', 'petugas', 'pelanggan'])): ?>
                <a href="<?= site_url('transaksi/penyewaan/create') ?>" class="btn btn-primary">
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
                        <th>Tgl Sewa</th>
                        <th>Tgl Kembali</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($penyewaan)): ?>
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1;
                        foreach ($penyewaan as $p): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($p['nama_pelanggan'] ?? '-') ?></td>
                                <td><?= date('d/m/Y', strtotime($p['tanggal_sewa'])) ?></td>
                                <td><?= date('d/m/Y', strtotime($p['tanggal_kembali'])) ?></td>
                                <td>Rp <?= number_format($p['total_bayar'], 0, ',', '.') ?></td>
                                <td>
                                    <?php
                                    $badgeClass = [
                                        'booking' => 'bg-label-info',
                                        'berjalan' => 'bg-label-warning',
                                        'selesai' => 'bg-label-success',
                                        'batal' => 'bg-label-danger'
                                    ];
                                    ?>
                                    <span class="badge <?= $badgeClass[$p['status_sewa']] ?? 'bg-label-secondary' ?>">
                                        <?= ucfirst($p['status_sewa']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= site_url('transaksi/penyewaan/detail/' . $p['id_sewa']) ?>" class="btn btn-sm btn-info">
                                        <i class="bx bx-show"></i>
                                    </a>
                                    <?php if (isAdmin()): ?>
                                        <a href="<?= site_url('transaksi/penyewaan/edit/' . $p['id_sewa']) ?>" class="btn btn-sm btn-warning">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <a href="<?= site_url('transaksi/penyewaan/delete/' . $p['id_sewa']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">
                                            <i class="bx bx-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>