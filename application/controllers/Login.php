<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->database(); // Load the database
        $allowed_ips = ['103.79.246.93', '182.1.83.109', '::1'];

        $user_ip = $this->input->ip_address();

        if (!in_array($user_ip, $allowed_ips)) {
            show_error('Akses ditolak: Anda tidak terhubung ke Wi-Fi yang diizinkan', 403);
        }
    }

    public function index()
    {
        $this->load->view('login');
    }

    public function process()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            // Check the credentials using the model
            $user = $this->User_model->get_user_by_username($username);

            if ($user && password_verify($password, $user['password'])) {
                // Store user data in session
                $this->session->set_userdata('user', $user);

                // Check role and redirect accordingly
                if ($user['role'] == 'admin') {
                    redirect('admin'); // Redirect to the admin page
                } else {
                    redirect('attendance'); // Redirect to the regular dashboard
                }
            } else {
                $this->session->set_flashdata('error', 'Username or password is incorrect!');
                redirect('login');
            }
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('user');
        redirect('login');
    }
}
?>
