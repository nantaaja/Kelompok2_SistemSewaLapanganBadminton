-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2025 at 09:14 AM
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

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `FN_GetPendapatanBulanan` (`bulan_input` INT, `tahun_input` INT) RETURNS DECIMAL(10,2) READS SQL DATA BEGIN
    DECLARE total_pendapatan DECIMAL(10,2);

    SELECT SUM(total_harga)
    INTO total_pendapatan
    FROM reservasi
    WHERE MONTH(tanggal_booking) = bulan_input
      AND YEAR(tanggal_booking) = tahun_input
      AND status_reservasi IN ('confirmed', 'completed');

    IF total_pendapatan IS NULL THEN
        SET total_pendapatan = 0.00;
    END IF;

    RETURN total_pendapatan;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `FN_GetPendapatanHarian` (`tanggal_input` DATE) RETURNS DECIMAL(10,2) READS SQL DATA BEGIN
    DECLARE total_pendapatan DECIMAL(10,2);

    SELECT SUM(total_harga)
    INTO total_pendapatan
    FROM reservasi
    WHERE tanggal_booking = tanggal_input AND status_reservasi = 'confirmed';

    -- Jika tidak ada reservasi yang dikonfirmasi, kembalikan 0
    IF total_pendapatan IS NULL THEN
        SET total_pendapatan = 0.00;
    END IF;

    RETURN total_pendapatan;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(10) NOT NULL,
  `id_lapangan` int(10) NOT NULL,
  `hari` varchar(10) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_berakhir` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `id_lapangan`, `hari`, `jam_mulai`, `jam_berakhir`) VALUES
(16, 101, 'Senin', '08:00:00', '09:00:00'),
(17, 101, 'Senin', '09:00:00', '10:00:00'),
(18, 102, 'Selasa', '10:00:00', '11:00:00'),
(19, 102, 'Rabu', '14:00:00', '15:00:00'),
(20, 103, 'Kamis', '18:00:00', '19:00:00'),
(21, 103, 'Jumat', '19:00:00', '20:00:00'),
(22, 101, 'Sabtu', '07:00:00', '08:00:00'),
(23, 102, 'Sabtu', '08:00:00', '09:00:00'),
(24, 103, 'Minggu', '16:00:00', '17:00:00'),
(25, 101, 'Minggu', '17:00:00', '18:00:00'),
(27, 101, 'Senin', '18:00:00', '19:00:00'),
(28, 103, 'Rabu', '20:00:00', '21:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `lapangan`
--

CREATE TABLE `lapangan` (
  `id_lapangan` int(10) NOT NULL,
  `nama_lapangan` varchar(255) NOT NULL,
  `harga` int(10) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'Tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lapangan`
--

INSERT INTO `lapangan` (`id_lapangan`, `nama_lapangan`, `harga`, `status`) VALUES
(101, 'Lapangan Garuda', 50000, 'Tersedia'),
(102, 'Lapangan Elang', 55000, 'Tersedia'),
(103, 'Lapangan Rajawali', 60000, 'Tersedia'),
(105, 'Lapangan Rajawali', 50000, 'Tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `reservasi`
--

CREATE TABLE `reservasi` (
  `id_reservasi` int(10) NOT NULL,
  `id_user` int(10) NOT NULL,
  `id_lapangan` int(10) NOT NULL,
  `id_jadwal` int(10) NOT NULL,
  `tanggal_booking` date DEFAULT NULL,
  `durasi` int(2) DEFAULT NULL,
  `total_harga` decimal(10,2) DEFAULT NULL,
  `status_reservasi` enum('pending','confirmed','cancelled','completed','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservasi`
--

INSERT INTO `reservasi` (`id_reservasi`, `id_user`, `id_lapangan`, `id_jadwal`, `tanggal_booking`, `durasi`, `total_harga`, `status_reservasi`) VALUES
(4, 12, 101, 17, '2025-06-29', 5, 250000.00, 'confirmed'),
(5, 13, 105, 28, '2025-06-29', 5, 250000.00, 'confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(10) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama_user`, `password`, `no_telp`, `email`, `role`) VALUES
(12, 'Nanta', '202cb962ac59075b964b07152d234b70', '12334', '123@gmmail', 'customer'),
(13, 'Nasok', '4297f44b13955235245b2497399d7a93', '1111111111', 'nasok123@mail', 'customer');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_detailreservasi`
-- (See below for the actual view)
--
CREATE TABLE `v_detailreservasi` (
`id_reservasi` int(10)
,`nama_user` varchar(100)
,`user_email` varchar(100)
,`user_phone` varchar(15)
,`nama_lapangan` varchar(255)
,`harga` int(10)
,`hari` varchar(10)
,`jam_mulai` time
,`jam_berakhir` time
,`tanggal_booking` date
,`durasi_jam` int(2)
,`total_harga` decimal(10,2)
,`status_reservasi` enum('pending','confirmed','cancelled','completed','rejected')
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_reservasimendatanguser`
-- (See below for the actual view)
--
CREATE TABLE `v_reservasimendatanguser` (
`id_reservasi` int(10)
,`id_user` int(10)
,`nama_lapangan` varchar(255)
,`harga` int(10)
,`jam_mulai` time
,`jam_berakhir` time
,`tanggal_booking` date
,`durasi_jam` int(2)
,`total_harga` decimal(10,2)
,`status_reservasi` enum('pending','confirmed','cancelled','completed','rejected')
);

-- --------------------------------------------------------

--
-- Structure for view `v_detailreservasi`
--
DROP TABLE IF EXISTS `v_detailreservasi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_detailreservasi`  AS SELECT `r`.`id_reservasi` AS `id_reservasi`, `u`.`nama_user` AS `nama_user`, `u`.`email` AS `user_email`, `u`.`no_telp` AS `user_phone`, `l`.`nama_lapangan` AS `nama_lapangan`, `l`.`harga` AS `harga`, `j`.`hari` AS `hari`, `j`.`jam_mulai` AS `jam_mulai`, `j`.`jam_berakhir` AS `jam_berakhir`, `r`.`tanggal_booking` AS `tanggal_booking`, `r`.`durasi` AS `durasi_jam`, `r`.`total_harga` AS `total_harga`, `r`.`status_reservasi` AS `status_reservasi` FROM (((`reservasi` `r` join `user` `u` on(`r`.`id_user` = `u`.`id_user`)) join `lapangan` `l` on(`r`.`id_lapangan` = `l`.`id_lapangan`)) join `jadwal` `j` on(`r`.`id_jadwal` = `j`.`id_jadwal`)) ;

-- --------------------------------------------------------

--
-- Structure for view `v_reservasimendatanguser`
--
DROP TABLE IF EXISTS `v_reservasimendatanguser`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_reservasimendatanguser`  AS SELECT `r`.`id_reservasi` AS `id_reservasi`, `r`.`id_user` AS `id_user`, `l`.`nama_lapangan` AS `nama_lapangan`, `l`.`harga` AS `harga`, `j`.`jam_mulai` AS `jam_mulai`, `j`.`jam_berakhir` AS `jam_berakhir`, `r`.`tanggal_booking` AS `tanggal_booking`, `r`.`durasi` AS `durasi_jam`, `r`.`total_harga` AS `total_harga`, `r`.`status_reservasi` AS `status_reservasi` FROM ((`reservasi` `r` join `lapangan` `l` on(`r`.`id_lapangan` = `l`.`id_lapangan`)) join `jadwal` `j` on(`r`.`id_jadwal` = `j`.`id_jadwal`)) WHERE `r`.`tanggal_booking` >= curdate() ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `id_lapangan` (`id_lapangan`),
  ADD KEY `idx_jadwal_lapangan_jam` (`id_lapangan`,`jam_mulai`);

--
-- Indexes for table `lapangan`
--
ALTER TABLE `lapangan`
  ADD PRIMARY KEY (`id_lapangan`);

--
-- Indexes for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD PRIMARY KEY (`id_reservasi`),
  ADD KEY `idUser` (`id_user`),
  ADD KEY `idLapangan` (`id_lapangan`),
  ADD KEY `idJadwal` (`id_jadwal`),
  ADD KEY `idx_reservasi_id_user` (`id_user`),
  ADD KEY `idx_reservasi_id_lapangan` (`id_lapangan`),
  ADD KEY `idx_reservasi_tanggal_booking` (`tanggal_booking`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `idx_user_email` (`email`),
  ADD KEY `idx_user_no_telp` (`no_telp`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `lapangan`
--
ALTER TABLE `lapangan`
  MODIFY `id_lapangan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `reservasi`
--
ALTER TABLE `reservasi`
  MODIFY `id_reservasi` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`id_lapangan`) REFERENCES `lapangan` (`id_lapangan`);

--
-- Constraints for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD CONSTRAINT `reservasi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `reservasi_ibfk_2` FOREIGN KEY (`id_lapangan`) REFERENCES `lapangan` (`id_lapangan`),
  ADD CONSTRAINT `reservasi_ibfk_3` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal` (`id_jadwal`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
