<?= $this->extend('index') ?>
<?= $this->section('content') ?>
<?php $validation = session()->get('validation'); ?>

<style>
    .form-card {
        background: #fff;
        border: 1px solid rgba(148, 163, 184, 0.1);
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }

    .form-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.1);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .form-card-header h5 {
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-card-header h5 i {
        color: #696cff;
    }

    .form-card-body {
        padding: 1.5rem;
    }

    .form-section {
        background: rgba(105, 108, 255, 0.03);
        border: 1px solid rgba(105, 108, 255, 0.1);
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .form-section-title {
        font-weight: 600;
        color: #696cff;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label {
        font-weight: 500;
        color: #475569;
        margin-bottom: 0.5rem;
    }

    .form-label .required {
        color: #ef4444;
        margin-left: 2px;
    }

    .form-control,
    .form-select {
        border: 2px solid rgba(148, 163, 184, 0.2);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: all 0.2s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #696cff;
        box-shadow: 0 0 0 3px rgba(105, 108, 255, 0.1);
    }

    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: #ef4444;
        background-image: none;
    }

    .invalid-feedback {
        color: #ef4444;
        font-size: 0.8rem;
        margin-top: 0.35rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .form-hint {
        font-size: 0.8rem;
        color: #94a3b8;
        margin-top: 0.35rem;
    }

    .btn-submit {
        background: linear-gradient(135deg, #696cff 0%, #8b5cf6 100%);
        border: none;
        border-radius: 10px;
        padding: 0.875rem 2rem;
        font-weight: 600;
        color: white;
        box-shadow: 0 4px 15px rgba(105, 108, 255, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        color: white;
    }

    .alert-validation {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.2);
        border-radius: 12px;
        padding: 1rem 1.25rem;
        color: #dc2626;
    }

    .alert-validation ul {
        margin: 0;
        padding-left: 1.25rem;
    }

    .info-sisa {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border: 1px solid #f59e0b;
        border-radius: 10px;
        padding: 1rem;
        margin-top: 1rem;
    }

    .info-sisa .label {
        font-size: 0.85rem;
        color: #92400e;
    }

    .info-sisa .value {
        font-size: 1.25rem;
        font-weight: 700;
        color: #b45309;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Transaksi /</span> <?= $title ?>
    </h4>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px;">
            <i class='bx bx-error-circle me-2'></i><?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($validation && $validation->getErrors()): ?>
        <div class="alert-validation mb-4">
            <strong><i class='bx bx-error me-1'></i> Terdapat kesalahan:</strong>
            <ul class="mt-2">
                <?php foreach ($validation->getErrors() as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="form-card">
        <div class="form-card-header">
            <h5><i class='bx bx-money'></i> <?= $title ?></h5>
            <a href="<?= site_url('transaksi/pembayaran') ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
        </div>
        <div class="form-card-body">
            <?php
            $isEdit = isset($pembayaran);
            $action = $isEdit ? site_url('transaksi/pembayaran/update/' . $pembayaran['id_bayar']) : site_url('transaksi/pembayaran/store');
            ?>

            <form action="<?= $action ?>" method="POST" id="formPembayaran">
                <?= csrf_field() ?>

                <div class="form-section">
                    <div class="form-section-title"><i class='bx bx-receipt'></i> Data Penyewaan</div>
                    <div class="mb-0">
                        <label class="form-label">Penyewaan <span class="required">*</span></label>
                        <select class="form-select <?= ($validation && $validation->hasError('id_sewa')) ? 'is-invalid' : '' ?>"
                            id="id_sewa" name="id_sewa" <?= $isEdit ? 'disabled' : 'required' ?>>
                            <option value="">-- Pilih Penyewaan --</option>
                            <?php foreach ($penyewaan as $p):
                                $sisaBayar = $p['total_bayar'] - ($p['total_dibayar'] ?? 0);
                            ?>
                                <option value="<?= $p['id_sewa'] ?>"
                                    data-total="<?= $p['total_bayar'] ?>"
                                    data-dibayar="<?= $p['total_dibayar'] ?? 0 ?>"
                                    data-sisa="<?= $sisaBayar ?>"
                                    <?= old('id_sewa', $pembayaran['id_sewa'] ?? '') == $p['id_sewa'] ? 'selected' : '' ?>>
                                    #<?= str_pad($p['id_sewa'], 5, '0', STR_PAD_LEFT) ?> - <?= esc($p['nama_pelanggan']) ?>
                                    (Total: Rp <?= number_format($p['total_bayar'], 0, ',', '.') ?> | Sisa: Rp <?= number_format($sisaBayar, 0, ',', '.') ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if ($validation && $validation->hasError('id_sewa')): ?>
                            <div class="invalid-feedback"><i class='bx bx-error-circle'></i> <?= $validation->getError('id_sewa') ?></div>
                        <?php endif; ?>

                        <div class="info-sisa mt-3" id="infoSisa" style="display: none;">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="label">Total Tagihan</div>
                                    <div class="value" id="totalTagihan">-</div>
                                </div>
                                <div class="col-4">
                                    <div class="label">Sudah Dibayar</div>
                                    <div class="value" id="sudahDibayar">-</div>
                                </div>
                                <div class="col-4">
                                    <div class="label">Sisa Tagihan</div>
                                    <div class="value" id="sisaTagihan">-</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-title"><i class='bx bx-calendar'></i> Detail Pembayaran</div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Bayar <span class="required">*</span></label>
                            <input type="date" class="form-control <?= ($validation && $validation->hasError('tanggal_bayar')) ? 'is-invalid' : '' ?>"
                                id="tanggal_bayar" name="tanggal_bayar"
                                value="<?= old('tanggal_bayar', $pembayaran['tanggal_bayar'] ?? date('Y-m-d')) ?>"
                                max="<?= date('Y-m-d') ?>" required>
                            <?php if ($validation && $validation->hasError('tanggal_bayar')): ?>
                                <div class="invalid-feedback"><i class='bx bx-error-circle'></i> <?= $validation->getError('tanggal_bayar') ?></div>
                            <?php else: ?>
                                <div class="form-hint">Tidak boleh lebih dari hari ini</div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Metode Pembayaran <span class="required">*</span></label>
                            <input type="text" class="form-control" value="💵 Tunai" disabled>
                            <input type="hidden" name="metode_bayar" value="tunai">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Jumlah Bayar (Pelunasan) <span class="required">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control" id="jumlah_bayar_display" disabled>
                                <input type="hidden" id="jumlah_bayar" name="jumlah_bayar" value="<?= old('jumlah_bayar', $pembayaran['jumlah_bayar'] ?? '') ?>">
                            </div>
                            <div class="form-hint">
                                <i class='bx bx-info-circle'></i> Pembayaran otomatis untuk pelunasan penuh sisa tagihan
                            </div>
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="2" placeholder="Keterangan pembayaran (opsional)"><?= old('keterangan', $pembayaran['keterangan'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="<?= site_url('transaksi/pembayaran') ?>" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn-submit">
                        <i class="bx bx-save me-1"></i> <?= $isEdit ? 'Update' : 'Simpan' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectSewa = document.getElementById('id_sewa');
        const infoSisa = document.getElementById('infoSisa');
        const inputJumlah = document.getElementById('jumlah_bayar');
        const inputJumlahDisplay = document.getElementById('jumlah_bayar_display');

        function formatRupiah(num) {
            return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        function updateInfo() {
            const selected = selectSewa.options[selectSewa.selectedIndex];
            if (selected && selected.value) {
                const total = parseInt(selected.dataset.total) || 0;
                const dibayar = parseInt(selected.dataset.dibayar) || 0;
                const sisa = parseInt(selected.dataset.sisa) || 0;

                document.getElementById('totalTagihan').textContent = formatRupiah(total);
                document.getElementById('sudahDibayar').textContent = formatRupiah(dibayar);
                document.getElementById('sisaTagihan').textContent = formatRupiah(sisa);

                // Set jumlah bayar otomatis ke sisa tagihan (pelunasan)
                inputJumlah.value = sisa;
                inputJumlahDisplay.value = formatRupiah(sisa);

                infoSisa.style.display = 'block';
            } else {
                infoSisa.style.display = 'none';
                inputJumlah.value = '';
                inputJumlahDisplay.value = '';
            }
        }

        selectSewa?.addEventListener('change', updateInfo);

        // Trigger on load if already selected
        if (selectSewa?.value) {
            updateInfo();
        }
    });
</script>

<?= $this->endSection() ?>