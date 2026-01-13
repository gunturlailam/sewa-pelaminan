<?php

namespace App\Controllers\Laporan;

use App\Controllers\BaseController;
use App\Models\PembayaranModel;
use App\Models\PenyewaanModel;

class Keuangan extends BaseController
{
    protected $pembayaranModel;
    protected $penyewaanModel;

    public function __construct()
    {
        $this->pembayaranModel = new PembayaranModel();
        $this->penyewaanModel = new PenyewaanModel();
    }

    public function pembayaran()
    {
        if (!$this->canViewLaporan()) {
            return $this->denyAccess();
        }

        $tanggalMulai = $this->request->getGet('tanggal_mulai') ?? date('Y-m-01');
        $tanggalSelesai = $this->request->getGet('tanggal_selesai') ?? date('Y-m-d');

        // ============================================
        // VALIDASI FILTER TANGGAL
        // ============================================
        $errors = $this->validateDateFilter($tanggalMulai, $tanggalSelesai);
        if (!empty($errors)) {
            return redirect()->back()->with('error', implode(', ', $errors));
        }

        $pembayaran = $this->pembayaranModel
            ->select('pembayaran.*, penyewaan.tanggal_sewa, penyewaan.total_bayar as total_sewa, users.nama as nama_pelanggan')
            ->join('penyewaan', 'penyewaan.id_sewa = pembayaran.id_sewa')
            ->join('pelanggan', 'pelanggan.id_pelanggan = penyewaan.id_pelanggan')
            ->join('users', 'users.id_user = pelanggan.id_user')
            ->where('pembayaran.tanggal_bayar >=', $tanggalMulai)
            ->where('pembayaran.tanggal_bayar <=', $tanggalSelesai)
            ->orderBy('pembayaran.tanggal_bayar', 'DESC')
            ->findAll();

        $totalPembayaran = array_sum(array_column($pembayaran, 'jumlah_bayar'));
        $totalTunai = array_sum(array_column(array_filter($pembayaran, fn($p) => $p['metode_bayar'] == 'tunai'), 'jumlah_bayar'));
        $totalTransfer = array_sum(array_column(array_filter($pembayaran, fn($p) => $p['metode_bayar'] == 'transfer'), 'jumlah_bayar'));

        $data = [
            'title' => 'Laporan Pembayaran',
            'pembayaran' => $pembayaran,
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
            'totalPembayaran' => $totalPembayaran,
            'totalTunai' => $totalTunai,
            'totalTransfer' => $totalTransfer
        ];

        return view('laporan/keuangan/pembayaran', $data);
    }

    public function piutang()
    {
        if (!$this->canViewLaporan()) {
            return $this->denyAccess();
        }

        // Ambil penyewaan yang belum lunas
        $penyewaan = $this->penyewaanModel
            ->select('penyewaan.*, users.nama as nama_pelanggan, pelanggan.nik, users.no_hp,
                      COALESCE((SELECT SUM(jumlah_bayar) FROM pembayaran WHERE pembayaran.id_sewa = penyewaan.id_sewa), 0) as total_dibayar')
            ->join('pelanggan', 'pelanggan.id_pelanggan = penyewaan.id_pelanggan')
            ->join('users', 'users.id_user = pelanggan.id_user')
            ->where('penyewaan.status_sewa !=', 'batal')
            ->orderBy('penyewaan.tanggal_sewa', 'DESC')
            ->findAll();

        // Filter yang masih ada piutang
        $piutang = array_filter($penyewaan, function ($p) {
            return ($p['total_bayar'] - $p['total_dibayar']) > 0;
        });

        $totalPiutang = array_sum(array_map(function ($p) {
            return $p['total_bayar'] - $p['total_dibayar'];
        }, $piutang));

        // Hitung piutang jatuh tempo (tanggal kembali sudah lewat)
        $today = date('Y-m-d');
        $piutangJatuhTempo = array_filter($piutang, function ($p) use ($today) {
            return $p['tanggal_kembali'] < $today;
        });
        $totalJatuhTempo = array_sum(array_map(function ($p) {
            return $p['total_bayar'] - $p['total_dibayar'];
        }, $piutangJatuhTempo));

        $data = [
            'title' => 'Laporan Piutang',
            'piutang' => $piutang,
            'totalPiutang' => $totalPiutang,
            'totalJatuhTempo' => $totalJatuhTempo,
            'jumlahJatuhTempo' => count($piutangJatuhTempo)
        ];

        return view('laporan/keuangan/piutang', $data);
    }

    /**
     * Validasi filter tanggal
     */
    private function validateDateFilter($tanggalMulai, $tanggalSelesai): array
    {
        $errors = [];

        // Validasi format tanggal
        if (!$this->isValidDate($tanggalMulai)) {
            $errors[] = 'Format tanggal mulai tidak valid';
        }

        if (!$this->isValidDate($tanggalSelesai)) {
            $errors[] = 'Format tanggal selesai tidak valid';
        }

        if (!empty($errors)) {
            return $errors;
        }

        // Validasi tanggal mulai tidak lebih dari tanggal selesai
        if (strtotime($tanggalMulai) > strtotime($tanggalSelesai)) {
            $errors[] = 'Tanggal mulai tidak boleh lebih dari tanggal selesai';
        }

        // Validasi rentang maksimal 1 tahun
        $diff = (strtotime($tanggalSelesai) - strtotime($tanggalMulai)) / (60 * 60 * 24);
        if ($diff > 365) {
            $errors[] = 'Rentang tanggal maksimal 1 tahun (365 hari)';
        }

        // Validasi tanggal tidak di masa depan (untuk laporan)
        if (strtotime($tanggalSelesai) > strtotime(date('Y-m-d'))) {
            // Tidak error, tapi set ke hari ini
            // $errors[] = 'Tanggal selesai tidak boleh lebih dari hari ini';
        }

        return $errors;
    }

    /**
     * Cek apakah format tanggal valid
     */
    private function isValidDate($date): bool
    {
        $d = \DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }
}
