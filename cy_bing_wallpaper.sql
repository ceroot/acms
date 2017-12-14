-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2017-12-14 11:19:04
-- 服务器版本： 5.5.53
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `remark` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '中文标题（有作者）',
  `author` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT '版权作者',
  `description` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '描述',
  `oldurl` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '原url',
  `year` int(4) NOT NULL COMMENT '年',
  `month` int(2) NOT NULL COMMENT '月',
  `createtime` int(10) NOT NULL COMMENT '添加时间',
  `updatetime` int(10) NOT NULL COMMENT '修改时间',
  `country` varchar(32) CHARACTER SET utf8 NOT NULL COMMENT '国别',
  `viewcount` int(10) NOT NULL DEFAULT '0' COMMENT '浏览次数',
  `downcount` int(10) NOT NULL DEFAULT '0' COMMENT '下载次数'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='BingWallpaper图片信息表';

--
-- 转存表中的数据 `cy_bing_wallpaper`
--

INSERT INTO `cy_bing_wallpaper` (`id`, `datesign`, `oldname`, `newname`, `title`, `remark`, `author`, `description`, `oldurl`, `year`, `month`, `createtime`, `updatetime`, `country`, `viewcount`, `downcount`) VALUES
(1, 0, 'Freudenberg_ZH-CN10942614197_1366x768.jpg', 'BingWallpaper-2017-12-13.jpg', '弗罗伊登贝格镇，德国', '弗罗伊登贝格镇，德国 (© Iain Masterton/age fotostock)', '', '', 'http://cn.bing.com/az/hprichbg/rb/Freudenberg_ZH-CN10942614197_1366x768.jpg', 2017, 12, 1513149148, 0, 'CN', 0, 0),
(2, 0, 'PlutoNorthPole_ZH-CN12213356975_1366x768.jpg', 'BingWallpaper-2017-12-14.jpg', '冥王星的北极', '冥王星的北极 (© J Marshall/Alamy)', '', '', 'http://cn.bing.com/az/hprichbg/rb/PlutoNorthPole_ZH-CN12213356975_1366x768.jpg', 2017, 12, 1513217568, 0, 'CN', 0, 0);

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
