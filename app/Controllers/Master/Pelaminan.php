<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Models\PelaminanModel;
use App\Models\KategoriModel;

class Pelaminan extends BaseController
{
    protected $pelaminanModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->pelaminanModel = new PelaminanModel();
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'Data Pelaminan',
            'pelaminan' => $this->pelaminanModel->getWithKategori()
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
            'kategori'   => $this->kategoriModel->getAktif(),
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
            'id_kategori'    => 'permit_empty|numeric',
            'nama_pelaminan' => 'required|min_length[3]|max_length[100]',
            'jenis'          => 'required|max_length[50]',
            'ukuran'         => 'required|max_length[50]',
            'warna'          => 'required|max_length[50]',
            'harga_sewa'     => 'required|numeric|greater_than[0]',
            'stok'           => 'required|integer|greater_than_equal_to[0]',
            'status'         => 'required|in_list[tersedia,disewa]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->pelaminanModel->insert([
            'id_kategori'    => $this->request->getPost('id_kategori') ?: null,
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
            'kategori'   => $this->kategoriModel->getAktif(),
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
            'id_kategori'    => 'permit_empty|numeric',
            'nama_pelaminan' => 'required|min_length[3]|max_length[100]',
            'jenis'          => 'required|max_length[50]',
            'ukuran'         => 'required|max_length[50]',
            'warna'          => 'required|max_length[50]',
            'harga_sewa'     => 'required|numeric|greater_than[0]',
            'stok'           => 'required|integer|greater_than_equal_to[0]',
            'status'         => 'required|in_list[tersedia,disewa]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->pelaminanModel->update($id, [
            'id_kategori'    => $this->request->getPost('id_kategori') ?: null,
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

        // Cek apakah pelaminan sedang disewa
        $db = \Config\Database::connect();
        $used = $db->table('detail_penyewaan dp')
            ->join('penyewaan p', 'p.id_sewa = dp.id_sewa')
            ->where('dp.id_pelaminan', $id)
            ->whereNotIn('p.status_sewa', ['selesai', 'batal'])
            ->countAllResults();

        if ($used > 0) {
            return redirect()->to('/master/pelaminan')->with('error', 'Pelaminan tidak dapat dihapus karena sedang dalam proses penyewaan');
        }

        $this->pelaminanModel->delete($id);
        return redirect()->to('/master/pelaminan')->with('success', 'Data pelaminan berhasil dihapus');
    }
}
