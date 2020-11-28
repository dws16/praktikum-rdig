<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aslab_model extends CI_Model
{
  public function getPenilaian()
  {
    // SELECT * FROM `kelompok_aslab` ka LEFT JOIN praktikum p ON ka.IDPraktikum=p.PraktikumID LEFT JOIN kelompok k ON ka.IDKelompok=k.kelompokID
    // LEFT JOIN kelompok_praktikan kp ON k.kelompokID=kp.IDKelompok LEFT JOIN user u ON kp.IDUser=u.nrp WHERE p.status=1 AND k.status=1 AND k.year=2020 AND k.term=0;

    // $data = [
    //   'year' => $this->input->get('year') == '' ? date('Y', timestampNow) : $this->input->get('year'),
    //   'term' => $this->input->get('term') == '' ? 0 : $this->input->get('term'),
    // ];
    // $arrayWhere = array('year' => $data['year'], 'term' => $data['term']);
    $arrayWhere = array('p.status' => 1, 'k.status' => 1);
    $this->db->select('u.name AS praktikan, kp.IDUser AS nrpPraktikan, p.*');
    $this->db->from('kelompok_aslab ka');
    $this->db->join('praktikum p', 'ka.IDPraktikum=p.PraktikumID', 'left');
    $this->db->join('kelompok k', 'ka.IDKelompok=k.kelompokID', 'left');
    $this->db->join('kelompok_praktikan kp', 'k.kelompokID=kp.IDKelompok', 'left');
    $this->db->join('user u', 'kp.IDUser=u.nrp', 'left');
    $this->db->where($arrayWhere);
    $query = $this->db->get();
    $result = $query->result();

    return $result;
  }
  public function getNilai($data)
  {
    $this->db->from('penilaian');
    $query = $this->db->get();
    $arr = $query->result();
    $result = [];
    foreach ($arr as $item) {
      $item = (array) $item;
      unset($item['statusKriteria']);

      $this->db->select('nilai');
      $this->db->from('penilaian_praktikum');
      $this->db->where('IDPenilaian', $item['penilaianID']);
      $this->db->where('IDPraktikum', $data['praktikum']);
      $this->db->where('praktikan', $data['praktikan']);
      $this->db->where('aslab', $data['aslab']);
      $query = $this->db->get();
      $arr1 = $query->result();

      if(count($arr1) == 0){
        $arr1[0]['nilai'] = '0';
      }
      $arr_merge = array_merge($item, (array) $arr1[0], $data);
      array_push($result, $arr_merge);
    }
    return $result;
  }

  public function upsertNilai($arg)
  {
    $return = true;
    if(isset($arg['kriteria'])){
      foreach ($arg['kriteria'] as $key) {
        $sql = "INSERT INTO penilaian_praktikum (IDPenilaian, IDPraktikum, praktikan, aslab, nilai) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE nilai=?";
        $query = $this->db->query($sql, array($key['penilaian'], $arg['praktikum'], $arg['praktikan'], $arg['aslab'], $key['nilaiInsert'], $key['nilaiUpdate']));
        if(!$query) return $query;
      }
    }

    // return $this->db->affected_rows();
    return $return;
  }

}
