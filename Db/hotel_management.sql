-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Bulan Mei 2024 pada 14.53
-- Versi server: 10.4.28-MariaDB-log
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel_management`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `availability` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rooms`
--

INSERT INTO `rooms` (`id`, `type`, `image`, `price`, `availability`) VALUES
(1, 'Superior Room', 'uploads/Property 1=Variant2.svg,uploads/room4.avif', 99.00, 1),
(2, 'Deluxe Room', 'uploads/Property 1=Default.svg', 99.00, 3),
(3, 'Junior Room', 'uploads/Property 1=Default (1).svg', 99.00, 2),
(4, 'Executive Suite', 'uploads/room5.svg', 99.00, 4),
(5, 'Executive Suite', 'uploads/room5.svg', 99.00, 2),
(17, 'Superior Room', 'uploads/room4.avif', 99.00, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `room_categories`
--

CREATE TABLE `room_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `room_categories`
--

INSERT INTO `room_categories` (`id`, `name`) VALUES
(1, 'Superior Room'),
(2, 'Deluxe Room'),
(3, 'Junior Room'),
(4, 'Executive Room'),
(5, 'Executive Suite');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `mobile_phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `birth_date` date NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `mobile_phone`, `email`, `birth_date`, `password`, `is_admin`) VALUES
(1, 'Admin', 'User', 'admin', '1234567890', 'admin@example.com', '1990-01-01', '$2y$10$EFZ8u8NHb6mJ3SQEdz.WhO/K3UzaLQeluM4AuCtHHwHMFDf9QhS2W', 1),
(7, 'Aldo', 'Pratama ', 'Aldo', '082184161008', 'aldopratama0707@gmail.com', '2024-05-04', '$2y$10$5HZgmZiHLYExmBYY60uNxeJ4QX/FH9b/0ZPnppHRNEcFSSm1bGIvq', 0),
(12, 'Tama', 'Pratama ', 'Tama', '12345678912', 'aldoptma0407@gmail.com', '2024-05-07', '$2y$10$2/VLtMBm2uLZy/8FYk9uLeEYIhvUwYTqft7vKG1hKP5xEi58vDtLu', 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `room_categories`
--
ALTER TABLE `room_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `room_categories`
--
ALTER TABLE `room_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
