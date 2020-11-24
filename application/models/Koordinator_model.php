<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Koordinator_model extends CI_Model
{
  public function listkelompok()
  {
    $query = 'SELECT `kelompok`.`name`, COUNT(`kelompok_user`.`id`) as `jumlah` 
              FROM `kelompok` LEFT JOIN `kelompok_user` ON `kelompok`.`id` = `kelompok_user`.`kelompok_id`
              GROUP BY `kelompok_user`.`kelompok_id`';

    return $this->db->query($query)->result_array();
  }
}
