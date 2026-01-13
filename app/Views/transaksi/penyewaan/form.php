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

    .pelaminan-info {
        background: rgba(34, 197, 94, 0.1);
        border: 1px solid rgba(34, 197, 94, 0.2);
        border-radius: 10px;
        padding: 1rem;
        margin-top: 0.5rem;
        display: none;
    }

    .total-display {
        background: rgba(105, 108, 255, 0.1);
        border: 1px solid rgba(105, 108, 255, 0.2);
        border-radius: 10px;
        padding: 1rem;
        text-align: center;
        font-size: 1.1rem;
        font-weight: 600;
        color: #696cff;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Transaksi /</span> <?= $title ?>
    </h4>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class='bx bx-error-circle me-2'></i><?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($validation && $validation->getErrors()): ?>
        <div class="alert alert-danger">
            <strong><i class='bx bx-error me-1'></i> Terdapat kesalahan:</strong>
            <ul class="mt-2 mb-0">
                <?php foreach ($validation->getErrors() as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="form-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class='bx bx-edit'></i> <?= $title ?></h5>
            <a href="<?= site_url('transaksi/penyewaan') ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <?php
            $isEdit = isset($penyewaan);
            $action = $isEdit ? site_url('transaksi/penyewaan/update/' . $penyewaan['id_sewa']) : site_url('transaksi/penyewaan/store');
            ?>

            <form action="<?= $action ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <!-- Data Pelanggan -->
                <div class="form-section">
                    <div class="form-section-title"><i class='bx bx-user'></i> Data Pelanggan</div>
                    <?php if (!isPelanggan()): ?>
                        <div class="mb-0">
                            <label class="form-label">Pelanggan <span class="text-danger">*</span></label>
                            <select class="form-select" name="id_pelanggan" required <?= $isEdit ? 'disabled' : '' ?>>
                                <option value="">-- Pilih Pelanggan --</option>
                                <?php foreach ($pelanggan as $p): ?>
                                    <option value="<?= $p['id_pelanggan'] ?>" <?= old('id_pelanggan', $penyewaan['id_pelanggan'] ?? '') == $p['id_pelanggan'] ? 'selected' : '' ?>>
                                        <?= esc($p['nama']) ?> - <?= esc($p['nik']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info mb-0">
                            <i class='bx bx-info-circle me-1'></i> Penyewaan atas nama: <strong><?= session()->get('nama') ?></strong>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Pilih Pelaminan -->
                <div class="form-section">
                    <div class="form-section-title"><i class='bx bx-package'></i> Pilih Pelaminan</div>
                    <div class="mb-3">
                        <label class="form-label">Pelaminan <span class="text-danger">*</span></label>
                        <select class="form-select" id="id_pelaminan" name="id_pelaminan" required <?= $isEdit ? 'disabled' : '' ?>>
                            <option value="">-- Pilih Pelaminan --</option>
                            <?php if (empty($pelaminan)): ?>
                                <option value="" disabled>Tidak ada pelaminan yang tersedia</option>
                            <?php else: ?>
                                <?php foreach ($pelaminan as $item): ?>
                                    <option value="<?= $item['id_pelaminan'] ?>"
                                        data-harga="<?= $item['harga_sewa'] ?>"
                                        data-nama="<?= esc($item['nama_pelaminan']) ?>"
                                        data-jenis="<?= esc($item['jenis']) ?>"
                                        data-warna="<?= esc($item['warna']) ?>"
                                        data-kategori="<?= esc($item['nama_kategori'] ?? 'Tanpa Kategori') ?>"
                                        <?= old('id_pelaminan', $penyewaan['id_pelaminan'] ?? '') == $item['id_pelaminan'] ? 'selected' : '' ?>>
                                        [<?= esc($item['nama_kategori'] ?? 'Tanpa Kategori') ?>] <?= esc($item['nama_pelaminan']) ?> - Rp <?= number_format($item['harga_sewa'], 0, ',', '.') ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <div class="form-text">Hanya pelaminan yang tersedia (tidak sedang disewa) yang ditampilkan</div>
                    </div>

                    <!-- Info Pelaminan -->
                    <div class="pelaminan-info" id="pelaminan-info">
                        <div class="row">
                            <div class="col-md-8">
                                <strong>Detail Pelaminan:</strong><br>
                                <span id="info-nama">-</span><br>
                                <small class="text-muted">
                                    Kategori: <span id="info-kategori">-</span> |
                                    Jenis: <span id="info-jenis">-</span> |
                                    Warna: <span id="info-warna">-</span>
                                </small>
                            </div>
                            <div class="col-md-4 text-end">
                                <strong>Harga Sewa:</strong><br>
                                <span class="text-success fs-5" id="info-harga">Rp 0</span><br>
                                <small class="text-muted">1 unit</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Jadwal Sewa -->
                <div class="form-section">
                    <div class="form-section-title"><i class='bx bx-calendar'></i> Jadwal Sewa</div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Sewa <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="tanggal_sewa" name="tanggal_sewa"
                                value="<?= old('tanggal_sewa', $penyewaan['tanggal_sewa'] ?? date('Y-m-d')) ?>"
                                min="<?= date('Y-m-d') ?>" required>
                            <div class="form-text">Tidak boleh sebelum hari ini</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Kembali <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali"
                                value="<?= old('tanggal_kembali', $penyewaan['tanggal_kembali'] ?? '') ?>" required>
                            <div class="form-text">Maksimal 7 hari dari tanggal sewa</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat Acara <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="alamat_acara" rows="2"
                            placeholder="Alamat lengkap lokasi acara" required><?= old('alamat_acara', $penyewaan['alamat_acara'] ?? '') ?></textarea>
                        <div class="form-text">Minimal 10 karakter</div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Catatan</label>
                        <textarea class="form-control" name="catatan" rows="2"
                            placeholder="Catatan tambahan (opsional)"><?= old('catatan', $penyewaan['catatan'] ?? '') ?></textarea>
                    </div>
                </div>

                <?php if ($isEdit): ?>
                    <!-- Status -->
                    <div class="form-section">
                        <div class="form-section-title"><i class='bx bx-check-circle'></i> Status</div>
                        <select class="form-select" name="status_sewa" required>
                            <option value="booking" <?= ($penyewaan['status_sewa'] ?? '') == 'booking' ? 'selected' : '' ?>>Booking</option>
                            <option value="berjalan" <?= ($penyewaan['status_sewa'] ?? '') == 'berjalan' ? 'selected' : '' ?>>Berjalan</option>
                            <option value="selesai" <?= ($penyewaan['status_sewa'] ?? '') == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                            <option value="batal" <?= ($penyewaan['status_sewa'] ?? '') == 'batal' ? 'selected' : '' ?>>Batal</option>
                        </select>
                    </div>
                <?php else: ?>
                    <!-- Pembayaran DP -->
                    <div class="form-section">
                        <div class="form-section-title"><i class='bx bx-money'></i> Pembayaran DP (Opsional)</div>

                        <!-- Info Minimal DP -->
                        <div id="info-minimal-dp" style="display: none; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border: 1px solid #f59e0b; border-radius: 10px; padding: 0.75rem 1rem; margin-bottom: 1rem;">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <i class='bx bx-info-circle' style="color: #b45309; font-size: 1.25rem;"></i>
                                <div>
                                    <div style="font-size: 0.85rem; color: #92400e; font-weight: 500;">Minimal DP (30%)</div>
                                    <div id="minimal-dp-value" style="font-size: 1.1rem; font-weight: 700; color: #b45309;">Rp 0</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jumlah DP</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="dp_bayar" name="dp_bayar" value="0" min="0">
                                </div>
                                <div class="form-text">Minimal 30% dari total. Kosongkan jika belum bayar.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Metode Pembayaran</label>
                                <input type="text" class="form-control" value="💵 Tunai" disabled>
                                <input type="hidden" name="metode_bayar" value="tunai">
                            </div>
                        </div>

                    </div>
                <?php endif; ?>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="<?= site_url('transaksi/penyewaan') ?>" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save me-1"></i> <?= $isEdit ? 'Update' : 'Simpan' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pelaminanSelect = document.getElementById('id_pelaminan');
        const pelaminanInfo = document.getElementById('pelaminan-info');
        const tanggalSewa = document.getElementById('tanggal_sewa');
        const tanggalKembali = document.getElementById('tanggal_kembali');
        const infoMinimalDp = document.getElementById('info-minimal-dp');
        const minimalDpValue = document.getElementById('minimal-dp-value');
        const dpInput = document.getElementById('dp_bayar');

        // Update info pelaminan dan minimal DP
        function updatePelaminanInfo() {
            const selected = pelaminanSelect.selectedOptions[0];
            if (selected && selected.value) {
                const harga = parseInt(selected.dataset.harga);

                document.getElementById('info-nama').textContent = selected.dataset.nama;
                document.getElementById('info-kategori').textContent = selected.dataset.kategori;
                document.getElementById('info-jenis').textContent = selected.dataset.jenis;
                document.getElementById('info-warna').textContent = selected.dataset.warna;
                document.getElementById('info-harga').textContent = 'Rp ' + harga.toLocaleString('id-ID');

                pelaminanInfo.style.display = 'block';

                // Hitung dan tampilkan minimal DP (30%)
                const minimalDp = Math.ceil(harga * 0.3);
                if (minimalDpValue) {
                    minimalDpValue.textContent = 'Rp ' + minimalDp.toLocaleString('id-ID');
                    infoMinimalDp.style.display = 'block';
                }

                // Set min value untuk input DP
                if (dpInput) {
                    dpInput.setAttribute('data-min-dp', minimalDp);
                    dpInput.setAttribute('data-max-dp', harga);
                }
            } else {
                pelaminanInfo.style.display = 'none';
                if (infoMinimalDp) {
                    infoMinimalDp.style.display = 'none';
                }
            }
        }

        // Event listeners
        pelaminanSelect?.addEventListener('change', updatePelaminanInfo);

        // Validasi tanggal
        tanggalSewa?.addEventListener('change', function() {
            tanggalKembali.min = this.value;
            const sewaDate = new Date(this.value);
            sewaDate.setDate(sewaDate.getDate() + 7);
            tanggalKembali.max = sewaDate.toISOString().split('T')[0];
            if (tanggalKembali.value && tanggalKembali.value < this.value) {
                tanggalKembali.value = this.value;
            }
        });

        // Initialize
        if (tanggalSewa?.value) tanggalSewa.dispatchEvent(new Event('change'));
        updatePelaminanInfo();
    });
</script>

<?= $this->endSection() ?>