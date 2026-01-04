<?php

namespace App\Controllers\Laporan;

use App\Controllers\BaseController;
use App\Models\PenyewaanModel;
use App\Models\PembayaranModel;
use App\Models\PengembalianModel;

class Pelanggan extends BaseController
{
    protected $penyewaanModel;
    protected $pembayaranModel;
    protected $pengembalianModel;

    public function __construct()
    {
        $this->penyewaanModel = new PenyewaanModel();
        $this->pembayaranModel = new PembayaranModel();
        $this->pengembalianModel = new PengembalianModel();
    }

    public function index()
    {
        // Admin & Petugas bisa lihat semua, Pelanggan hanya miliknya
        $idPelanggan = null;

        if ($this->isPelanggan()) {
            $idPelanggan = $this->session->get('pelanggan_id');
        } else {
            $idPelanggan = $this->request->getGet('id_pelanggan');
        }

        $tanggalMulai = $this->request->getGet('tanggal_mulai') ?? date('Y-01-01');
        $tanggalSelesai = $this->request->getGet('tanggal_selesai') ?? date('Y-m-d');

        // Query penyewaan
        $queryPenyewaan = $this->penyewaanModel
            ->select('penyewaan.*, users.nama as nama_pelanggan')
            ->join('pelanggan', 'pelanggan.id_pelanggan = penyewaan.id_pelanggan')
            ->join('users', 'users.id_user = pelanggan.id_user')
            ->where('penyewaan.tanggal_sewa >=', $tanggalMulai)
            ->where('penyewaan.tanggal_sewa <=', $tanggalSelesai);

        if ($idPelanggan) {
            $queryPenyewaan->where('penyewaan.id_pelanggan', $idPelanggan);
        }

        $penyewaan = $queryPenyewaan->orderBy('penyewaan.tanggal_sewa', 'DESC')->findAll();

        // Statistik
        $totalTransaksi = count($penyewaan);
        $totalNilai = array_sum(array_column($penyewaan, 'total_bayar'));
        $selesai = count(array_filter($penyewaan, fn($p) => $p['status_sewa'] == 'selesai'));
        $berjalan = count(array_filter($penyewaan, fn($p) => in_array($p['status_sewa'], ['booking', 'berjalan'])));

        // Untuk dropdown pelanggan (Admin & Petugas)
        $pelangganList = [];
        if (!$this->isPelanggan()) {
            $pelangganModel = new \App\Models\PelangganModel();
            $pelangganList = $pelangganModel->getWithUser();
        }

        $data = [
            'title' => 'Riwayat Transaksi Pelanggan',
            'penyewaan' => $penyewaan,
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
            'idPelanggan' => $idPelanggan,
            'pelangganList' => $pelangganList,
            'totalTransaksi' => $totalTransaksi,
            'totalNilai' => $totalNilai,
            'selesai' => $selesai,
            'berjalan' => $berjalan
        ];

        return view('laporan/pelanggan/index', $data);
    }

    /**
     * Riwayat Transaksi Personal - Khusus untuk role Pelanggan
     * Menampilkan data penyewaan dengan status pembayaran
     */
    public function riwayat()
    {
        // Pastikan hanya pelanggan yang bisa akses
        if (!$this->isPelanggan()) {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak');
        }

        $pelangganId = session()->get('pelanggan_id');

        if (!$pelangganId) {
            return redirect()->to('dashboard')->with('error', 'Data pelanggan tidak ditemukan');
        }

        // Query: JOIN penyewaan dengan pembayaran untuk mendapatkan status lunas
        $db = \Config\Database::connect();

        $riwayat = $db->table('penyewaan p')
            ->select('
                p.id_sewa,
                p.tanggal_sewa,
                p.tanggal_kembali,
                p.total_bayar,
                p.status_sewa,
                COALESCE(SUM(pb.jumlah_bayar), 0) as total_dibayar
            ')
            ->join('pembayaran pb', 'pb.id_sewa = p.id_sewa', 'left')
            ->where('p.id_pelanggan', $pelangganId)
            ->groupBy('p.id_sewa')
            ->orderBy('p.tanggal_sewa', 'DESC')
            ->get()
            ->getResultArray();

        // Hitung statistik
        $totalTransaksi = count($riwayat);
        $totalNilai = array_sum(array_column($riwayat, 'total_bayar'));
        $lunas = 0;
        $belumLunas = 0;

        foreach ($riwayat as &$item) {
            $item['sisa_bayar'] = $item['total_bayar'] - $item['total_dibayar'];
            $item['status_bayar'] = ($item['sisa_bayar'] <= 0) ? 'Lunas' : 'Belum Lunas';

            if ($item['sisa_bayar'] <= 0) {
                $lunas++;
            } else {
                $belumLunas++;
            }
        }

        $data = [
            'title' => 'Riwayat Transaksi Saya',
            'riwayat' => $riwayat,
            'totalTransaksi' => $totalTransaksi,
            'totalNilai' => $totalNilai,
            'lunas' => $lunas,
            'belumLunas' => $belumLunas
        ];

        return view('laporan/pelanggan/v_history_personal', $data);
    }
}
