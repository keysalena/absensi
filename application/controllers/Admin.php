<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Check if the user is logged in and if the role is 'admin'
        if (!$this->session->userdata('user') || $this->session->userdata('user')['role'] != 'admin') {
            redirect('login'); // Redirect to login page if not admin
        }
        // $allowed_ips = ['103.79.246.93', '182.1.83.109', '::1'];

        // $user_ip = $this->input->ip_address();

        // if (!in_array($user_ip, $allowed_ips)) {
        //     show_error('Akses ditolak: Anda tidak terhubung ke Wi-Fi yang diizinkan', 403);
        // }
    }

    public function index()
    {
        $this->load->view('admin_dashboard'); // Load the admin dashboard view
    }
}
?>
