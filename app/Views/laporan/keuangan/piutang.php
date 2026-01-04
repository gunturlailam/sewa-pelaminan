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

    <!-- Summary -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h6 class="text-white mb-1">Total Piutang</h6>
                    <h3 class="text-white mb-0">Rp <?= number_format($totalPiutang, 0, ',', '.') ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6 class="text-white mb-1">Jumlah Transaksi Belum Lunas</h6>
                    <h3 class="text-white mb-0"><?= count($piutang) ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Daftar Piutang</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>ID Sewa</th>
                        <th>Pelanggan</th>
                        <th>Tgl Sewa</th>
                        <th>Total Sewa</th>
                        <th>Sudah Dibayar</th>
                        <th>Sisa Piutang</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($piutang)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-success">Tidak ada piutang</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1;
                        foreach ($piutang as $p): ?>
                            <?php $sisa = $p['total_bayar'] - $p['total_dibayar']; ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>#<?= str_pad($p['id_sewa'], 5, '0', STR_PAD_LEFT) ?></td>
                                <td><?= esc($p['nama_pelanggan']) ?></td>
                                <td><?= date('d/m/Y', strtotime($p['tanggal_sewa'])) ?></td>
                                <td>Rp <?= number_format($p['total_bayar'], 0, ',', '.') ?></td>
                                <td>Rp <?= number_format($p['total_dibayar'], 0, ',', '.') ?></td>
                                <td class="text-danger fw-bold">Rp <?= number_format($sisa, 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="6" class="text-end">Total Piutang:</th>
                        <th class="text-danger">Rp <?= number_format($totalPiutang, 0, ',', '.') ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>