<?= $this->extend('index') ?>
<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Master /</span> <?= $title ?>
    </h4>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><?= $title ?></h5>
            <a href="<?= site_url('master/paket') ?>" class="btn btn-secondary btn-sm">
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
            $isEdit = isset($paket);
            $action = $isEdit ? site_url('master/paket/update/' . $paket['id_paket']) : site_url('master/paket/store');
            ?>

            <form action="<?= $action ?>" method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label" for="nama_paket">Nama Paket</label>
                    <input type="text" class="form-control" id="nama_paket" name="nama_paket"
                        value="<?= old('nama_paket', $paket['nama_paket'] ?? '') ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="deskripsi">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required><?= old('deskripsi', $paket['deskripsi'] ?? '') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="harga_paket">Harga Paket</label>
                    <input type="number" class="form-control" id="harga_paket" name="harga_paket"
                        value="<?= old('harga_paket', $paket['harga_paket'] ?? '') ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="status">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="aktif" <?= old('status', $paket['status'] ?? '') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="nonaktif" <?= old('status', $paket['status'] ?? '') == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bx bx-save me-1"></i> <?= $isEdit ? 'Update' : 'Simpan' ?>
                </button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>