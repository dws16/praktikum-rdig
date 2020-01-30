<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    is_logged_in();
  }

  public function index()
  {
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['title'] = 'My Profile';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('profile/index', $data);
    $this->load->view('templates/footer');
  }

  public function edit()
  {
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['title'] = 'Edit Profile';

    $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
    $this->form_validation->set_rules('nrp', 'NRP', 'required|trim|exact_length[14]|numeric|is_unique[user.nrp]');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('profile/edit', $data);
      $this->load->view('templates/footer');
    } else {
      $name = $this->input->post('name');
      $email = $this->input->post('email');
      $nrp = $this->input->post('nrp');

      $this->db->set('name', $name);
      $this->db->set('nrp', $nrp);
      $this->db->where('email', $email);
      $this->db->update('user');

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Your profile has been updated!
            </div>');
      redirect(base_url('profile'));
    }
  }
}
