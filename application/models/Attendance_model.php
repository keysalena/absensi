<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Attendance_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_today_attendance($user_id, $date)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('tanggal', $date);
        return $this->db->get('absensi')->row_array();
    }

    public function get_monthly_attendance($user_id, $date_filter)
    {
        $this->db->where('user_id', $user_id);
        $this->db->like('tanggal', $date_filter, 'after');
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get('absensi')->result_array();
    }

    public function clock_in($user_id, $date, $time)
    {
        $data = [
            'user_id' => $user_id,
            'tanggal' => $date,
            'waktu_masuk' => $time
        ];
        $this->db->insert('absensi', $data);
    }

    public function clock_out($user_id, $date, $time, $log_kegiatan)
    {
        $data = [
            'waktu_pulang' => $time,
            'log_kegiatan' => $log_kegiatan
        ];
        $this->db->where('user_id', $user_id);
        $this->db->where('tanggal', $date);
        $this->db->update('absensi', $data);
    }
    public function special_attendance($user_id, $date, $type)
    {
        $data = [
            'user_id' => $user_id,
            'tanggal' => $date,
            'waktu_masuk' => $type,
            'waktu_pulang' => $type,
            'log_kegiatan' => '-'
        ];

        $existing_attendance = $this->db->get_where('absensi', ['user_id' => $user_id, 'tanggal' => $date])->row();

        if ($existing_attendance) {
            $this->db->where('id', $existing_attendance->id);
            $this->db->update('absensi', $data);
        } else {
            $this->db->insert('absensi', $data);
        }
    }
}
