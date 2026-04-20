-- MySQL dump 10.13  Distrib 9.0.1, for Win64 (x86_64)
-- Host: 127.0.0.1    Database: eskkd_db
-- ------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!50503 SET NAMES utf8mb4 */
;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */
;
/*!40103 SET TIME_ZONE='+00:00' */
;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */
;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */
;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */
;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */
;

-- ------------------------------------------------------
-- 1. Table structure for table `sys_settings`
-- ------------------------------------------------------
DROP TABLE IF EXISTS `sys_settings`;

CREATE TABLE `sys_settings` (
    `key_name` varchar(50) NOT NULL,
    `key_value` varchar(100) DEFAULT NULL,
    PRIMARY KEY (`key_name`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

LOCK TABLES `sys_settings` WRITE;

INSERT INTO `sys_settings` VALUES ( 'last_backup', '12 March 2026' );

UNLOCK TABLES;

-- ------------------------------------------------------
-- 2. Table structure for table `users`
-- ------------------------------------------------------
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
    `id_user` int NOT NULL AUTO_INCREMENT,
    `nama_lengkap` varchar(100) NOT NULL,
    `username` varchar(100) NOT NULL,
    `password` varchar(255) NOT NULL,
    `role` enum('Petugas Loket', 'Admin') NOT NULL,
    `created_at` datetime DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL,
    `last_login` datetime DEFAULT NULL,
    PRIMARY KEY (`id_user`)
) ENGINE = InnoDB AUTO_INCREMENT = 20 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

LOCK TABLES `users` WRITE;

INSERT INTO
    `users`
VALUES (
        12,
        'Administrator',
        'admin',
        '$2y$10$cmH5SSQRqNC9YA7PdjgX3u0a1vS9NH6n9qKS/nz7TmDYtb7PTrOBW',
        'Admin',
        '2026-01-19 07:37:59',
        '2026-04-16 09:12:43',
        '2026-04-16 09:12:43'
    ),
    (
        16,
        'Budi Santoso',
        'budi',
        '$2y$10$Q8/ZZ0csbIRj2sFlSmF7EeICNFhc09Agw/cujztpMvAu0INLm4xK.',
        'Petugas Loket',
        '2026-02-18 06:40:49',
        '2026-02-18 06:41:09',
        '2026-02-18 06:41:09'
    ),
    (
        17,
        'Rizqiyah',
        'iky123',
        '$2y$10$7hVRNTVAsxz4hXozt1bGHOzjGirg2nmgDhdSZ6EUalbbeVIUEt1cS',
        'Petugas Loket',
        '2026-03-12 04:18:30',
        '2026-03-12 11:39:58',
        '2026-03-12 11:39:58'
    ),
    (
        19,
        'Budi',
        'iky',
        '$2y$10$PX9vdzplmur64giS6Z4pSekmC32dae81WJM6g/mqv5oxQCIygX9p2',
        'Admin',
        '2026-03-12 04:34:07',
        '2026-03-12 04:34:07',
        NULL
    );

UNLOCK TABLES;

-- ------------------------------------------------------
-- 3. Table structure for table `dokter`
-- ------------------------------------------------------
DROP TABLE IF EXISTS `dokter`;

CREATE TABLE `dokter` (
    `id_dokter` int NOT NULL AUTO_INCREMENT,
    `nama_dokter` varchar(150) NOT NULL,
    `nomor_identitas` varchar(50) NOT NULL,
    `created_by` int DEFAULT NULL,
    `created_at` datetime DEFAULT NULL,
    `updated_by` int DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL,
    PRIMARY KEY (`id_dokter`)
) ENGINE = InnoDB AUTO_INCREMENT = 10 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

LOCK TABLES `dokter` WRITE;

INSERT INTO
    `dokter`
VALUES (
        5,
        'DR. EVA SARAH SIREGAR',
        'SIP. MR91712509005441',
        12,
        '2026-01-19 08:52:59',
        12,
        '2026-01-19 08:55:50'
    ),
    (
        6,
        'DR. EMILIA M SITUMORANG',
        'NIP. 19810322 200909 2 001',
        12,
        '2026-01-19 08:54:26',
        12,
        '2026-01-19 08:55:42'
    ),
    (
        7,
        'DR. IRWANSYAH ABDULAH.S',
        'SIP 33/SIP.dr/IV-/DPM&PTSP/2025',
        12,
        '2026-01-19 08:56:14',
        NULL,
        '2026-01-19 08:56:14'
    );

UNLOCK TABLES;

-- ------------------------------------------------------
-- 4. Table structure for table `pasien`
-- ------------------------------------------------------
DROP TABLE IF EXISTS `pasien`;

CREATE TABLE `pasien` (
    `id_pasien` int NOT NULL AUTO_INCREMENT,
    `nama_lengkap` varchar(150) NOT NULL,
    `nik` varchar(16) NOT NULL,
    `tempat_lahir` varchar(100) NOT NULL,
    `tanggal_lahir` date NOT NULL,
    `jenis_kelamin` enum('L', 'P') NOT NULL,
    `pekerjaan` varchar(100) NOT NULL,
    `alamat` text NOT NULL,
    `created_by` int DEFAULT NULL,
    `created_at` datetime DEFAULT NULL,
    `updated_by` int DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL,
    PRIMARY KEY (`id_pasien`)
) ENGINE = InnoDB AUTO_INCREMENT = 12 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

LOCK TABLES `pasien` WRITE;

INSERT INTO
    `pasien`
VALUES (
        5,
        'RIZQIYAH',
        '9109889098380458',
        'JEMBER',
        '2025-12-31',
        'P',
        'HVNN',
        'HVHNVN',
        10,
        '2026-01-19 05:05:33',
        NULL,
        '2026-01-19 05:05:33'
    ),
    (
        8,
        'JUNIARTI S DUWIRI',
        '3509094904050001',
        'ABEPURA',
        '2003-06-17',
        'P',
        'HACKER',
        'JL.GERILYAWAN KAMKEY ',
        12,
        '2026-01-22 03:47:25',
        12,
        '2026-01-23 03:22:38'
    );

UNLOCK TABLES;

-- ------------------------------------------------------
-- 5. Table structure for table `pendaftaran_skkd`
-- ------------------------------------------------------
DROP TABLE IF EXISTS `pendaftaran_skkd`;

CREATE TABLE `pendaftaran_skkd` (
    `id_pendaftaran` int NOT NULL AUTO_INCREMENT,
    `status` enum(
        'Menunggu',
        'Terverifikasi',
        'Selesai'
    ) DEFAULT 'Menunggu',
    `tanggal_periksa` date NOT NULL,
    `tinggi_badan` int DEFAULT NULL,
    `berat_badan` int DEFAULT NULL,
    `golongan_darah` enum('A', 'B', 'AB', 'O') NOT NULL,
    `tekanan_darah` varchar(20) NOT NULL,
    `keperluan_surat` varchar(255) NOT NULL,
    `id_pasien` int NOT NULL,
    `id_dokter` int NOT NULL,
    `created_by` int DEFAULT NULL,
    `created_at` datetime DEFAULT NULL,
    `updated_by` int DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL,
    PRIMARY KEY (`id_pendaftaran`),
    KEY `fk_periksa_pasien` (`id_pasien`),
    KEY `fk_periksa_dokter` (`id_dokter`),
    CONSTRAINT `fk_periksa_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT `fk_periksa_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 23 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

LOCK TABLES `pendaftaran_skkd` WRITE;

INSERT INTO
    `pendaftaran_skkd`
VALUES (
        20,
        'Selesai',
        '2026-03-12',
        168,
        80,
        'B',
        '120/90',
        'Melamar',
        5,
        5,
        12,
        '2026-03-12 05:05:48',
        12,
        '2026-03-12 05:06:39'
    ),
    (
        21,
        'Terverifikasi',
        '2026-03-12',
        120,
        85,
        'B',
        '120/90',
        'Melamar',
        5,
        6,
        12,
        '2026-03-12 05:15:53',
        12,
        '2026-04-15 03:15:33'
    ),
    (
        22,
        'Terverifikasi',
        '2026-03-12',
        70,
        90,
        'A',
        '120/80',
        'csjhd  jhbjkbres',
        5,
        5,
        17,
        '2026-03-12 11:40:49',
        12,
        '2026-04-15 09:09:07'
    );

UNLOCK TABLES;

-- ------------------------------------------------------
-- 6. Table structure for table `skkd`
-- ------------------------------------------------------
DROP TABLE IF EXISTS `skkd`;

CREATE TABLE `skkd` (
    `id_skkd` int NOT NULL AUTO_INCREMENT,
    `nomor_surat` varchar(50) NOT NULL,
    `id_pendaftaran` int NOT NULL,
    `created_by` int DEFAULT NULL,
    `created_at` datetime DEFAULT NULL,
    `updated_by` int DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL,
    PRIMARY KEY (`id_skkd`),
    UNIQUE KEY `nomor_surat` (`nomor_surat`),
    KEY `fk_skkd_periksa` (`id_pendaftaran`),
    CONSTRAINT `fk_skkd_periksa` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran_skkd` (`id_pendaftaran`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 20 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

LOCK TABLES `skkd` WRITE;

INSERT INTO
    `skkd`
VALUES (
        17,
        '440 / 2 / III / 2026',
        20,
        12,
        '2026-03-12 05:06:33',
        NULL,
        '2026-03-12 05:06:33'
    ),
    (
        18,
        '440 / 3 / IV / 2026',
        21,
        12,
        '2026-04-15 03:15:33',
        NULL,
        '2026-04-15 03:15:33'
    ),
    (
        19,
        '440 / 4 / IV / 2026',
        22,
        12,
        '2026-04-15 09:09:07',
        NULL,
        '2026-04-15 09:09:07'
    );

UNLOCK TABLES;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */
;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */
;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */
;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */
;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */
;