<?= $this->extend('index') ?>
<?= $this->section('content') ?>
<?php helper('auth'); ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Transaksi /</span> <?= $title ?>
    </h4>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Informasi Penyewaan</h5>
                    <div>
                        <a href="<?= site_url('transaksi/penyewaan/cetak/' . $penyewaan['id_sewa']) ?>" class="btn btn-info btn-sm" target="_blank">
                            <i class="bx bx-printer me-1"></i> Cetak Invoice
                        </a>
                        <a href="<?= site_url('transaksi/penyewaan') ?>" class="btn btn-secondary btn-sm">
                            <i class="bx bx-arrow-back me-1"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>ID Sewa</strong></div>
                        <div class="col-sm-8">#<?= str_pad($penyewaan['id_sewa'], 5, '0', STR_PAD_LEFT) ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Pelanggan</strong></div>
                        <div class="col-sm-8"><?= esc($penyewaan['nama_pelanggan']) ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>NIK</strong></div>
                        <div class="col-sm-8"><?= esc($penyewaan['nik'] ?? '-') ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>No HP</strong></div>
                        <div class="col-sm-8"><?= esc($penyewaan['no_hp'] ?? $penyewaan['telepon'] ?? '-') ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Tanggal Sewa</strong></div>
                        <div class="col-sm-8"><?= date('d F Y', strtotime($penyewaan['tanggal_sewa'])) ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Tanggal Kembali</strong></div>
                        <div class="col-sm-8"><?= date('d F Y', strtotime($penyewaan['tanggal_kembali'])) ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Status</strong></div>
                        <div class="col-sm-8">
                            <?php
                            $badgeClass = [
                                'booking' => 'bg-label-info',
                                'berjalan' => 'bg-label-warning',
                                'selesai' => 'bg-label-success',
                                'batal' => 'bg-label-danger'
                            ];
                            ?>
                            <span class="badge <?= $badgeClass[$penyewaan['status_sewa']] ?>">
                                <?= ucfirst($penyewaan['status_sewa']) ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Item -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Detail Item</h5>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Pelaminan</th>
                                <th>Harga Sewa</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($detail as $d): ?>
                                <tr>
                                    <td><?= esc($d['nama_pelaminan']) ?></td>
                                    <td>Rp <?= number_format($d['harga_sewa'], 0, ',', '.') ?></td>
                                    <td><?= $d['jumlah'] ?></td>
                                    <td>Rp <?= number_format($d['subtotal'], 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total:</th>
                                <th>Rp <?= number_format($penyewaan['total_bayar'], 0, ',', '.') ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-primary text-white mb-3">
                <div class="card-body">
                    <h6 class="text-white mb-3">Total Pembayaran</h6>
                    <h3 class="text-white mb-0">Rp <?= number_format($penyewaan['total_bayar'], 0, ',', '.') ?></h3>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?= site_url('transaksi/penyewaan/cetak/' . $penyewaan['id_sewa']) ?>" class="btn btn-outline-info" target="_blank">
                            <i class="bx bx-printer me-1"></i> Cetak Invoice
                        </a>
                        <?php if (hasRole(['admin', 'petugas'])): ?>
                            <a href="<?= site_url('transaksi/pembayaran/create?id_sewa=' . $penyewaan['id_sewa']) ?>" class="btn btn-outline-success">
                                <i class="bx bx-money me-1"></i> Input Pembayaran
                            </a>
                        <?php endif; ?>
                        <?php if (isAdmin()): ?>
                            <a href="<?= site_url('transaksi/penyewaan/edit/' . $penyewaan['id_sewa']) ?>" class="btn btn-outline-warning">
                                <i class="bx bx-edit me-1"></i> Edit Penyewaan
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>