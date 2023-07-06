-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour restaurant
CREATE DATABASE IF NOT EXISTS `restaurant` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `restaurant`;

-- Listage de la structure de table restaurant. adresse
CREATE TABLE IF NOT EXISTS `adresse` (
  `id_adresse` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `cp` int NOT NULL,
  `ville` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `telephone` int NOT NULL,
  `defaut` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_adresse`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `FK__users` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table restaurant.adresse : ~2 rows (environ)
INSERT INTO `adresse` (`id_adresse`, `id_user`, `nom`, `prenom`, `adresse`, `cp`, `ville`, `telephone`, `defaut`) VALUES
	(1, 12, 'Br', 'Fr', '13 rue glace', 67000, 'Strasbourg', 606060606, 1),
	(2, 12, 'fezf', 'fezf', '14 rue test', 67000, 'Stra', 505050505, 0);

-- Listage de la structure de table restaurant. carte
CREATE TABLE IF NOT EXISTS `carte` (
  `id_produit` int NOT NULL AUTO_INCREMENT,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `prix` float NOT NULL,
  `section` varchar(50) NOT NULL,
  PRIMARY KEY (`id_produit`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table restaurant.carte : ~22 rows (environ)
INSERT INTO `carte` (`id_produit`, `description`, `prix`, `section`) VALUES
	(1, 'FORMULE Entr&eacute;e + Plat ou Plat + Dessert', 19, 'dejeuner'),
	(2, 'FORMULE Entr&eacute;e + Plat ou Plat + Dessert', 29, 'soir'),
	(3, 'La Burratina Cr&eacute;meuse des Pouilles, Grenade et Sel Noir Fum&eacute;', 11, 'entree'),
	(4, 'Le Magret de Canard L&eacute;gendaire du Sud-Ouest, Napp&eacute; d&#039;une Sauce &agrave; l&#039;Orange Accompagn&eacute; de son Gratin de Duo de Pommes de Terre', 25, 'plat'),
	(5, 'Le D&eacute;lice Dor&eacute; : Brioche fa&ccedil;on Pain Perdu Accompagn&eacute; de son Caramel Beurre Sal&eacute; et de sa Cr&egrave;me Anglaise', 10, 'dessert'),
	(6, 'Littre Vittel ou Badoit', 4, 'boisson'),
	(7, 'Le Saumon Gravlax Maison &agrave; l&#039;Aneth, une V&eacute;ritable D&eacute;lice', 13, 'entree'),
	(9, 'Le Gratin de Ravioles du Dauphin&eacute; Label Rouge au Parmesan A.O.P., un R&eacute;gal Gratifi&eacute;', 12, 'entree'),
	(10, 'Le Tataki de B&oelig;uf Angus, Fa&ccedil;on &quot;Tigre qui Pleure&quot;, une Merveille Absolue', 13, 'entree'),
	(11, 'Le Burger C&eacute;l&egrave;bre des &Eacute;picuriens Pain brioch&eacute; BIO, Steak Angus 150g, Double Cheddar affin&eacute; 18 mois, oignons confits, Poitrine Fum&eacute;e et Sauce Secr&egrave;te', 24, 'plat'),
	(12, 'Le Dos de Cabillaud Charismatique au Curry et Lait de Coco Accompagn&eacute; d&#039;un Duo de Riz Sauvage et Basmati', 24, 'plat'),
	(13, 'Le C&oelig;ur de Rumsteack Angus d&#039;Argentine Merveilleux (250g) Accompagn&eacute; d&#039;un Gratin Dauphinois Maison et de sa Sauce Gorgonzola', 28, 'plat'),
	(14, 'Le Tartare de Thon Inoubliable &agrave; la Tha&iuml;landaise Servi avec ses Frites de Patates Douces', 25, 'plat'),
	(15, 'Le Tartare de B&oelig;uf &agrave; l&#039;Italienne Savoureux Accompagn&eacute; de ses Frites Maison', 21, 'plat'),
	(16, 'Les Lasagnes V&eacute;g&eacute;tariennes &agrave; la Ricotta et aux &Eacute;pinards Savour&eacute;es avec D&eacute;lice', 20, 'plat'),
	(17, 'Le Chocolat Fondant R&eacute;confortant de P&eacute;p&eacute; Un H&eacute;ritage de Douceur', 10, 'dessert'),
	(18, 'La Vanille Bourbon en Caresse : Cr&egrave;me Br&ucirc;l&eacute;e Un Plaisir Classique &agrave; la Vanille', 9, 'dessert'),
	(19, 'Le Tiramisu Gourmand du Chef : Sp&eacute;culoos et Caramel Beurre Sal&eacute; Une Tentation Italienne Sublim&eacute;e', 9, 'dessert'),
	(20, 'Le Caf&eacute; des Rupins, un Gourmand Absolu Accompagn&eacute; d&#039;une S&eacute;lection de Mignardises', 11, 'dessert'),
	(21, 'Cocktails', 8, 'boisson'),
	(22, 'Soft (Coca-Cola, Sprite, Red Bull, Ice Tea, Jus d&rsquo;orange, Limonade)', 3, 'boisson'),
	(23, 'Caf&eacute;', 2, 'boisson');

-- Listage de la structure de table restaurant. commande
CREATE TABLE IF NOT EXISTS `commande` (
  `id_commande` int NOT NULL AUTO_INCREMENT,
  `id_users` int NOT NULL,
  `statut` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_commande`),
  KEY `id_users` (`id_users`),
  CONSTRAINT `FK_commande_users` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table restaurant.commande : ~5 rows (environ)
INSERT INTO `commande` (`id_commande`, `id_users`, `statut`) VALUES
	(1, 17, 1),
	(2, 17, 1),
	(3, 12, 1),
	(4, 17, 1),
	(26, 17, 0);

-- Listage de la structure de table restaurant. horaires
CREATE TABLE IF NOT EXISTS `horaires` (
  `id_horaire` int NOT NULL AUTO_INCREMENT,
  `jour` varchar(50) NOT NULL,
  `heures` varchar(50) NOT NULL,
  PRIMARY KEY (`id_horaire`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table restaurant.horaires : ~3 rows (environ)
INSERT INTO `horaires` (`id_horaire`, `jour`, `heures`) VALUES
	(1, 'LUN - VEN', '12h00 - 15h00 . 18h30 - 22h30'),
	(2, 'SAMEDI', '12h00 - 15h00 . 18h30 - 23h30'),
	(5, 'DIMANCHE', '12h00 - 15h00 . 18h30 - 22h30');

-- Listage de la structure de table restaurant. nb_table
CREATE TABLE IF NOT EXISTS `nb_table` (
  `nb_table` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table restaurant.nb_table : ~1 rows (environ)
INSERT INTO `nb_table` (`nb_table`) VALUES
	(20);

-- Listage de la structure de table restaurant. produit_commande
CREATE TABLE IF NOT EXISTS `produit_commande` (
  `id_commande` int NOT NULL,
  `id_produit` int NOT NULL,
  `quantite` int NOT NULL,
  KEY `id_commande` (`id_commande`),
  CONSTRAINT `FK_produit_commande_commande` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id_commande`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table restaurant.produit_commande : ~1 rows (environ)
INSERT INTO `produit_commande` (`id_commande`, `id_produit`, `quantite`) VALUES
	(26, 4, 1);

-- Listage de la structure de table restaurant. reservation
CREATE TABLE IF NOT EXISTS `reservation` (
  `id_reservation` int NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `nombre` int NOT NULL,
  `creneau` varchar(50) NOT NULL,
  `civilite` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `telephone` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `statut` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_reservation`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table restaurant.reservation : ~0 rows (environ)

-- Listage de la structure de table restaurant. table_reserve
CREATE TABLE IF NOT EXISTS `table_reserve` (
  `nb_table` float NOT NULL DEFAULT '0',
  `date` date NOT NULL,
  `creneau` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table restaurant.table_reserve : ~0 rows (environ)

-- Listage de la structure de table restaurant. users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(80) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `admin` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `username` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- Listage des données de la table restaurant.users : ~2 rows (environ)
INSERT INTO `users` (`id`, `email`, `password`, `nom`, `prenom`, `admin`) VALUES
	(12, 'admin@snoux.fr', '$2y$10$4.EEEHx9QbHJwAVpexME1OF.tvZzFg1DLtvt.R5ppiEhZV5oWjQiW', 'Snoux', 'Snoux', 1),
	(17, 'test@gmail.com', '$2y$10$E41ntixa3JjrLtlcurMTou9TICxZ2YKieA3iQoevj7VwepI1JcYD6', 'test', 'test', 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
