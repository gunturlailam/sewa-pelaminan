<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    /**
     * Cek apakah user memiliki role yang diizinkan
     * 
     * @param RequestInterface $request
     * @param array|null $arguments - Role yang diizinkan ['admin', 'petugas', 'pelanggan']
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/auth/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $userRole = $session->get('role');

        // Jika tidak ada argument, izinkan semua role yang sudah login
        if (empty($arguments)) {
            return;
        }

        // Cek apakah role user ada di daftar yang diizinkan
        if (!in_array($userRole, $arguments)) {
            return redirect()->to('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
