-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 02 juil. 2024 à 03:59
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gov_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `gares`
--

CREATE TABLE `gares` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `gares`
--

INSERT INTO `gares` (`id`, `name`, `location`) VALUES
(1, 'Gare de Lyon', 'paris'),
(2, 'Gare de Nantes', 'Nates'),
(3, 'Gare de nice', 'Nice'),
(4, 'Gare de Lille', 'Lille'),
(5, 'Gare de Lille', 'Lille'),
(6, 'Gare d Aubagne', 'Aubagne'),
(7, 'Gare example', 'exampe'),
(8, 'Example', 'Example'),
(9, 'Gare gggg', 'gggg'),
(10, 'Gare fffff', 'fffff');

-- --------------------------------------------------------

--
-- Structure de la table `natures`
--

CREATE TABLE `natures` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `color` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `natures`
--

INSERT INTO `natures` (`id`, `name`, `color`) VALUES
(1, 'TGV', 'blue'),
(2, 'TGV INOUI', 'yellow'),
(8, 'Nature 2', ''),
(9, 'Example', ''),
(10, 'Example', ''),
(11, 'nature 2', ''),
(12, 'Nature 4', ''),
(13, 'nature 4', ''),
(14, 'nature 3', ''),
(15, 'Nature 4', '');

-- --------------------------------------------------------

--
-- Structure de la table `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `options`
--

INSERT INTO `options` (`id`, `name`) VALUES
(1, 'HLP'),
(2, 'Reste à quai'),
(3, 'Réserve'),
(6, 'Option2'),
(7, 'Option 3'),
(8, 'Option 4');

-- --------------------------------------------------------

--
-- Structure de la table `trains`
--

CREATE TABLE `trains` (
  `id` int(11) NOT NULL,
  `number` varchar(50) NOT NULL,
  `departure_time` time NOT NULL,
  `arrival_time` time NOT NULL,
  `origin` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `track` varchar(50) NOT NULL,
  `option` varchar(255) NOT NULL,
  `nature_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `trains`
--

INSERT INTO `trains` (`id`, `number`, `departure_time`, `arrival_time`, `origin`, `destination`, `track`, `option`, `nature_id`) VALUES
(3, '01', '06:38:00', '11:39:00', 'paris', 'lyon', '5', 'aaaa', 1),
(26, '098', '01:01:00', '05:00:00', 'Paris', 'Lyon', '1', 'HLP', 2),
(30, '113', '04:00:00', '06:00:00', 'hwwhwh', 'hhhwhw', '11', 'HLP', 2),
(34, '100', '00:00:00', '03:28:00', 'AAJAJ', 'SSJJSJ', '16', 'HLP', 1),
(35, '101', '05:09:00', '03:28:00', 'AAJAJ', 'SSJJSJ', '1', 'HLP', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'LAGHNIMI', 'hlaghnimi@gf.com', '$2y$10$6ggwqp9PBBCk2nbTsaBZt.T9CmdsZH/ODJ7IrHoOQRRo2StX1rs7O');

-- --------------------------------------------------------

--
-- Structure de la table `voies`
--

CREATE TABLE `voies` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('in_service','out_of_service','maintenance') NOT NULL,
  `longueur` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `voies`
--

INSERT INTO `voies` (`id`, `name`, `status`, `longueur`) VALUES
(1, 'Voie 1', 'in_service', '250m'),
(2, 'Voie 2', 'maintenance', '250m'),
(3, 'Voie 3', 'in_service', '250m'),
(4, 'Voie 4', 'out_of_service', '250m'),
(5, 'Voie 5', 'in_service', '250m'),
(6, 'Voie 6', 'out_of_service', '250m'),
(7, 'Voie 7', 'out_of_service', '250m'),
(10, 'Voie 8', 'out_of_service', '250m'),
(11, 'Voie 9', 'in_service', '250m'),
(14, 'Voie 10', 'in_service', '250m'),
(15, 'Voie 11', 'in_service', '250m'),
(16, 'Voie 12', 'in_service', '250m'),
(17, 'Voie 13', 'in_service', '250m'),
(18, 'Voie 14', 'in_service', '250m'),
(19, 'Voie 15', 'in_service', '250m'),
(20, 'Voie 16', 'in_service', '250m'),
(21, 'Voie 17', 'in_service', '250m'),
(22, 'Voie 18', 'in_service', '250m'),
(23, 'Voie 19', 'in_service', '250m');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `gares`
--
ALTER TABLE `gares`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `natures`
--
ALTER TABLE `natures`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `trains`
--
ALTER TABLE `trains`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `number` (`number`),
  ADD KEY `fk_nature` (`nature_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `voies`
--
ALTER TABLE `voies`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `gares`
--
ALTER TABLE `gares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `natures`
--
ALTER TABLE `natures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `trains`
--
ALTER TABLE `trains`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `voies`
--
ALTER TABLE `voies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `trains`
--
ALTER TABLE `trains`
  ADD CONSTRAINT `fk_nature` FOREIGN KEY (`nature_id`) REFERENCES `natures` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
