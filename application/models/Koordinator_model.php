<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Koordinator_model extends CI_Model
{
  public function listkelompok()
  {
    $query = 'SELECT `kelompok`.`name`, `kelompok`.`id`, COUNT(`kelompok_user`.`id`) as `jumlah` 
              FROM `kelompok` LEFT JOIN `kelompok_user` ON `kelompok`.`id` = `kelompok_user`.`kelompok_id`
              GROUP BY `kelompok`.`id`';

    return $this->db->query($query)->result_array();
  }

  public function detailkelompok($kelompok_id)
  {
    $query = "SELECT  `kelompok`.`name` AS `kelompok`, `kelompok`.`id`, `user`.`name`, `user`.`nrp` 
              FROM `kelompok` LEFT JOIN `kelompok_user` ON `kelompok`.`id` = `kelompok_user`.`kelompok_id`
              LEFT JOIN `user` ON `kelompok_user`.`user_nrp` = `user`.`nrp` WHERE `kelompok`.`id` = '$kelompok_id'";

    return $this->db->query($query)->result_array();
  }

  public function ceknrpkelompok($nrp, $id_kel)
  {
    $query = "SELECT `kelompok`.`name` AS `kelompok`, `kelompok`.`id`, `user`.`name`, `user`.`nrp` 
              FROM `kelompok` INNER JOIN `kelompok_user` ON `kelompok`.`id` = `kelompok_user`.`kelompok_id`
              INNER JOIN `user` ON `kelompok_user`.`user_nrp` = `user`.`nrp` 
              WHERE `kelompok`.`id` != '1' 
              AND `user`.`nrp`= '$nrp'
              AND `user`.`role_id` = '4'";

    return $this->db->query($query)->result_array();
  }

  public function listpraktikan()
  {
    $query = "SELECT `user`.`name`, `user`.`nrp`, `user`.`jadwal`, `user`.`frs`, `kelompok`.`name` AS `kelompok`
              FROM `user` 
              LEFT JOIN `kelompok_user` ON `user`.`nrp` = `kelompok_user`.`user_nrp`
              LEFT JOIN `kelompok` ON `kelompok`.`id` = `kelompok_user`.`kelompok_id`
              WHERE `user`.`role_id`='4'";

    return $this->db->query($query)->result_array();
  }
}
