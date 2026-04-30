-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2026 at 04:06 AM
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
  `nama_barang` varchar(150) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga_per_hari` int(11) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang_sewa`
--

INSERT INTO `barang_sewa` (`id`, `nama_barang`, `deskripsi`, `harga_per_hari`, `gambar`, `status`, `created_at`) VALUES
(5, 'Thinkpad X13', 'Beh', 20000, 'Poster-MBG.png', 1, '2026-04-29 06:28:32'),
(6, 'Toyota Avanza', 'Hanya Mobil Dawg', 345000, 'Entahlah, Masih Testing!', 0, '2026-04-29 13:17:13');

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
(12, 'RangS', '1', '2', 'A@M.com', '$2y$10$nVHratdbTdGF9xeCnAe07OO.E3.YYyc8EZv/W9nBaL6DIhCh4qocW', 'user', '2026-04-29 13:06:07'),
(13, 'Aidil', 'a', 'i', 'ai@gmail.com', '$2y$10$qC86n9LxMiHYM844M3nYLem2PlnilBTAZVWo3q0PNe8ptcyPeJqf2', 'user', '2026-04-29 13:32:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang_sewa`
--
ALTER TABLE `barang_sewa`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
