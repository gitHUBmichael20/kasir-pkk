-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Jan 2025 pada 11.15
-- Versi server: 8.0.30
-- Versi PHP: 8.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasirpkk`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `ID_ADMIN` varchar(20) NOT NULL,
  `USERNAME_ADMIN` varchar(50) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`ID_ADMIN`, `USERNAME_ADMIN`, `PASSWORD`) VALUES
('1', 'handika', '1ca0acf49daa83f03a8377850e4d2785a724ff62c9cff30aa4fdf9f7e9124e7c');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product`
--

CREATE TABLE `product` (
  `ID_PRODUCT` int NOT NULL,
  `NAME` varchar(100) NOT NULL,
  `STOCK` int NOT NULL,
  `PRICE` decimal(10,2) NOT NULL,
  `TYPE` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `product`
--

INSERT INTO `product` (`ID_PRODUCT`, `NAME`, `STOCK`, `PRICE`, `TYPE`, `created_at`) VALUES
(1, '⁠Snack Kriuk Putri', 30, 5000.00, 'makanan', '2025-01-13 14:43:18'),
(2, '⁠Donat Putri', 20, 4000.00, 'makanan', '2025-01-13 14:43:18'),
(3, 'Kebab Annisa', 20, 7000.00, 'makanan', '2025-01-13 14:43:18'),
(4, 'Bakso Mercon Annisa', 25, 10000.00, 'makanan', '2025-01-13 14:43:18'),
(5, 'Thai Tea Hirto', 20, 7000.00, 'minuman', '2025-01-13 14:43:18'),
(6, 'Salad Buah Hirto', 12, 15000.00, 'makanan', '2025-01-13 14:43:18'),
(7, 'Mie Roll Allisa', 20, 10000.00, 'makanan', '2025-01-13 14:43:18'),
(8, 'Sawi Gulung Allisa', 20, 12000.00, 'makanan', '2025-01-13 14:43:18'),
(9, 'Kopi Dingin Handika', 40, 5000.00, 'minuman', '2025-01-13 14:43:18'),
(10, 'Risol Handika', 40, 2500.00, 'makanan', '2025-01-13 14:43:18'),
(11, 'Molen Kenzie', 12, 5000.00, 'makanan', '2025-01-13 14:43:18'),
(12, 'Soda Gembira Kenzie', 10, 5000.00, 'minuman', '2025-01-13 14:43:18'),
(13, 'Sushi Aufa ', 20, 7000.00, 'makanan', '2025-01-13 14:43:18'),
(14, '⁠Keripik Pisang Lumer Aufa', 12, 5000.00, 'makanan', '2025-01-13 14:43:18'),
(15, 'Martabak Mie Raynaldo', 12, 7000.00, 'makanan', '2025-01-13 14:43:18'),
(16, 'Es Milo Raynaldo', 12, 5000.00, 'minuman', '2025-01-13 14:43:18'),
(17, 'Piscok Kenzie', 10, 3000.00, 'makanan', '2025-01-13 14:43:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions`
--

CREATE TABLE `transactions` (
  `id` int NOT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `payment_amount` decimal(10,2) DEFAULT NULL,
  `transaction_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaction_details`
--

CREATE TABLE `transaction_details` (
  `id` int NOT NULL,
  `transaction_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID_ADMIN`);

--
-- Indeks untuk tabel `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ID_PRODUCT`);

--
-- Indeks untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `product`
--
ALTER TABLE `product`
  MODIFY `ID_PRODUCT` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `transaction_details`
--
ALTER TABLE `transaction_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD CONSTRAINT `transaction_details_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`),
  ADD CONSTRAINT `transaction_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`ID_PRODUCT`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
