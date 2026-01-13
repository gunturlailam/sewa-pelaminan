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
            <a href="<?= site_url('master/pelaminan') ?>" class="btn btn-secondary btn-sm">
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
            $isEdit = isset($pelaminan);
            $action = $isEdit ? site_url('master/pelaminan/update/' . $pelaminan['id_pelaminan']) : site_url('master/pelaminan/store');
            ?>

            <form action="<?= $action ?>" method="POST">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="nama_pelaminan">Nama Pelaminan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= ($validation && $validation->hasError('nama_pelaminan')) ? 'is-invalid' : '' ?>"
                            id="nama_pelaminan" name="nama_pelaminan"
                            value="<?= old('nama_pelaminan', $pelaminan['nama_pelaminan'] ?? '') ?>"
                            placeholder="Contoh: Pelaminan Jawa Modern" required>
                        <?php if ($validation && $validation->hasError('nama_pelaminan')): ?>
                            <div class="invalid-feedback"><?= $validation->getError('nama_pelaminan') ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="id_kategori">Kategori</label>
                        <select class="form-select <?= ($validation && $validation->hasError('id_kategori')) ? 'is-invalid' : '' ?>"
                            id="id_kategori" name="id_kategori">
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($kategori as $k): ?>
                                <option value="<?= $k['id_kategori'] ?>" <?= old('id_kategori', $pelaminan['id_kategori'] ?? '') == $k['id_kategori'] ? 'selected' : '' ?>>
                                    <?= esc($k['nama_kategori']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if ($validation && $validation->hasError('id_kategori')): ?>
                            <div class="invalid-feedback"><?= $validation->getError('id_kategori') ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="jenis">Jenis <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= ($validation && $validation->hasError('jenis')) ? 'is-invalid' : '' ?>"
                            id="jenis" name="jenis"
                            value="<?= old('jenis', $pelaminan['jenis'] ?? '') ?>"
                            placeholder="Contoh: Modern, Tradisional, Minimalis" required>
                        <?php if ($validation && $validation->hasError('jenis')): ?>
                            <div class="invalid-feedback"><?= $validation->getError('jenis') ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="warna">Warna <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= ($validation && $validation->hasError('warna')) ? 'is-invalid' : '' ?>"
                            id="warna" name="warna"
                            value="<?= old('warna', $pelaminan['warna'] ?? '') ?>"
                            placeholder="Contoh: Merah Maroon, Gold, Putih" required>
                        <?php if ($validation && $validation->hasError('warna')): ?>
                            <div class="invalid-feedback"><?= $validation->getError('warna') ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="ukuran">Ukuran <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= ($validation && $validation->hasError('ukuran')) ? 'is-invalid' : '' ?>"
                            id="ukuran" name="ukuran"
                            value="<?= old('ukuran', $pelaminan['ukuran'] ?? '') ?>"
                            placeholder="Contoh: 3x4m, Large, Standard" required>
                        <?php if ($validation && $validation->hasError('ukuran')): ?>
                            <div class="invalid-feedback"><?= $validation->getError('ukuran') ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="harga_sewa">Harga Sewa <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control <?= ($validation && $validation->hasError('harga_sewa')) ? 'is-invalid' : '' ?>"
                                id="harga_sewa" name="harga_sewa"
                                value="<?= old('harga_sewa', $pelaminan['harga_sewa'] ?? '') ?>"
                                min="1" required>
                        </div>
                        <?php if ($validation && $validation->hasError('harga_sewa')): ?>
                            <div class="invalid-feedback d-block"><?= $validation->getError('harga_sewa') ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="stok">Stok <span class="text-danger">*</span></label>
                        <input type="number" class="form-control <?= ($validation && $validation->hasError('stok')) ? 'is-invalid' : '' ?>"
                            id="stok" name="stok"
                            value="<?= old('stok', $pelaminan['stok'] ?? 1) ?>"
                            min="0" required>
                        <?php if ($validation && $validation->hasError('stok')): ?>
                            <div class="invalid-feedback"><?= $validation->getError('stok') ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="status">Status <span class="text-danger">*</span></label>
                        <select class="form-select <?= ($validation && $validation->hasError('status')) ? 'is-invalid' : '' ?>"
                            id="status" name="status" required>
                            <option value="tersedia" <?= old('status', $pelaminan['status'] ?? 'tersedia') == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                            <option value="disewa" <?= old('status', $pelaminan['status'] ?? '') == 'disewa' ? 'selected' : '' ?>>Disewa</option>
                        </select>
                        <?php if ($validation && $validation->hasError('status')): ?>
                            <div class="invalid-feedback"><?= $validation->getError('status') ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save me-1"></i> <?= $isEdit ? 'Update' : 'Simpan' ?>
                    </button>
                    <a href="<?= site_url('master/pelaminan') ?>" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>