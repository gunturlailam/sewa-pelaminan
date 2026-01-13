<?php

namespace App\Controllers\Laporan;

use App\Controllers\BaseController;
use App\Models\PengembalianModel;

class Logistik extends BaseController
{
    protected $pengembalianModel;

    public function __construct()
    {
        $this->pengembalianModel = new PengembalianModel();
    }

    public function pengembalian()
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

        $pengembalian = $this->pengembalianModel
            ->select('pengembalian.*, penyewaan.tanggal_sewa, penyewaan.tanggal_kembali as jadwal_kembali, users.nama as nama_pelanggan')
            ->join('penyewaan', 'penyewaan.id_sewa = pengembalian.id_sewa')
            ->join('pelanggan', 'pelanggan.id_pelanggan = penyewaan.id_pelanggan')
            ->join('users', 'users.id_user = pelanggan.id_user')
            ->where('pengembalian.tanggal_kembali >=', $tanggalMulai)
            ->where('pengembalian.tanggal_kembali <=', $tanggalSelesai)
            ->orderBy('pengembalian.tanggal_kembali', 'DESC')
            ->findAll();

        $totalPengembalian = count($pengembalian);
        $kondisiBaik = count(array_filter($pengembalian, fn($p) => $p['kondisi'] == 'baik'));
        $kondisiRusak = count(array_filter($pengembalian, fn($p) => $p['kondisi'] == 'rusak'));

        // Hitung keterlambatan
        $terlambat = 0;
        foreach ($pengembalian as $p) {
            if (isset($p['jadwal_kembali']) && $p['tanggal_kembali'] > $p['jadwal_kembali']) {
                $terlambat++;
            }
        }

        $data = [
            'title' => 'Laporan Pengembalian',
            'pengembalian' => $pengembalian,
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
            'totalPengembalian' => $totalPengembalian,
            'kondisiBaik' => $kondisiBaik,
            'kondisiRusak' => $kondisiRusak,
            'terlambat' => $terlambat
        ];

        return view('laporan/logistik/pengembalian', $data);
    }

    public function denda()
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

        $denda = $this->pengembalianModel
            ->select('pengembalian.*, penyewaan.tanggal_sewa, users.nama as nama_pelanggan')
            ->join('penyewaan', 'penyewaan.id_sewa = pengembalian.id_sewa')
            ->join('pelanggan', 'pelanggan.id_pelanggan = penyewaan.id_pelanggan')
            ->join('users', 'users.id_user = pelanggan.id_user')
            ->where('pengembalian.denda >', 0)
            ->where('pengembalian.tanggal_kembali >=', $tanggalMulai)
            ->where('pengembalian.tanggal_kembali <=', $tanggalSelesai)
            ->orderBy('pengembalian.tanggal_kembali', 'DESC')
            ->findAll();

        $totalDenda = array_sum(array_column($denda, 'denda'));
        $jumlahKasus = count($denda);

        $data = [
            'title' => 'Laporan Denda',
            'denda' => $denda,
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
            'totalDenda' => $totalDenda,
            'jumlahKasus' => $jumlahKasus
        ];

        return view('laporan/logistik/denda', $data);
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
