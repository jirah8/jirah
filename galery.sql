-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2024 at 05:47 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `galery`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `album_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`album_id`, `user_id`, `title`, `description`, `created_at`) VALUES
(69, 12369, 'Air Terjun', 'Air terjun adalah formasi geologi dari arus air yang mengalir melalui suatu formasi bebatuan yang mengalami erosi dan jatuh ke bawah dari ketinggian. Dan ini beberapa keindahan Air terjun yang ada di indonesia.', '2024-03-04 22:40:36'),
(72, 12369, 'Gunung', 'Gunung adalah suatu bentuk permukaan tanah yang letaknya jauh lebih tinggi daripada tanah-tanah di daerah sekitarnya. Ini beberapa keindahan Gunung yang ada di Indonesia', '2024-03-04 11:03:23'),
(75, 12371, 'Sunset', 'Sunset merupakan salah satu fenomena atau proses tenggelam nya matahari.', '2024-03-05 03:54:09'),
(76, 12372, 'Jenis Bunga', 'Bunga adalah bagian dari tanaman yang umumnya berpenampilan indah dan mengeluarkan aroma wangi.', '2024-03-05 04:16:06'),
(77, 12373, 'Pantai', 'Daerah pantai menjadi batas antara daratan dan perairan laut. Kawasan pantai berbeda dengan pesisir walaupun antara keduanya saling berkaitan.', '2024-03-05 04:33:21'),
(78, 12374, 'Bali', 'Bali adalah pulau yang sangat indah dengan panjang garis pantai sekitar 633,35 km.', '2024-03-05 04:45:11'),
(79, 12371, 'Madinah', 'Madinah menjadi kota terpenting bagi Rasulullah selain Kota Mekkah.', '2024-03-05 05:32:27');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comments_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comments_id`, `user_id`, `photo_id`, `comment_text`, `created_at`) VALUES
(71, 12371, 100, 'jelek', '2024-03-04 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `laporan_id` int(11) NOT NULL,
  `isi` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `foto_id` int(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`like_id`, `user_id`, `photo_id`, `created_at`) VALUES
(7, 11, 30, '2024-02-08 17:00:00'),
(8, 11, 30, '2024-02-08 17:00:00'),
(9, 11, 30, '2024-02-08 17:00:00'),
(10, 17, 30, '2024-02-09 17:00:00'),
(11, 11, 30, '2024-02-09 17:00:00'),
(12, 11, 30, '2024-02-09 17:00:00'),
(13, 11, 30, '2024-02-09 17:00:00'),
(14, 11, 30, '2024-02-11 17:00:00'),
(15, 12, 30, '2024-02-11 17:00:00'),
(16, 17, 30, '2024-02-11 17:00:00'),
(17, 11, 30, '2024-02-11 17:00:00'),
(18, 11, 30, '2024-02-11 17:00:00'),
(19, 12, 30, '2024-02-11 17:00:00'),
(20, 17, 30, '2024-02-11 17:00:00'),
(21, 18, 30, '2024-02-11 17:00:00'),
(22, 11, 30, '2024-02-11 17:00:00'),
(23, 12, 30, '2024-02-11 17:00:00'),
(24, 11, 30, '2024-02-11 17:00:00'),
(25, 11, 30, '2024-02-11 17:00:00'),
(26, 11, 30, '2024-02-11 17:00:00'),
(30, 30, 17, '2024-02-11 17:00:00'),
(31, 30, 18, '2024-02-11 17:00:00'),
(38, 30, 19, '2024-02-14 17:00:00'),
(39, 2, 19, '2024-02-14 17:00:00'),
(40, 30, 11, '2024-02-14 17:00:00'),
(41, 2, 12, '2024-02-15 17:00:00'),
(42, 2, 20, '2024-02-15 17:00:00'),
(44, 30, 20, '2024-02-15 17:00:00'),
(47, 2, 26, '2024-02-17 17:00:00'),
(57, 2, 25, '2024-02-17 17:00:00'),
(59, 2, 21, '2024-02-18 17:00:00'),
(60, 30, 12, '2024-02-18 17:00:00'),
(62, 30, 21, '2024-02-18 17:00:00'),
(63, 30, 34, '2024-02-18 17:00:00'),
(64, 30, 25, '2024-02-18 17:00:00'),
(65, 30, 26, '2024-02-18 17:00:00'),
(72, 12347, 40, '2024-02-19 17:00:00'),
(73, 12347, 42, '2024-02-19 17:00:00'),
(74, 12347, 44, '2024-02-19 17:00:00'),
(75, 12347, 45, '2024-02-19 17:00:00'),
(76, 12347, 21, '2024-02-19 17:00:00'),
(77, 12347, 25, '2024-02-19 17:00:00'),
(78, 12347, 26, '2024-02-19 17:00:00'),
(82, 12347, 60, '2024-02-19 17:00:00'),
(83, 12347, 61, '2024-02-19 17:00:00'),
(84, 12347, 62, '2024-02-19 17:00:00'),
(86, 12347, 63, '2024-02-19 17:00:00'),
(87, 12347, 64, '2024-02-19 17:00:00'),
(88, 12347, 65, '2024-02-19 17:00:00'),
(96, 2, 60, '2024-02-19 17:00:00'),
(98, 2, 68, '2024-02-19 17:00:00'),
(99, 2, 69, '2024-02-19 17:00:00'),
(100, 12347, 69, '2024-02-19 17:00:00'),
(103, 12347, 73, '2024-02-19 17:00:00'),
(105, 2, 76, '2024-02-19 17:00:00'),
(108, 12347, 79, '2024-02-19 17:00:00'),
(112, 12347, 72, '2024-02-20 17:00:00'),
(117, 12347, 70, '2024-02-27 17:00:00'),
(118, 12347, 88, '2024-02-28 17:00:00'),
(123, 12369, 94, '2024-03-03 17:00:00'),
(141, 12369, 96, '2024-03-03 17:00:00'),
(142, 12369, 80, '2024-03-03 17:00:00'),
(143, 2, 80, '2024-03-03 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `photo_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `album_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`photo_id`, `user_id`, `title`, `description`, `image_path`, `created_at`, `album_id`) VALUES
(100, 12369, 'Air Terjun Lapopu ', 'Lokasi air terjun Lapopu berada di Taman Nasional Menupeu Tanah Daru dan Laiwangi Wanggameti (ManaLawa) di Pulau Sumba, tepatnya Manurara, Katikutana Selatan, Sumba, Nusa Tenggara Timur.', '967917448-air_terjun1.jpeg', '2024-03-04 03:33:47', 69),
(101, 12369, 'Air Terjun Tumpak Sewu', 'Air terjun ini berada di lumajang, Jawa Timur', '1303324148-air_terjun7.jpg', '2024-03-04 03:39:20', 69),
(102, 12369, 'Air terjun', 'Air terjun ini termasuk kebagian air terjun terindah', '786861942-air_terjun7.webp', '2024-03-04 03:46:44', 69),
(103, 12369, 'Air Terjun', 'Keindahan air terjun ini menunjukan ke asrian alam yang sangat indah', '610810008-air_terjun4.webp', '2024-03-04 03:48:43', 69),
(104, 12369, 'Air Terjun', 'Keasrian Air terjun akan selalu terlihat indah apabila masyarakat lingkungan sekitar mampu melestarikannya ', '1834722528-air_terjun6.jpg', '2024-03-04 03:51:58', 69),
(105, 12369, 'Air Terjun', 'Air terjun ini bagian dari keindahan alam yang perlu dilestarikan', '620111762-air_terjun5.jpg', '2024-03-04 03:56:54', 69),
(107, 12369, 'Gunung Rinjani', 'Tidak diherankan lagi jika penggemar trekking ingin mengunjungi gunung rinjani.', '1067922178-gunung_rinjani5.jpg', '2024-03-05 14:48:49', 72),
(108, 12369, 'Gunung', 'Gunung juga bagian dari keindahan alam', '1700302897-gunung6.webp', '2024-03-04 04:09:57', 72),
(109, 12369, 'gunung', 'Gunung juga bagian dari keindahan alam', '1012707950-gunung4.avif', '2024-03-04 04:11:10', 72),
(110, 12369, 'Gunung', 'Gunung juga termasuk bagian dari keindahan alam', '908119659-gunung3.jpg', '2024-03-04 04:12:00', 72),
(111, 12369, 'Gunung', 'Gunung juga bagian dari keindahan alam', '805700407-gunung2.jpg', '2024-03-04 04:13:13', 72),
(123, 12369, 'Gunung', 'Gunung juga bagian dari keindahan alam.', '1017815013-gunung1.webp', '2024-03-04 20:52:46', 72),
(124, 12371, 'Sunset', 'Tidak heran jika sunset banyak digemari orang karena keindahannya.', '541125687-sunset5.webp', '2024-03-04 20:55:29', 75),
(125, 12371, 'Sunset', 'Sunset juga bagian dari keindahan alam ', '1949629685-sunset6.jpg', '2024-03-04 20:56:26', 75),
(126, 12371, 'Sunset', 'Fenomena alam yang satu ini sangat banyak digemari orang orang', '161695798-sunset2.jpg', '2024-03-04 20:57:07', 75),
(127, 12371, 'Sunset', 'sunset (senja) keindahan alam yang banyak digemari orang orang.', '1386349615-sunset4.jpg', '2024-03-04 20:58:15', 75),
(128, 12371, 'Sunset', 'Sunset adalah fenomena alam yang sangat indah.', '445139739-sunset1.jpg', '2024-03-04 20:58:46', 75),
(129, 12371, 'Sunset', 'Salah satu fenomena alam yang mampu digemari banyak orang karena keindahannya.', '239471107-sunset3.jpg', '2024-03-04 21:02:09', 75),
(130, 12372, 'Bunga Tulip', 'Bunga tulip adalah kelopak bunganya yang terbuka dengan bentuk simetris yang indah.', '1522873117-bunga1.jpg', '2024-03-04 21:17:15', 76),
(131, 12372, 'Bunga daisy', 'Bunga daisy adalah bunga yang berasal dari Tiongkok dan sering dijadikan sebagai hiasan dekorasi.', '348509602-bunga2.jpg', '2024-03-04 21:18:26', 76),
(132, 12372, 'Bunga mawar', 'Mawar adalah tanaman semak berduri yang tingginya dapat mencapai 2 hingga 5 meter.', '1934686582-bunga3.jpg', '2024-03-04 21:19:16', 76),
(133, 12372, 'Bunga Mawar', 'Bunga mawar yang satu ini berwarna merah muda.', '813031412-bunga5.jpg', '2024-03-04 21:20:04', 76),
(134, 12372, 'Bunga Sakura', 'Sakura adalah sebutan untuk bunga yang tumbuh dari pohon bergenus Prunus maupun subgenusnya, Cerasus. ', '525023718-bunga4.jpg', '2024-03-04 21:21:03', 76),
(135, 12372, 'Bung Lavender', 'Lavender adalah bunga berwarna ungu yang mengandung senyawa flavonoid.', '2138580707-bunga6.webp', '2024-03-04 21:24:42', 76),
(136, 12373, 'Pantai', 'Banyak wisatawan yang ingin mengunjungi pantai karena keindahannya', '1621085532-pantai2.jpg', '2024-03-04 21:34:20', 77),
(137, 12373, 'Pantai', 'Pantai juga bagian dari keindahan alam.', '1034469811-pantai1.jpg', '2024-03-04 21:35:40', 77),
(138, 12373, 'Pantai', 'Pantai adalah salah satu tempat wisata yang perlu dikunjungi.', '1457612119-pantai6.jpg', '2024-03-04 21:37:11', 77),
(139, 12373, 'Pantai', 'Pantai juga bagian dari keindahan alam.', '1581646047-pantai8.jpg', '2024-03-04 21:37:38', 77),
(140, 12373, 'Pantai', 'Pantai juga bagian dari keindahan alam.', '462637955-pantai4.png', '2024-03-04 21:38:02', 77),
(141, 12373, 'Pantai', 'Pantai juga bagian dari keindahan alam.', '1308669173-pantai9.jpg', '2024-03-04 21:38:34', 77),
(142, 12373, 'Pantai', 'Pantai juga bagian dari keindahan alam.', '2122440020-pantai5.webp', '2024-03-04 21:39:19', 77),
(143, 12373, 'Pantai', 'Pantai juga bagian dari keindahan alam.', '1765135743-pantai7.jpeg', '2024-03-04 21:39:44', 77),
(144, 12373, 'Pantai', 'Pantai juga bagian dari keindahan alam.', '183563643-pantai3.jpg', '2024-03-04 21:40:30', 77),
(145, 12374, 'Bali', 'Ini salah satu tempat wisata di bali', '2074161986-bali5.webp', '2024-03-05 15:46:10', 78),
(146, 12374, 'Bali', 'Bali menjadi kunjungan wisata yang paling banyak digemari orang orang.', '1380245745-bali1.webp', '2024-03-04 21:47:46', 78),
(147, 12374, 'Bali', 'Tidak heran banyak orang yang ingin pergi ke bali', '627525447-bali3.webp', '2024-03-04 21:48:21', 78),
(148, 12374, 'Bali', 'Tidak heran banyak orang yang ingin pergi ke bali', '317635960-bali2.jpg', '2024-03-04 21:48:55', 78),
(149, 12374, 'Bali', 'Tidak heran banyak orang yang ingin pergi ke bali', '743675350-bali6.png', '2024-03-04 21:49:16', 78),
(150, 12374, 'Bali', 'Tidak heran banyak orang yang ingin pergi ke bali', '1132762803-bali4.jpg', '2024-03-04 21:50:13', 78),
(151, 12371, 'Madinah', 'Kota Madinah juga mendapat julukan-julukan yang indah. Salah satu sebutannya adalah Madinah al-Munawwarah yang berarti terang benderang.', '191561232-madinah1.jpeg', '2024-03-05 16:34:09', 79),
(152, 12371, 'madinah', 'kota yang indah', '1902033682-madinah6.jpg', '2024-03-04 22:34:52', 79),
(153, 12371, 'Madinah', 'Keindahan kota maddinah', '1009550169-madinah3.jpeg', '2024-03-04 22:35:49', 79),
(154, 12371, 'Madinah', 'Tidak diragukan keindahan kota maidinah', '500547667-madinah5.jpg', '2024-03-04 22:36:37', 79),
(155, 12371, 'Madinah', 'Salah satu kota terindah', '1491386701-madinah4.jpg', '2024-03-04 22:37:21', 79),
(156, 12371, 'Madinah', 'Madinah indah sekali', '1555303576-madinah2.jpg', '2024-03-04 22:38:35', 79);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `acces_level` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `username`, `password`, `email`, `acces_level`, `img`, `created_at`) VALUES
(12369, 'Admin', 'Admin', '$2y$10$ThnaZmg1MwwQLNg9wM6cPuwpIAMrAJqlQdqVNgruxoq89BOqqsLNq', 'admin@gmail.com', 'admin', '', '2024-03-03 11:39:10'),
(12371, 'User1', 'User1', '$2y$10$YTaF1eFMo2oE7pjLdLyF6.lUMTd0SnPvv7m1KvqQN0fxkU/uFz/uS', 'User1@gmail.com', 'user', '', '2024-03-05 01:08:44'),
(12372, 'User2', 'User2', '$2y$10$HO1TYjhut0zdFlzryVDGAe5Lj87PpSBTf1.hbWLkR0pa2.aM9PXl2', 'User2@gmail.com', 'user', '', '2024-03-05 01:10:29'),
(12373, 'User3', 'User3', '$2y$10$JqkvlH8m4I.JHat.7A61ee5ANTf9rT.AEHOeb9fBcxUd/lCuPeKyW', 'User3@gmail.com', 'user', '', '2024-03-05 01:10:52'),
(12374, 'User4', 'User4', '$2y$10$rokD.TZV6W09QybKTqGKy.Qi/w985vgAe9bCkWumdvnmn5bbNdtbO', 'User4@gmail.com', 'user', '', '2024-03-05 01:11:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`album_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comments_id`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`laporan_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`photo_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `album_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comments_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `laporan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12375;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
