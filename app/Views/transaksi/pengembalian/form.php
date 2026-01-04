<?= $this->extend('index') ?>
<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Transaksi /</span> <?= $title ?>
    </h4>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><?= $title ?></h5>
            <a href="<?= site_url('transaksi/pengembalian') ?>" class="btn btn-secondary btn-sm">
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
            $isEdit = isset($pengembalian);
            $action = $isEdit ? site_url('transaksi/pengembalian/update/' . $pengembalian['id_kembali']) : site_url('transaksi/pengembalian/store');
            ?>

            <form action="<?= $action ?>" method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label" for="id_sewa">Penyewaan</label>
                    <select class="form-select" id="id_sewa" name="id_sewa" <?= $isEdit ? 'disabled' : 'required' ?>>
                        <option value="">-- Pilih Penyewaan --</option>
                        <?php foreach ($penyewaan as $p): ?>
                            <?php if (!$isEdit && $p['status_sewa'] == 'selesai') continue; ?>
                            <option value="<?= $p['id_sewa'] ?>" <?= old('id_sewa', $pengembalian['id_sewa'] ?? '') == $p['id_sewa'] ? 'selected' : '' ?>>
                                #<?= str_pad($p['id_sewa'], 5, '0', STR_PAD_LEFT) ?> - <?= esc($p['nama_pelanggan']) ?> (<?= ucfirst($p['status_sewa']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="tanggal_kembali">Tanggal Pengembalian</label>
                        <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali"
                            value="<?= old('tanggal_kembali', $pengembalian['tanggal_kembali'] ?? date('Y-m-d')) ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="kondisi">Kondisi Barang</label>
                        <select class="form-select" id="kondisi" name="kondisi" required>
                            <option value="baik" <?= old('kondisi', $pengembalian['kondisi'] ?? '') == 'baik' ? 'selected' : '' ?>>Baik</option>
                            <option value="rusak" <?= old('kondisi', $pengembalian['kondisi'] ?? '') == 'rusak' ? 'selected' : '' ?>>Rusak</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="denda">Denda (jika ada)</label>
                    <input type="number" class="form-control" id="denda" name="denda"
                        value="<?= old('denda', $pengembalian['denda'] ?? 0) ?>" min="0">
                    <small class="text-muted">Kosongkan atau isi 0 jika tidak ada denda</small>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bx bx-save me-1"></i> <?= $isEdit ? 'Update' : 'Proses Pengembalian' ?>
                </button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>