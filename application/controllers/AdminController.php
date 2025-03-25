<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        // Load required resources
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->database(); // Load database connection

        // Security checks
        $this->_check_admin_access();
        $this->_check_ip_restriction();
    }

    /**
     * Check if user is logged in and has admin role
     * @private
     */
    private function _check_admin_access()
    {
        // Verify session and admin role
        if (!isset($this->session->user) || $this->session->user['role'] != 'admin') {
            redirect('login'); // Redirect to login if not authorized
        }
    }

    /**
     * Check if IP address is allowed
     * @private
     */
    private function _check_ip_restriction()
    {
        // List of allowed IP addresses
        $allowed_ips = ['103.79.246.93', '182.1.83.109', '::1']; // ::1 is localhost
        $user_ip = $this->input->ip_address();

        // Deny access if IP not in allowed list
        if (!in_array($user_ip, $allowed_ips)) {
            show_error('Akses ditolak: Anda tidak terhubung ke Wi-Fi yang diizinkan', 403);
        }
    }

    /**
     * Display admin dashboard with list of users
     */
    public function index()
    {
        // Get all users from database
        $data['users'] = $this->User_model->get_all_users();
        
        // Load view with user data
        $this->load->view('users_list', $data);
    }

    /**
     * Get attendance data via AJAX request
     * @return JSON response
     */
    public function get_absensi()
    {
        // Get parameters from GET request
        $user_id = $this->input->get('user_id');
        $month = $this->input->get('month');
        $year = $this->input->get('year');

        // Validate required parameters
        if (!$user_id || !$month || !$year) {
            echo json_encode([]);
            return;
        }

        // Get attendance data from model
        $attendance = $this->User_model->get_absensi($user_id, $month, $year);
        
        // Return JSON response
        echo json_encode($attendance);
    }
}