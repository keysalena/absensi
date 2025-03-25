<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Admin
 * 
 * Mengelola semua fungsi yang terkait dengan administrator sistem.
 * Hanya dapat diakses oleh user dengan role 'admin' dan dari IP tertentu.
 */
class Admin extends CI_Controller {

    private $allowed_ips = ['103.79.246.93', '182.1.83.109', '::1']; // Daftar IP yang diizinkan

    /**
     * Constructor
     * 
     * Memeriksa autentikasi dan otorisasi sebelum mengakses method apapun
     */
    public function __construct()
    {
        parent::__construct();
        
        // Load library dan helper yang diperlukan
        $this->load->library('session');
        $this->load->helper('url');
        
        // Authentikasi: Cek apakah user sudah login
        if (!$this->session->userdata('user')) {
            redirect('login'); // Redirect ke halaman login jika belum login
        }
        
        // Otorisasi: Cek apakah user memiliki role admin
        if ($this->session->userdata('user')['role'] != 'admin') {
            show_error('Anda tidak memiliki izin untuk mengakses halaman ini', 403); // 403 Forbidden
        }
        
        // Keamanan IP: Restriksi akses berdasarkan alamat IP
        $user_ip = $this->input->ip_address();
        if (!in_array($user_ip, $this->allowed_ips)) {
            log_message('error', 'Attempted unauthorized access from IP: '.$user_ip); // Log percobaan akses
            show_error('Akses ditolak: Anda harus terhubung ke jaringan yang diizinkan', 403);
        }
    }

    /**
     * Dashboard Admin
     * 
     * Menampilkan halaman dashboard administrator
     * @return void
     */
    public function index()
    {
        // Persiapan data untuk view
        $data = [
            'page_title' => 'Admin Dashboard',
            'user_info'  => $this->session->userdata('user')
        ];
        
        // Load view dengan data
        $this->load->view('admin/header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('admin/footer');
    }
}