-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 24, 2025 at 05:31 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `GesNotes`
--

-- --------------------------------------------------------

--
-- Table structure for table `Credentials`
--

CREATE TABLE `Credentials` (
  `ID` int(11) NOT NULL,
  `Nom` tinytext NOT NULL,
  `Login` tinytext NOT NULL,
  `Password` tinytext NOT NULL,
  `Email` tinytext NOT NULL,
  `Categorie` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Credentials`
--

INSERT INTO `Credentials` (`ID`, `Nom`, `Login`, `Password`, `Email`, `Categorie`) VALUES
(1, 'Administrateur', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin@admin.net', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `Notes`
--

CREATE TABLE `Notes` (
  `ID` int(11) NOT NULL,
  `Nom` tinytext NOT NULL,
  `Informatique` float NOT NULL,
  `Maths` float NOT NULL,
  `Photo` text NOT NULL DEFAULT '\'./assets/blank-pfp.png\'',
  `isDELETED` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Notes`
--

INSERT INTO `Notes` (`ID`, `Nom`, `Informatique`, `Maths`, `Photo`, `isDELETED`) VALUES
(1, 'Anwar Mouabbir', 15, 14, '\'./assets/blank-pfp.png\'', 0),
(2, 'Aoulia Mountassir', 7, 5, 'uploads/img_1742831024_67e17db07729b.png', 0),
(3, 'test', 12, 16, 'uploads/img_1742831843_67e180e3c4440.png', 0),
(4, 'Graoui Abderrahmane', 14, 5, 'uploads/img_1742832720_67e184502506e.png', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Credentials`
--
ALTER TABLE `Credentials`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Notes`
--
ALTER TABLE `Notes`
  ADD PRIMARY KEY (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
