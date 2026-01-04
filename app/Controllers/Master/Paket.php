<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Models\PaketModel;

class Paket extends BaseController
{
    protected $paketModel;

    public function __construct()
    {
        $this->paketModel = new PaketModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Paket Pelaminan',
            'paket' => $this->paketModel->findAll()
        ];
        return view('master/paket/index', $data);
    }

    public function create()
    {
        if (!$this->canManageMaster()) {
            return $this->denyAccess();
        }

        $data = [
            'title'      => 'Tambah Paket',
            'validation' => \Config\Services::validation()
        ];
        return view('master/paket/form', $data);
    }

    public function store()
    {
        if (!$this->canManageMaster()) {
            return $this->denyAccess();
        }

        $rules = [
            'nama_paket'  => 'required|min_length[3]|max_length[100]',
            'deskripsi'   => 'required',
            'harga_paket' => 'required|numeric',
            'status'      => 'required|in_list[aktif,nonaktif]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->paketModel->insert([
            'nama_paket'  => $this->request->getPost('nama_paket'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'harga_paket' => $this->request->getPost('harga_paket'),
            'status'      => $this->request->getPost('status'),
        ]);

        return redirect()->to('/master/paket')->with('success', 'Data paket berhasil ditambahkan');
    }

    public function edit($id)
    {
        if (!$this->canManageMaster()) {
            return $this->denyAccess();
        }

        $paket = $this->paketModel->find($id);
        if (!$paket) {
            return redirect()->to('/master/paket')->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title'      => 'Edit Paket',
            'paket'      => $paket,
            'validation' => \Config\Services::validation()
        ];
        return view('master/paket/form', $data);
    }

    public function update($id)
    {
        if (!$this->canManageMaster()) {
            return $this->denyAccess();
        }

        $rules = [
            'nama_paket'  => 'required|min_length[3]|max_length[100]',
            'deskripsi'   => 'required',
            'harga_paket' => 'required|numeric',
            'status'      => 'required|in_list[aktif,nonaktif]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->paketModel->update($id, [
            'nama_paket'  => $this->request->getPost('nama_paket'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'harga_paket' => $this->request->getPost('harga_paket'),
            'status'      => $this->request->getPost('status'),
        ]);

        return redirect()->to('/master/paket')->with('success', 'Data paket berhasil diupdate');
    }

    public function delete($id)
    {
        if (!$this->canManageMaster()) {
            return $this->denyAccess();
        }

        $paket = $this->paketModel->find($id);
        if (!$paket) {
            return redirect()->to('/master/paket')->with('error', 'Data tidak ditemukan');
        }

        $this->paketModel->delete($id);
        return redirect()->to('/master/paket')->with('success', 'Data paket berhasil dihapus');
    }
}
