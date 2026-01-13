<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'nama',
        'username',
        'password',
        'role',
        'foto',
        'no_hp',
        'alamat',
        'status'
    ];

    // Dates
    protected $useTimestamps = false;

    // Validation
    protected $validationRules = [
        'nama'     => 'required|min_length[3]|max_length[100]',
        'username' => 'required|min_length[3]|max_length[50]',
        'role'     => 'required|in_list[admin,petugas,pelanggan]',
        'no_hp'    => 'permit_empty|min_length[10]|max_length[15]',
        'alamat'   => 'permit_empty',
    ];

    protected $validationMessages = [
        'username' => [
            'is_unique' => 'Username sudah digunakan'
        ]
    ];

    protected $skipValidation = true; // Skip validation by default, validate manually in controller
}
