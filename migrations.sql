-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Creato il: Apr 02, 2025 alle 15:11
-- Versione del server: 8.0.40
-- Versione PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `OrizonTravel`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `Country`
--

CREATE TABLE `Country` (
  `idCountry` int NOT NULL,
  `Country` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dump dei dati per la tabella `Country`
--

INSERT INTO `Country` (`idCountry`, `Country`) VALUES
(25, 'Giappone'),
(26, 'Cina'),
(27, 'India'),
(28, 'Corea del Sud'),
(29, 'Thailandia'),
(30, 'Vietnam'),
(31, 'Filippine'),
(32, 'Stati Uniti'),
(33, 'Canada'),
(34, 'Messico'),
(35, 'Brasile'),
(36, 'Argentina'),
(37, 'Perù'),
(38, 'Colombia'),
(39, 'Cuba');

-- --------------------------------------------------------

--
-- Struttura della tabella `Travel`
--

CREATE TABLE `Travel` (
  `idTravel` int NOT NULL,
  `Travel` varchar(45) NOT NULL,
  `Places_Avables` int NOT NULL,
  `idCountry` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dump dei dati per la tabella `Travel`
--

INSERT INTO `Travel` (`idTravel`, `Travel`, `Places_Avables`, `idCountry`) VALUES
(33, 'Viaggio in Giappone', 50, 1),
(34, 'Viaggio in Cina', 80, 2),
(35, 'Tour in India', 60, 3),
(36, 'Viaggio in Corea del Sud', 40, 4),
(37, 'Vacanza in Thailandia', 35, 5),
(38, 'Esplorazione del Vietnam', 45, 6),
(39, 'Tour nelle Filippine', 55, 7),
(40, 'Viaggio negli Stati Uniti', 100, 8),
(41, 'Tour in Canada', 50, 9),
(42, 'Vacanza in Messico', 40, 10),
(43, 'Viaggio in Brasile', 60, 11),
(44, 'Esplorazione dell\'Argentina', 30, 12),
(45, 'Viaggio in Perù', 50, 13),
(46, 'Tour in Colombia', 45, 14),
(47, 'Vacanza a Cuba', 50, 15);

-- --------------------------------------------------------

--
-- Struttura della tabella `Travel_Country`
--

CREATE TABLE `Travel_Country` (
  `idTravel` int NOT NULL,
  `idCountry` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dump dei dati per la tabella `Travel_Country`
--

INSERT INTO `Travel_Country` (`idTravel`, `idCountry`) VALUES
(33, 25),
(34, 26),
(36, 26),
(34, 27),
(35, 27),
(33, 28),
(36, 28),
(35, 29),
(37, 29),
(39, 29),
(35, 30),
(37, 30),
(38, 30),
(38, 31),
(39, 31),
(40, 32),
(41, 32),
(40, 33),
(41, 33),
(42, 34),
(43, 34),
(47, 34),
(42, 35),
(43, 35),
(43, 36),
(44, 36),
(44, 37),
(45, 37),
(46, 37),
(45, 38),
(46, 38),
(47, 39);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `Country`
--
ALTER TABLE `Country`
  ADD PRIMARY KEY (`idCountry`);

--
-- Indici per le tabelle `Travel`
--
ALTER TABLE `Travel`
  ADD PRIMARY KEY (`idTravel`);

--
-- Indici per le tabelle `Travel_Country`
--
ALTER TABLE `Travel_Country`
  ADD PRIMARY KEY (`idTravel`,`idCountry`),
  ADD KEY `idCountry` (`idCountry`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `Country`
--
ALTER TABLE `Country`
  MODIFY `idCountry` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT per la tabella `Travel`
--
ALTER TABLE `Travel`
  MODIFY `idTravel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `Travel_Country`
--
ALTER TABLE `Travel_Country`
  ADD CONSTRAINT `travel_country_ibfk_1` FOREIGN KEY (`idTravel`) REFERENCES `Travel` (`idTravel`) ON DELETE CASCADE,
  ADD CONSTRAINT `travel_country_ibfk_2` FOREIGN KEY (`idCountry`) REFERENCES `Country` (`idCountry`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
