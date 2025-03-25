<?php
/**
 * Profile Controller - Handles user profile operations
 * 
 * Manages user profile retrieval and updates with security validation
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    /**
     * Constructor - Initializes database connection
     */
    public function __construct() {
        parent::__construct();
        $this->load->database(); // Load database connection
        $this->load->library('session'); // Load session library
    }

    // --------------------------------------------------------------------
    // PROFILE RETRIEVAL METHOD
    // --------------------------------------------------------------------

    /**
     * Get user profile data
     * 
     * @param int $user_id User ID to retrieve
     * @return array|bool User data array or false if not found/invalid
     */
    public function get_user_profile($user_id) {
        // Input validation - ensure numeric ID
        if (!is_numeric($user_id) || $user_id <= 0) {
            log_message('error', 'Invalid user ID requested: ' . $user_id);
            return false;
        }

        // Secure query with parameter binding
        $query = $this->db->get_where('users', ['id' => (int)$user_id], 1); // Limit 1 for safety
        
        // Return results
        return ($query->num_rows() === 1) ? $query->row_array() : false;
    }

    // --------------------------------------------------------------------
    // PROFILE UPDATE METHOD
    // --------------------------------------------------------------------

    /**
     * Update user profile information
     * 
     * @param int $user_id User ID to update
     * @param string $username New username
     * @param string $password New password (optional)
     * @return bool Update success status
     */
    public function update_user_profile($user_id, $username, $password) {
        // Validasi input
        if (!is_numeric($user_id)) {
            return false;
        }

        // Prepare update data
        $update_data = [
            'username' => html_escape($username), // XSS protection
            'updated_at' => date('Y-m-d H:i:s')   // Add update timestamp
        ];

        // Only update password if provided
        if (!empty($password)) {
            $update_data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        // Execute secure update
        $this->db->where('id', (int)$user_id);
        $result = $this->db->update('users', $update_data);

        // Handle result
        if ($result) {
            // Update session if current user updates their own profile
            if ($this->session->userdata('id') == $user_id) {
                $this->session->set_userdata('username', $username);
            }
            return true;
        }

        log_message('error', 'Profile update failed for user_id: ' . $user_id);
        return false;
    }
}