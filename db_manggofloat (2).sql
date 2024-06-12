-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2024 at 03:18 PM
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
-- Database: `db_manggofloat`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id_admin`, `username`, `email`, `password`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$mxz1arLcnB1QOYL7oiYyweZ/P.XM4CZSCravBRpVWe1bK5qtoTl0i');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pembelian`
--

CREATE TABLE `tbl_pembelian` (
  `id_pembelian` int(11) NOT NULL,
  `kode_transaksi` varchar(10) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total_harga` int(10) NOT NULL,
  `status_pembelian` varchar(50) DEFAULT 'Diproses',
  `status_pembayaran` varchar(20) NOT NULL,
  `tanggal_pembelian` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pembelian`
--

INSERT INTO `tbl_pembelian` (`id_pembelian`, `kode_transaksi`, `id_produk`, `id_pengguna`, `jumlah`, `total_harga`, `status_pembelian`, `status_pembayaran`, `tanggal_pembelian`) VALUES
(72, 'PJ001', 11, 9, 1, 10000, 'Diterima', 'DANA', '2024-06-11 17:00:00'),
(73, 'PJ002', 11, 9, 2, 20000, 'Sudah Dibayar', 'DANA', '2024-06-11 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengguna`
--

CREATE TABLE `tbl_pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nama_pengguna` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `ongkir` int(10) NOT NULL,
  `no_telepon` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pengguna`
--

INSERT INTO `tbl_pengguna` (`id_pengguna`, `nama_pengguna`, `email`, `password`, `alamat`, `ongkir`, `no_telepon`) VALUES
(4, 'sari1', 'sari@gmail.com', '$2y$10$Fqd0jt2NY.ypweygb7PJp..IYQLLqJYszDa79lmdvRQpKtUbnNvFK', 'Batuphat', 0, '1234567890'),
(8, 'sari', 'sari1@gmail.com', '$2y$10$Ng/AzwgSRBGHCbC6vfxIKOH2QK.QouaavWi1k1ZaiWK3MB6dR4unO', 'Cunda', 0, '082164331277'),
(9, 'budi', 'budiman1@gmail.com', '$2y$10$VQBcHfrkHZZwJUXUQNoqf.elOv2t7A86C6GLy7iI.6H7tABVVe0li', 'Simpang Len', 5000, '082165443677'),
(10, 'tia', 'tia@gmail.com', '$2y$10$ZxZwscHuKcsrpTO7rOaqvOF0B4H3hPDBsFq2NRlaR8Tq1YLQKb4JO', 'Cunda', 10000, '082165443677');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_produk`
--

CREATE TABLE `tbl_produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `gambar_produk` varchar(255) DEFAULT NULL,
  `harga_produk` int(5) NOT NULL,
  `deskripsi_produk` text DEFAULT NULL,
  `stok_produk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_produk`
--

INSERT INTO `tbl_produk` (`id_produk`, `nama_produk`, `gambar_produk`, `harga_produk`, `deskripsi_produk`, `stok_produk`) VALUES
(10, 'Jus Mangga', 'uploads/—Pngtree—mango mango juice_7199742.png', 10000, 'Jus Mangga Segar', 10),
(11, 'Jus Jeruk', 'uploads/pngwing.com (3).png', 10000, 'Jus Jeruk Segar', 10),
(12, 'Day Cream1', 'uploads/ECOMMERCE.png', 10, 'abc', 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tbl_pembelian`
--
ALTER TABLE `tbl_pembelian`
  ADD PRIMARY KEY (`id_pembelian`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_pembelian`
--
ALTER TABLE `tbl_pembelian`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_pembelian`
--
ALTER TABLE `tbl_pembelian`
  ADD CONSTRAINT `tbl_pembelian_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `tbl_produk` (`id_produk`),
  ADD CONSTRAINT `tbl_pembelian_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `tbl_pengguna` (`id_pengguna`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
