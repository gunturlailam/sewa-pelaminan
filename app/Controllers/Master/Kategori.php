<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Models\KategoriModel;

class Kategori extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Kategori',
            'kategori' => $this->kategoriModel->getWithCount()
        ];
        return view('master/kategori/index', $data);
    }

    public function create()
    {
        if (!$this->canManageMaster()) {
            return $this->denyAccess();
        }

        $data = [
            'title' => 'Tambah Kategori',
            'validation' => \Config\Services::validation()
        ];
        return view('master/kategori/form', $data);
    }

    public function store()
    {
        if (!$this->canManageMaster()) {
            return $this->denyAccess();
        }

        $rules = [
            'nama_kategori' => [
                'rules' => 'required|min_length[3]|max_length[100]|is_unique[kategori.nama_kategori]',
                'errors' => [
                    'required' => 'Nama kategori wajib diisi',
                    'min_length' => 'Nama kategori minimal 3 karakter',
                    'max_length' => 'Nama kategori maksimal 100 karakter',
                    'is_unique' => 'Nama kategori sudah ada'
                ]
            ],
            'deskripsi' => [
                'rules' => 'permit_empty|max_length[500]',
                'errors' => [
                    'max_length' => 'Deskripsi maksimal 500 karakter'
                ]
            ],
            'status' => [
                'rules' => 'required|in_list[aktif,nonaktif]',
                'errors' => [
                    'required' => 'Status wajib dipilih',
                    'in_list' => 'Status tidak valid'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->kategoriModel->insert([
            'nama_kategori' => $this->request->getPost('nama_kategori'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
            'status'        => $this->request->getPost('status'),
        ]);

        return redirect()->to('/master/kategori')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        if (!$this->canManageMaster()) {
            return $this->denyAccess();
        }

        $kategori = $this->kategoriModel->find($id);
        if (!$kategori) {
            return redirect()->to('/master/kategori')->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Kategori',
            'kategori' => $kategori,
            'validation' => \Config\Services::validation()
        ];
        return view('master/kategori/form', $data);
    }

    public function update($id)
    {
        if (!$this->canManageMaster()) {
            return $this->denyAccess();
        }

        $kategori = $this->kategoriModel->find($id);
        if (!$kategori) {
            return redirect()->to('/master/kategori')->with('error', 'Data tidak ditemukan');
        }

        $rules = [
            'nama_kategori' => [
                'rules' => "required|min_length[3]|max_length[100]|is_unique[kategori.nama_kategori,id_kategori,{$id}]",
                'errors' => [
                    'required' => 'Nama kategori wajib diisi',
                    'min_length' => 'Nama kategori minimal 3 karakter',
                    'max_length' => 'Nama kategori maksimal 100 karakter',
                    'is_unique' => 'Nama kategori sudah ada'
                ]
            ],
            'deskripsi' => [
                'rules' => 'permit_empty|max_length[500]',
                'errors' => [
                    'max_length' => 'Deskripsi maksimal 500 karakter'
                ]
            ],
            'status' => [
                'rules' => 'required|in_list[aktif,nonaktif]',
                'errors' => [
                    'required' => 'Status wajib dipilih',
                    'in_list' => 'Status tidak valid'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->kategoriModel->update($id, [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
            'status'        => $this->request->getPost('status'),
        ]);

        return redirect()->to('/master/kategori')->with('success', 'Kategori berhasil diupdate');
    }

    public function delete($id)
    {
        if (!$this->canManageMaster()) {
            return $this->denyAccess();
        }

        $kategori = $this->kategoriModel->find($id);
        if (!$kategori) {
            return redirect()->to('/master/kategori')->with('error', 'Data tidak ditemukan');
        }

        // Cek apakah kategori masih digunakan
        $db = \Config\Database::connect();
        $used = $db->table('pelaminan')->where('id_kategori', $id)->countAllResults();
        if ($used > 0) {
            return redirect()->to('/master/kategori')->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh ' . $used . ' pelaminan');
        }

        $this->kategoriModel->delete($id);
        return redirect()->to('/master/kategori')->with('success', 'Kategori berhasil dihapus');
    }
}
