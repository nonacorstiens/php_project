-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 02, 2019 at 10:36 AM
-- Server version: 5.6.38
-- PHP Version: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: PHPotato
--

-- --------------------------------------------------------

--
-- Table structure for table followUser
--


-- --------------------------------------------------------

--
-- Table structure for table post
--

CREATE TABLE post (
  id int(11) NOT NULL,
  imageName varchar(200) NOT NULL,
  imageDescription varchar(255) NOT NULL,
  user-id int(11) NOT NULL,
  imageCrop varchar(200) NOT NULL,
  uploadDate datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  location varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table post
--

INSERT INTO post (id, imageName, imageDescription, user-id, imageCrop, uploadDate, location) VALUES
(134, 'uploads/full/5cc8798295e9b0.14623586.jpg', 'GIRL', 0, 'uploads/cropped/5cc879829b6352.79712737.jpeg', '0000-00-00 00:00:00', ''),
(135, 'uploads/full/5cc879972762f5.41105183.jpg', 'TIGERS', 0, 'uploads/cropped/5cc879972e2358.17303122.jpeg', '0000-00-00 00:00:00', ''),
(136, 'uploads/full/5cc879e6ee6031.14526854.jpg', 'BOY', 0, 'uploads/cropped/5cc879e7022103.69549905.jpeg', '0000-00-00 00:00:00', ''),
(137, 'uploads/full/5cc879f9b92f42.77726300.jpg', 'RAIN', 0, 'uploads/cropped/5cc879f9c002f1.93152533.jpeg', '0000-00-00 00:00:00', ''),
(138, 'uploads/full/5cc87a09a289c9.53260829.jpg', 'MONKEY', 0, 'uploads/cropped/5cc87a09a888f4.19640234.jpeg', '0000-00-00 00:00:00', ''),
(139, 'uploads/full/5cc87a1cbc0c20.06561891.jpg', 'KIDS', 0, 'uploads/cropped/5cc87a1cc3a460.02144669.jpeg', '0000-00-00 00:00:00', ''),
(140, 'uploads/full/5cc87a2adecdf0.00290091.jpg', 'SHARK', 0, 'uploads/cropped/5cc87a2ae54749.40272486.jpeg', '0000-00-00 00:00:00', ''),
(141, 'uploads/full/5cc87a43916bf4.89358736.jpg', 'GIRL', 0, 'uploads/cropped/5cc87a43966c48.20816166.jpeg', '0000-00-00 00:00:00', ''),
(142, 'uploads/full/5cc87a4dc7cfb5.87603407.jpg', 'SHADOW', 0, 'uploads/cropped/5cc87a4dcc2f84.33073941.jpeg', '0000-00-00 00:00:00', ''),
(143, 'uploads/full/5cc87a603d04d8.90515574.jpg', 'BIRDS', 0, 'uploads/cropped/5cc87a6042c633.74303834.jpeg', '0000-00-00 00:00:00', ''),
(144, 'uploads/full/5cc87a721f1bd5.77774073.jpg', 'WINGS', 0, 'uploads/cropped/5cc87a7223f0c9.48394212.jpeg', '0000-00-00 00:00:00', ''),
(145, 'uploads/full/5cc8a38d750fd8.63419499.jpg', 'UMBRELLA', 0, 'uploads/cropped/5cc8a38d8141c7.74210899.jpeg', '0000-00-00 00:00:00', ''),
(146, 'uploads/full/5cc8a3c6c17b28.76074555.jpg', 'BABY', 0, 'uploads/cropped/5cc8a3c6c7a0f1.55995228.jpeg', '2019-04-30 21:36:38', ''),
(147, 'uploads/full/5cc8a3d998abd6.54825906.jpg', 'PAINT', 0, 'uploads/cropped/5cc8a3d9a14a82.39474651.jpeg', '2019-04-30 21:36:57', ''),
(148, 'uploads/full/5cc8a3e4a8ed24.89429842.jpg', 'BLOW', 0, 'uploads/cropped/5cc8a3e4b23e23.46367205.jpeg', '2019-04-30 21:37:08', ''),
(149, 'uploads/full/5cc8a3f7ca82b9.21402397.jpg', 'GEISHA', 0, 'uploads/cropped/5cc8a3f7d24570.83834392.jpeg', '2019-04-30 21:37:27', ''),
(150, 'uploads/full/5cc8a402526497.86229620.jpg', 'FLOWER', 0, 'uploads/cropped/5cc8a40266d4d9.71200901.jpeg', '2019-04-30 21:37:38', ''),
(151, 'uploads/full/5cc8a40cedb7b3.06529279.jpg', 'YELLOW', 0, 'uploads/cropped/5cc8a40d0752e1.65599733.jpeg', '2019-04-30 21:37:49', ''),
(152, 'uploads/full/5cc8a419269886.11909876.jpg', 'SHHTT', 0, 'uploads/cropped/5cc8a4192e6208.95398671.jpeg', '2019-04-30 21:38:01', ''),
(153, 'uploads/full/5cc8a4220fc0f9.29126054.jpg', 'DARK', 0, 'uploads/cropped/5cc8a422173d07.53426336.jpeg', '2019-04-30 21:38:10', ''),
(154, 'uploads/full/5cc8a42b8f34e3.94205027.jpg', 'LADY', 0, 'uploads/cropped/5cc8a42b96b5f6.80959235.jpeg', '2019-04-30 21:38:19', ''),
(155, 'uploads/full/5cc8a43a812d06.27177421.jpg', 'COLOR', 0, 'uploads/cropped/5cc8a43a89a1a7.05695043.jpeg', '2019-04-30 21:38:34', '');

-- --------------------------------------------------------

--
-- Table structure for table postComment
--

CREATE TABLE postComment (
  id int(11) NOT NULL,
  comment varchar(255) NOT NULL,
  picture-id int(11) NOT NULL,
  user-id int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table postLike
--

CREATE TABLE postLike (
  id int(11) NOT NULL,
  picture-id int(11) NOT NULL,
  user-id int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table user
--

CREATE TABLE user (
  id int(11) UNSIGNED NOT NULL,
  firstName varchar(255) NOT NULL,
  lastName varchar(255) NOT NULL,
  userName varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  image longblob NOT NULL,
  description varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table user
--

INSERT INTO user (id, firstName, lastName, userName, email, password, image, description) VALUES
(1, 'Nona', 'Corstiens', 'nona_corstiens', 'nonacorstiens@hotmail.com', '$2y$12$hlx5mBoJJIEcqvc0T8SuTOpW5WG.FPLYVukgAAaAmmZ7hIf4DBrl.', '', ''),
(2, 'Nona', 'Corstiens', 'test', 'test', '$2y$12$tVcMTZfF/RfmLMjF9lV3MOXGhq.Z1qRjta2c3tfC4eSTssEKcx9Ae', '', ''),
(3, 'nona', 'corstiens', 'nona_corstiens', 'nonacorstiens@hotmail.com', '$2y$12$zFIG0sJf5wlBmBLVF44HFeSPXHE0qIjVcL4eU1F0fw0rmS/DmCHVe', '', ''),
(4, 'Eddy', 'Merckx', 'eddy_mercxk', 'eddy@merckx.be', '$2y$12$dk2PM4QuAtlP4FIsJNLnMOQzbLtsMgll4ng.yxHQp.7X3aC1BT.LS', '', ''),
(5, 'koen', 'lauwers', 'koen_lauwers', 'koen@lauwers.be', '$2y$12$WBREdWvx2P9qln5nDvWrP.x7eGEJDSbSBy8SkntBZJVqPuKIbscD.', '', ''),
(6, 'Nancy', 'Erken', 'nancy.erken', 'nancy@erken.be', '$2y$12$2/pFKjkKMYmr.y7JXUq8iOhQBKd/XKRo.Rhjda5.P6eZwaqFvw1x2', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table followUser
--
ALTER TABLE followUser
  ADD PRIMARY KEY (id);

--
-- Indexes for table post
--
ALTER TABLE post
  ADD PRIMARY KEY (id);

--
-- Indexes for table postComment
--
ALTER TABLE postComment
  ADD PRIMARY KEY (id);

--
-- Indexes for table postLike
--
ALTER TABLE postLike
  ADD PRIMARY KEY (id);

--
-- Indexes for table user
--
ALTER TABLE user
  ADD PRIMARY KEY (id) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table followUser
--
ALTER TABLE followUser
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table post
--
ALTER TABLE post
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table postComment
--
ALTER TABLE postComment
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table postLike
--
ALTER TABLE postLike
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table user
--
ALTER TABLE user
  MODIFY id int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;