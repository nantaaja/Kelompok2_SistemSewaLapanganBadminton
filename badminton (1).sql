-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2025 at 10:38 AM
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
-- Database: `badminton`
--

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `idJadwal` int(10) NOT NULL,
  `hari` varchar(10) NOT NULL,
  `jamMulai` time NOT NULL,
  `jamBerakhir` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lapangan`
--

CREATE TABLE `lapangan` (
  `idLapangan` int(10) NOT NULL,
  `namaLapangan` varchar(255) NOT NULL,
  `harga` int(10) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservasi`
--

CREATE TABLE `reservasi` (
  `idReservasi` int(10) NOT NULL,
  `idUser` int(10) NOT NULL,
  `idLapangan` int(10) NOT NULL,
  `idJadwal` int(10) NOT NULL,
  `tanggalBooking` date DEFAULT NULL,
  `durasi` int(2) DEFAULT NULL,
  `totalHarga` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `idUser` int(10) NOT NULL,
  `namaUser` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `noTelp` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUser`, `namaUser`, `password`, `noTelp`, `email`, `role`) VALUES
(1, '', '4297f44b13955235245b2497399d7a93', '+11111', 'asdasd@asdasd', 'Admin'),
(2, '', 'd41d8cd98f00b204e9800998ecf8427e', '+11111', 'asdasd@asdasd', 'Admin'),
(3, '', 'd41d8cd98f00b204e9800998ecf8427e', '+11111', 'asdasd@asdasd', 'Admin'),
(4, '', 'a8f5f167f44f4964e6c998dee827110c', '', 'aas@dads', 'asdad'),
(5, 'adasd', 'c7b4b1167548e4611bec35af8972a658', 'dffaa', 'sadasa@adsa', 'asdasas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`idJadwal`);

--
-- Indexes for table `lapangan`
--
ALTER TABLE `lapangan`
  ADD PRIMARY KEY (`idLapangan`);

--
-- Indexes for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD PRIMARY KEY (`idReservasi`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idLapangan` (`idLapangan`),
  ADD KEY `idJadwal` (`idJadwal`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `idJadwal` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lapangan`
--
ALTER TABLE `lapangan`
  MODIFY `idLapangan` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservasi`
--
ALTER TABLE `reservasi`
  MODIFY `idReservasi` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD CONSTRAINT `reservasi_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`),
  ADD CONSTRAINT `reservasi_ibfk_2` FOREIGN KEY (`idLapangan`) REFERENCES `lapangan` (`idLapangan`),
  ADD CONSTRAINT `reservasi_ibfk_3` FOREIGN KEY (`idJadwal`) REFERENCES `jadwal` (`idJadwal`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
