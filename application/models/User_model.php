<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
  public function CariUser()
  {
    $keyword = $this->input->post('keyword', true);

    $this->db->like('name', $keyword);
    $this->db->or_like('email', $keyword);
    $this->db->or_like('nrp', $keyword);
    $this->db->or_like('role_id', $keyword);

    return $this->db->get('user')->result_array();
  }
}
