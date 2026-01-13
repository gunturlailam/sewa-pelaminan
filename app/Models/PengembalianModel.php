<?php

namespace App\Models;

use CodeIgniter\Model;

class PengembalianModel extends Model
{
    protected $table            = 'pengembalian';
    protected $primaryKey       = 'id_kembali';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_sewa', 'tanggal_kembali', 'kondisi', 'denda', 'keterangan', 'created_at'];

    public function getWithRelations($id = null)
    {
        $builder = $this->select('pengembalian.*, penyewaan.tanggal_sewa, penyewaan.tanggal_kembali as jadwal_kembali, penyewaan.total_bayar, users.nama as nama_pelanggan')
            ->join('penyewaan', 'penyewaan.id_sewa = pengembalian.id_sewa')
            ->join('pelanggan', 'pelanggan.id_pelanggan = penyewaan.id_pelanggan')
            ->join('users', 'users.id_user = pelanggan.id_user');

        if ($id) {
            return $builder->where('pengembalian.id_kembali', $id)->first();
        }
        return $builder->orderBy('pengembalian.id_kembali', 'DESC')->findAll();
    }

    public function getByPelanggan($idPelanggan)
    {
        return $this->select('pengembalian.*, penyewaan.tanggal_sewa, penyewaan.tanggal_kembali as jadwal_kembali')
            ->join('penyewaan', 'penyewaan.id_sewa = pengembalian.id_sewa')
            ->where('penyewaan.id_pelanggan', $idPelanggan)
            ->orderBy('pengembalian.id_kembali', 'DESC')
            ->findAll();
    }
}
