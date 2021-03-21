<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Praktikan extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    is_logged_in();
  }

  public function index()
  {
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['title'] = 'Dashboard';
    $id_kelompok = $this->db->get_where('kelompok_praktikan', ['IDUser' => $this->session->userdata('nrp')])->row_array();
    $data['kelompok'] = $this->db->get_where('kelompok', ['kelompokID' => $id_kelompok['IDKelompok']])->row_array();
    $data['anggota'] = $this->db->where('kelompok_praktikan.IDKelompok', $id_kelompok['IDKelompok'])
      ->join('user', 'user.nrp = kelompok_praktikan.IDUser')
      ->get('kelompok_praktikan')->result_array();

    $data['praktikum'] = $this->db->get_where('praktikum', ['IDType' => 1])->result_array();
    foreach ($data['praktikum'] as $key => $p) {
      $jadwal = $this->db->where('timeline_praktikum.praktikumID', $p['praktikumID'])
        ->join('timeline_praktikum', 'timeline_praktikum.dateID = timeline_presensi.dateID')
        ->get('timeline_presensi')->row_array();
      if ($jadwal) {
        $asisten = $this->db->where('IDKelompok', $id_kelompok['IDKelompok'])
          ->where('IDPraktikum', $jadwal['praktikumID'])
          ->join('user', 'user.nrp = kelompok_aslab.IDUser')
          ->get('kelompok_aslab')->row_array();
        if ($asisten) {
          $data['praktikum'][$key]['asisten'] = $asisten['name'];
        } else {
          $data['praktikum'][$key]['asisten'] = '-';
        }
        $data['praktikum'][$key]['date'] = human_shortdate_id(strtotime($jadwal['date']), 'datetime');
      } else {
        $data['praktikum'][$key]['date'] = 'JADWAL BELUM TERSEDIA';
        $data['praktikum'][$key]['asisten'] = '-';
      }
    }
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('praktikan/index', $data);
    $this->load->view('templates/footer');
  }

  public function modul_praktikum()
  {
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['title'] = 'Modul Praktikum';

    $data['modul'] = $this->db->get_where('praktikum', ['IDType' => 1])->result_array();
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('praktikan/kelengkapanpraktikum', $data);
    $this->load->view('templates/footer');
  }

  public function buku()
  {
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['title'] = 'Kelengkapan Buku';
    $data['buku'] = $this->db->get('filebuku')->result_array();
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('praktikan/buku', $data);
    $this->load->view('templates/footer');
  }

  public function penilaian()
  {
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['title'] = 'Penilaian';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('praktikan/penilaian', $data);
    $this->load->view('templates/footer');
  }
}
