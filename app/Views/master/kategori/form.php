<?= $this->extend('index') ?>
<?= $this->section('content') ?>
<?php $validation = session()->get('validation'); ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Master /</span> <?= $title ?>
    </h4>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><?= $title ?></h5>
            <a href="<?= site_url('master/kategori') ?>" class="btn btn-secondary btn-sm">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <?php if ($validation && $validation->getErrors()): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($validation->getErrors() as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php
            $isEdit = isset($kategori);
            $action = $isEdit ? site_url('master/kategori/update/' . $kategori['id_kategori']) : site_url('master/kategori/store');
            ?>

            <form action="<?= $action ?>" method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label" for="nama_kategori">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" class="form-control <?= ($validation && $validation->hasError('nama_kategori')) ? 'is-invalid' : '' ?>"
                        id="nama_kategori" name="nama_kategori"
                        value="<?= old('nama_kategori', $kategori['nama_kategori'] ?? '') ?>"
                        placeholder="Contoh: Pelaminan Utama" required>
                    <?php if ($validation && $validation->hasError('nama_kategori')): ?>
                        <div class="invalid-feedback"><?= $validation->getError('nama_kategori') ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="deskripsi">Deskripsi</label>
                    <textarea class="form-control <?= ($validation && $validation->hasError('deskripsi')) ? 'is-invalid' : '' ?>"
                        id="deskripsi" name="deskripsi" rows="3"
                        placeholder="Deskripsi singkat kategori (opsional)"><?= old('deskripsi', $kategori['deskripsi'] ?? '') ?></textarea>
                    <?php if ($validation && $validation->hasError('deskripsi')): ?>
                        <div class="invalid-feedback"><?= $validation->getError('deskripsi') ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="status">Status <span class="text-danger">*</span></label>
                    <select class="form-select <?= ($validation && $validation->hasError('status')) ? 'is-invalid' : '' ?>"
                        id="status" name="status" required>
                        <option value="aktif" <?= old('status', $kategori['status'] ?? 'aktif') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="nonaktif" <?= old('status', $kategori['status'] ?? '') == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                    <?php if ($validation && $validation->hasError('status')): ?>
                        <div class="invalid-feedback"><?= $validation->getError('status') ?></div>
                    <?php endif; ?>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save me-1"></i> <?= $isEdit ? 'Update' : 'Simpan' ?>
                    </button>
                    <a href="<?= site_url('master/kategori') ?>" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>