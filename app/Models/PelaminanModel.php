<?php

namespace App\Models;

use CodeIgniter\Model;

class PelaminanModel extends Model
{
    protected $table            = 'pelaminan';
    protected $primaryKey       = 'id_pelaminan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama_pelaminan', 'jenis', 'ukuran', 'warna', 'harga_sewa', 'stok', 'status'];

    protected $validationRules = [
        'nama_pelaminan' => 'required|min_length[3]|max_length[100]',
        'jenis'          => 'required|max_length[50]',
        'ukuran'         => 'required|max_length[50]',
        'warna'          => 'required|max_length[50]',
        'harga_sewa'     => 'required|numeric',
        'stok'           => 'required|integer',
        'status'         => 'required|in_list[tersedia,disewa]',
    ];
}
