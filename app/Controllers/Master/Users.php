<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if (!$this->canManageUsers()) {
            return $this->denyAccess();
        }

        $data = [
            'title' => 'Data Users',
            'users' => $this->userModel->where('role !=', 'pelanggan')->findAll()
        ];
        return view('master/users/index', $data);
    }

    public function create()
    {
        if (!$this->canManageUsers()) {
            return $this->denyAccess();
        }

        $data = [
            'title'      => 'Tambah User',
            'validation' => \Config\Services::validation()
        ];
        return view('master/users/form', $data);
    }

    public function store()
    {
        if (!$this->canManageUsers()) {
            return $this->denyAccess();
        }

        $rules = [
            'nama'     => 'required|min_length[3]|max_length[100]',
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'password' => 'required|min_length[6]',
            'role'     => 'required|in_list[admin,petugas]',
            'no_hp'    => 'required|min_length[10]',
            'alamat'   => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->insert([
            'nama'     => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'),
            'foto'     => 'default.png',
            'no_hp'    => $this->request->getPost('no_hp'),
            'alamat'   => $this->request->getPost('alamat'),
            'status'   => 'aktif'
        ]);

        return redirect()->to('/master/users')->with('success', 'Data user berhasil ditambahkan');
    }

    public function edit($id)
    {
        if (!$this->canManageUsers()) {
            return $this->denyAccess();
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/master/users')->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title'      => 'Edit User',
            'user'       => $user,
            'validation' => \Config\Services::validation()
        ];
        return view('master/users/form', $data);
    }

    public function update($id)
    {
        if (!$this->canManageUsers()) {
            return $this->denyAccess();
        }

        $rules = [
            'nama'   => 'required|min_length[3]|max_length[100]',
            'role'   => 'required|in_list[admin,petugas]',
            'no_hp'  => 'required|min_length[10]',
            'alamat' => 'required',
            'status' => 'required|in_list[aktif,nonaktif]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama'   => $this->request->getPost('nama'),
            'role'   => $this->request->getPost('role'),
            'no_hp'  => $this->request->getPost('no_hp'),
            'alamat' => $this->request->getPost('alamat'),
            'status' => $this->request->getPost('status'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);
        return redirect()->to('/master/users')->with('success', 'Data user berhasil diupdate');
    }

    public function delete($id)
    {
        if (!$this->canManageUsers()) {
            return $this->denyAccess();
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/master/users')->with('error', 'Data tidak ditemukan');
        }

        if ($user['id_user'] == $this->getUserId()) {
            return redirect()->to('/master/users')->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $this->userModel->delete($id);
        return redirect()->to('/master/users')->with('success', 'Data user berhasil dihapus');
    }
}
