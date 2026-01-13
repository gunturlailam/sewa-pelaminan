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
            <?php
            $isEdit = isset($pelanggan);
            $action = $isEdit ? site_url('master/pelanggan/update/' . $pelanggan['id_pelanggan']) : site_url('master/pelanggan/store');
            $errors = session()->getFlashdata('errors') ?? [];
            ?>

            <form action="<?= $action ?>" method="POST">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="nama">Nama Lengkap</label>
                        <input type="text" class="form-control <?= isset($errors['nama']) ? 'is-invalid' : '' ?>"
                            id="nama" name="nama"
                            value="<?= old('nama', $pelanggan['nama'] ?? '') ?>" required>
                        <?php if (isset($errors['nama'])): ?>
                            <div class="invalid-feedback"><?= $errors['nama'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="nik">NIK</label>
                        <input type="text" class="form-control <?= isset($errors['nik']) ? 'is-invalid' : '' ?>"
                            id="nik" name="nik" maxlength="20"
                            value="<?= old('nik', $pelanggan['nik'] ?? '') ?>" required>
                        <?php if (isset($errors['nik'])): ?>
                            <div class="invalid-feedback"><?= $errors['nik'] ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if (!$isEdit): ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="username">Username</label>
                            <input type="text" class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>"
                                id="username" name="username"
                                value="<?= old('username') ?>" required>
                            <?php if (isset($errors['username'])): ?>
                                <div class="invalid-feedback"><?= $errors['username'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                                id="password" name="password" required>
                            <?php if (isset($errors['password'])): ?>
                                <div class="invalid-feedback"><?= $errors['password'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password Baru (kosongkan jika tidak diubah)</label>
                        <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                            id="password" name="password">
                        <?php if (isset($errors['password'])): ?>
                            <div class="invalid-feedback"><?= $errors['password'] ?></div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                            id="email" name="email"
                            value="<?= old('email', $pelanggan['email'] ?? '') ?>" required>
                        <?php if (isset($errors['email'])): ?>
                            <div class="invalid-feedback"><?= $errors['email'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="no_hp">No HP</label>
                        <input type="text" class="form-control <?= isset($errors['no_hp']) ? 'is-invalid' : '' ?>"
                            id="no_hp" name="no_hp"
                            value="<?= old('no_hp', $pelanggan['no_hp'] ?? '') ?>" required>
                        <?php if (isset($errors['no_hp'])): ?>
                            <div class="invalid-feedback"><?= $errors['no_hp'] ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="alamat">Alamat</label>
                    <textarea class="form-control <?= isset($errors['alamat']) ? 'is-invalid' : '' ?>"
                        id="alamat" name="alamat" rows="3" required><?= old('alamat', $pelanggan['alamat'] ?? '') ?></textarea>
                    <?php if (isset($errors['alamat'])): ?>
                        <div class="invalid-feedback"><?= $errors['alamat'] ?></div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bx bx-save me-1"></i> <?= $isEdit ? 'Update' : 'Simpan' ?>
                </button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>