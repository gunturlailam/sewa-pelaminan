<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Jika sudah login, redirect ke dashboard
        if ($this->session->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    public function login()
    {
        // Jika sudah login, redirect ke dashboard
        if ($this->session->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        // Jika GET request, tampilkan form
        if ($this->request->getMethod() === 'GET') {
            return view('auth/login');
        }

        // Validasi input
        $rules = [
            'username' => 'required|min_length[3]',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Username dan password harus diisi dengan benar');
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Cari user berdasarkan username
        $user = $this->userModel->where('username', $username)->first();

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Username tidak ditemukan');
        }

        // Cek status user
        if ($user['status'] !== 'aktif') {
            return redirect()->back()->withInput()->with('error', 'Akun Anda tidak aktif. Hubungi administrator');
        }

        // Verifikasi password
        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Password salah');
        }

        // Set session
        $sessionData = [
            'user_id'     => $user['id_user'],
            'username'    => $user['username'],
            'nama'        => $user['nama'],
            'role'        => $user['role'],
            'foto'        => $user['foto'],
            'isLoggedIn'  => true
        ];

        $this->session->set($sessionData);

        return redirect()->to('/dashboard')->with('success', 'Selamat datang, ' . $user['nama']);
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/auth/login')->with('success', 'Anda telah berhasil logout');
    }

    public function register()
    {
        return view('auth/register');
    }
}
