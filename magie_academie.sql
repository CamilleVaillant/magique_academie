-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 13 déc. 2024 à 15:45
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `magie_academie`
--

-- --------------------------------------------------------

--
-- Structure de la table `bestiaire`
--

DROP TABLE IF EXISTS `bestiaire`;
CREATE TABLE IF NOT EXISTS `bestiaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `id_user` int NOT NULL,
  `id_type` int NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_type` (`id_type`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `bestiaire`
--

INSERT INTO `bestiaire` (`id`, `nom`, `description`, `id_user`, `id_type`, `image_path`) VALUES
(1, 'elementaire d&#039;eau', 'femme bleu au pouvoir aquatique', 1, 1, '1734096610215.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `element`
--

DROP TABLE IF EXISTS `element`;
CREATE TABLE IF NOT EXISTS `element` (
  `id` int NOT NULL AUTO_INCREMENT,
  `element` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `element`
--

INSERT INTO `element` (`id`, `element`) VALUES
(1, 'lumière'),
(2, 'eau'),
(3, 'air'),
(4, 'feu');

-- --------------------------------------------------------

--
-- Structure de la table `sort`
--

DROP TABLE IF EXISTS `sort`;
CREATE TABLE IF NOT EXISTS `sort` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `id_element` int NOT NULL,
  `id_user` int NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_element` (`id_element`),
  KEY `id_user` (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `sort`
--

INSERT INTO `sort` (`id`, `nom`, `id_element`, `id_user`, `image_path`) VALUES
(1, 'eclair', 3, 1, '1734104143265.webp');

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

DROP TABLE IF EXISTS `type`;
CREATE TABLE IF NOT EXISTS `type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`id`, `type`) VALUES
(1, '[aquatique]'),
(2, '[démoniaque]'),
(3, '[mort vivante]'),
(4, '[mi-bête]');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','utilisateur') COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `password`, `role`) VALUES
(1, 'catherine', '$2y$10$YBiK70fO1K4stf5ZBtoA9OqfLBQ.nCnATahqcpO9k07tHDQOZ6qi6', 'admin'),
(2, 'anastasya', '$2y$10$wf4QDqVgKLUEQ9dmBVvxp.8pbNGSBQBAehoiJz5RSKyfMvKqkLO3C', 'admin'),
(3, 'kiril', '$2y$10$xNghw2jq/rbFU5nUh8c1c.et.U7hf1cMq24ePlkK65DTAViyPBpyi', 'admin'),
(4, 'anton', '$2y$10$B/Y9GJY9AtQrniI7/vSwHO8L.dCl1YDnXce0Cge0w3JQg/jhBau7K', 'admin'),
(5, 'irina', '$2y$10$mr3CqS3a2oQ/QAMXdDxUAeL3kRo8BuuLF5G/3FXi5KJE9HquN575y', 'admin'),
(6, 'jorgen', '$2y$10$SfAJ0liEhsyggl79N2ha0enH.du4ONhuZ2dPl/Azmrx94W85jJa02', 'admin'),
(7, 'kalindra', '$2y$10$wshTvIHRsOjr0vSfDd5TU.mZ/0Y4jF9j1l0.dmC3JF6KmDH4GD2Kq', 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `user_element`
--

DROP TABLE IF EXISTS `user_element`;
CREATE TABLE IF NOT EXISTS `user_element` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `id_element` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_element` (`id_element`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user_element`
--

INSERT INTO `user_element` (`id`, `id_user`, `id_element`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 2, 2),
(6, 3, 1),
(7, 3, 4),
(8, 4, 1),
(9, 4, 2),
(10, 5, 2),
(11, 5, 3),
(12, 6, 4),
(13, 7, 3);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
