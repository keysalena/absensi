<?php
/**
 * User Model - Handles all database operations related to users
 * 
 * Manages user authentication, registration, attendance data, and user management
 */
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    /**
     * Constructor - Initializes the model
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // Load database connection
    }

    // --------------------------------------------------------------------
    // USER AUTHENTICATION METHODS
    // --------------------------------------------------------------------

    /**
     * Get user by username for login authentication
     * 
     * @param string $username Username to search
     * @return array|null User data array or null if not found
     */
    public function get_user_by_username($username)
    {
        return $this->db
            ->where('username', $username)
            ->limit(1) // Optimize query by limiting to 1 result
            ->get('users')
            ->row_array();
    }

    // --------------------------------------------------------------------
    // USER MANAGEMENT METHODS
    // --------------------------------------------------------------------

    /**
     * Get all non-admin users
     * 
     * @return array List of all regular users
     */
    public function get_all_users()
    {
        return $this->db
            ->where('role !=', 'admin')
            ->order_by('created_at', 'DESC') // Show newest users first
            ->get('users')
            ->result_array();
    }

    /**
     * Register new user with duplicate check
     * 
     * @param array $data User data including username, password, etc
     * @return bool|int Insert ID if successful, false if duplicate
     */
    public function register_user($data)
    {
        // Check for existing username
        $exists = $this->db
            ->where('username', $data['username'])
            ->limit(1)
            ->get('users')
            ->num_rows();

        if ($exists > 0) {
            return false; // Username exists
        }

        // Add timestamps
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        // Hash password if not already hashed
        if (isset($data['password']) && !password_needs_rehash($data['password'], PASSWORD_BCRYPT)) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }

        $this->db->insert('users', $data);
        return $this->db->insert_id(); // Return new user ID
    }

    // --------------------------------------------------------------------
    // ATTENDANCE METHODS
    // --------------------------------------------------------------------

    /**
     * Get user attendance records for specific month/year
     * 
     * @param int $user_id User ID
     * @param int $month Month (1-12)
     * @param int $year Year (YYYY)
     * @return array Attendance records
     */
    public function get_absensi($user_id, $month, $year)
    {
        return $this->db
            ->select('tanggal, waktu_masuk, waktu_pulang, log_kegiatan')
            ->from('absensi')
            ->where('user_id', (int)$user_id)
            ->where('MONTH(tanggal)', $month)
            ->where('YEAR(tanggal)', $year)
            ->order_by('tanggal', 'DESC')
            ->get()
            ->result_array();
    }
}