-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2017-12-14 13:44:35
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
-- 表的结构 `cy_bing_scenic_brief`
--

CREATE TABLE `cy_bing_scenic_brief` (
  `id` int(10) NOT NULL COMMENT '自增id',
  `datesign` int(10) NOT NULL DEFAULT '0' COMMENT '日期标记（格式20171201）',
  `year` int(4) NOT NULL COMMENT '年',
  `month` int(2) NOT NULL COMMENT '月',
  `day` int(2) NOT NULL COMMENT '天',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `description` text NOT NULL COMMENT '描述内容',
  `create_time` int(10) NOT NULL COMMENT '增加时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='景区简洁的';

--
-- 转存表中的数据 `cy_bing_scenic_brief`
--

INSERT INTO `cy_bing_scenic_brief` (`id`, `datesign`, `year`, `month`, `day`, `title`, `description`, `create_time`) VALUES
(1, 20171214, 2017, 12, 14, '海王星', '海王星是八大行星中的远日行星，按照行星与太阳的距离排列海王星是第八颗行星，直径上是第四大行星，质量上是第三大行星。它的亮度仅为7.85星等，只有在天文望远镜里才能看到它。由于它那荧荧的淡蓝色光，所以西方人用罗马神话中的海神——“尼普顿”的名字来称呼它。在中文里，把它译为海王星。', 1513257700),
(2, 20171214, 2017, 12, 14, '天王星', '天王星是太阳系由内向外的第七颗行星，其体积在太阳系中排名第三，质量排名第四，几乎横躺着围绕太阳公转。天王星大气的主要成分是氢和氦，还包含较高比例的由水、氨、甲烷等结成的“冰”，但是氨和甲烷在天王星上只能以液体来存在。天王星是太阳系内大气层最冷的行星，最低温度只有-224℃。', 1513257700),
(3, 20171214, 2017, 12, 14, '木星', '木星是太阳系八大行星中体积最大、自转最快的行星，从内向外的第五颗行星。它的质量为太阳的千分之一，是太阳系中其它七大行星质量总和的2.5倍。木星与土星、天王星、海王星皆属气体行星，因此四者又合称类木行星。2012年2月3日科学家称发现了木星2颗新卫星，累计卫星达68颗。', 1513257700),
(4, 20171214, 2017, 12, 14, '火星', '火星是太阳系八大行星之一，是太阳系由内往外数的第四颗行星，属于类地行星，直径约为地球的53%，质量为地球的11%。自转轴倾角、自转周期均与地球相近，公转一周约为地球公转时间的两倍。橘红色外表是地表的赤铁矿。我国古书上将火星称为“荧惑星”，西方古代称为“战神玛尔斯星”。', 1513257700);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cy_bing_scenic_brief`
--
ALTER TABLE `cy_bing_scenic_brief`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `cy_bing_scenic_brief`
--
ALTER TABLE `cy_bing_scenic_brief`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增id', AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
