<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| File ini digunakan untuk memetakan URI request ke fungsi controller tertentu.
| Memungkinkan custom routing untuk membuat URL yang lebih bersih dan SEO friendly.
*/

/*
| -------------------------------------------------------------------------
| DEFAULT CONTROLLER
| -------------------------------------------------------------------------
| Controller yang akan di-load ketika tidak ada URI yang ditentukan
*/
$route['default_controller'] = 'AttendanceController'; // Controller utama untuk halaman depan

/*
| -------------------------------------------------------------------------
| AUTHENTICATION ROUTES
| -------------------------------------------------------------------------
| Routing untuk proses autentikasi (login/logout/register)
*/
$route['register'] = 'register'; // Halaman pendaftaran
$route['register/process'] = 'register/process'; // Proses form pendaftaran
$route['logout'] = 'Login/logout'; // Proses logout

/*
| -------------------------------------------------------------------------
| ATTENDANCE ROUTES
| -------------------------------------------------------------------------
| Routing untuk fitur absensi
*/
$route['attendance'] = 'AttendanceController/index'; // Halaman absensi utama
$route['attendance/process_absen/(:any)'] = 'AttendanceController/process_absen/$1'; // Proses absen dengan parameter

/*
| -------------------------------------------------------------------------
| ADMIN ROUTES
| -------------------------------------------------------------------------
| Routing untuk halaman admin
*/
$route['admin'] = 'AdminController/index'; // Dashboard admin
$route['admin/get_absensi'] = 'AdminController/get_absensi'; // Endpoint API untuk data absensi

/*
| -------------------------------------------------------------------------
| PROFILE ROUTES
| -------------------------------------------------------------------------
| Routing untuk manajemen profil pengguna
*/
$route['profile'] = 'profile'; // Halaman profil
$route['profile/update'] = 'profile/update'; // Proses update profil

/*
| -------------------------------------------------------------------------
| DASHBOARD ROUTE
| -------------------------------------------------------------------------
| Routing untuk halaman dashboard pengguna
*/
$route['dashboard'] = 'dashboard'; // Halaman dashboard setelah login

/*
| -------------------------------------------------------------------------
| TRANSLATE URI DASHES
| -------------------------------------------------------------------------
| Konversi otomatis tanda strip (-) menjadi underscore (_) pada URI
| Berguna untuk kompatibilitas nama controller/method
*/
$route['translate_uri_dashes'] = FALSE; // Nonaktifkan fitur konversi