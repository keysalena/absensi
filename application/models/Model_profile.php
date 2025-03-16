<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // Memastikan database di-load
    }

    public function get_user_profile($user_id) {
        // Validasi input
        if (!is_numeric($user_id)) {
            return false;
        }

        // Query Binding untuk mencegah SQL Injection
        $query = $this->db->get_where('users', ['id' => $user_id]);
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function update_user_profile($user_id, $username, $password) {
        // Validasi input
        if (!is_numeric($user_id)) {
            return false;
        }

        $data = ['username' => $username];

        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        // Query Binding untuk mencegah SQL Injection
        $this->db->where('id', $user_id);
        $result = $this->db->update('users', $data);

        if ($result) {
            return true;
        } else {
            // Log error atau handle error sesuai kebutuhan
            log_message('error', 'Failed to update user profile for user_id: ' . $user_id);
            return false;
        }
    }
}