<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KeberangkatanModel;

class Keberangkatan extends BaseController
{
    public function laporan()
    {
        $tujuan = $this->request->getGet('tujuan');
        $model = new KeberangkatanModel();
        $data['laporan'] = $model->getLaporanByTujuan($tujuan);
        $data['tujuan'] = $tujuan;
        // Render view sesuai kebutuhan, misal:
        return view('laporan/keberangkatan', $data);
    }
}
