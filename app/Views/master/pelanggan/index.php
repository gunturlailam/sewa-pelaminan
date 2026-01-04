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
            <h5 class="mb-0">Daftar Pelanggan</h5>
            <?php if (isAdmin()): ?>
                <a href="<?= site_url('master/pelanggan/create') ?>" class="btn btn-primary">
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
                        <th>NIK</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Alamat</th>
                        <th>Status</th>
                        <?php if (isAdmin()): ?>
                            <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pelanggan)): ?>
                        <tr>
                            <td colspan="<?= isAdmin() ? 8 : 7 ?>" class="text-center">Tidak ada data</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1;
                        foreach ($pelanggan as $p): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($p['nama']) ?></td>
                                <td><?= esc($p['nik']) ?></td>
                                <td><?= esc($p['email']) ?></td>
                                <td><?= esc($p['no_hp']) ?></td>
                                <td><?= esc(substr($p['alamat'], 0, 30)) ?>...</td>
                                <td>
                                    <span class="badge bg-label-<?= $p['status'] == 'aktif' ? 'success' : 'secondary' ?>">
                                        <?= ucfirst($p['status']) ?>
                                    </span>
                                </td>
                                <?php if (isAdmin()): ?>
                                    <td>
                                        <a href="<?= site_url('master/pelanggan/edit/' . $p['id_pelanggan']) ?>" class="btn btn-sm btn-warning">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <a href="<?= site_url('master/pelanggan/delete/' . $p['id_pelanggan']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">
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