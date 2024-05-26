-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Bulan Mei 2024 pada 07.10
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
-- Struktur dari tabel `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `room_id` int(11) DEFAULT NULL,
  `check_in` date DEFAULT NULL,
  `check_out` date DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `bed_type` varchar(100) DEFAULT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `room_type` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price_per_night` decimal(10,2) DEFAULT NULL,
  `bed_type` varchar(50) DEFAULT NULL,
  `max_guests` int(11) DEFAULT NULL,
  `area` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `availability` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rooms`
--

INSERT INTO `rooms` (`id`, `room_type`, `description`, `price_per_night`, `bed_type`, `max_guests`, `area`, `image`, `availability`) VALUES
(21, 'Superior Room', 'Room Facilities\r\nAir conditioning\r\nBlackout curtains\r\nComplimentary bottled water\r\nElectric kettle\r\nMinibar\r\nRefrigerator\r\n\r\n\r\nBathroom Amenities\r\nPrivate bathroom\r\nShower\r\nToiletries\r\nTowels\r\nHair dryer\r\nHydromassage shower head', 500000.00, '2 Twin Bed Or 1 King Bed', 2, 32.00, 'uploads/Property 1=Variant2.svg', NULL),
(23, 'Deluxe Room', 'Room Facilities\r\nAir conditioning\r\nBlackout curtains\r\nComplimentary bottled water\r\nElectric kettle\r\nMinibar\r\nRefrigerator', 99.00, '2 Twin Bed Or 1 King Bed', 2, 32.00, 'uploads/Property 1=Default (1).svg', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `room_availability`
--

CREATE TABLE `room_availability` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `room_availability`
--

INSERT INTO `room_availability` (`id`, `room_id`, `date`, `is_available`) VALUES
(12, 21, '2024-05-25', 1),
(13, 21, '2024-05-25', 1),
(14, 21, '2024-05-25', 1),
(15, 21, '2024-05-25', 1),
(16, 21, '2024-05-25', 1),
(17, 21, '2024-05-25', 1),
(18, 23, '2024-05-05', 1),
(19, 23, '2024-05-06', 1),
(20, 23, '2024-05-07', 1),
(21, 23, '2024-05-08', 1),
(22, 23, '2024-05-09', 1),
(23, 23, '2024-05-10', 1);

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
-- Indeks untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indeks untuk tabel `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `room_availability`
--
ALTER TABLE `room_availability`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_id` (`room_id`);

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
-- AUTO_INCREMENT untuk tabel `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `room_availability`
--
ALTER TABLE `room_availability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Ketidakleluasaan untuk tabel `room_availability`
--
ALTER TABLE `room_availability`
  ADD CONSTRAINT `room_availability_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
