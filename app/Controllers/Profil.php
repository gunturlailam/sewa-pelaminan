<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profil extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('dashboard')->with('error', 'User tidak ditemukan');
        }

        $data = [
            'title' => 'Profil Saya',
            'user' => $user,
            'validation' => \Config\Services::validation()
        ];

        return view('profil', $data);
    }

    public function update()
    {
        $userId = session()->get('user_id');

        // Validation rules
        $rules = [
            'nama' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Nama wajib diisi',
                    'min_length' => 'Nama minimal 3 karakter',
                    'max_length' => 'Nama maksimal 100 karakter'
                ]
            ],
            'username' => [
                'rules' => "required|min_length[3]|max_length[50]|is_unique[users.username,id_user,{$userId}]",
                'errors' => [
                    'required' => 'Username wajib diisi',
                    'min_length' => 'Username minimal 3 karakter',
                    'max_length' => 'Username maksimal 50 karakter',
                    'is_unique' => 'Username sudah digunakan'
                ]
            ]
        ];

        // Add password validation if password field is filled
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $rules['password'] = [
                'rules' => 'min_length[8]',
                'errors' => [
                    'min_length' => 'Password minimal 8 karakter'
                ]
            ];
            $rules['password_confirm'] = [
                'rules' => 'matches[password]',
                'errors' => [
                    'matches' => 'Konfirmasi password tidak cocok'
                ]
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Prepare update data
        $updateData = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username')
        ];

        // Update password if provided
        if (!empty($password)) {
            $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Update user
        $this->userModel->update($userId, $updateData);

        // Update session nama
        session()->set('nama', $updateData['nama']);

        return redirect()->to('profil')->with('success', 'Profil berhasil diperbarui');
    }
}
