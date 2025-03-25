<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| KONFIGURASI DATABASE
| -------------------------------------------------------------------
| File ini berisi pengaturan untuk koneksi ke database.
| Untuk petunjuk lengkap, lihat dokumentasi CodeIgniter:
| https://codeigniter.com/userguide3/database/configuration.html
*/

/*
| -------------------------------------------------------------------
| KELOMPOK KONEKSI AKTIF
| -------------------------------------------------------------------
| Memilih kelompok koneksi database yang aktif
*/
$active_group = 'default'; // Gunakan kelompok koneksi 'default'

/*
| -------------------------------------------------------------------
| QUERY BUILDER
| -------------------------------------------------------------------
| Mengaktifkan atau menonaktifkan Query Builder
*/
$query_builder = TRUE; // Aktifkan untuk fitur database yang lebih powerful

/*
| -------------------------------------------------------------------
| KONFIGURASI DEFAULT DATABASE
| -------------------------------------------------------------------
| Pengaturan untuk koneksi database utama
*/
$db['default'] = array(
    // Data Source Name (DSN) - Kosongkan untuk menggunakan hostname
    'dsn'       => '', 
    
    // Hostname server database
    'hostname'  => 'localhost', 
    
    // Username untuk koneksi database
    'username'  => 'root', 
    
    // Password untuk koneksi database
    'password'  => '', 
    
    // Nama database yang digunakan
    'database'  => 'absensi', 
    
    // Driver database yang digunakan (mysqli/mysql/pdo)
    'dbdriver'  => 'mysqli', 
    
    // Prefix untuk nama tabel (opsional)
    'dbprefix'  => '', 
    
    // Persistent connection - nonaktifkan untuk performa
    'pconnect'  => FALSE, 
    
    // Debug mode - aktif hanya di development
    'db_debug'  => (ENVIRONMENT !== 'production'), 
    
    // Cache query - nonaktifkan kecuali diperlukan
    'cache_on'  => FALSE, 
    
    // Direktori penyimpanan cache
    'cachedir'  => '', 
    
    // Character set database
    'char_set'  => 'utf8mb4', 
    
    // Database collation
    'dbcollat'  => 'utf8mb4_general_ci', 
    
    // Swap prefix (untuk backward compatibility)
    'swap_pre'  => '', 
    
    // Enkripsi koneksi (SSL)
    'encrypt'   => FALSE, 
    
    // Kompresi koneksi
    'compress'  => FALSE, 
    
    // Strict mode - aktifkan di development
    'stricton'  => FALSE, 
    
    // Failover configuration
    'failover'  => array(), 
    
    // Simpan query log - nonaktifkan di production
    'save_queries' => (ENVIRONMENT !== 'production') 
);

/*
| -------------------------------------------------------------------
| KONFIGURASI PRODUCTION (Contoh)
| -------------------------------------------------------------------
| Contoh konfigurasi untuk environment production
|
| $db['production'] = array(
|     'hostname'  => 'prod-db.server.com',
|     'username'  => 'db_prod_user',
|     'password'  => 'StrongPassword123!',
|     'database'  => 'absensi_prod',
|     'dbdriver'  => 'mysqli',
|     'db_debug'  => FALSE,
|     'char_set'  => 'utf8mb4',
|     'dbcollat'  => 'utf8mb4_unicode_ci',
|     'encrypt'   => array(
|         'ssl_key'    => '/path/to/client-key.pem',
|         'ssl_cert'   => '/path/to/client-cert.pem',
|         'ssl_ca'     => '/path/to/ca-cert.pem',
|         'ssl_verify' => TRUE
|     )
| );
*/