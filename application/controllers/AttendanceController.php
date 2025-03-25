<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * AttendanceController
 * 
 * Controller untuk manajemen absensi karyawan
 * - Clock in/out
 * - Riwayat absensi bulanan
 * - Validasi IP dan session
 */
class AttendanceController extends CI_Controller
{
    // Daftar IP yang diizinkan
    private $allowed_ips = ['103.79.246.93', '182.1.83.109', '::1'];
    
    // Format waktu yang valid
    private $time_format = '/^\d{2}:\d{2}:\d{2}$/';

    public function __construct()
    {
        parent::__construct();
        
        // Load dependencies
        $this->load->model('Attendance_model');  // Model untuk operasi absensi
        $this->load->helper(['url', 'form']);    // Helper URL dan form
        $this->load->database();                // Load database
        $this->load->library(['session', 'form_validation']); // Library session dan validasi

        // Validasi IP address
        $this->_validate_ip_access();

        // Cek autentikasi dan otorisasi user
        $this->_check_auth();
    }

    /**
     * Dashboard Absensi
     * 
     * Menampilkan:
     * - Absensi hari ini
     * - Riwayat bulanan
     * - Filter berdasarkan bulan
     */
    public function index()
    {
        try {
            $user = $this->session->userdata('user');
            $today = date('Y-m-d');
            
            // Data absensi hari ini
            $today_attendance = $this->Attendance_model->get_today_attendance($user['id'], $today);

            // Filter bulan
            $bulan_pilih = $this->input->post('bulan') ?? date('m');
            $date_filter = date('Y') . '-' . str_pad($bulan_pilih, 2, '0', STR_PAD_LEFT);

            // Data absensi bulanan
            $attendance_records = $this->Attendance_model->get_monthly_attendance(
                $user['id'], 
                $date_filter
            );

            // Siapkan data untuk view
            $data = [
                'user' => $user,
                'bulan_pilih' => $bulan_pilih,
                'bulan' => $this->_get_month_list(), // Daftar bulan
                'attendance_records' => $attendance_records,
                'today_attendance' => $today_attendance
            ];

            // Load view
            $this->load->view('layouts/header', $data);
            $this->load->view('attendance/dashboard', $data);
            $this->load->view('layouts/footer');

        } catch (Exception $e) {
            log_message('error', 'Error in AttendanceController index: '.$e->getMessage());
            show_error('Terjadi kesalahan saat memuat data absensi', 500);
        }
    }

    /**
     * Proses Absensi (Masuk/Pulang)
     * 
     * @param string $action Jenis absen (masuk/pulang)
     */
    public function process_absen($action)
    {
        try {
            // Validasi session
            if (!$this->session->userdata('user')) {
                redirect('login');
            }

            $user = $this->session->userdata('user');
            $time = $this->input->get('time');
            $date = date('Y-m-d');

            // Validasi format waktu
            if (!$time || !preg_match($this->time_format, $time)) {
                throw new Exception("Format waktu tidak valid");
            }

            switch ($action) {
                case 'masuk':
                    $this->_process_clock_in($user['id'], $date, $time);
                    break;
                    
                case 'pulang':
                    $log_kegiatan = $this->input->post('log_kegiatan');
                    $this->_process_clock_out($user['id'], $date, $time, $log_kegiatan);
                    break;
                    
                default:
                    throw new Exception("Aksi absen tidak valid");
            }

            redirect('attendance');

        } catch (Exception $e) {
            log_message('error', 'Absen Error: '.$e->getMessage());
            $this->session->set_flashdata('error', $e->getMessage());
            redirect('attendance');
        }
    }

    /*********************
     * PRIVATE METHODS
     *********************/

    /**
     * Validasi akses IP
     */
    private function _validate_ip_access()
    {
        $user_ip = $this->input->ip_address();
        if (!in_array($user_ip, $this->allowed_ips)) {
            log_message('error', 'IP Blocked: '.$user_ip);
            show_error('Akses ditolak: IP tidak diizinkan', 403);
        }
    }

    /**
     * Cek autentikasi user
     */
    private function _check_auth()
    {
        // Redirect admin ke halaman admin
        if ($this->session->user['role'] == 'admin') {
            redirect('admin');
        }

        // Redirect ke login jika tidak ada session
        if (!isset($this->session->user) || $this->session->user['role'] == 0) {
            redirect('login');
        }
    }

    /**
     * Proses clock in
     */
    private function _process_clock_in($user_id, $date, $time)
    {
        $this->Attendance_model->clock_in($user_id, $date, $time);
        $this->session->set_flashdata('success', 'Absen masuk berhasil!');
    }

    /**
     * Proses clock out
     */
    private function _process_clock_out($user_id, $date, $time, $log_kegiatan)
    {
        // Validasi log kegiatan
        $this->form_validation->set_rules('log_kegiatan', 'Log Kegiatan', 'required');
        
        if (!$this->form_validation->run()) {
            throw new Exception(validation_errors());
        }

        $this->Attendance_model->clock_out($user_id, $date, $time, $log_kegiatan);
        $this->session->set_flashdata('success', 'Absen pulang berhasil!');
    }

    /**
     * Daftar bulan
     */
    private function _get_month_list()
    {
        return [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April',   '05' => 'Mei',      '06' => 'Juni',
            '07' => 'Juli',    '08' => 'Agustus',  '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
    }
}