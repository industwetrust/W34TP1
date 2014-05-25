-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Sam 24 Mai 2014 à 16:47
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

use mysql;
drop database tpw34;
create database tpw34;
use tpw34;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `tpw34`
--

-- --------------------------------------------------------

--
-- Structure de la table `addresses`
--

CREATE TABLE IF NOT EXISTS `addresses` (
  `AddressID` int(11) NOT NULL AUTO_INCREMENT,
  `CustomerID` int(11) NOT NULL,
  `Country` varchar(50) NOT NULL,
  `Province` varchar(50) NOT NULL,
  `City` varchar(50) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `IsDefaultShipping` tinyint(1) DEFAULT '0',
  `IsDefaultBilling` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`AddressID`),
  KEY `CustomerID` (`CustomerID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `CategoryID` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(60) NOT NULL,
  `Description` text,
  `ImageURL` varchar(2048) NOT NULL,
  PRIMARY KEY (`CategoryID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`CategoryID`, `CategoryName`, `Description`, `ImageURL`) VALUES
(1, 'Chocolat au lait', 'SucrÃ©e', 'MilkChocolate.jpg'),
(2, 'Chocolat noir', 'Riche en antioxidants', 'DarkChocolate.jpg'),
(3, 'Chocolat blanc', 'Chocolat blanc', 'WhiteChocolate.jpg'),
(4, 'MÃ©langes fruitÃ©es', 'MÃ©langes de fruits et chocolats', 'Fruit.jpg'),
(6, 'Rabais', 'Rabais', 'Discount.png');

-- --------------------------------------------------------

--
-- Structure de la table `Admins`
--

CREATE TABLE IF NOT EXISTS `Admins` (
  `nom` varchar(60) NOT NULL,
  `User` varchar(60) NOT NULL,
  `Password` varchar(60) NOT NULL,
  PRIMARY KEY (`User`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Admins`
--

INSERT INTO `Admins` (`nom`, `User`, `Password`) VALUES
('Pablo Aguilar-Lliguin', '7e4b64eb65e34fdfad79e623c44abd94', 'c378985d629e99a4e86213db0cd5e70d');

-- --------------------------------------------------------

--
-- Structure de la table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `CustomerID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(60) NOT NULL,
  `Password` varchar(60) NOT NULL,
  `Phone` varchar(15) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `FirstName` varchar(60) DEFAULT NULL,
  `LastName` varchar(60) DEFAULT NULL,
  `RegisterDate` date DEFAULT NULL,
  PRIMARY KEY (`CustomerID`),
  UNIQUE KEY `Username` (`Username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `customers`
--

INSERT INTO `customers` (`CustomerID`, `Username`, `Password`, `Phone`, `Email`, `FirstName`, `LastName`, `RegisterDate`) VALUES
(8, 'qwerty', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'qwerty', NULL, 'qwerty', 'qwerty', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `orderdetail`
--

CREATE TABLE IF NOT EXISTS `orderdetail` (
  `OrderID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  PRIMARY KEY (`OrderID`,`ProductID`),
  KEY `ProductID` (`ProductID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `orderdetail`
--

INSERT INTO `orderdetail` (`OrderID`, `ProductID`, `Quantity`) VALUES
(3, 2, 2),
(3, 4, 1),
(4, 1, 4),
(4, 3, 5),
(4, 4, 10),
(5, 1, 5),
(5, 3, 2);

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `OrderID` int(11) NOT NULL AUTO_INCREMENT,
  `Shipped` tinyint(1) DEFAULT '0',
  `CustomerID` int(11) NOT NULL,
  `BillingAddress` int(11) DEFAULT NULL,
  `ShippingAddress` int(11) DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `ShipDate` date DEFAULT NULL,
  PRIMARY KEY (`OrderID`),
  KEY `CustomerID` (`CustomerID`),
  KEY `BillingAddress` (`BillingAddress`),
  KEY `ShippingAddress` (`ShippingAddress`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `orders`
--

INSERT INTO `orders` (`OrderID`, `Shipped`, `CustomerID`, `BillingAddress`, `ShippingAddress`, `OrderDate`, `ShipDate`) VALUES
(3, 0, 8, NULL, NULL, '2014-05-15', '2014-05-24'),
(4, 0, 8, NULL, NULL, '2014-05-23', '2014-05-24'),
(5, 0, 8, NULL, NULL, '2014-05-23', '2014-05-24');

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `ProductID` int(11) NOT NULL AUTO_INCREMENT,
  `ProductName` varchar(60) NOT NULL,
  `Price` decimal(9,2) DEFAULT NULL,
  `UnitsInStock` int(11) DEFAULT NULL,
  `Description` varchar(2024) DEFAULT NULL,
  `ImageURL` varchar(2014) DEFAULT NULL,
  PRIMARY KEY (`ProductID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `products`
--

INSERT INTO `products` (`ProductID`, `ProductName`, `Price`, `UnitsInStock`, `Description`, `ImageURL`) VALUES
(1, 'Chocolat 100', '4.99', 2, '', 'Animal chocolate.jpg'),
(2, 'Chocolat 101', '3.99', 3, '', 'Chocolate dices.jpg'),
(3, 'Chocolat 102', '4.49', 6, '', 'ProductTest.jpg'),
(4, 'Chocolat 103', '4.99', 7, '', 'Rose chocolate.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `productscategories`
--

CREATE TABLE IF NOT EXISTS `productscategories` (
  `ProductID` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  PRIMARY KEY (`ProductID`,`CategoryID`),
  KEY `CategoryID` (`CategoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `productscategories`
--

INSERT INTO `productscategories` (`ProductID`, `CategoryID`) VALUES
(1, 1),
(4, 1),
(3, 2),
(2, 3),
(4, 3),
(1, 4),
(2, 4),
(4, 4),
(1, 6),
(2, 6);

-- --------------------------------------------------------

--
-- Structure de la table `shippers`
--

CREATE TABLE IF NOT EXISTS `shippers` (
  `ShipperID` int(11) NOT NULL AUTO_INCREMENT,
  `ShipperName` varchar(100) NOT NULL,
  `ShipperPhone` varchar(15) DEFAULT NULL,
  `ShipperWebsite` varchar(2048) DEFAULT NULL,
  PRIMARY KEY (`ShipperID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customers` (`CustomerID`);

--
-- Contraintes pour la table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD CONSTRAINT `orderdetail_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`),
  ADD CONSTRAINT `orderdetail_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`);

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customers` (`CustomerID`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`BillingAddress`) REFERENCES `addresses` (`AddressID`),
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`ShippingAddress`) REFERENCES `addresses` (`AddressID`);

--
-- Contraintes pour la table `productscategories`
--
ALTER TABLE `productscategories`
  ADD CONSTRAINT `productscategories_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`),
  ADD CONSTRAINT `productscategories_ibfk_2` FOREIGN KEY (`CategoryID`) REFERENCES `categories` (`CategoryID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
