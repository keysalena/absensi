<?php
/**
 * UserController - Controller untuk manajemen profil pengguna
 * 
 * Mengelola tampilan dan pembaruan profil pengguna dengan validasi dan keamanan
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {

    /**
     * Constructor - Load model yang diperlukan
     */
    public function __construct() {
        parent::__construct();
        // Load model profil pengguna dengan alias 'user_model'
        $this->load->model('Model_profile', 'user_model');
    }

    // --------------------------------------------------------------------

    /**
     * Menampilkan halaman profil pengguna
     * 
     * @return void Redirect ke login jika tidak ada sesi, atau tampilkan view profil
     */
    public function profile() {
        // Ambil ID pengguna dari sesi
        $user_id = $this->session->userdata('user_id');
        
        // Redirect ke halaman login jika tidak ada sesi pengguna
        if (!$user_id) {
            redirect('login');
        }

        // Ambil data profil dari model
        $data['user'] = $this->user_model->get_user_profile($user_id);
        
        // Muat view profil dengan data pengguna
        $this->load->view('profile', $data);
    }

    // --------------------------------------------------------------------

    /**
     * Memproses pembaruan profil pengguna
     * 
     * @return void Redirect ke halaman profil dengan pesan flash
     */
    public function update() {
        // Validasi sesi pengguna
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            redirect('login');
        }

        // Filter input untuk mencegah XSS
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password');
        
        // Validasi field wajib
        if (empty($username)) {
            $this->session->set_flashdata('error', 'Username wajib diisi.');
            redirect('profile');
        }

        // Data yang akan diupdate
        $update_data = ['username' => $username];

        // Hash password hanya jika diisi
        if (!empty($password)) {
            $update_data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        // Proses update dan beri feedback
        if ($this->user_model->update_user_profile($user_id, $update_data)) {
            // Perbarui data sesi jika username berubah
            $this->session->set_userdata('username', $username);
            $this->session->set_flashdata('success', 'Profil berhasil diperbarui!');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui profil. Data tidak berubah.');
        }

        redirect('profile');
    }
}