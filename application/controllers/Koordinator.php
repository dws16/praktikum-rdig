<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Koordinator extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    is_logged_in();
  }

  //Function Pembagian Kelompok
  public function kelompok()
  {
    $this->load->model('Koordinator_model');
    $data['kelompok'] = $this->Koordinator_model->listkelompok();
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['title'] = 'Pembagian Kelompok';

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('koordinator/kelompok', $data);
    $this->load->view('templates/footer');
  }
  public function checknamakelompok()
  {
    $name = $this->input->post('namakelompok', true);
    $cek = $this->db->get_where('kelompok', ['name' => $name])->row_array();

    if ($cek) {
      echo json_encode("ada");
    } else {
      echo json_encode("tidak");
    }
  }
  public function addkelompok()
  {
    $data = [
      'name' => $this->input->post('kelompok'),
      'year' => $this->input->post('year'),
      'term' => $this->input->post('term'),
      'status' => $this->input->post('status')
    ];
    if ($this->db->insert('kelompok', $data)) {
      if ($this->input->post('nrp')) {
        $kel_id = $this->db->get_where('kelompok', ['name' => $data['name']])->row_array();
        foreach ($this->input->post('nrp') as $nrp) {
          if ($this->db->get_where('kelompok_praktikan', ['IDUser' => $nrp])->row_array()) {
            continue;
          }
          $data_kel = [];
          $data_kel = [
            'IDKelompok' => $kel_id['kelompokID'],
            'IDUser' => $nrp
          ];
          $this->db->insert('kelompok_praktikan', $data_kel);
        }
      }
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Kelompok berhasil ditambahkan!</div>');
      redirect(base_url('koordinator/kelompok'));
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Kelompok gagal ditambahkan!</div>');
      redirect(base_url('koordinator/kelompok'));
    }
  }
  public function checknrpkelompok()
  {
    $this->load->model('Koordinator_model');
    $cek = $this->Koordinator_model->ceknrpkelompok($this->input->post('nrp'), $this->input->post('id_kel'));
    if ($cek) {
      echo json_encode("Sudah masuk");
    } else {
      $ada = $this->db->get_where('user', ['nrp' => $this->input->post('nrp'), 'role_id' => 4])->row_array();
      if ($ada) {
        echo json_encode($ada['name']);
      } else {
        echo json_encode("Tidak ada");
      }
    }
  }
  public function getdetailkelompok()
  {
    $this->load->model('Koordinator_model');
    echo json_encode($this->Koordinator_model->detailkelompok($this->input->post('id')));
  }
  public function editkelompok()
  {
    $data = [
      'name' => $this->input->post('kelompok'),
      'year' => $this->input->post('year'),
      'term' => $this->input->post('term'),
      'status' => $this->input->post('status')
    ];

    $this->db->where('kelompokID', $this->input->post('id'));
    $this->db->update('kelompok', $data);

    $this->db->where('IDKelompok', $this->input->post('id'));
    $this->db->delete('kelompok_praktikan');
    foreach ($this->input->post('nrp') as $nrp) {
      $data_kel = [];
      $data_kel = [
        'IDKelompok' => $this->input->post('id'),
        'IDUser' => $nrp
      ];

      $this->db->insert('kelompok_praktikan', $data_kel);
    }

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Kelompok berhasil diubah!</div>');
    redirect(base_url('koordinator/kelompok'));
  }
  public function deletekelompok($id)
  {
    $this->db->where('kelompokID', $id);
    $this->db->delete('kelompok');

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Kelompok berhasil dihapus!</div>');
    redirect(base_url('koordinator/kelompok'));
  }
  //End of Function Pembagian Kelompok

  //Function Pembagian Asisten
  public function asisten()
  {
    $this->load->model('Koordinator_model');
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['title'] = 'Pembagian Asisten';
    $this->db->where('status', 1);
    $this->db->order_by('IDType', 'ASC');
    $data['modul'] = $this->db->get('praktikum')->result_array();
    $data['kelompok'] = $this->db->get_where('kelompok', ['status' => 1])->result_array();
    $data['kelompok_asisten'] = $this->Koordinator_model->listkelompok_asisten();
    $this->db->where_not_in('role_id', array(4));
    $data['asisten'] = $this->db->get('user')->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('koordinator/asisten', $data);
    $this->load->view('templates/footer');
  }
  public function getdetailkelompok_asisten()
  {
    $this->load->model('Koordinator_model');
    $kelompok = $this->input->post('kelompok');
    $modul = $this->db->get_where('praktikum', ['praktikumID' => $this->input->post('modul')])->row_array();
    $ada = $this->Koordinator_model->detailkelompok_asisten($kelompok, $this->input->post('modul'));
    if ($ada) {
      echo json_encode($ada);
    } else {
      $kel = $this->db->get_where('kelompok', ['kelompokID' => $kelompok])->row_array();
      $data = [
        'kelompok' => $kel['name'],
        'praktikumID' => $modul['praktikumID'],
        'modul' => $modul['name']
      ];
      echo json_encode($data);
    }
  }
  public function getdetailkelompok_asistenFP()
  {
    $this->load->model('Koordinator_model');
    $kelompok = $this->input->post('kelompok');
    $modul = $this->db->get_where('praktikum', ['praktikumID' => $this->input->post('modul')])->row_array();
    $ada = $this->Koordinator_model->detailkelompok_asistenFP($kelompok, $this->input->post('modul'));
    if ($ada) {
      echo json_encode($ada);
    } else {
      $kel = $this->db->get_where('kelompok', ['kelompokID' => $kelompok])->row_array();
      $data = [
        'kelompok' => $kel['name'],
        'praktikumID' => $modul['praktikumID'],
        'modul' => $modul['name']
      ];
      echo json_encode($data);
    }
  }

  public function editasistenFP()
  {
    $kelompok = $this->input->post('kelompok');
    $kelompok = $this->db->get_where('kelompok', ['name' => $kelompok])->row_array();
    $modul = $this->input->post('modul');

    $this->db->where('IDKelompok', $kelompok['kelompokID']);
    $this->db->where('IDPraktikum', $this->input->post('id'));
    $this->db->delete('kelompok_aslab');

    foreach ($this->input->post('nrpAsisten') as $nrp) {
      $data = [
        'IDPraktikum' => $this->input->post('id'),
        'IDKelompok' => $kelompok['kelompokID'],
        'IDUser' => $nrp
      ];
      $this->db->insert('kelompok_aslab', $data);
    }
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
             Asisten berhasil diubah!
              </div>');
    redirect(base_url('koordinator/asisten'));
  }

  public function cekasisten()
  {
    $this->db->where_not_in('role_id', array(4));
    $this->db->where('nrp', $this->input->post('nrp'));
    $ada = $this->db->get('user')->row_array();
    if ($ada) {
      echo json_encode($ada);
    } else {
      echo json_encode("Tidak");
    }
  }
  public function editasisten()
  {
    $modul = $this->input->post('id');
    $kelompok = $this->input->post('kelompok');
    $kelompok = $this->db->get_where('kelompok', ['name' => $kelompok])->row_array();
    $ada = $this->db->get_where('kelompok_aslab', ['IDPraktikum' => $modul, 'IDKelompok' => $kelompok['kelompokID']])->row_array();
    if ($ada) {
      $this->db->where('IDPraktikum', $modul);
      $this->db->where('IDKelompok', $kelompok['kelompokID']);
      $this->db->update('kelompok_aslab', ['IDUser' => $this->input->post('nrp')]);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
             Asisten berhasil diubah!
              </div>');
      redirect(base_url('koordinator/asisten'));
    } else {
      $data = [
        'IDKelompok' => $kelompok['kelompokID'],
        'IDUser' => $this->input->post('nrp'),
        'IDPraktikum' => $modul
      ];
      $this->db->insert('kelompok_aslab', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
      Asisten berhasil ditambahkan!
      </div>');
      redirect(base_url('koordinator/asisten'));
    }
  }
  //End of Function Pembagian Asisten

  public function praktikan()
  {
    $this->load->model('Koordinator_model');
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['title'] = 'Data Praktikan';
    $data['list'] = $this->Koordinator_model->listpraktikan();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('koordinator/praktikan', $data);
    $this->load->view('templates/footer');
  }

  public function deletePraktikan()
  {
    $jumlah = $this->db->get_where('user', ['role_id' => 4])->num_rows();
    $this->db->where('role_id', 4);
    $this->db->delete('user');

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'
      . $jumlah . ' data praktikan berhasil dihapus!
      </div>');
    redirect(base_url('koordinator/praktikan'));
  }

  //Function Modul
  public function modul()
  {
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['title'] = 'Manajemen Modul';
    $data['list'] = $this->db->get_where('praktikum', ['IDType' => 1])->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('koordinator/modul', $data);
    $this->load->view('templates/footer');
  }
  public function addmodul()
  {
    $ext = explode(".", $_FILES['filepraktikum']['name']);
    $_FILES['filepraktikum']['name'] = $this->input->post('modul') . "_" . time() . "." . end($ext);


    $config['upload_path'] = './assets/file/praktikum/';
    $config['allowed_types'] = 'pdf';

    $this->load->library('upload', $config);

    if ($this->upload->do_upload('filepraktikum')) {

      $new_file = $this->upload->data('file_name');

      $this->db->set('filename', $new_file);
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
      redirect(base_url('koordinator/modul'));
    }

    if ($this->input->post('status')) {
      $status = 1;
    } else {
      $status = 0;
    }

    $this->db->set('name', $this->input->post('modul'));
    $this->db->set('title', $this->input->post('title'));
    $this->db->set('description', $this->input->post('desc'));
    $this->db->set('status', $status);
    $this->db->set('IDType', 1);
    $this->db->insert('praktikum');

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Modul berhasil ditambahkan!</div>');
    redirect(base_url('koordinator/modul'));
  }
  public function geteditmodul()
  {
    echo json_encode($this->db->get_where('praktikum', ['praktikumID' => $this->input->post('id')])->row_array());
  }
  public function editmodul()
  {
    $modul_id = $this->input->post('id');
    $file = $_FILES['filepraktikum']['name'];

    $lama = $this->db->get_where('praktikum', ['praktikumID' => $modul_id])->row_array();

    if ($file) {
      unlink(FCPATH . 'assets/file/praktikum/' . $lama['filename']);

      $ext = explode(".", $_FILES['filepraktikum']['name']);
      $_FILES['filepraktikum']['name'] = $this->input->post('modul') . "_" . time() . "." . end($ext);

      $config['upload_path'] = './assets/file/praktikum/';
      $config['allowed_types'] = 'pdf';

      $this->load->library('upload', $config);

      if ($this->upload->do_upload('filepraktikum')) {

        $new_file = $this->upload->data('file_name');

        $this->db->set('filename', $new_file);
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
        redirect(base_url('koordinator/modul'));
      }
    }

    if ($this->input->post('status')) {
      $status = 1;
    } else {
      $status = 0;
    }

    $this->db->set('name', $this->input->post('modul'));
    $this->db->set('title', $this->input->post('title'));
    $this->db->set('description', $this->input->post('desc'));
    $this->db->set('status', $status);
    $this->db->where('praktikumID', $modul_id);
    $this->db->update('praktikum');

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Modul berhasil diubah!</div>');
    redirect(base_url('koordinator/modul'));
  }
  public function deletemodul($id)
  {
    $modul = $this->db->get_where('praktikum', ['praktikumID' => $id])->row_array();
    $loc = FCPATH . 'assets/file/praktikum/' . $modul['filename'];
    if (file_exists($loc)) {
      unlink($loc);
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">File modul tidak ditemukan!</div>');
      redirect(base_url('koordinator/modul'));
    }

    $this->db->where('praktikumID', $id);
    $this->db->delete('praktikum');

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Modul berhasil dihapus!</div>');
    redirect(base_url('koordinator/modul'));
  }
  //End of Function Modul

  // Function Kelengkapan Buku
  public function buku()
  {
    $data['file'] = $this->db->get('filebuku')->result_array();
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['title'] = 'Kelengkapan Buku';

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('koordinator/buku', $data);
    $this->load->view('templates/footer');
  }
  public function geteditfilebuku()
  {
    echo json_encode($this->db->get_where('filebuku', ['id' => $this->input->post('id')])->row_array());
  }
  public function addfilebuku()
  {
    $nama = $this->input->post('namafile');
    $file = $_FILES['filebuku']['name'];

    if ($file) {
      $config['upload_path'] = './assets/file/buku/';
      $config['allowed_types'] = 'gif|jpg|png|pdf|cdr|rar|zip|docx';

      $this->load->library('upload', $config);

      if ($this->upload->do_upload('filebuku')) {

        $new_file = $this->upload->data('file_name');

        $this->db->set('filename', $new_file);
        $this->db->set('name', $nama);
        $this->db->insert('filebuku');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">File berhasil ditambahkan!</div>');
        redirect(base_url('koordinator/buku'));
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
        redirect(base_url('koordinator/buku'));
      }
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Harap tambahkan file!</div>');
      redirect(base_url('koordinator/buku'));
    }
  }
  public function editfilebuku()
  {
    $nama = $this->input->post('namafile');
    $file = $_FILES['filebuku']['name'];

    $lama = $this->db->get_where('filebuku', ['id' => $this->input->post('id')])->row_array();

    if ($file) {
      unlink(FCPATH . 'assets/file/prakitkum/' . $lama['filename']);
      $config['upload_path'] = './assets/file/buku/';
      $config['allowed_types'] = 'gif|jpg|png|pdf|cdr|rar|zip|docx';

      $this->load->library('upload', $config);

      if ($this->upload->do_upload('filebuku')) {

        $new_file = $this->upload->data('file_name');

        $this->db->set('filename', $new_file);
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
        redirect(base_url('koordinator/buku'));
      }
    }

    $this->db->set('name', $nama);
    $this->db->where('id', $this->input->post('id'));
    $this->db->update('filebuku');

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">File berhasil diubah!</div>');
    redirect(base_url('koordinator/buku'));
  }
  public function deletefilebuku($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('filebuku');

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">File berhasil dihapus!</div>');
    redirect(base_url('koordinator/buku'));
  }
  // End of Function Kelengkapan Buku

  //Function Penjadwalan
  public function penjadwalan()
  {
    $this->load->model('Koordinator_model');
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['title'] = 'Penjadwalan';
    $data['sesi'] = $this->Koordinator_model->listsesi();
    $data['modul'] = $this->db->get_where('praktikum', ['status' => 1])->result_array();
    $data['jadwalKelompok'] = $this->Koordinator_model->jadwalkelompok();
    $data['listKelompok'] = $this->db->get_where('kelompok', ['status' => 1])->result_array();
    $data['listJadwal'] = $this->db->get('timeline_praktikum');
    $data['listJaga'] = $this->Koordinator_model->listjaga();
    $data['listPraktikan'] = $this->Koordinator_model->jadwalpraktikan();
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('koordinator/penjadwalan', $data);
    $this->load->view('templates/footer');
  }
  public function addsesi()
  {
    $data = [
      'date' => $this->input->post('date'),
      'praktikumID' => $this->input->post('praktikumID'),
      'ket' => $this->input->post('ket')
    ];

    $this->db->insert('timeline_praktikum', $data);
    $this->session->set_flashdata('messageSesi', '<div class="alert alert-success" role="alert">Jadwal berhasil ditambahkan!</div>');
    redirect(base_url('koordinator/penjadwalan'));
  }
  public function geteditsesi()
  {
    $this->load->model('Koordinator_model');

    echo json_encode($this->Koordinator_model->listsesi($this->input->post('id')));
  }
  public function editsesi()
  {
    $data = [
      'date' => $this->input->post('date'),
      'praktikumID' => $this->input->post('praktikumID'),
      'ket' => $this->input->post('ket')
    ];
    $this->db->where('dateID', $this->input->post('id'));
    $this->db->update('timeline_praktikum', $data);
    $this->session->set_flashdata('messageSesi', '<div class="alert alert-success" role="alert">Jadwal berhasil diubah!</div>');
    redirect(base_url('koordinator/penjadwalan'));
  }
  public function deletesesi($id)
  {
    $this->db->where('dateID', $id);
    $this->db->delete('timeline_praktikum');

    $this->session->set_flashdata('messageSesi', '<div class="alert alert-success" role="alert">Jadwal berhasil dihapus!</div>');
    redirect(base_url('koordinator/penjadwalan'));
  }
  public function getlistjadwal()
  {
    $id = $this->input->post('modul');
    $ada = $this->db->get_where('timeline_praktikum', ['praktikumID' => $id])->result_array();
    if ($ada) {
      echo json_encode($ada);
    } else {
      echo json_encode("Belum");
    }
  }
  public function cekjadwalkelompok()
  {
    $this->load->model('Koordinator_model');
    $modul = $this->input->post('modul');
    $kelompok = $this->input->post('kelompok');
    $ada = $this->Koordinator_model->cekjadwalkelompok($modul, $kelompok);
    if ($ada) {
      echo json_encode("Sudah");
    } else {
      echo json_encode("Belum");
    }
  }
  public function addjadwalkelompok()
  {
    $this->load->model('Koordinator_model');
    $data = [
      'dateID' => $this->input->post('dateID'),
      'kelompokID' => $this->input->post('kelompokID')
    ];
    $this->db->insert('timeline_presensi_kelompok', $data);

    $praktikan = $this->db->get_where('kelompok_praktikan', ['IDKelompok' => $data['kelompokID']])->result_array();
    foreach ($praktikan as $p) {
      $presensi = [];
      $ada = $this->Koordinator_model->cekjadwalpraktikan($this->input->post('IDPraktikum'), $p['IDUser']);
      if ($ada) {
        $presensi = [
          'dateID' => $data['dateID']
        ];
        $this->db->where('id', $ada['id']);
        $this->db->update('timeline_presensi', $presensi);
      } else {
        $cek = $this->db->get_where('timeline_praktikum', ['praktikumID' => $this->input->post('IDpraktikum')])->result_array();
        foreach ($cek as $c) {
          $sudah = $this->db->get_where('timeline_presensi', ['dateID' => $c['dateID'], 'nrp' => $p['IDUser']])->row_array();

          if ($sudah) {
            $presensi = [
              'dateID' => $data['dateID']
            ];
            $this->db->where('id', $sudah['id']);
            $this->db->update('timeline_presensi', $presensi);
          } else {
            if ($c['dateID'] == $data['dateID']) {
              continue;
            }
            $presensi = [
              'dateID' => $data['dateID'],
              'nrp' => $p['IDUser']
            ];
            $this->db->insert('timeline_presensi', $presensi);
          }
        }
      }
    }
    $this->session->set_flashdata('messageKelompok', '<div class="alert alert-success" role="alert">Jadwal Kelompok berhasil ditambahkan!</div>');
    redirect(base_url('koordinator/penjadwalan'));
  }
  public function getdetailjadwalkelompok()
  {
    $this->load->model('Koordinator_model');

    echo json_encode($this->Koordinator_model->detailjadwalkelompok($this->input->post('id')));
  }
  public function editjadwalkelompok()
  {
    $data = [
      'dateID' => $this->input->post('dateID'),
    ];
    $kelompok = $this->db->get_where('timeline_presensi_kelompok', ['id' => $this->input->post('jadwalkelompokID')])->row_array();
    $praktikan = $this->db->get_where('kelompok_praktikan', ['IDKelompok' => $kelompok['kelompokID']])->result_array();
    $cek = $this->db->get_where('timeline_praktikum', ['praktikumID' => $this->input->post('IDModul')])->result_array();
    $this->db->where('id', $kelompok['id']);
    $this->db->update('timeline_presensi_kelompok', $data);
    $i = 0;
    foreach ($praktikan as $p) {
      foreach ($cek as $c) {
        $ada = $this->db->get_where('timeline_presensi', ['dateID' => $c['dateID'], 'nrp' => $p['IDUser']])->row_array();
        $presensi = [];
        if ($ada) {
          $presensi = [
            'dateID' => $data['dateID']
          ];
          $this->db->where('dateID', $c['dateID']);
          $this->db->where('nrp', $p['IDUser']);
          $this->db->update('timeline_presensi', $presensi);
          $i = 1;
        }
      }
    }
    if ($i == 0) {
      $presensi = [
        'dateID' => $data['dateID'],
        'nrp' => $p['IDUser']
      ];
      $this->db->insert('timeline_presensi', $presensi);
    }
    $this->session->set_flashdata('messageKelompok', '<div class="alert alert-success" role="alert">Jadwal Kelompok berhasil diubah!</div>');
    redirect(base_url('koordinator/penjadwalan'));
  }
  public function deletejadwalkelompok($id)
  {
    $kelompok = $this->db->get_where('timeline_presensi_kelompok', ['id' => $id])->row_array();
    $praktikan = $this->db->get_where('kelompok_praktikan', ['IDKelompok' => $kelompok['kelompokID']])->result_array();
    foreach ($praktikan as $p) {
      $this->db->where('dateID', $kelompok['dateID']);
      $this->db->where('nrp', $p['IDUser']);
      $this->db->delete('timeline_presensi');
    }
    $this->db->where('id', $id);
    $this->db->delete('timeline_presensi_kelompok');

    $this->session->set_flashdata('messageKelompok', '<div class="alert alert-success" role="alert">Jadwal Kelompok berhasil dihapus!</div>');
    redirect(base_url('koordinator/penjadwalan'));
  }
  public function cekjadwalpraktikan()
  {
    $this->load->model('Koordinator_model');
    $modul = $this->input->post('modul');
    $nrp = $this->input->post('nrp');
    $ada = $this->Koordinator_model->cekjadwalpraktikan($modul, $nrp);
    if ($ada == NULL) {
      echo json_encode("Belum");
    } else {
      echo json_encode("Sudah");
    }
  }
  public function addjadwalpraktikan()
  {
    $data = [
      'dateID' => $this->input->post('datePraktikanID'),
      'nrp' => $this->input->post('nrp')
    ];
    $this->db->insert('timeline_presensi', $data);

    $this->session->set_flashdata('messagePraktikan', '<div class="alert alert-success" role="alert">Jadwal praktikan berhasil ditambahkan!</div>');
    redirect(base_url('koordinator/penjadwalan'));
  }
  public function getdetailjadwalpraktikan()
  {
    $this->load->model('Koordinator_model');

    echo json_encode($this->Koordinator_model->jadwalpraktikan($this->input->post('id')));
  }
  public function editjadwalpraktikan()
  {
    $data = [
      'dateID' => $this->input->post('datePraktikanID'),
      'ket' => $this->input->post('keterangan')
    ];
    $this->db->where('id', $this->input->post('jadwalID'));
    $this->db->update('timeline_presensi', $data);

    $this->session->set_flashdata('messagePraktikan', '<div class="alert alert-success" role="alert">Jadwal praktikan berhasil diubah!</div>');
    redirect(base_url('koordinator/penjadwalan'));
  }
  public function deletejadwalpraktikan($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('timeline_presensi');

    $this->session->set_flashdata('messagePraktikan', '<div class="alert alert-success" role="alert">Jadwal praktikan berhasil dihapus!</div>');
    redirect(base_url('koordinator/penjadwalan'));
  }
  public function getdetailjaga()
  {
    $this->load->model('Koordinator_model');
    $ada = $this->Koordinator_model->detailjaga($this->input->post('id'));
    if ($ada) {
      echo json_encode($ada);
    } else {
      echo json_encode("Tidak");
    }
  }
  public function editjaga()
  {
    $date = $this->input->post('idSesi');

    $query = "DELETE `timeline_presensi`.* FROM `timeline_presensi` INNER JOIN `user` ON `timeline_presensi`.`nrp` = `user`.`nrp`
              WHERE `timeline_presensi`.`dateID` ='$date' AND NOT `user`.`role_id` = '4'";
    $this->db->query($query);

    foreach ($this->input->post('asisten') as $p) {
      $asisten = [];
      if ($this->db->get_where('timeline_presensi', ['dateID' => $date, 'nrp' => $p])->row_array()) {
        continue;
      } else {
        $asisten = [
          'dateID' => $date,
          'nrp' => $p
        ];
        $this->db->insert('timeline_presensi', $asisten);
      }
    }

    $this->session->set_flashdata('messageJaga', '<div class="alert alert-success" role="alert">Jadwal jaga berhasil diubah!</div>');
    redirect(base_url('koordinator/penjadwalan'));
  }
  public function getlistasisten()
  {
    $this->db->where_not_in('role_id', array(4));
    $list = $this->db->get('user')->result_array();
    echo json_encode($list);
  }
  // End of Function Penjadwalan

  public function finalproject()
  {
    $data['file'] = $this->db->get('filebuku')->result_array();
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['title'] = 'Final Project';
    $data['finalproject'] = $this->db->get('finalproject')->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('koordinator/finalproject', $data);
    $this->load->view('templates/footer');
  }

  public function addfp()
  {
    $data = [
      'name' => $this->input->post('rangkaian'),
      'type' => $this->input->post('type'),
      'input' => $this->input->post('input'),
      'output' => $this->input->post('output'),
      'selector' => $this->input->post('selector'),
      'enable' => $this->input->post('enable'),
      'gate' => $this->input->post('gate'),
      'status' => $this->input->post('status'),
    ];

    $this->db->insert('finalproject', $data);
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Final Project berhasil ditambahkan!</div>');
    redirect(base_url('koordinator/finalproject'));
  }

  public function getdetailfp()
  {
    echo json_encode($this->db->get_where('finalproject', ['id' => $this->input->post('id')])->row_array());
  }

  public function editfp()
  {
    $data = [
      'name' => $this->input->post('rangkaian'),
      'type' => $this->input->post('type'),
      'input' => $this->input->post('input'),
      'output' => $this->input->post('output'),
      'selector' => $this->input->post('selector'),
      'enable' => $this->input->post('enable'),
      'gate' => $this->input->post('gate'),
      'status' => $this->input->post('status'),
    ];

    $this->db->where('id', $this->input->post('id'));
    $this->db->update('finalproject', $data);
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Final Project berhasil diubah!</div>');
    redirect(base_url('koordinator/finalproject'));
  }

  public function deletefp($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('finalproject');

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Final Project berhasil dihapus!</div>');
    redirect(base_url('koordinator/finalproject'));
  }
}
