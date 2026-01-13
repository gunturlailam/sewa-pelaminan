<?= $this->extend('index') ?>
<?= $this->section('content') ?>
<?php helper('auth'); ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Master /</span> <?= $title ?>
    </h4>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><?= $title ?></h5>
            <?php if (canManageMaster()): ?>
                <a href="<?= site_url('master/pelaminan/create') ?>" class="btn btn-primary btn-sm">
                    <i class="bx bx-plus me-1"></i> Tambah Pelaminan
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Pelaminan</th>
                            <th>Kategori</th>
                            <th>Jenis</th>
                            <th>Ukuran</th>
                            <th>Warna</th>
                            <th>Harga Sewa</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <?php if (canManageMaster()): ?>
                                <th width="12%">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pelaminan)): ?>
                            <tr>
                                <td colspan="<?= canManageMaster() ? 10 : 9 ?>" class="text-center text-muted py-4">
                                    <i class='bx bx-crown' style="font-size: 2rem; opacity: 0.3;"></i>
                                    <p class="mb-0 mt-2">Belum ada data pelaminan</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1;
                            foreach ($pelaminan as $p): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><strong><?= esc($p['nama_pelaminan']) ?></strong></td>
                                    <td>
                                        <?php if (!empty($p['nama_kategori'])): ?>
                                            <span class="badge bg-label-info"><?= esc($p['nama_kategori']) ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($p['jenis']) ?></td>
                                    <td><?= esc($p['ukuran']) ?></td>
                                    <td><?= esc($p['warna']) ?></td>
                                    <td>Rp <?= number_format($p['harga_sewa'], 0, ',', '.') ?></td>
                                    <td><?= $p['stok'] ?></td>
                                    <td>
                                        <?php if ($p['status'] == 'tersedia'): ?>
                                            <span class="badge bg-success">Tersedia</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Disewa</span>
                                        <?php endif; ?>
                                    </td>
                                    <?php if (canManageMaster()): ?>
                                        <td>
                                            <a href="<?= site_url('master/pelaminan/edit/' . $p['id_pelaminan']) ?>" class="btn btn-warning btn-sm">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <a href="<?= site_url('master/pelaminan/delete/' . $p['id_pelaminan']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus pelaminan ini?')">
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
</div>

<?= $this->endSection() ?>