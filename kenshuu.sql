-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2014 年 10 月 21 日 17:00
-- サーバのバージョン： 5.5.40-log
-- PHP Version: 5.4.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kenshuu`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `tweet`
--

CREATE TABLE IF NOT EXISTS `tweet` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tweet` varchar(160) NOT NULL,
  `post_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=259 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `tweet`
--

INSERT INTO `tweet` (`id`, `user_id`, `tweet`, `post_time`) VALUES
(248, 15, 'ツイート１', '2014-10-18 05:10:24'),
(249, 15, 'ツイート２', '2014-10-21 05:10:40'),
(250, 15, 'ツイート３', '2014-10-21 05:10:51'),
(251, 15, 'ツイート４', '2014-10-21 05:36:19'),
(252, 15, 'ツイート５', '2014-10-21 05:54:27'),
(253, 15, 'ツイート６', '2014-10-21 05:56:07'),
(254, 15, 'ツイート７', '2014-10-21 05:58:51'),
(255, 15, 'ツイート７', '2014-10-21 06:00:56'),
(256, 15, 'ツイート８', '2014-10-21 06:05:11'),
(257, 15, 'ツイート９', '2014-10-21 06:22:55'),
(258, 15, 'ツイート１０', '2014-10-21 06:24:58');

-- --------------------------------------------------------

--
-- テーブルの構造 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `password` varchar(300) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `email`) VALUES
(15, 'チャン・アイン・タイ', 'e10adc3949ba59abbe56e057f20f883e', 'thai@email.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tweet`
--
ALTER TABLE `tweet`
 ADD PRIMARY KEY (`id`), ADD KEY `frk1` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`), ADD KEY `name` (`name`(255));

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tweet`
--
ALTER TABLE `tweet`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=259;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `tweet`
--
ALTER TABLE `tweet`
ADD CONSTRAINT `frk1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
