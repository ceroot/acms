-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2017-12-14 13:44:21
-- 服务器版本： 5.5.53
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `acms`
--

-- --------------------------------------------------------

--
-- 表的结构 `cy_bing_scenic_details`
--

CREATE TABLE `cy_bing_scenic_details` (
  `id` int(10) NOT NULL COMMENT '自增id',
  `datesign` int(10) NOT NULL DEFAULT '0' COMMENT '日期标记（格式20171201）',
  `year` int(4) NOT NULL COMMENT '年',
  `month` int(2) NOT NULL COMMENT '月',
  `day` int(2) NOT NULL COMMENT '天',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `content` text NOT NULL COMMENT '描述内容',
  `img` varchar(255) NOT NULL COMMENT '图片路径',
  `imgold` varchar(255) NOT NULL COMMENT '原图片路径',
  `create_time` int(10) NOT NULL COMMENT '增加时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='景区简洁的';

--
-- 转存表中的数据 `cy_bing_scenic_details`
--

INSERT INTO `cy_bing_scenic_details` (`id`, `datesign`, `year`, `month`, `day`, `title`, `description`, `content`, `img`, `imgold`, `create_time`) VALUES
(1, 20171214, 2017, 12, 14, '土星', '土星是太阳系八大行星之一，是太阳系由内往外数的第六颗行星。土星主要由氢组成，还有少量的氦与微量元素，内部的核心包括岩石和冰，外围由数层金属氢和气体包裹着。土星的风速高达1800公里/时，明显的比木星上的风速快。土星的行星磁场强度介于地球和更强的木星之间。', '', '9017e0ab53b28028575e771cfde53adc.jpg', 'http://s.cn.bing.net/th?id=OJ.pcw12gr42c6gvg&pid=MSNJVFeeds', 1513257700),
(2, 20171214, 2017, 12, 14, '柯伊伯带', '柯伊伯带是太阳系在海王星轨道外黄道面附近、天体密集的中空圆盘状区域。柯伊伯带的假说最初是由爱尔兰裔天文学家艾吉沃斯提出，杰拉德·柯伊伯发展了该观点。如今已有约1000个柯伊伯带天体被发现。柯伊伯带有时被误认为是太阳系的边界，但太阳系还包括向外延伸两光年之远的奥尔特星云。', '', '1484c739886e8502ab3a72c2dd178745.jpg', 'http://s3.cn.bing.net/th?id=OJ.IwKaVO0ApazpnQ&pid=MSNJVFeeds', 1513257700);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cy_bing_scenic_details`
--
ALTER TABLE `cy_bing_scenic_details`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `cy_bing_scenic_details`
--
ALTER TABLE `cy_bing_scenic_details`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增id', AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
