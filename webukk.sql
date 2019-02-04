-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2019 at 08:21 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webukk`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblogin`
--

CREATE TABLE `tblogin` (
  `KodeLogin` int(11) NOT NULL,
  `Username` varchar(150) NOT NULL,
  `Password` varchar(150) NOT NULL,
  `NamaLengkap` varchar(100) NOT NULL,
  `Level` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblogin`
--

INSERT INTO `tblogin` (`KodeLogin`, `Username`, `Password`, `NamaLengkap`, `Level`) VALUES
(1, 'admin', 'admin', 'Ryan Hazizi', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbpelanggan`
--

CREATE TABLE `tbpelanggan` (
  `KodePelanggan` int(11) NOT NULL,
  `NoPelanggan` varchar(100) NOT NULL,
  `NoMeter` varchar(100) NOT NULL,
  `KodeTarif` int(11) NOT NULL,
  `NamaLengkap` varchar(100) NOT NULL,
  `Telp` varchar(15) NOT NULL,
  `Alamat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbpembayaran`
--

CREATE TABLE `tbpembayaran` (
  `KodePembayaran` int(11) NOT NULL,
  `NoTagihan` varchar(100) NOT NULL,
  `TglBayar` date NOT NULL,
  `JumlahTagihan` double NOT NULL,
  `BuktiPembayaran` varchar(100) NOT NULL,
  `Status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbtagihan`
--

CREATE TABLE `tbtagihan` (
  `KodeTagihan` int(11) NOT NULL,
  `NoTagihan` varchar(100) NOT NULL,
  `KodePelanggan` int(11) NOT NULL,
  `TahunTagih` int(11) NOT NULL,
  `BulanTagih` varchar(10) NOT NULL,
  `PemakaianAkhir` double NOT NULL,
  `JumlahPemakaian` double NOT NULL,
  `TglPencatatan` date NOT NULL,
  `TotalBayar` double NOT NULL,
  `TglMulaiBayar` date NOT NULL,
  `TglAkhirBayar` date NOT NULL,
  `Status` varchar(30) NOT NULL,
  `Keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbtarif`
--

CREATE TABLE `tbtarif` (
  `KodeTarif` int(11) NOT NULL,
  `Daya` int(11) NOT NULL,
  `TarifPerKwh` double NOT NULL,
  `Beban` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblogin`
--
ALTER TABLE `tblogin`
  ADD PRIMARY KEY (`KodeLogin`);

--
-- Indexes for table `tbpelanggan`
--
ALTER TABLE `tbpelanggan`
  ADD PRIMARY KEY (`KodePelanggan`);

--
-- Indexes for table `tbpembayaran`
--
ALTER TABLE `tbpembayaran`
  ADD PRIMARY KEY (`KodePembayaran`);

--
-- Indexes for table `tbtagihan`
--
ALTER TABLE `tbtagihan`
  ADD PRIMARY KEY (`KodeTagihan`);

--
-- Indexes for table `tbtarif`
--
ALTER TABLE `tbtarif`
  ADD PRIMARY KEY (`KodeTarif`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblogin`
--
ALTER TABLE `tblogin`
  MODIFY `KodeLogin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbpelanggan`
--
ALTER TABLE `tbpelanggan`
  MODIFY `KodePelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbpembayaran`
--
ALTER TABLE `tbpembayaran`
  MODIFY `KodePembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbtagihan`
--
ALTER TABLE `tbtagihan`
  MODIFY `KodeTagihan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbtarif`
--
ALTER TABLE `tbtarif`
  MODIFY `KodeTarif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
