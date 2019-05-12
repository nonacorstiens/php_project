-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 11, 2019 at 09:21 PM
-- Server version: 5.6.38
-- PHP Version: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `PHPotato`
--

-- --------------------------------------------------------

--
-- Table structure for table `followUser`
--

CREATE TABLE `followUser` (
  `id` int(11) NOT NULL,
  `userIdFollower` int(11) NOT NULL,
  `userIdFollowed` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `imageName` varchar(200) NOT NULL,
  `imageDescription` varchar(255) NOT NULL,
  `userId` int(11) NOT NULL,
  `imageCrop` varchar(200) NOT NULL,
  `uploadDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` int(11) NOT NULL DEFAULT '1',
  `location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `imageName`, `imageDescription`, `userId`, `imageCrop`, `uploadDate`, `active`, `location`) VALUES
(134, 'uploads/full/5cc8798295e9b0.14623586.jpg', 'GIRL', 0, 'uploads/cropped/5cc879829b6352.79712737.jpeg', '0000-00-00 00:00:00', 1, ''),
(135, 'uploads/full/5cc879972762f5.41105183.jpg', 'TIGERS', 0, 'uploads/cropped/5cc879972e2358.17303122.jpeg', '0000-00-00 00:00:00', 1, ''),
(136, 'uploads/full/5cc879e6ee6031.14526854.jpg', 'BOY', 0, 'uploads/cropped/5cc879e7022103.69549905.jpeg', '0000-00-00 00:00:00', 1, ''),
(137, 'uploads/full/5cc879f9b92f42.77726300.jpg', 'RAIN', 0, 'uploads/cropped/5cc879f9c002f1.93152533.jpeg', '0000-00-00 00:00:00', 1, ''),
(138, 'uploads/full/5cc87a09a289c9.53260829.jpg', 'MONKEY', 0, 'uploads/cropped/5cc87a09a888f4.19640234.jpeg', '0000-00-00 00:00:00', 1, ''),
(139, 'uploads/full/5cc87a1cbc0c20.06561891.jpg', 'KIDS', 0, 'uploads/cropped/5cc87a1cc3a460.02144669.jpeg', '0000-00-00 00:00:00', 1, ''),
(140, 'uploads/full/5cc87a2adecdf0.00290091.jpg', 'SHARK', 0, 'uploads/cropped/5cc87a2ae54749.40272486.jpeg', '0000-00-00 00:00:00', 1, ''),
(141, 'uploads/full/5cc87a43916bf4.89358736.jpg', 'GIRL', 0, 'uploads/cropped/5cc87a43966c48.20816166.jpeg', '0000-00-00 00:00:00', 1, ''),
(142, 'uploads/full/5cc87a4dc7cfb5.87603407.jpg', 'SHADOW', 0, 'uploads/cropped/5cc87a4dcc2f84.33073941.jpeg', '0000-00-00 00:00:00', 1, ''),
(143, 'uploads/full/5cc87a603d04d8.90515574.jpg', 'BIRDS', 0, 'uploads/cropped/5cc87a6042c633.74303834.jpeg', '0000-00-00 00:00:00', 1, ''),
(144, 'uploads/full/5cc87a721f1bd5.77774073.jpg', 'WINGS', 0, 'uploads/cropped/5cc87a7223f0c9.48394212.jpeg', '0000-00-00 00:00:00', 1, ''),
(145, 'uploads/full/5cc8a38d750fd8.63419499.jpg', 'UMBRELLA', 0, 'uploads/cropped/5cc8a38d8141c7.74210899.jpeg', '0000-00-00 00:00:00', 1, ''),
(146, 'uploads/full/5cc8a3c6c17b28.76074555.jpg', 'BABY', 0, 'uploads/cropped/5cc8a3c6c7a0f1.55995228.jpeg', '2019-04-30 21:36:38', 1, ''),
(147, 'uploads/full/5cc8a3d998abd6.54825906.jpg', 'PAINT', 0, 'uploads/cropped/5cc8a3d9a14a82.39474651.jpeg', '2019-04-30 21:36:57', 1, ''),
(148, 'uploads/full/5cc8a3e4a8ed24.89429842.jpg', 'BLOW', 0, 'uploads/cropped/5cc8a3e4b23e23.46367205.jpeg', '2019-04-30 21:37:08', 1, ''),
(149, 'uploads/full/5cc8a3f7ca82b9.21402397.jpg', 'GEISHA', 0, 'uploads/cropped/5cc8a3f7d24570.83834392.jpeg', '2019-04-30 21:37:27', 1, ''),
(150, 'uploads/full/5cc8a402526497.86229620.jpg', 'FLOWER', 0, 'uploads/cropped/5cc8a40266d4d9.71200901.jpeg', '2019-04-30 21:37:38', 1, ''),
(151, 'uploads/full/5cc8a40cedb7b3.06529279.jpg', 'YELLOW', 0, 'uploads/cropped/5cc8a40d0752e1.65599733.jpeg', '2019-04-30 21:37:49', 1, ''),
(152, 'uploads/full/5cc8a419269886.11909876.jpg', 'SHHTT', 0, 'uploads/cropped/5cc8a4192e6208.95398671.jpeg', '2019-04-30 21:38:01', 1, ''),
(153, 'uploads/full/5cc8a4220fc0f9.29126054.jpg', 'DARK', 0, 'uploads/cropped/5cc8a422173d07.53426336.jpeg', '2019-04-30 21:38:10', 1, ''),
(154, 'uploads/full/5cc8a42b8f34e3.94205027.jpg', 'LADY', 0, 'uploads/cropped/5cc8a42b96b5f6.80959235.jpeg', '2019-04-30 21:38:19', 1, ''),
(155, 'uploads/full/5cc8a43a812d06.27177421.jpg', 'COLOR', 0, 'uploads/cropped/5cc8a43a89a1a7.05695043.jpeg', '2019-04-30 21:38:34', 1, ''),
(157, 'uploads/full/5ccabe533626c8.21190996.jpg', 'TEST', 0, 'uploads/cropped/5ccabe533e1378.85968396.jpeg', '2019-05-02 11:54:27', 1, ''),
(158, 'uploads/full/5ccabec290d401.91377113.jpg', 'BLUE', 6, 'uploads/cropped/5ccabec296f002.58732759.jpeg', '2019-05-02 11:56:18', 1, ''),
(170, 'uploads/full/5cd71ba7b37956.66855897.jpg', 'MJ', 12, 'uploads/cropped/5cd71ba7bbe1f3.87607479.jpeg', '2019-05-11 20:59:51', 1, '51.2142792,4.599961599999999');

-- --------------------------------------------------------

--
-- Table structure for table `postComment`
--

CREATE TABLE `postComment` (
  `id` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `imageId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `uploadDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `postComment`
--

INSERT INTO `postComment` (`id`, `comment`, `imageId`, `userId`, `uploadDate`) VALUES
(8, 'wow beautiful design', 155, 6, '2019-05-03 16:18:31'),
(9, 'in love <3', 155, 6, '2019-05-03 16:18:37'),
(10, 'funny', 157, 6, '2019-05-03 16:18:50'),
(11, 'hehe', 157, 6, '2019-05-03 16:18:55'),
(12, 'creepy girl...', 158, 6, '2019-05-03 16:19:05'),
(16, 'blaaaaaack', 152, 6, '2019-05-03 16:35:45'),
(17, 'hohaha', 149, 6, '2019-05-03 16:35:53'),
(18, 'nothing to see', 154, 7, '2019-05-03 16:40:04'),
(19, 'dfsgdf', 158, 6, '2019-05-05 13:49:20'),
(21, 'Flowers', 150, 6, '2019-05-09 23:33:46'),
(22, 'so pretty', 150, 6, '2019-05-09 23:33:50'),
(28, 'Hello hello', 153, 6, '2019-05-11 13:14:15'),
(29, 'No no nooo', 153, 6, '2019-05-11 13:14:19'),
(30, 'Michael Jackson', 170, 12, '2019-05-11 21:07:34'),
(31, 'Art', 170, 12, '2019-05-11 21:07:37');

-- --------------------------------------------------------

--
-- Table structure for table `postLike`
--

CREATE TABLE `postLike` (
  `id` int(11) NOT NULL,
  `imageId` int(11) NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reportedPost`
--

CREATE TABLE `reportedPost` (
  `id` int(11) NOT NULL,
  `imageId` int(11) NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reportedPost`
--

INSERT INTO `reportedPost` (`id`, `imageId`, `userId`) VALUES
(80, 158, 6),
(81, 157, 6),
(82, 155, 6),
(83, 152, 6),
(84, 149, 6),
(85, 153, 6),
(86, 154, 6),
(87, 151, 6),
(88, 150, 6);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) UNSIGNED NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profileImage` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstName`, `lastName`, `userName`, `email`, `password`, `profileImage`, `description`) VALUES
(1, 'Nona', 'Corstiens', 'nona_corstiens', 'nonacorstiens@hotmail.com', '$2y$12$hlx5mBoJJIEcqvc0T8SuTOpW5WG.FPLYVukgAAaAmmZ7hIf4DBrl.', '', ''),
(2, 'Nona', 'Corstiens', 'test', 'test', '$2y$12$tVcMTZfF/RfmLMjF9lV3MOXGhq.Z1qRjta2c3tfC4eSTssEKcx9Ae', '', ''),
(3, 'nona', 'corstiens', 'nona_corstiens', 'nonacorstiens@hotmail.com', '$2y$12$zFIG0sJf5wlBmBLVF44HFeSPXHE0qIjVcL4eU1F0fw0rmS/DmCHVe', '', ''),
(4, 'Eddy', 'Merckx', 'eddy_mercxk', 'eddy@merckx.be', '$2y$12$dk2PM4QuAtlP4FIsJNLnMOQzbLtsMgll4ng.yxHQp.7X3aC1BT.LS', '', ''),
(5, 'koen', 'lauwers', 'koen_lauwers', 'koen@lauwers.be', '$2y$12$WBREdWvx2P9qln5nDvWrP.x7eGEJDSbSBy8SkntBZJVqPuKIbscD.', '', ''),
(6, 'Nancy', 'Erken', 'nancy.erken', 'nancy@erken.be', '$2y$12$2/pFKjkKMYmr.y7JXUq8iOhQBKd/XKRo.Rhjda5.P6eZwaqFvw1x2', '', ''),
(7, 'Tom', 'Loris', 'tom.loris', 'tom@loris.be', '$2y$12$r2hlcsbgy056SlNTbaWFjePcaecTnx.C4cCkXHQLWGjU3WH/3vCvW', '', ''),
(8, 'Dirk', 'Dom', 'dirk.dom', 'dirk@dom.be', '$2y$12$QgEmuzlgHSVcWeScTd1yKulod9oFB.FkhMJQtxkz9VIT4OWSFlIUm', '', ''),
(9, 'Dirk', 'Dom', 'dirk.dom', 'dirk@dom.be', '$2y$12$RI7PIwjWDPAeVU8o95Msgu.RvSWl2syJb5SXN.espWHJ/SCyOJccC', '', ''),
(10, 'lora', 'li', 'lora.li', 'lora@li.com', '$2y$12$9Gyu32911o2cUbRuuBgcEOMSF4N7XCcBIc2WtV42acarxeXBje6Uy', '', ''),
(11, 'tom', 'dag', 'tom.dag', 'tom@dag.be', '$2y$12$wlWYv6n5p7zXAQlJhy6TOeVG.x73kQq5o.wwNcfmHxwfZgNkCGYMK', '', ''),
(12, 'Tim', 'Pim', 'TimPim', 'tim@pim.com', '$2y$12$iu05/eg7WxoIrvJpuYrWYuUD1WnhHYU.ne55WKbHUGUA55ype6EVS', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `followUser`
--
ALTER TABLE `followUser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `postComment`
--
ALTER TABLE `postComment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `postLike`
--
ALTER TABLE `postLike`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reportedPost`
--
ALTER TABLE `reportedPost`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `followUser`
--
ALTER TABLE `followUser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT for table `postComment`
--
ALTER TABLE `postComment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `postLike`
--
ALTER TABLE `postLike`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reportedPost`
--
ALTER TABLE `reportedPost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;