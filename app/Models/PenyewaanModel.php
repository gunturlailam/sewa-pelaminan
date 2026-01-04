<?php

namespace App\Models;

use CodeIgniter\Model;

class PenyewaanModel extends Model
{
    protected $table            = 'penyewaan';
    protected $primaryKey       = 'id_sewa';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_pelanggan', 'tanggal_sewa', 'tanggal_kembali', 'total_bayar', 'status_sewa'];

    public function getWithRelations($id = null)
    {
        $builder = $this->select('penyewaan.*, pelanggan.nik, users.nama as nama_pelanggan, users.no_hp')
            ->join('pelanggan', 'pelanggan.id_pelanggan = penyewaan.id_pelanggan')
            ->join('users', 'users.id_user = pelanggan.id_user');

        if ($id) {
            return $builder->where('penyewaan.id_sewa', $id)->first();
        }
        return $builder->orderBy('penyewaan.id_sewa', 'DESC')->findAll();
    }

    public function getByPelanggan($idPelanggan)
    {
        return $this->select('penyewaan.*, pelanggan.nik, users.nama as nama_pelanggan')
            ->join('pelanggan', 'pelanggan.id_pelanggan = penyewaan.id_pelanggan')
            ->join('users', 'users.id_user = pelanggan.id_user')
            ->where('penyewaan.id_pelanggan', $idPelanggan)
            ->orderBy('penyewaan.id_sewa', 'DESC')
            ->findAll();
    }
}
