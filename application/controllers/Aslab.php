<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aslab extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    is_logged_in();
    $this->load->model('Aslab_model');
  }

  public function index()
  {
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['title'] = 'Dashboard';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('aslab/index', $data);
    $this->load->view('templates/footer');
  }

  public function penilaian()
  {
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['result'] = $this->Aslab_model->getPenilaian();
    $data['title'] = 'Penilaian Praktikum';
    $data['url'] = base_url('aslab/nilai');
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('aslab/penilaian', $data);
    $this->load->view('templates/footer');
  }
  public function nilai()
  {
    $data = [
      'praktikum' => $this->input->get('praktikum'),
      'praktikan' => $this->input->get('praktikan'),
      'aslab'     => $this->input->get('aslab'),
    ];
    $result['result'] = $this->Aslab_model->getNilai($data);
    $result['data'] = $data;
    // !! Trouble in Client Side, Must be redirect page
    // $this->session->set_flashdata('praktikum', $data['praktikum']);
    // $this->session->set_flashdata('praktikan', $data['praktikan']);
    // $this->session->set_flashdata('aslab', $data['aslab']);

    header('Content-Type: application/json');
    echo json_encode( $result );
  }
  public function upsertnilai()
  {
    $data = $this->input->post();
    $param['kriteria'] = [];
    foreach ($data as $key => $value) {
      $temp = explode("_",$key);
      if($temp[0] == 'kriteria'){
        $item['penilaian'] = $temp[1];
        $item['nilaiInsert'] = $value;
        $item['nilaiUpdate'] = $value;
        array_push($param['kriteria'], $item);
      }else{
        $param[$key] = $value;
      }
    }
    $result = $this->Aslab_model->upsertNilai($param);
    if($result) {
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">BERHASIL memberikan penilaian!</div>');
      redirect(base_url('aslab/penilaian'));
    }else{
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">GAGAL melakukan perubahan nilai!</div>');
      redirect(base_url('aslab/penilaian'));
    }
  }


  // ! TEST API for Aik
  public function aik()
  {
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['title'] = 'Test Page';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('aslab/test', $data);
    $this->load->view('templates/footer');
  }
  public function aiksql()
  {
    $data = [
      'praktikum' => $this->input->get('praktikum'),
      'praktikan' => $this->input->get('praktikan'),
      'aslab'     => $this->input->get('aslab'),
    ];
    $this->db->from('penilaian');
    $query = $this->db->get();
    $arr = $query->result();
    $result = [];
    $next = false;
    foreach ($arr as $item) {
      $this->db->select('nilai');
      $this->db->from('penilaian_praktikum');
      $this->db->where('IDPenilaian', $item->penilaianID);
      $this->db->where('IDPraktikum', $data['praktikum']);
      $this->db->where('praktikan', $data['praktikan']);
      $this->db->where('aslab', $data['aslab']);
      $query = $this->db->get();
      $arr1 = $query->result();
    }
    print_r($this->db->last_query());
  }
  public function aikarray()
  {
    $data = [
      'praktikum' => $this->input->get('praktikum'),
      'praktikan' => $this->input->get('praktikan'),
      'aslab'     => $this->input->get('aslab'),
    ];
    $this->db->from('penilaian');
    $query = $this->db->get();
    $arr = $query->result();
    $result = [];
    $next = false;
    foreach ($arr as $item) {
      $this->db->select('nilai');
      $this->db->from('penilaian_praktikum');
      $this->db->where('IDPenilaian', $item->penilaianID);
      $this->db->where('IDPraktikum', $data['praktikum']);
      $this->db->where('praktikan', $data['praktikan']);
      $this->db->where('aslab', $data['aslab']);
      $query = $this->db->get();
      $arr1 = $query->result();

      if(count($arr1) > 0){
        $arr_merge = array_merge((array) $item, (array) $arr1[0]);
        $next = true;
      }elseif(count($arr1) == 0){
        $arr_merge = $item;
        $next = false;
      }
      if($next) array_push($result, (array) $arr_merge);
    }
    print_r($result);
  }
}
