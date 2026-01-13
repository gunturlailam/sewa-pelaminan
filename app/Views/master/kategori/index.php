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
                <a href="<?= site_url('master/kategori/create') ?>" class="btn btn-primary btn-sm">
                    <i class="bx bx-plus me-1"></i> Tambah Kategori
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th>Jumlah Item</th>
                            <th>Status</th>
                            <?php if (canManageMaster()): ?>
                                <th width="15%">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($kategori as $k): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <strong><?= esc($k['nama_kategori']) ?></strong>
                                </td>
                                <td><?= esc($k['deskripsi'] ?? '-') ?></td>
                                <td>
                                    <span class="badge bg-label-primary"><?= $k['jumlah_pelaminan'] ?? 0 ?> item</span>
                                </td>
                                <td>
                                    <?php if ($k['status'] == 'aktif'): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <?php if (canManageMaster()): ?>
                                    <td>
                                        <a href="<?= site_url('master/kategori/edit/' . $k['id_kategori']) ?>" class="btn btn-warning btn-sm">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <a href="<?= site_url('master/kategori/delete/' . $k['id_kategori']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                            <i class="bx bx-trash"></i>
                                        </a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>