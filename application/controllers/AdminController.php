<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->database(); // Load the databas

        // Check if the user is logged in and is an admin
        if (!isset($this->session->user) || $this->session->user['role'] != 'admin') {
            redirect('login');
        }
        // $allowed_ips = ['103.79.246.93', '182.1.83.109', '::1'];

        // $user_ip = $this->input->ip_address();

        // if (!in_array($user_ip, $allowed_ips)) {
        //     show_error('Akses ditolak: Anda tidak terhubung ke Wi-Fi yang diizinkan', 403);
        // }
    }

    public function index()
    {
        $data['users'] = $this->User_model->get_all_users();
        $this->load->view('users_list', $data);
    }

    public function get_absensi()
    {
        $user_id = $this->input->get('user_id');
        $month = $this->input->get('month');
        $year = $this->input->get('year');

        if (!$user_id || !$month || !$year) {
            echo json_encode([]);
            return;
        }

        $attendance = $this->User_model->get_absensi($user_id, $month, $year);
        echo json_encode($attendance);
    }
}
