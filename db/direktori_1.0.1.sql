-- --------------------------------------------------------
-- Host:                         10.19.202.233
-- Server version:               5.6.33-0ubuntu0.14.04.1 - (Ubuntu)
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for direktori_1.0.1
CREATE DATABASE IF NOT EXISTS `direktori_1.0.1` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `direktori_1.0.1`;


-- Dumping structure for table direktori_1.0.1.ahli
CREATE TABLE IF NOT EXISTS `ahli` (
  `ahli_id` int(11) NOT NULL AUTO_INCREMENT,
  `ahli_kump_id` int(11) NOT NULL,
  `ahli_staf_id` int(11) NOT NULL,
  `ahli_jawatan` varchar(255) DEFAULT NULL,
  `ahli_hirarki` int(11) NOT NULL DEFAULT '0',
  `ahli_catatan` text,
  `ahli_tambah` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ahli_kemaskini` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ahli_id`),
  KEY `Kumpulan_idx` (`ahli_kump_id`),
  KEY `Staff_idx` (`ahli_staf_id`),
  CONSTRAINT `Kumpulan` FOREIGN KEY (`ahli_kump_id`) REFERENCES `kumpulan` (`kump_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `Staff` FOREIGN KEY (`ahli_staf_id`) REFERENCES `staf` (`staf_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table direktori_1.0.1.akses
CREATE TABLE IF NOT EXISTS `akses` (
  `aks_id` int(11) NOT NULL AUTO_INCREMENT,
  `aks_nama` varchar(45) DEFAULT NULL,
  `aks_tambah` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `aks_kemaskini` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`aks_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table direktori_1.0.1.kumpulan
CREATE TABLE IF NOT EXISTS `kumpulan` (
  `kump_id` int(11) NOT NULL AUTO_INCREMENT,
  `kump_nama` varchar(255) NOT NULL,
  `kump_alamat` tinytext,
  `kump_poskod` varchar(45) DEFAULT NULL,
  `kump_negeri` varchar(255) DEFAULT NULL,
  `kump_tel` varchar(45) DEFAULT NULL,
  `kump_tel_samb` varchar(20) DEFAULT NULL,
  `kump_fax` varchar(45) DEFAULT NULL,
  `kump_emel` varchar(255) DEFAULT NULL,
  `kump_hirarki` int(11) NOT NULL DEFAULT '0',
  `kump_catatan` text,
  `kump_tambah` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `kump_kemaskini` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`kump_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table direktori_1.0.1.organisasi
CREATE TABLE IF NOT EXISTS `organisasi` (
  `org_id` int(11) NOT NULL AUTO_INCREMENT,
  `org_sub_org_id` int(11) DEFAULT NULL COMMENT 'Organisasi Induk',
  `org_nama` varchar(255) NOT NULL,
  `org_alamat` tinytext,
  `org_poskod` varchar(45) DEFAULT NULL,
  `org_negeri` varchar(255) DEFAULT NULL,
  `org_negara` varchar(255) DEFAULT NULL,
  `org_tel` varchar(45) DEFAULT NULL,
  `org_tel_samb` varchar(20) DEFAULT NULL,
  `org_fax` varchar(45) DEFAULT NULL,
  `org_emel` varchar(255) DEFAULT NULL,
  `org_hirarki` int(11) NOT NULL DEFAULT '0',
  `org_papar_sub` enum('Tidak','Ya') NOT NULL DEFAULT 'Tidak',
  `org_catatan` text,
  `org_tambah` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `org_kemaskini` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`org_id`),
  KEY `Sub Organisasi_idx` (`org_sub_org_id`),
  CONSTRAINT `Sub Organisasi` FOREIGN KEY (`org_sub_org_id`) REFERENCES `organisasi` (`org_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table direktori_1.0.1.penjawatan
CREATE TABLE IF NOT EXISTS `penjawatan` (
  `pjwn_id` int(11) NOT NULL AUTO_INCREMENT,
  `pjwn_staf_id` int(11) DEFAULT NULL,
  `pjwn_penyelia_pjwn_id` int(11) DEFAULT NULL COMMENT 'pjwn_id Penyelia',
  `pjwn_gelaran` varchar(255) DEFAULT NULL COMMENT 'Gelaran Jawatan. Cth: Setiausaha Bahagian',
  `pjwn_kod` varchar(45) DEFAULT NULL COMMENT 'Singkatan Gelaran Jawatan. Cth: SUB(M)',
  `pjwn_gred` varchar(45) DEFAULT NULL,
  `pjwn_tel` varchar(45) DEFAULT NULL,
  `pjwn_tel_samb` varchar(20) DEFAULT NULL,
  `pjwn_org_id` int(11) NOT NULL,
  `pjwn_hirarki` int(11) NOT NULL DEFAULT '0',
  `pjwn_catatan` text,
  `pjwn_tambah` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pjwn_kemaskini` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`pjwn_id`),
  UNIQUE KEY `pjwn_kod_UNIQUE` (`pjwn_kod`),
  KEY `Penjawatan Staf_idx` (`pjwn_staf_id`),
  KEY `Penjawatan Organisasi_idx` (`pjwn_org_id`),
  KEY `Penjawatan Penyelia_idx` (`pjwn_penyelia_pjwn_id`),
  CONSTRAINT `Penjawatan Organisasi` FOREIGN KEY (`pjwn_org_id`) REFERENCES `organisasi` (`org_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `Penjawatan Penyelia` FOREIGN KEY (`pjwn_penyelia_pjwn_id`) REFERENCES `penjawatan` (`pjwn_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `Penjawatan Staf` FOREIGN KEY (`pjwn_staf_id`) REFERENCES `staf` (`staf_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table direktori_1.0.1.pentadbir
CREATE TABLE IF NOT EXISTS `pentadbir` (
  `ptdb_id` int(11) NOT NULL AUTO_INCREMENT,
  `ptdb_staf_id` int(11) NOT NULL,
  `ptdb_katalaluan` varchar(255) NOT NULL,
  `ptdb_aks_id` int(11) NOT NULL,
  `ptdb_tambah` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ptdb_kemaskini` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ptdb_id`),
  UNIQUE KEY `admn_staff_auto_id_UNIQUE` (`ptdb_staf_id`),
  KEY `Staff_idx` (`ptdb_staf_id`),
  KEY `Jenis Capaian_idx` (`ptdb_aks_id`),
  CONSTRAINT `Jenis Capaian` FOREIGN KEY (`ptdb_aks_id`) REFERENCES `akses` (`aks_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `Staff Admin` FOREIGN KEY (`ptdb_staf_id`) REFERENCES `staf` (`staf_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table direktori_1.0.1.pentadbir_organisasi
CREATE TABLE IF NOT EXISTS `pentadbir_organisasi` (
  `ptor_id` int(11) NOT NULL AUTO_INCREMENT,
  `ptor_ptdb_id` int(11) NOT NULL,
  `ptor_org_id` int(11) NOT NULL,
  `ptor_status` enum('Aktif','Tidak Aktif') NOT NULL DEFAULT 'Aktif',
  `ptor_tambah` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ptor_kemaskini` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ptor_id`),
  KEY `Pentadbir_idx` (`ptor_ptdb_id`),
  KEY `Organisasi_idx` (`ptor_org_id`),
  CONSTRAINT `Organisasi` FOREIGN KEY (`ptor_org_id`) REFERENCES `organisasi` (`org_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `Pentadbir` FOREIGN KEY (`ptor_ptdb_id`) REFERENCES `pentadbir` (`ptdb_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table direktori_1.0.1.staf
CREATE TABLE IF NOT EXISTS `staf` (
  `staf_id` int(11) NOT NULL AUTO_INCREMENT,
  `staf_mykad` varchar(45) DEFAULT NULL,
  `staf_gelaran` varchar(45) DEFAULT NULL,
  `staf_nama` varchar(255) NOT NULL,
  `staf_jawatan` varchar(255) DEFAULT NULL,
  `staf_gred` varchar(45) DEFAULT NULL,
  `staf_taraf` varchar(45) DEFAULT NULL COMMENT 'Tetap, Kontrak, Sementara',
  `staf_emel` varchar(255) DEFAULT NULL,
  `staf_status` enum('Aktif','Tidak Aktif') NOT NULL DEFAULT 'Aktif',
  `staf_catatan` text,
  `staf_tambah` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `staf_kemaskini` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`staf_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
