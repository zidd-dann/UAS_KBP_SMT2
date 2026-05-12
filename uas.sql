-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Bulan Mei 2026 pada 17.37
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uas`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `resiko`
--

CREATE TABLE `resiko` (
  `id` int(11) NOT NULL,
  `resiko` varchar(255) NOT NULL,
  `divisi` enum('Keuangan','Keagamaan','Keamanan','Rumah Tangga','Pendidikan','Pembangunan') NOT NULL,
  `tingkat` enum('Tinggi, Sering','Tinggi, Sedang','Tinggi, Jarang','Sedang, Sering','Sedang, Sedang','Sedang, Jarang','Rendah, Sering','Rendah, Sedang','Rendah, Jarang') NOT NULL,
  `penyebab` varchar(255) NOT NULL,
  `sumber` enum('Internal Kampus','Internal Divisi','Eksternal Kampus','Eksternal Divisi') NOT NULL,
  `mitigasi` varchar(255) NOT NULL,
  `solusi` varchar(255) NOT NULL,
  `status` enum('approved','rejected','pending') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `resiko`
--

INSERT INTO `resiko` (`id`, `resiko`, `divisi`, `tingkat`, `penyebab`, `sumber`, `mitigasi`, `solusi`, `status`) VALUES
(23, 'kesleo', 'Keamanan', 'Rendah, Jarang', 'mletre', 'Internal Divisi', 'ejfbefjebf', 'jebfjbfj', 'approved'),
(25, 'c', 'Keuangan', 'Tinggi, Sering', 'c', 'Internal Kampus', 'nnun', 'edde', 'approved'),
(26, 'kecelakaan kerja', 'Keamanan', 'Sedang, Jarang', 'Diare', 'Internal Divisi', 'Minum Obat', 'Obat', 'approved'),
(28, 'kecelakaan', 'Keamanan', 'Tinggi, Sedang', 'kelalaian', 'Internal Kampus', 'Tinjau Alat keslamatan Kerja', 'Gunakan Alat keslamatan', 'approved');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','User') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(4, 'admin', '$2y$10$6tBMTftPOvMPq3U2CME1VuJ78IpFz0QUI8pNiN4eVxFDd2DQ6VhbC', 'Admin'),
(5, 'user', '$2y$10$zqI5Jtommo6pWW1DaB6NmeWoS0FqPbK0THbfxNoEQujmqSU/PBO.m', 'User'),
(10, 'azka', '$2y$10$lIi27DnzBTCrl3w3FoGQhu7I.9dEtAlDJjCNYHKi4O3WRtqKQUB9.', 'User');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `resiko`
--
ALTER TABLE `resiko`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `resiko`
--
ALTER TABLE `resiko`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
