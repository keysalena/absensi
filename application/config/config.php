<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Konfigurasi Dasar Aplikasi
|--------------------------------------------------------------------------
| File ini berisi pengaturan dasar untuk aplikasi CodeIgniter 3.
*/

/*
|--------------------------------------------------------------------------
| Base Site URL
|--------------------------------------------------------------------------
| URL dasar aplikasi, harus diakhiri dengan slash (/)
| Untuk development: localhost
| Untuk production: sesuaikan dengan domain
*/
$config['base_url'] = 'http://localhost/absensi/';
// $config['base_url'] = 'https://absen.maliki.id'; // Contoh untuk production

/*
|--------------------------------------------------------------------------
| Index File
|--------------------------------------------------------------------------
| Nama file index, kosongkan jika menggunakan mod_rewrite
*/
$config['index_page'] = ''; // Kosong untuk URL yang lebih bersih

/*
|--------------------------------------------------------------------------
| URI Protocol
|--------------------------------------------------------------------------
| Metode yang digunakan untuk membaca URI
| REQUEST_URI adalah pilihan paling kompatibel
*/
$config['uri_protocol'] = 'REQUEST_URI';

/*
|--------------------------------------------------------------------------
| URL Suffix
|--------------------------------------------------------------------------
| Akhiran tambahan untuk URL, misalnya .html
| Biarkan kosong jika tidak diperlukan
*/
$config['url_suffix'] = '';

/*
|--------------------------------------------------------------------------
| Bahasa Default
|--------------------------------------------------------------------------
| Set bahasa default untuk aplikasi
*/
$config['language'] = 'english'; // Bisa diganti ke 'indonesian' jika ada file bahasanya

/*
|--------------------------------------------------------------------------
| Default Character Set
|--------------------------------------------------------------------------
| Encoding karakter default untuk aplikasi
*/
$config['charset'] = 'UTF-8'; // Encoding standar untuk multilingual

/*
|--------------------------------------------------------------------------
| Enable Hooks
|--------------------------------------------------------------------------
| Aktifkan fitur hooks untuk eksekusi kode di titik tertentu
*/
$config['enable_hooks'] = FALSE; // Disable jika tidak digunakan

/*
|--------------------------------------------------------------------------
| Subclass Prefix
|--------------------------------------------------------------------------
| Prefix untuk class extension custom
*/
$config['subclass_prefix'] = 'MY_'; // Standar prefix untuk extended classes

/*
|--------------------------------------------------------------------------
| Composer Autoload
|--------------------------------------------------------------------------
| Lokasi file autoload Composer jika digunakan
*/
$config['composer_autoload'] = FALSE; // Enable jika menggunakan packages Composer

/*
|--------------------------------------------------------------------------
| Allowed URL Characters
|--------------------------------------------------------------------------
| Karakter yang diizinkan dalam URL
| Untuk keamanan, batasi karakter yang diperbolehkan
*/
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-'; // Karakter aman untuk URL

/*
|--------------------------------------------------------------------------
| Enable Query Strings
|--------------------------------------------------------------------------
| Aktifkan mode query string (tidak direkomendasikan)
*/
$config['enable_query_strings'] = FALSE; // Biarkan FALSE untuk URL yang lebih bersih
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';

/*
|--------------------------------------------------------------------------
| Allow GET Array
|--------------------------------------------------------------------------
| Izinkan akses ke array $_GET
*/
$config['allow_get_array'] = TRUE; // Biarkan TRUE untuk kompatibilitas

/*
|--------------------------------------------------------------------------
| Error Logging
|--------------------------------------------------------------------------
| Pengaturan logging error aplikasi
*/
$config['log_threshold'] = 1; // Set 1 untuk logging error saja di production
$config['log_path'] = ''; // Biarkan kosong untuk default (application/logs/)
$config['log_file_extension'] = ''; // Ekstensi file log, default 'php'
$config['log_file_permissions'] = 0644; // Permission file log
$config['log_date_format'] = 'Y-m-d H:i:s'; // Format tanggal log

/*
|--------------------------------------------------------------------------
| Error Views Path
|--------------------------------------------------------------------------
| Lokasi custom untuk file error views
*/
$config['error_views_path'] = ''; // Biarkan kosong untuk default

/*
|--------------------------------------------------------------------------
| Cache Path
|--------------------------------------------------------------------------
| Lokasi penyimpanan cache
*/
$config['cache_path'] = ''; // Biarkan kosong untuk default (application/cache/)

/*
|--------------------------------------------------------------------------
| Cache Query String
|--------------------------------------------------------------------------
| Cache berdasarkan query string
*/
$config['cache_query_string'] = FALSE; // Disable untuk performa lebih baik

/*
|--------------------------------------------------------------------------
| Encryption Key
|--------------------------------------------------------------------------
| Kunci untuk enkripsi, HARUS diisi untuk keamanan!
*/
$config['encryption_key'] = ''; // HARUS diisi dengan string random panjang

/*
|--------------------------------------------------------------------------
| Session Configuration
|--------------------------------------------------------------------------
| Pengaturan session management
*/
$config['sess_driver'] = 'files'; // Driver session (files/database/redis/memcached)
$config['sess_cookie_name'] = 'ci_session'; // Nama cookie session
$config['sess_samesite'] = 'Lax'; // Pengaturan SameSite cookie
$config['sess_expiration'] = 7200; // Durasi session dalam detik (2 jam)
$config['sess_save_path'] = NULL; // Path penyimpanan session (NULL untuk default)
$config['sess_match_ip'] = FALSE; // Cocokkan IP user dengan session
$config['sess_time_to_update'] = 300; // Interval regenerasi session ID
$config['sess_regenerate_destroy'] = FALSE; // Hapus data session lama saat regenerasi

/*
|--------------------------------------------------------------------------
| Cookie Configuration
|--------------------------------------------------------------------------
| Pengaturan cookie global
*/
$config['cookie_prefix'] = ''; // Prefix untuk nama cookie
$config['cookie_domain'] = ''; // Domain cookie
$config['cookie_path'] = '/'; // Path cookie
$config['cookie_secure'] = FALSE; // Hanya kirim cookie via HTTPS
$config['cookie_httponly'] = FALSE; // Hanya akses cookie via HTTP (no JS)
$config['cookie_samesite'] = 'Lax'; // Pengaturan SameSite untuk cookie

/*
|--------------------------------------------------------------------------
| Standardize Newlines
|--------------------------------------------------------------------------
| Standarisasi newline characters (deprecated)
*/
$config['standardize_newlines'] = FALSE; // Biarkan FALSE

/*
|--------------------------------------------------------------------------
| Global XSS Filtering
|--------------------------------------------------------------------------
| Filter XSS global (deprecated)
*/
$config['global_xss_filtering'] = FALSE; // Lebih baik handle XSS di input/output

/*
|--------------------------------------------------------------------------
| CSRF Protection
|--------------------------------------------------------------------------
| Pengaturan proteksi Cross-Site Request Forgery
*/
$config['csrf_protection'] = FALSE; // Enable di production untuk keamanan
$config['csrf_token_name'] = 'csrf_test_name'; // Nama token CSRF
$config['csrf_cookie_name'] = 'csrf_cookie_name'; // Nama cookie CSRF
$config['csrf_expire'] = 7200; // Durasi token CSRF
$config['csrf_regenerate'] = TRUE; // Regenerasi token setiap submit
$config['csrf_exclude_uris'] = array(); // URI yang dikecualikan dari CSRF

/*
|--------------------------------------------------------------------------
| Output Compression
|--------------------------------------------------------------------------
| Kompresi output Gzip
*/
$config['compress_output'] = FALSE; // Enable jika server mendukung

/*
|--------------------------------------------------------------------------
| Timezone
|--------------------------------------------------------------------------
| Zona waktu default aplikasi
*/
$config['time_reference'] = 'local'; // Atau set timezone seperti 'Asia/Jakarta'

/*
|--------------------------------------------------------------------------
| Rewrite Short Tags
|--------------------------------------------------------------------------
| Konversi short tag PHP (<?) ke long tag (<?php)
*/
$config['rewrite_short_tags'] = FALSE; // Biarkan FALSE untuk kompatibilitas

/*
|--------------------------------------------------------------------------
| Proxy IPs
|--------------------------------------------------------------------------
| Daftar IP proxy yang dipercaya
*/
$config['proxy_ips'] = ''; // Isi jika aplikasi di belakang proxy