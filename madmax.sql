-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2019. Már 15. 20:13
-- Kiszolgáló verziója: 10.1.34-MariaDB
-- PHP verzió: 5.6.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `madmax`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `products`
--

INSERT INTO `products` (`id`, `name`, `quantity`, `description`, `price`) VALUES
(1, 'asdasd', 2, 'dfasdf', 0),
(2, 'sdasd', 3, 'adss', 0),
(3, 'gfg', 5, 'fgsfg', 0),
(4, 'asd', 4, 'adsfsdf', 0),
(5, '123', 123, '123', 0),
(6, '123', 123, 'qdas', 0),
(7, '123123', 123, 'asdas', 0),
(8, 'sad', 123, 'fdsfasd', 0),
(9, 'asdas', 234, 'fadsfd', 0),
(10, 'asd', 123, 'asdf', NULL),
(11, 'asdas', 1234, 'asfsdf', 123),
(12, 'asdasd', 123, 'dasfasdf sdaf sda', 123),
(13, 'sad', 5, 'rrrr', 6),
(14, 'asdasd', 2, 'tt', 5),
(15, 'asd', 3, 'asds', 4),
(16, 'qwe', 1111, 'asd', 111112),
(17, 'qwe', 1111, 'asd', 111112),
(18, 'aaaa', 5, 'asd', 5);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `products_images`
--

CREATE TABLE `products_images` (
  `id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED DEFAULT NULL,
  `filename` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `products_images`
--

INSERT INTO `products_images` (`id`, `product_id`, `filename`) VALUES
(1, 1, 'uploads/aaa.PNG'),
(2, 2, 'uploads/gyenge.PNG'),
(3, 3, 'uploads/WIN_20181202_19_34_40_Pro.jpg'),
(4, 4, 'uploads/WIN_20181202_19_34_40_Pro.jpg'),
(5, 5, 'uploads/WIN_20181202_19_34_41_Pro.jpg'),
(6, 6, 'uploads/WIN_20181202_19_34_14_Pro.jpg'),
(7, 7, 'uploads/WIN_20181202_19_34_14_Pro.jpg'),
(8, 8, 'uploads/WIN_20181202_19_34_41_Pro.jpg'),
(9, 9, 'uploads/WIN_20181202_19_34_41_Pro.jpg'),
(10, 10, 'uploads/WIN_20181202_19_34_41_Pro.jpg'),
(11, 11, 'uploads/WIN_20181202_19_34_41_Pro.jpg'),
(12, 12, 'uploads/WIN_20181202_19_34_14_Pro.jpg'),
(13, 13, 'uploads/product06.png'),
(14, 14, 'uploads/product04.png'),
(15, 15, 'uploads/product03.png'),
(16, 16, 'uploads/product04.png'),
(17, 17, 'uploads/product04.png'),
(18, 18, 'uploads/shop03.png');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tblproduct`
--

CREATE TABLE `tblproduct` (
  `id` int(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `price` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- A tábla adatainak kiíratása `tblproduct`
--

INSERT INTO `tblproduct` (`id`, `name`, `code`, `image`, `price`) VALUES
(1, 'FinePix Pro2 3D Camera', '3DcAM01', 'product-images/camera.jpg', 1500.00),
(2, 'EXP Portable Hard Drive', 'USB02', 'product-images/external-hard-drive.jpg', 800.00),
(3, 'Luxury Ultra thin Wrist Watch', 'wristWear03', 'product-images/watch.jpg', 300.00),
(4, 'XP 1155 Intel Core Laptop', 'LPN45', 'product-images/laptop.jpg', 800.00);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(7, 'Ezaze', '', '$2y$10$h69Rr/bkpCKlclpyUBxE.enLcMFihDx4ZJzNSDNAJOZrrDq0dOjKy'),
(8, 'users', '', '$2y$10$i2VwgAU3hjvmp2/GvfadYOSkosCIZb5nFp.PBeJzCPmJbXcGXgFSm'),
(9, 'Jeee', '', '$2y$10$ZUBI1CoYWsRGw3dxihwyD.ejEfs9U5PIdhDTc5qa2bKoeovFv4c.q'),
(10, 'ASD', '', '$2y$10$Qckf1IUBniOxshcETVxHF.E90iJD8auV0OrwgWmu2nsZH.4y9wvWe'),
(11, 'ASD1', '', '$2y$10$cSL/4MSEMlnK2QNc9RxysOnnbrK1TGfPydeS8KSlX7j/6zcoVSdZG'),
(12, 'ASD2', '', '$2y$10$XogQvJRqd7Lwn480bHF4TOuzmBrtKCb6R3zDM3avf9//dBpl.dWYa'),
(13, 'AAA', '', '$2y$10$FHX8ozDXKwq4G5ZAloAM4Onl99kLx.fyzRNqJ46VV65./mDRH.jrC'),
(14, 'Regisztr', '', '$2y$10$waxnMV3g88ezHB/KAUVVMucCWNuDJjhTcP4Y0VMaAsCe2Y2y1Z4em'),
(15, 'kakaka', '', '$2y$10$4lSRNMoqvv4oGC6jqAZEgubLCEzGDzU2ET/0Iw4MGmzmp28vI3z3C'),
(16, 'szÃ¼retibor', '', '$2y$10$wmdNFx4DFpAgA9il/25dtOpW7RQARTX7dmJj635YUY7N7RWj0CWUq'),
(17, 'asdasd2', '', '$2y$10$HYsXjxKsC9O5lVwiDrqLfO8OpDNP9WMKOrAiAA5eQoUPBfawU866G');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `products_images`
--
ALTER TABLE `products_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- A tábla indexei `tblproduct`
--
ALTER TABLE `tblproduct`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_code` (`code`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT a táblához `products_images`
--
ALTER TABLE `products_images`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT a táblához `tblproduct`
--
ALTER TABLE `tblproduct`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `products_images`
--
ALTER TABLE `products_images`
  ADD CONSTRAINT `products_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
