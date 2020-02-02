<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    is_logged_in();
  }

  public function index($id = '')
  {
    #USER#
    $this->load->model('User_model');
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['list'] = $this->db->get('user')->result_array();
    $data['detail'] = $this->db->get_where('user', ['id' => $id])->row_array();
    if ($this->db->get_where('praktikan', ['id' => $id])) {
      $data['praktikan'] = $this->db->get_where('praktikan', ['id' => $id])->row_array();
    }

    if ($this->input->post('keyword')) {
      $data['list'] = $this->User_model->CariUser();
    }
    $data['title'] = 'User List';

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('admin/index', $data);
    $this->load->view('templates/footer');
  }

  public function delete($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('user');
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        User has been deleted!
        </div>');
    redirect(base_url('admin/user_list'));
  }

  public function getdetail()
  {
    echo json_encode($this->db->get_where('user', ['id' => $this->input->post('id')])->row_array());
  }

  public function getubah()
  {
    echo json_encode($this->db->get_where('user', ['id' => $this->input->post('id')])->row_array());
  }

  public function edit()
  {
    $data = [
      "name" => $this->input->post('name', true),
      "email" => $this->input->post('email', true),
      "role_id" => $this->input->post('role_id', true)
    ];

    $this->db->where('id', $this->input->post('id'));
    $this->db->update('user', $data);
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        User data has been edited!
        </div>');
    redirect(base_url('admin/user_list'));
  }
  #USER END#

  #ROLE#
  public function role()
  {
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['title'] = 'Role';

    $data['role'] = $this->db->get('user_role')->result_array();

    $this->form_validation->set_rules('role', 'Role', 'required');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('admin/role', $data);
      $this->load->view('templates/footer');
    } else {
      $this->db->insert('user_role', ['role' => $this->input->post('role')]);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            New role added!
            </div>');
      redirect(base_url('admin/role'));
    }
  }

  public function editrole()
  {
    $data = [
      "role" => $this->input->post('role', true)
    ];

    $this->db->where('id', $this->input->post('id'));
    $this->db->update('user_role', $data);
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Role has been edited!
        </div>');
    redirect(base_url('admin/role'));
  }

  public function getubahrole()
  {
    echo json_encode($this->db->get_where('user_role', ['id' => $this->input->post('id')])->row_array());
  }

  public function deleterole($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('user_role');
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Role has been deleted!
        </div>');
    redirect(base_url('admin/role'));
  }

  public function roleAccess($role_id)
  {
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['title'] = 'Role Access';

    $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

    $data['menu'] = $this->db->get('user_menu')->result_array();

    $this->form_validation->set_rules('role', 'Role', 'required');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('admin/role-access', $data);
      $this->load->view('templates/footer');
    } else {
      $this->db->insert('user_role', ['role' => $this->input->post('role')]);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            New role added!
            </div>');
      redirect(base_url('admin/role'));
    }
  }

  public function changeaccess()
  {
    $menu_id = $this->input->post('menuId');
    $role_id = $this->input->post('roleId');

    $data = [
      'role_id' => $role_id,
      'menu_id' => $menu_id
    ];

    $result = $this->db->get_where('user_access_menu', $data);

    if ($result->num_rows() < 1) {
      $this->db->insert('user_access_menu', $data);
    } else {
      $this->db->delete('user_access_menu', $data);
    }
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Access changed!
            </div>');
  }
  #ROLE END#

}
