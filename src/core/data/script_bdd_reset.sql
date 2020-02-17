-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  ven. 21 juin 2019 à 14:17
-- Version du serveur :  10.1.38-MariaDB
-- Version de PHP :  7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
DROP DATABASE `bddreserv`;
--
-- Base de données :  `bddreserv`
--
CREATE DATABASE IF NOT EXISTS `bddreserv` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `bddreserv`;

-- --------------------------------------------------------

--
-- Structure de la table `contenir`
--

CREATE TABLE `contenir` (
  `Id` int(11) NOT NULL,
  `IdReservation` int(11) NOT NULL,
  `IdMateriel` int(11) NOT NULL,
  `nbOrdis` int(11) NOT NULL,
  `internet` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `demandeur`
--

CREATE TABLE `demandeur` (
  `IdPoste` int(11) NOT NULL,
  `nomDemandeur` varchar(50) COLLATE utf8_bin NOT NULL,
  `IdService` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `disposition`
--

CREATE TABLE `disposition` (
  `Id` int(11) NOT NULL,
  `Libelle` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `disposition`
--

INSERT INTO `disposition` (`Id`, `Libelle`) VALUES
(1, 'Conférence'),
(2, 'Carré'),
(3, 'Tables rondes'),
(4, 'Buffet + quelques chaises');

-- --------------------------------------------------------

--
-- Structure de la table `fournir`
--

CREATE TABLE `fournir` (
  `Id` int(11) NOT NULL,
  `IdReservation` int(11) NOT NULL,
  `IdPresta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `materiel`
--

CREATE TABLE `materiel` (
  `Id` int(11) NOT NULL,
  `Libelle` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `materiel`
--

INSERT INTO `materiel` (`Id`, `Libelle`) VALUES
(1, 'Paperboard + stylo'),
(2, 'Ordinateur'),
(3, 'Vidéoprojecteur + écran'),
(4, 'Sono'),
(5, 'TV');

-- --------------------------------------------------------

--
-- Structure de la table `prestation`
--

CREATE TABLE `prestation` (
  `Id` int(11) NOT NULL,
  `Libelle` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `prestation`
--

INSERT INTO `prestation` (`Id`, `Libelle`) VALUES
(0, 'Rien'),
(1, 'Café'),
(2, 'Thé'),
(3, 'Eau'),
(4, 'Buffet');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `Id` int(11) NOT NULL,
  `nomIntervenant` varchar(50) COLLATE utf8_bin NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `typeReservation` varchar(50) COLLATE utf8_bin NOT NULL,
  `typeParticipants` varchar(50) COLLATE utf8_bin NOT NULL,
  `nbPers` int(11) NOT NULL,
  `estAnnonceEcran` tinyint(1) NOT NULL,
  `annonce` varchar(255) COLLATE utf8_bin NOT NULL,
  `validation` tinyint(1) NOT NULL,
  `repeatWeek` tinyint(1) NOT NULL,
  `validationPresta` tinyint(1) NOT NULL,
  `allDay` tinyint(1) NOT NULL,
  `IdDemandeur` int(11) NOT NULL,
  `IdDisposition` int(11) NOT NULL,
  `IdSalle` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

CREATE TABLE `salle` (
  `Id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `salle`
--

INSERT INTO `salle` (`Id`, `libelle`) VALUES
(1, 'Salle des mariages (les 3 salles)'),
(2, 'Salon d\'Honneur'),
(3, 'Salle des Commissions'),
(4, 'Salle du Conseil Municipal (les 2 salles)'),
(5, 'Salle du Conseil'),
(6, 'Salle Louise A. Boyd'),
(7, 'Salle des Fêtes'),
(8, 'Salle Rosalind Franklin'),
(9, 'Salle Bleue'),
(10, 'Bureau d\'Accueil'),
(11, 'Grande salle Ambroise Croizat'),
(12, ' Petite salle Ambroise Croizat'),
(13, 'Grenier du petit bois '),
(14, ' Château d’eau'),
(15, ' Marcel Lods'),
(16, ' Maison citoyenne Gadeau de Kerville'),
(17, ' Maison citoyenne Ferdinand Buissons'),
(18, ' Maison des Associations'),
(19, ' Rez-de-chaussée (CMS Bernard Lawday)'),
(20, ' Salle Jaune (CMS Bernard Lawday)'),
(21, 'Ecoles maternelle Jean Rostand'),
(22, 'École élémentaire publique Jean Rostand'),
(23, 'Ecoles Maternelle Jean Jaurès'),
(24, 'École Franklin Raspail'),
(25, 'Ecole Maternelle Jules Michelet');

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

CREATE TABLE `service` (
  `Id` int(11) NOT NULL,
  `libelleService` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `service`
--

INSERT INTO `service` (`Id`, `libelleService`) VALUES
(1, 'SSI'),
(2, 'RH'),
(13, 'POLICE'),
(14, 'CCAS'),
(16, 'RP'),
(17, 'CULTURE'),
(18, 'BIBLIOTHEQUE'),
(19, 'ADMINISTRATION GENERALE'),
(20, 'AAFP'),
(21, 'COMMUNICATION'),
(22, 'DIRECTION GENERALE'),
(23, 'FINANCES'),
(24, 'JEUNESSE'),
(25, 'APSM'),
(26, 'ECOLE DE MUSIQUE'),
(27, 'CABINET'),
(28, 'SYNDICATS'),
(29, 'SPORTS'),
(30, 'URBANISME'),
(31, 'VIVACITE'),
(32, 'SERVICES TECHNIQUES');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdReservation` (`IdReservation`),
  ADD KEY `IdMateriel` (`IdMateriel`);

--
-- Index pour la table `demandeur`
--
ALTER TABLE `demandeur`
  ADD PRIMARY KEY (`IdPoste`),
  ADD KEY `service.Id` (`IdService`);

--
-- Index pour la table `disposition`
--
ALTER TABLE `disposition`
  ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `fournir`
--
ALTER TABLE `fournir`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdReservation` (`IdReservation`),
  ADD KEY `IdPresta` (`IdPresta`);

--
-- Index pour la table `materiel`
--
ALTER TABLE `materiel`
  ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `prestation`
--
ALTER TABLE `prestation`
  ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdDemandeur` (`IdDemandeur`),
  ADD KEY `IdDisposition` (`IdDisposition`),
  ADD KEY `IdSalle` (`IdSalle`);

--
-- Index pour la table `salle`
--
ALTER TABLE `salle`
  ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `contenir`
--
ALTER TABLE `contenir`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT pour la table `demandeur`
--
ALTER TABLE `demandeur`
  MODIFY `IdPoste` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT pour la table `disposition`
--
ALTER TABLE `disposition`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `fournir`
--
ALTER TABLE `fournir`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `materiel`
--
ALTER TABLE `materiel`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `prestation`
--
ALTER TABLE `prestation`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=303;

--
-- AUTO_INCREMENT pour la table `salle`
--
ALTER TABLE `salle`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pour la table `service`
--
ALTER TABLE `service`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
