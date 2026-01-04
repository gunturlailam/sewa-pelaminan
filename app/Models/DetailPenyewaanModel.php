<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPenyewaanModel extends Model
{
    protected $table            = 'detail_penyewaan';
    protected $primaryKey       = 'id_detail_sewa';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_sewa', 'id_pelaminan', 'jumlah', 'subtotal'];

    public function getByPenyewaan($idSewa)
    {
        return $this->select('detail_penyewaan.*, pelaminan.nama_pelaminan, pelaminan.harga_sewa')
            ->join('pelaminan', 'pelaminan.id_pelaminan = detail_penyewaan.id_pelaminan')
            ->where('detail_penyewaan.id_sewa', $idSewa)
            ->findAll();
    }
}
