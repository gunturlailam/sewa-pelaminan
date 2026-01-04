<?php

namespace App\Validation;

use Config\Database;

class PenyewaanRules
{
    /**
     * Cek apakah pelanggan_id ada di database
     */
    public function pelanggan_exists(string $str, string $fields, array $data): bool
    {
        $db = Database::connect();
        $result = $db->table('pelanggan')
            ->where('id_pelanggan', $str)
            ->countAllResults();
        return $result > 0;
    }

    /**
     * Cek apakah user (petugas) aktif
     */
    public function user_aktif(string $str, string $fields, array $data): bool
    {
        $db = Database::connect();
        $result = $db->table('users')
            ->where('id_user', $str)
            ->where('status', 'aktif')
            ->countAllResults();
        return $result > 0;
    }

    /**
     * Cek apakah pelaminan tersedia (tidak sedang disewa pada tanggal tersebut)
     * Format: pelaminan_tersedia[tanggal_sewa,tanggal_kembali]
     */
    public function pelaminan_tersedia(string $str, string $fields, array $data): bool
    {
        if (empty($str)) return true;

        $params = explode(',', $fields);
        $tanggalSewa = $data[$params[0]] ?? null;
        $tanggalKembali = $data[$params[1]] ?? null;
        $idSewaEdit = $params[2] ?? null; // untuk edit, exclude id_sewa ini

        if (!$tanggalSewa || !$tanggalKembali) return true;

        $db = Database::connect();

        // Cek apakah pelaminan ini sudah ada di penyewaan lain yang bentrok tanggalnya
        // dan belum dikembalikan (tidak ada di tabel pengembalian atau status belum selesai)
        $builder = $db->table('detail_penyewaan dp')
            ->select('dp.id_sewa')
            ->join('penyewaan p', 'p.id_sewa = dp.id_sewa')
            ->where('dp.id_pelaminan', $str)
            ->where('p.status_sewa !=', 'batal')
            ->where('p.status_sewa !=', 'selesai')
            ->groupStart()
            // Cek overlapping: tanggal sewa baru berada dalam rentang sewa yang ada
            ->groupStart()
            ->where('p.tanggal_sewa <=', $tanggalKembali)
            ->where('p.tanggal_kembali >=', $tanggalSewa)
            ->groupEnd()
            ->groupEnd();

        // Jika edit, exclude id_sewa yang sedang diedit
        if ($idSewaEdit) {
            $builder->where('p.id_sewa !=', $idSewaEdit);
        }

        $result = $builder->countAllResults();

        return $result === 0;
    }

    /**
     * Validasi tanggal tidak boleh kemarin (harus >= hari ini)
     */
    public function tanggal_tidak_kemarin(string $str, string $fields, array $data): bool
    {
        $inputDate = strtotime($str);
        $today = strtotime(date('Y-m-d'));
        return $inputDate >= $today;
    }

    /**
     * Validasi tanggal kembali harus setelah atau sama dengan tanggal sewa
     * Format: tanggal_setelah[field_tanggal_sewa]
     */
    public function tanggal_setelah(string $str, string $fields, array $data): bool
    {
        $tanggalSewa = $data[$fields] ?? null;
        if (!$tanggalSewa) return true;

        return strtotime($str) >= strtotime($tanggalSewa);
    }

    /**
     * Validasi durasi maksimal (dalam hari)
     * Format: durasi_maksimal[field_tanggal_sewa,max_hari]
     */
    public function durasi_maksimal(string $str, string $fields, array $data): bool
    {
        $params = explode(',', $fields);
        $tanggalSewa = $data[$params[0]] ?? null;
        $maxHari = (int)($params[1] ?? 7);

        if (!$tanggalSewa) return true;

        $diff = (strtotime($str) - strtotime($tanggalSewa)) / (60 * 60 * 24);
        return $diff <= $maxHari;
    }

    /**
     * Validasi DP minimal (persentase dari total)
     * Format: dp_minimal[field_total,persentase]
     */
    public function dp_minimal(string $str, string $fields, array $data): bool
    {
        $params = explode(',', $fields);
        $total = (float)($data[$params[0]] ?? 0);
        $persentase = (float)($params[1] ?? 30);

        if ($total <= 0) return true;

        $minDp = ($persentase / 100) * $total;
        return (float)$str >= $minDp;
    }

    /**
     * Validasi jumlah bayar tidak lebih dari total
     * Format: tidak_lebih_dari[field_total]
     */
    public function tidak_lebih_dari(string $str, string $fields, array $data): bool
    {
        $total = (float)($data[$fields] ?? 0);
        return (float)$str <= $total;
    }
}
