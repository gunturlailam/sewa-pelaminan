<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table            = 'pembayaran';
    protected $primaryKey       = 'id_bayar';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_sewa', 'tanggal_bayar', 'metode', 'jumlah_bayar', 'status_bayar'];

    public function getWithRelations($id = null)
    {
        $builder = $this->select('pembayaran.*, penyewaan.tanggal_sewa, penyewaan.total_bayar, users.nama as nama_pelanggan')
            ->join('penyewaan', 'penyewaan.id_sewa = pembayaran.id_sewa')
            ->join('pelanggan', 'pelanggan.id_pelanggan = penyewaan.id_pelanggan')
            ->join('users', 'users.id_user = pelanggan.id_user');

        if ($id) {
            return $builder->where('pembayaran.id_bayar', $id)->first();
        }
        return $builder->orderBy('pembayaran.id_bayar', 'DESC')->findAll();
    }

    public function getByPelanggan($idPelanggan)
    {
        return $this->select('pembayaran.*, penyewaan.tanggal_sewa, penyewaan.total_bayar')
            ->join('penyewaan', 'penyewaan.id_sewa = pembayaran.id_sewa')
            ->where('penyewaan.id_pelanggan', $idPelanggan)
            ->orderBy('pembayaran.id_bayar', 'DESC')
            ->findAll();
    }

    public function getTotalBayar($idSewa)
    {
        return $this->selectSum('jumlah_bayar')
            ->where('id_sewa', $idSewa)
            ->first()['jumlah_bayar'] ?? 0;
    }
}
