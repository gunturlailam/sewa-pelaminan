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

    .info-sewa {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border: 1px solid #3b82f6;
        border-radius: 10px;
        padding: 1rem;
        margin-top: 1rem;
    }

    .info-sewa .label {
        font-size: 0.85rem;
        color: #1e40af;
    }

    .info-sewa .value {
        font-size: 1rem;
        font-weight: 600;
        color: #1d4ed8;
    }

    .kondisi-option {
        padding: 0.75rem 1rem;
        border: 2px solid rgba(148, 163, 184, 0.2);
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .kondisi-option:hover {
        border-color: #696cff;
    }

    .kondisi-option.active {
        border-color: #696cff;
        background: rgba(105, 108, 255, 0.05);
    }

    .kondisi-option input {
        display: none;
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
            <h5><i class='bx bx-package'></i> <?= $title ?></h5>
            <a href="<?= site_url('transaksi/pengembalian') ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
        </div>
        <div class="form-card-body">
            <?php
            $isEdit = isset($pengembalian);
            $action = $isEdit ? site_url('transaksi/pengembalian/update/' . $pengembalian['id_kembali']) : site_url('transaksi/pengembalian/store');
            ?>

            <form action="<?= $action ?>" method="POST" id="formPengembalian">
                <?= csrf_field() ?>

                <div class="form-section">
                    <div class="form-section-title"><i class='bx bx-receipt'></i> Data Penyewaan</div>
                    <div class="mb-0">
                        <label class="form-label">Penyewaan <span class="required">*</span></label>
                        <select class="form-select <?= ($validation && $validation->hasError('id_sewa')) ? 'is-invalid' : '' ?>"
                            id="id_sewa" name="id_sewa" <?= $isEdit ? 'disabled' : 'required' ?>>
                            <option value="">-- Pilih Penyewaan --</option>
                            <?php foreach ($penyewaan as $p): ?>
                                <option value="<?= $p['id_sewa'] ?>"
                                    data-tanggal-sewa="<?= $p['tanggal_sewa'] ?>"
                                    data-tanggal-kembali="<?= $p['tanggal_kembali'] ?? '' ?>"
                                    data-pelanggan="<?= esc($p['nama_pelanggan']) ?>"
                                    data-harga-sewa="<?= $p['total_bayar'] ?? 0 ?>"
                                    <?= old('id_sewa', $pengembalian['id_sewa'] ?? '') == $p['id_sewa'] ? 'selected' : '' ?>>
                                    #<?= str_pad($p['id_sewa'], 5, '0', STR_PAD_LEFT) ?> - <?= esc($p['nama_pelanggan']) ?>
                                    (Sewa: <?= date('d/m/Y', strtotime($p['tanggal_sewa'])) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if ($validation && $validation->hasError('id_sewa')): ?>
                            <div class="invalid-feedback"><i class='bx bx-error-circle'></i> <?= $validation->getError('id_sewa') ?></div>
                        <?php endif; ?>

                        <div class="info-sewa mt-3" id="infoSewa" style="display: none;">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="label">Pelanggan</div>
                                    <div class="value" id="infoPelanggan">-</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="label">Tanggal Sewa</div>
                                    <div class="value" id="infoTglSewa">-</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="label">Jadwal Kembali</div>
                                    <div class="value" id="infoJadwalKembali">-</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-title"><i class='bx bx-calendar-check'></i> Detail Pengembalian</div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Pengembalian <span class="required">*</span></label>
                            <input type="date" class="form-control <?= ($validation && $validation->hasError('tanggal_kembali')) ? 'is-invalid' : '' ?>"
                                id="tanggal_kembali" name="tanggal_kembali"
                                value="<?= old('tanggal_kembali', $pengembalian['tanggal_kembali'] ?? date('Y-m-d')) ?>" required>
                            <?php if ($validation && $validation->hasError('tanggal_kembali')): ?>
                                <div class="invalid-feedback"><i class='bx bx-error-circle'></i> <?= $validation->getError('tanggal_kembali') ?></div>
                            <?php else: ?>
                                <div class="form-hint">Tidak boleh sebelum tanggal sewa</div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kondisi Barang <span class="required">*</span></label>
                            <select class="form-select <?= ($validation && $validation->hasError('kondisi')) ? 'is-invalid' : '' ?>"
                                id="kondisi" name="kondisi" required>
                                <option value="baik" <?= old('kondisi', $pengembalian['kondisi'] ?? '') == 'baik' ? 'selected' : '' ?>>✅ Baik</option>
                                <option value="rusak" <?= old('kondisi', $pengembalian['kondisi'] ?? '') == 'rusak' ? 'selected' : '' ?>>⚠️ Rusak</option>
                                <option value="hilang" <?= old('kondisi', $pengembalian['kondisi'] ?? '') == 'hilang' ? 'selected' : '' ?>>❌ Hilang</option>
                            </select>
                            <?php if ($validation && $validation->hasError('kondisi')): ?>
                                <div class="invalid-feedback"><i class='bx bx-error-circle'></i> <?= $validation->getError('kondisi') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Denda</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control" id="denda_display" readonly
                                    style="background-color: #f8f9fa; font-weight: 600;"
                                    value="<?= number_format(old('denda', $pengembalian['denda'] ?? 0), 0, ',', '.') ?>">
                                <input type="hidden" id="denda" name="denda"
                                    value="<?= old('denda', $pengembalian['denda'] ?? 0) ?>">
                            </div>
                            <div class="form-hint" id="dendaHint" style="line-height: 1.6;">Otomatis dihitung: kondisi barang + keterlambatan (Rp 50.000/hari)</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" name="keterangan" rows="1" placeholder="Keterangan pengembalian (opsional)"><?= old('keterangan', $pengembalian['keterangan'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="<?= site_url('transaksi/pengembalian') ?>" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn-submit">
                        <i class="bx bx-check me-1"></i> <?= $isEdit ? 'Update' : 'Proses Pengembalian' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectSewa = document.getElementById('id_sewa');
        const infoSewa = document.getElementById('infoSewa');
        const inputTglKembali = document.getElementById('tanggal_kembali');
        const selectKondisi = document.getElementById('kondisi');
        const inputDenda = document.getElementById('denda');
        const inputDendaDisplay = document.getElementById('denda_display');
        const dendaHint = document.getElementById('dendaHint');

        // Persentase denda berdasarkan kondisi
        const DENDA_RUSAK = 0.5; // 50% dari harga sewa
        const DENDA_HILANG = 1.0; // 100% dari harga sewa
        const DENDA_TERLAMBAT_PER_HARI = 50000; // Rp 50.000 per hari keterlambatan

        let hargaSewa = 0;
        let jadwalKembali = null;

        function formatDate(dateStr) {
            if (!dateStr) return '-';
            const d = new Date(dateStr);
            return d.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
        }

        function formatRupiah(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        function hitungHariTerlambat() {
            if (!jadwalKembali || !inputTglKembali.value) return 0;

            const tglJadwal = new Date(jadwalKembali);
            const tglAktual = new Date(inputTglKembali.value);

            // Hitung selisih hari
            const diffTime = tglAktual - tglJadwal;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            return diffDays > 0 ? diffDays : 0;
        }

        function updateInfo() {
            const selected = selectSewa.options[selectSewa.selectedIndex];
            if (selected && selected.value) {
                const tglSewa = selected.dataset.tanggalSewa;
                const tglKembali = selected.dataset.tanggalKembali;
                const pelanggan = selected.dataset.pelanggan;
                hargaSewa = parseInt(selected.dataset.hargaSewa) || 0;
                jadwalKembali = tglKembali;

                document.getElementById('infoPelanggan').textContent = pelanggan;
                document.getElementById('infoTglSewa').textContent = formatDate(tglSewa);
                document.getElementById('infoJadwalKembali').textContent = formatDate(tglKembali);

                // Set min date untuk tanggal kembali
                inputTglKembali.min = tglSewa;

                infoSewa.style.display = 'block';

                // Update denda berdasarkan kondisi yang sudah dipilih
                updateDenda();
            } else {
                infoSewa.style.display = 'none';
                hargaSewa = 0;
                jadwalKembali = null;
            }
        }

        function updateDenda() {
            const kondisi = selectKondisi.value;
            let dendaKondisi = 0;
            let dendaTerlambat = 0;
            let hintText = [];

            // Hitung denda berdasarkan kondisi barang
            if (kondisi === 'rusak') {
                dendaKondisi = Math.round(hargaSewa * DENDA_RUSAK);
                hintText.push('<span class="text-warning"><i class="bx bx-error"></i> Rusak: Rp ' + formatRupiah(dendaKondisi) + ' (50% dari harga sewa)</span>');
            } else if (kondisi === 'hilang') {
                dendaKondisi = Math.round(hargaSewa * DENDA_HILANG);
                hintText.push('<span class="text-danger"><i class="bx bx-x-circle"></i> Hilang: Rp ' + formatRupiah(dendaKondisi) + ' (100% dari harga sewa)</span>');
            } else {
                hintText.push('<span class="text-success"><i class="bx bx-check-circle"></i> Kondisi baik</span>');
            }

            // Hitung denda keterlambatan
            const hariTerlambat = hitungHariTerlambat();
            if (hariTerlambat > 0) {
                dendaTerlambat = hariTerlambat * DENDA_TERLAMBAT_PER_HARI;
                hintText.push('<span class="text-danger"><i class="bx bx-time"></i> Terlambat ' + hariTerlambat + ' hari: Rp ' + formatRupiah(dendaTerlambat) + ' (Rp 50.000/hari)</span>');
            }

            // Total denda
            const totalDenda = dendaKondisi + dendaTerlambat;

            // Update tampilan
            if (totalDenda > 0) {
                inputDendaDisplay.style.backgroundColor = '#f8d7da';
                inputDendaDisplay.style.color = '#721c24';
                inputDendaDisplay.style.fontWeight = '700';
            } else {
                inputDendaDisplay.style.backgroundColor = '#d4edda';
                inputDendaDisplay.style.color = '#155724';
                inputDendaDisplay.style.fontWeight = '600';
            }

            // Update nilai
            inputDenda.value = totalDenda;
            inputDendaDisplay.value = formatRupiah(totalDenda);
            dendaHint.innerHTML = hintText.join('<br>');
        }

        selectSewa?.addEventListener('change', updateInfo);
        selectKondisi?.addEventListener('change', updateDenda);
        inputTglKembali?.addEventListener('change', updateDenda);

        // Trigger on load if already selected
        if (selectSewa?.value) {
            updateInfo();
        } else {
            // Set default style untuk kondisi baik
            updateDenda();
        }
    });
</script>

<?= $this->endSection() ?>