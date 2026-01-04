<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 */
abstract class BaseController extends Controller
{
    protected $session;
    protected $helpers = ['url', 'form'];

    // Role constants
    const ROLE_ADMIN = 'admin';
    const ROLE_PETUGAS = 'petugas';
    const ROLE_PELANGGAN = 'pelanggan';

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->session = service('session');
    }

    /**
     * Cek apakah user sudah login
     */
    protected function isLoggedIn(): bool
    {
        return (bool) $this->session->get('isLoggedIn');
    }

    /**
     * Get current user role
     */
    protected function getUserRole(): ?string
    {
        return $this->session->get('role');
    }

    /**
     * Get current user ID
     */
    protected function getUserId(): ?int
    {
        return $this->session->get('user_id');
    }

    /**
     * Cek apakah user adalah Admin
     */
    protected function isAdmin(): bool
    {
        return $this->getUserRole() === self::ROLE_ADMIN;
    }

    /**
     * Cek apakah user adalah Petugas
     */
    protected function isPetugas(): bool
    {
        return $this->getUserRole() === self::ROLE_PETUGAS;
    }

    /**
     * Cek apakah user adalah Pelanggan
     */
    protected function isPelanggan(): bool
    {
        return $this->getUserRole() === self::ROLE_PELANGGAN;
    }

    /**
     * Cek apakah user memiliki salah satu role yang diizinkan
     */
    protected function hasRole(array $allowedRoles): bool
    {
        return in_array($this->getUserRole(), $allowedRoles);
    }

    /**
     * Redirect jika tidak punya akses
     */
    protected function denyAccess(string $message = 'Anda tidak memiliki akses')
    {
        return redirect()->to('/dashboard')->with('error', $message);
    }

    /**
     * Cek apakah data milik user yang sedang login (untuk Pelanggan)
     */
    protected function isOwnData(int $pelangganId): bool
    {
        if ($this->isAdmin() || $this->isPetugas()) {
            return true; // Admin & Petugas bisa akses semua data
        }
        return $this->session->get('pelanggan_id') == $pelangganId;
    }

    /**
     * Permission check untuk Master data
     * Admin: Full, Petugas: View only, Pelanggan: View only (kecuali profil sendiri)
     */
    protected function canManageMaster(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Permission check untuk Transaksi
     * Admin: Full, Petugas: Input & View, Pelanggan: View own only
     */
    protected function canInputTransaksi(): bool
    {
        return $this->hasRole([self::ROLE_ADMIN, self::ROLE_PETUGAS]);
    }

    /**
     * Permission check untuk Laporan
     * Admin: Full, Petugas: View, Pelanggan: View own history only
     */
    protected function canViewLaporan(): bool
    {
        return $this->hasRole([self::ROLE_ADMIN, self::ROLE_PETUGAS]);
    }

    /**
     * Permission check untuk User Management
     * Admin only
     */
    protected function canManageUsers(): bool
    {
        return $this->isAdmin();
    }
}
