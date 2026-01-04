<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    public function run()
    {
        // Data Penyewaan - tersebar di beberapa bulan untuk testing filter
        $penyewaan = [
            // Januari 2025 - Selesai
            [
                'id_pelanggan'    => 1,
                'tanggal_sewa'    => '2025-01-20',
                'tanggal_kembali' => '2025-01-21',
                'total_bayar'     => 8500000,
                'status_sewa'     => 'selesai'
            ],
            // Februari 2025 - Selesai
            [
                'id_pelanggan'    => 2,
                'tanggal_sewa'    => '2025-02-14',
                'tanggal_kembali' => '2025-02-15',
                'total_bayar'     => 12000000,
                'status_sewa'     => 'selesai'
            ],
            // Maret 2025 - Selesai
            [
                'id_pelanggan'    => 3,
                'tanggal_sewa'    => '2025-03-25',
                'tanggal_kembali' => '2025-03-26',
                'total_bayar'     => 6500000,
                'status_sewa'     => 'selesai'
            ],
            // April 2025 - Selesai
            [
                'id_pelanggan'    => 4,
                'tanggal_sewa'    => '2025-04-10',
                'tanggal_kembali' => '2025-04-11',
                'total_bayar'     => 15500000,
                'status_sewa'     => 'selesai'
            ],
            // Mei 2025 - Selesai
            [
                'id_pelanggan'    => 5,
                'tanggal_sewa'    => '2025-05-18',
                'tanggal_kembali' => '2025-05-19',
                'total_bayar'     => 9000000,
                'status_sewa'     => 'selesai'
            ],
            // Juni 2025 - Berjalan (belum lunas)
            [
                'id_pelanggan'    => 1,
                'tanggal_sewa'    => '2025-06-22',
                'tanggal_kembali' => '2025-06-23',
                'total_bayar'     => 11000000,
                'status_sewa'     => 'berjalan'
            ],
            // Juli 2025 - Berjalan
            [
                'id_pelanggan'    => 2,
                'tanggal_sewa'    => '2025-07-15',
                'tanggal_kembali' => '2025-07-16',
                'total_bayar'     => 7500000,
                'status_sewa'     => 'berjalan'
            ],
            // Agustus 2025 - Booking
            [
                'id_pelanggan'    => 3,
                'tanggal_sewa'    => '2025-08-20',
                'tanggal_kembali' => '2025-08-21',
                'total_bayar'     => 20000000,
                'status_sewa'     => 'booking'
            ],
            // September 2025 - Booking
            [
                'id_pelanggan'    => 4,
                'tanggal_sewa'    => '2025-09-12',
                'tanggal_kembali' => '2025-09-13',
                'total_bayar'     => 13500000,
                'status_sewa'     => 'booking'
            ],
            // Oktober 2025 - Batal
            [
                'id_pelanggan'    => 5,
                'tanggal_sewa'    => '2025-10-05',
                'tanggal_kembali' => '2025-10-06',
                'total_bayar'     => 5000000,
                'status_sewa'     => 'batal'
            ],
        ];

        $this->db->table('penyewaan')->insertBatch($penyewaan);
        echo "✅ Penyewaan: " . count($penyewaan) . " transaksi berhasil ditambahkan\n";

        // Detail Penyewaan
        $detailPenyewaan = [
            // Sewa 1 - Pelaminan Jawa + Kursi
            ['id_sewa' => 1, 'id_pelaminan' => 1, 'jumlah' => 1, 'subtotal' => 3500000],
            ['id_sewa' => 1, 'id_pelaminan' => 10, 'jumlah' => 1, 'subtotal' => 1500000],
            ['id_sewa' => 1, 'id_pelaminan' => 9, 'jumlah' => 1, 'subtotal' => 2500000],

            // Sewa 2 - Pelaminan Modern + Backdrop
            ['id_sewa' => 2, 'id_pelaminan' => 3, 'jumlah' => 1, 'subtotal' => 5000000],
            ['id_sewa' => 2, 'id_pelaminan' => 5, 'jumlah' => 1, 'subtotal' => 7500000],

            // Sewa 3 - Pelaminan Minang
            ['id_sewa' => 3, 'id_pelaminan' => 2, 'jumlah' => 1, 'subtotal' => 4000000],
            ['id_sewa' => 3, 'id_pelaminan' => 9, 'jumlah' => 1, 'subtotal' => 2500000],

            // Sewa 4 - Pelaminan Luxury
            ['id_sewa' => 4, 'id_pelaminan' => 8, 'jumlah' => 1, 'subtotal' => 12000000],
            ['id_sewa' => 4, 'id_pelaminan' => 10, 'jumlah' => 1, 'subtotal' => 1500000],
            ['id_sewa' => 4, 'id_pelaminan' => 9, 'jumlah' => 1, 'subtotal' => 2500000],

            // Sewa 5 - Pelaminan Rustic
            ['id_sewa' => 5, 'id_pelaminan' => 4, 'jumlah' => 1, 'subtotal' => 6000000],
            ['id_sewa' => 5, 'id_pelaminan' => 9, 'jumlah' => 1, 'subtotal' => 2500000],

            // Sewa 6 - Pelaminan Modern + Glamour
            ['id_sewa' => 6, 'id_pelaminan' => 3, 'jumlah' => 1, 'subtotal' => 5000000],
            ['id_sewa' => 6, 'id_pelaminan' => 4, 'jumlah' => 1, 'subtotal' => 6000000],

            // Sewa 7 - Pelaminan Sunda
            ['id_sewa' => 7, 'id_pelaminan' => 7, 'jumlah' => 1, 'subtotal' => 3500000],
            ['id_sewa' => 7, 'id_pelaminan' => 2, 'jumlah' => 1, 'subtotal' => 4000000],

            // Sewa 8 - Pelaminan Luxury + Full
            ['id_sewa' => 8, 'id_pelaminan' => 8, 'jumlah' => 1, 'subtotal' => 12000000],
            ['id_sewa' => 8, 'id_pelaminan' => 5, 'jumlah' => 1, 'subtotal' => 7500000],

            // Sewa 9 - Pelaminan Glamour + Aksesoris
            ['id_sewa' => 9, 'id_pelaminan' => 5, 'jumlah' => 1, 'subtotal' => 7500000],
            ['id_sewa' => 9, 'id_pelaminan' => 4, 'jumlah' => 1, 'subtotal' => 6000000],

            // Sewa 10 - Pelaminan Bronze (Batal)
            ['id_sewa' => 10, 'id_pelaminan' => 1, 'jumlah' => 1, 'subtotal' => 3500000],
            ['id_sewa' => 10, 'id_pelaminan' => 10, 'jumlah' => 1, 'subtotal' => 1500000],
        ];

        $this->db->table('detail_penyewaan')->insertBatch($detailPenyewaan);
        echo "✅ Detail Penyewaan: " . count($detailPenyewaan) . " item berhasil ditambahkan\n";

        // Pembayaran - variasi lunas dan belum lunas
        $pembayaran = [
            // Sewa 1 - Lunas
            ['id_sewa' => 1, 'tanggal_bayar' => '2025-01-15', 'metode' => 'transfer', 'jumlah_bayar' => 4000000, 'status_bayar' => 'belum'],
            ['id_sewa' => 1, 'tanggal_bayar' => '2025-01-20', 'metode' => 'tunai', 'jumlah_bayar' => 4500000, 'status_bayar' => 'lunas'],

            // Sewa 2 - Lunas
            ['id_sewa' => 2, 'tanggal_bayar' => '2025-02-10', 'metode' => 'transfer', 'jumlah_bayar' => 12000000, 'status_bayar' => 'lunas'],

            // Sewa 3 - Lunas
            ['id_sewa' => 3, 'tanggal_bayar' => '2025-03-20', 'metode' => 'tunai', 'jumlah_bayar' => 3000000, 'status_bayar' => 'belum'],
            ['id_sewa' => 3, 'tanggal_bayar' => '2025-03-25', 'metode' => 'tunai', 'jumlah_bayar' => 3500000, 'status_bayar' => 'lunas'],

            // Sewa 4 - Lunas
            ['id_sewa' => 4, 'tanggal_bayar' => '2025-04-05', 'metode' => 'transfer', 'jumlah_bayar' => 15500000, 'status_bayar' => 'lunas'],

            // Sewa 5 - Lunas
            ['id_sewa' => 5, 'tanggal_bayar' => '2025-05-15', 'metode' => 'transfer', 'jumlah_bayar' => 5000000, 'status_bayar' => 'belum'],
            ['id_sewa' => 5, 'tanggal_bayar' => '2025-05-18', 'metode' => 'tunai', 'jumlah_bayar' => 4000000, 'status_bayar' => 'lunas'],

            // Sewa 6 - DP saja (Piutang)
            ['id_sewa' => 6, 'tanggal_bayar' => '2025-06-18', 'metode' => 'transfer', 'jumlah_bayar' => 5000000, 'status_bayar' => 'belum'],

            // Sewa 7 - DP saja (Piutang)
            ['id_sewa' => 7, 'tanggal_bayar' => '2025-07-10', 'metode' => 'tunai', 'jumlah_bayar' => 3000000, 'status_bayar' => 'belum'],

            // Sewa 8 - DP (Booking)
            ['id_sewa' => 8, 'tanggal_bayar' => '2025-08-01', 'metode' => 'transfer', 'jumlah_bayar' => 10000000, 'status_bayar' => 'belum'],

            // Sewa 9 - DP (Booking)
            ['id_sewa' => 9, 'tanggal_bayar' => '2025-09-01', 'metode' => 'transfer', 'jumlah_bayar' => 7000000, 'status_bayar' => 'belum'],
        ];

        $this->db->table('pembayaran')->insertBatch($pembayaran);
        echo "✅ Pembayaran: " . count($pembayaran) . " pembayaran berhasil ditambahkan\n";

        // Pengembalian - dengan variasi kondisi dan denda
        $pengembalian = [
            // Sewa 1 - Kondisi baik
            ['id_sewa' => 1, 'tanggal_kembali' => '2025-01-21', 'kondisi' => 'baik', 'denda' => 0],

            // Sewa 2 - Kondisi rusak, ada denda
            ['id_sewa' => 2, 'tanggal_kembali' => '2025-02-15', 'kondisi' => 'rusak', 'denda' => 500000],

            // Sewa 3 - Kondisi baik
            ['id_sewa' => 3, 'tanggal_kembali' => '2025-03-26', 'kondisi' => 'baik', 'denda' => 0],

            // Sewa 4 - Kondisi rusak, denda besar
            ['id_sewa' => 4, 'tanggal_kembali' => '2025-04-12', 'kondisi' => 'rusak', 'denda' => 1500000],

            // Sewa 5 - Kondisi baik, terlambat (denda keterlambatan)
            ['id_sewa' => 5, 'tanggal_kembali' => '2025-05-21', 'kondisi' => 'baik', 'denda' => 200000],
        ];

        $this->db->table('pengembalian')->insertBatch($pengembalian);
        echo "✅ Pengembalian: " . count($pengembalian) . " pengembalian berhasil ditambahkan\n";
    }
}
