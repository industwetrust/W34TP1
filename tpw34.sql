-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 15, 2014 at 03:51 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tpw34`
--
CREATE DATABASE IF NOT EXISTS `tpw34` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `tpw34`;

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
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
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `CategoryID` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(60) NOT NULL,
  `Description` text,
  `ImageURL` varchar(2048) NOT NULL,
  PRIMARY KEY (`CategoryID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`CategoryID`, `CategoryName`, `Description`, `ImageURL`) VALUES
(1, 'Chocolat au lait', 'SucrÃ©e', 'MilkChocolate.jpg'),
(2, 'Chocolat noir', 'Riche en antioxidants', 'DarkChocolate.jpg'),
(3, 'Chocolat blanc', 'Chocolat blanc', 'WhiteChocolate.jpg'),
(4, 'MÃ©langes fruitÃ©es', 'MÃ©langes de fruits et chocolats', 'Fruit.jpg'),
(6, 'Rabais', 'Rabais', 'Discount.png');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
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
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`CustomerID`, `Username`, `Password`, `Phone`, `Email`, `FirstName`, `LastName`, `RegisterDate`) VALUES
(8, 'qwerty', 'qwerty', 'qwerty', NULL, 'qwerty', 'qwerty', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orderdetail`
--

CREATE TABLE IF NOT EXISTS `orderdetail` (
  `OrderID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  PRIMARY KEY (`OrderID`,`ProductID`),
  KEY `ProductID` (`ProductID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderdetail`
--

INSERT INTO `orderdetail` (`OrderID`, `ProductID`, `Quantity`) VALUES
(3, 2, 2),
(3, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `OrderID` int(11) NOT NULL AUTO_INCREMENT,
  `CustomerID` int(11) NOT NULL,
  `ShipperID` int(11) DEFAULT NULL,
  `BillingAddress` int(11) DEFAULT NULL,
  `ShippingAddress` int(11) DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `ShipDate` date DEFAULT NULL,
  PRIMARY KEY (`OrderID`),
  KEY `CustomerID` (`CustomerID`),
  KEY `ShipperID` (`ShipperID`),
  KEY `BillingAddress` (`BillingAddress`),
  KEY `ShippingAddress` (`ShippingAddress`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `CustomerID`, `ShipperID`, `BillingAddress`, `ShippingAddress`, `OrderDate`, `ShipDate`) VALUES
(3, 8, NULL, NULL, NULL, '2014-05-15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
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
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductID`, `ProductName`, `Price`, `UnitsInStock`, `Description`, `ImageURL`) VALUES
(1, 'Chocolat 100', '4.99', 2, '', 'Animal chocolate.jpg'),
(2, 'Chocolat 101', '3.99', 3, '', 'Chocolate dices.jpg'),
(3, 'Chocolat 102', '4.49', 6, '', 'ProductTest.jpg'),
(4, 'Chocolat 103', '4.99', 7, '', 'Rose chocolate.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `productscategories`
--

CREATE TABLE IF NOT EXISTS `productscategories` (
  `ProductID` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  PRIMARY KEY (`ProductID`,`CategoryID`),
  KEY `CategoryID` (`CategoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `productscategories`
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
-- Table structure for table `shippers`
--

CREATE TABLE IF NOT EXISTS `shippers` (
  `ShipperID` int(11) NOT NULL AUTO_INCREMENT,
  `ShipperName` varchar(100) NOT NULL,
  `ShipperPhone` varchar(15) DEFAULT NULL,
  `ShipperWebsite` varchar(2048) DEFAULT NULL,
  PRIMARY KEY (`ShipperID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customers` (`CustomerID`);

--
-- Constraints for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD CONSTRAINT `orderdetail_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`),
  ADD CONSTRAINT `orderdetail_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customers` (`CustomerID`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`ShipperID`) REFERENCES `shippers` (`ShipperID`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`BillingAddress`) REFERENCES `addresses` (`AddressID`),
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`ShippingAddress`) REFERENCES `addresses` (`AddressID`);

--
-- Constraints for table `productscategories`
--
ALTER TABLE `productscategories`
  ADD CONSTRAINT `productscategories_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`),
  ADD CONSTRAINT `productscategories_ibfk_2` FOREIGN KEY (`CategoryID`) REFERENCES `categories` (`CategoryID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
