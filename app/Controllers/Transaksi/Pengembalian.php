<?php

namespace App\Controllers\Transaksi;

use App\Controllers\BaseController;
use App\Models\PengembalianModel;
use App\Models\PenyewaanModel;

class Pengembalian extends BaseController
{
    protected $pengembalianModel;
    protected $penyewaanModel;

    public function __construct()
    {
        $this->pengembalianModel = new PengembalianModel();
        $this->penyewaanModel = new PenyewaanModel();
    }

    public function index()
    {
        if ($this->isPelanggan()) {
            $pengembalian = $this->pengembalianModel->getByPelanggan($this->session->get('pelanggan_id'));
        } else {
            $pengembalian = $this->pengembalianModel->getWithRelations();
        }

        $data = [
            'title' => 'Data Pengembalian',
            'pengembalian' => $pengembalian
        ];
        return view('transaksi/pengembalian/index', $data);
    }

    public function create()
    {
        if (!$this->canInputTransaksi()) {
            return $this->denyAccess();
        }

        // Ambil penyewaan yang belum dikembalikan
        $penyewaan = $this->penyewaanModel
            ->where('status_sewa', 'berjalan')
            ->orWhere('status_sewa', 'booking')
            ->findAll();

        $data = [
            'title' => 'Proses Pengembalian',
            'penyewaan' => $this->penyewaanModel->getWithRelations(),
            'validation' => \Config\Services::validation()
        ];
        return view('transaksi/pengembalian/form', $data);
    }

    public function store()
    {
        if (!$this->canInputTransaksi()) {
            return $this->denyAccess();
        }

        $rules = [
            'id_sewa'         => 'required|numeric',
            'tanggal_kembali' => 'required|valid_date',
            'kondisi'         => 'required|in_list[baik,rusak]',
            'denda'           => 'permit_empty|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idSewa = $this->request->getPost('id_sewa');

        $this->pengembalianModel->insert([
            'id_sewa'         => $idSewa,
            'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
            'kondisi'         => $this->request->getPost('kondisi'),
            'denda'           => $this->request->getPost('denda') ?? 0,
        ]);

        // Update status penyewaan
        $this->penyewaanModel->update($idSewa, ['status_sewa' => 'selesai']);

        return redirect()->to('/transaksi/pengembalian')->with('success', 'Pengembalian berhasil diproses');
    }

    public function edit($id)
    {
        if (!$this->isAdmin()) {
            return $this->denyAccess();
        }

        $pengembalian = $this->pengembalianModel->find($id);
        if (!$pengembalian) {
            return redirect()->to('/transaksi/pengembalian')->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Pengembalian',
            'pengembalian' => $pengembalian,
            'penyewaan' => $this->penyewaanModel->getWithRelations(),
            'validation' => \Config\Services::validation()
        ];
        return view('transaksi/pengembalian/form', $data);
    }

    public function update($id)
    {
        if (!$this->isAdmin()) {
            return $this->denyAccess();
        }

        $rules = [
            'tanggal_kembali' => 'required|valid_date',
            'kondisi'         => 'required|in_list[baik,rusak]',
            'denda'           => 'permit_empty|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->pengembalianModel->update($id, [
            'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
            'kondisi'         => $this->request->getPost('kondisi'),
            'denda'           => $this->request->getPost('denda') ?? 0,
        ]);

        return redirect()->to('/transaksi/pengembalian')->with('success', 'Pengembalian berhasil diupdate');
    }

    public function delete($id)
    {
        if (!$this->isAdmin()) {
            return $this->denyAccess();
        }

        $pengembalian = $this->pengembalianModel->find($id);
        if (!$pengembalian) {
            return redirect()->to('/transaksi/pengembalian')->with('error', 'Data tidak ditemukan');
        }

        // Kembalikan status penyewaan
        $this->penyewaanModel->update($pengembalian['id_sewa'], ['status_sewa' => 'berjalan']);
        $this->pengembalianModel->delete($id);

        return redirect()->to('/transaksi/pengembalian')->with('success', 'Pengembalian berhasil dihapus');
    }
}
