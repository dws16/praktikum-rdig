<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Koordinator_model extends CI_Model
{
  public function listkelompok()
  {
    $query = 'SELECT `kelompok`.`name`, `kelompok`.`kelompokID`, COUNT(`kelompok_praktikan`.`IDUser`) as `jumlah`, `kelompok`.`year`,
              `kelompok`.`term`, `kelompok`.`status`
              FROM `kelompok` LEFT JOIN `kelompok_praktikan` ON `kelompok`.`kelompokID` = `kelompok_praktikan`.`IDKelompok`
              GROUP BY `kelompok`.`kelompokID`';

    return $this->db->query($query)->result_array();
  }

  public function detailkelompok($kelompok_id)
  {
    $query = "SELECT  `kelompok`.`name` AS `kelompok`, `kelompok`.`kelompokID`, `kelompok`.`year`, `kelompok`.`term`, 
              `kelompok`.`status`, `user`.`name`, `user`.`nrp` 
              FROM `kelompok` LEFT JOIN `kelompok_praktikan` ON `kelompok`.`kelompokID` = `kelompok_praktikan`.`IDKelompok`
              LEFT JOIN `user` ON `kelompok_praktikan`.`IDUser` = `user`.`nrp` WHERE `kelompok`.`kelompokID` = '$kelompok_id'";

    return $this->db->query($query)->result_array();
  }

  public function ceknrpkelompok($nrp, $id_kel)
  {
    $query = "SELECT `kelompok`.`name` AS `kelompok`, `kelompok`.`kelompokID`, `user`.`name`, `user`.`nrp` 
              FROM `kelompok` INNER JOIN `kelompok_praktikan` ON `kelompok`.`kelompokID` = `kelompok_praktikan`.`IDKelompok`
              INNER JOIN `user` ON `kelompok_praktikan`.`IDUser` = `user`.`nrp` 
              WHERE `kelompok`.`kelompokID` != '$id_kel' 
              AND `user`.`nrp`= '$nrp'
              AND `user`.`role_id` = '4'";

    return $this->db->query($query)->result_array();
  }

  public function listpraktikan()
  {
    $query = "SELECT `user`.`name`, `user`.`nrp`, `user`.`jadwal`, `user`.`frs`, `kelompok`.`name` AS `kelompok`
              FROM `user` 
              LEFT JOIN `kelompok_praktikan` ON `user`.`nrp` = `kelompok_praktikan`.`IDUser`
              LEFT JOIN `kelompok` ON `kelompok`.`kelompokID` = `kelompok_praktikan`.`IDKelompok`
              WHERE `user`.`role_id`='4'";

    return $this->db->query($query)->result_array();
  }

  public function listkelompok_asisten()
  {
    $query = 'SELECT `user`.`name` as `asisten`, `user`.`nrp`, `kelompok_aslab`.`IDKelompok`, `kelompok`.`name` as `kelompok`, `kelompok_aslab`.`IDPraktikum`
              FROM `kelompok_aslab` INNER JOIN `kelompok` ON `kelompok`.`kelompokID` = `kelompok_aslab`.`IDKelompok`
              INNER JOIN `user` ON `user`.`nrp` = `kelompok_aslab`.`IDUser`';

    return $this->db->query($query)->result_array();
  }

  public function detailkelompok_asisten($kelompok, $modul)
  {
    $query = "SELECT `user`.`name` as `asisten`, `user`.`nrp`, `kelompok`.`name` as `kelompok`, `kelompok_aslab`.`IDPraktikum`,
              `kelompok`.`kelompokID`, `praktikum`.`praktikumID`, `praktikum`.`name` as `modul`
              FROM `kelompok_aslab` INNER JOIN `kelompok` ON `kelompok`.`kelompokID` = `kelompok_aslab`.`IDKelompok`
              INNER JOIN `user` ON `user`.`nrp` = `kelompok_aslab`.`IDUser`
              INNER JOIN `praktikum` ON `kelompok_aslab`.`IDPraktikum` = `praktikum`.`praktikumID`
              WHERE `kelompok_aslab`.`IDKelompok` = '$kelompok'
              AND `kelompok_aslab`.`IDPraktikum` = '$modul'";

    return $this->db->query($query)->row_array();
  }
}
