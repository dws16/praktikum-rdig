-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2020 at 06:17 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `praktikum`
--

-- --------------------------------------------------------

--
-- Table structure for table `filebuku`
--

CREATE TABLE `filebuku` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `filename` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `filebuku`
--

INSERT INTO `filebuku` (`id`, `name`, `filename`) VALUES
(2, 'Tes', 'Screenshot_7.png');

-- --------------------------------------------------------

--
-- Table structure for table `kelompok`
--

CREATE TABLE `kelompok` (
  `kelompokID` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `year` year(4) NOT NULL,
  `term` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kelompok`
--

INSERT INTO `kelompok` (`kelompokID`, `name`, `year`, `term`, `status`) VALUES
(1, 'Tes', 2020, 0, 1),
(4, 'Halo', 2020, 0, 1),
(5, 'Halo2', 2020, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `kelompok_aslab`
--

CREATE TABLE `kelompok_aslab` (
  `IDPraktikum` int(11) NOT NULL,
  `IDKelompok` int(11) NOT NULL,
  `IDUser` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kelompok_aslab`
--

INSERT INTO `kelompok_aslab` (`IDPraktikum`, `IDKelompok`, `IDUser`) VALUES
(1, 1, '07211640000015');

-- --------------------------------------------------------

--
-- Table structure for table `kelompok_praktikan`
--

CREATE TABLE `kelompok_praktikan` (
  `IDKelompok` int(11) NOT NULL,
  `IDUser` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kelompok_praktikan`
--

INSERT INTO `kelompok_praktikan` (`IDKelompok`, `IDUser`) VALUES
(4, '07211740000014');

-- --------------------------------------------------------

--
-- Table structure for table `penilaian`
--

CREATE TABLE `penilaian` (
  `penilaianID` int(11) NOT NULL,
  `kriteria` varchar(64) NOT NULL,
  `rangeKriteria` tinyint(3) UNSIGNED NOT NULL DEFAULT 100,
  `descKriteria` text DEFAULT NULL,
  `statusKriteria` tinyint(1) NOT NULL DEFAULT 0,
  `IDType` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penilaian`
--

INSERT INTO `penilaian` (`penilaianID`, `kriteria`, `rangeKriteria`, `descKriteria`, `statusKriteria`, `IDType`) VALUES
(1, 'Pendahuluan', 80, '', 0, 1),
(2, 'Proses Praktikum', 100, '', 1, 1),
(3, 'Laporan', 100, '', 1, 1),
(4, 'Asistensi', 100, '', 1, 1),
(5, 'Orisinalitas', 100, '', 1, 1),
(6, 'Kelengkapan', 100, 'Kelengkapan Pembukuan Lapres', 1, 2),
(7, 'Keteraturan', 100, NULL, 1, 2),
(8, 'Format', 100, NULL, 1, 2),
(9, 'Krtieria FP', 100, NULL, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `penilaian_pelanggaran`
--

CREATE TABLE `penilaian_pelanggaran` (
  `pelanggaranID` int(11) NOT NULL,
  `kriteriaPelanggaran` varchar(64) NOT NULL,
  `nilaiPelanggaran` tinyint(2) UNSIGNED NOT NULL DEFAULT 15,
  `descPelanggaran` text DEFAULT NULL,
  `statusPelanggaran` tinyint(1) NOT NULL DEFAULT 0,
  `IDType` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penilaian_pelanggaran`
--

INSERT INTO `penilaian_pelanggaran` (`pelanggaranID`, `kriteriaPelanggaran`, `nilaiPelanggaran`, `descPelanggaran`, `statusPelanggaran`, `IDType`) VALUES
(1, 'Terlambat Praktikum', 15, 'Praktikan datang terlambat saat praktikum', 1, 1),
(2, 'Terlambat Pengumpulan', 5, 'Terlambat mengumpulkan lapres', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `penilaian_pengurangan`
--

CREATE TABLE `penilaian_pengurangan` (
  `IDPelanggaran` int(11) NOT NULL,
  `IDPraktikum` int(11) NOT NULL,
  `praktikan` varchar(128) CHARACTER SET latin1 NOT NULL,
  `aslab` varchar(128) CHARACTER SET latin1 NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penilaian_pengurangan`
--

INSERT INTO `penilaian_pengurangan` (`IDPelanggaran`, `IDPraktikum`, `praktikan`, `aslab`, `status`) VALUES
(1, 1, '07211740000010', '67890987654321', 1),
(1, 1, '07211740000040', '67890987654321', 0),
(2, 1, '07211740000010', '67890987654321', 1),
(2, 1, '07211740000040', '67890987654321', 0);

-- --------------------------------------------------------

--
-- Table structure for table `penilaian_praktikum`
--

CREATE TABLE `penilaian_praktikum` (
  `IDPenilaian` int(11) NOT NULL,
  `IDPraktikum` int(11) NOT NULL,
  `praktikan` varchar(128) CHARACTER SET latin1 NOT NULL,
  `aslab` varchar(128) CHARACTER SET latin1 NOT NULL,
  `nilai` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penilaian_praktikum`
--

INSERT INTO `penilaian_praktikum` (`IDPenilaian`, `IDPraktikum`, `praktikan`, `aslab`, `nilai`) VALUES
(1, 1, '07211740000040', '67890987654321', 0),
(2, 1, '07211740000010', '67890987654321', 0),
(2, 1, '07211740000040', '67890987654321', 12),
(3, 1, '07211740000010', '67890987654321', 0),
(3, 1, '07211740000040', '67890987654321', 34),
(4, 1, '07211740000010', '67890987654321', 3),
(4, 1, '07211740000040', '67890987654321', 56),
(4, 9, '07211740000040', '67890987654321', 4),
(5, 1, '07211740000010', '67890987654321', 0),
(5, 1, '07211740000040', '67890987654321', 78),
(5, 10, '07211740000040', '67890987654321', 5);

-- --------------------------------------------------------

--
-- Table structure for table `penilaian_rekap`
--

CREATE TABLE `penilaian_rekap` (
  `IDPraktikum` int(11) NOT NULL,
  `IDUser` varchar(128) CHARACTER SET latin1 NOT NULL,
  `nilai` tinyint(4) NOT NULL,
  `IDType` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penilaian_rekap`
--

INSERT INTO `penilaian_rekap` (`IDPraktikum`, `IDUser`, `nilai`, `IDType`) VALUES
(1, '07211740000040', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `praktikum`
--

CREATE TABLE `praktikum` (
  `praktikumID` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `title` varchar(128) NOT NULL,
  `filename` varchar(128) NOT NULL,
  `description` varchar(128) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `IDType` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `praktikum`
--

INSERT INTO `praktikum` (`praktikumID`, `name`, `title`, `filename`, `description`, `status`, `IDType`) VALUES
(1, 'P1', 'Dasar Rangkaian Digital', 'toefl.pdf', '', 1, 1),
(9, 'FP', 'Final Project', 'P2_1606385242.pdf', '', 1, 3),
(10, 'Lapres', 'Buku Lapres', '', '', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `praktikum_type`
--

CREATE TABLE `praktikum_type` (
  `typeID` int(11) NOT NULL,
  `typeName` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `praktikum_type`
--

INSERT INTO `praktikum_type` (`typeID`, `typeName`) VALUES
(1, 'Praktikum'),
(2, 'Buku Lapres'),
(3, 'Final Project');

-- --------------------------------------------------------

--
-- Table structure for table `timeline_praktikum`
--

CREATE TABLE `timeline_praktikum` (
  `dateID` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `praktikumID` int(11) NOT NULL,
  `ket` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `timeline_praktikum`
--

INSERT INTO `timeline_praktikum` (`dateID`, `date`, `praktikumID`, `ket`) VALUES
(8, '2020-11-28 16:34:00', 1, 'Sesi 1'),
(9, '2020-12-09 22:40:00', 1, 'Sesi 2'),
(10, '2020-11-28 17:02:00', 9, 'Sesi 1'),
(11, '2020-12-12 17:54:00', 9, 'Sesi 2');

-- --------------------------------------------------------

--
-- Table structure for table `timeline_presensi`
--

CREATE TABLE `timeline_presensi` (
  `id` int(11) NOT NULL,
  `dateID` int(11) NOT NULL,
  `nrp` varchar(128) NOT NULL,
  `hadir` tinyint(1) NOT NULL DEFAULT '0',
  `ket` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `timeline_presensi`
--

INSERT INTO `timeline_presensi` (`id`, `dateID`, `nrp`, `hadir`, `ket`) VALUES
(65, 8, '07211740000014', 0, NULL),
(68, 8, '07211740000043', 0, NULL),
(69, 8, '07211640000015', 0, NULL),
(82, 11, '07211640000015', 0, NULL),
(83, 11, '07211740000043', 0, NULL),
(84, 10, '07211740000043', 0, NULL),
(85, 9, '07211740000043', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `timeline_presensi_kelompok`
--

CREATE TABLE `timeline_presensi_kelompok` (
  `id` int(11) NOT NULL,
  `dateID` int(11) NOT NULL,
  `kelompokID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `timeline_presensi_kelompok`
--

INSERT INTO `timeline_presensi_kelompok` (`id`, `dateID`, `kelompokID`) VALUES
(34, 9, 1),
(35, 10, 1),
(40, 8, 4);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `nrp` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `frs` varchar(128) DEFAULT NULL,
  `jadwal` varchar(128) DEFAULT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `nrp`, `email`, `password`, `role_id`, `is_active`, `frs`, `jadwal`, `date_created`) VALUES
(4, 'Fradipta Alqaiyum', '07211740000005', 'Fradipta.17072@mhs.its.ac.id', '$2y$10$aSSQcDxt4J1wZ8KJnvpXye6mQw1TvzHgm/j/fDDJZ1JZR0aYKO/Te', 4, 1, 'Screenshot_2019-12-26-05-25-17-910_com_android_chrome.png', 'Screenshot_2019-12-26-05-25-17-910_com_android_chrome1.png', 1577313141),
(5, 'Ahmad Zakiy', '07211740000040', 'zakiy4898@gmail.com', '$2y$10$hIyeZjCoVgF8DCMGbARQX.PXFix1LIxbQ5jEFdomxQ.M6lFuJFjD.', 4, 1, '1390071.jpg', '139011.jpg', 1577340532),
(13, 'Firdaus Nanda Pradanggapasti', '07211640000015', 'firdausnp16@gmail.com', '$2y$10$t4mPqca5PHeleICmXofKp.IqeaBNPEG5y9eMQj/IaX9Yde4SGSBEi', 1, 1, 'hitam12.png', 'putih1.png', 1577552626),
(14, 'Muhammad Dzulfiqar', '07211740000043', 'mfikar.md@gmail.com', '$2y$10$JCdOmvll1.XuGV4aeOqbXuKGPkgCz85oIgXanbOFZoa7NDVzSDYvK', 3, 1, '1555357134802.jpg', '1556562188746.jpg', 1580651215),
(15, 'Mpu Hambyah Syah Bagaskara Aji', '07211740000010', 'mpu.hambyah@gmail.com', '$2y$10$XabUxcv1fDAv2v33AZxs1.gvCWoRqHgKPdypUkadaMMO6h4JwW8Yy', 4, 1, '07211740000010_Mpu_Hambyah_Syah_Bagaskara_Aji.pdf', '07211740000010_Mpu_Hambyah_Syah_Bagaskara_Aji1.pdf', 1594780376),
(16, 'Nia Angellina', '07211740000014', 'niaaldy99@gmail.com', '$2y$10$PeZNEKFGpyTHSgYoyKisf.M2PP/253qOMYsAeHaa.jjcHofqr3J/O', 4, 0, 'Capture.JPG', 'Capture1.JPG', 1595149534),
(17, 'Firdaus Pradanggapasti', '07211640000014', 'dauuuussss@gmail.com', '$2y$10$4crH9BW9UxAjyDVb3/zJzOMeYg.j75nHdqXAOF1PGkQyR0MqAskf.', 4, 0, 'cool-background.png', 'cool-background_(1).png', 1597486903),
(18, 'Aik - Admin', '67890987654321', 'a@a.a', '$2y$10$APhLpoqdmQjXvWWec1dECOuQlrK3Ge5ywnhjUfDh6WxPIt/qZr9f2', 1, 1, NULL, NULL, 1597486903);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 4, 4),
(6, 1, 5),
(7, 1, 6),
(8, 2, 2),
(9, 3, 3),
(10, 1, 3),
(12, 1, 4),
(13, 1, 2),
(14, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Profile'),
(2, 'Koordinator'),
(3, 'Aslab'),
(4, 'Praktikan'),
(5, 'Menu'),
(6, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Admin'),
(2, 'Koor'),
(3, 'Aslab'),
(4, 'Praktikan');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 1, 'My Profile', 'profile', 'fas fa-fw fa-user', 1),
(3, 1, 'Change Password', 'profile/changepassword', 'fas fa-fw fa-key', 1),
(8, 4, 'Dashboard', 'praktikan', 'fas fa-fw fa-tachometer-alt', 1),
(9, 4, 'Kelengkapan Praktikum', 'praktikan/kelengkapanpraktikum', 'fas fa-fw fa-file-archive', 1),
(10, 4, 'Kelengkapan Buku', 'praktikan/buku', 'fas fa-fw fa-book', 1),
(11, 4, 'Penilaian', 'praktikan/penilaian', 'fas fa-fw fa-font', 1),
(12, 5, 'Menu Management', 'menu', 'fas fa-fw fa-folder', 1),
(13, 5, 'Submenu Management', 'menu/submenu', 'fas fa-fw fa-folder-open', 1),
(14, 6, 'User List', 'admin', 'fas fa-fw fa-users', 1),
(15, 6, 'Role', 'admin/role', 'fas fa-fw fa-users-cog', 1),
(16, 3, 'Dashboard', 'aslab', 'fas fa-fw fa-tachometer-alt', 1),
(17, 3, 'Penilaian', 'aslab/penilaian', 'fas fa-fw fa-font', 1),
(18, 2, 'Pembagian Kelompok', 'koordinator/kelompok', 'fas fa-fw fa-users', 1),
(19, 2, 'Pembagian Asisten', 'koordinator/asisten', 'fas fa-fw fa-user-astronaut', 1),
(21, 2, 'Kelengkapan Buku', 'koordinator/buku', 'fas fa-fw fa-book', 1),
(22, 2, 'Penjadwalan', 'koordinator/penjadwalan', 'fas fa-fw fa-calendar-day', 1),
(23, 2, 'Data Praktikan', 'koordinator/praktikan', 'fas fa-fw fa-robot', 1),
(24, 2, 'Manajemen Modul', 'koordinator/modul', 'fas fa-fw fa-book-open', 1),
(25, 2, 'Final Project', 'koordinator/finalproject', 'fas fa-fw fa-project-diagram', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_token`
--

INSERT INTO `user_token` (`id`, `email`, `token`, `date_created`) VALUES
(5, 'zakiy4898@gmail.com', 'RABQgZhlq+sIe+5j7wY+L0xPF4YA/p8NQsG0V9y+jzY=', '0000-00-00'),
(6, 'dauuuussss@gmail.com', 'Trn/e0IaGx06cjxOKjPwIWTx6ItZ0ukAhETjmEdydHA=', '0000-00-00'),
(7, 'dauuuussss@gmail.com', 'gFjbbt+7NmQldm4LRtzkIC5Deqab4TwScjF2pR/LqUM=', '0000-00-00'),
(8, 'dauuuussss@gmail.com', 'DQh9jUXT5zCkF+xbwD31c+blCodz7XtWaZER8bzFdsc=', '0000-00-00'),
(9, 'dauuuussss@gmail.com', 'U2UuhCHQTJqXMCOuIp7ExDPPYkDhgzisc9ez2+PmsqM=', '0000-00-00'),
(14, 'firdausnp16@gmail.com', 'Db9oTq4sSJJG9F3MS5AsDzRODXODzN8LaL4m/uE3+hA=', '0000-00-00'),
(15, 'firdausnp16@gmail.com', 'CnOOVJOqexw0vcgbPIQtnbqOSq9Vv0EQ6y6ldN6riMs=', '0000-00-00'),
(16, 'mfikar.md@gmail.com', 'PIRcqLrdKIqKS5OZSqfXvZODzd2Ulr/n5yWsc7phi2c=', '0000-00-00'),
(17, 'firdausnp16@gmail.com', 'jqG8PFK02UV9cC29vliFIQvhjFS45Eam8YXti9SzVRo=', '0000-00-00'),
(18, 'firdausnp16@gmail.com', 'XlEDnMhPPFYCUKVXU65f2Ojn/SYZO2AGjikE2AFnamY=', '0000-00-00'),
(19, 'firdausnp16@gmail.com', 'KV4JP9wOy9bOuhTh9klBowAv60K7JK3lzP3LZGR44RY=', '0000-00-00'),
(20, 'firdausnp16@gmail.com', 'z9ZDHtHFd8RMGESmLqVfS+4QCSzI0eZ81g0Fqf3XwFU=', '0000-00-00'),
(21, 'mpu.hambyah@gmail.com', 'PziMejObVYV8E207p3BPty5TAUU58FzsXGFzfeg4hVc=', '0000-00-00'),
(22, 'niaaldy99@gmail.com', 'GP/qP1a04SxOTfpblFYtlC2HB6ubelZc/lDylGlBcPU=', '0000-00-00'),
(23, 'dauuuussss@gmail.com', 'QCheM9OOITJZ63WUOvPLK37Y/6ZF0Qr/YrhuEwj6Nno=', '0000-00-00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `filebuku`
--
ALTER TABLE `filebuku`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelompok`
--
ALTER TABLE `kelompok`
  ADD PRIMARY KEY (`kelompokID`);

--
-- Indexes for table `kelompok_aslab`
--
ALTER TABLE `kelompok_aslab`
  ADD KEY `IDKelompok` (`IDKelompok`),
  ADD KEY `IDPraktikum` (`IDPraktikum`),
  ADD KEY `IDUser` (`IDUser`);

--
-- Indexes for table `kelompok_praktikan`
--
ALTER TABLE `kelompok_praktikan`
  ADD KEY `IDUser` (`IDUser`),
  ADD KEY `IDKelompok` (`IDKelompok`);

--
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`penilaianID`),
  ADD KEY `IDType` (`IDType`);

--
-- Indexes for table `penilaian_pelanggaran`
--
ALTER TABLE `penilaian_pelanggaran`
  ADD PRIMARY KEY (`pelanggaranID`),
  ADD KEY `IDType` (`IDType`);

--
-- Indexes for table `penilaian_pengurangan`
--
ALTER TABLE `penilaian_pengurangan`
  ADD UNIQUE KEY `Penilaian Pengurangan` (`IDPelanggaran`,`IDPraktikum`,`praktikan`,`aslab`);

--
-- Indexes for table `penilaian_praktikum`
--
ALTER TABLE `penilaian_praktikum`
  ADD UNIQUE KEY `penilaian_praktikum` (`IDPenilaian`,`IDPraktikum`,`praktikan`,`aslab`) USING BTREE;

--
-- Indexes for table `penilaian_rekap`
--
ALTER TABLE `penilaian_rekap`
  ADD UNIQUE KEY `Penilaian Rekap` (`IDPraktikum`,`IDUser`,`IDType`) USING BTREE,
  ADD KEY `IDType` (`IDType`);

--
-- Indexes for table `praktikum`
--
ALTER TABLE `praktikum`
  ADD PRIMARY KEY (`praktikumID`),
  ADD KEY `IDType` (`IDType`);

--
-- Indexes for table `praktikum_type`
--
ALTER TABLE `praktikum_type`
  ADD PRIMARY KEY (`typeID`);

--
-- Indexes for table `timeline_praktikum`
--
ALTER TABLE `timeline_praktikum`
  ADD PRIMARY KEY (`dateID`),
  ADD KEY `praktikumID` (`praktikumID`);

--
-- Indexes for table `timeline_presensi`
--
ALTER TABLE `timeline_presensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dateID` (`dateID`),
  ADD KEY `nrp` (`nrp`);

--
-- Indexes for table `timeline_presensi_kelompok`
--
ALTER TABLE `timeline_presensi_kelompok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dateID` (`dateID`),
  ADD KEY `kelompokID` (`kelompokID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nrp` (`nrp`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `filebuku`
--
ALTER TABLE `filebuku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kelompok`
--
ALTER TABLE `kelompok`
  MODIFY `kelompokID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `penilaianID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `penilaian_pelanggaran`
--
ALTER TABLE `penilaian_pelanggaran`
  MODIFY `pelanggaranID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `praktikum`
--
ALTER TABLE `praktikum`
  MODIFY `praktikumID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `timeline_praktikum`
--
ALTER TABLE `timeline_praktikum`
  MODIFY `dateID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `timeline_presensi`
--
ALTER TABLE `timeline_presensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `timeline_presensi_kelompok`
--
ALTER TABLE `timeline_presensi_kelompok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kelompok_aslab`
--
ALTER TABLE `kelompok_aslab`
  ADD CONSTRAINT `kelompok_aslab_ibfk_1` FOREIGN KEY (`IDKelompok`) REFERENCES `kelompok` (`kelompokID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kelompok_aslab_ibfk_2` FOREIGN KEY (`IDPraktikum`) REFERENCES `praktikum` (`praktikumID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kelompok_aslab_ibfk_3` FOREIGN KEY (`IDUser`) REFERENCES `user` (`nrp`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kelompok_praktikan`
--
ALTER TABLE `kelompok_praktikan`
  ADD CONSTRAINT `kelompok_praktikan_ibfk_1` FOREIGN KEY (`IDUser`) REFERENCES `user` (`nrp`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kelompok_praktikan_ibfk_2` FOREIGN KEY (`IDKelompok`) REFERENCES `kelompok` (`kelompokID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `penilaian_ibfk_1` FOREIGN KEY (`IDType`) REFERENCES `praktikum_type` (`typeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penilaian_pelanggaran`
--
ALTER TABLE `penilaian_pelanggaran`
  ADD CONSTRAINT `penilaian_pelanggaran_ibfk_1` FOREIGN KEY (`IDType`) REFERENCES `praktikum_type` (`typeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penilaian_rekap`
--
ALTER TABLE `penilaian_rekap`
  ADD CONSTRAINT `penilaian_rekap_ibfk_1` FOREIGN KEY (`IDType`) REFERENCES `praktikum_type` (`typeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `praktikum`
--
ALTER TABLE `praktikum`
  ADD CONSTRAINT `praktikum_ibfk_1` FOREIGN KEY (`IDType`) REFERENCES `praktikum_type` (`typeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `timeline_praktikum`
--
ALTER TABLE `timeline_praktikum`
  ADD CONSTRAINT `timeline_praktikum_ibfk_1` FOREIGN KEY (`praktikumID`) REFERENCES `praktikum` (`praktikumID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `timeline_presensi`
--
ALTER TABLE `timeline_presensi`
  ADD CONSTRAINT `timeline_presensi_ibfk_1` FOREIGN KEY (`dateID`) REFERENCES `timeline_praktikum` (`dateID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `timeline_presensi_ibfk_2` FOREIGN KEY (`nrp`) REFERENCES `user` (`nrp`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `timeline_presensi_kelompok`
--
ALTER TABLE `timeline_presensi_kelompok`
  ADD CONSTRAINT `timeline_presensi_kelompok_ibfk_1` FOREIGN KEY (`dateID`) REFERENCES `timeline_praktikum` (`dateID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `timeline_presensi_kelompok_ibfk_2` FOREIGN KEY (`kelompokID`) REFERENCES `kelompok` (`kelompokID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
