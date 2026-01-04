<?= $this->extend('index') ?>
<?= $this->section('content') ?>

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
            $isEdit = isset($pelaminan);
            $action = $isEdit ? site_url('master/pelaminan/update/' . $pelaminan['id_pelaminan']) : site_url('master/pelaminan/store');
            ?>

            <form action="<?= $action ?>" method="POST">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="nama_pelaminan">Nama Pelaminan</label>
                        <input type="text" class="form-control" id="nama_pelaminan" name="nama_pelaminan"
                            value="<?= old('nama_pelaminan', $pelaminan['nama_pelaminan'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="jenis">Jenis</label>
                        <input type="text" class="form-control" id="jenis" name="jenis"
                            value="<?= old('jenis', $pelaminan['jenis'] ?? '') ?>" placeholder="Contoh: Modern, Tradisional" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="ukuran">Ukuran</label>
                        <input type="text" class="form-control" id="ukuran" name="ukuran"
                            value="<?= old('ukuran', $pelaminan['ukuran'] ?? '') ?>" placeholder="Contoh: 3x4m" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="warna">Warna</label>
                        <input type="text" class="form-control" id="warna" name="warna"
                            value="<?= old('warna', $pelaminan['warna'] ?? '') ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="harga_sewa">Harga Sewa</label>
                        <input type="number" class="form-control" id="harga_sewa" name="harga_sewa"
                            value="<?= old('harga_sewa', $pelaminan['harga_sewa'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="stok">Stok</label>
                        <input type="number" class="form-control" id="stok" name="stok"
                            value="<?= old('stok', $pelaminan['stok'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="status">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="tersedia" <?= old('status', $pelaminan['status'] ?? '') == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                            <option value="disewa" <?= old('status', $pelaminan['status'] ?? '') == 'disewa' ? 'selected' : '' ?>>Disewa</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bx bx-save me-1"></i> <?= $isEdit ? 'Update' : 'Simpan' ?>
                </button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>