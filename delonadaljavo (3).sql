-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gostitelj: 127.0.0.1
-- Čas nastanka: 13. nov 2025 ob 20.05
-- Različica strežnika: 10.4.32-MariaDB
-- Različica PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Zbirka podatkov: `delonadaljavo`
--

-- --------------------------------------------------------

--
-- Struktura tabele `gradiva`
--

CREATE TABLE `gradiva` (
  `idGradiva` int(11) NOT NULL,
  `predmet_idPredmeta` int(11) DEFAULT NULL,
  `Naslov` varchar(255) CHARACTER SET utf8 COLLATE utf8_slovenian_ci NOT NULL,
  `Pot_do_datoteke` text CHARACTER SET utf8 COLLATE utf8_slovenian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `gradiva`
--

INSERT INTO `gradiva` (`idGradiva`, `predmet_idPredmeta`, `Naslov`, `Pot_do_datoteke`) VALUES
(1, 1, 'Moderna na Slovenskem', 'Moderna.docx'),
(2, 2, 'IP naslovi', 'IP.pptx');

-- --------------------------------------------------------

--
-- Struktura tabele `naloge`
--

CREATE TABLE `naloge` (
  `idNaloge` int(11) NOT NULL,
  `Predmet-idPredmeta` int(11) DEFAULT NULL,
  `Naslov` text CHARACTER SET utf8 COLLATE utf8_slovenian_ci DEFAULT NULL,
  `Rok_za_oddajo` date DEFAULT NULL,
  `Vsebina` text CHARACTER SET utf8 COLLATE utf8_slovenian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `naloge`
--

INSERT INTO `naloge` (`idNaloge`, `Predmet-idPredmeta`, `Naslov`, `Rok_za_oddajo`, `Vsebina`) VALUES
(1, 1, 'Aktualizacija smrti', '2025-12-01', 'Opišite vaše razmišljanje o smrti');

-- --------------------------------------------------------

--
-- Struktura tabele `oddaje`
--

CREATE TABLE `oddaje` (
  `naloge_idNaloge` int(11) DEFAULT NULL,
  `uporabnik_idUporabnika` int(11) DEFAULT NULL,
  `Datum_oddaje` date DEFAULT NULL,
  `Ocena` int(11) NOT NULL,
  `Datoteka` text CHARACTER SET utf8 COLLATE utf8_slovenian_ci NOT NULL,
  `Naslov` text CHARACTER SET utf8 COLLATE utf8_slovenian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `oddaje`
--

INSERT INTO `oddaje` (`naloge_idNaloge`, `uporabnik_idUporabnika`, `Datum_oddaje`, `Ocena`, `Datoteka`, `Naslov`) VALUES
(1, 4, '2025-11-08', 4, 'KovačAna-Aktualizacija.docx', 'Aktualizacija smrti'),
(1, 5, '2025-11-10', 3, 'NovakMiha-Aktualizacija.docx', 'Aktualizacija smrti');

-- --------------------------------------------------------

--
-- Struktura tabele `predmet`
--

CREATE TABLE `predmet` (
  `idPredmeta` int(11) NOT NULL,
  `Naziv` varchar(255) CHARACTER SET utf8 COLLATE utf8_slovenian_ci DEFAULT NULL,
  `Kratica` varchar(20) CHARACTER SET utf8 COLLATE utf8_slovenian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `predmet`
--

INSERT INTO `predmet` (`idPredmeta`, `Naziv`, `Kratica`) VALUES
(1, 'Slovenščina', 'SLO'),
(2, 'Omrežni servisi', 'OS'),
(3, 'Moderne vsebine', 'MV'),
(4, 'Računalništvo', 'RAČ'),
(5, 'Angleščina', 'ANG'),
(6, 'Matematika', 'MAT'),
(7, 'Spletne aplikacije', 'SA'),
(8, 'Terminologija strokovna', 'TES'),
(9, 'Komuniciranje', 'KOM'),
(10, 'Fizika', 'FIZ');

-- --------------------------------------------------------

--
-- Struktura tabele `ucenec_predmet`
--

CREATE TABLE `ucenec_predmet` (
  `predmet_idPredmeta` int(11) DEFAULT NULL,
  `uporabnik_idUporabnika` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `ucenec_predmet`
--

INSERT INTO `ucenec_predmet` (`predmet_idPredmeta`, `uporabnik_idUporabnika`) VALUES
(1, 4),
(1, 5),
(2, 4),
(2, 5),
(3, 4),
(1, 24),
(2, 24),
(2, 9),
(1, 25),
(3, 25),
(1, 26),
(4, 26),
(5, 26),
(1, 27),
(6, 27),
(8, 27),
(1, 28),
(9, 28),
(1, 29),
(4, 29),
(7, 29),
(1, 30),
(4, 30),
(7, 30),
(1, 31),
(8, 31),
(10, 31),
(1, 32),
(4, 32),
(9, 32),
(1, 33),
(5, 33),
(1, 34),
(7, 34),
(4, 34),
(1, 35),
(3, 35),
(1, 36),
(2, 36),
(7, 36),
(1, 37),
(2, 37),
(3, 37),
(1, 38),
(4, 38),
(10, 38),
(1, 39),
(5, 39),
(1, 40),
(9, 40),
(10, 40),
(1, 41),
(4, 41),
(6, 41),
(1, 42),
(7, 42),
(8, 42),
(9, 42),
(1, 43),
(3, 43),
(4, 43),
(1, 44),
(4, 44),
(8, 44),
(1, 45),
(9, 45),
(1, 46),
(6, 46),
(8, 46),
(1, 47),
(2, 47),
(4, 47),
(7, 47),
(1, 48),
(7, 48),
(9, 48),
(1, 49),
(2, 49),
(5, 49),
(9, 49),
(1, 50),
(4, 50),
(6, 50),
(8, 50),
(1, 51),
(7, 51),
(10, 51),
(1, 52),
(4, 52),
(2, 52),
(9, 52),
(1, 53),
(2, 53),
(3, 53),
(4, 53),
(1, 54),
(3, 54),
(5, 54),
(1, 55),
(7, 55),
(9, 55),
(10, 55),
(1, 56),
(5, 56),
(7, 56),
(1, 57),
(6, 57),
(10, 57),
(1, 58),
(3, 58),
(4, 58),
(1, 59),
(10, 59),
(1, 60),
(6, 60),
(7, 60),
(1, 61),
(6, 61),
(8, 61),
(1, 62),
(4, 62),
(1, 63),
(3, 63),
(1, 64),
(4, 64),
(8, 64),
(1, 65),
(2, 65),
(1, 66),
(10, 66),
(1, 67),
(6, 67),
(7, 67),
(1, 68),
(8, 68),
(1, 69),
(2, 69),
(4, 69),
(1, 70),
(4, 70),
(1, 71),
(10, 71),
(1, 72),
(7, 72),
(1, 73),
(3, 73),
(6, 73),
(1, 74),
(9, 74),
(1, 75),
(6, 75),
(10, 75),
(1, 76),
(5, 76),
(1, 77),
(7, 77),
(1, 78),
(7, 78),
(8, 78),
(1, 79),
(5, 79),
(9, 79),
(1, 80),
(3, 80),
(1, 81),
(8, 81),
(1, 82),
(10, 82),
(1, 83),
(4, 83),
(1, 84),
(6, 84),
(7, 84),
(1, 85),
(3, 85),
(1, 86),
(7, 86),
(1, 87),
(4, 87),
(9, 87),
(1, 88),
(8, 88),
(1, 89),
(6, 89),
(1, 90),
(9, 90),
(1, 91),
(5, 91),
(1, 92),
(4, 92),
(1, 93),
(3, 93),
(9, 93),
(1, 94),
(7, 94),
(1, 95),
(10, 95),
(1, 96),
(6, 96),
(10, 96),
(1, 97),
(7, 97),
(1, 98),
(8, 98),
(1, 99),
(9, 99),
(1, 100),
(4, 100),
(1, 101),
(3, 101),
(1, 102),
(10, 102),
(1, 103),
(4, 103),
(8, 103),
(1, 104),
(4, 104),
(1, 105),
(5, 105),
(1, 106),
(6, 106),
(9, 106),
(1, 107),
(7, 107),
(1, 108),
(8, 108),
(1, 109),
(9, 109),
(1, 110),
(10, 110),
(1, 111),
(2, 111),
(4, 111),
(1, 112),
(2, 112),
(1, 113),
(3, 113),
(1, 114),
(4, 114),
(9, 114),
(1, 115),
(5, 115),
(1, 116),
(6, 116),
(1, 117),
(7, 117),
(1, 118),
(8, 118),
(1, 119),
(9, 119),
(8, 119),
(1, 120),
(10, 120),
(2, 120),
(1, 121),
(2, 121),
(4, 121);

-- --------------------------------------------------------

--
-- Struktura tabele `ucitelj_predmet`
--

CREATE TABLE `ucitelj_predmet` (
  `predmet_idPredmeta` int(11) DEFAULT NULL,
  `uporabnik_idUporabnika` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `ucitelj_predmet`
--

INSERT INTO `ucitelj_predmet` (`predmet_idPredmeta`, `uporabnik_idUporabnika`) VALUES
(1, 2),
(2, 2),
(2, 3),
(3, 3),
(1, 9),
(3, 13),
(3, 8),
(4, 7),
(4, 15),
(5, 6),
(5, 22),
(5, 10),
(6, 11),
(6, 12),
(7, 7),
(7, 16),
(7, 18),
(7, 19),
(8, 22),
(9, 17),
(10, 21),
(10, 20),
(4, 14),
(7, 23);

-- --------------------------------------------------------

--
-- Struktura tabele `uporabnik`
--

CREATE TABLE `uporabnik` (
  `idUporabnika` int(11) NOT NULL,
  `Ime` varchar(45) CHARACTER SET utf8 COLLATE utf8_slovenian_ci DEFAULT NULL,
  `Priimek` varchar(255) CHARACTER SET utf8 COLLATE utf8_slovenian_ci DEFAULT NULL,
  `Email` text CHARACTER SET utf8 COLLATE utf8_slovenian_ci DEFAULT NULL,
  `Geslo` text CHARACTER SET utf8 COLLATE utf8_slovenian_ci DEFAULT NULL,
  `Vloga` int(11) DEFAULT NULL COMMENT '0-Admin\r\n1-Učitelj\r\n2-Učenec'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `uporabnik`
--

INSERT INTO `uporabnik` (`idUporabnika`, `Ime`, `Priimek`, `Email`, `Geslo`, `Vloga`) VALUES
(1, 'Tim', 'Krušič', 'krusic.tim@gmail.com', 'abc123', 0),
(2, 'Valentina', 'Hrastnik', 'valentina@gmail.com', 'abc123', 1),
(3, 'Borut', 'Slemenšek', 'borut@siol.net', 'abc123', 1),
(4, 'Ana', 'Kovač', 'ana.kovac@gmail.com', 'abc123', 2),
(5, 'Miha', 'Novak', 'miha.novak@gmail.com', 'abc123', 2),
(6, 'Rosana', 'Breznik', 'rosanab@gmail.com', 'abc123', 1),
(7, 'Jaka', 'Koren', 'jaka.koren@gmail.com', 'abc123', 1),
(8, 'Boštjan', 'Resinovič', 'bostjan.resinovic@gmail.com', 'abc123', 1),
(9, 'Tanja', 'Jelenko', 'tanja.jelenko@gmail.com', 'abc123', 1),
(10, 'Katja', 'Kolar', 'katja.kolar@gmail.com', 'abc123', 1),
(11, 'Helena', 'Klepej Viher', 'helena.klepejviher@gmail.com', 'abc123', 1),
(12, 'Nataša', 'Besednjak', 'natasa.besednjak@siol.net', 'abc123', 1),
(13, 'Andraž', 'Pušnik', 'andraz.pusnik@sc.si', 'abc123', 1),
(14, 'Boštjan', 'Lubej', 'bostjan.lubej@sc.si', 'abc123', 1),
(15, 'Žiga', 'Pušelc', 'ziga.puselc@siol.net', 'abc123', 1),
(16, 'Oskar', 'Žveglič', 'oskar.zveglic@sc.si', 'abc123', 1),
(17, 'Tjaša', 'Verdev', 'tjasa.verdev@sc.si', 'abc123', 1),
(18, 'Boštjan', 'Fidler', 'bostjan.fidler@sc.si', 'abc123', 1),
(19, 'Matic', 'Holobar', 'matic.holobar@sc.si', 'abc123', 1),
(20, 'Matej', 'Kališek', 'matej.kalisek@sc.si', 'abc123', 1),
(21, 'Bojan', 'Herman', 'bojan.herman@sc.si', 'abc123', 1),
(22, 'Klavdija', 'Špur Jereb', 'klavdija.spur.jereb@sc.si', 'abc123', 1),
(23, 'Tilen', 'Sirk', 'tilen.sirk@sc.si', 'abc123', 1),
(24, 'Mojca', 'Podkrižnik', 'mojca.podkriznik@siol.net', 'abc123', 2),
(25, 'Peter', 'Malik', 'peter.malik@gmail.com', 'abc123', 2),
(26, 'Rok', 'Urni', 'rok.urni@gmail.com', 'abc123', 2),
(27, 'Ana', 'Novak', 'ana.novak@siol.net', 'abc123', 2),
(28, 'Maja', 'Kralj', 'maja.kralj@siol.net', 'abc123', 2),
(29, 'Nina', 'Horvat', 'nina.horvat@siol.net', 'abc123', 2),
(30, 'Lara', 'Zupan', 'lara.zupan@siol.net', 'abc123', 2),
(31, 'Eva', 'Mlakar', 'eva.mlakar@siol.net', 'abc123', 2),
(32, 'Luka', 'Zajc', 'luka.zajc@gmail.com', 'abc123', 2),
(33, 'Marko', 'Novak', 'marko.novak@siol.net', 'abc123', 2),
(34, 'Žan', 'Kralj', 'zan.kralj@gmail.com', 'abc123', 2),
(35, 'Miha', 'Horvat', 'miha.horvat@gmail.com', 'abc123', 2),
(36, 'David', 'Mlakar', 'david.mlakar@gmail.com', 'abc123', 2),
(37, 'Jure', 'Potočnik', 'jure.potocnik@gmail.com', 'abc123', 2),
(38, 'Tomaž', 'Medved', 'tomaz.medved@gmail.com', 'abc123', 2),
(39, 'Peter', 'Kovač', 'peter.kovac@gmail.com', 'abc123', 2),
(40, 'Andrej', 'Rozman', 'andrej.rozman@gmail.com', 'abc123', 2),
(41, 'Simon', 'Bizjak', 'simon.bizjak@gmail.com', 'abc123', 2),
(42, 'Gregor', 'Turk', 'gregor.turk@gmail.com', 'abc123', 2),
(43, 'Matej', 'Žagar', 'matej.zagar@gmail.com', 'abc123', 2),
(44, 'Alen', 'Vidmar', 'alen.vidmar@gmail.com', 'abc123', 2),
(45, 'Rok', 'Jerman', 'rok.jerman@gmail.com', 'abc123', 2),
(46, 'Nejc', 'Košir', 'nejc.kosir@gmail.com', 'abc123', 2),
(47, 'Tjaš', 'Potočnik', 'tjaš.potocnik@gmail.com', 'abc123', 2),
(48, 'Klara', 'Zajec', 'klara.zajec@gmail.com', 'abc123', 2),
(49, 'Mojca', 'Medved', 'mojca.medved@siol.net', 'abc123', 2),
(50, 'Sara', 'Kovač', 'sara.kovac@gmail.com', 'abc123', 2),
(51, 'Barbara', 'Rozman', 'barbara.rozman@siol.net', 'abc123', 2),
(52, 'Jan', 'Bizjak', 'jan.bizjak@gmail.com', 'abc123', 2),
(53, 'Katja', 'Turek', 'katja.turek@gmail.com', 'abc123', 2),
(54, 'Urh', 'Žagar', 'urh.zagar@gmail.com', 'abc123', 2),
(55, 'Alja', 'Vidmar', 'alja.vidmar@gmail.com', 'abc123', 2),
(56, 'Špela', 'Jeram', 'špela.jeram@gmail.com', 'abc123', 2),
(57, 'Neža', 'Košir', 'neza.kosir@gmail.com', 'abc123', 2),
(58, 'Denis', 'Božičnik', 'denis.bozicnik@gmail.com', 'abc123', 2),
(59, 'Aleš', 'Rebrnik', 'ales.rebrnik@siol.net', 'abc123', 2),
(60, 'Miha', 'Rebršak', 'miha.rebrsak@gmail.com', 'abc123', 2),
(61, 'Igor', 'Kocjan', 'igor.kocjan@gmail.com', 'abc123', 2),
(62, 'Boris', 'Mayer', 'boris.mayer@gmail.com', 'abc123', 2),
(63, 'Sebastian', 'Kristan', 'sebastian.kristan@gmail.com', 'abc123', 2),
(64, 'Kristjan', 'Zajec', 'kristjan.zajec@gmail.com', 'abc123', 2),
(65, 'Ivan', 'Petek', 'ivan.petek@gmail.com', 'abc123', 2),
(66, 'Martin', 'Kačur', 'martin.kacur@gmail.com', 'abc123', 2),
(67, 'Boštjan', 'Knez', 'bostjan.knez@gmail.com', 'abc123', 2),
(68, 'Boris', 'Dolenšek', 'boris.dolensek@gmail.com', 'abc123', 2),
(69, 'Žiga', 'Ribič', 'ziga.ribic@gmail.com', 'abc123', 2),
(70, 'Milanka', 'Gradišar', 'milanka.gradisar@gmail.com', 'abc123', 2),
(71, 'Deja', 'Kocjančič', 'deja.kocjancic@gmail.com', 'abc123', 2),
(72, 'Milan', 'Gradič', 'milan.gradic@gmail.com', 'abc123', 2),
(73, 'Filip', 'Tomšič', 'filip.tomsic@gmail.com', 'abc123', 2),
(74, 'Dejan', 'Vovk', 'dejan.vovk@gmail.com', 'abc123', 2),
(75, 'Francka', 'Cankar', 'francka.cankar@gmail.com', 'abc123', 2),
(76, 'Sebastijan', 'Hrovat', 'sebastijan.hrovat@gmail.com', 'abc123', 2),
(77, 'Tanja', 'Rajh', 'tanja.rajh@gmail.com', 'abc123', 2),
(78, 'Lidija', 'Vrhunc', 'lidija.vrhunc@gmail.com', 'abc123', 2),
(79, 'Olga', 'Vidic', 'olga.vidic@gmail.com', 'abc123', 2),
(80, 'Aleš', 'Vidičnik', 'ales.vidicnik@gmail.com', 'abc123', 2),
(81, 'Alenka', 'Zupan', 'alenka.zupan@gmail.com', 'abc123', 2),
(82, 'Rok', 'Zupančič', 'rok.zupancic@gmail.com', 'abc123', 2),
(83, 'Helena', 'Pirc', 'helena.pirc@gmail.com', 'abc123', 2),
(84, 'Mark', 'Kosec', 'mark.kosec@gmail.com', 'abc123', 2),
(85, 'Maša', 'Bevčič', 'masa.bevcic@gmail.com', 'abc123', 2),
(86, 'Hana', 'Rajh', 'hana.rajh@gmail.com', 'abc123', 2),
(87, 'Lucija', 'Ramšak', 'lucija.ramsak@gmail.com', 'abc123', 2),
(88, 'Tit', 'Črni', 'tit.crni@gmail.com', 'abc123', 2),
(89, 'Krista', 'Zorčič', 'krista.zorcic@gmail.com', 'abc123', 2),
(90, 'Matej', 'Zorko', 'matej.zorko@gmail.com', 'abc123', 2),
(91, 'Jasmina', 'Kocbek', 'jasmina.kocbek@gmail.com', 'abc123', 2),
(92, 'Simona', 'Prešeren', 'simona.preseren@gmail.com', 'abc123', 2),
(93, 'Elizabeta', 'Kovač', 'elizabeta.kovac@gmail.com', 'abc123', 2),
(94, 'Dani', 'Presec', 'dani.presec@gmail.com', 'abc123', 2),
(95, 'Roman', 'Bevc', 'roman.bevc@gmail.com', 'abc123', 2),
(96, 'Ivanka', 'Petrič', 'ivanka.petric@gmail.com', 'abc123', 2),
(97, 'Maruša', 'Knez', 'marusa.knez@gmail.com', 'abc123', 2),
(98, 'Teja', 'Ribič', 'teja.ribic@gmail.com', 'abc123', 2),
(99, 'Andrej', 'Kraljič', 'andrej.kraljic@gmail.com', 'abc123', 2),
(100, 'Andrejka', 'Lončar', 'andrejka.loncar@gmail.com', 'abc123', 2),
(101, 'Živa', 'Tomšič', 'ziva.tomsic@gmail.com', 'abc123', 2),
(102, 'Romana', 'Vovk', 'romana.vovk@gmail.com', 'abc123', 2),
(103, 'Mojmir', 'Majer', 'mojmir.majer@gmail.com', 'abc123', 2),
(104, 'Leja', 'Božič', 'leja.bozic@gmail.com', 'abc123', 2),
(105, 'Edvard', 'Kocmur', 'edvard.kocmur@gmail.com', 'abc123', 2),
(106, 'Ratko', 'Šubic', 'ratko.subic@gmail.com', 'abc123', 2),
(107, 'Miran', 'Jereb', 'miran.jereb@gmail.com', 'abc123', 2),
(108, 'Aleš', 'Vidic', 'ales.vidic@gmail.com', 'abc123', 2),
(109, 'Jan', 'Pirc', 'jan.pirc@gmail.com', 'abc123', 2),
(110, 'Zoran', 'Zupanek', 'zoran.zupanek@gmail.com', 'abc123', 2),
(111, 'Oskar', 'Križaj', 'oskar.krizaj@gmail.com', 'abc123', 2),
(112, 'Stanko', 'Oblak', 'stanko.oblak@gmail.com', 'abc123', 2),
(113, 'Tilen', 'Bojkov', 'tilen.bojkov@gmail.com', 'abc123', 2),
(114, 'Lovro', 'Ramšak', 'lovro.ramsak@gmail.com', 'abc123', 2),
(115, 'Rok', 'Štrukelj', 'rok.strukelj@gmail.com', 'abc123', 2),
(116, 'Zoran', 'Vrhunc', 'zoran.vrhunc@gmail.com', 'abc123', 2),
(117, 'Primož', 'Kovač', 'primoz.kovac@gmail.com', 'abc123', 2),
(118, 'Gašper', 'Oblak', 'gasper.oblak@gmail.com', 'abc123', 2),
(119, 'Mare', 'Kocuvan', 'mare.kocuvan@gmail.com', 'abc123', 2),
(120, 'Anja', 'Ribičič', 'anja.ribicic@gmail.com', 'abc123', 2),
(121, 'Mark', 'Kolovrat', 'mark.kolovrat@gmail.com', 'abc123', 2);

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `gradiva`
--
ALTER TABLE `gradiva`
  ADD PRIMARY KEY (`idGradiva`),
  ADD KEY `predmet_idPredmeta` (`predmet_idPredmeta`);

--
-- Indeksi tabele `naloge`
--
ALTER TABLE `naloge`
  ADD PRIMARY KEY (`idNaloge`),
  ADD KEY `Predmet-idPredmeta` (`Predmet-idPredmeta`);

--
-- Indeksi tabele `oddaje`
--
ALTER TABLE `oddaje`
  ADD KEY `naloge_idNaloge` (`naloge_idNaloge`),
  ADD KEY `uporabnik_idUporabnika` (`uporabnik_idUporabnika`);

--
-- Indeksi tabele `predmet`
--
ALTER TABLE `predmet`
  ADD PRIMARY KEY (`idPredmeta`);

--
-- Indeksi tabele `ucenec_predmet`
--
ALTER TABLE `ucenec_predmet`
  ADD KEY `predmet_idPredmeta` (`predmet_idPredmeta`),
  ADD KEY `uporabnik_idUporabnika` (`uporabnik_idUporabnika`);

--
-- Indeksi tabele `ucitelj_predmet`
--
ALTER TABLE `ucitelj_predmet`
  ADD KEY `predmet_idPredmeta` (`predmet_idPredmeta`),
  ADD KEY `uporabnik_idUporabnika` (`uporabnik_idUporabnika`);

--
-- Indeksi tabele `uporabnik`
--
ALTER TABLE `uporabnik`
  ADD PRIMARY KEY (`idUporabnika`);

--
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `gradiva`
--
ALTER TABLE `gradiva`
  MODIFY `idGradiva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT tabele `naloge`
--
ALTER TABLE `naloge`
  MODIFY `idNaloge` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT tabele `uporabnik`
--
ALTER TABLE `uporabnik`
  MODIFY `idUporabnika` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `gradiva`
--
ALTER TABLE `gradiva`
  ADD CONSTRAINT `gradiva_ibfk_1` FOREIGN KEY (`predmet_idPredmeta`) REFERENCES `predmet` (`idPredmeta`) ON DELETE CASCADE;

--
-- Omejitve za tabelo `naloge`
--
ALTER TABLE `naloge`
  ADD CONSTRAINT `naloge_ibfk_1` FOREIGN KEY (`Predmet-idPredmeta`) REFERENCES `predmet` (`idPredmeta`) ON DELETE CASCADE;

--
-- Omejitve za tabelo `oddaje`
--
ALTER TABLE `oddaje`
  ADD CONSTRAINT `oddaje_ibfk_1` FOREIGN KEY (`uporabnik_idUporabnika`) REFERENCES `uporabnik` (`idUporabnika`) ON DELETE CASCADE,
  ADD CONSTRAINT `oddaje_ibfk_2` FOREIGN KEY (`naloge_idNaloge`) REFERENCES `naloge` (`idNaloge`) ON DELETE CASCADE;

--
-- Omejitve za tabelo `ucenec_predmet`
--
ALTER TABLE `ucenec_predmet`
  ADD CONSTRAINT `ucenec_predmet_ibfk_1` FOREIGN KEY (`uporabnik_idUporabnika`) REFERENCES `uporabnik` (`idUporabnika`) ON DELETE CASCADE,
  ADD CONSTRAINT `ucenec_predmet_ibfk_2` FOREIGN KEY (`predmet_idPredmeta`) REFERENCES `predmet` (`idPredmeta`) ON DELETE CASCADE;

--
-- Omejitve za tabelo `ucitelj_predmet`
--
ALTER TABLE `ucitelj_predmet`
  ADD CONSTRAINT `ucitelj_predmet_ibfk_1` FOREIGN KEY (`uporabnik_idUporabnika`) REFERENCES `uporabnik` (`idUporabnika`) ON DELETE CASCADE,
  ADD CONSTRAINT `ucitelj_predmet_ibfk_2` FOREIGN KEY (`predmet_idPredmeta`) REFERENCES `predmet` (`idPredmeta`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
