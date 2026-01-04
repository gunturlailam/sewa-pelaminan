<?php

namespace App\Controllers;

use App\Models\PelangganModel;
use App\Models\PaketModel;
use App\Models\PelaminanModel;

class Home extends BaseController
{
    public function index()
    {
        $pelangganModel = new PelangganModel();
        $paketModel = new PaketModel();
        $pelaminanModel = new PelaminanModel();

        $data = [
            'title' => 'Dashboard',
            'totalPelanggan' => $pelangganModel->countAll(),
            'totalPaket' => $paketModel->where('status', 'aktif')->countAllResults(),
            'totalPelaminan' => $pelaminanModel->countAll(),
            'pelaminanTersedia' => $pelaminanModel->where('status', 'tersedia')->countAllResults(),
            'pelaminanDisewa' => $pelaminanModel->where('status', 'disewa')->countAllResults(),
            'paketTerbaru' => $paketModel->orderBy('id_paket', 'DESC')->limit(5)->findAll(),
            'pelaminanList' => $pelaminanModel->orderBy('id_pelaminan', 'DESC')->limit(5)->findAll(),
        ];

        return view('dashboard', $data);
    }
}
