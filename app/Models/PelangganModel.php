<?php

namespace App\Models;

use CodeIgniter\Model;

class PelangganModel extends Model
{
    protected $table            = 'pelanggan';
    protected $primaryKey       = 'id_pelanggan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_user', 'nik', 'email', 'tanggal_daftar'];

    protected $validationRules = [
        'nik'   => 'required|min_length[16]|max_length[20]',
        'email' => 'required|valid_email|max_length[100]',
    ];

    public function getWithUser()
    {
        return $this->select('pelanggan.*, users.nama, users.no_hp, users.alamat, users.status')
            ->join('users', 'users.id_user = pelanggan.id_user')
            ->findAll();
    }
}
