<?= $this->extend('index') ?>
<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Transaksi /</span> <?= $title ?>
    </h4>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><?= $title ?></h5>
            <a href="<?= site_url('transaksi/pembayaran') ?>" class="btn btn-secondary btn-sm">
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
            $isEdit = isset($pembayaran);
            $action = $isEdit ? site_url('transaksi/pembayaran/update/' . $pembayaran['id_bayar']) : site_url('transaksi/pembayaran/store');
            ?>

            <form action="<?= $action ?>" method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label" for="id_sewa">Penyewaan</label>
                    <select class="form-select" id="id_sewa" name="id_sewa" <?= $isEdit ? 'disabled' : 'required' ?>>
                        <option value="">-- Pilih Penyewaan --</option>
                        <?php foreach ($penyewaan as $p): ?>
                            <option value="<?= $p['id_sewa'] ?>" <?= old('id_sewa', $pembayaran['id_sewa'] ?? '') == $p['id_sewa'] ? 'selected' : '' ?>>
                                #<?= str_pad($p['id_sewa'], 5, '0', STR_PAD_LEFT) ?> - <?= esc($p['nama_pelanggan']) ?> (Rp <?= number_format($p['total_bayar'], 0, ',', '.') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="tanggal_bayar">Tanggal Bayar</label>
                        <input type="date" class="form-control" id="tanggal_bayar" name="tanggal_bayar"
                            value="<?= old('tanggal_bayar', $pembayaran['tanggal_bayar'] ?? date('Y-m-d')) ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="metode">Metode Pembayaran</label>
                        <select class="form-select" id="metode" name="metode" required>
                            <option value="tunai" <?= old('metode', $pembayaran['metode'] ?? '') == 'tunai' ? 'selected' : '' ?>>Tunai</option>
                            <option value="transfer" <?= old('metode', $pembayaran['metode'] ?? '') == 'transfer' ? 'selected' : '' ?>>Transfer</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="jumlah_bayar">Jumlah Bayar</label>
                        <input type="number" class="form-control" id="jumlah_bayar" name="jumlah_bayar"
                            value="<?= old('jumlah_bayar', $pembayaran['jumlah_bayar'] ?? '') ?>" required>
                    </div>
                    <?php if ($isEdit): ?>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="status_bayar">Status</label>
                            <select class="form-select" id="status_bayar" name="status_bayar" required>
                                <option value="belum" <?= ($pembayaran['status_bayar'] ?? '') == 'belum' ? 'selected' : '' ?>>Belum Lunas</option>
                                <option value="lunas" <?= ($pembayaran['status_bayar'] ?? '') == 'lunas' ? 'selected' : '' ?>>Lunas</option>
                            </select>
                        </div>
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