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
    $data['title'] = 'Penilaian Aslab';
    $data['url'] = base_url('aslab/nilai');
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('aslab/penilaian', $data);
    $this->load->view('templates/footer');
  }
  public function nilai()
  {
    $param = [
      'praktikum' => $this->input->get('praktikum'),
      'praktikan' => $this->input->get('praktikan'),
      'aslab'     => $this->input->get('aslab'),
      'type'      => $this->input->get('type'),
    ];
    $result['result'] = $this->Aslab_model->getNilai($param);
    $result['param'] = $param;
    // !! Trouble in Client Side, Must be redirect page
    // $this->session->set_flashdata('praktikum', $data['praktikum']);
    // $this->session->set_flashdata('praktikan', $data['praktikan']);
    // $this->session->set_flashdata('aslab', $data['aslab']);

    header('Content-Type: application/json');
    echo json_encode( $result );
  }
  public function upsertnilai()
  {
    $paramPost = $this->input->post();
    $param['kriteria'] = [];
    $param['pelanggaran'] = [];
    $param['reset-pelanggaran'] = [];
    foreach ($paramPost as $key => $value) {
      $temp = explode("_",$key);
      if($temp[0] == 'kriteria'){
        $kriteria['penilaian'] = $temp[1];
        $kriteria['nilaiInsert'] = $value;
        $kriteria['nilaiUpdate'] = $value;
        array_push($param['kriteria'], $kriteria);
      }elseif($temp[0] == 'pelanggaran'){
        $pelanggaran['pelanggaran'] = $temp[1];
        array_push($param['pelanggaran'], $pelanggaran);
      }elseif($temp[0] == 'reset-pelanggaran'){
        $reset_pelanggaran['reset-pelanggaran'] = $temp[1];
        array_push($param['reset-pelanggaran'], $reset_pelanggaran);
      }else{
        $param[$key] = $value;
      }
    }
    $result = $this->Aslab_model->upsertNilai($param);
    // header('Content-Type: application/json');
    // echo json_encode( $param );
    // print_r($param);
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
    // $arrayWhere = array('p.status' => 1, 'k.status' => 1);
    $this->db->select('u.name AS praktikan, u.nrp AS nrpPraktikan, pr.nilai, p.*');
    $this->db->from('kelompok_aslab ka');
    $this->db->join('praktikum p', 'ka.IDPraktikum=p.PraktikumID', 'left');
    $this->db->join('kelompok k', 'ka.IDKelompok=k.kelompokID', 'left');
    $this->db->join('kelompok_praktikan kp', 'k.kelompokID=kp.IDKelompok', 'left');
    $this->db->join('user u', 'kp.IDUser=u.nrp', 'left');
    $this->db->join('penilaian_rekap pr', 'pr.IDUser=u.nrp AND pr.IDPraktikum=ka.IDPraktikum', 'left');
    // $this->db->where($arrayWhere);
    $this->db->get();
    $query['sql'] = $this->db->last_query();

    $sql = $query['sql']. ' WHERE p.status=1 AND k.status=1';
    $sqlPraktikum = $sql. " AND p.IDType=1";
    $sqlLapres = $sql. " AND p.IDType=2";
    $sqlFP = $sql. " AND p.IDType=3";

    $this->db->query($sqlPraktikum);
    $query['praktikum'] = $this->db->last_query();
    $this->db->query($sqlLapres);
    $query['lapres'] = $this->db->last_query();
    $this->db->query($sqlFP);
    $query['fp'] = $this->db->last_query();

    print_r($query);
    // print_r($this->db->last_query());
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
  public function aikresult()
  {
    $result['result'] = $this->Aslab_model->getPenilaian();
    // print_r($result);
    header('Content-Type: application/json');
    echo json_encode( $result );
  }
}
