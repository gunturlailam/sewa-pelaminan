<?php

namespace App\Controllers\Transaksi;

use App\Controllers\BaseController;
use App\Models\PenyewaanModel;
use App\Models\PelangganModel;
use App\Models\PelaminanModel;
use Config\Database;

class Penyewaan extends BaseController
{
    protected $penyewaanModel;
    protected $pelangganModel;
    protected $pelaminanModel;

    public function __construct()
    {
        $this->penyewaanModel = new PenyewaanModel();
        $this->pelangganModel = new PelangganModel();
        $this->pelaminanModel = new PelaminanModel();
    }

    public function index()
    {
        // Pelanggan hanya lihat miliknya
        if ($this->isPelanggan()) {
            $penyewaan = $this->penyewaanModel->getByPelanggan($this->session->get('pelanggan_id'));
        } else {
            $penyewaan = $this->penyewaanModel->getWithRelations();
        }

        $data = [
            'title' => 'Data Penyewaan',
            'penyewaan' => $penyewaan
        ];
        return view('transaksi/penyewaan/index', $data);
    }

    public function create()
    {
        // Admin, Petugas, dan Pelanggan bisa input
        $data = [
            'title' => 'Tambah Penyewaan',
            'pelanggan' => $this->pelangganModel->getWithUser(),
            'pelaminan' => $this->pelaminanModel->getAvailableForRent(), // Hanya yang tersedia
            'validation' => \Config\Services::validation()
        ];
        return view('transaksi/penyewaan/form', $data);
    }

    public function store()
    {
        // ============================================
        // VALIDASI KETAT - PENYEWAAN SEDERHANA
        // ============================================

        // 1. Validasi Dasar
        $rules = [
            'tanggal_sewa' => [
                'rules' => 'required|valid_date|tanggal_tidak_kemarin',
                'errors' => [
                    'required' => 'Tanggal sewa wajib diisi',
                    'valid_date' => 'Format tanggal sewa tidak valid',
                    'tanggal_tidak_kemarin' => 'Tanggal sewa tidak boleh sebelum hari ini'
                ]
            ],
            'tanggal_kembali' => [
                'rules' => 'required|valid_date|tanggal_setelah[tanggal_sewa]|durasi_maksimal[tanggal_sewa,7]',
                'errors' => [
                    'required' => 'Tanggal kembali wajib diisi',
                    'valid_date' => 'Format tanggal kembali tidak valid',
                    'tanggal_setelah' => 'Tanggal kembali harus setelah atau sama dengan tanggal sewa',
                    'durasi_maksimal' => 'Durasi sewa maksimal 7 hari'
                ]
            ],
            'id_pelaminan' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Pelaminan wajib dipilih',
                    'numeric' => 'ID Pelaminan tidak valid'
                ]
            ],
            'alamat_acara' => [
                'rules' => 'required|min_length[10]|max_length[500]',
                'errors' => [
                    'required' => 'Alamat acara wajib diisi',
                    'min_length' => 'Alamat acara minimal 10 karakter',
                    'max_length' => 'Alamat acara maksimal 500 karakter'
                ]
            ],
            'catatan' => [
                'rules' => 'permit_empty|max_length[1000]',
                'errors' => [
                    'max_length' => 'Catatan maksimal 1000 karakter'
                ]
            ]
        ];

        // 2. Validasi Pelanggan (jika bukan pelanggan yang input)
        if (!$this->isPelanggan()) {
            $rules['id_pelanggan'] = [
                'rules' => 'required|numeric|pelanggan_exists',
                'errors' => [
                    'required' => 'Pelanggan wajib dipilih',
                    'numeric' => 'ID Pelanggan tidak valid',
                    'pelanggan_exists' => 'Pelanggan tidak ditemukan di database'
                ]
            ];
        }

        // Jalankan validasi dasar
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $idPelaminan = $this->request->getPost('id_pelaminan');
        $tanggalSewa = $this->request->getPost('tanggal_sewa');
        $tanggalKembali = $this->request->getPost('tanggal_kembali');

        // 3. Validasi Pelaminan
        $pelaminan = $this->pelaminanModel->find($idPelaminan);
        if (!$pelaminan) {
            return redirect()->back()->withInput()->with('error', 'Pelaminan tidak ditemukan');
        }

        if ($pelaminan['status'] !== 'tersedia') {
            return redirect()->back()->withInput()->with('error', 'Pelaminan sedang tidak tersedia');
        }

        // 4. Cek bentrok jadwal
        $db = Database::connect();
        $bentrok = $db->table('penyewaan')
            ->where('id_pelaminan', $idPelaminan)
            ->whereNotIn('status_sewa', ['batal', 'selesai'])
            ->groupStart()
            ->where('tanggal_sewa <=', $tanggalKembali)
            ->where('tanggal_kembali >=', $tanggalSewa)
            ->groupEnd()
            ->countAllResults();

        if ($bentrok > 0) {
            return redirect()->back()->withInput()->with('error', 'Pelaminan sudah disewa pada tanggal tersebut');
        }

        // 5. Hitung Total (selalu 1 unit)
        $hargaSewa = $pelaminan['harga_sewa'];
        $totalBayar = $hargaSewa; // Tidak dikali jumlah karena selalu 1

        // 6. Validasi DP (jika ada)
        $dpBayar = (float)$this->request->getPost('dp_bayar');
        if ($dpBayar > 0) {
            if ($dpBayar > $totalBayar) {
                return redirect()->back()->withInput()->with('error', 'DP tidak boleh lebih besar dari total harga (Rp ' . number_format($totalBayar, 0, ',', '.') . ')');
            }

            $minDp = $totalBayar * 0.3;
            if ($dpBayar < $minDp) {
                return redirect()->back()->withInput()->with('error', 'Minimal DP adalah 30% dari total (Rp ' . number_format($minDp, 0, ',', '.') . ')');
            }
        }

        // 7. Validasi User Aktif
        $userId = $this->session->get('user_id');
        if (!$userId) {
            return redirect()->to('/auth/login')->with('error', 'Session expired, silakan login ulang');
        }

        $userAktif = $db->table('users')
            ->where('id_user', $userId)
            ->where('status', 'aktif')
            ->countAllResults();

        if (!$userAktif) {
            return redirect()->back()->withInput()->with('error', 'Akun Anda tidak aktif, tidak dapat melakukan transaksi');
        }

        // ============================================
        // SIMPAN DATA
        // ============================================

        // Jika pelanggan, paksa id_pelanggan dari session
        $idPelanggan = $this->isPelanggan()
            ? $this->session->get('pelanggan_id')
            : $this->request->getPost('id_pelanggan');

        // Insert penyewaan (jumlah selalu 1)
        $idSewa = $this->penyewaanModel->insert([
            'id_pelanggan'    => $idPelanggan,
            'id_pelaminan'    => $idPelaminan,
            'tanggal_sewa'    => $tanggalSewa,
            'tanggal_kembali' => $tanggalKembali,
            'alamat_acara'    => $this->request->getPost('alamat_acara'),
            'catatan'         => $this->request->getPost('catatan'),
            'harga_sewa'      => $hargaSewa,
            'total_bayar'     => $totalBayar,
            'status_sewa'     => 'booking',
            'created_by'      => $userId,
            'created_at'      => date('Y-m-d H:i:s')
        ]);

        // Update status pelaminan menjadi 'disewa'
        $this->pelaminanModel->update($idPelaminan, ['status' => 'disewa']);

        // Insert pembayaran DP jika ada
        if ($dpBayar > 0) {
            $db->table('pembayaran')->insert([
                'id_sewa' => $idSewa,
                'tanggal_bayar' => date('Y-m-d'),
                'jumlah_bayar' => $dpBayar,
                'metode_bayar' => 'tunai',
                'keterangan' => 'DP Awal',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        return redirect()->to('/transaksi/penyewaan')->with('success', 'Penyewaan berhasil ditambahkan dengan No. Nota #' . str_pad($idSewa, 5, '0', STR_PAD_LEFT));
    }

    public function detail($id)
    {
        $penyewaan = $this->penyewaanModel->getWithRelations($id);
        if (!$penyewaan) {
            return redirect()->to('/transaksi/penyewaan')->with('error', 'Data tidak ditemukan');
        }

        // Cek akses pelanggan
        if ($this->isPelanggan() && $penyewaan['id_pelanggan'] != $this->session->get('pelanggan_id')) {
            return $this->denyAccess();
        }

        $data = [
            'title' => 'Detail Penyewaan',
            'penyewaan' => $penyewaan
        ];
        return view('transaksi/penyewaan/detail', $data);
    }

    public function edit($id)
    {
        if (!$this->hasRole([self::ROLE_ADMIN])) {
            return $this->denyAccess();
        }

        $penyewaan = $this->penyewaanModel->getWithRelations($id);
        if (!$penyewaan) {
            return redirect()->to('/transaksi/penyewaan')->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Penyewaan',
            'penyewaan' => $penyewaan,
            'pelanggan' => $this->pelangganModel->getWithUser(),
            'pelaminan' => $this->pelaminanModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('transaksi/penyewaan/form', $data);
    }

    public function update($id)
    {
        if (!$this->hasRole([self::ROLE_ADMIN])) {
            return $this->denyAccess();
        }

        $rules = [
            'tanggal_sewa' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'Tanggal sewa wajib diisi',
                    'valid_date' => 'Format tanggal sewa tidak valid'
                ]
            ],
            'tanggal_kembali' => [
                'rules' => 'required|valid_date|tanggal_setelah[tanggal_sewa]',
                'errors' => [
                    'required' => 'Tanggal kembali wajib diisi',
                    'valid_date' => 'Format tanggal kembali tidak valid',
                    'tanggal_setelah' => 'Tanggal kembali harus setelah atau sama dengan tanggal sewa'
                ]
            ],
            'status_sewa' => [
                'rules' => 'required|in_list[booking,berjalan,selesai,batal]',
                'errors' => [
                    'required' => 'Status wajib dipilih',
                    'in_list' => 'Status tidak valid'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $statusBaru = $this->request->getPost('status_sewa');
        $penyewaanLama = $this->penyewaanModel->find($id);

        $this->penyewaanModel->update($id, [
            'tanggal_sewa'    => $this->request->getPost('tanggal_sewa'),
            'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
            'status_sewa'     => $statusBaru,
        ]);

        // Jika status berubah ke selesai/batal, kembalikan status pelaminan
        if (in_array($statusBaru, ['selesai', 'batal']) && !in_array($penyewaanLama['status_sewa'], ['selesai', 'batal'])) {
            $this->pelaminanModel->update($penyewaanLama['id_pelaminan'], ['status' => 'tersedia']);
        }

        return redirect()->to('/transaksi/penyewaan')->with('success', 'Penyewaan berhasil diupdate');
    }

    public function delete($id)
    {
        if (!$this->hasRole([self::ROLE_ADMIN])) {
            return $this->denyAccess();
        }

        $penyewaan = $this->penyewaanModel->find($id);
        if (!$penyewaan) {
            return redirect()->to('/transaksi/penyewaan')->with('error', 'Data tidak ditemukan');
        }

        // Kembalikan status pelaminan
        $this->pelaminanModel->update($penyewaan['id_pelaminan'], ['status' => 'tersedia']);

        $this->penyewaanModel->delete($id);

        return redirect()->to('/transaksi/penyewaan')->with('success', 'Penyewaan berhasil dihapus');
    }

    /**
     * Cetak Invoice/Nota Penyewaan
     */
    public function cetak($id)
    {
        $penyewaan = $this->penyewaanModel->getWithRelations($id);
        if (!$penyewaan) {
            return redirect()->to('/transaksi/penyewaan')->with('error', 'Data tidak ditemukan');
        }

        // Cek akses pelanggan
        if ($this->isPelanggan() && $penyewaan['id_pelanggan'] != $this->session->get('pelanggan_id')) {
            return $this->denyAccess();
        }

        // Ambil riwayat pembayaran
        $db = Database::connect();
        $pembayaran = $db->table('pembayaran')
            ->where('id_sewa', $id)
            ->orderBy('tanggal_bayar', 'ASC')
            ->get()
            ->getResultArray();

        // Hitung total dibayar dan sisa
        $totalDibayar = array_sum(array_column($pembayaran, 'jumlah_bayar'));
        $sisaBayar = $penyewaan['total_bayar'] - $totalDibayar;

        $data = [
            'title' => 'Cetak Invoice',
            'penyewaan' => $penyewaan,
            'pembayaran' => $pembayaran,
            'totalDibayar' => $totalDibayar,
            'sisaBayar' => $sisaBayar
        ];

        return view('transaksi/penyewaan/cetak_nota', $data);
    }
}
