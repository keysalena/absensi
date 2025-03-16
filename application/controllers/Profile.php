<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Model_profile', 'user_model');
    }

    public function profile() {
        $user_id = $this->session->userdata('user_id');
        
        if (!$user_id) {
            redirect('login');
        }

        $data['user'] = $this->user_model->get_user_profile($user_id);
        
        $this->load->view('profile', $data);
    }

    public function update() {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            redirect('login');
        }
       $username = $this->input->post('username', true);
        $password = $this->input->post('password');       
        if (empty($username)) {
            $this->session->set_flashdata('error', 'All fields are required.');
            redirect('profile');
        }
        $update_data = [
            'username' => $username
        ];
        if (!empty($password)) {
            $update_data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }
        if ($this->user_model->update_user_profile($user_id, $update_data)) {
            $this->session->set_flashdata('success', 'Profile updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update profile.');
        }

        redirect('profile');
    }
}
