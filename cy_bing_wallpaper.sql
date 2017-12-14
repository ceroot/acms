-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2017-12-14 13:44:47
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
-- 表的结构 `cy_bing_wallpaper`
--

CREATE TABLE `cy_bing_wallpaper` (
  `id` int(10) NOT NULL COMMENT 'ID',
  `datesign` int(10) NOT NULL DEFAULT '0' COMMENT '日期标记（格式20171201）',
  `oldname` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '原名称',
  `newname` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '现在的名称',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '中文标题',
  `titlelong` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '长标题',
  `author` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT '版权作者',
  `description` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '描述',
  `item_ttl` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_attr` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_tt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_ts` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `oldurl` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '原url',
  `year` int(4) NOT NULL COMMENT '年',
  `month` int(2) NOT NULL COMMENT '月',
  `create_time` int(10) NOT NULL COMMENT '添加时间',
  `update_time` int(10) NOT NULL COMMENT '修改时间',
  `country` varchar(32) CHARACTER SET utf8 NOT NULL COMMENT '国别',
  `viewcount` int(10) NOT NULL DEFAULT '0' COMMENT '浏览次数',
  `downcount` int(10) NOT NULL DEFAULT '0' COMMENT '下载次数'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='BingWallpaper图片信息表';

--
-- 转存表中的数据 `cy_bing_wallpaper`
--

INSERT INTO `cy_bing_wallpaper` (`id`, `datesign`, `oldname`, `newname`, `title`, `titlelong`, `author`, `description`, `item_ttl`, `item_attr`, `item_tt`, `item_ts`, `oldurl`, `year`, `month`, `create_time`, `update_time`, `country`, `viewcount`, `downcount`) VALUES
(1, 20171214, 'PlutoNorthPole_ZH-CN12213356975_1366x768.jpg', 'BingWallpaper-2017-12-14.jpg', '冥王星的北极', '冥王星的北极 (© J Marshall/Alamy)', 'J Marshall/Alamy', '冥王星可能不再被认为是一个完整的行星，但它仍然是太阳系中最大的矮行星，有很多有待发现的奥秘。由于冥王星距离太阳非常远，因此科学家们对冥王星的了解相对较少，直到2015年新地平线号宇宙飞船到达它为止。这艘飞船花了5个月的时间收集了有关冥王星和它的卫星的详细信息，同时拍摄了那些构成这张合成图像的照片。', '缓慢的时间感', '探索冥王星的奥秘', '了解太阳系的奥秘', '太空秘密永远比你想象的多', 'http://cn.bing.com/az/hprichbg/rb/PlutoNorthPole_ZH-CN12213356975_1366x768.jpg', 2017, 12, 1513257700, 1513257700, 'CN', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cy_bing_wallpaper`
--
ALTER TABLE `cy_bing_wallpaper`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `cy_bing_wallpaper`
--
ALTER TABLE `cy_bing_wallpaper`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
