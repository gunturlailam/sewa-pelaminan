<?= $this->extend('index') ?>
<?= $this->section('content') ?>

<style>
    @media print {
        .no-print {
            display: none !important;
        }

        .card {
            border: none !important;
            box-shadow: none !important;
        }
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <h4 class="fw-bold mb-0"><?= $title ?></h4>
        <div>
            <a href="<?= site_url('laporan/penyewaan') ?>" class="btn btn-secondary me-2">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
            <button onclick="window.print()" class="btn btn-outline-primary">
                <i class="bx bx-printer me-1"></i> Cetak
            </button>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Invoice #<?= str_pad($penyewaan['id_sewa'], 5, '0', STR_PAD_LEFT) ?></h5>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h6 class="text-muted mb-2">Informasi Pelanggan</h6>
                    <p class="mb-1"><strong><?= esc($penyewaan['nama_pelanggan']) ?></strong></p>
                    <p class="mb-1">NIK: <?= esc($penyewaan['nik']) ?></p>
                    <p class="mb-1">HP: <?= esc($penyewaan['no_hp']) ?></p>
                    <p class="mb-0"><?= esc($penyewaan['alamat']) ?></p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h6 class="text-muted mb-2">Informasi Sewa</h6>
                    <p class="mb-1">Tanggal Sewa: <strong><?= date('d F Y', strtotime($penyewaan['tanggal_sewa'])) ?></strong></p>
                    <p class="mb-1">Tanggal Kembali: <strong><?= date('d F Y', strtotime($penyewaan['tanggal_kembali'])) ?></strong></p>
                    <p class="mb-0">Status:
                        <span class="badge bg-<?= $penyewaan['status_sewa'] == 'selesai' ? 'success' : 'warning' ?>">
                            <?= ucfirst($penyewaan['status_sewa']) ?>
                        </span>
                    </p>
                </div>
            </div>

            <hr>

            <h6 class="mb-3">Detail Item</h6>
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Pelaminan</th>
                        <th>Harga Sewa</th>
                        <th>Jumlah</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($detail as $d): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= esc($d['nama_pelaminan']) ?></td>
                            <td>Rp <?= number_format($d['harga_sewa'], 0, ',', '.') ?></td>
                            <td><?= $d['jumlah'] ?></td>
                            <td class="text-end">Rp <?= number_format($d['subtotal'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">Total:</th>
                        <th class="text-end">Rp <?= number_format($penyewaan['total_bayar'], 0, ',', '.') ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>