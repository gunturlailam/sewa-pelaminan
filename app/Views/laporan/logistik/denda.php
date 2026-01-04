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

    <!-- Summary -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h6 class="text-white mb-1">Total Denda</h6>
                    <h3 class="text-white mb-0">Rp <?= number_format($totalDenda, 0, ',', '.') ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6 class="text-white mb-1">Jumlah Kasus</h6>
                    <h3 class="text-white mb-0"><?= count($denda) ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Data Denda</h5>
            <small class="text-muted">Periode: <?= date('d/m/Y', strtotime($tanggalMulai)) ?> - <?= date('d/m/Y', strtotime($tanggalSelesai)) ?></small>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tgl Kembali</th>
                        <th>Pelanggan</th>
                        <th>Kondisi</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($denda)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-success">Tidak ada denda</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1;
                        foreach ($denda as $d): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= date('d/m/Y', strtotime($d['tanggal_kembali'])) ?></td>
                                <td><?= esc($d['nama_pelanggan']) ?></td>
                                <td>
                                    <span class="badge bg-danger"><?= ucfirst($d['kondisi']) ?></span>
                                </td>
                                <td class="text-danger fw-bold">Rp <?= number_format($d['denda'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="4" class="text-end">Total Denda:</th>
                        <th class="text-danger">Rp <?= number_format($totalDenda, 0, ',', '.') ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>