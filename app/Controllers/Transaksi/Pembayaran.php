<?php

namespace App\Controllers\Transaksi;

use App\Controllers\BaseController;
use App\Models\PembayaranModel;
use App\Models\PenyewaanModel;

class Pembayaran extends BaseController
{
    protected $pembayaranModel;
    protected $penyewaanModel;

    public function __construct()
    {
        $this->pembayaranModel = new PembayaranModel();
        $this->penyewaanModel = new PenyewaanModel();
    }

    public function index()
    {
        if ($this->isPelanggan()) {
            $pembayaran = $this->pembayaranModel->getByPelanggan($this->session->get('pelanggan_id'));
        } else {
            $pembayaran = $this->pembayaranModel->getWithRelations();
        }

        $data = [
            'title' => 'Data Pembayaran',
            'pembayaran' => $pembayaran
        ];
        return view('transaksi/pembayaran/index', $data);
    }

    public function create()
    {
        if (!$this->canInputTransaksi()) {
            return $this->denyAccess();
        }

        $data = [
            'title' => 'Tambah Pembayaran',
            'penyewaan' => $this->penyewaanModel->getWithRelations(),
            'validation' => \Config\Services::validation()
        ];
        return view('transaksi/pembayaran/form', $data);
    }

    public function store()
    {
        if (!$this->canInputTransaksi()) {
            return $this->denyAccess();
        }

        $rules = [
            'id_sewa'      => 'required|numeric',
            'tanggal_bayar' => 'required|valid_date',
            'metode'       => 'required|in_list[tunai,transfer]',
            'jumlah_bayar' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idSewa = $this->request->getPost('id_sewa');
        $jumlahBayar = $this->request->getPost('jumlah_bayar');

        // Cek total yang sudah dibayar
        $penyewaan = $this->penyewaanModel->find($idSewa);
        $totalDibayar = $this->pembayaranModel->getTotalBayar($idSewa);
        $sisaBayar = $penyewaan['total_bayar'] - $totalDibayar;

        // Tentukan status
        $statusBayar = ($jumlahBayar >= $sisaBayar) ? 'lunas' : 'belum';

        $this->pembayaranModel->insert([
            'id_sewa'      => $idSewa,
            'tanggal_bayar' => $this->request->getPost('tanggal_bayar'),
            'metode'       => $this->request->getPost('metode'),
            'jumlah_bayar' => $jumlahBayar,
            'status_bayar' => $statusBayar
        ]);

        return redirect()->to('/transaksi/pembayaran')->with('success', 'Pembayaran berhasil ditambahkan');
    }

    public function edit($id)
    {
        if (!$this->isAdmin()) {
            return $this->denyAccess();
        }

        $pembayaran = $this->pembayaranModel->find($id);
        if (!$pembayaran) {
            return redirect()->to('/transaksi/pembayaran')->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Pembayaran',
            'pembayaran' => $pembayaran,
            'penyewaan' => $this->penyewaanModel->getWithRelations(),
            'validation' => \Config\Services::validation()
        ];
        return view('transaksi/pembayaran/form', $data);
    }

    public function update($id)
    {
        if (!$this->isAdmin()) {
            return $this->denyAccess();
        }

        $rules = [
            'tanggal_bayar' => 'required|valid_date',
            'metode'       => 'required|in_list[tunai,transfer]',
            'jumlah_bayar' => 'required|numeric',
            'status_bayar' => 'required|in_list[lunas,belum]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->pembayaranModel->update($id, [
            'tanggal_bayar' => $this->request->getPost('tanggal_bayar'),
            'metode'       => $this->request->getPost('metode'),
            'jumlah_bayar' => $this->request->getPost('jumlah_bayar'),
            'status_bayar' => $this->request->getPost('status_bayar'),
        ]);

        return redirect()->to('/transaksi/pembayaran')->with('success', 'Pembayaran berhasil diupdate');
    }

    public function delete($id)
    {
        if (!$this->isAdmin()) {
            return $this->denyAccess();
        }

        $pembayaran = $this->pembayaranModel->find($id);
        if (!$pembayaran) {
            return redirect()->to('/transaksi/pembayaran')->with('error', 'Data tidak ditemukan');
        }

        $this->pembayaranModel->delete($id);
        return redirect()->to('/transaksi/pembayaran')->with('success', 'Pembayaran berhasil dihapus');
    }
}
