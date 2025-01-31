<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AttendanceController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Attendance_model');
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $allowed_ips = ['103.79.246.93', '182.1.83.109', '::1'];

        $user_ip = $this->input->ip_address();

        if (!in_array($user_ip, $allowed_ips)) {
            show_error('Akses ditolak: Anda tidak terhubung ke Wi-Fi yang diizinkan', 403);
        }
        if ($this->session->user['role'] == 'admin') {
            redirect('admin');
        }
        if (!isset($this->session->user) || $this->session->user['role'] == 0) {
            redirect('login');
        }
    }

    public function index()
    {
        if (!$this->session->userdata('user')) {
            redirect('login');
        }

        $user = $this->session->userdata('user');
        $today = date('Y-m-d');
        $today_attendance = $this->Attendance_model->get_today_attendance($user['id'], $today);

        $bulan_pilih = $this->input->post('bulan') ? $this->input->post('bulan') : date('m');
        $bulan = $this->get_month_list();
        $date_filter = date('Y') . '-' . str_pad($bulan_pilih, 2, '0', STR_PAD_LEFT);

        $attendance_records = $this->Attendance_model->get_monthly_attendance($user['id'], $date_filter);

        $data = [
            'user' => $user,
            'bulan_pilih' => $bulan_pilih,
            'bulan' => $bulan,
            'attendance_records' => $attendance_records,
            'today_attendance' => $today_attendance
        ];

        $this->load->view('attendance_dashboard', $data);
    }

    public function process_absen($action)
    {
        if (!$this->session->userdata('user')) {
            redirect('login');
        }

        $user = $this->session->userdata('user');
        $time = $this->input->get('time');
        $date = date('Y-m-d');
        $log_kegiatan = $this->input->post('log_kegiatan'); // Ambil log kegiatan dari input form

        if (!$time || !preg_match('/^\d{2}:\d{2}:\d{2}$/', $time)) {
            $this->session->set_flashdata('error', 'Waktu tidak valid!');
            redirect('attendance');
        }

        if ($action === 'masuk') {
            $this->Attendance_model->clock_in($user['id'], $date, $time);
            $this->session->set_flashdata('success', 'Berhasil absen masuk!');
        } elseif ($action === 'pulang') {
            if (empty($log_kegiatan)) {
                $this->session->set_flashdata('error', 'Log kegiatan wajib diisi!');
                redirect('attendance');
            }

            $this->Attendance_model->clock_out($user['id'], $date, $time, $log_kegiatan);
            $this->session->set_flashdata('success', 'Berhasil absen pulang!');
        } else {
            $this->session->set_flashdata('error', 'Aksi tidak valid!');
        }

        redirect('attendance');
    }

    private function get_month_list()
    {
        return [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];
    }
}
