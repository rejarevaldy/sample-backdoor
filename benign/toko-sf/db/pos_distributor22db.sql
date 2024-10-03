-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2016 at 04:37 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos_distributor22db`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `kd_barang` char(7) NOT NULL,
  `barcode` varchar(20) NOT NULL,
  `nm_barang` varchar(100) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `satuan` varchar(20) NOT NULL,
  `harga_modal` int(12) NOT NULL,
  `harga_jual_1` int(12) NOT NULL,
  `harga_jual_2` int(12) NOT NULL,
  `harga_jual_3` int(12) NOT NULL,
  `harga_jual_4` int(12) NOT NULL,
  `stok` int(10) NOT NULL,
  `stok_opname` int(10) NOT NULL,
  `stok_minimal` int(10) NOT NULL,
  `stok_maksimal` int(10) NOT NULL,
  `lokasi_stok` enum('Toko','Gudang') NOT NULL,
  `lokasi_rak` varchar(40) NOT NULL,
  `kd_supplier` char(4) NOT NULL,
  `kd_jenis` char(4) NOT NULL,
  `kd_merek` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`kd_barang`, `barcode`, `nm_barang`, `keterangan`, `satuan`, `harga_modal`, `harga_jual_1`, `harga_jual_2`, `harga_jual_3`, `harga_jual_4`, `stok`, `stok_opname`, `stok_minimal`, `stok_maksimal`, `lokasi_stok`, `lokasi_rak`, `kd_supplier`, `kd_jenis`, `kd_merek`) VALUES
('B000001', 'DR982SH26WMRID ', 'Leather Boot Shoes Tan ', '-', 'Unit', 350000, 420000, 470000, 520000, 550000, 8, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J001', 'M01'),
('B000002', 'ZA848SH82TUJID ', 'Mix Material Boots With Buckles Brown', '-', 'Unit', 500000, 550000, 580000, 610000, 640000, 9, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J001', 'M02'),
('B000003', 'ZA848SH83TUIID', 'Mix Material Boots With Buckles Black', '-', 'Unit', 500000, 599000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J001', 'M02'),
('B000004', 'RI412SH87QLGID ', 'Cut Out Buckle Chelsea Boots', '-', 'Unit', 600000, 720000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J001', 'M03'),
('B000005', 'DR982SH72FWDID ', 'Ladies Boot Shoes Brown', '-', 'Unit', 350000, 420000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J001', 'M01'),
('B000006', 'ZA848SH40FHZID ', 'High Top Laced Up Sneakers With Side Zipper Tan', '-', 'Unit', 330000, 396000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J001', 'M02'),
('B000007', 'ZA848SH42FHXID', 'High Top Laced Up Sneakers With Side Zipper Black', '-', 'Unit', 330000, 396000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J001', 'M02'),
('B000008', 'ZA848SH41FHYID ', 'High Top Laced Up Sneakers With Side Zipper Grey', '-', 'Unit', 330000, 396000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J001', 'M02'),
('B000009', 'ZA848SH92TXVID ', 'Studded Stiletto Boots Black', '-', 'Unit', 400000, 480000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J001', 'M02'),
('B000010', 'ZA848SH91TXWID', 'Studded Stiletto Boots Taupe', '-', 'Unit', 400000, 480000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J001', 'M02'),
('B000011', 'ZA848SH56MALID ', 'Side Buttoned Fleece Boots Grey', '-', 'Unit', 330000, 396000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J001', 'M02'),
('B000012', 'ZA848SH57MAKID ', 'Side Buttoned Fleece Boots Black', '-', 'Unit', 330000, 396000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J001', 'M02'),
('B000013', 'ZA848SH55MAMID', 'Side Buttoned Fleece Boots Beige', '-', 'Unit', 330000, 396000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J001', 'M02'),
('B000014', 'MM739SH62CUVID', 'MM Shoes Calista Black', '-', 'Unit', 200000, 240000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J001', 'M04'),
('B000015', 'MM739SH10LYBID ', 'MM Middle Redboots', '-', 'Unit', 150000, 200000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J001', 'M04'),
('B000016', 'MA456SH40MKPID', 'Ladies We Boots', '-', 'Unit', 260000, 312000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J001', 'M05'),
('B000017', ' ZA848SH57VLQID ', 'Peep Toe Ballerinas Pink', '-', 'Unit', 165000, 198000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J003', 'M02'),
('B000018', 'ZA848SH56VLRID ', 'Peep Toe Ballerinas Black', '-', 'Unit', 165000, 198000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J003', 'M02'),
('B000019', 'ZA848SH55VLSID ', 'Peep Toe Ballerinas Beige', '-', 'Unit', 165000, 198000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J003', 'M02'),
('B000020', 'ZA848SH06WYBID ', 'T-Bar Ballerina Flats Blush ', '-', 'Unit', 190000, 228000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J003', 'M02'),
('B000021', 'ZA848SH07WYAID', 'T-Bar Ballerina Flats Black', '-', 'Unit', 190000, 228000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J003', 'M02'),
('B000022', 'ZA848SH05WYCID', 'T-Bar Ballerina Flats Beige', '-', 'Unit', 190000, 228000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J003', 'M02'),
('B000023', 'ZA848SH10SXDID ', 'Suede Ankle Strap Flats', '-', 'Unit', 190000, 228000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J003', 'M02'),
('B000024', 'ZA848SH08SXFID ', 'Mixed Suede Pointed Ballerinas Maroon/Navy ', '-', 'Unit', 190000, 228000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J003', 'M02'),
('B000025', 'ZA848SH06SXHID ', 'Mixed Suede Pointed Ballerinas Taupe/Pink ', '-', 'Unit', 190000, 228000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J003', 'M02'),
('B000026', 'SO043SH21QYSID ', 'Flat Ballerinas With Bow Tie Grey', '-', 'Unit', 210000, 252000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J003', 'M06'),
('B000027', 'SO043SH20QYTID ', 'Flat Ballerinas With Bow Tie Beige ', '-', 'Unit', 210000, 252000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J003', 'M06'),
('B000028', 'ZA848SH89VOGID ', 'Weave Ballerinas with Bow Detail Beige', '-', 'Unit', 190000, 228000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J003', 'M02'),
('B000029', 'ZA848SH91VOEID ', 'Weave Ballerinas with Bow Detail Black', '-', 'Unit', 190000, 228000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J003', 'M02'),
('B000030', 'ZA848SH90VOFID ', 'Weave Ballerinas with Bow Detail Grey', '-', 'Unit', 190000, 228000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J003', 'M02'),
('B000031', 'SO043SH49OHIID  ', 'Asymmetric Pointed Toe Flats  Pewter ', '-', 'Unit', 150000, 180000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J003', 'M06'),
('B000032', 'SO043SH50OHHID ', 'Asymmetric Pointed Toe Flats  Silver', '-', 'Unit', 150000, 180000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J003', 'M06'),
('B000033', 'SO043SH45OHMID', 'Pointed Flats with Ankle Strap Black', '-', 'Unit', 165000, 198000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J003', 'M06'),
('B000034', 'SO043SH44OHNID ', 'Pointed Flats with Ankle Strap Beige ', '-', 'Unit', 165000, 198000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J003', 'M06'),
('B000035', 'ZA848SH01KTAID', 'Butterfly Embroidered Loafers Grey', '-', 'Unit', 150000, 180000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J003', 'M02'),
('B000036', 'KO931SH82IKBID', 'Ankle Ribbon Satin Flat Shoes Wine Red', '-', 'Unit', 210000, 252000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J003', 'M07'),
('B000037', 'TI213SH70LFPID', 'Melissa Round Toe Batik Flats', '-', 'Unit', 250000, 300000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J003', 'M08'),
('B000038', 'SO043SH71GLOID ', 'Ankle Band Mid-Heeled Pumps Dark Grey', '-', 'Unit', 250000, 300000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J004', 'M06'),
('B000039', 'SO043SH72GLNID ', 'Ankle Band Mid-Heeled Pumps Black', '-', 'Unit', 250000, 300000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J004', 'M06'),
('B000040', 'SO043SH70GLPID', 'Ankle Band Mid-Heeled Pumps Beige', '-', 'Unit', 250000, 300000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J004', 'M06'),
('B000041', 'ZA848SH92CHBID ', 'Patent High Heel Sandals With Back Zip Blush', '-', 'Unit', 330000, 396000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J004', 'M02'),
('B000042', 'ZA848SH93CHAID', 'Patent High Heel Sandals With Back Zip Black', '-', 'Unit', 330000, 396000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J004', 'M02'),
('B000043', 'ZA848SH91CHCID', 'Patent High Heel Sandals With Back Zip Taupe', '-', 'Unit', 330000, 396000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J004', 'M02'),
('B000044', 'ZA848SH90CHDID ', 'Patent High Heel Sandals With Back Zip Silver', '-', 'Unit', 330000, 396000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J004', 'M02'),
('B000045', 'ZA848SH95TXSID', 'Strappy High Heel Sandal Black ', '-', 'Unit', 320000, 384000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J004', 'M02'),
('B000046', 'ZA848SH96TXRID ', 'Strappy High Heel Sandal Beige', '-', 'Unit', 320000, 384000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J004', 'M02'),
('B000047', 'ZA848SH40ALFID ', 'Pointed Toe Slip On Mule Heels Brown', '-', 'Unit', 330000, 396000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J004', 'M02'),
('B000048', 'ZA848SH39ALGID', 'Pointed Toe Slip On Mule Heels Black', '-', 'Unit', 330000, 396000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J004', 'M02'),
('B000049', 'SO043SH91QSEID ', 'Pointed Pumps With Metal Heel Detail Blue', '-', 'Unit', 250000, 300000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J004', 'M06'),
('B000050', 'SO043SH94QSBID ', 'Pointed Pumps With Metal Heel Detail Black', '-', 'Unit', 250000, 330000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J004', 'M06'),
('B000051', 'SO043SH93QSCID ', 'Pointed Pumps With Metal Heel Detail Pink', '-', 'Unit', 250000, 300000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J004', 'M06'),
('B000052', 'SO043SH92QSDID', 'Pointed Pumps With Metal Heel Detail Grey', '-', 'Unit', 250000, 300000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J004', 'M06'),
('B000053', 'SO043SH28CHRID', 'Metal-Heel Pointed Pumps Beige', '-', 'Unit', 250000, 300000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J004', 'M06'),
('B000054', 'PR763SH35LKUID ', 'Lidia High Heels Brown', '-', 'Unit', 375000, 400000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J004', 'M09'),
('B000055', 'EZ319SH77QLQID ', 'Gladiator Heel With Double Ankle Strap Black', '-', 'Unit', 320000, 384000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J004', 'M02'),
('B000056', 'EZ319SH78QLPID ', 'Gladiator Heel With Double Ankle Strap Grey', '-', 'Unit', 320000, 384000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J004', 'M02'),
('B000057', 'EZ319SH76QLRID', 'Gladiator Heel With Double Ankle Strap Claret ', '-', 'Unit', 320000, 384000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J004', 'M02'),
('B000058', 'VI289SH87DMQID ', 'Yovela Heels Silver', '-', 'Unit', 375000, 400000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J004', 'M10'),
('B000059', 'VI289SH85GHUID ', 'Yovela Heels Gold Nina', '-', 'Unit', 375000, 400000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J004', 'M10'),
('B000060', 'VI289SH71YBWID ', 'Rubina Heels Black', '-', 'Unit', 330000, 396000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J004', 'M10'),
('B000061', 'ZA848SH36AXVID ', 'Peeptoe Espadrille Platform Wedges Navy Kombi White', '-', 'Unit', 275000, 350000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'K10', 'M02'),
('B000062', 'ZA848SH35AXWID ', 'Peeptoe Espadrille Platform Wedges Black', '-', 'Unit', 275000, 350000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'K10', 'M02'),
('B000063', 'ZA848SH10INXID ', 'Platform Wedge With Ankle Strap Black ', '-', 'Unit', 320000, 384000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'K10', 'M02'),
('B000064', 'ZA848SH12INVID ', 'Platform Wedge With Ankle Strap Navy', '-', 'Unit', 320000, 384000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'K10', 'M02'),
('B000065', 'ZA848SH11INWID', 'Platform Wedge With Ankle Strap Brown', '-', 'Unit', 320000, 384000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'K10', 'M02'),
('B000066', 'BA426SH61ZCOID ', 'Usra Sandal Wedges Blue', '-', 'Unit', 250000, 300000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'K10', 'M11'),
('B000067', 'BA426SH62ZCNID', 'Usra Sandal Wedges  Brown ', '-', 'Unit', 250000, 300000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'K10', 'M11'),
('B000068', 'NI905SH89SWWID ', 'Wedge Marcella  Light Gold ', '-', 'Unit', 275000, 350000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'K10', 'M12'),
('B000069', 'NI905SH86SWZID ', 'Wedge Marcella Black', '-', 'Unit', 275000, 350000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'K10', 'M12'),
('B000070', 'MA456SH24FJNID ', 'Marc & Stuart Shoes Black', '-', 'Unit', 150000, 180000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'K10', 'M05'),
('B000071', 'SO043SH35JOUID ', 'Dual-Strap Wedges Pink ', '-', 'Unit', 290000, 348000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'K10', 'M06'),
('B000072', 'SO043SH36JOTID ', 'Dual-Strap Wedges Black', '-', 'Unit', 290000, 348000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'K10', 'M06'),
('B000073', 'EV441SH74YBDID ', 'Vivian Wedges Beige ', '-', 'Unit', 450000, 540000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'K10', 'M14'),
('B000074', 'EV441SH73YBEID ', 'Vivian Wedges  Bronze ', '-', 'Unit', 450000, 540000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'K10', 'M14'),
('B000075', 'EV441SH72YBFID ', 'Vivian Wedges Gold', '-', 'Unit', 450000, 540000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'K10', 'M14'),
('B000076', 'NI905SH76KGPID ', 'Lincoln Wedges  Apricot ', '-', 'Unit', 265000, 318000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'K10', 'M12'),
('B000077', 'AP517SH71JEIID ', 'Nicole Wedges Shoes Beige ', '-', 'Unit', 375000, 450000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'K10', 'M15'),
('B000078', 'PR763SH16MHRID', 'Alexa Suede Wedges Black', '-', 'Unit', 460000, 552000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'K10', 'M09'),
('B000079', 'ST294SH81GBQID ', 'Chantelle Wedges Black', '-', 'Unit', 405000, 486000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'K10', 'M16'),
('B000080', 'ST294SH82GBPID', 'Chantelle Wedges Brown', '-', 'Unit', 405000, 486000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'K10', 'M16'),
('B000081', 'ZA848SH34FIFID ', 'Jersey Laced Up Hidden Wedge Sneakers White ', '-', 'Unit', 300000, 480000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J008', 'M02'),
('B000082', 'ZA848SH33FIGID ', 'Jersey Laced Up Hidden Wedge Sneakers Grey ', '-', 'Unit', 400000, 480000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J008', 'M02'),
('B000083', 'ZA848SH32FIHID ', 'Jersey Laced Up Hidden Wedge Sneakers Black', '-', 'Unit', 400000, 480000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J008', 'M02'),
('B000084', 'ZA848SH32MJZID ', 'Faux Leather High Top Sneakers Black', '-', 'Unit', 415000, 498000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J008', 'M02'),
('B000085', 'ZA848SH34MJXID ', 'Faux Leather High Top Sneakers Wahite', '-', 'Unit', 415000, 498000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J008', 'M02'),
('B000086', 'ZA848SH33MJYID', 'Faux Leather High Top Sneakers Pink', '-', 'Unit', 415000, 498000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J008', 'M02'),
('B000087', 'ZA848SH61KKWID ', 'Metallic Lace Up Sneakers White', '-', 'Unit', 235000, 282000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J008', 'M02'),
('B000088', 'ZA848SH62KKVID', 'Metallic Lace Up Sneakers Black', '-', 'Unit', 235000, 282000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J008', 'M02'),
('B000089', 'ZA848SH90NCBID', 'Studded Lace Up Sneaker Silver', '-', 'Unit', 280000, 336000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J008', 'M02'),
('B000090', 'ZA848SH89NCCID ', 'Studded Lace Up Sneaker Black', '-', 'Unit', 280000, 336000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J008', 'M02'),
('B000091', 'ZA911SH56UWHID', 'Basic Canvas Sneakers Black', '-', 'Unit', 150000, 199000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J008', 'M02'),
('B000092', 'ZA911SH57UWGID ', 'Basic Canvas Sneakers Maroon ', '-', 'Unit', 150000, 199000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J008', 'M02'),
('B000093', 'ZA911SH55UWIID ', 'Basic Canvas Sneakers Grey ', '-', 'Unit', 150000, 199000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J008', 'M02'),
('B000094', 'ZA848SH19ISMID', 'Lace Up Canvas Sneakers With Stripe Lining Yellow', '-', 'Unit', 250000, 300000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J008', 'M02'),
('B000095', 'ZA848SH21ISKID ', 'Lace Up Canvas Sneakers With Stripe Lining Black', '-', 'Unit', 250000, 300000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J008', 'M02'),
('B000096', 'CO302SH39SQUID ', 'CT As Canvas Ox Sneaker Shoes Navy', '-', 'Unit', 400000, 480000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J008', 'M17'),
('B000097', 'CO302SH43SQQID ', 'CT As Canvas Ox Sneaker Shoes Black', '-', 'Unit', 400000, 480000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J008', 'M17'),
('B000098', 'ZA848SH73YYKID ', 'High Top Sneakers With High Platform Cream', '-', 'Unit', 330000, 396000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J008', 'M02'),
('B000099', 'ZA848SH74YYJID ', 'High Top Sneakers With High Platform Grey', '-', 'Unit', 330000, 396000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J008', 'M02'),
('B000100', 'ZA848SH72YYLID', 'High Top Sneakers With High Platform Black', '-', 'Unit', 330000, 396000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J008', 'M02'),
('B000101', 'ZA848SH18LDXID ', 'Cross Stitch Floral Slip Ons Multi Black', '-', 'Unit', 150000, 199000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J009', 'M02'),
('B000102', 'ZA848SH19LDWID ', 'Cross Stitch Floral Slip Ons Multi Blue', '-', 'Unit', 150000, 199000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J009', 'M02'),
('B000103', 'ZA848SH17LDYID ', 'Cross Stitch Floral Slip Ons Multi Beige', '-', 'Unit', 150000, 199000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J009', 'M02'),
('B000104', 'ZA911SH67KKQID', 'Basic Herringbone Slip Ons Cream', '-', 'Unit', 190000, 228000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J009', 'M02'),
('B000105', 'ZA911SH69KKOID ', 'Basic Canvas Slip Ons Black', '-', 'Unit', 190000, 228000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J009', 'M02'),
('B000106', 'ZA911SH68KKPID', 'Basic Canvas Slip Ons Grey', '-', 'Unit', 190000, 228000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J009', 'M02'),
('B000107', 'ZA848SH39FIAID ', 'Slip On Platform Sneaker Black', '-', 'Unit', 350000, 420000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J009', 'M02'),
('B000108', 'ZA848SH38FIBID ', 'Slip On Platform Sneaker Beige', '-', 'Unit', 350000, 420000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J009', 'M02'),
('B000109', 'ZA848SH37FICID ', 'Slip On Platform Sneaker White', '-', 'Unit', 350000, 420000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J009', 'M02'),
('B000110', 'RU128AA82ZMJID', 'Pretty Frill Socks  Black ', '-', 'Unit', 30000, 59900, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J005', 'M18'),
('B000111', 'RU128AA81ZMKID', 'Pretty Frill Socks Blush', '-', 'Unit', 30000, 59900, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J005', 'M18'),
('B000112', 'RU128AC64EDJID ', 'Pretty Frill Socks  Panda Heads', '-', 'Unit', 30000, 59900, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J005', 'M18'),
('B000113', 'RU128AA77WZEID ', 'Pretty Frill Socks Navy', '-', 'Unit', 30000, 59900, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J005', 'M18'),
('B000114', 'RU128AA80ZMLID ', 'Pretty Frill Socks Grey', '-', 'Unit', 30000, 59900, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J005', 'M18'),
('B000115', 'RU128AA75WZGID', 'Ankle Novelty Socks Lime', '-', 'Unit', 30000, 59900, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J005', 'M18'),
('B000116', 'RU128AA76WZFID ', 'Ankle Novelty Sock  Coral Rhinos  Pink', '-', 'Unit', 30000, 59900, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J005', 'M18'),
('B000117', 'AT088AC73VPIID ', 'Dress Sock 3 Pieces Navy Light Grey', '-', 'Unit', 45000, 75000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J005', 'M19'),
('B000118', 'AT088AC93VOOID ', 'Crew Sock Grey', '-', 'Unit', 15000, 30000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J005', 'M19'),
('B000119', 'AT088AC94VONID ', 'Crew Sock Black', '-', 'Unit', 15000, 30000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J005', 'M19'),
('B000120', 'AT088AC92VOPID', 'Crew Sock White', '-', 'Unit', 15000, 30000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 01-05', 'S001', 'J005', 'M19'),
('B000121', '000121', 'Barang Satu', 'Keterangan Barang', 'Unit', 1000, 2000, 0, 0, 0, 0, 0, 40, 100, 'Toko', 'SPT 03', 'S001', 'J001', 'M02');

-- --------------------------------------------------------

--
-- Table structure for table `hak_akses`
--

CREATE TABLE `hak_akses` (
  `id` int(4) NOT NULL,
  `kd_user` char(4) NOT NULL,
  `mu_data_user` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_data_supplier` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_data_merek` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_data_pelanggan` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_data_kategori` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_data_jenis` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_data_barang` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_kontrol_stok` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_pencarian` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_barcode` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_trans_pembelian` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_trans_returbeli` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_trans_penjualan` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_trans_returjual` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_bayar_pembelian` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_bayar_penjualan` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_laporan_cetak` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_laporan_grafik` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_login` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_logout` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_backup_restore` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_export_import` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_export_barang` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_export_pelanggan` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_import_barang` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mu_import_pelanggan` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_user` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_supplier` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_pelanggan` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_merek` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_kategori` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_jenis` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_barang_kategori` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_barang_jenis` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_barang_merek` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_barang_supplier` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_barang_minimal` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_barang_maksimal` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_pembelian_periode` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_pembelian_bulan` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_pembelian_supplier` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_pembelian_barang_periode` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_pembelian_barang_bulan` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_pembelian_rekap_periode` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_pembelian_rekap_bulan` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_returbeli_periode` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_returbeli_bulan` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_returbeli_barang_periode` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_returbeli_barang_bulan` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_returbeli_rekap_periode` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_returbeli_rekap_bulan` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_penjualan_tanggal` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_penjualan_periode` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_penjualan_bulan` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_penjualan_pelanggan` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_penjualan_barang_tanggal` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_penjualan_barang_periode` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_penjualan_barang_bulan` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_penjualan_barang_pelanggan` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_penjualan_rekap_periode` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_penjualan_rekap_bulan` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_penjualan_terlaris` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_labarugi_periode` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_labarugi_bulan` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_returjual_periode` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_returjual_bulan` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_returjual_barang_periode` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_returjual_barang_bulan` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_returjual_rekap_periode` enum('No','Yes') NOT NULL DEFAULT 'No',
  `mlap_returjual_rekap_bulan` enum('No','Yes') NOT NULL DEFAULT 'No'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hak_akses`
--

INSERT INTO `hak_akses` (`id`, `kd_user`, `mu_data_user`, `mu_data_supplier`, `mu_data_merek`, `mu_data_pelanggan`, `mu_data_kategori`, `mu_data_jenis`, `mu_data_barang`, `mu_kontrol_stok`, `mu_pencarian`, `mu_barcode`, `mu_trans_pembelian`, `mu_trans_returbeli`, `mu_trans_penjualan`, `mu_trans_returjual`, `mu_bayar_pembelian`, `mu_bayar_penjualan`, `mu_laporan_cetak`, `mu_laporan_grafik`, `mu_login`, `mu_logout`, `mu_backup_restore`, `mu_export_import`, `mu_export_barang`, `mu_export_pelanggan`, `mu_import_barang`, `mu_import_pelanggan`, `mlap_user`, `mlap_supplier`, `mlap_pelanggan`, `mlap_merek`, `mlap_kategori`, `mlap_jenis`, `mlap_barang_kategori`, `mlap_barang_jenis`, `mlap_barang_merek`, `mlap_barang_supplier`, `mlap_barang_minimal`, `mlap_barang_maksimal`, `mlap_pembelian_periode`, `mlap_pembelian_bulan`, `mlap_pembelian_supplier`, `mlap_pembelian_barang_periode`, `mlap_pembelian_barang_bulan`, `mlap_pembelian_rekap_periode`, `mlap_pembelian_rekap_bulan`, `mlap_returbeli_periode`, `mlap_returbeli_bulan`, `mlap_returbeli_barang_periode`, `mlap_returbeli_barang_bulan`, `mlap_returbeli_rekap_periode`, `mlap_returbeli_rekap_bulan`, `mlap_penjualan_tanggal`, `mlap_penjualan_periode`, `mlap_penjualan_bulan`, `mlap_penjualan_pelanggan`, `mlap_penjualan_barang_tanggal`, `mlap_penjualan_barang_periode`, `mlap_penjualan_barang_bulan`, `mlap_penjualan_barang_pelanggan`, `mlap_penjualan_rekap_periode`, `mlap_penjualan_rekap_bulan`, `mlap_penjualan_terlaris`, `mlap_labarugi_periode`, `mlap_labarugi_bulan`, `mlap_returjual_periode`, `mlap_returjual_bulan`, `mlap_returjual_barang_periode`, `mlap_returjual_barang_bulan`, `mlap_returjual_rekap_periode`, `mlap_returjual_rekap_bulan`) VALUES
(1, 'U01', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes'),
(2, 'U02', 'No', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'No', 'No', 'No', 'Yes', 'Yes', 'No', 'No', 'No', 'Yes', 'No', 'No', 'No', 'No', 'No', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'No', 'No', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(3, 'U03', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'Yes', 'No', 'No', 'No', 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'Yes', 'No', 'No', 'No', 'No', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 'Yes', 'No', 'No', 'Yes', 'Yes', 'No', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No'),
(6, 'U04', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 'No', 'No', 'Yes', 'No', 'No', 'No', 'Yes', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'Yes', 'Yes', 'Yes', 'No', 'Yes', 'Yes', 'No', 'Yes', 'Yes', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `jenis`
--

CREATE TABLE `jenis` (
  `kd_jenis` char(4) NOT NULL,
  `nm_jenis` varchar(100) NOT NULL,
  `kd_kategori` char(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis`
--

INSERT INTO `jenis` (`kd_jenis`, `nm_jenis`, `kd_kategori`) VALUES
('J001', 'Boots', 'K01'),
('J002', 'Clog', 'K01'),
('J003', 'Flats & Ballerina', 'K01'),
('J004', 'High Heels', 'K01'),
('J005', 'Kaos Kaki', 'K01'),
('J006', 'Sandal', 'K01'),
('J007', 'Sepatu Olahraga', 'K01'),
('J008', 'Sneakers/Kets', 'K01'),
('J009', 'Slip On', 'K01'),
('J010', 'Wedges', 'K01');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kd_kategori` char(3) NOT NULL,
  `nm_kategori` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`kd_kategori`, `nm_kategori`) VALUES
('K02', 'TAS'),
('K04', 'JERSEY/ SPORT'),
('K03', 'PAKAIAN'),
('K01', 'SEPATU');

-- --------------------------------------------------------

--
-- Table structure for table `merek`
--

CREATE TABLE `merek` (
  `kd_merek` char(3) NOT NULL,
  `nm_merek` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `merek`
--

INSERT INTO `merek` (`kd_merek`, `nm_merek`) VALUES
('M02', 'Zalora'),
('M01', 'Dr. Kevin'),
('M03', 'River Island'),
('M04', 'MM Shoes '),
('M05', 'Marc & Stuart Shoes'),
('M06', 'Something Borrowed'),
('M07', 'Koumi Koumi'),
('M08', 'Tivoli'),
('M09', 'Prima Classe'),
('M10', 'Victoria'),
('M11', 'Bata'),
('M12', 'Nicholas Edison'),
('M13', 'Yongki Komaladi'),
('M14', 'Everbest'),
('M15', 'Apple Green'),
('M16', 'Stevania Baldo'),
('M17', 'Converse'),
('M18', 'Rubi'),
('M19', 'Atypical Sock');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `kd_pelanggan` char(4) NOT NULL,
  `nm_pelanggan` varchar(100) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `level_harga` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`kd_pelanggan`, `nm_pelanggan`, `alamat`, `no_telepon`, `level_harga`) VALUES
('P001', 'CASH RITEL', 'Yogyakarta', '-', 4),
('P002', 'Fitria Prasetiawati', 'Jl. Janti, Karang Jambe, Yogyakarta', '081928222211', 2),
('P003', 'Septi Suhesti', 'Lampung', '08191111', 3);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_beli`
--

CREATE TABLE `pembayaran_beli` (
  `no_pembayaran_beli` char(7) NOT NULL,
  `tgl_pembayaran_beli` date NOT NULL,
  `no_pembelian` char(7) NOT NULL,
  `total_bayar` int(12) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_user` char(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembayaran_beli`
--

INSERT INTO `pembayaran_beli` (`no_pembayaran_beli`, `tgl_pembayaran_beli`, `no_pembelian`, `total_bayar`, `keterangan`, `kd_user`) VALUES
('PB00001', '2015-09-18', 'BL00001', 8500000, 'Pelunasan', 'U01');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_jual`
--

CREATE TABLE `pembayaran_jual` (
  `no_pembayaran_jual` char(7) NOT NULL,
  `tgl_pembayaran_jual` date NOT NULL,
  `no_penjualan` char(7) NOT NULL,
  `total_bayar` int(12) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_user` char(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembayaran_jual`
--

INSERT INTO `pembayaran_jual` (`no_pembayaran_jual`, `tgl_pembayaran_jual`, `no_penjualan`, `total_bayar`, `keterangan`, `kd_user`) VALUES
('PJ00001', '2015-09-18', 'JL00002', 200000, 'Angsuran', 'U01'),
('PJ00002', '2015-09-18', 'JL00002', 50000, 'Angsuran 2', 'U01'),
('PJ00003', '2015-09-18', 'JL00002', 70000, 'Pelunasan', 'U01');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `no_pembelian` char(7) NOT NULL,
  `tgl_pembelian` date NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_supplier` char(4) NOT NULL,
  `status_bayar` enum('Hutang','Lunas') NOT NULL DEFAULT 'Hutang',
  `kd_user` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`no_pembelian`, `tgl_pembelian`, `keterangan`, `kd_supplier`, `status_bayar`, `kd_user`) VALUES
('BL00001', '2015-09-18', 'Belanja Stok', 'S001', 'Lunas', 'U01');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_item`
--

CREATE TABLE `pembelian_item` (
  `no_pembelian` char(7) NOT NULL,
  `kd_barang` char(7) NOT NULL,
  `harga_beli` int(12) NOT NULL,
  `jumlah` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembelian_item`
--

INSERT INTO `pembelian_item` (`no_pembelian`, `kd_barang`, `harga_beli`, `jumlah`) VALUES
('BL00001', 'B000001', 350000, 10),
('BL00001', 'B000002', 500000, 10);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `no_penjualan` char(7) NOT NULL,
  `tgl_penjualan` date NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_pelanggan` char(4) NOT NULL,
  `cara_bayar` enum('Tunai','Kredit') NOT NULL,
  `status_bayar` enum('Lunas','Hutang') NOT NULL,
  `tgl_jatuh_tempo` date NOT NULL,
  `uang_bayar` int(12) NOT NULL,
  `kd_user` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`no_penjualan`, `tgl_penjualan`, `keterangan`, `kd_pelanggan`, `cara_bayar`, `status_bayar`, `tgl_jatuh_tempo`, `uang_bayar`, `kd_user`) VALUES
('JL00001', '2015-09-18', 'Penjualan Ritel', 'P002', 'Tunai', 'Lunas', '0000-00-00', 1050000, 'U01'),
('JL00002', '2015-09-18', 'Penjualan Kredit', 'P003', 'Kredit', 'Lunas', '2015-09-22', 200000, 'U01');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_item`
--

CREATE TABLE `penjualan_item` (
  `no_penjualan` char(7) NOT NULL,
  `kd_barang` char(7) NOT NULL,
  `harga_modal` int(12) NOT NULL,
  `harga_jual` int(12) NOT NULL,
  `jumlah` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan_item`
--

INSERT INTO `penjualan_item` (`no_penjualan`, `kd_barang`, `harga_modal`, `harga_jual`, `jumlah`) VALUES
('JL00001', 'B000001', 350000, 470000, 1),
('JL00001', 'B000002', 500000, 580000, 1),
('JL00002', 'B000001', 350000, 520000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `returbeli`
--

CREATE TABLE `returbeli` (
  `no_returbeli` char(7) NOT NULL,
  `tgl_returbeli` date NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_supplier` char(4) NOT NULL,
  `kd_user` char(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `returbeli_item`
--

CREATE TABLE `returbeli_item` (
  `no_returbeli` char(7) NOT NULL,
  `kd_barang` char(7) NOT NULL,
  `jumlah` int(3) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `returjual`
--

CREATE TABLE `returjual` (
  `no_returjual` char(7) NOT NULL,
  `tgl_returjual` date NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_pelanggan` char(4) NOT NULL,
  `kd_user` char(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `returjual_item`
--

CREATE TABLE `returjual_item` (
  `no_returjual` char(7) NOT NULL,
  `kd_barang` char(7) NOT NULL,
  `jumlah` int(3) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `kd_sales` char(4) NOT NULL,
  `nm_sales` varchar(100) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `level_harga` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `kd_supplier` char(4) NOT NULL,
  `nm_supplier` varchar(100) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `no_telepon` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`kd_supplier`, `nm_supplier`, `alamat`, `no_telepon`) VALUES
('S001', 'PT. SUPPLIER 1', 'Jl. Pleret, Blok O, Yogyakarta', '0274-561881'),
('S002', 'PT. SUPPLIER 2', 'Jl. Wates, Km 123, Yogyakarta', '0274-561881'),
('S003', 'PT. ASTRINDO INDONESIA', 'Yogyakarta', '08192345'),
('S004', 'PT. LG INOVATION INDONESIA', 'Jl. Gejayan, Yogyakarta', '08192222222');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_pembelian`
--

CREATE TABLE `tmp_pembelian` (
  `id` int(3) NOT NULL,
  `kd_supplier` char(4) NOT NULL,
  `kd_barang` char(7) NOT NULL,
  `harga` int(12) NOT NULL,
  `jumlah` int(3) NOT NULL,
  `kd_user` char(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_penjualan`
--

CREATE TABLE `tmp_penjualan` (
  `id` int(10) NOT NULL,
  `kd_pelanggan` char(4) NOT NULL,
  `kd_barang` char(7) NOT NULL,
  `harga` int(12) NOT NULL,
  `jumlah` int(4) NOT NULL,
  `kd_user` char(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_returbeli`
--

CREATE TABLE `tmp_returbeli` (
  `id` int(3) NOT NULL,
  `kd_supplier` char(4) NOT NULL,
  `kd_barang` char(7) NOT NULL,
  `jumlah` int(3) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_user` char(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_returjual`
--

CREATE TABLE `tmp_returjual` (
  `id` int(3) NOT NULL,
  `kd_pelanggan` char(4) NOT NULL,
  `kd_barang` char(7) NOT NULL,
  `jumlah` int(3) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_user` char(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `kd_user` char(3) NOT NULL,
  `nm_user` varchar(100) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `level` enum('Kasir','Gudang','Admin') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`kd_user`, `nm_user`, `no_telepon`, `username`, `password`, `level`) VALUES
('U01', 'Bunafit Nugroho', '081922223333', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin'),
('U02', 'Fitria Prasetya', '08191111111', 'fitria', 'ef208a5dfcfc3ea9941d7a6c43841784', 'Kasir'),
('U03', 'Septi Suhesti', '', 'septi', 'd58d8a16aa666d48fbcc30bd3217fb17', 'Kasir');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kd_barang`),
  ADD UNIQUE KEY `kd_buku` (`kd_barang`);

--
-- Indexes for table `hak_akses`
--
ALTER TABLE `hak_akses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`kd_jenis`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kd_kategori`);

--
-- Indexes for table `merek`
--
ALTER TABLE `merek`
  ADD PRIMARY KEY (`kd_merek`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`kd_pelanggan`);

--
-- Indexes for table `pembayaran_beli`
--
ALTER TABLE `pembayaran_beli`
  ADD PRIMARY KEY (`no_pembayaran_beli`);

--
-- Indexes for table `pembayaran_jual`
--
ALTER TABLE `pembayaran_jual`
  ADD PRIMARY KEY (`no_pembayaran_jual`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`no_pembelian`),
  ADD KEY `kd_supplier` (`kd_supplier`);

--
-- Indexes for table `pembelian_item`
--
ALTER TABLE `pembelian_item`
  ADD KEY `no_pembelian` (`no_pembelian`,`kd_barang`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`no_penjualan`);

--
-- Indexes for table `penjualan_item`
--
ALTER TABLE `penjualan_item`
  ADD KEY `nomor_penjualan_tamu` (`no_penjualan`,`kd_barang`);

--
-- Indexes for table `returbeli`
--
ALTER TABLE `returbeli`
  ADD PRIMARY KEY (`no_returbeli`),
  ADD KEY `kd_supplier` (`kd_supplier`);

--
-- Indexes for table `returbeli_item`
--
ALTER TABLE `returbeli_item`
  ADD KEY `no_pembelian` (`no_returbeli`,`kd_barang`);

--
-- Indexes for table `returjual`
--
ALTER TABLE `returjual`
  ADD PRIMARY KEY (`no_returjual`),
  ADD KEY `kd_supplier` (`kd_pelanggan`);

--
-- Indexes for table `returjual_item`
--
ALTER TABLE `returjual_item`
  ADD KEY `no_pembelian` (`no_returjual`,`kd_barang`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`kd_sales`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`kd_supplier`);

--
-- Indexes for table `tmp_pembelian`
--
ALTER TABLE `tmp_pembelian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_penjualan`
--
ALTER TABLE `tmp_penjualan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_returbeli`
--
ALTER TABLE `tmp_returbeli`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_returjual`
--
ALTER TABLE `tmp_returjual`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`kd_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hak_akses`
--
ALTER TABLE `hak_akses`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tmp_pembelian`
--
ALTER TABLE `tmp_pembelian`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tmp_penjualan`
--
ALTER TABLE `tmp_penjualan`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `tmp_returbeli`
--
ALTER TABLE `tmp_returbeli`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `tmp_returjual`
--
ALTER TABLE `tmp_returjual`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
