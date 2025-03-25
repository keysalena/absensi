<?php
/**
 * Register Controller - Handles user registration process
 * 
 * Manages user registration with IP restriction, input validation, and secure password handling
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    /**
     * Constructor - Loads required models, libraries and checks IP restriction
     */
    public function __construct()
    {
        parent::__construct();
        
        // Load required resources
        $this->load->model('User_model');      // User model for database operations
        $this->load->library('session');      // Session library for flash messages
        $this->load->database();              // Database connection
        
        // IP restriction configuration
        $allowed_ips = ['103.79.246.93', '182.1.83.109', '::1']; // ::1 is localhost
        $user_ip = $this->input->ip_address();

        // Check if user IP is allowed
        if (!in_array($user_ip, $allowed_ips)) {
            show_error('Access denied: Anda tidak terhubung ke Wi-Fi yang diizinkan', 403);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Display registration form
     */
    public function index()
    {
        // Load registration view
        $this->load->view('register');
    }

    // --------------------------------------------------------------------

    /**
     * Process registration form submission
     * 
     * Handles POST request, validates input, and creates new user account
     */
    public function process()
    {
        // Only proceed if request method is POST
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            redirect('register');
        }

        // Collect and sanitize form data
        $nama = $this->input->post('nama', true);       // XSS cleaned
        $username = $this->input->post('username', true); // XSS cleaned
        $role = $this->input->post('role', true);       // XSS cleaned
        
        // Basic input validation
        if (empty($nama) || empty($username) || empty($role) || empty($this->input->post('password'))) {
            $this->session->set_flashdata('error', 'All fields are required!');
            redirect('register');
        }

        // Hash password using secure algorithm
        $password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);

        // Prepare user data for database
        $user_data = [
            'nama' => $nama,
            'username' => $username,
            'password' => $password,
            'role' => $role, 
        ];

        // Attempt to register user
        $registration_result = $this->User_model->register_user($user_data);

        // Set appropriate flash message and redirect
        if ($registration_result) {
            $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login.');
            redirect('login');
        } else {
            $this->session->set_flashdata('error', 'Registrasi gagal! Username sudah digunakan.');
            redirect('register');
        }
    }
}