-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 21, 2014 at 02:22 PM
-- Server version: 5.5.35
-- PHP Version: 5.3.10-1ubuntu3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `libros`
--

-- --------------------------------------------------------

--
-- Table structure for table `libros`
--

CREATE TABLE IF NOT EXISTS `libros` (
  `idLibro` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(300) NOT NULL,
  `tipo` varchar(300) NOT NULL,
  `enlace` varchar(600) NOT NULL,
  `idOriginal` varchar(100) NOT NULL,
  PRIMARY KEY (`idLibro`),
  UNIQUE KEY `enlace` (`enlace`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `libros`
--

INSERT INTO `libros` (`idLibro`, `titulo`, `tipo`, `enlace`, `idOriginal`) VALUES
(7, 'Shakespeare - Otelo El moro de Venecia.pdf', 'application/pdf', 'https://doc-0k-68-docs.googleusercontent.com/docs/securesc/4gtti9mkjcjo8li0q3lj7rpqqqqjubs6/nm57e57mi8edqrrbd3o9dle1e329vhm0/1381996800000/18247297115040907517/18247297115040907517/0B1qpI3eiqFP2UGYwSEgxT1hlREU?h=16653014193614665626&e=download', '0B1qpI3eiqFP2UGYwSEgxT1hlREU'),
(9, 'Shakespeare - El rey lear.pdf', 'application/pdf', 'https://doc-0s-68-docs.googleusercontent.com/docs/securesc/4gtti9mkjcjo8li0q3lj7rpqqqqjubs6/no7r0t5e0n8lpkk77vask24r3bjag3l6/1381996800000/18247297115040907517/18247297115040907517/0B1qpI3eiqFP2Sm5BUTlLck1qeFU?h=16653014193614665626&e=download', '0B1qpI3eiqFP2Sm5BUTlLck1qeFU');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
