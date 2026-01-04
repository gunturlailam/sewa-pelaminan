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
            <h5 class="mb-0">Daftar Paket</h5>
            <?php if (isAdmin()): ?>
                <a href="<?= site_url('master/paket/create') ?>" class="btn btn-primary">
                    <i class="bx bx-plus me-1"></i> Tambah
                </a>
            <?php endif; ?>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Paket</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <?php if (isAdmin()): ?>
                            <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($paket)): ?>
                        <tr>
                            <td colspan="<?= isAdmin() ? 6 : 5 ?>" class="text-center">Tidak ada data</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1;
                        foreach ($paket as $p): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($p['nama_paket']) ?></td>
                                <td><?= esc(substr($p['deskripsi'], 0, 50)) ?>...</td>
                                <td>Rp <?= number_format($p['harga_paket'], 0, ',', '.') ?></td>
                                <td>
                                    <span class="badge bg-label-<?= $p['status'] == 'aktif' ? 'success' : 'secondary' ?>">
                                        <?= ucfirst($p['status']) ?>
                                    </span>
                                </td>
                                <?php if (isAdmin()): ?>
                                    <td>
                                        <a href="<?= site_url('master/paket/edit/' . $p['id_paket']) ?>" class="btn btn-sm btn-warning">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <a href="<?= site_url('master/paket/delete/' . $p['id_paket']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">
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