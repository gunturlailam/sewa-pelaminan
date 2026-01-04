<?php

/**
 * Auth Helper - Helper functions untuk permission checking
 */

if (!function_exists('isLoggedIn')) {
    function isLoggedIn(): bool
    {
        return (bool) session()->get('isLoggedIn');
    }
}

if (!function_exists('getUserRole')) {
    function getUserRole(): ?string
    {
        return session()->get('role');
    }
}

if (!function_exists('getUserId')) {
    function getUserId(): ?int
    {
        return session()->get('user_id');
    }
}

if (!function_exists('getPelangganId')) {
    function getPelangganId(): ?int
    {
        return session()->get('pelanggan_id');
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin(): bool
    {
        return getUserRole() === 'admin';
    }
}

if (!function_exists('isPetugas')) {
    function isPetugas(): bool
    {
        return getUserRole() === 'petugas';
    }
}

if (!function_exists('isPelanggan')) {
    function isPelanggan(): bool
    {
        return getUserRole() === 'pelanggan';
    }
}

if (!function_exists('hasRole')) {
    function hasRole(array $roles): bool
    {
        return in_array(getUserRole(), $roles);
    }
}

if (!function_exists('canManageMaster')) {
    function canManageMaster(): bool
    {
        return isAdmin();
    }
}

if (!function_exists('canInputTransaksi')) {
    function canInputTransaksi(): bool
    {
        return hasRole(['admin', 'petugas']);
    }
}

if (!function_exists('canViewLaporan')) {
    function canViewLaporan(): bool
    {
        return hasRole(['admin', 'petugas']);
    }
}

if (!function_exists('canManageUsers')) {
    function canManageUsers(): bool
    {
        return isAdmin();
    }
}
