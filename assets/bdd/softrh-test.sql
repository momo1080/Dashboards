-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Mar 28 Janvier 2020 à 15:48
-- Version du serveur :  10.3.21-MariaDB-1:10.3.21+maria~bionic-log
-- Version de PHP :  7.2.24-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `softrh`
--

-- --------------------------------------------------------

--
-- Structure de la table `Employe`
--

CREATE TABLE `Employe` (
  `id_Employe` int(11) NOT NULL,
  `utilisateur` varchar(20) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `admin` varchar(5) NOT NULL,
  `Service_id_service` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Employe`
--

INSERT INTO `Employe` (`id_Employe`, `utilisateur`, `mdp`, `admin`, `Service_id_service`) VALUES
(1, 'admintest', '1234', 'true', 1),
(2, 'person1', '*00A51F3F48415C7D4E8908980D443C29C69B60C9', 'false', 2);

-- --------------------------------------------------------

--
-- Structure de la table `Humeur`
--

CREATE TABLE `Humeur` (
  `id_humeur` int(11) NOT NULL,
  `nom_humeur` varchar(45) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Service`
--

CREATE TABLE `Service` (
  `id_service` int(11) NOT NULL,
  `nom_service` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Service`
--

INSERT INTO `Service` (`id_service`, `nom_service`) VALUES
(1, 'comptabilite'),
(2, 'juridique'),
(3, 'secretariat'),
(4, 'logistique');

-- --------------------------------------------------------

--
-- Structure de la table `Service_has_Humeur`
--

CREATE TABLE `Service_has_Humeur` (
  `Service_id_service` int(11) NOT NULL,
  `Humeur_id_humeur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Employe`
--
ALTER TABLE `Employe`
  ADD PRIMARY KEY (`id_Employe`),
  ADD UNIQUE KEY `utilisateur_UNIQUE` (`utilisateur`),
  ADD KEY `fk_Employe_Service_idx` (`Service_id_service`);

--
-- Index pour la table `Humeur`
--
ALTER TABLE `Humeur`
  ADD PRIMARY KEY (`id_humeur`);

--
-- Index pour la table `Service`
--
ALTER TABLE `Service`
  ADD PRIMARY KEY (`id_service`);

--
-- Index pour la table `Service_has_Humeur`
--
ALTER TABLE `Service_has_Humeur`
  ADD PRIMARY KEY (`Service_id_service`,`Humeur_id_humeur`),
  ADD KEY `fk_Service_has_Humeur_Humeur1_idx` (`Humeur_id_humeur`),
  ADD KEY `fk_Service_has_Humeur_Service1_idx` (`Service_id_service`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Employe`
--
ALTER TABLE `Employe`
  MODIFY `id_Employe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `Humeur`
--
ALTER TABLE `Humeur`
  MODIFY `id_humeur` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Service`
--
ALTER TABLE `Service`
  MODIFY `id_service` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Employe`
--
ALTER TABLE `Employe`
  ADD CONSTRAINT `fk_Employe_Service` FOREIGN KEY (`Service_id_service`) REFERENCES `Service` (`id_service`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `Service_has_Humeur`
--
ALTER TABLE `Service_has_Humeur`
  ADD CONSTRAINT `fk_Service_has_Humeur_Humeur1` FOREIGN KEY (`Humeur_id_humeur`) REFERENCES `Humeur` (`id_humeur`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Service_has_Humeur_Service1` FOREIGN KEY (`Service_id_service`) REFERENCES `Service` (`id_service`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
