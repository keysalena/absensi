<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_user_by_username($username)
    {
        // Query the database for the user with the provided username
        $this->db->where('username', $username);
        $query = $this->db->get('users');

        // Return the result if any
        return $query->row_array();
    }
    public function get_all_users()
    {
        $this->db->where('role !=', 'admin');
        $query = $this->db->get('users');
        return $query->result_array();
    }

    public function get_absensi($user_id, $month, $year)
    {
        $this->db->select('tanggal, waktu_masuk, waktu_pulang, log_kegiatan');
        $this->db->from('absensi');
        $this->db->where('user_id', $user_id);
        $this->db->where('MONTH(tanggal)', $month);
        $this->db->where('YEAR(tanggal)', $year);
        $this->db->order_by('tanggal', 'DESC');
        $query = $this->db->get();

        return $query->result_array();
    }
    public function register_user($data)
    {
        // Check if the username already exists
        $this->db->where('username', $data['username']);
        $query = $this->db->get('users');

        if ($query->num_rows() > 0) {
            // Username already exists
            return false;
        }

        // Insert the new user data into the database
        return $this->db->insert('users', $data);
    }
}
