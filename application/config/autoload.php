<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| AUTO-LOADER
| -------------------------------------------------------------------
| File ini menentukan sistem apa yang akan dimuat secara otomatis
| pada setiap request. Konfigurasi ini mempengaruhi performa aplikasi.
*/

/*
| -------------------------------------------------------------------
| Auto-load Packages
| -------------------------------------------------------------------
| Paket dari third_party yang akan dimuat otomatis
| Format: array(APPPATH.'third_party', '/path/lain')
*/
$autoload['packages'] = array(); // Kosongkan jika tidak menggunakan package third_party

/*
| -------------------------------------------------------------------
| Auto-load Libraries
| -------------------------------------------------------------------
| Library sistem yang sering digunakan agar tidak perlu load manual
| di setiap controller. Disarankan hanya memuat yang benar-benar diperlukan.
|
| Contoh umum: database, session, form_validation, email
*/
$autoload['libraries'] = array(
    'database',    // Library database untuk koneksi DB
    'session',     // Library session management
    'form_validation' // Library validasi form
);

/*
| -------------------------------------------------------------------
| Auto-load Drivers
| -------------------------------------------------------------------
| Driver khusus yang diperlukan aplikasi
| Contoh: cache, upload, image_lib
*/
$autoload['drivers'] = array(); // Kosongkan jika tidak menggunakan driver khusus

/*
| -------------------------------------------------------------------
| Auto-load Helper Files
| -------------------------------------------------------------------
| Helper functions yang sering digunakan di seluruh aplikasi
| Pilihan helper umum: url, form, file, security
*/
$autoload['helper'] = array(
    'url',     // Helper untuk URL (base_url(), site_url())
    'form',    // Helper untuk form HTML
    'security' // Helper untuk XSS cleaning dan CSRF
);

/*
| -------------------------------------------------------------------
| Auto-load Config Files
| -------------------------------------------------------------------
| File konfigurasi custom yang perlu dimuat otomatis
| Contoh: custom_config.php cukup tulis 'custom_config'
*/
$autoload['config'] = array(); // Kosongkan jika tidak ada config custom

/*
| -------------------------------------------------------------------
| Auto-load Language Files
| -------------------------------------------------------------------
| File bahasa untuk multilingual support
| Contoh: untuk file 'english_lang.php' cukup tulis 'english'
*/
$autoload['language'] = array(); // Kosongkan jika tidak menggunakan multilingual

/*
| -------------------------------------------------------------------
| Auto-load Models
| -------------------------------------------------------------------
| Model yang perlu dimuat otomatis di seluruh aplikasi
| Disarankan hanya untuk model yang benar-benar global
*/
$autoload['model'] = array(
    'User_model' // Model untuk manajemen user
);