-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2026 at 08:07 AM
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
-- Database: `vkauppa`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `session` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `order_id`, `session`) VALUES
(1, 0, 'ptbb3pdiest5kaee70gln3uacq'),
(2, 1, 'n67ffqc7pf8rodqa6b8hsbtn3g'),
(3, 2, 'h6eg2of0kn49v3n0nte0jkca0e'),
(8, 0, 'k8aj1ea2ijgpmjc9f3ivli4qel');

-- --------------------------------------------------------

--
-- Table structure for table `cart_item`
--

CREATE TABLE `cart_item` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_item`
--

INSERT INTO `cart_item` (`id`, `cart_id`, `product_id`, `amount`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 1),
(13, 3, 1, 1),
(27, 4, 2, 1),
(29, 5, 3, 1),
(30, 6, 3, 1),
(32, 7, 4, 1),
(34, 9, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Liha'),
(2, 'Kala'),
(3, 'Viljatuotteet'),
(4, 'Marjat'),
(5, 'Juustot'),
(6, 'Muut tuotteet');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `session` varchar(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `session`, `name`, `email`, `phone`, `datetime`) VALUES
(1, 'n67ffqc7pf8rodqa6b8hsbtn3g', 'Niklas', 'niklasjurvelin@gmail.com', '4449824828234234', '2026-03-06 08:34:45'),
(2, 'h6eg2of0kn49v3n0nte0jkca0e', 'niklas', 'niklasjurvelin@gmail.com', '044928', '2026-04-14 09:37:36'),
(6, 'hf185u16oietp176p99fipdk4r', 'Niklas', 'niklasjurvelin@gmail.com', '044982743', '2026-04-17 12:56:56'),
(7, 'cb762klucn357f8hv6a7be96e5', 'Niklas', 'niklas@gmail.com', '04040404', '2026-04-20 09:04:05'),
(9, '6m7m6tmg2kin5pr50krb4rr1hb', 'Niklas', 'niklasjurvelin@gmail.com', '0308472', '2026-04-22 12:16:46');

-- --------------------------------------------------------

--
-- Table structure for table `producers`
--

CREATE TABLE `producers` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `producers`
--

INSERT INTO `producers` (`id`, `name`) VALUES
(1, 'Ellun kanat'),
(2, 'Luomuvilja Oy'),
(3, 'Sysimetsän hunajatila'),
(4, 'Vipeltäjäfarmi'),
(5, 'Valajan tuottajat'),
(6, 'Jannen mehustamo'),
(7, 'Rapalanmäen kala Oy'),
(8, 'Alkuviljan tila Ky'),
(9, 'Metsälläkävijät Osuuskunta'),
(10, 'Munkkilan mäkijuusto');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `producer_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `stock` int(11) NOT NULL,
  `unit` varchar(5) NOT NULL,
  `prize` decimal(10,2) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `producer_id`, `category_id`, `name`, `stock`, `unit`, `prize`, `description`) VALUES
(1, 5, 2, 'Rotunaudan sisäfilee', 15, 'kg', 52.00, 'Sydänmaan Highlander luomulihasta sisäfilee, n. 800g. Kilohinta.'),
(2, 5, 1, 'Rotukarjan paistisuikaleet', 13, 'kg', 46.00, 'Rotukarjan ulkofileestä tehty paistisuikale. Paketissa 1kg.'),
(3, 1, 1, 'Kalkkunan ohut schnitzel ', 57, 'kg', 4.90, 'Ohueksi moukaroidut kalkkunaleike 4kpl ja 320g paketti'),
(4, 1, 1, 'Luomu broileri', 25, 'kg', 15.50, 'Kokonainen n. 1.4kg luomubroileri'),
(5, 7, 2, 'KalaWursti', 17, 'kpl', 7.20, 'Suomalaisestä järvikalasta tuotettu makkara 240g paketti'),
(6, 7, 2, 'Kuhafilee', 28, 'kpl', 8.20, 'Kuhaa fileenä 300g paketti\r\n'),
(7, 7, 2, 'Silakkapihvi', 41, 'kpl', 5.10, 'Valmiiksi tehdyt silakkapihvit 4kpl ja 280g paketti'),
(8, 7, 2, 'Järkälesärki yrttimaustettuna', 15, 'kpl', 4.50, 'Yrttimaustettua särkeä rapsiöljyssä 250g/200g purkeissa'),
(9, 2, 3, 'Hienojauhettu Luomu \"00\" spelttijauho', 70, 'kpl', 4.00, 'Spelttijauhoa jauhettuna pizzajauhojen karkeudella 1kg'),
(10, 2, 3, 'Luomu kaurajauhoja', 45, 'kpl', 2.40, 'Gluteenittomia luomu kaurajauhoja 1kg'),
(11, 2, 3, 'Gluteeniton vehnäjauho', 67, 'kpl', 3.70, 'Yleisvehnäjauho leivontaan ja piirakoihin 1kg '),
(12, 8, 3, 'Suomalaista alkuviljaa \"kamut\"', 51, 'kpl', 3.70, 'Vatsaystävällistä jalostamatonta \"Kamut\" alkuviljaa 1kg'),
(13, 6, 4, 'Tyrnijauho', 51, 'kpl', 2.50, 'Superruokana puuroon tai jugurttiin hienoksi jauhettu tyrni 50g paketti'),
(14, 6, 6, 'Tuorepuristettu omenamehu', 31, 'kpl', 8.50, 'Tuorepuristettu mehu Lobo omenasta 3 litran hanapakkauksissa'),
(15, 9, 6, 'Metsämustikkamehu', 31, 'kpl', 11.70, 'Mustikkamehua 3 litran hanapakkauksissa'),
(16, 9, 6, 'Puolukkamehu', 30, 'kpl', 10.30, 'Puolukkamehua 3 litran hanapakkauksissa'),
(17, 5, 5, 'Valajan Brie', 50, 'kpl', 6.20, 'Ranskalaistyyppinen brie -juusto 150g kiekoissa'),
(18, 5, 5, 'Valajan Gouda', 36, 'kpl', 4.00, 'Hollantilaistyylinen mieto Gouda 250g pakkauksissa'),
(19, 10, 5, 'Luostarijuusto', 10, 'kpl', 4.00, 'Vanhan ajan kotijuustoa muistuttava tuote 200g paketti'),
(20, 10, 5, 'Munkkijuusto', 40, 'kpl', 8.80, 'Suomalainen kermajuusto 500g pakkauksissa'),
(21, 4, 6, 'Kuivatut ja suolatut heinäsirkat', 27, 'kpl', 2.40, 'Suomessa kasvatettujen heinäsirkkojen 50g herkkupussi '),
(22, 4, 6, 'Heinäsirkkasipsit', 5, 'kpl', 2.50, 'Rasvassa paistetut ja suolatut heinäsirkat 75g pussi'),
(23, 3, 6, 'Kukkaishunaja', 40, 'kpl', 5.20, 'Keski-Suomalainen keskikesän kukkaishunaja 350g paketti'),
(24, 3, 6, 'Luomu hunaja', 28, 'kpl', 4.80, 'Kiteeltä kerätty Luomu hunajan 350g'),
(25, 1, 1, 'Hunajamarinoitu rintafilee', 45, 'kg', 17.60, 'n. 700g pakkauksessa 5-6kpl hunajamarinoituja kanan rintafileitä. Kilohinta.'),
(26, 2, 3, 'Vehnäjauho', 27, 'kpl', 4.20, 'Leivontaan erittäin hyvin soveltuva, laadukas vehnäjauho 1kg paketissa'),
(27, 3, 6, 'Kesäkukkahunaja', 50, 'kpl', 4.70, 'Juokseva kesäkukkaishunaja, 500g'),
(28, 4, 6, 'Paistetut heinäsirkat', 70, 'kpl', 3.80, 'Voissa paistetut heinäsirjat, 500g uudelleenavattavassa rasiassa'),
(29, 5, 5, 'Valajan Turunmaa', 25, 'kpl', 8.90, 'Kevyt, mutta vivahdeikas kermajuusto 500g pakkauksessa'),
(30, 6, 6, 'Mansikkamehu', 47, 'kpl', 11.50, 'Todella maukas mansikkamehu 3l hanapakkauksessa'),
(31, 7, 2, 'Lasimestarin silli', 25, 'kpl', 8.30, 'Todella maukasta lasimestarin silliä 700g purkissa'),
(32, 8, 3, 'Spelttijauho', 40, 'kpl', 9.20, 'Gluteiinitinon spelttijauho 1kg paketissa'),
(33, 8, 3, 'Tattarijauho, luomu', 30, 'kg', 4.20, 'Sopii rieskojen, leipästen, piirakoiden, torttujen, kakkujen ja muiden leivonnaisten leivontaan.'),
(34, 9, 1, 'Hirvenpaisti', 20, 'kg', 17.20, 'Raakakypsytetty hirvenpaisti n. 800g paloina. Kilohinta'),
(35, 10, 5, 'Gouda', 32, 'kpl', 7.20, 'Mieto, pitkään kypsennetty gouda 500g paketissa');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `e_mail` varchar(100) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `password`, `e_mail`, `role`) VALUES
(1, 'Niklas', '$2y$10$K5TURb5jCuH0Zqm7HDRtOOwG1F10VFd3zdKbfqqBKk53TalMC4R1e', 'niklasjurvelin@gmail.com', 'user'),
(3, 'nislas', '$2y$10$ApwZa5PtmEMqttCg4YCrfuKuokXLDfbeMjpaHKJbH/7itzASyQVt.', 'niklas@gmail.com', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `producers`
--
ALTER TABLE `producers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `producers`
--
ALTER TABLE `producers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
