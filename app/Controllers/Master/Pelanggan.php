<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Models\PelangganModel;
use App\Models\UserModel;

class Pelanggan extends BaseController
{
    protected $pelangganModel;
    protected $userModel;

    public function __construct()
    {
        $this->pelangganModel = new PelangganModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'Data Pelanggan',
            'pelanggan' => $this->pelangganModel->getWithUser()
        ];
        return view('master/pelanggan/index', $data);
    }

    public function create()
    {
        if (!$this->canManageMaster()) {
            return $this->denyAccess();
        }

        $data = [
            'title'      => 'Tambah Pelanggan',
            'validation' => \Config\Services::validation()
        ];
        return view('master/pelanggan/form', $data);
    }

    public function store()
    {
        if (!$this->canManageMaster()) {
            return $this->denyAccess();
        }

        $rules = [
            'nama'     => 'required|min_length[3]|max_length[100]',
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'password' => 'required|min_length[6]',
            'nik'      => 'required|min_length[16]|max_length[20]',
            'email'    => 'required|valid_email',
            'no_hp'    => 'required|min_length[10]',
            'alamat'   => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Insert ke tabel users dulu
        $userId = $this->userModel->insert([
            'nama'     => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'pelanggan',
            'foto'     => 'default.png',
            'no_hp'    => $this->request->getPost('no_hp'),
            'alamat'   => $this->request->getPost('alamat'),
            'status'   => 'aktif'
        ]);

        // Insert ke tabel pelanggan
        $this->pelangganModel->insert([
            'id_user'       => $userId,
            'nik'           => $this->request->getPost('nik'),
            'email'         => $this->request->getPost('email'),
            'tanggal_daftar' => date('Y-m-d')
        ]);

        return redirect()->to('/master/pelanggan')->with('success', 'Data pelanggan berhasil ditambahkan');
    }

    public function edit($id)
    {
        if (!$this->canManageMaster()) {
            return $this->denyAccess();
        }

        $pelanggan = $this->pelangganModel->select('pelanggan.*, users.nama, users.username, users.no_hp, users.alamat')
            ->join('users', 'users.id_user = pelanggan.id_user')
            ->find($id);
        if (!$pelanggan) {
            return redirect()->to('/master/pelanggan')->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title'      => 'Edit Pelanggan',
            'pelanggan'  => $pelanggan,
            'validation' => \Config\Services::validation()
        ];
        return view('master/pelanggan/form', $data);
    }

    public function update($id)
    {
        if (!$this->canManageMaster()) {
            return $this->denyAccess();
        }

        $pelanggan = $this->pelangganModel->find($id);
        if (!$pelanggan) {
            return redirect()->to('/master/pelanggan')->with('error', 'Data tidak ditemukan');
        }

        $rules = [
            'nama'   => 'required|min_length[3]|max_length[100]',
            'nik'    => 'required|min_length[16]|max_length[20]',
            'email'  => 'required|valid_email',
            'no_hp'  => 'required|min_length[10]',
            'alamat' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update tabel users
        $this->userModel->update($pelanggan['id_user'], [
            'nama'   => $this->request->getPost('nama'),
            'no_hp'  => $this->request->getPost('no_hp'),
            'alamat' => $this->request->getPost('alamat'),
        ]);

        // Update password jika diisi
        if ($this->request->getPost('password')) {
            $this->userModel->update($pelanggan['id_user'], [
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
            ]);
        }

        // Update tabel pelanggan
        $this->pelangganModel->update($id, [
            'nik'   => $this->request->getPost('nik'),
            'email' => $this->request->getPost('email'),
        ]);

        return redirect()->to('/master/pelanggan')->with('success', 'Data pelanggan berhasil diupdate');
    }

    public function delete($id)
    {
        if (!$this->canManageMaster()) {
            return $this->denyAccess();
        }

        $pelanggan = $this->pelangganModel->find($id);
        if (!$pelanggan) {
            return redirect()->to('/master/pelanggan')->with('error', 'Data tidak ditemukan');
        }

        $this->pelangganModel->delete($id);
        $this->userModel->delete($pelanggan['id_user']);

        return redirect()->to('/master/pelanggan')->with('success', 'Data pelanggan berhasil dihapus');
    }
}
