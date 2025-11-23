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
(21, 'admin', 'admin@example.com', '$2y$10$/Bwx5K/BztTp8F8OI3GeEOTp0fU6GppOQGBelo20FDUAH2Br4rHaW', 'admin', 'Urh', 'Admin', '2025-09-08 19:23:06', 1),
(22, 'ucitelj', 'ucitelj@example.com', '$2y$10$b6WTE0IJmO16wPmLDqfgZuC.h.j40lrGxwAe.gJf6h872uQbPOHwm', 'ucitelj', 'Tina', 'Ucitelj', '2025-09-08 19:23:06', 1),
(23, 'ucenec6', 'tihumus.lukus@solski-sistem.si', '$2y$10$k5.Q/TPGsIvAu7ArW843m.aHLSuEbiKiqBP8nnHtPfR63n09BNi2K', 'ucenec', 'Tihomus', 'Lukus', '2025-11-21 15:23:46', 1),
(24, 'ucitelj6', 'matic.novak@solski-sistem.si', '$2y$10$qjntoj9ATrvV.cafYwxY7eF2f5rahr7GWy8tnmgIVI/YKWT.ea.rO', 'ucitelj', 'Matic', 'Novak', '2025-11-21 15:26:35', 1),
(25, 'ucitelj7', 'val.hrastec@solski-sistem.si', '$2y$10$EgtwgOE1OqrmB3SIKLBFX.Qfh6v.MHa2eGdgu3DPR1oZ43SDGLqgq', 'ucitelj', 'Val', 'Hrastec', '2025-11-23 11:18:42', 1),
(26, 'ucitelj8', 'bor.slemenik@solski-ssitem.si', '$2y$10$KNRq4N8lHly0SjkWoZsdLuqsCyVVQbwIV47wbwYeF.OxTnX4RiQZG', 'ucitelj', 'Bor', 'Slemenik', '2025-11-23 11:20:26', 1),
(27, 'ucitelj9', 'ana.brezovnik@solski-sistem.si', '$2y$10$4uGTq4lxKUKPWabQMNBb.e40SO0ZxsHDz6mnq3mYVhI/dNzm7g/8C', 'ucitelj', 'Ana', 'Brezovnik', '2025-11-23 11:21:09', 1),
(28, 'ucitelj10', 'jan.kor@solski-sistem.si', '$2y$10$.GI5QgCbxASmmzKdVS54hOHQOcN7TmBRoPRfCR9N2vytw.8ZOKdGy', 'ucitelj', 'Jan', 'Kor', '2025-11-23 11:21:45', 1),
(29, 'ucitelj11', 'bojan.resnik@solski-sistem.si', '$2y$10$rXyfTZynbzrtVVXFPq5nI.Km1Fhj4bjXB/3vNwZIdm4vPK5a61xum', 'ucitelj', 'Bojan', 'Resnik', '2025-11-23 11:22:20', 1),
(30, 'ucitelj12', 'tanaja.jencic@solski-sistem.si', '$2y$10$oPUXK9PMwi.N/ZH5TxwH8eycHAmoGh40NoygS1Na4jV94MI.Hn0WS', 'ucitelj', 'Tanaja', 'Jenčič', '2025-11-23 11:22:59', 1),
(31, 'ucitelj13', 'katja.kolnik@solski-sistem.si', '$2y$10$bhnD2e2ksunMlR3J1CfnCeA3swUg1jKW8qDlPw4r7X3wadPLNZP0a', 'ucitelj', 'Katja', 'Kolnik', '2025-11-23 11:23:39', 1),
(32, 'ucitelj14', 'miha.vihar@solski-sistem.si', '$2y$10$bD90JbRxs21Li97j9LQSQ./JRHMrPMzLMRWiLyS5syQxtlFyTmwSW', 'ucitelj', 'Miha', 'Vihar', '2025-11-23 11:24:20', 1),
(33, 'ucitelj15', 'natasa.kovac@soslki-sistem.si', '$2y$10$DReLWjfTNvP2VMJS3xfmwuycatCSJhCHwfcskWV3oSp8Fc1j4iSMq', 'ucitelj', 'Nataša', 'Kovač', '2025-11-23 11:25:09', 1),
(34, 'ucitelj16', 'anze.puskin@solski-sistem.si', '$2y$10$RCFmHNT2F6wI/bIsqYXCh.kojANioD06/OY6oYPKfotjhwPNW/m3m', 'ucitelj', 'Anže', 'Puškin', '2025-11-23 11:25:40', 1),
(35, 'ucitelj17', 'bostjan.bor@solski-sistem.si', '$2y$10$7qGUijk2h47l1RFh7mIUgOSeOzjLo5MfKiKO.ZgSENJ8X3hqO8GRK', 'ucitelj', 'Boštjan', 'Bor', '2025-11-23 11:26:17', 1),
(36, 'ucitelj18', 'zan.pusnik@solski-sistem.si', '$2y$10$tQ2p9c7X43l7zHAnncMy/e.4QNdEvigzvi.UN/PJuR9X.s0AEhj3W', 'ucitelj', 'Žan', 'Pušnik', '2025-11-23 11:26:54', 1),
(37, 'ucitelj19', 'oskar.zaga@solski-sistem.si', '$2y$10$9c3CUsMigXTo5uk9kx6DDupY6.ijVBcCBAPdjmTs7hbdSmlJHmugq', 'ucitelj', 'Oskar', 'Žaga', '2025-11-23 11:27:32', 1),
(38, 'ucitelj20', 'matej.folder@solski-sistem.si', '$2y$10$D01HASxkKXkwVUB7DZosR.mdKsSlEPr0MiMdh/pjCPXoQfij026dW', 'ucitelj', 'Matej', 'Folder', '2025-11-23 11:28:17', 1),
(39, 'ucenec7', 'ana.kovac@solski-sistem.si', '$2y$10$RFcwUZpjO7Y.Ck4cDWjt1ugamr7upK0DkNXvRtpjh6zuCiKt7Yoci', 'ucenec', 'Ana', 'Kovač', '2025-11-23 11:32:49', 1),
(40, 'ucenec8', 'miha.novak@solski-sistem.si', '$2y$10$WPUBEV8TaGn5WzWALsApm.0aKg96bYmRjZtoq7diPutq1lRmmpoyi', 'ucenec', 'Miha', 'Novak', '2025-11-23 11:33:58', 1),
(41, 'ucenec9', 'mojca.podkriznik@solski-sistem.si', '$2y$10$.BHpQFD7Jq3LiH/J6Is5qORgFcOhsjivADMuBVo/j8o/QyyKZPsv2', 'ucenec', 'Mojca', 'Podkrižnik', '2025-11-23 11:35:04', 1),
(42, 'ucenec10', 'peter.malik@solski-sistem.si', '$2y$10$yMcExXPepZ8nPvcPB0QaOeAQ5eYGSkbgXHpa/FMC6C3ce40u5wPoG', 'ucenec', 'Peter', 'Malik', '2025-11-23 11:35:46', 1),
(43, 'ucenec11', 'rok.urni@solski-sistem.si', '$2y$10$Bph7kv4jqxDgPwr0mUvF6eyEfCRM22qQJ7Fv1Kl6hqol.1S4zOs.a', 'ucenec', 'Rok', 'Urni', '2025-11-23 11:36:43', 1),
(44, 'ucenec12', 'ana.novak@solski-sistem.si', '$2y$10$h9IjOSHe.6dgfNM9OPCND.QTooAbO2YjEJcTn52GJighLRBxz037q', 'ucenec', 'Ana', 'Novak', '2025-11-23 11:37:11', 1),
(45, 'ucenec13', 'maja.kralj@solski-sistem.si', '$2y$10$tiBstSIP8W4z0QwkJcwkQ.pC0ii42sO8fYRtUXKlhHk9welh6Wb26', 'ucenec', 'Maja', 'Kralj', '2025-11-23 11:37:38', 1),
(46, 'ucenec14', 'nina.horvat@solski-sistem.si', '$2y$10$C5ThUZ8/r5WxCnQte6F4ouV.YQkbsSFaQS1S3pEmpv/Q96fPzawdq', 'ucenec', 'Nina', 'Horvat', '2025-11-23 11:38:04', 1),
(47, 'ucenec15', 'lara.zupan@solski-sistem.si', '$2y$10$Tf/6HlVJ7kAikPy50t6Ztuz9h54hMFuxd2TZwWsXqviJ1OZsqeF3W', 'ucenec', 'Lara', 'Zupan', '2025-11-23 11:38:29', 1),
(48, 'ucenec16', 'eva.mlakar@solski-sistem.si', '$2y$10$XNHYr0VDcdAcN0KA7UyLmefhzvBKkCWUr82tuLZxXflSKiplikPam', 'ucenec', 'Eva', 'Mlakar', '2025-11-23 11:39:30', 1),
(49, 'ucenec17', 'luka.zajc@solski-sistem.si', '$2y$10$T./uG9Alty8vYcC3V7Qwg..ULAv0/L43JSD1IOYJn7333FSdA/rlm', 'ucenec', 'Luka', 'Zajc', '2025-11-23 11:39:57', 1),
(50, 'ucenec18', 'marko.novak@solski-sistem.si', '$2y$10$xBLECv3GGQ2WHgAFYfsF2ejXrLuAQz7awNUsrf16ccHLYoKLIVG42', 'ucenec', 'Marko', 'Novak', '2025-11-23 11:40:25', 1),
(51, 'ucenec19', 'zan.kralj@solski-sistem.si', '$2y$10$dyHje82ZB5fK2imwTBdtcub8XSdKri9TfIFz1DxA.DFTgDT.0FZC2', 'ucenec', 'Žan', 'Kralj', '2025-11-23 11:40:47', 1),
(52, 'ucenec20', 'mark.horvat@solski-sistem.si', '$2y$10$iW1LpUUEPWsLpnGmVw2RS.k9MUqO.uIUzZ2xies6POB2VnhM5573G', 'ucenec', 'Mark', 'Horvat', '2025-11-23 11:41:25', 1),
(53, 'ucenec21', 'david.mlaker@solski-sistem.si', '$2y$10$zWiq3R.nu6u1pLQnlD6sBuh1/bceoeTeSgRUPm6nRxoSP0PLdpgBO', 'ucenec', 'David', 'Mlaker', '2025-11-23 11:41:55', 1),
(54, 'ucenec22', 'jure.potocnik@solski-sistem.si', '$2y$10$OktvK38.q8nkuir8q1BlbOCzM3c7gsphc.Td5U8e6f8giELvdOL8K', 'ucenec', 'Jure', 'Potočnik', '2025-11-23 11:42:19', 1),
(55, 'ucenec23', 'tomaz.medved@solski-sistem.si', '$2y$10$2K4hAExeMS3YM3kos2upFe4BzpuYq7TiNVQsgGaXuNo7FfIZbeaNm', 'ucenec', 'Tomaž', 'Medved', '2025-11-23 11:42:42', 1),
(56, 'ucenec24', 'peter.kovac@solski-sistem.si', '$2y$10$WinyYDvyjkzcF5utZwDjWusRSDt7nAsZ8ApSl63UACcNmjSRILyQ2', 'ucenec', 'Peter', 'Kovač', '2025-11-23 11:43:08', 1),
(57, 'ucenec25', 'andrej.rozman@solski-sistem.si', '$2y$10$Oi9E7mWQAY7wBYME8GV3ReEPnZ7w8M/j/qvyA79PlDaqllgClVBWC', 'ucenec', 'Andrej', 'Rozman', '2025-11-23 11:43:30', 1),
(58, 'ucenec26', 'simon.bizjak@solski-sistem.si', '$2y$10$4lZ4AEOQRMPp1GM3rV8HRe5SaakYgUlLueB5K06b0GWWt1X2tmEVC', 'ucenec', 'Simon', 'Bizjak', '2025-11-23 11:43:54', 1),
(59, 'ucenec27', 'gregor.turk@solski-sistem.si', '$2y$10$6hfVHCFACjZb99zHYCZJ/eKpcrPgkZ.ch.ME1jU3Y4coym9y3ZfTa', 'ucenec', 'Gregor', 'Turk', '2025-11-23 11:44:18', 1),
(60, 'ucenec28', 'matej.zagar@solski-sistem.si', '$2y$10$YA2oLVE0kD5x8ThEzdOKEuFpz0LQT6cKMyuxjON5J6DnSNL8Gu.He', 'ucenec', 'Matej', 'Žagar', '2025-11-23 11:44:43', 1),
(61, 'ucenec29', 'alen.vidmar@solski-sistem.si', '$2y$10$7/d/Adk4/yxzLejPyH/2k.6M9o4NvxTt2Gfp6vQ5jFiv36n.Gc232', 'ucenec', 'Alen', 'Vidmar', '2025-11-23 11:45:09', 1),
(62, 'ucenec30', 'rok.jerman@solski-sistem.si', '$2y$10$vtDkWPTg1S1yr8KhL8NSAeT2zsp1.FE5d6ddZj5e6/XdEaBwM6uPO', 'ucenec', 'Rok', 'Jerman', '2025-11-23 11:45:34', 1),
(63, 'ucenec31', 'nejc.kosir@solski-sistem.si', '$2y$10$o4p3e4YO8L/sQFPg0d0z5uHA73SiBS/uCSIYP6WqBYyw7.IIpJEHa', 'ucenec', 'Nejc', 'Košir', '2025-11-23 11:45:58', 1),
(64, 'ucenec32', 'tjaz.potocnik@solski-sistem.si', '$2y$10$ktQey0A9AiOBmrXd7ZI5/.C4rN9QuCI2SOkFGNMGta.LcpYcbFgTy', 'ucenec', 'Tjaž', 'Potočnik', '2025-11-23 11:46:21', 1),
(65, 'ucenec33', 'klara.zajec@solski-sistem.si', '$2y$10$k8hU9.P.bdCYnJ2LMCfns.FJp/rrLMojiNdGTvD9vjoiMhSf6B4Oq', 'ucenec', 'Klara', 'Zajec', '2025-11-23 11:46:43', 1),
(66, 'ucenec34', 'mojca.medved@solski-sistem.si', '$2y$10$K5w9k3Bav4DgrtyOEWj8w.aMCSvOJmNiLxjU5CeFeHxeqRRgk8CJ2', 'ucenec', 'Mojca', 'Medved', '2025-11-23 11:47:06', 1),
(67, 'ucenec35', 'sara.kovacic@solski-sistem.si', '$2y$10$40Mavhnp3Bs45/kOmpuXb.G91dhsdOt4y/kDz0O56H8JXmiwtfKLy', 'ucenec', 'Sara', 'Kovačič', '2025-11-23 11:47:33', 1),
(68, 'ucenec36', 'barbara.roza@solski-sistem.si', '$2y$10$UMfB4p.feKm/YGYdOMbnKOY7wvampVPSMuX2olfE9qr1Wa2eFwto6', 'ucenec', 'Barbara', 'Roza', '2025-11-23 11:47:56', 1),
(69, 'ucenec37', 'jan.bizjak@solski-sistem.si', '$2y$10$aYXoDaVT83UL/rBqxsX6V.f6dfE3BOWl6ynowT.LYDDz3e2S1tPeO', 'ucenec', 'Jan', 'Bizjak', '2025-11-23 11:48:51', 1),
(70, 'ucenec38', 'katja.turek@solski-sistem.si', '$2y$10$rbUi6vN9cZqs5roCp.1PDeWI1Z7FIPCWD8IQ6mvgPuFEbHsG0OOAa', 'ucenec', 'Katja', 'Turek', '2025-11-23 11:49:17', 1),
(71, 'ucenec39', 'urh.zagar@solski-sistem.si', '$2y$10$5LfFwZFGctLEUu4YyeiO4.LllSeeinyuz8KO5vpVcvjOhCgYbHj/G', 'ucenec', 'Urh', 'Žagar', '2025-11-23 11:49:41', 1),
(72, 'ucenec40', 'alja.vodar@solski-sistem.si', '$2y$10$XnEK/T4Jq47fTw/iLMw7f.HsCi9UUIW2WuaTsLjJlRCJjbO5doGDm', 'ucenec', 'Alja', 'Vodar', '2025-11-23 11:50:05', 1),
(73, 'ucenec41', 'spela.jeram@solski-sistem.si', '$2y$10$pwit4oBsYe8t8kJMi7BpReUMYkzclah0cMClJKTGgMer2Ja.y2RUy', 'ucenec', 'Špela', 'Jeram', '2025-11-23 11:50:27', 1),
(74, 'ucenec42', 'neza.kosir@solski-sistem.si', '$2y$10$V0q9bsj9y.XZbyczERl4puySDVD2hezAGSbbiddobaFpN9J4ZG1W6', 'ucenec', 'Neža', 'Košir', '2025-11-23 11:50:49', 1),
(75, 'ucenec43', 'denis.bozicnik@solski-sistem.si', '$2y$10$.JCIQgA5gngRLOVgPUC3huytcKDaKlpdzXO3YSDEQJIuseZE94mBm', 'ucenec', 'Denis', 'Božičnik', '2025-11-23 11:51:17', 1),
(76, 'ucenec44', 'ales.rebrnik@solski-sistem.si', '$2y$10$JkbodgxMgi6FmBYHA56jSuuZnEqovx1wV8yAFRwU6ewKB4WLXLU7m', 'ucenec', 'Aleš', 'Rebrnik', '2025-11-23 11:51:44', 1),
(77, 'ucenec45', 'miha.rebrsak@solski-sistem.si', '$2y$10$2HUMrPrWbD5Vvgp.o/wfgeMyrYIzgyT0wZMDBDGs2AHM260AiGvfG', 'ucenec', 'Miha', 'Rebršak', '2025-11-23 11:52:12', 1),
(78, 'ucenec46', 'igor.kocjan@solski-sistem.si', '$2y$10$rrwjfLfms9/M6yT6KVNfL.SXk7GD0yYTpseqVTcYqrFijIJM7A9sq', 'ucenec', 'Igor', 'Kocjan', '2025-11-23 11:52:36', 1),
(79, 'ucenec47', 'boris.mayer@solski-sistem.si', '$2y$10$GHTt3rct2G109X7B77BJr.nWMKDkDZUYUUm8AF9lLiJ05MoLEErKy', 'ucenec', 'Boris', 'Mayer', '2025-11-23 11:52:59', 1),
(80, 'ucenec48', 'sebastian.kristan@solski-sistem.si', '$2y$10$cUD/S20SCuRphKisUa2QC.3r1vxAiv/rVDs9tjIVkhbCTGuTCeK02', 'ucenec', 'Sebastian', 'Kristan', '2025-11-23 11:53:27', 1),
(81, 'ucenec49', 'kristjan.zajec@solski-sistem.si', '$2y$10$J7fIOIpEz75EayUgemZFSucmFpJLu12jukTBQrA4SDP9ksiw52Rj2', 'ucenec', 'Kristjan', 'Zajec', '2025-11-23 11:53:53', 1),
(82, 'ucenec50', 'ivan.petek@solski-sistem.si', '$2y$10$qAvk9RYFmx6poMKBpQiXEena4ZX6SFnwXFpn7bevhyPTCwp0jAEzu', 'ucenec', 'Ivan', 'Petek', '2025-11-23 11:54:17', 1),
(83, 'ucenec51', 'martin.kacur@solski-sistem.si', '$2y$10$ZSpCxhvalDepfshlJmuFt.7NZ2YEtZKAY5A9c1DQB2zg4eJpPocu6', 'ucenec', 'Martin', 'Kačur', '2025-11-23 11:54:53', 1),
(84, 'ucenec52', 'bostjan.knez@solski-sistem.si', '$2y$10$D8tNvcGRaw7htE7R9jBHDu9FEeRYr7ujg4bz1AHjZVLwblLPLW7hm', 'ucenec', 'Boštjan', 'Knez', '2025-11-23 11:55:19', 1),
(85, 'ucenec53', 'boris.dolensek@solski-sistem.si', '$2y$10$qP1YiRhoJx8iKEO8sUAWjOFqDcbme.4uWL6aMGGsVw.1awf0iknFe', 'ucenec', 'Boris', 'Dolenšek', '2025-11-23 11:55:44', 1),
(86, 'ucenec54', 'ziga.ribic@solski-sistem.si', '$2y$10$GKEiTDbhSo6QO9XgZj7dZOYMD8hCdhWNOz/Ck2vrOHL1.Tni57hXO', 'ucenec', 'Žiga', 'Ribič', '2025-11-23 11:56:07', 1),
(87, 'ucenec55', 'milanka.greadisar@solski-sistem.si', '$2y$10$FE3TORJHpTQwp/nKwShZSeY6C83LeyhHXXPHFtBZcZfoSmv/41UgO', 'ucenec', 'Milanka', 'Gradišar', '2025-11-23 11:56:32', 1),
(88, 'ucenec56', 'deja.kocjancic@solski-sistem.si', '$2y$10$89TioVPzFYPfpQFNxivkNOQtszv3nl1K2RX78YwKj9PvMtHlwUz5W', 'ucenec', 'Deja', 'Kocjančič', '2025-11-23 11:56:58', 1),
(89, 'ucenec57', 'milan.gradic@solski-sistem.si', '$2y$10$47vn3FMBSKeOZTYNGaLlleLBwsLRs5.TEWMIsbnwSWSfhQEVlcdiG', 'ucenec', 'Milan', 'Gradič', '2025-11-23 11:57:25', 1),
(90, 'ucenec58', 'filip.tomsic@solski-sistem.si', '$2y$10$YuprrKHCOrodVBRhotk75.of3G6x3ZcAs3bCK/QiHKkB0fFr6g5ea', 'ucenec', 'Filip', 'Tomšič', '2025-11-23 11:57:51', 1),
(91, 'ucenec59', 'dejan.vovk@solski-sistem.si', '$2y$10$dACDPoAdkjcz.mAkLKZWc.Jm1O1tjoplAToXvgOuBwl4IabObgz3W', 'ucenec', 'Dejan', 'Vovk', '2025-11-23 11:58:37', 1),
(92, 'ucenec60', 'francka.cankar@solski-sistem.si', '$2y$10$4Iq4bbrsJpm4ljGktUIXc.gdT3tx4TJNIHBsR8tZu6lzdmlJUQfNK', 'ucenec', 'Francka', 'Cankar', '2025-11-23 11:59:03', 1),
(93, 'ucenec61', 'seba.hrovat@solski-sistem.si', '$2y$10$XoThibhQduo.1Vu6IyIRgulyWiBPnFx9bJXB1HLrzo9hsG2sm6GPG', 'ucenec', 'Seba', 'Hrovat', '2025-11-23 11:59:29', 1),
(94, 'ucenec62', 'tanja.rajh@solski-sistem.si', '$2y$10$hHNVCAPfliTgfWmYumOrFuEDsxpm2Jpxg.9QtqKWWSXYGbdNUa2XK', 'ucenec', 'Tanja', 'Rajh', '2025-11-23 11:59:51', 1),
(95, 'ucenec63', 'lidija.vrhunc@solski-sistem.si', '$2y$10$q9nPWELQjSkp61j/XA7SLOv7rjAifbniOoRpEx9jykzCh1.N7OOtK', 'ucenec', 'Lidija', 'Vrhunc', '2025-11-23 12:00:16', 1),
(96, 'ucenec64', 'olga.vidic@solski-sistem.si', '$2y$10$iZS3pnr4YroEfaNqnc0ViOv5jac5tMJ2aMnovh1386XaUFoy.UGoq', 'ucenec', 'Olga', 'Vidic', '2025-11-23 12:00:46', 1),
(97, 'ucenec65', 'ales.vidicnik@solski-sistem.si', '$2y$10$3FWyDjSIH3o7qkxj/GorKOrjiRoVwWySejn7hEdJpxvRyfi022MIq', 'ucenec', 'Aleš', 'Vidičnik', '2025-11-23 12:01:11', 1),
(98, 'ucenec66', 'alenka.zupan@solski-sistem.si', '$2y$10$51ky.szE2ufj7AGfC01a1OvmNpFN.TeGlmBO7dZKjGfduW3vUKUpe', 'ucenec', 'Alenka', 'Zupan', '2025-11-23 12:01:36', 1),
(99, 'ucenec67', 'rok.zupancic@solski-sistem.si', '$2y$10$6OkwhbqBUg5U.ymoSISixOTVf/u4noLXY/MFe7ZSTQlWzwYdilH.2', 'ucenec', 'Rok', 'Zupančič', '2025-11-23 12:02:04', 1),
(100, 'ucenec68', 'helena.pirc@solski-sistem.si', '$2y$10$yzNlue0vLmtRKJ8OjTBPAuwJo6gfxp83xBQJf37U4IUjqt5B4WBUu', 'ucenec', 'Helena', 'Pirc', '2025-11-23 12:02:29', 1),
(101, 'ucenec69', 'mark.kosec@solski-sistem.si', '$2y$10$45NZ5fHIyIkrzYQq36f..eJCI0ftt6eQzKBkd/50BTl9DXAwV0FWW', 'ucenec', 'Mark', 'Kosec', '2025-11-23 12:02:53', 1),
(102, 'ucenec70', 'masa.bevcic@solski-sistem.si', '$2y$10$QmSDG7TvXwWV8XkaoGcPaOHS13S9s2qL5n7WEI4B2zfcwbGquN4qi', 'ucenec', 'Maša', 'Bevčič', '2025-11-23 12:03:18', 1),
(103, 'ucenec71', 'hana.ram@solski-sistem.si', '$2y$10$BVdwrPiVpIrxoOoksh95s.sSfBHAC54V2NQOprgYhBbjJgWAT1PoG', 'ucenec', 'Hana', 'Ram', '2025-11-23 12:03:40', 1),
(104, 'ucenec72', 'lucija.ramsak@solski-sistem.si', '$2y$10$EmB2hGRPRySu.dyto6Dn6OBGB6sC/WDDBNYf7iOZuG21mqiik7zJ.', 'ucenec', 'Lucija', 'Ramšak', '2025-11-23 12:04:04', 1),
(105, 'ucenec73', 'tit.crni@solski-sistem.si', '$2y$10$4wYeUfUwaypzZhPzwaTvfu/5UNtsoUjhXf9WRj4TlZxk5NLN/C7sm', 'ucenec', 'Tit', 'Črni', '2025-11-23 12:04:25', 1),
(106, 'ucenec74', 'krista.zorcic@solski-sistem.si', '$2y$10$rMgPhYaGH0nx0U38tQ9FhO0GWfpXSE3HZn7wfzgIrxkFezLHhv0b2', 'ucenec', 'Krista', 'Zorčič', '2025-11-23 12:04:49', 1),
(107, 'ucenec75', 'matej.zorko@solski-sistem.si', '$2y$10$dTXsxxP9l6xriIlJCByOuuFl37Kb61XzfqlrroQ5R9JamI9/WHz8e', 'ucenec', 'Matej', 'Zorko', '2025-11-23 12:05:12', 1),
(108, 'ucenec76', 'jasmina.kocbek@solski-sistem.si', '$2y$10$FVNKk4g0AU1d6yCntqoRHuq391abSRwkVcMkDeMTQnAwnUtWGDE6K', 'ucenec', 'Jasmina', 'Kocbek', '2025-11-23 12:05:35', 1),
(109, 'ucenec77', 'simona.preseren@solski-sistem.si', '$2y$10$UYRpjC1UKL3vOPVQ4Vcr7uuD8xa3S0hyGImohdeP1LFLmZOvFDY/i', 'ucenec', 'Simona', 'Prešeren', '2025-11-23 12:06:09', 1),
(110, 'ucenec78', 'elizabeta.kovac@solski-sistem.si', '$2y$10$i2IG.OUMOEqgV.ZnEPq1guthtfkzw3bsS8hGnA71RVaj91DBkVLXq', 'ucenec', 'Elizabeta', 'Kovač', '2025-11-23 12:06:35', 1),
(111, 'ucenec79', 'dani.presec@solski-sistem.si', '$2y$10$m54YU2leNRzz5iO542z8j.cHSr66.qy2opMkU9YcGAxUbfcUXfTxu', 'ucenec', 'Dani', 'Presec', '2025-11-23 12:07:29', 1),
(112, 'ucenec80', 'roman.bevc@solski-sistem.si', '$2y$10$T0SsDx/64fpZEhggVycDXeQv37sWmetD1gYThP85b/uvCNIr0jgAi', 'ucenec', 'Roman', 'Bevc', '2025-11-23 12:08:01', 1),
(113, 'ucenec81', 'ivanka.petric@solski-sistem.si', '$2y$10$oA7LuMsqp40Ltu8NTXuVzuU4EqbJUTmhl6VRPZBC8wzjVPUGDEebu', 'ucenec', 'Ivanka', 'Petrič', '2025-11-23 12:08:23', 1),
(114, 'ucenec82', 'marusa.knez@solski-sistem.si', '$2y$10$yhMrERhkS0HPgCjI4Af./OQofzr.Ak5sw9mvluIbUHySHkHX/TRYW', 'ucenec', 'Maruša', 'Knez', '2025-11-23 12:08:49', 1),
(115, 'ucenec83', 'teja.ribic@solski-sistem.si', '$2y$10$Bcx1tbu.NAJetMU8ORiF2eW0hUxz6S3Cyt1tGqdgiXWJjL5n8m1iq', 'ucenec', 'Teja', 'Ribič', '2025-11-23 12:09:15', 1),
(116, 'ucenec84', 'andrej.kraljic@solski-sistem.si', '$2y$10$ZU/d5bLnx5bH3M7LRQI2jugaOlhtgJwK50jyWEeju1y2r7ABu7nkm', 'ucenec', 'Andrej', 'Kraljič', '2025-11-23 12:09:39', 1),
(117, 'ucenec85', 'andrejka.loncar@solski-sistem.si', '$2y$10$3qNTS6wCp.6.qaoLmOiEfeu4S8oVBO7PSGbH8cE4FDwcj6NztjzqG', 'ucenec', 'Andrejka', 'Lončar', '2025-11-23 12:10:05', 1),
(118, 'ucenec86', 'ziva.tomsic@solski-sistem.si', '$2y$10$zKPerqclQ/fUuMeU.DCiuuKYQvMx8MbrxeG4RHpYnenZ4Y9C.Sjc6', 'ucenec', 'Živa', 'Tomšič', '2025-11-23 12:10:35', 1),
(119, 'ucenec87', 'romana.vovk@solski-sistem.si', '$2y$10$93iOD3jFlSbu6V7Fn.aDgOHy6Goq/FR5AmKAY.PLRglQoBnkiVYyG', 'ucenec', 'Romana', 'Vovk', '2025-11-23 12:11:01', 1),
(120, 'ucenec88', 'mojmir.mayer@solski-sistem.si', '$2y$10$RR2E0S/z4ZO9xTG3ZBjFNOZuckiVPnvrW5ik9Mg09CombDvSD/hr2', 'ucenec', 'Mojmir', 'Mayer', '2025-11-23 12:11:30', 1),
(121, 'ucenec89', 'leja.bozicnik@solski-sistem.si', '$2y$10$mjB8z8U.tA/qJOgD1nOv.OMrUNAzFR3fZA3P.x0OhQQsF91hRWEUS', 'ucenec', 'Leja', 'Božičnik', '2025-11-23 12:11:55', 1),
(122, 'ucenec90', 'edvard.kocmur@solski-sistem.si', '$2y$10$EpRmE/x0zU8RLjb0ZpIC6un6n./r0l2iZCzlMKHIn/En78hBXtWm.', 'ucenec', 'Edvard', 'Kocmur', '2025-11-23 12:12:20', 1),
(123, 'ucenec91', 'ratko.subic@solski-sistem.si', '$2y$10$BqRHIBL3Px.WwxuYR8M2Gu94ECcire7QvE.jZsEruhhfyghzxQSyy', 'ucenec', 'Ratko', 'Šubic', '2025-11-23 12:13:02', 1),
(124, 'ucenec92', 'miran.jereb@solski-sistem.si', '$2y$10$DCHyJDokrvnvIx5hH320guvmYwEpkhahpwHOhMBomDrZC15RWpWJW', 'ucenec', 'Miran', 'Jereb', '2025-11-23 12:13:27', 1),
(125, 'ucenec93', 'ales.vidic@solski-sistem.si', '$2y$10$m2Hq/iS2..8gxRSRdvMyZO/noeDTAVnl9rW2mcF.wt6uhUrSL5XD2', 'ucenec', 'Aleš', 'Vidic', '2025-11-23 12:13:58', 1),
(126, 'ucenec94', 'jan.pirc@solski-sistem.si', '$2y$10$QU4lv7sAlah1qrs2ZuLd4OljFLnlvUUJdN333DJoKhDRLDWGYbeX.', 'ucenec', 'Jan', 'Pirc', '2025-11-23 12:14:20', 1),
(127, 'ucenec95', 'zoran.zupanek@solski-sistem.si', '$2y$10$R3FJzGLg3eGSfcjol72Qdemm0GDMR.kzvD5GvyGtGI5k0lKAbuLha', 'ucenec', 'Zoran', 'Zupanek', '2025-11-23 12:14:47', 1),
(128, 'ucenec96', 'oskar.krizaj@solski-sistem.si', '$2y$10$ZvU9jl0VZJtImSWB2rpHkudIY5.zzJrZeQ6e9pRdkznAgwI3wohmm', 'ucenec', 'Oskar', 'Križaj', '2025-11-23 12:15:14', 1),
(129, 'ucenec97', 'stanko.oblak@solski-sistem.si', '$2y$10$JuqWnkDcskBQr7m1dNEqKeq7xxeBDIHna2iw/gENEbwq1QtK/PxNO', 'ucenec', 'Stanko', 'Oblak', '2025-11-23 12:15:40', 1),
(130, 'ucenec98', 'tilen.bojkov@solski-sistem.si', '$2y$10$aJOOZPO8p.OFq2AsrCNTdONZHvVbbe/zyiehKwfs5fbrOdNQurBI6', 'ucenec', 'Tilen', 'Bojkov', '2025-11-23 12:16:05', 1),
(131, 'ucenec99', 'lovro.ramsak@solski-sistem.si', '$2y$10$owxVWNPv.bEcvbTY1y6JGO5cXIQtdiXElkaVpNgJX9CLlXFFLxcrS', 'ucenec', 'Lovro', 'Ramšak', '2025-11-23 12:16:28', 1),
(132, 'ucenec100', 'rok.strukelj@solski-sistem.si', '$2y$10$XAQBslUx5uvTsVz4YIPwYuaxNOjeIeLLulwIpjLQgPwvREHMjof2O', 'ucenec', 'Rok', 'Štrukelj', '2025-11-23 12:16:53', 1);

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
