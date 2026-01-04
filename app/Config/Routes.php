<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Auth Routes
$routes->get('/', 'Auth::index');
$routes->get('auth/login', 'Auth::login');
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/logout', 'Auth::logout');
$routes->get('auth/register', 'Auth::register');

// Dashboard
$routes->get('dashboard', 'Home::index');

// Master Paket
$routes->get('master/paket', 'Master\Paket::index');
$routes->get('master/paket/create', 'Master\Paket::create');
$routes->post('master/paket/store', 'Master\Paket::store');
$routes->get('master/paket/edit/(:num)', 'Master\Paket::edit/$1');
$routes->post('master/paket/update/(:num)', 'Master\Paket::update/$1');
$routes->get('master/paket/delete/(:num)', 'Master\Paket::delete/$1');

// Master Pelaminan
$routes->get('master/pelaminan', 'Master\Pelaminan::index');
$routes->get('master/pelaminan/create', 'Master\Pelaminan::create');
$routes->post('master/pelaminan/store', 'Master\Pelaminan::store');
$routes->get('master/pelaminan/edit/(:num)', 'Master\Pelaminan::edit/$1');
$routes->post('master/pelaminan/update/(:num)', 'Master\Pelaminan::update/$1');
$routes->get('master/pelaminan/delete/(:num)', 'Master\Pelaminan::delete/$1');

// Master Pelanggan
$routes->get('master/pelanggan', 'Master\Pelanggan::index');
$routes->get('master/pelanggan/create', 'Master\Pelanggan::create');
$routes->post('master/pelanggan/store', 'Master\Pelanggan::store');
$routes->get('master/pelanggan/edit/(:num)', 'Master\Pelanggan::edit/$1');
$routes->post('master/pelanggan/update/(:num)', 'Master\Pelanggan::update/$1');
$routes->get('master/pelanggan/delete/(:num)', 'Master\Pelanggan::delete/$1');

// Master Users (Admin only)
$routes->get('master/users', 'Master\Users::index');
$routes->get('master/users/create', 'Master\Users::create');
$routes->post('master/users/store', 'Master\Users::store');
$routes->get('master/users/edit/(:num)', 'Master\Users::edit/$1');
$routes->post('master/users/update/(:num)', 'Master\Users::update/$1');
$routes->get('master/users/delete/(:num)', 'Master\Users::delete/$1');

// Transaksi Penyewaan
$routes->get('transaksi/penyewaan', 'Transaksi\Penyewaan::index');
$routes->get('transaksi/penyewaan/create', 'Transaksi\Penyewaan::create');
$routes->post('transaksi/penyewaan/store', 'Transaksi\Penyewaan::store');
$routes->get('transaksi/penyewaan/detail/(:num)', 'Transaksi\Penyewaan::detail/$1');
$routes->get('transaksi/penyewaan/edit/(:num)', 'Transaksi\Penyewaan::edit/$1');
$routes->post('transaksi/penyewaan/update/(:num)', 'Transaksi\Penyewaan::update/$1');
$routes->get('transaksi/penyewaan/delete/(:num)', 'Transaksi\Penyewaan::delete/$1');
$routes->get('transaksi/penyewaan/cetak/(:num)', 'Transaksi\Penyewaan::cetak/$1');

// Transaksi Pembayaran
$routes->get('transaksi/pembayaran', 'Transaksi\Pembayaran::index');
$routes->get('transaksi/pembayaran/create', 'Transaksi\Pembayaran::create');
$routes->post('transaksi/pembayaran/store', 'Transaksi\Pembayaran::store');
$routes->get('transaksi/pembayaran/edit/(:num)', 'Transaksi\Pembayaran::edit/$1');
$routes->post('transaksi/pembayaran/update/(:num)', 'Transaksi\Pembayaran::update/$1');
$routes->get('transaksi/pembayaran/delete/(:num)', 'Transaksi\Pembayaran::delete/$1');

// Transaksi Pengembalian
$routes->get('transaksi/pengembalian', 'Transaksi\Pengembalian::index');
$routes->get('transaksi/pengembalian/create', 'Transaksi\Pengembalian::create');
$routes->post('transaksi/pengembalian/store', 'Transaksi\Pengembalian::store');
$routes->get('transaksi/pengembalian/edit/(:num)', 'Transaksi\Pengembalian::edit/$1');
$routes->post('transaksi/pengembalian/update/(:num)', 'Transaksi\Pengembalian::update/$1');
$routes->get('transaksi/pengembalian/delete/(:num)', 'Transaksi\Pengembalian::delete/$1');


// Laporan Penyewaan
$routes->get('laporan/penyewaan', 'Laporan\Penyewaan::index');
$routes->get('laporan/penyewaan/detail/(:num)', 'Laporan\Penyewaan::detail/$1');

// Laporan Keuangan
$routes->get('laporan/keuangan', 'Laporan\Keuangan::pembayaran');
$routes->get('laporan/keuangan/pembayaran', 'Laporan\Keuangan::pembayaran');
$routes->get('laporan/keuangan/piutang', 'Laporan\Keuangan::piutang');

// Laporan Logistik
$routes->get('laporan/logistik', 'Laporan\Logistik::pengembalian');
$routes->get('laporan/logistik/pengembalian', 'Laporan\Logistik::pengembalian');
$routes->get('laporan/logistik/denda', 'Laporan\Logistik::denda');

// Laporan Pelanggan (Riwayat)
$routes->get('laporan/pelanggan', 'Laporan\Pelanggan::index');
$routes->get('riwayat', 'Laporan\Pelanggan::riwayat');

// Profil
$routes->get('profil', 'Profil::index');
$routes->post('profil/update', 'Profil::update');
