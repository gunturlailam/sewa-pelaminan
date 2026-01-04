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
        <button onclick="window.print()" class="btn btn-outline-primary">
            <i class="bx bx-printer me-1"></i> Cetak
        </button>
    </div>

    <!-- Filter -->
    <div class="card mb-4 no-print">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="<?= $tanggalMulai ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control" value="<?= $tanggalSelesai ?>">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-filter-alt me-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="text-white mb-1">Total Transaksi</h6>
                    <h3 class="text-white mb-0"><?= $totalTransaksi ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="text-white mb-1">Total Nilai Sewa</h6>
                    <h3 class="text-white mb-0">Rp <?= number_format($totalSewa, 0, ',', '.') ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Rekap Penyewaan</h5>
            <small class="text-muted">Periode: <?= date('d/m/Y', strtotime($tanggalMulai)) ?> - <?= date('d/m/Y', strtotime($tanggalSelesai)) ?></small>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>ID Sewa</th>
                        <th>Pelanggan</th>
                        <th>Tgl Sewa</th>
                        <th>Tgl Kembali</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th class="no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($penyewaan)): ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1;
                        foreach ($penyewaan as $p): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>#<?= str_pad($p['id_sewa'], 5, '0', STR_PAD_LEFT) ?></td>
                                <td><?= esc($p['nama_pelanggan']) ?></td>
                                <td><?= date('d/m/Y', strtotime($p['tanggal_sewa'])) ?></td>
                                <td><?= date('d/m/Y', strtotime($p['tanggal_kembali'])) ?></td>
                                <td>Rp <?= number_format($p['total_bayar'], 0, ',', '.') ?></td>
                                <td>
                                    <span class="badge bg-<?= $p['status_sewa'] == 'selesai' ? 'success' : ($p['status_sewa'] == 'batal' ? 'danger' : 'warning') ?>">
                                        <?= ucfirst($p['status_sewa']) ?>
                                    </span>
                                </td>
                                <td class="no-print">
                                    <a href="<?= site_url('laporan/penyewaan/detail/' . $p['id_sewa']) ?>" class="btn btn-sm btn-info">
                                        <i class="bx bx-show"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="5" class="text-end">Total:</th>
                        <th>Rp <?= number_format($totalSewa, 0, ',', '.') ?></th>
                        <th colspan="2"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>