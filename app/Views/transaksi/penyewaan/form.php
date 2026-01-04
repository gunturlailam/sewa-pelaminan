<?= $this->extend('index') ?>
<?= $this->section('content') ?>
<?php helper('auth'); ?>
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

    .detail-row {
        background: #fff;
        border: 1px solid rgba(148, 163, 184, 0.15);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 0.75rem;
    }

    .btn-remove {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border: none;
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
    }

    .btn-remove:hover:not(:disabled) {
        background: #ef4444;
        color: white;
    }

    .btn-remove:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .btn-add-item {
        background: rgba(105, 108, 255, 0.1);
        color: #696cff;
        border: 2px dashed rgba(105, 108, 255, 0.3);
        border-radius: 10px;
        padding: 0.75rem 1.25rem;
        font-weight: 500;
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
            <h5><i class='bx bx-edit'></i> <?= $title ?></h5>
            <a href="<?= site_url('transaksi/penyewaan') ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
        </div>
        <div class="form-card-body">
            <?php
            $isEdit = isset($penyewaan);
            $action = $isEdit ? site_url('transaksi/penyewaan/update/' . $penyewaan['id_sewa']) : site_url('transaksi/penyewaan/store');
            ?>

            <form action="<?= $action ?>" method="POST" id="formPenyewaan">
                <?= csrf_field() ?>

                <div class="form-section">
                    <div class="form-section-title"><i class='bx bx-user'></i> Data Pelanggan</div>
                    <?php if (!isPelanggan()): ?>
                        <div class="mb-0">
                            <label class="form-label">Pelanggan <span class="required">*</span></label>
                            <select class="form-select <?= ($validation && $validation->hasError('id_pelanggan')) ? 'is-invalid' : '' ?>"
                                name="id_pelanggan" <?= $isEdit ? 'disabled' : 'required' ?>>
                                <option value="">-- Pilih Pelanggan --</option>
                                <?php foreach ($pelanggan as $p): ?>
                                    <option value="<?= $p['id_pelanggan'] ?>" <?= old('id_pelanggan', $penyewaan['id_pelanggan'] ?? '') == $p['id_pelanggan'] ? 'selected' : '' ?>>
                                        <?= esc($p['nama']) ?> - <?= esc($p['nik']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if ($validation && $validation->hasError('id_pelanggan')): ?>
                                <div class="invalid-feedback"><i class='bx bx-error-circle'></i> <?= $validation->getError('id_pelanggan') ?></div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info mb-0" style="border-radius: 10px;">
                            <i class='bx bx-info-circle me-1'></i> Penyewaan atas nama: <strong><?= session()->get('nama') ?></strong>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-section">
                    <div class="form-section-title"><i class='bx bx-calendar'></i> Jadwal Sewa</div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Sewa <span class="required">*</span></label>
                            <input type="date" class="form-control <?= ($validation && $validation->hasError('tanggal_sewa')) ? 'is-invalid' : '' ?>"
                                id="tanggal_sewa" name="tanggal_sewa"
                                value="<?= old('tanggal_sewa', $penyewaan['tanggal_sewa'] ?? date('Y-m-d')) ?>"
                                min="<?= date('Y-m-d') ?>" required>
                            <?php if ($validation && $validation->hasError('tanggal_sewa')): ?>
                                <div class="invalid-feedback"><i class='bx bx-error-circle'></i> <?= $validation->getError('tanggal_sewa') ?></div>
                            <?php else: ?>
                                <div class="form-hint">Tidak boleh sebelum hari ini</div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Kembali <span class="required">*</span></label>
                            <input type="date" class="form-control <?= ($validation && $validation->hasError('tanggal_kembali')) ? 'is-invalid' : '' ?>"
                                id="tanggal_kembali" name="tanggal_kembali"
                                value="<?= old('tanggal_kembali', $penyewaan['tanggal_kembali'] ?? '') ?>" required>
                            <?php if ($validation && $validation->hasError('tanggal_kembali')): ?>
                                <div class="invalid-feedback"><i class='bx bx-error-circle'></i> <?= $validation->getError('tanggal_kembali') ?></div>
                            <?php else: ?>
                                <div class="form-hint">Maksimal 7 hari dari tanggal sewa</div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat Acara <span class="required">*</span></label>
                        <textarea class="form-control <?= ($validation && $validation->hasError('alamat_acara')) ? 'is-invalid' : '' ?>"
                            name="alamat_acara" rows="2" placeholder="Alamat lengkap lokasi acara" required><?= old('alamat_acara', $penyewaan['alamat_acara'] ?? '') ?></textarea>
                        <?php if ($validation && $validation->hasError('alamat_acara')): ?>
                            <div class="invalid-feedback"><i class='bx bx-error-circle'></i> <?= $validation->getError('alamat_acara') ?></div>
                        <?php else: ?>
                            <div class="form-hint">Minimal 10 karakter</div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Catatan</label>
                        <textarea class="form-control" name="catatan" rows="2" placeholder="Catatan tambahan (opsional)"><?= old('catatan', $penyewaan['catatan'] ?? '') ?></textarea>
                    </div>
                </div>

                <?php if ($isEdit): ?>
                    <div class="form-section">
                        <div class="form-section-title"><i class='bx bx-check-circle'></i> Status</div>
                        <select class="form-select" name="status_sewa" required>
                            <option value="booking" <?= ($penyewaan['status_sewa'] ?? '') == 'booking' ? 'selected' : '' ?>>Booking</option>
                            <option value="berjalan" <?= ($penyewaan['status_sewa'] ?? '') == 'berjalan' ? 'selected' : '' ?>>Berjalan</option>
                            <option value="selesai" <?= ($penyewaan['status_sewa'] ?? '') == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                            <option value="batal" <?= ($penyewaan['status_sewa'] ?? '') == 'batal' ? 'selected' : '' ?>>Batal</option>
                        </select>
                    </div>
                <?php endif; ?>

                <?php if (!$isEdit): ?>
                    <div class="form-section">
                        <div class="form-section-title"><i class='bx bx-package'></i> Detail Pelaminan</div>
                        <div id="detail-container">
                            <div class="detail-row">
                                <div class="row align-items-end">
                                    <div class="col-md-6 mb-2 mb-md-0">
                                        <label class="form-label">Pelaminan <span class="required">*</span></label>
                                        <select class="form-select pelaminan-select" name="pelaminan_id[]" required>
                                            <option value="">-- Pilih Pelaminan --</option>
                                            <?php foreach ($pelaminan as $item): ?>
                                                <option value="<?= $item['id_pelaminan'] ?>" data-harga="<?= $item['harga_sewa'] ?>">
                                                    <?= esc($item['nama_pelaminan']) ?> - Rp <?= number_format($item['harga_sewa'], 0, ',', '.') ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2 mb-md-0">
                                        <label class="form-label">Jumlah <span class="required">*</span></label>
                                        <input type="number" class="form-control" name="jumlah[]" min="1" value="1" required>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-remove w-100" disabled><i class="bx bx-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-add-item w-100 mt-2" id="btn-add-detail">
                            <i class="bx bx-plus me-1"></i> Tambah Item
                        </button>
                    </div>

                    <div class="form-section">
                        <div class="form-section-title"><i class='bx bx-money'></i> Pembayaran DP (Opsional)</div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jumlah DP</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="dp_bayar" value="0" min="0">
                                </div>
                                <div class="form-hint">Minimal 30% dari total. Kosongkan jika belum bayar.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Metode Pembayaran</label>
                                <select class="form-select" name="metode_bayar">
                                    <option value="tunai">Tunai</option>
                                    <option value="transfer">Transfer Bank</option>
                                    <option value="qris">QRIS</option>
                                </select>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="<?= site_url('transaksi/penyewaan') ?>" class="btn btn-outline-secondary">Batal</a>
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
        const container = document.getElementById('detail-container');
        const btnAdd = document.getElementById('btn-add-detail');
        const tanggalSewa = document.getElementById('tanggal_sewa');
        const tanggalKembali = document.getElementById('tanggal_kembali');

        tanggalSewa?.addEventListener('change', function() {
            tanggalKembali.min = this.value;
            const sewaDate = new Date(this.value);
            sewaDate.setDate(sewaDate.getDate() + 7);
            tanggalKembali.max = sewaDate.toISOString().split('T')[0];
            if (tanggalKembali.value && tanggalKembali.value < this.value) {
                tanggalKembali.value = this.value;
            }
        });

        if (tanggalSewa?.value) tanggalSewa.dispatchEvent(new Event('change'));

        btnAdd?.addEventListener('click', function() {
            const row = container.querySelector('.detail-row').cloneNode(true);
            row.querySelector('select').value = '';
            row.querySelector('input').value = '1';
            row.querySelector('.btn-remove').disabled = false;
            container.appendChild(row);
            updateRemoveButtons();
        });

        container?.addEventListener('click', function(e) {
            if (e.target.closest('.btn-remove')) {
                const rows = container.querySelectorAll('.detail-row');
                if (rows.length > 1) e.target.closest('.detail-row').remove();
                updateRemoveButtons();
            }
        });

        function updateRemoveButtons() {
            const rows = container.querySelectorAll('.detail-row');
            rows.forEach(row => row.querySelector('.btn-remove').disabled = rows.length === 1);
        }
    });
</script>

<?= $this->endSection() ?>