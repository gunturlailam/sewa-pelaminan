<?php

namespace App\Controllers\Laporan;

use App\Controllers\BaseController;
use App\Models\PenyewaanModel;
use App\Models\DetailPenyewaanModel;

class Penyewaan extends BaseController
{
    protected $penyewaanModel;
    protected $detailModel;

    public function __construct()
    {
        $this->penyewaanModel = new PenyewaanModel();
        $this->detailModel = new DetailPenyewaanModel();
    }

    public function index()
    {
        if (!$this->canViewLaporan()) {
            return $this->denyAccess();
        }

        $tanggalMulai = $this->request->getGet('tanggal_mulai') ?? date('Y-m-01');
        $tanggalSelesai = $this->request->getGet('tanggal_selesai') ?? date('Y-m-d');

        $penyewaan = $this->penyewaanModel
            ->select('penyewaan.*, users.nama as nama_pelanggan, pelanggan.nik')
            ->join('pelanggan', 'pelanggan.id_pelanggan = penyewaan.id_pelanggan')
            ->join('users', 'users.id_user = pelanggan.id_user')
            ->where('penyewaan.tanggal_sewa >=', $tanggalMulai)
            ->where('penyewaan.tanggal_sewa <=', $tanggalSelesai)
            ->orderBy('penyewaan.tanggal_sewa', 'DESC')
            ->findAll();

        // Hitung total
        $totalSewa = array_sum(array_column($penyewaan, 'total_bayar'));
        $totalTransaksi = count($penyewaan);

        $data = [
            'title' => 'Laporan Penyewaan',
            'penyewaan' => $penyewaan,
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
            'totalSewa' => $totalSewa,
            'totalTransaksi' => $totalTransaksi
        ];

        return view('laporan/penyewaan/index', $data);
    }

    public function detail($id)
    {
        if (!$this->canViewLaporan()) {
            return $this->denyAccess();
        }

        $penyewaan = $this->penyewaanModel
            ->select('penyewaan.*, users.nama as nama_pelanggan, pelanggan.nik, users.no_hp, users.alamat')
            ->join('pelanggan', 'pelanggan.id_pelanggan = penyewaan.id_pelanggan')
            ->join('users', 'users.id_user = pelanggan.id_user')
            ->where('penyewaan.id_sewa', $id)
            ->first();

        if (!$penyewaan) {
            return redirect()->to('/laporan/penyewaan')->with('error', 'Data tidak ditemukan');
        }

        $detail = $this->detailModel->getByPenyewaan($id);

        $data = [
            'title' => 'Detail Laporan Penyewaan',
            'penyewaan' => $penyewaan,
            'detail' => $detail
        ];

        return view('laporan/penyewaan/detail', $data);
    }
}
