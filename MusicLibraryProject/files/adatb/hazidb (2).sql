-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2021. Máj 17. 05:01
-- Kiszolgáló verziója: 10.4.17-MariaDB
-- PHP verzió: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `hazidb`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalo`
--

CREATE TABLE `felhasznalo` (
  `userid` smallint(5) UNSIGNED NOT NULL,
  `vezeteknev` varchar(45) DEFAULT NULL,
  `keresztnev` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `jelszo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `felhasznalo`
--

INSERT INTO `felhasznalo` (`userid`, `vezeteknev`, `keresztnev`, `email`, `jelszo`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', 'admin'),
(2, 'Teszt', 'Sanyi', 'sanyiteszt@gmail.com', '1234'),
(5, 'Dávid', 'Lajos Géza', 'dl@freemail.com', 'dl'),
(7, 'Dávid', 'Krisz', 'dk@gmail.com', 'dk'),
(8, 'dav', 'dave', 'dave@gmail.com', 'dave'),
(9, 'dl', 'dl', 'dac@gmail.com', 'dac');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `hallgataslista`
--

CREATE TABLE `hallgataslista` (
  `felhasznalo_userid` int(11) NOT NULL,
  `zene_idzene` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `hallgataslista`
--

INSERT INTO `hallgataslista` (`felhasznalo_userid`, `zene_idzene`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `iras`
--

CREATE TABLE `iras` (
  `zene_idzene` int(11) NOT NULL,
  `szerzo_idszerzo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `iras`
--

INSERT INTO `iras` (`zene_idzene`, `szerzo_idszerzo`) VALUES
(1, 1),
(2, 2),
(3, 2),
(4, 3),
(5, 4);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `szerzo`
--

CREATE TABLE `szerzo` (
  `idszerzo` smallint(5) UNSIGNED NOT NULL,
  `muvesznev` varchar(45) DEFAULT NULL,
  `szarmazas` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `szerzo`
--

INSERT INTO `szerzo` (`idszerzo`, `muvesznev`, `szarmazas`) VALUES
(1, 'Drake', 'kanadai'),
(2, 'EXO', 'koreai'),
(3, 'Alligatoah', 'nemet'),
(4, 'Rúzsa Magdi', 'magyar'),
(5, 'Gregorio', 'roma'),
(6, 'Hamvai PG', 'magyar'),
(7, 'David Guetta', 'francia'),
(8, 'GioBoosie300', 'curacaoi'),
(14, 'Dj A', 'magyar'),
(15, 'DJ Dávid', 'magyar');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `zene`
--

CREATE TABLE `zene` (
  `idzene` smallint(5) UNSIGNED NOT NULL,
  `cim` varchar(45) DEFAULT NULL,
  `zsanra` varchar(45) DEFAULT NULL,
  `kiadas` date DEFAULT NULL,
  `link` varchar(45) DEFAULT NULL,
  `nyelv` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `zene`
--

INSERT INTO `zene` (`idzene`, `cim`, `zsanra`, `kiadas`, `link`, `nyelv`) VALUES
(1, 'Wants and Needs', 'Rap', '2021-03-05', 'youtube.com/watch?v=U6k5dIhB6AM', 'angol'),
(2, 'Sweet Lies', 'R&B', '2017-09-05', 'youtube.com/watch?v=FFOLaEb7Xns', 'koreai'),
(3, 'Oh La La La', 'R&B', '2018-11-02', 'youtube.com/watch?v=8l4OGw3bEto', 'koreai'),
(4, 'Willst Du', 'Pop', '2013-08-16', 'youtube.com/watch?v=Ahwc-ouFeTQ', 'német'),
(5, 'Szerelem', 'Pop', '2012-11-11', 'youtube.com/watch?v=ydPwn3Hpn80', 'magyar'),
(29, 'a', 'a', '2021-05-14', 'a', 'a');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `felhasznalo`
--
ALTER TABLE `felhasznalo`
  ADD PRIMARY KEY (`userid`);

--
-- A tábla indexei `hallgataslista`
--
ALTER TABLE `hallgataslista`
  ADD PRIMARY KEY (`felhasznalo_userid`,`zene_idzene`),
  ADD KEY `fk_felhasznalo_has_zene_zene1_idx` (`zene_idzene`),
  ADD KEY `fk_felhasznalo_has_zene_felhasznalo_idx` (`felhasznalo_userid`);

--
-- A tábla indexei `iras`
--
ALTER TABLE `iras`
  ADD PRIMARY KEY (`zene_idzene`,`szerzo_idszerzo`),
  ADD KEY `fk_zene_has_szerzo_szerzo1_idx` (`szerzo_idszerzo`),
  ADD KEY `fk_zene_has_szerzo_zene1_idx` (`zene_idzene`);

--
-- A tábla indexei `szerzo`
--
ALTER TABLE `szerzo`
  ADD PRIMARY KEY (`idszerzo`);

--
-- A tábla indexei `zene`
--
ALTER TABLE `zene`
  ADD PRIMARY KEY (`idzene`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `felhasznalo`
--
ALTER TABLE `felhasznalo`
  MODIFY `userid` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT a táblához `szerzo`
--
ALTER TABLE `szerzo`
  MODIFY `idszerzo` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT a táblához `zene`
--
ALTER TABLE `zene`
  MODIFY `idzene` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `hallgataslista`
--
ALTER TABLE `hallgataslista`
  ADD CONSTRAINT `fk_felhasznalo_has_zene_felhasznalo` FOREIGN KEY (`felhasznalo_userid`) REFERENCES `felhasznalo` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_felhasznalo_has_zene_zene1` FOREIGN KEY (`zene_idzene`) REFERENCES `zene` (`idzene`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Megkötések a táblához `iras`
--
ALTER TABLE `iras`
  ADD CONSTRAINT `fk_zene_has_szerzo_szerzo1` FOREIGN KEY (`szerzo_idszerzo`) REFERENCES `szerzo` (`idszerzo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_zene_has_szerzo_zene1` FOREIGN KEY (`zene_idzene`) REFERENCES `zene` (`idzene`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
