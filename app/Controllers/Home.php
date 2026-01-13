<?php

namespace App\Controllers;

use App\Models\PelangganModel;
use App\Models\PelaminanModel;
use App\Models\PenyewaanModel;

class Home extends BaseController
{
    public function index()
    {
        $pelangganModel = new PelangganModel();
        $pelaminanModel = new PelaminanModel();
        $penyewaanModel = new PenyewaanModel();

        // Ambil transaksi terbaru
        $transaksiTerbaru = $penyewaanModel->getWithRelations();
        $transaksiTerbaru = array_slice($transaksiTerbaru, 0, 5);

        $data = [
            'title' => 'Dashboard',
            'totalPelanggan' => $pelangganModel->countAll(),
            'totalPelaminan' => $pelaminanModel->countAll(),
            'pelaminanTersedia' => $pelaminanModel->where('status', 'tersedia')->countAllResults(),
            'pelaminanDisewa' => $pelaminanModel->where('status', 'disewa')->countAllResults(),
            'pelaminanList' => $pelaminanModel->orderBy('id_pelaminan', 'DESC')->limit(5)->findAll(),
            'transaksiTerbaru' => $transaksiTerbaru,
        ];

        return view('dashboard', $data);
    }
}
