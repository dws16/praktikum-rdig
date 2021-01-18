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
  public function detailkelompok_asistenFP($kelompok, $modul)
  {
    $query = "SELECT `user`.`name` as `asisten`, `user`.`nrp`, `kelompok`.`name` as `kelompok`, `kelompok_aslab`.`IDPraktikum`,
              `kelompok`.`kelompokID`, `praktikum`.`praktikumID`, `praktikum`.`name` as `modul`
              FROM `kelompok_aslab` INNER JOIN `kelompok` ON `kelompok`.`kelompokID` = `kelompok_aslab`.`IDKelompok`
              INNER JOIN `user` ON `user`.`nrp` = `kelompok_aslab`.`IDUser`
              INNER JOIN `praktikum` ON `kelompok_aslab`.`IDPraktikum` = `praktikum`.`praktikumID`
              WHERE `kelompok_aslab`.`IDKelompok` = '$kelompok'
              AND `kelompok_aslab`.`IDPraktikum` = '$modul'";

    return $this->db->query($query)->result_array();
  }

  public function listsesi($id = NULL)
  {
    $query = 'SELECT `timeline_praktikum`.`dateID`, `timeline_praktikum`.`date`, 
              `praktikum`.`name`, `praktikum`.`praktikumID`, `timeline_praktikum`.`ket`
              FROM `timeline_praktikum` INNER JOIN `praktikum` ON `praktikum`.`praktikumID` = `timeline_praktikum`.`praktikumID`';
    if ($id) {
      $query .= "WHERE `timeline_praktikum`.`dateID` = '$id'";
      return $this->db->query($query)->row_array();
    }

    return $this->db->query($query)->result_array();
  }

  public function listjaga()
  {
    $query = "SELECT `timeline_praktikum`.`dateID`, `timeline_praktikum`.`date`, COUNT(`timeline_presensi`.`id`) AS `jumlah`,
              `praktikum`.`name`, `praktikum`.`praktikumID`, `timeline_praktikum`.`ket`
              FROM `timeline_praktikum` INNER JOIN `praktikum` ON `praktikum`.`praktikumID` = `timeline_praktikum`.`praktikumID`
              LEFT JOIN `timeline_presensi` ON `timeline_praktikum`.`dateID` = `timeline_presensi`.`dateID`
              INNER JOIN `user` ON `timeline_presensi`.`nrp` = `user`.`nrp`
              WHERE `user`.`role_id` !='4'
              GROUP BY `timeline_praktikum`.`dateID`
              ";

    return $this->db->query($query)->result_array();
  }
  public function detailjaga($id)
  {
    $query = "SELECT `timeline_presensi`.`dateID`, `timeline_presensi`.`id`, `timeline_praktikum`.`date`, `timeline_praktikum`.`ket`,
              `timeline_presensi`.`nrp`, `user`.`name`, `praktikum`.`name` AS `modul` FROM `timeline_presensi`
              LEFT JOIN `timeline_praktikum` ON `timeline_presensi`.`dateID` = `timeline_praktikum`.`dateID`
              LEFT JOIN `user` ON `timeline_presensi`.`nrp` = `user`.`nrp`
              LEFT JOIN `praktikum` ON `timeline_praktikum`.`praktikumID` = `praktikum`.`praktikumID`
              WHERE `timeline_presensi`.`dateID` = '$id' AND `user`.`role_id`!=4";

    return $this->db->query($query)->result_array();
  }

  public function jadwalkelompok()
  {
    $query = "SELECT `kelompok`.`name` AS `kelompok`, `kelompok`.`kelompokID`, `praktikum`.`name`, `praktikum`.`praktikumID`,
              `timeline_praktikum`.`date`, `timeline_presensi_kelompok`.`id` FROM `timeline_presensi_kelompok`
              INNER JOIN `kelompok` ON `timeline_presensi_kelompok`.`kelompokID` = `kelompok`.`kelompokID`
              INNER JOIN `timeline_praktikum` ON `timeline_presensi_kelompok`.`dateID` = `timeline_praktikum`.`dateID`
              INNER JOIN `praktikum` ON `timeline_praktikum`.`praktikumID` = `praktikum`.`praktikumID`";

    return $this->db->query($query)->result_array();
  }

  public function cekjadwalkelompok($modul, $kelompok)
  {
    $query = "SELECT `timeline_presensi_kelompok`.`kelompokID` FROM `timeline_presensi_kelompok`
              INNER JOIN `timeline_praktikum` ON `timeline_presensi_kelompok`.`dateID` = `timeline_praktikum`.`dateID`
              WHERE `timeline_presensi_kelompok`.`kelompokID` = '$kelompok' AND `timeline_praktikum`.`praktikumID` = '$modul'";

    return $this->db->query($query)->row_array();
  }
  public function detailjadwalkelompok($id)
  {
    $query = "SELECT `kelompok`.`name`, `kelompok`.`kelompokID`, `praktikum`.`name` AS `modul`, 
              `praktikum`.`praktikumID`, `timeline_praktikum`.`dateID`
              FROM `timeline_presensi_kelompok`
              INNER JOIN `timeline_praktikum` ON `timeline_presensi_kelompok`.`dateID` = `timeline_praktikum`.`dateID`
              INNER JOIN `praktikum` ON `timeline_praktikum`.`praktikumID` = `praktikum`.`praktikumID`
              INNER JOIN `kelompok` ON `timeline_presensi_kelompok`.`kelompokID` = `kelompok`.`kelompokID`
              WHERE `timeline_presensi_kelompok`.`id` = '$id'";

    return $this->db->query($query)->row_array();
  }

  public function jadwalpraktikan($id = NULL)
  {
    $query = "SELECT `user`.`name` AS `praktikan`, `user`.`nrp`, `kelompok`.`name` AS `kelompok`, `kelompok`.`kelompokID`, 
              `praktikum`.`name` AS `modul`, `praktikum`.`praktikumID`, `timeline_praktikum`.`dateID`,
              `timeline_praktikum`.`ket`, `timeline_presensi`.`id`, `timeline_presensi`.`ket` AS `absen` FROM `timeline_presensi`
              INNER JOIN `timeline_praktikum` ON `timeline_presensi`.`dateID` = `timeline_praktikum`.`dateID`
              INNER JOIN `praktikum` ON `timeline_praktikum`.`praktikumID` = `praktikum`.`praktikumID`
              INNER JOIN `kelompok_praktikan` ON `timeline_presensi`.`nrp` = `kelompok_praktikan`.`IDUser`
              INNER JOIN `kelompok` ON `kelompok_praktikan`.`IDKelompok` = `kelompok`.`kelompokID`
              INNER JOIN `user` ON `timeline_presensi`.`nrp`= `user`.`nrp`";
    if ($id) {
      $query .= "WHERE `timeline_presensi`.`id`='$id'";
      return $this->db->query($query)->row_array();
    }

    return $this->db->query($query)->result_array();
  }
  public function cekjadwalpraktikan($modul, $nrp)
  {
    $query = "SELECT `timeline_presensi`.`id` FROM `timeline_presensi`
              INNER JOIN `timeline_praktikum` ON `timeline_presensi`.`dateID` = `timeline_praktikum`.`dateID`
              WHERE `timeline_presensi`.`nrp`= '$nrp' AND `timeline_praktikum`.`praktikumID`='$modul'";

    return $this->db->query($query)->row_array();
  }
}
