<?php

namespace App\Models;

use CodeIgniter\Model;

class PaketModel extends Model
{
    protected $table            = 'paket_pelaminan';
    protected $primaryKey       = 'id_paket';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama_paket', 'deskripsi', 'harga_paket', 'status'];

    protected $validationRules = [
        'nama_paket'  => 'required|min_length[3]|max_length[100]',
        'deskripsi'   => 'required',
        'harga_paket' => 'required|numeric',
        'status'      => 'required|in_list[aktif,nonaktif]',
    ];
}
