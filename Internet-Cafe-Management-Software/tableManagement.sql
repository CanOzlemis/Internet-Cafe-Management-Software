-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 14, 2019 at 09:42 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tableManagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `end_day_report`
--

DROP TABLE IF EXISTS `end_day_report`;
CREATE TABLE IF NOT EXISTS `end_day_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tarih` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `pepsi` int(11) DEFAULT NULL,
  `seven_up` int(11) DEFAULT NULL,
  `7gun` int(11) DEFAULT NULL,
  `ice_tea` int(11) DEFAULT NULL,
  `meyve_suyu` int(11) DEFAULT NULL,
  `cay` int(11) DEFAULT NULL,
  `nescafe` int(11) DEFAULT NULL,
  `soda` int(11) DEFAULT NULL,
  `meyveli_soda` int(11) DEFAULT NULL,
  `su` int(11) DEFAULT NULL,
  `turk_kahvesi` int(11) DEFAULT NULL,
  `bitki_cayi` int(11) DEFAULT NULL,
  `sicak_cikolata` int(11) DEFAULT NULL,
  `enerji_icecegi` int(11) DEFAULT NULL,
  `cips` int(11) DEFAULT NULL,
  `jelibon` int(11) DEFAULT NULL,
  `lolipop` int(11) DEFAULT NULL,
  `toplam_fiyat` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `end_day_report`
--

INSERT INTO `end_day_report` (`id`, `tarih`, `pepsi`, `seven_up`, `7gun`, `ice_tea`, `meyve_suyu`, `cay`, `nescafe`, `soda`, `meyveli_soda`, `su`, `turk_kahvesi`, `bitki_cayi`, `sicak_cikolata`, `enerji_icecegi`, `cips`, `jelibon`, `lolipop`, `toplam_fiyat`) VALUES
(28, '2019-02-27 09:18:44', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, NULL, NULL, NULL, NULL),
(29, '2019-02-27 20:24:28', 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 28, NULL, NULL, NULL, NULL),
(30, '2019-03-13 18:24:30', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 16.5);

-- --------------------------------------------------------

--
-- Table structure for table `prices`
--

DROP TABLE IF EXISTS `prices`;
CREATE TABLE IF NOT EXISTS `prices` (
  `ps_12` int(11) DEFAULT NULL,
  `ps_123` int(11) DEFAULT NULL,
  `ps_1234` int(11) DEFAULT NULL,
  `vr` int(11) DEFAULT NULL,
  `table_tennis` int(11) DEFAULT NULL,
  `billard` int(11) DEFAULT NULL,
  `guitar_hero` int(11) DEFAULT NULL,
  `car_simulation` int(11) DEFAULT NULL,
  `pepsi` int(11) DEFAULT NULL,
  `seven_up` int(11) DEFAULT NULL,
  `seven_gun` int(11) DEFAULT NULL,
  `ice_tea` int(11) DEFAULT NULL,
  `fruit_juice` int(11) DEFAULT NULL,
  `tea` int(11) DEFAULT NULL,
  `nescafe` int(11) DEFAULT NULL,
  `soda` int(11) DEFAULT NULL,
  `fruit_soda` int(11) DEFAULT NULL,
  `water` float DEFAULT NULL,
  `turkish_coffee` int(11) DEFAULT NULL,
  `herbal` int(11) DEFAULT NULL,
  `hot_chocolate` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prices`
--

INSERT INTO `prices` (`ps_12`, `ps_123`, `ps_1234`, `vr`, `table_tennis`, `billard`, `guitar_hero`, `car_simulation`, `pepsi`, `seven_up`, `seven_gun`, `ice_tea`, `fruit_juice`, `tea`, `nescafe`, `soda`, `fruit_soda`, `water`, `turkish_coffee`, `herbal`, `hot_chocolate`) VALUES
(10, 15, 20, 20, 20, 40, 30, 15, 5, 5, 5, 5, 5, 3, 5, 3, 4, 2.5, 4, 4, 6);

-- --------------------------------------------------------

--
-- Table structure for table `sales_updated`
--

DROP TABLE IF EXISTS `sales_updated`;
CREATE TABLE IF NOT EXISTS `sales_updated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `urunler` varchar(50) DEFAULT NULL,
  `prices` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_updated`
--

INSERT INTO `sales_updated` (`id`, `urunler`, `prices`) VALUES
(1, 'Pepsi', 0),
(2, '7Up', 0),
(3, '7Gun', 0),
(4, 'ice_tea', 0),
(5, 'fruit_juice', 0),
(6, 'tea', 0),
(7, 'nescafe', 0),
(8, 'soda', 0),
(9, 'fruit_soda', 0),
(10, 'water', 0),
(11, 'turksih_coffee', 0),
(12, 'herbal', 0),
(13, 'hot_chocolate', 0),
(14, 'energy_drink', 0),
(15, 'chips', 0),
(16, 'jelly', 0),
(17, 'lolipop', 0),
(18, 'total_amount', 0);

-- --------------------------------------------------------

--
-- Table structure for table `urunler_tbl`
--

DROP TABLE IF EXISTS `urunler_tbl`;
CREATE TABLE IF NOT EXISTS `urunler_tbl` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `urunler` varchar(30) NOT NULL,
  `prices` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `urunler_tbl`
--

INSERT INTO `urunler_tbl` (`id`, `urunler`, `prices`) VALUES
(1, 'Pepsi', 5),
(2, '7Up', 5),
(3, '7Gun', 5),
(4, 'Ice Tea', 5),
(5, 'Meyve Suyu', 5),
(6, 'Cay', 3),
(7, 'Nescafe', 5),
(8, 'Soda', 3),
(9, 'Meyveli Soda', 4),
(10, 'Su', 2.5),
(11, 'Turk Kahvesi', 4),
(12, 'Bitki Cayi', 4),
(13, 'Sicak Cikolata', 6),
(14, 'Enerji icecegi', 6),
(15, 'Cips', 5),
(16, 'Jelibon', 4),
(17, 'Lolipop', 1.5);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
