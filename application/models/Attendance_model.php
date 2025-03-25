<?php
/**
 * Attendance Model - Handles all database operations for attendance tracking
 * 
 * Manages clock-in/clock-out operations and attendance data retrieval
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Attendance_model extends CI_Model
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
    // ATTENDANCE RETRIEVAL METHODS
    // --------------------------------------------------------------------

    /**
     * Get today's attendance record for a specific user
     * 
     * @param int $user_id User ID to check
     * @param string $date Date in YYYY-MM-DD format
     * @return array|null Single attendance record or null if not found
     */
    public function get_today_attendance($user_id, $date)
    {
        return $this->db
            ->where('user_id', (int)$user_id)  // Ensure integer type
            ->where('tanggal', $date)         // Filter by date
            ->get('absensi')
            ->row_array();                    // Return single record
    }

    /**
     * Get monthly attendance records for a specific user
     * 
     * @param int $user_id User ID to check
     * @param string $date_filter Year and month (YYYY-MM) to filter
     * @return array List of attendance records
     */
    public function get_monthly_attendance($user_id, $date_filter)
    {
        return $this->db
            ->where('user_id', (int)$user_id)          // Ensure integer type
            ->like('tanggal', $date_filter, 'after')   // Filter by month
            ->order_by('tanggal', 'DESC')              // Newest dates first
            ->get('absensi')
            ->result_array();                          // Return all records
    }

    // --------------------------------------------------------------------
    // ATTENDANCE OPERATION METHODS
    // --------------------------------------------------------------------

    /**
     * Record clock-in time for a user
     * 
     * @param int $user_id User ID
     * @param string $date Date in YYYY-MM-DD format
     * @param string $time Time in HH:MM:SS format
     * @return bool Insertion result
     */
    public function clock_in($user_id, $date, $time)
    {
        $data = [
            'user_id' => (int)$user_id,    // User ID
            'tanggal' => $date,            // Date of attendance
            'waktu_masuk' => $time,        // Clock-in time
            'created_at' => date('Y-m-d H:i:s') // Record creation timestamp
        ];
        
        return $this->db->insert('absensi', $data);
    }

    /**
     * Record clock-out time and activity log for a user
     * 
     * @param int $user_id User ID
     * @param string $date Date in YYYY-MM-DD format
     * @param string $time Time in HH:MM:SS format
     * @param string $log_kegiatan Activity description
     * @return bool Update result
     */
    public function clock_out($user_id, $date, $time, $log_kegiatan)
    {
        $data = [
            'waktu_pulang' => $time,       // Clock-out time
            'log_kegiatan' => $log_kegiatan, // Activity log
            'updated_at' => date('Y-m-d H:i:s') // Update timestamp
        ];
        
        return $this->db
            ->where('user_id', (int)$user_id)  // Filter by user
            ->where('tanggal', $date)         // Filter by date
            ->update('absensi', $data);       // Execute update
    }
}