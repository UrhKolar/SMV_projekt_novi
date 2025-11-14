-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gostitelj: 127.0.0.1
-- Čas nastanka: 08. sep 2025 ob 21.31
-- Različica strežnika: 10.4.32-MariaDB
-- Različica PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Zbirka podatkov: `solski_sistem`
--

-- --------------------------------------------------------

--
-- Struktura tabele `gradiva`
--

CREATE TABLE `gradiva` (
  `id` int(11) NOT NULL,
  `predmet_id` int(11) NOT NULL,
  `ucitelj_id` int(11) NOT NULL,
  `naslov` varchar(200) NOT NULL,
  `opis` text DEFAULT NULL,
  `datoteka` varchar(255) DEFAULT NULL,
  `velikost_datoteke` int(11) DEFAULT NULL,
  `tip_datoteke` varchar(50) DEFAULT NULL,
  `datum_nalaganja` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `gradiva`
--

INSERT INTO `gradiva` (`id`, `predmet_id`, `ucitelj_id`, `naslov`, `opis`, `datoteka`, `velikost_datoteke`, `tip_datoteke`, `datum_nalaganja`) VALUES
(1, 1, 2, 'Osnove algebre', 'Uvod v algebrske izraze in enačbe', 'algebra_osnove.pdf', NULL, NULL, '2025-09-06 14:05:02'),
(2, 2, 3, 'Slovenska književnost', 'Pregled slovenske književnosti', 'slovenska_knjizevnost.pdf', NULL, NULL, '2025-09-06 14:05:02'),
(3, 3, 4, 'English Grammar', 'Osnove angleške slovnice', 'english_grammar.pdf', NULL, NULL, '2025-09-06 14:05:02'),
(4, 9, 6, 'Uvod v programiranje', 'Osnove programiranja v Pythonu', 'python_uvod.pdf', NULL, NULL, '2025-09-06 14:05:02'),
(5, 1, 2, 'Kvadratne enačbe', 'Reševanje in uporaba kvadratnih enačb', 'kvadratne_enacbe.pdf', NULL, NULL, '2025-09-07 14:22:09'),
(6, 4, 2, 'Osnove mehanike', 'Kinematika in dinamika', 'osnove_mehanike.pdf', NULL, NULL, '2025-09-07 14:22:09'),
(7, 2, 3, 'Skloni v slovenščini', 'Povzetek sklonov z vajami', 'slovnica_skloni.pdf', NULL, NULL, '2025-09-07 14:22:09'),
(8, 6, 3, 'France Prešeren', 'Življenje in delo F. Prešerna', 'preseren_pregled.pdf', NULL, NULL, '2025-09-07 14:22:09'),
(9, 3, 4, 'Vocabulary: Travel', 'Besedišče na temo potovanj', 'vocabulary_travel.pdf', NULL, NULL, '2025-09-07 14:22:09'),
(10, 7, 4, 'Podnebni pasovi', 'Značilnosti in primeri', 'podnebni_pasovi.pdf', NULL, NULL, '2025-09-07 14:22:09'),
(11, 5, 5, 'Periodni sistem', 'Elementi in njihove lastnosti', 'periodni_sistem.pdf', NULL, NULL, '2025-09-07 14:22:09'),
(12, 8, 5, 'Celični procesi', 'Delitev celic in metabolizem', 'celicni_procesi.pdf', NULL, NULL, '2025-09-07 14:22:09'),
(13, 9, 6, 'Algoritmi in podatkovne strukture', 'Uvodni koncepti', 'algoritmi_uvod.pdf', NULL, NULL, '2025-09-07 14:22:09'),
(14, 1, 6, 'Funkcije in grafi', 'Definicija in risanje grafov', 'funkcije_grafi.pdf', NULL, NULL, '2025-09-07 14:22:09');

-- --------------------------------------------------------

--
-- Struktura tabele `naloge`
--

CREATE TABLE `naloge` (
  `id` int(11) NOT NULL,
  `predmet_id` int(11) NOT NULL,
  `ucenec_id` int(11) NOT NULL,
  `naslov` varchar(200) NOT NULL,
  `opis` text DEFAULT NULL,
  `datoteka` varchar(255) DEFAULT NULL,
  `velikost_datoteke` int(11) DEFAULT NULL,
  `tip_datoteke` varchar(50) DEFAULT NULL,
  `datum_oddaje` timestamp NOT NULL DEFAULT current_timestamp(),
  `ocena` int(11) DEFAULT NULL,
  `komentar` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `naloge`
--

INSERT INTO `naloge` (`id`, `predmet_id`, `ucenec_id`, `naslov`, `opis`, `datoteka`, `velikost_datoteke`, `tip_datoteke`, `datum_oddaje`, `ocena`, `komentar`) VALUES
(1, 1, 7, 'Algebraične enačbe', 'Reševanje algebraičnih enačb', 'mlakar_luka_algebraicne_enacbe.pdf', NULL, NULL, '2025-09-06 14:05:02', NULL, NULL),
(2, 2, 8, 'Analiza pesmi', 'Analiza izbrane pesmi', 'krajnc_sara_analiza_pesmi.pdf', NULL, NULL, '2025-09-06 14:05:02', NULL, NULL),
(3, 9, 9, 'Python program', 'Prvi Python program', 'bernard_nejc_python_program.py', NULL, NULL, '2025-09-06 14:05:02', NULL, NULL),
(4, 1, 7, 'Kvadratne enačbe - naloga', 'Reši 10 kvadratnih enačb', 'mlakar_luka_kvadratne.pdf', NULL, NULL, '2025-09-07 14:22:09', NULL, NULL),
(5, 2, 8, 'Esej: France Prešeren', 'Kratek esej o Prešernu', 'krajnc_sara_preseren.pdf', NULL, NULL, '2025-09-07 14:22:09', NULL, NULL),
(6, 3, 9, 'Essay: My holiday', 'Kratek opis počitnic', 'bernard_nejc_holiday.docx', NULL, NULL, '2025-09-07 14:22:09', NULL, NULL),
(7, 4, 10, 'Gibanje po klancu', 'Izračuni pospeškov in sil', 'kos_eva_klanc.pdf', NULL, NULL, '2025-09-07 14:22:09', NULL, NULL),
(8, 5, 11, 'Reakcije kislin', 'Opis in primeri reakcij', 'vesel_jan_kisline.pdf', NULL, NULL, '2025-09-07 14:22:09', NULL, NULL),
(9, 6, 7, 'Referat: Rimsko cesarstvo', 'Zgodovinski povzetek', 'mlakar_luka_rim.docx', NULL, NULL, '2025-09-07 14:22:09', NULL, NULL),
(10, 7, 8, 'Analiza zemljevida', 'Opis reliefa in podnebja', 'krajnc_sara_zemljevid.pdf', NULL, NULL, '2025-09-07 14:22:09', NULL, NULL),
(11, 8, 9, 'Mikroskopiranje', 'Opazovanja pod mikroskopom', 'bernard_nejc_mikroskop.pdf', NULL, NULL, '2025-09-07 14:22:09', NULL, NULL),
(12, 9, 10, 'HTML in CSS', 'Pripravi preprost spletni projekt', 'kos_eva_html_css.zip', NULL, NULL, '2025-09-07 14:22:09', NULL, NULL),
(13, 2, 11, 'Analiza pesmi II', 'Poglobljena analiza izbrane pesmi', 'vesel_jan_analiza2.pdf', NULL, NULL, '2025-09-07 14:22:09', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabele `predmeti`
--

CREATE TABLE `predmeti` (
  `id` int(11) NOT NULL,
  `naziv` varchar(100) NOT NULL,
  `opis` text DEFAULT NULL,
  `kratica` varchar(10) DEFAULT NULL,
  `datum_dodaje` timestamp NOT NULL DEFAULT current_timestamp(),
  `aktiven` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `predmeti`
--

INSERT INTO `predmeti` (`id`, `naziv`, `opis`, `kratica`, `datum_dodaje`, `aktiven`) VALUES
(1, 'Matematika', 'Osnove matematike in algebra', 'MAT', '2025-09-06 14:05:02', 0),
(2, 'Slovenščina', 'Slovenski jezik in književnost', 'SLO', '2025-09-06 14:05:02', 1),
(3, 'Angleščina', 'Angleški jezik', 'ANG', '2025-09-06 14:05:02', 1),
(4, 'Fizika', 'Osnove fizike', 'FIZ', '2025-09-06 14:05:02', 1),
(5, 'Kemija', 'Osnove kemije', 'KEM', '2025-09-06 14:05:02', 1),
(6, 'Zgodovina', 'Zgodovina Slovenije in sveta', 'ZGO', '2025-09-06 14:05:02', 1),
(7, 'Geografija', 'Geografija Slovenije in sveta', 'GEO', '2025-09-06 14:05:02', 1),
(8, 'Biologija', 'Osnove biologije', 'BIO', '2025-09-06 14:05:02', 1),
(9, 'Računalništvo', 'Osnove računalništva in programiranja', 'RAC', '2025-09-06 14:05:02', 1),
(10, 'Glasba', 'Glasbena vzgoja', 'GLA', '2025-09-06 14:05:02', 1),
(11, 'Likovna vzgoja', 'Likovna vzgoja in umetnost', 'LIK', '2025-09-06 14:05:02', 1),
(12, 'Športna vzgoja', 'Telesna vzgoja', 'TV', '2025-09-06 14:05:02', 1);

-- --------------------------------------------------------

--
-- Struktura tabele `seje`
--

CREATE TABLE `seje` (
  `id` int(11) NOT NULL,
  `uporabnik_id` int(11) NOT NULL,
  `session_token` varchar(255) NOT NULL,
  `datum_ustvarjanja` timestamp NOT NULL DEFAULT current_timestamp(),
  `datum_poteka` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `seje`
--

INSERT INTO `seje` (`id`, `uporabnik_id`, `session_token`, `datum_ustvarjanja`, `datum_poteka`) VALUES
(9, 7, '8339a0048132f9b30ef82c581562b545af9899eb610db779ccad9b73ea5c9dd1', '2025-09-07 14:27:49', '2025-09-08 14:27:49');

-- --------------------------------------------------------

--
-- Struktura tabele `ucenci_predmeti`
--

CREATE TABLE `ucenci_predmeti` (
  `id` int(11) NOT NULL,
  `ucenec_id` int(11) NOT NULL,
  `predmet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `ucenci_predmeti`
--

INSERT INTO `ucenci_predmeti` (`id`, `ucenec_id`, `predmet_id`) VALUES
(1, 7, 1),
(2, 7, 2),
(3, 7, 3),
(21, 7, 4),
(22, 7, 5),
(4, 7, 9),
(5, 8, 1),
(6, 8, 2),
(7, 8, 4),
(8, 8, 5),
(23, 8, 7),
(24, 8, 9),
(25, 9, 1),
(9, 9, 2),
(10, 9, 3),
(11, 9, 6),
(12, 9, 7),
(26, 9, 9),
(13, 10, 1),
(27, 10, 2),
(14, 10, 3),
(28, 10, 7),
(15, 10, 8),
(16, 10, 9),
(29, 11, 1),
(17, 11, 2),
(30, 11, 3),
(18, 11, 4),
(19, 11, 5),
(20, 11, 6);

-- --------------------------------------------------------

--
-- Struktura tabele `ucitelji_predmeti`
--

CREATE TABLE `ucitelji_predmeti` (
  `id` int(11) NOT NULL,
  `ucitelj_id` int(11) NOT NULL,
  `predmet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `ucitelji_predmeti`
--

INSERT INTO `ucitelji_predmeti` (`id`, `ucitelj_id`, `predmet_id`) VALUES
(1, 2, 1),
(16, 2, 2),
(2, 2, 4),
(11, 2, 6),
(12, 3, 1),
(3, 3, 2),
(17, 3, 4),
(4, 3, 6),
(13, 4, 2),
(5, 4, 3),
(6, 4, 7),
(18, 5, 1),
(7, 5, 5),
(14, 5, 7),
(8, 5, 8),
(10, 6, 1),
(15, 6, 3),
(9, 6, 9);

-- --------------------------------------------------------

--
-- Struktura tabele `uporabniki`
--

CREATE TABLE `uporabniki` (
  `id` int(11) NOT NULL,
  `uporabnisko_ime` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `geslo` varchar(255) NOT NULL,
  `tip_uporabnika` enum('admin','ucitelj','ucenec') NOT NULL,
  `ime` varchar(50) NOT NULL,
  `priimek` varchar(50) NOT NULL,
  `datum_registracije` timestamp NOT NULL DEFAULT current_timestamp(),
  `aktiven` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `uporabniki`
--

INSERT INTO `uporabniki` (`id`, `uporabnisko_ime`, `email`, `geslo`, `tip_uporabnika`, `ime`, `priimek`, `datum_registracije`, `aktiven`) VALUES
(2, 'ucitelj1', 'janez.novak@solski-sistem.si', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ucitelj', 'Janez', 'Novak', '2025-09-06 14:05:02', 1),
(3, 'ucitelj2', 'maria.kovač@solski-sistem.si', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ucitelj', 'Marija', 'Kovač', '2025-09-06 14:05:02', 1),
(4, 'ucitelj3', 'peter.horvat@solski-sistem.si', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ucitelj', 'Peter', 'Horvat', '2025-09-06 14:05:02', 1),
(5, 'ucitelj4', 'ana.petek@solski-sistem.si', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ucitelj', 'Ana', 'Petek', '2025-09-06 14:05:02', 1),
(6, 'ucitelj5', 'marko.zupan@solski-sistem.si', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ucitelj', 'Marko', 'Zupan', '2025-09-06 14:05:02', 1),
(7, 'ucenec1', 'luka.mlakar@solski-sistem.si', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ucenec', 'Luka', 'Mlakar', '2025-09-06 14:05:02', 1),
(8, 'ucenec2', 'sara.krajnc@solski-sistem.si', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ucenec', 'Sara', 'Krajnc', '2025-09-06 14:05:02', 1),
(9, 'ucenec3', 'nejc.bernard@solski-sistem.si', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ucenec', 'Nejc', 'Bernard', '2025-09-06 14:05:02', 1),
(10, 'ucenec4', 'eva.kos@solski-sistem.si', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ucenec', 'Eva', 'Kos', '2025-09-06 14:05:02', 1),
(11, 'ucenec5', 'jan.vesel@solski-sistem.si', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ucenec', 'Jan', 'Vesel', '2025-09-06 14:05:02', 1),
(12, 'klemen', 'klemenrozic007@gmail.com', '$2y$10$SvJgs0jkHg.m3KIOG2kuO.mHKELtg3eWp1z9F8FkzuFgtCQOkmCHe', 'ucenec', 'klemen', 'rozic', '2025-09-08 18:41:51', 1),
(21, 'admin', 'admin@example.com', '$2y$10$/Bwx5K/BztTp8F8OI3GeEOTp0fU6GppOQGBelo20FDUAH2Br4rHaW', 'admin', 'Ana', 'Admin', '2025-09-08 19:23:06', 1),
(22, 'ucitelj', 'ucitelj@example.com', '$2y$10$b6WTE0IJmO16wPmLDqfgZuC.h.j40lrGxwAe.gJf6h872uQbPOHwm', 'ucitelj', 'Tina', 'Ucitelj', '2025-09-08 19:23:06', 1);

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `gradiva`
--
ALTER TABLE `gradiva`
  ADD PRIMARY KEY (`id`),
  ADD KEY `predmet_id` (`predmet_id`),
  ADD KEY `ucitelj_id` (`ucitelj_id`);

--
-- Indeksi tabele `naloge`
--
ALTER TABLE `naloge`
  ADD PRIMARY KEY (`id`),
  ADD KEY `predmet_id` (`predmet_id`),
  ADD KEY `ucenec_id` (`ucenec_id`);

--
-- Indeksi tabele `predmeti`
--
ALTER TABLE `predmeti`
  ADD PRIMARY KEY (`id`);

--
-- Indeksi tabele `seje`
--
ALTER TABLE `seje`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `session_token` (`session_token`),
  ADD KEY `uporabnik_id` (`uporabnik_id`);

--
-- Indeksi tabele `ucenci_predmeti`
--
ALTER TABLE `ucenci_predmeti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_ucenec_predmet` (`ucenec_id`,`predmet_id`),
  ADD KEY `predmet_id` (`predmet_id`);

--
-- Indeksi tabele `ucitelji_predmeti`
--
ALTER TABLE `ucitelji_predmeti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_ucitelj_predmet` (`ucitelj_id`,`predmet_id`),
  ADD KEY `predmet_id` (`predmet_id`);

--
-- Indeksi tabele `uporabniki`
--
ALTER TABLE `uporabniki`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uporabnisko_ime` (`uporabnisko_ime`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `gradiva`
--
ALTER TABLE `gradiva`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT tabele `naloge`
--
ALTER TABLE `naloge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT tabele `predmeti`
--
ALTER TABLE `predmeti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT tabele `seje`
--
ALTER TABLE `seje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT tabele `ucenci_predmeti`
--
ALTER TABLE `ucenci_predmeti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT tabele `ucitelji_predmeti`
--
ALTER TABLE `ucitelji_predmeti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT tabele `uporabniki`
--
ALTER TABLE `uporabniki`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `gradiva`
--
ALTER TABLE `gradiva`
  ADD CONSTRAINT `gradiva_ibfk_1` FOREIGN KEY (`predmet_id`) REFERENCES `predmeti` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gradiva_ibfk_2` FOREIGN KEY (`ucitelj_id`) REFERENCES `uporabniki` (`id`) ON DELETE CASCADE;

--
-- Omejitve za tabelo `naloge`
--
ALTER TABLE `naloge`
  ADD CONSTRAINT `naloge_ibfk_1` FOREIGN KEY (`predmet_id`) REFERENCES `predmeti` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `naloge_ibfk_2` FOREIGN KEY (`ucenec_id`) REFERENCES `uporabniki` (`id`) ON DELETE CASCADE;

--
-- Omejitve za tabelo `seje`
--
ALTER TABLE `seje`
  ADD CONSTRAINT `seje_ibfk_1` FOREIGN KEY (`uporabnik_id`) REFERENCES `uporabniki` (`id`) ON DELETE CASCADE;

--
-- Omejitve za tabelo `ucenci_predmeti`
--
ALTER TABLE `ucenci_predmeti`
  ADD CONSTRAINT `ucenci_predmeti_ibfk_1` FOREIGN KEY (`ucenec_id`) REFERENCES `uporabniki` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ucenci_predmeti_ibfk_2` FOREIGN KEY (`predmet_id`) REFERENCES `predmeti` (`id`) ON DELETE CASCADE;

--
-- Omejitve za tabelo `ucitelji_predmeti`
--
ALTER TABLE `ucitelji_predmeti`
  ADD CONSTRAINT `ucitelji_predmeti_ibfk_1` FOREIGN KEY (`ucitelj_id`) REFERENCES `uporabniki` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ucitelji_predmeti_ibfk_2` FOREIGN KEY (`predmet_id`) REFERENCES `predmeti` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
