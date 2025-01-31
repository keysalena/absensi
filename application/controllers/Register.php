<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load the User model
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->database(); // Load the databas
        $allowed_ips = ['103.79.246.93', '182.1.83.109', '::1'];

        $user_ip = $this->input->ip_address();

        if (!in_array($user_ip, $allowed_ips)) {
            show_error('Akses ditolak: Anda tidak terhubung ke Wi-Fi yang diizinkan', 403);
        }
    }

    public function index()
    {
        // Load the registration view
        $this->load->view('register');
    }

    public function process()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $nama = $this->input->post('nama');
            $username = $this->input->post('username');
            $role = $this->input->post('role');
            $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

            // Prepare data to be inserted into the database
            $data = [
                'nama' => $nama,
                'username' => $username,
                'password' => $password,
                'role' => $role, 
            ];

            // Call the model function to insert user data
            $result = $this->User_model->register_user($data);

            if ($result) {
                $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login.');
                redirect('login');
            } else {
                $this->session->set_flashdata('error', 'Registrasi gagal! Username sudah digunakan.');
                redirect('register');
            }
        }
    }
}
?>
