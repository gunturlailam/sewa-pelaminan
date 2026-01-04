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

        $pengembalian = $this->pengembalianModel
            ->select('pengembalian.*, penyewaan.tanggal_sewa, users.nama as nama_pelanggan')
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

        $data = [
            'title' => 'Laporan Pengembalian',
            'pengembalian' => $pengembalian,
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
            'totalPengembalian' => $totalPengembalian,
            'kondisiBaik' => $kondisiBaik,
            'kondisiRusak' => $kondisiRusak
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

        $data = [
            'title' => 'Laporan Denda',
            'denda' => $denda,
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
            'totalDenda' => $totalDenda
        ];

        return view('laporan/logistik/denda', $data);
    }
}
