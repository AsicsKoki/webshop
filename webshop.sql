-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 09, 2013 at 03:21 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `webshop`
--
CREATE DATABASE IF NOT EXISTS `webshop` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `webshop`;

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE IF NOT EXISTS `banners` (
  `banner_id` int(11) NOT NULL AUTO_INCREMENT,
  `banner` varchar(250) NOT NULL,
  PRIMARY KEY (`banner_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`banner_id`, `banner`) VALUES
(1, 'side1.jpg'),
(2, 'side2.jpg'),
(3, 'side3.jpg'),
(4, 'side21.jpg'),
(5, 'side22.jpg'),
(6, 'side23.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE IF NOT EXISTS `colors` (
  `color_id` int(11) NOT NULL AUTO_INCREMENT,
  `color_name` varchar(50) NOT NULL,
  PRIMARY KEY (`color_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`color_id`, `color_name`) VALUES
(1, 'Red'),
(2, 'Green'),
(3, 'Blue'),
(4, 'Purple'),
(5, 'Black');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `posted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` varchar(500) NOT NULL,
  `rating` int(11) NOT NULL,
  `approved` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `product_id`, `user_id`, `posted_at`, `comment`, `rating`, `approved`) VALUES
(36, 1, 14, '2013-09-06 10:55:23', '12', 0, 0),
(37, 1, 14, '2013-09-06 11:10:25', '123', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `image_name` varchar(100) NOT NULL,
  `entity_id` varchar(100) NOT NULL,
  `entity_type` varchar(100) NOT NULL,
  `entity_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `image_name`, `entity_id`, `entity_type`, `entity_name`) VALUES
(6, 'technics-q-c-250-200-7.jpg', '1', 'product', ''),
(7, 'sports-q-c-250-200-3.jpg', '1', 'product', ''),
(9, 'side1.jpg', '16', 'user', 'mile');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `colorid` int(11) NOT NULL,
  `price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `description` text NOT NULL,
  `active` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `colorid`, `price`, `quantity`, `description`, `active`) VALUES
(1, 'Product1', 4, 45, 25, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus, repudiandae, cumque iusto laudantium animi itaque ullam error ipsam ex delectus architecto necessitatibus nostrum rem saepe nulla quod amet iure dignissimos.', 1),
(3, 'product3', 1, 62100, 14, ' nostrud exercitation ullamco laboris nisi ut al   \r\niquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncill', 1),
(4, 'Product4', 1, 322, 24, 'd oiwaoma iwmawvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv', 1),
(5, 'product2', 1, 40000, 4, ' nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `username` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(64) NOT NULL,
  `bio` varchar(400) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `first_name`, `last_name`, `username`, `email`, `password`, `bio`) VALUES
(14, 1, 'Konstantin', 'Velickovic', 'AsicsKoki', 'cpt.koki@gmail.com', './ucicd8m4f2U', ''),
(15, 1, 'Milos', 'Miloskovic', 'Misa', 'misa@misa.com', './DxNzAZYbwuw', ''),
(16, 0, 'Mile', 'Kitic', 'mile', 'mile@mile.com', './EmyFkGZ8byY', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'),
(17, 0, 'pera', 'pera', 'pera', 'pera@hotmail.com', './DxNzAZYbwuw', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
