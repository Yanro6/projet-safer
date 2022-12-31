-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--

-- Généré le : mar. 29 nov. 2022 à 15:24
-- Version du serveur : 10.3.31-MariaDB-1:10.3.31+maria~buster-log
-- Version de PHP : 7.3.31-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;



-- --------------------------------------------------------

--
-- Structure de la table `SAFER`
--

CREATE TABLE `SAFER` (
  `Référence` varchar(15) NOT NULL,
  `Intitulé` varchar(200) NOT NULL,
  `Descriptif` varchar(200) NOT NULL,
  `Localisation` varchar(10) NOT NULL,
  `Surface` varchar(10) NOT NULL,
  `Prix` varchar(15) NOT NULL,
  `Type` varchar(20) NOT NULL,
  `Catégorie` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `SAFER`
--

INSERT INTO `SAFER` (`Référence`, `Intitulé`, `Descriptif`, `Localisation`, `Surface`, `Prix`, `Type`, `Catégorie`) VALUES
('17.03.017', 'Activit?s Equestres, Apiculture, Chasse,', 'Propri?t? Charente-Maritime', '17200', '17Ha', '330000', 'Vente', 'Exploitations'),
('19.07.118', 'FERME 100% HERBAGERE/ ELEVAGE LAITIER', 'Situ?e ? l\'or?e d\'un bourg, ? 10 minutes des services et commerces.', '35200', '34Ha', '950', 'Location', 'Exploitations'),
('23.16.104', 'Propri?t? Creuse', 'Dans un hameau ? moins de 10 minutes d\'un bourg avec services et commerces, et d\'un village ayant un int?r?t touristique sur les routes de St-Jacques-de-Compostelle.', '23320', '1Ha55', '860', 'Location', 'Batiments'),
('30VI9700', 'Propri?t? Gard', 'Ensemble immobilier proche d\'un plan d\'eau am?nag?', '34290', '29Ha', '2000', 'Location', 'Exploitations'),
('313453DR', 'Id?al soci?t? de chasse', 'Terrain bois? class? ONF', '22700', '35Ha', '120000', 'Vente', 'Bois'),
('344334UJ', 'Sapini?re', 'Sapini?re en cours de bail, cherche reprise', '35200', '1,8Ha', '800', 'Location', 'Bois'),
('345E7EG', 'Bois sur pied', 'Diverses essences sur place', '29510', '6Ha', '30000', 'Vente', 'Bois'),
('34AG10897', 'Tourisme rural-h?bergement', 'Au nord de l\'H?rault, proche des axes routiers et ? 45 minutes de Montpellier', '34070', '1Ha90', '1 490 000', 'Vente', 'Batiments'),
('34VI6979', 'Propri?t? viticole et sa cave', 'Au c?ur de l\'appellation Saint-Chinian', '34280', '30Ha', '1 500 000', 'Vente', 'Batiments'),
('38TB22187', 'Vallons du Voironnais', '13 Ha de terrain', '38500', '13Ha', '2000', 'Location', 'Terrain agricole'),
('43LM220118', 'Prairies en pays glazik', 'Usage petits animaux type caprins', '29510', '1ha22', '15000', 'Vente', 'Prairie'),
('44 22 AN 08', 'B?timents avicoles ? transmettre', 'Site avicole ? transmettre sur la commune de Nort-sur-Erdre, au nord de Nantes.', '44220', '2Ha', '200000', 'Vente', 'Batiments'),
('47.06.098', 'PRET A USAGE sur 95 ha - PLAINE DES VOSGES ', ' A 5 min de Villeneuve-sur-Lot', '47300', '14Ha', '11000', 'Location', 'Terrain agricole'),
('48EL11345', 'Propri?t? Loz?re', 'Ensemble b?ti avec environ 1ha55', '48370', '1Ha55', '700', 'Location', 'Batiments'),
('48RE11201', 'Situ? ? 15 minutes de Mende', 'id?al pour polyculture sur 14 ha', '30430', '10Ha', '1300', 'Location', 'Terrain agricole'),
('55VS', 'Propri?t? Meuse', 'FERME DE COURUPT : Secteur Sainte-Menehould / Clermont-en-Argonne / Revigny', '88340', '59Ha', 'Nous consulter', 'Location', 'Exploitations'),
('5667DB', 'Ancienne ferme ?questre en ruine', 'Terrains actuellement lou?s', '29510', '12Ha', '156000', 'Vente', 'Terrain agricole'),
('64.02.59', 'Productions v?g?tales', 'La parcelle se situe dans le B?arn sur la commune de LAGOR.', '64150', '2Ha', '7700', 'Vente', 'Prairie'),
('64.03.60', 'Propri?t? situ?e dans un secteur vallonn?', 'Propri?t? Pyr?n?es-Atlantiques', '23500', '6Ha', '650', 'Location', 'Batiments'),
('65.23.876', 'Terrain class? T4', 'clotur? et partiellement bois?', '56500', '1,2Ha', '500', 'Location', 'Bois'),
('7629CA', 'Prairies sur les plateaux', 'Parcelle de terre labourable d\'environ 2 ha', '81090', '76Ha', '400000', 'Vente', 'Prairie'),
('765DN', 'Prairies orient?es nord ouest', 'Lot d\'un seul tenant', '56500', '11Ha', '113000', 'Vente', 'Prairie'),
('76RZDC', 'Terrain proche cours d\'eau', 'Non accessible par la route, uniquement chemin d\'exploitation', '35200', '5,5Ha', '3000', 'Location', 'Prairie'),
('81EL11100', 'Secteur du S?gala-Viaur', 'les secteurs les plus en pente sont empi?r?s', '12200', '54Ha', '400000', 'Vente', 'Bois'),
('88 FB ', 'Vittel Dombrot : Ouest vosgien, secteur de VITTEL', 'Terrains d\'environ 6,5 ha', '88170', '6,5Ha', 'Nous consulter', 'Vente', 'Terrain agricole'),
('9875RDC', 'Terrain avec abri', 'Pour propri?taire ?quin', '44110', '1,2Ha', '1200', 'Location', 'Prairie'),
('AA 72 22 0088 R', 'Exploitation Agricole sp?cialis?e en polyculture ?levage', 'Exploitation situ?e dans le Sud Est de La Sarthe, entre la commune d\'Ecommoy (72220) et Sarc? (72327)', '72220', '87Ha', 'a', 'Vente', 'Exploitations'),
('MQ14170356 ', 'Propri?t? Calvados', 'JFD : Noue de Sienne (14)', '14380', '17Ha', '173 440', 'Vente', 'Exploitations'),
('QDSGF56', 'Bois domainial', 'Bois accessible avec sentiers', '44110', '32Ha', '12000', 'Location', 'Bois'),
('Z34.345.45', 'L?g?rement en Pente', 'Id?al paturage moutons', '22700', '3,4Ha', '2400', 'Location', 'Prairie');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `SAFER`
--
ALTER TABLE `SAFER`
  ADD PRIMARY KEY (`Référence`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
