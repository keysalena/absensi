-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 31, 2025 at 07:18 AM
-- Server version: 10.11.10-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u756850892_absesnsi`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_masuk` time DEFAULT NULL,
  `waktu_pulang` time DEFAULT NULL,
  `log_kegiatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `user_id`, `tanggal`, `waktu_masuk`, `waktu_pulang`, `log_kegiatan`) VALUES
(11, 5, '2025-01-31', '12:04:40', '12:04:47', 'Mainan Ml'),
(12, 6, '2025-01-31', '12:16:16', NULL, NULL),
(13, 9, '2025-01-31', '12:19:51', '12:20:05', 'membuli rifka'),
(14, 11, '2025-01-31', '12:34:12', NULL, NULL),
(15, 12, '2025-01-31', '12:34:31', NULL, NULL),
(16, 13, '2025-01-31', '12:35:43', NULL, NULL),
(17, 14, '2025-01-31', '12:49:50', '12:50:43', 'ngerjainnya tugas'),
(18, 14, '2025-01-31', '12:49:50', '12:50:43', 'ngerjainnya tugas'),
(19, 14, '2025-01-31', '12:49:50', '12:50:43', 'ngerjainnya tugas'),
(20, 14, '2025-01-31', '12:49:50', '12:50:43', 'ngerjainnya tugas'),
(21, 14, '2025-01-31', '12:49:50', '12:50:43', 'ngerjainnya tugas'),
(22, 14, '2025-01-31', '12:49:50', '12:50:43', 'ngerjainnya tugas'),
(23, 14, '2025-01-31', '12:49:50', '12:50:43', 'ngerjainnya tugas');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','Magang','Pegawai') NOT NULL,
  `nama` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `nama`, `created_at`) VALUES
(3, 'admin', '$2y$10$.b/AJPQj8Qv1IbObj7XEzOdzm6wtxnAx4Urv4Ey9QXT5cMVcr3mzi', 'admin', 'Administrator', '2025-01-20 12:52:18'),
(5, 'Annisa', '$2y$10$.LWqW8JDZTITHQ3afU9aN.bTkRUHf8zRlC4RRdtdXYbXF.jIm/Oi2', 'Pegawai', 'Annisa Indah Triwahyuni', '2025-01-31 05:04:26'),
(6, 'pacarjake', '$2y$10$d0zm.Nq8LJB2c5TkmOwPXeuQZ7IVbRg9/.48d81Vgq40WUVM7x0By', 'Magang', 'Rifka warid azzahrah', '2025-01-31 05:16:03'),
(7, 'Adinda02', '$2y$10$y3UPb/c0RgGc.0K6AoN.aOlBj/wb6IyurvOIMdcDvyaEGGKaPmxzy', 'Magang', 'Adinda Adha Auliya', '2025-01-31 05:16:16'),
(8, 'ajenggg', '$2y$10$kzQ4vv5EFsWRDNaj4NruV.dr1OJOxnUYIibeNBxkNeL3QJA9UKzJW', 'Magang', 'Ajeng laraswati', '2025-01-31 05:17:26'),
(9, 'keysa', '$2y$10$8bx./.AY2N.T23MKPtuyhu.EWEHPvJscbB6mdmY0aV7ae3eSEEpqS', 'Magang', 'Keysalena Misdona', '2025-01-31 05:19:32'),
(10, 'ailin', '$2y$10$4FIziABaOZZbq.16JMwKr.dmuPDGhn5Cob/BDxcYyVhqHQjRkX1ii', 'Pegawai', 'Ailin', '2025-01-31 05:28:42'),
(11, 'Exsa', '$2y$10$siLp9Zd3NgW7NW1ELLGt3ePzzhMePiRsbUWy2Tb7N8frcZ/.2JpN6', 'Pegawai', 'Exsa sabrina violita', '2025-01-31 05:33:59'),
(12, 'suciii', '$2y$10$/ZOg3UQ43CGVmLRDCjj.meSe1DfhwClJ6HvzFdQZfkWIM25.5gx1u', 'Pegawai', 'Suci Pangestu ', '2025-01-31 05:34:02'),
(13, 'Dimas', '$2y$10$p/usd2N5EQhFJJVKL4AyTuyeckQDbRkMnIVAfxDX/KhNhtKIFY4Pi', 'Pegawai', 'Dimas', '2025-01-31 05:35:11'),
(14, 'Rayhan', '$2y$10$xZ.Uut35mvb9sMcPvOcpfuG/Mq9T5gpxViRPNW3YdwXShhidGHIvu', 'Magang', 'Afdhaluddin RS', '2025-01-31 05:49:39'),
(15, 'nevianin', '$2y$10$dq6v/ny3Yre.eJfxf5vNv.q57yM/KQTHM0xOOXfh/j8ejfVUBLv4q', 'Magang', 'Nevi Anindita', '2025-01-31 06:38:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
