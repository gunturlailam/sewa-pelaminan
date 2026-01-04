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
            <h5 class="mb-0">Daftar Pelaminan</h5>
            <?php if (isAdmin()): ?>
                <a href="<?= site_url('master/pelaminan/create') ?>" class="btn btn-primary">
                    <i class="bx bx-plus me-1"></i> Tambah
                </a>
            <?php endif; ?>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Ukuran</th>
                        <th>Warna</th>
                        <th>Harga Sewa</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <?php if (isAdmin()): ?>
                            <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pelaminan)): ?>
                        <tr>
                            <td colspan="<?= isAdmin() ? 9 : 8 ?>" class="text-center">Tidak ada data</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1;
                        foreach ($pelaminan as $p): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($p['nama_pelaminan']) ?></td>
                                <td><?= esc($p['jenis']) ?></td>
                                <td><?= esc($p['ukuran']) ?></td>
                                <td><?= esc($p['warna']) ?></td>
                                <td>Rp <?= number_format($p['harga_sewa'], 0, ',', '.') ?></td>
                                <td><?= $p['stok'] ?></td>
                                <td>
                                    <span class="badge bg-label-<?= $p['status'] == 'tersedia' ? 'success' : 'warning' ?>">
                                        <?= ucfirst($p['status']) ?>
                                    </span>
                                </td>
                                <?php if (isAdmin()): ?>
                                    <td>
                                        <a href="<?= site_url('master/pelaminan/edit/' . $p['id_pelaminan']) ?>" class="btn btn-sm btn-warning">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <a href="<?= site_url('master/pelaminan/delete/' . $p['id_pelaminan']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">
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