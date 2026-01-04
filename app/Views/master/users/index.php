<?= $this->extend('index') ?>
<?= $this->section('content') ?>

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
            <h5 class="mb-0">Daftar Users (Admin & Petugas)</h5>
            <a href="<?= site_url('master/users/create') ?>" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Tambah
            </a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>No HP</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1;
                        foreach ($users as $u): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($u['nama']) ?></td>
                                <td><?= esc($u['username']) ?></td>
                                <td>
                                    <span class="badge bg-label-<?= $u['role'] == 'admin' ? 'primary' : 'info' ?>">
                                        <?= ucfirst($u['role']) ?>
                                    </span>
                                </td>
                                <td><?= esc($u['no_hp']) ?></td>
                                <td>
                                    <span class="badge bg-label-<?= $u['status'] == 'aktif' ? 'success' : 'secondary' ?>">
                                        <?= ucfirst($u['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= site_url('master/users/edit/' . $u['id_user']) ?>" class="btn btn-sm btn-warning">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    <?php if ($u['id_user'] != session()->get('user_id')): ?>
                                        <a href="<?= site_url('master/users/delete/' . $u['id_user']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">
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