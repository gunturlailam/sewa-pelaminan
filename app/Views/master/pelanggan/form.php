<?= $this->extend('index') ?>
<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Master /</span> <?= $title ?>
    </h4>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><?= $title ?></h5>
            <a href="<?= site_url('master/pelanggan') ?>" class="btn btn-secondary btn-sm">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php
            $isEdit = isset($pelanggan);
            $action = $isEdit ? site_url('master/pelanggan/update/' . $pelanggan['id_pelanggan']) : site_url('master/pelanggan/store');
            ?>

            <form action="<?= $action ?>" method="POST">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="nama">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama"
                            value="<?= old('nama', $pelanggan['nama'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="nik">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" maxlength="20"
                            value="<?= old('nik', $pelanggan['nik'] ?? '') ?>" required>
                    </div>
                </div>

                <?php if (!$isEdit): ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username"
                                value="<?= old('username') ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password Baru (kosongkan jika tidak diubah)</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="<?= old('email', $pelanggan['email'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="no_hp">No HP</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp"
                            value="<?= old('no_hp', $pelanggan['no_hp'] ?? '') ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="alamat">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= old('alamat', $pelanggan['alamat'] ?? '') ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bx bx-save me-1"></i> <?= $isEdit ? 'Update' : 'Simpan' ?>
                </button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>