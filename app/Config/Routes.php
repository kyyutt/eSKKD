<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public Routes for Authentication
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::processLogin');
$routes->get('/logout', 'AuthController::logout');

// Protected Routes for Dashboard
$routes->get('/', 'DashboardController::index', ['filter' => 'auth']);

// Protected Routes for User Management
$routes->group('user', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'UserController::index');
    $routes->get('ajaxList', 'UserController::ajaxList');
    $routes->post('store', 'UserController::store');
    $routes->get('(:num)', 'UserController::get/$1');
    $routes->post('update/(:num)', 'UserController::update/$1');
    $routes->delete('delete/(:num)', 'UserController::delete/$1');
    $routes->get('my_profile', 'UserController::getMyProfile');
    $routes->post('update_my_profile', 'UserController::updateMyProfile');
});

// Protected Routes for Pasien Management
$routes->group('pasien', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'PasienController::index');
    $routes->get('ajaxList', 'PasienController::ajaxList');
    $routes->get('(:num)', 'PasienController::show/$1');
    $routes->post('store', 'PasienController::store');
    $routes->post('update/(:num)', 'PasienController::update/$1');
    $routes->delete('delete/(:num)', 'PasienController::delete/$1');
});

// Protected Routes for Dokter Management
$routes->group('dokter', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'DokterController::index');
    $routes->get('ajaxList', 'DokterController::ajaxList');
    $routes->post('store', 'DokterController::store');
    $routes->post('update/(:num)', 'DokterController::update/$1');
    $routes->delete('delete/(:num)', 'DokterController::delete/$1');
});

// Protected Routes for Pendaftaran SKKD
$routes->group('pendaftaran_skkd', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'PendaftaranSKKD::index');
    $routes->post('store', 'PendaftaranSKKD::store');
    $routes->get('cari-pasien', 'PendaftaranSKKD::searchPasien');
});

// Protected Routes for Riwayat SKKD Management
$routes->group('riwayat_skkd', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Pengajuan::index');
    $routes->get('ajaxList', 'Pengajuan::ajaxList');
    $routes->get('show/(:num)', 'Pengajuan::show/$1');
    $routes->post('update/(:num)', 'Pengajuan::update/$1');
    $routes->delete('delete/(:num)', 'Pengajuan::delete/$1');
    $routes->post('update_status/(:num)', 'Pengajuan::updateStatus/$1');
});

// Protected Routes for SKKD Processing and Printing
$routes->group('skkd', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'SKKDController::index');
    $routes->get('ajaxList', 'SKKDController::ajaxList');
    $routes->get('(:num)', 'SKKDController::show/$1');
    $routes->post('store', 'SKKDController::store');
    $routes->delete('delete/(:num)', 'SKKDController::delete/$1');
    $routes->get('cetak/(:num)', 'SKKDController::cetak/$1');
    $routes->get('print_pdf/(:num)', 'SKKDController::print_pdf/$1');
});

// Protected Routes for Laporan Management
$routes->group('laporan', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'LaporanController::index');
    $routes->get('getData', 'LaporanController::getData');
    $routes->get('cetak', 'LaporanController::cetak');
});
