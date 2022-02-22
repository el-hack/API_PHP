-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mar. 22 fév. 2022 à 18:34
-- Version du serveur :  5.7.34
-- Version de PHP : 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `abonnement`
--

-- --------------------------------------------------------

--
-- Structure de la table `abonner`
--

CREATE TABLE `abonner` (
  `idClient` int(11) NOT NULL,
  `idTypeAbo` int(11) NOT NULL,
  `dateAbonnement` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `idClient` int(11) NOT NULL,
  `nomClient` varchar(20) DEFAULT NULL,
  `prenomClien` varchar(30) DEFAULT NULL,
  `adresse` varchar(30) DEFAULT NULL,
  `statut` varchar(10) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`idClient`, `nomClient`, `prenomClien`, `adresse`, `statut`, `date`) VALUES
(31, 'Koffi', 'Awa ', 'yopougon', 'actif', '2022-02-21 19:07:42'),
(32, 'kamara', 'el adj', 'yop', '1', '2022-02-22 17:22:59'),
(33, 'koff', 'el adj', 'yop', '1', '2022-02-22 17:25:27'),
(34, 'koff', 'eli', 'yop', '1', '2022-02-22 17:25:54'),
(35, 'kouame', 'icubczd', 'toto', '1', '2022-02-22 18:01:20');

-- --------------------------------------------------------

--
-- Structure de la table `typeAbo`
--

CREATE TABLE `typeAbo` (
  `idTypeAbo` int(11) NOT NULL,
  `libelleAbonnement` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `abonner`
--
ALTER TABLE `abonner`
  ADD PRIMARY KEY (`idClient`,`idTypeAbo`),
  ADD KEY `idClient` (`idClient`,`idTypeAbo`),
  ADD KEY `fk_typeabo` (`idTypeAbo`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`idClient`);

--
-- Index pour la table `typeAbo`
--
ALTER TABLE `typeAbo`
  ADD PRIMARY KEY (`idTypeAbo`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `idClient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `typeAbo`
--
ALTER TABLE `typeAbo`
  MODIFY `idTypeAbo` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `abonner`
--
ALTER TABLE `abonner`
  ADD CONSTRAINT `fk_client` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_typeabo` FOREIGN KEY (`idTypeAbo`) REFERENCES `typeAbo` (`idTypeAbo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
