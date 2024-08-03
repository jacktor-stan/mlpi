-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 03 Agu 2024 pada 17.58
-- Versi server: 8.0.30
-- Versi PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mlpi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `event`
--

CREATE TABLE `event` (
  `user_id` int NOT NULL,
  `event` varchar(1) NOT NULL DEFAULT '0',
  `event_image` varchar(100) NOT NULL,
  `image_title` mediumtext NOT NULL,
  `image_description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `event`
--

INSERT INTO `event` (`user_id`, `event`, `event_image`, `image_title`, `image_description`) VALUES
(1, '2', '', '', ''),
(2, '1', '', '', ''),
(3, '0', '', '', ''),
(4, '0', '', '', ''),
(5, '0', '', '', ''),
(6, '0', '', '', ''),
(7, '0', '', '', ''),
(8, '2', 'Blast_event_284.png', 'Linda spark', 'Yeah That my girlfriend '),
(9, '0', '', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `type` varchar(10) NOT NULL,
  `register` enum('Y','N') NOT NULL DEFAULT 'Y',
  `event_title` varchar(100) NOT NULL,
  `event_description` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`type`, `register`, `event_title`, `event_description`) VALUES
('event', 'Y', 'Buka Pendaftaran', '<b>Informasi</b>\nEvent dimulai pada tanggal:  Tidak ditentukan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `bio` varchar(225) NOT NULL DEFAULT 'Hallo, Saya adalah anggota MLPI',
  `profile_image` varchar(100) NOT NULL DEFAULT 'images/default.png',
  `account` varchar(10) NOT NULL DEFAULT 'member',
  `active` enum('Y','N') NOT NULL DEFAULT 'N',
  `code` varchar(10) NOT NULL,
  `token` varchar(225) NOT NULL,
  `registered` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `firstname`, `lastname`, `bio`, `profile_image`, `account`, `active`, `code`, `token`, `registered`) VALUES
(1, 'admin', 'admin@jacktor.com', '$2y$10$gXOO.0y.jKEI2UW6s03SOuyJic1q2ghabF5zCq.S9RFfzp2rQsade', 'Admin', 'Jacktor', 'Admin Utama/Leader MLPI', 'images/avatar/profile_6.png', 'developer', 'Y', '', 'NpQxZFLUUUjIpgZqlCIVJDwEDSEHKXRRKUXUMPRRVPPTXPOYUS', '2018-01-29 07:29:32'),
(2, 'Rafli', 'muhammad.rafli.ok@gmail.com', '$2y$10$Oe.Pj9IfECeRJtLcXAqrBujn5lbdJ6Ln2D29b7juc8DmzotxdE462', 'Muhammad', 'Rafli', 'Admin MLPI, saya wakil admin utama', 'images/avatar/profile_6.png', 'admin', 'Y', '', 'KvD77bYInbNHmGGRmKNENMRKtSsKHNyQUYHQKWWWXTKRMZMZSZ', '2019-06-02 15:41:42'),
(3, 'Arikichifu', 'sityhusnulkhotimahhusnul520@gmail.com', '$2y$10$mlDqBL7mHDzDkVsspFEqk.kvkLZbRV5NO9MrwuzH7np14Cgk5Ojie', 'Arikichifu', 'Ridoaritodota', 'Saya admin MLPI dari ISMLP', 'images/avatar/profile_4.png', 'admin', 'Y', '', 'YT7ZvMhFWfqeiFnzLNutrDHDFPZLAAYVIYZLRIITNWLJQOXUQV', '2019-06-02 17:05:32'),
(4, 'Bima', 'naufalhafizh@gmail.com', '$2y$10$Ccmdk/5xr623G3rW1Jc0MOlkGlk8apKnlovpN0f9.YL.8yBnlhFUi', 'Naufal', 'Hafizh', 'Saya adalah moderator MLPI, Ashiaappp!', 'images/avatar/profile_4.png', 'moderator', 'Y', '', 'yfSN6nQWIKgdlyKukqZsIOuBKZEGWJISDzJVMQNULNNWTVSXQX', '2019-06-02 05:02:42'),
(5, 'TPriyadi', 'tegarpriyadi021@gmail.com', '$2y$10$naozZ5J.IWjQNJSccI3cA.oI.ziRqVnBHAtITRLYkgzh9Gk3O16fi', 'Tegar', 'Priyadi', 'Hallo, Saya adalah anggota MLPI', 'images/avatar/profile_1.png', 'moderator', 'Y', '', 'nn5RkRcIUTVsmECvEpELywFXEsWKxGGEKOYNTREQONZVOWRNVY', '2019-06-03 07:17:12'),
(6, 'jonikortek', 'cjkortek123@gmail.com', '$2y$10$GND/uk1sVmhzh50iZHYqwenVdGbpJAUsXQJAQHL0XUDaCQ.3wOow.', 'Diamond', 'Kortek', 'Hallo, Saya adalah anggota MLPI', 'images/avatar/profile_5.png', 'moderator', 'Y', '', 'f6xq9alfLuwYjNUqTJSnGpvIwPDAJWAJAUUSUQTHTZJKTSTRWT', '2019-06-03 00:50:28'),
(7, 'NissaWalker', 'anissarahmawati563@gmail.com', '$2y$10$yC8sy8n/Y6Pk.zwuwMGCl.AHzKEJqAvv/bP21cNLkiZA3rcLZ466O', 'Anissa', 'Rahmawati', 'Hallo, Saya adalah anggota MLPI', 'images/avatar/profile_5.png', 'moderator', 'Y', 'MLPI-2053', 'OxgwsqTwXZHQAgWqpBvzILIIDyRNAYHQSPTCZEFJYPMLZLYNYQ', '2019-06-16 02:15:52'),
(8, 'Blast', 'gilpermana1396@gmail.com', '$2y$10$Do78E1.7oKjMnFmIcL3hueYI25/LuuC75MiWtj5fkZexZTs.iojRW', 'Harisqi', 'Pratama', 'Be The One ?', 'images/avatar/profile_4.png', 'admin', 'Y', 'MLPI-4199', 'pj8EHXUPlMGHxLiHiLOuzYJSLvRFBYEGRSHEIDEZMYMTPWMWVU', '2019-09-05 10:46:49'),
(9, 'Bilqis27', 'muhammadkholidmuzakky12@gmail.com', '$2y$10$fNqBWh2iZxHZTltdzvliX.JP/EfMJsbbvYlDCiyxOOA51b.UEStMK', 'Bilqis', 'Amalia', 'Hallo, Saya adalah anggota MLPI', 'images/avatar/profile_5.png', 'member', 'Y', 'MLPI-1588', 'eCVMOLiKyktwAmLPHCnKrHMRDLNuQTBzFRPGWWHUKYUZPPUPPR', '2019-09-13 23:28:01');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`user_id`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`type`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
