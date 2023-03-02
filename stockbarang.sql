-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Mar 2023 pada 04.42
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stockbarang`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `keluar`
--

CREATE TABLE `keluar` (
  `idkeluar` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `namabarang` varchar(50) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `penerima` varchar(25) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `keluar`
--

INSERT INTO `keluar` (`idkeluar`, `idbarang`, `namabarang`, `tanggal`, `penerima`, `qty`) VALUES
(4, 11, 'Mikrotik', '2023-02-25 14:19:04', 'Pembeli 1', 40),
(5, 8, 'Vivo Y95', '2023-02-26 02:21:48', 'Pembeli 2', 10),
(6, 12, 'Mouse Logitech', '2023-02-27 02:07:32', 'Pembeli 3', 20),
(7, 13, 'Keyboard Logitech', '2023-02-28 08:05:42', 'Pembeli 4', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `login`
--

CREATE TABLE `login` (
  `iduser` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `login`
--

INSERT INTO `login` (`iduser`, `email`, `password`) VALUES
(2, 'samirulhuda@gmail.com', '$2y$10$EeZ1sL5cUYU/D1A4RrcNY.Mvhq4IO5bBG6.iz3nSfVhbtR6eYmdKy'),
(5, 'zazuzeng@gmail.com', '$2y$10$RLtTkQ49m80DBx48U4YY/ukFbInDuYG1u4GmY5bAIhxvIUh4i5lfK'),
(6, 'admin@gmail.com', '$2y$10$FZTGk4SehD3ktA7UQjJmDelAVQ4QDR3B7eeksyLqAKMV68erHy9a2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `masuk`
--

CREATE TABLE `masuk` (
  `idmasuk` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `namabarang` varchar(50) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `keterangan` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `masuk`
--

INSERT INTO `masuk` (`idmasuk`, `idbarang`, `namabarang`, `tanggal`, `keterangan`, `qty`) VALUES
(12, 11, 'Mikrotik', '2023-02-25 14:15:52', 'Abdi', 90),
(13, 8, 'Vivo Y95', '2023-02-26 02:06:46', 'Herman', 50),
(14, 9, 'IPhone 13', '2023-02-26 02:07:13', 'Epen', 10),
(15, 14, 'Printer Epson L805', '2023-02-26 02:07:41', 'Huda', 5),
(16, 12, 'Mouse Logitech', '2023-02-26 05:59:57', 'Huda', 20),
(17, 13, 'Keyboard Logitech', '2023-02-26 06:00:11', 'Huda', 20),
(18, 13, 'Keyboard Logitech', '2023-02-26 13:57:07', 'Ilham', 30),
(19, 16, 'Asus Zenbook Pro 2', '2023-02-27 01:54:26', 'Ulin', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `idpeminjaman` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggalpinjam` timestamp NOT NULL DEFAULT current_timestamp(),
  `qty` int(11) NOT NULL,
  `peminjam` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Dipinjam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`idpeminjaman`, `idbarang`, `tanggalpinjam`, `qty`, `peminjam`, `status`) VALUES
(4, 8, '2023-02-28 07:12:07', 5, 'Abdi', 'Kembali'),
(5, 13, '2023-02-28 07:44:29', 10, 'Toko A', 'Kembali'),
(6, 16, '2023-02-28 07:49:56', 2, 'Huda', 'Kembali'),
(7, 13, '2023-02-28 08:06:05', 20, 'Warnet', 'Dipinjam');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stock`
--

CREATE TABLE `stock` (
  `idbarang` int(11) NOT NULL,
  `namabarang` varchar(25) NOT NULL,
  `deskripsi` varchar(50) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `stock`
--

INSERT INTO `stock` (`idbarang`, `namabarang`, `deskripsi`, `stock`, `image`) VALUES
(8, 'Vivo Y95', 'Smartphone', 45, '63faf4da19379.jpg'),
(9, 'IPhone 13', 'Smartphone', 10, '63faf2ff08f19.png'),
(11, 'Mikrotik', 'Router', 50, '63faf1ec6c797.jpg'),
(12, 'Mouse Logitech', 'Mouse', 0, '63faf527724ef.jpg'),
(13, 'Keyboard Logitech', 'Keyboard', 20, '63faf41440a99.jpg'),
(15, 'Printer Epson L805', 'Printer', 10, '63faf3b0a0d72.jpg'),
(16, 'Asus Zenbook Pro 2', 'Laptop', 5, '63fb2d33b811b.jpg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `keluar`
--
ALTER TABLE `keluar`
  ADD PRIMARY KEY (`idkeluar`);

--
-- Indeks untuk tabel `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`iduser`);

--
-- Indeks untuk tabel `masuk`
--
ALTER TABLE `masuk`
  ADD PRIMARY KEY (`idmasuk`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`idpeminjaman`);

--
-- Indeks untuk tabel `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`idbarang`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `keluar`
--
ALTER TABLE `keluar`
  MODIFY `idkeluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `login`
--
ALTER TABLE `login`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `masuk`
--
ALTER TABLE `masuk`
  MODIFY `idmasuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `idpeminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `stock`
--
ALTER TABLE `stock`
  MODIFY `idbarang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
