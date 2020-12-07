<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aslab_model extends CI_Model
{
  public function getPenilaian()
  {
    // SELECT * FROM `kelompok_aslab` ka LEFT JOIN praktikum p ON ka.IDPraktikum=p.PraktikumID LEFT JOIN kelompok k ON ka.IDKelompok=k.kelompokID
    // LEFT JOIN kelompok_praktikan kp ON k.kelompokID=kp.IDKelompok LEFT JOIN user u ON kp.IDUser=u.nrp LEFT JOIN penilaian_rekap pr ON pr.IDUser=u.nrp AND pr.IDPraktikum=ka.IDPraktikum
    // WHERE p.status=1 AND k.status=1 AND k.year=2020 AND k.term=0;
    // kelompok_aslab, praktikum, kelompok, kelompok_praktikan, user, penilaian_rekap

    // $data = [
    //   'year' => $this->input->get('year') == '' ? date('Y', timestampNow) : $this->input->get('year'),
    //   'term' => $this->input->get('term') == '' ? 0 : $this->input->get('term'),
    // ];
    // $arrayWhere = array('year' => $data['year'], 'term' => $data['term']);
    // $arrayWhere = array('p.status' => 1, 'k.status' => 1);
    $this->db->select('u.name AS praktikan, u.nrp AS nrpPraktikan, IFNULL(pr.nilai, 0) AS nilai, p.*');
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

    $resultPraktikum = $this->db->query($sqlPraktikum);
    $result['praktikum'] = $resultPraktikum->result();
    $resultLapres = $this->db->query($sqlLapres);
    $result['lapres'] = $resultLapres->result();
    $resultFP = $this->db->query($sqlFP);
    $result['fp'] = $resultFP->result();

    return $result;
  }
  public function getNilai($data)
  {
    $next = true;
    $next1 = true;
    $result['penilaian'] = [];
    $this->db->from('penilaian');

    $arrayWhereNext['statusKriteria'] = 1;
    $arrayWhereNext1['statusPelanggaran'] = 1;
    if(isset($data['type'])){
      if($data['type'] == 'praktikum'){
        $arrayWhereNext['IDType'] = 1;
        $arrayWhereNext1['IDType'] = 1;
      }elseif($data['type'] == 'fp'){
        $arrayWhereNext['IDType'] = 3;
        $arrayWhereNext1['IDType'] = 3;
      }else{
        $next = false;
        $next1 = false;
      }
    }else{
      $next = false;
      $next1 = false;
    }
    $queryTemp = [];

    if($next){
      $this->db->where($arrayWhereNext);
      $query = $this->db->get();
      $arr = $query->result_array();
      foreach ($arr as $item) {
        unset($item['statusKriteria']);

        $arrayWhere = array(
          'IDPenilaian' => $item['penilaianID'],
          'IDPraktikum' => $data['praktikum'],
          'praktikan'   => $data['praktikan'],
        );
        $this->db->select('nilai');
        $this->db->from('penilaian_praktikum');
        $this->db->where($arrayWhere);
        $query = $this->db->get();
        $arr1 = $query->result_array();

        if(count($arr1) == 0){
          $arr1[0]['nilai'] = '0';
        }
        $arr_merge = array_merge($item, $arr1[0], $data);
        array_push($result['penilaian'], $arr_merge);
      }
    }


    if($next1){
      $result['pengurangan'] = [];
      $this->db->from('penilaian_pelanggaran');
      $this->db->where($arrayWhereNext1);
      $query = $this->db->get();
      $arr = $query->result_array();
      foreach ($arr as $item) {
        unset($item['statusPelanggaran']);

        if(isset($data['type'])){
          $next = true;
          $arrayWhere = array(
            'IDPelanggaran' => $item['pelanggaranID'],
            'IDPraktikum' => $data['praktikum'],
            'praktikan' => $data['praktikan'],
            'aslab' => $data['aslab'],
          );
          $this->db->select('status');
          $this->db->from('penilaian_pengurangan pp');
          $this->db->join('penilaian_pelanggaran p', 'pp.IDPelanggaran=p.pelanggaranID', 'left');
          $this->db->where($arrayWhere);
          $query = $this->db->get();
          $arr1 = $query->result_array();

          if(count($arr1) == 0){
            $arr1[0]['nilai'] = '0';
          }
          $arr_merge = array_merge($item, $arr1[0], $data);
          array_push($result['pengurangan'], $arr_merge);
        }
      }
    }
    $this->db->select('name');
    $query = $this->db->get_where('praktikum', array('praktikumID' => $data['praktikum']));
    $result['praktikum'] = $query->row_array();

    return $result;
  }

  public function upsertNilai($arg)
  {
    $return = true;
    if(isset($arg['kriteria'])){
      if(count($arg['kriteria']) > 0){
        foreach ($arg['kriteria'] as $key) {
          $sql = "INSERT INTO penilaian_praktikum (IDPenilaian, IDPraktikum, praktikan, aslab, nilai) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE nilai=?";
          $query = $this->db->query($sql, array($key['penilaian'], $arg['praktikum'], $arg['praktikan'], $arg['aslab'], $key['nilaiInsert'], $key['nilaiUpdate']));
          if(!$query) return $query;
        }
      }
    }
    if(isset($arg['reset-pelanggaran'])){
      if(count($arg['reset-pelanggaran']) > 0){
        foreach ($arg['reset-pelanggaran'] as $key) {
          $sql = "INSERT INTO penilaian_pengurangan (IDPelanggaran, IDPraktikum, praktikan, aslab, status) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE status=?";
          $query = $this->db->query($sql, array($key['reset-pelanggaran'], $arg['praktikum'], $arg['praktikan'], $arg['aslab'], 0, 0));
          if(!$query) return $query;
        }
      }
    }
    if(isset($arg['pelanggaran'])){
      if(count($arg['pelanggaran']) > 0){
        foreach ($arg['pelanggaran'] as $key) {
          $sql = "INSERT INTO penilaian_pengurangan (IDPelanggaran, IDPraktikum, praktikan, aslab, status) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE status=?";
          $query = $this->db->query($sql, array($key['pelanggaran'], $arg['praktikum'], $arg['praktikan'], $arg['aslab'], 1, 1));
          if(!$query) return $query;
        }
      }
    }

    return $return;
  }

}
