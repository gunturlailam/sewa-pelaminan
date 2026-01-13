<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table            = 'kategori';
    protected $primaryKey       = 'id_kategori';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama_kategori', 'deskripsi', 'status'];

    protected $validationRules = [
        'nama_kategori' => 'required|min_length[3]|max_length[100]',
        'deskripsi'     => 'permit_empty|max_length[500]',
        'status'        => 'required|in_list[aktif,nonaktif]',
    ];

    protected $validationMessages = [
        'nama_kategori' => [
            'required'   => 'Nama kategori wajib diisi',
            'min_length' => 'Nama kategori minimal 3 karakter',
            'max_length' => 'Nama kategori maksimal 100 karakter',
        ],
    ];

    /**
     * Ambil kategori aktif saja
     */
    public function getAktif()
    {
        return $this->where('status', 'aktif')->orderBy('nama_kategori', 'ASC')->findAll();
    }

    /**
     * Hitung jumlah pelaminan per kategori
     */
    public function getWithCount()
    {
        // Cek apakah tabel pelaminan punya kolom id_kategori
        $db = \Config\Database::connect();
        $fields = $db->getFieldNames('pelaminan');

        if (in_array('id_kategori', $fields)) {
            return $this->select('kategori.*, COUNT(pelaminan.id_pelaminan) as jumlah_pelaminan')
                ->join('pelaminan', 'pelaminan.id_kategori = kategori.id_kategori', 'left')
                ->groupBy('kategori.id_kategori')
                ->orderBy('kategori.nama_kategori', 'ASC')
                ->findAll();
        }

        // Fallback jika kolom belum ada
        return $this->select('kategori.*, 0 as jumlah_pelaminan')
            ->orderBy('kategori.nama_kategori', 'ASC')
            ->findAll();
    }
}
