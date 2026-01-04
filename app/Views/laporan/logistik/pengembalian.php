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
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="text-white mb-1">Total Pengembalian</h6>
                    <h3 class="text-white mb-0"><?= $totalPengembalian ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="text-white mb-1">Kondisi Baik</h6>
                    <h3 class="text-white mb-0"><?= $kondisiBaik ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h6 class="text-white mb-1">Kondisi Rusak</h6>
                    <h3 class="text-white mb-0"><?= $kondisiRusak ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Data Pengembalian</h5>
            <small class="text-muted">Periode: <?= date('d/m/Y', strtotime($tanggalMulai)) ?> - <?= date('d/m/Y', strtotime($tanggalSelesai)) ?></small>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tgl Kembali</th>
                        <th>Pelanggan</th>
                        <th>Tgl Sewa</th>
                        <th>Kondisi</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pengembalian)): ?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1;
                        foreach ($pengembalian as $p): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= date('d/m/Y', strtotime($p['tanggal_kembali'])) ?></td>
                                <td><?= esc($p['nama_pelanggan']) ?></td>
                                <td><?= date('d/m/Y', strtotime($p['tanggal_sewa'])) ?></td>
                                <td>
                                    <span class="badge bg-<?= $p['kondisi'] == 'baik' ? 'success' : 'danger' ?>">
                                        <?= ucfirst($p['kondisi']) ?>
                                    </span>
                                </td>
                                <td>Rp <?= number_format($p['denda'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>