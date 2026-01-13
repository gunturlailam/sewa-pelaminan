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

        // ============================================
        // VALIDASI FILTER TANGGAL
        // ============================================
        $errors = $this->validateDateFilter($tanggalMulai, $tanggalSelesai);
        if (!empty($errors)) {
            return redirect()->back()->with('error', implode(', ', $errors));
        }

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

        // Validasi ID
        if (!is_numeric($id) || $id <= 0) {
            return redirect()->to('/laporan/penyewaan')->with('error', 'ID tidak valid');
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
