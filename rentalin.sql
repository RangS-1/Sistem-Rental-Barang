-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2026 at 05:10 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rentalin`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang_sewa`
--

CREATE TABLE `barang_sewa` (
  `id` int(11) NOT NULL,
  `peminjam` int(11) DEFAULT NULL,
  `nama_barang` varchar(150) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga_per_hari` int(11) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang_sewa`
--

INSERT INTO `barang_sewa` (`id`, `peminjam`, `nama_barang`, `deskripsi`, `harga_per_hari`, `gambar`, `status`, `created_at`, `alamat`) VALUES
(8, NULL, 'Toyota Sedan', 'Bekas nan Awet', 600000, '1778511923_Toyota_Sedan.png', 1, '2026-05-11 15:05:23', NULL),
(9, 20, 'Thinkpad X13', 'Awet dengan touchscreen', 60000, '1778512066_Thinkpad_X13.jpg', 0, '2026-05-11 15:07:46', 'SMK Wikrama 1 Garut');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `email`, `password`, `role`, `created_at`) VALUES
(19, 'RangS', 'Rangga', 'Wijaya', 'rangga19sj@gmail.com', '$2y$10$oyeZpBzfYsDiKkzoO//2Tu8epDUBDTrhztcV4kSq7sMBCr8Pp6fkC', 'admin', '2026-05-11 15:02:27'),
(20, 'Denz', 'Alfi', 'Alfatih', 'Alfialfatih@gmail.com', '$2y$10$VJDx/ZVkraOaKOik9s9aGeAXRt4dKaTvRGB/LIV4ydwQSDz1gq5XO', 'user', '2026-05-11 15:04:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang_sewa`
--
ALTER TABLE `barang_sewa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peminjam` (`peminjam`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang_sewa`
--
ALTER TABLE `barang_sewa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang_sewa`
--
ALTER TABLE `barang_sewa`
  ADD CONSTRAINT `barang_sewa_ibfk_1` FOREIGN KEY (`peminjam`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
