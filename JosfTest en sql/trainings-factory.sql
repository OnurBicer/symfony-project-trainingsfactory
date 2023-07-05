-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 15 jun 2023 om 12:03
-- Serverversie: 10.4.24-MariaDB
-- PHP-versie: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trainings-factory`
--
CREATE DATABASE IF NOT EXISTS `trainings-factory` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `trainings-factory`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230523080845', '2023-05-23 10:08:51', 872),
('DoctrineMigrations\\Version20230523081452', '2023-05-23 10:14:56', 121),
('DoctrineMigrations\\Version20230523082453', '2023-05-23 10:25:00', 39),
('DoctrineMigrations\\Version20230524072947', '2023-05-24 09:29:56', 30),
('DoctrineMigrations\\Version20230524100602', '2023-05-24 12:06:09', 530),
('DoctrineMigrations\\Version20230524115444', '2023-05-24 13:54:49', 41),
('DoctrineMigrations\\Version20230524120826', '2023-05-24 14:08:32', 130),
('DoctrineMigrations\\Version20230524121120', '2023-05-24 14:11:26', 62);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `lesson`
--

DROP TABLE IF EXISTS `lesson`;
CREATE TABLE `lesson` (
  `id` int(11) NOT NULL,
  `training_id` int(11) DEFAULT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_persons` int(11) NOT NULL,
  `instructor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `lesson`
--

INSERT INTO `lesson` (`id`, `training_id`, `time`, `date`, `location`, `max_persons`, `instructor_id`) VALUES
(1, 1, '16:16:00', '2023-06-17', 'loremstraat 1', 3, 16),
(7, 3, '13:00:00', '2023-06-15', 'test', 5, 16);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `registration`
--

DROP TABLE IF EXISTS `registration`;
CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `payment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `registration`
--

INSERT INTO `registration` (`id`, `lesson_id`, `payment`, `user_id`) VALUES
(3, 1, '4', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `training`
--

DROP TABLE IF EXISTS `training`;
CREATE TABLE `training` (
  `id` int(11) NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extra_costs` decimal(5,2) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `training`
--

INSERT INTO `training` (`id`, `description`, `duration`, `extra_costs`, `image`, `title`) VALUES
(1, 'Kickboksen is een vechtsport waarbij zowel de handen als de benen mogen worden gebruikt. De sport kent zijn oorsprong in Japan en de Verenigde Staten, en werd daar populair in het begin van de jaren 1970. Bij kickboksen worden de stoten van het boksen gecombineerd met de trappen uit sporten zoals karate en taekwondo.', '30', NULL, 'img/vechtsporten/kickboksen.jpg', 'Kickboksen'),
(2, 'Mixed martial arts (Engels voor gemengde gevechtskunsten), meestal afgekort tot MMA, is een multidisciplinaire vechtsport die zich richt op het combineren van technieken uit meerdere traditionele vechtkunsten (en vechtsporten) die door beoefenaars van MMA met de verzamelnaam TMA (Traditional Martial Arts) worden aangeduid.', '60', NULL, 'img/vechtsporten/mma.jpg', 'MMA'),
(3, 'Boksen, of pugilistiek, is een tactische vechtsport waarbij ringinzicht, de coördinatie van voeten, ogen en handen, en conditie centraal staan. Twee tegenstanders proberen punten te scoren door elkaar op de juiste trefvlakken te raken, of te winnen op bijvoorbeeld een knock-out.', '30', '5.00', 'img/vechtsporten/boksen.jpg', 'Boksen'),
(4, 'Een bokszaktraining is een full body workout waarbij al je spieren worden aangesproken. Tijdens het stoten en trappen op de bokszak staan je spieren constant onder spanning. Daarnaast worden er vaak ook andere spierversterkende oefeningen gedaan bij een bokszaktraining zoals opdrukken, squats en buikspieroefeningen.', '35', NULL, 'img/stootzak/stootzaktraining.jpg', 'Stootzaktraining'),
(5, 'Een bootcamp is een spierversterkende trainingsmethode uitgevoerd in teamverband onder professionele begeleiding van een fitnessinstructeur. Het doel is om de kracht en uithouding te verbeteren door intense groepstrainingen gedurende de periode van een uur.', '65', '10.50', 'img/bootcamp/bootcamp.jpg', 'Bootcamp'),
(6, 'Cardio is een trainingsvorm waarbij je een (deel) van je lichaam traint en dan voornamelijk het cardiovasculaire systeem (hart- en vaatselsel) door middel van (intensieve) beweging of sport. Voorbeelden van een cardiotraining zijn: hardlopen. fietsen.', '45', NULL, 'img/fitness/cardio.jpg', 'Cardio training'),
(9, 'Krachttraining is een manier van sporten waarmee je jouw spiermassa, kracht en uithoudingsvermogen gaat vergroten. Daarbij krijg je er een betere houding van en gaat ook je vetverbranding flink omhoog', '25', NULL, 'img/fitness/kracht.jpg', 'Kracht training');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `preprovision` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateofbirth` date NOT NULL,
  `hiring_date` date DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `social_sec_number` int(11) DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `place` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `firstname`, `preprovision`, `lastname`, `dateofbirth`, `hiring_date`, `salary`, `social_sec_number`, `street`, `place`) VALUES
(1, 'klaas@rocmondriaan.nl', '[\"ROLE_MEMBER\"]', '$2y$13$nMSJd964nnZfBZB7hhIHH.QLDpe/sCKArLFgGJYUK77RE.Qk1PgTW', 'Klaas', 'q', 'Ipsum', '2023-05-03', NULL, NULL, NULL, 'nieuwestraat 134', 'den haag'),
(16, 'example@index.nl', '[\"ROLE_ADMIN\"]', '$2y$13$nMSJd964nnZfBZB7hhIHH.QLDpe/sCKArLFgGJYUK77RE.Qk1PgTW', 'ari', 'a', 'test', '2023-01-03', '2020-06-10', '450.00', 23, NULL, NULL),
(27, 'testing@mail.com', '[\"ROLE_INSTRUCT\"]', '$2y$13$kx0PtqDKL8x/fgnOWi.Wge0sfJYRpAwANHzU9ARCN8pY7GIfM91e2', 'lorre', 'van', 'insert', '2024-01-05', NULL, NULL, 5444, 'sterrrestraat 23', 'Den Haag'),
(31, 'test@trainingsfactory.com', '[\"ROLE_ADMIN\"]', '$2y$13$BEShp9s4SHXDmIPJl1JUpeXrz3xBVUJVVQgsl1AxKzr44kQnyayQ.', 'q3w4e5r6t7y8u', '34e5rt67y', 'e45r7t68', '2023-12-31', '2020-01-31', '12345.00', 234, NULL, NULL);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexen voor tabel `lesson`
--
ALTER TABLE `lesson`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F87474F3BEFD98D1` (`training_id`),
  ADD KEY `IDX_F87474F38C4FC193` (`instructor_id`);

--
-- Indexen voor tabel `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indexen voor tabel `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_62A8A7A7CDF80196` (`lesson_id`),
  ADD KEY `IDX_62A8A7A7A76ED395` (`user_id`);

--
-- Indexen voor tabel `training`
--
ALTER TABLE `training`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `lesson`
--
ALTER TABLE `lesson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT voor een tabel `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT voor een tabel `training`
--
ALTER TABLE `training`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT voor een tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `lesson`
--
ALTER TABLE `lesson`
  ADD CONSTRAINT `FK_F87474F38C4FC193` FOREIGN KEY (`instructor_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_F87474F3BEFD98D1` FOREIGN KEY (`training_id`) REFERENCES `training` (`id`);

--
-- Beperkingen voor tabel `registration`
--
ALTER TABLE `registration`
  ADD CONSTRAINT `FK_62A8A7A7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_62A8A7A7CDF80196` FOREIGN KEY (`lesson_id`) REFERENCES `lesson` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
