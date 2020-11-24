<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Koordinator extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    is_logged_in();
  }

  public function kelompok()
  {
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['title'] = 'Pembagian Kelompok';

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('koordinator/kelompok', $data);
    $this->load->view('templates/footer');
  }

  public function asisten()
  {
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['title'] = 'Pembagian Asisten';

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('koordinator/asisten', $data);
    $this->load->view('templates/footer');
  }

  public function praktikum()
  {
    $data['file'] = $this->db->get('filepraktikum')->result_array();
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['title'] = 'Kelengkapan Praktikum';

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('koordinator/praktikum', $data);
    $this->load->view('templates/footer');
  }

  public function geteditfilepraktikum()
  {
    echo json_encode($this->db->get_where('filepraktikum', ['id' => $this->input->post('id')])->row_array());
  }

  public function addfilepraktikum()
  {
    $nama = $this->input->post('namafile');
    $file = $_FILES['filepraktikum']['name'];

    if ($file) {
      $config['upload_path'] = './assets/file/praktikum/';
      $config['allowed_types'] = 'gif|jpg|png|pdf|cdr|rar|zip|docx';

      $this->load->library('upload', $config);

      if ($this->upload->do_upload('filepraktikum')) {

        $new_file = $this->upload->data('file_name');

        $this->db->set('filename', $new_file);
        $this->db->set('name', $nama);
        $this->db->insert('filepraktikum');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">File berhasil ditambahkan!</div>');
        redirect(base_url('koordinator/praktikum'));
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
        redirect(base_url('koordinator/praktikum'));
      }
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Harap tambahkan file!</div>');
      redirect(base_url('koordinator/praktikum'));
    }
  }

  public function editfilepraktikum()
  {
    $nama = $this->input->post('namafile');
    $file = $_FILES['filepraktikum']['name'];

    $lama = $this->db->get_where('filepraktikum', ['id' => $this->input->post('id')])->row_array();

    if ($file) {
      unlink(FCPATH . 'assets/file/prakitkum/' . $lama['filename']);
      $config['upload_path'] = './assets/file/praktikum/';
      $config['allowed_types'] = 'gif|jpg|png|pdf|cdr|rar|zip|docx';

      $this->load->library('upload', $config);

      if ($this->upload->do_upload('filepraktikum')) {

        $new_file = $this->upload->data('file_name');

        $this->db->set('filename', $new_file);
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
        redirect(base_url('koordinator/praktikum'));
      }
    }

    $this->db->set('name', $nama);
    $this->db->where('id', $this->input->post('id'));
    $this->db->update('filepraktikum');

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">File berhasil diubah!</div>');
    redirect(base_url('koordinator/praktikum'));
  }

  public function deletefilepraktikum($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('filepraktikum');

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">File berhasil dihapus!</div>');
    redirect(base_url('koordinator/praktikum'));
  }

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

  public function penjadwalan()
  {
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['title'] = 'Penjadwalan';

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('koordinator/penjadwalan', $data);
    $this->load->view('templates/footer');
  }
}
