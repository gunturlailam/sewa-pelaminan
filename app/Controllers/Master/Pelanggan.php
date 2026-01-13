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
            'nama'     => [
                'rules'  => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required'   => 'Nama lengkap wajib diisi',
                    'min_length' => 'Nama minimal 3 karakter',
                    'max_length' => 'Nama maksimal 100 karakter'
                ]
            ],
            'username' => [
                'rules'  => 'required|min_length[3]|is_unique[users.username]',
                'errors' => [
                    'required'   => 'Username wajib diisi',
                    'min_length' => 'Username minimal 3 karakter',
                    'is_unique'  => 'Username sudah digunakan'
                ]
            ],
            'password' => [
                'rules'  => 'required|min_length[6]',
                'errors' => [
                    'required'   => 'Password wajib diisi',
                    'min_length' => 'Password minimal 6 karakter'
                ]
            ],
            'nik'      => [
                'rules'  => 'required|min_length[16]|max_length[20]|numeric',
                'errors' => [
                    'required'   => 'NIK wajib diisi',
                    'min_length' => 'NIK minimal 16 digit',
                    'max_length' => 'NIK maksimal 20 digit',
                    'numeric'    => 'NIK harus berupa angka'
                ]
            ],
            'email'    => [
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required'    => 'Email wajib diisi',
                    'valid_email' => 'Format email tidak valid'
                ]
            ],
            'no_hp'    => [
                'rules'  => 'required|min_length[10]|numeric',
                'errors' => [
                    'required'   => 'No HP wajib diisi',
                    'min_length' => 'No HP minimal 10 digit',
                    'numeric'    => 'No HP harus berupa angka'
                ]
            ],
            'alamat'   => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Alamat wajib diisi'
                ]
            ],
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
            ->where('pelanggan.id_pelanggan', $id)
            ->first();

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

        $pelanggan = $this->pelangganModel->where('id_pelanggan', $id)->first();
        if (!$pelanggan) {
            return redirect()->to('/master/pelanggan')->with('error', 'Data tidak ditemukan');
        }

        $rules = [
            'nama'   => [
                'rules'  => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required'   => 'Nama lengkap wajib diisi',
                    'min_length' => 'Nama minimal 3 karakter',
                    'max_length' => 'Nama maksimal 100 karakter'
                ]
            ],
            'nik'    => [
                'rules'  => 'required|min_length[16]|max_length[20]|numeric',
                'errors' => [
                    'required'   => 'NIK wajib diisi',
                    'min_length' => 'NIK minimal 16 digit',
                    'max_length' => 'NIK maksimal 20 digit',
                    'numeric'    => 'NIK harus berupa angka'
                ]
            ],
            'email'  => [
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required'    => 'Email wajib diisi',
                    'valid_email' => 'Format email tidak valid'
                ]
            ],
            'no_hp'  => [
                'rules'  => 'required|min_length[10]|numeric',
                'errors' => [
                    'required'   => 'No HP wajib diisi',
                    'min_length' => 'No HP minimal 10 digit',
                    'numeric'    => 'No HP harus berupa angka'
                ]
            ],
            'alamat' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Alamat wajib diisi'
                ]
            ],
        ];

        // Validasi password jika diisi (untuk edit)
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $rules['password'] = [
                'rules'  => 'min_length[6]',
                'errors' => [
                    'min_length' => 'Password minimal 6 karakter'
                ]
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Gunakan Query Builder langsung untuk update users
        $db = \Config\Database::connect();

        $db->table('users')
            ->where('id_user', $pelanggan['id_user'])
            ->update([
                'nama'   => $this->request->getPost('nama'),
                'no_hp'  => $this->request->getPost('no_hp'),
                'alamat' => $this->request->getPost('alamat'),
            ]);

        // Update password jika diisi
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $db->table('users')
                ->where('id_user', $pelanggan['id_user'])
                ->update([
                    'password' => password_hash($password, PASSWORD_DEFAULT)
                ]);
        }

        // Update tabel pelanggan
        $db->table('pelanggan')
            ->where('id_pelanggan', $id)
            ->update([
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

        $pelanggan = $this->pelangganModel->where('id_pelanggan', $id)->first();
        if (!$pelanggan) {
            return redirect()->to('/master/pelanggan')->with('error', 'Data tidak ditemukan');
        }

        // Cek apakah pelanggan punya transaksi
        $db = \Config\Database::connect();
        $transaksi = $db->table('penyewaan')->where('id_pelanggan', $id)->countAllResults();
        if ($transaksi > 0) {
            return redirect()->to('/master/pelanggan')->with('error', 'Pelanggan tidak dapat dihapus karena memiliki ' . $transaksi . ' transaksi');
        }

        $this->pelangganModel->where('id_pelanggan', $id)->delete();
        $this->userModel->where('id_user', $pelanggan['id_user'])->delete();

        return redirect()->to('/master/pelanggan')->with('success', 'Data pelanggan berhasil dihapus');
    }
}
