-- phpMyAdmin SQL Dump
-- version 5.2.0-rc1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 22. Jul 2022 um 07:40
-- Server-Version: 5.7.36
-- PHP-Version: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `cms`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `published_at` datetime DEFAULT NULL,
  `image_file` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `article`
--

INSERT INTO `article` (`id`, `title`, `content`, `published_at`, `image_file`) VALUES
(18, 'CMS', 'Content Managment System Hello  2022', '2022-07-20 13:33:00', NULL),
(23, 'Hi', 'How are you ???? iam Fine 22222222222', '2022-07-22 07:39:00', '720_x_528_px_Lehrlinge22GeraetKlein.jpg'),
(24, 'Anton Paar buys viewing platform', 'Since 2014, the listed Fürstenstand had been repeatedly closed due to the danger of collapse. Now, as part of the company\'s 100th anniversary, the Anton Paar Group decided to renovate the popular excursion destination so that visitors can enjoy the all-round view of the region from the viewing platform again.\r\n\r\nIn June 2022, the 24 Asset Management GmbH, subsidiary of Anton Paar Group AG, purchased the property of about one hectare, which also includes a former restaurant. The redevelopment of the Fürstenstand will take several months.\r\n\r\nLocal recreation area for the entire region\r\nThe observation platform is located at an altitude of 754 meters above sea level and offers an excellent view of the entire region. It owes its name to Emperor Franz I, who visited Graz\'s local mountain in 1830 in his role as Styrian sovereign. In 1839 the first structure was built of wood, and in 1852 the current snail shape was constructed of stone.\r\n\r\n\"Fürstenstand is one of the most popular excursion destinations in the greater Graz area and has a special significance for the inhabitants of the Styrian capital as well as the municipalities in the region. Not only because of its history the place at the summit of Plabutsch is a Styrian cultural asset, the view over Graz, but also the view over Western Styria is unique and should not be denied to anyone. Therefore, we are pleased that this unique lookout can soon be enjoyed by the population again,\" says Friedrich Santner, CEO of Anton Paar GmbH.', '2022-07-21 15:13:00', 'csm_720_x_528_px_Lehrlinge21__GeraetGross_af45eae7fd.jpg'),
(25, 'Frühschoppen im Sudhaus', 'Ein abwechslungsreiches Programm bot letzten Sonntag der Radio Steiermark Frühschoppen, der live vom Sudhaus übertragen wurde.\r\n\r\nNeben dem Anton Paar Chor sorgten Benedikt Krainz, Los Insuperables und die Anbradler für gute Unterhaltung. ORF-Moderator Paul Reicher führte gekonnt durch das Programm und stellte den Zuhörerinnen und Zuhörern in der knapp einstündigen Sendung das Unternehmen und dessen Geschichte vor.\r\n\r\nWir bedanken uns bei den Musikerinnen und Musikern sowie bei den Sängerinnen und Sängern für musikalische Umrahmung des Frühschoppens und ein Danke gilt auch dem Sudhaus-Team für die Verpflegung der Gäste.', NULL, NULL),
(26, 'Hi', 'Hello ', NULL, NULL),
(27, 'Hello ', 'Hi 333333', NULL, NULL),
(28, 'Meeting ', 'Today  in Graz  20/07/2022 13:00', NULL, NULL),
(29, 'Abudi', 'Hi today is the last work day ', NULL, NULL),
(30, 'xx', 'xxxxx', '2022-07-22 09:11:00', NULL),
(31, 'Anton paar', 'Hello World!', '2022-07-22 09:23:00', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `article_category`
--

CREATE TABLE `article_category` (
  `article_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `article_category`
--

INSERT INTO `article_category` (`article_id`, `category_id`) VALUES
(18, 1),
(25, 2),
(28, 3),
(28, 4);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(3, 'education'),
(1, 'news'),
(4, 'products'),
(2, 'technology');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(1, 'root', '$2y$10$5yE1Zir27WYRhrwpKfKWp.b2.XLUvFMEJKKO9dRu7WVKwWEHcIvJi');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `web_application`
--

CREATE TABLE `web_application` (
  `id` int(11) NOT NULL,
  `Name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Age` int(11) NOT NULL,
  `Adresse` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `web_application`
--

INSERT INTO `web_application` (`id`, `Name`, `Age`, `Adresse`, `Date`) VALUES
(1, 'Abdulrhman Alshalal', 30, 'Qullenweg 3 ,8451 Heimschuh', '2022-04-15 08:01:19'),
(2, 'Gottfried Goessler', 32, 'Vortisberg ', '2022-04-15 08:16:19'),
(3, 'Chalid El-Heliebi', 28, 'Graz', '2022-04-15 08:55:21'),
(4, 'Onur Hanguel', 36, 'Graz', '2022-04-15 06:33:25'),
(5, 'Samo Lajtinger', 32, 'Slovenia', '2022-04-12 03:09:37'),
(6, 'Max Sommer', 31, 'Graz', '2022-04-15 09:54:59'),
(8, 'Chaild', 22, 'Graz', '2022-04-29 10:53:26');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `article_category`
--
ALTER TABLE `article_category`
  ADD PRIMARY KEY (`category_id`) USING BTREE,
  ADD KEY `article_id` (`article_id`,`category_id`) USING BTREE;

--
-- Indizes für die Tabelle `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indizes für die Tabelle `web_application`
--
ALTER TABLE `web_application`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT für Tabelle `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `web_application`
--
ALTER TABLE `web_application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `article_category`
--
ALTER TABLE `article_category`
  ADD CONSTRAINT `article_category_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `article_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
