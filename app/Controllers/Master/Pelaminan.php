<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Models\PelaminanModel;

class Pelaminan extends BaseController
{
    protected $pelaminanModel;

    public function __construct()
    {
        $this->pelaminanModel = new PelaminanModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'Data Pelaminan',
            'pelaminan' => $this->pelaminanModel->findAll()
        ];
        return view('master/pelaminan/index', $data);
    }

    public function create()
    {
        if (!$this->canManageMaster()) {
            return $this->denyAccess();
        }

        $data = [
            'title'      => 'Tambah Pelaminan',
            'validation' => \Config\Services::validation()
        ];
        return view('master/pelaminan/form', $data);
    }

    public function store()
    {
        if (!$this->canManageMaster()) {
            return $this->denyAccess();
        }

        $rules = [
            'nama_pelaminan' => 'required|min_length[3]|max_length[100]',
            'jenis'          => 'required|max_length[50]',
            'ukuran'         => 'required|max_length[50]',
            'warna'          => 'required|max_length[50]',
            'harga_sewa'     => 'required|numeric',
            'stok'           => 'required|integer',
            'status'         => 'required|in_list[tersedia,disewa]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->pelaminanModel->insert([
            'nama_pelaminan' => $this->request->getPost('nama_pelaminan'),
            'jenis'          => $this->request->getPost('jenis'),
            'ukuran'         => $this->request->getPost('ukuran'),
            'warna'          => $this->request->getPost('warna'),
            'harga_sewa'     => $this->request->getPost('harga_sewa'),
            'stok'           => $this->request->getPost('stok'),
            'status'         => $this->request->getPost('status'),
        ]);

        return redirect()->to('/master/pelaminan')->with('success', 'Data pelaminan berhasil ditambahkan');
    }

    public function edit($id)
    {
        if (!$this->canManageMaster()) {
            return $this->denyAccess();
        }

        $pelaminan = $this->pelaminanModel->find($id);
        if (!$pelaminan) {
            return redirect()->to('/master/pelaminan')->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title'      => 'Edit Pelaminan',
            'pelaminan'  => $pelaminan,
            'validation' => \Config\Services::validation()
        ];
        return view('master/pelaminan/form', $data);
    }

    public function update($id)
    {
        if (!$this->canManageMaster()) {
            return $this->denyAccess();
        }

        $rules = [
            'nama_pelaminan' => 'required|min_length[3]|max_length[100]',
            'jenis'          => 'required|max_length[50]',
            'ukuran'         => 'required|max_length[50]',
            'warna'          => 'required|max_length[50]',
            'harga_sewa'     => 'required|numeric',
            'stok'           => 'required|integer',
            'status'         => 'required|in_list[tersedia,disewa]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->pelaminanModel->update($id, [
            'nama_pelaminan' => $this->request->getPost('nama_pelaminan'),
            'jenis'          => $this->request->getPost('jenis'),
            'ukuran'         => $this->request->getPost('ukuran'),
            'warna'          => $this->request->getPost('warna'),
            'harga_sewa'     => $this->request->getPost('harga_sewa'),
            'stok'           => $this->request->getPost('stok'),
            'status'         => $this->request->getPost('status'),
        ]);

        return redirect()->to('/master/pelaminan')->with('success', 'Data pelaminan berhasil diupdate');
    }

    public function delete($id)
    {
        if (!$this->canManageMaster()) {
            return $this->denyAccess();
        }

        $pelaminan = $this->pelaminanModel->find($id);
        if (!$pelaminan) {
            return redirect()->to('/master/pelaminan')->with('error', 'Data tidak ditemukan');
        }

        $this->pelaminanModel->delete($id);
        return redirect()->to('/master/pelaminan')->with('success', 'Data pelaminan berhasil dihapus');
    }
}
