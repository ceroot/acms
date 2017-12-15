-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2017-12-15 09:22:53
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
-- 表的结构 `cy_bing_branch_brief`
--

CREATE TABLE `cy_bing_branch_brief` (
  `id` int(10) NOT NULL COMMENT '自增id',
  `datesign` int(10) NOT NULL DEFAULT '0' COMMENT '日期标记（格式20171201）',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `description` text NOT NULL COMMENT '描述内容',
  `create_time` int(10) NOT NULL COMMENT '增加时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='景区简洁的';

--
-- 转存表中的数据 `cy_bing_branch_brief`
--

INSERT INTO `cy_bing_branch_brief` (`id`, `datesign`, `title`, `description`, `create_time`) VALUES
(1, 20171215, '粒皮瘤海星', '粒皮瘤海星属于瘤海星科，具有5腕，体盘厚，腕粗短。体表光滑，有厚皮肤，上面密生细颗粒，沒有疣或棘。皮鳃区局限于背面，体盘中心的皮鳃围成一圈，呈辐射状。它们在生活时，全体为肉红色，皮鳃区呈较深的棕色。分布于菲律宾、印尼、西沙群岛、台湾南部、日本南部，栖息于水深8-15公尺的珊瑚礁区。', 1513329629),
(2, 20171215, '飞白枫海星', '飞白枫海星属于飞白枫海星科，因为外型好像一片掉落在海底的枫叶而得名。台湾附近目前仅见于澎湖的潮间带。外观似槭海星，但盘中央有明显的肛门，管足有发达的吸盘。反口面有黑褐色花纹。它们主要栖息在泥沙混合的潮间带低潮线附近，雄性在生殖季节有交错压叠在其它个体上的特殊行为。', 1513329629),
(3, 20171215, '棘冠海星', '棘冠海星又名魔鬼海星，其触手有六只或八只，表层上有棘刺。它们生活在浅海等有珊瑚礁的水域，主要食物为珊瑚，偶尔也会以甲壳类或海参为食。它们的毒棘有毒胞，是神经毒素。常有潜水夫或是浮潜客，甚至是渔民不慎碰到而中毒。成龄的棘冠海星几乎没有天敌，除了大法螺之外。', 1513329629),
(4, 20171215, '正海星', '正海星的直径可达15厘米，而且颜色多种，有浅红褐色、蓝色、白色或黄色，身上带有深褐色的肉突。主要生活在印度洋大约2米深的浅水潮汐地区。因为其生活在潮汐地区，对盐度的迅速变化有一定忍受力，新手饲养起来也比较容易。可以与性情温和的鱼混养，但不适合与珊瑚放在一起。', 1513329629);

-- --------------------------------------------------------

--
-- 表的结构 `cy_bing_branch_details`
--

CREATE TABLE `cy_bing_branch_details` (
  `id` int(10) NOT NULL COMMENT '自增id',
  `datesign` int(10) NOT NULL DEFAULT '0' COMMENT '日期标记（格式20171201）',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `content` text NOT NULL COMMENT '描述内容',
  `img` varchar(255) NOT NULL COMMENT '图片路径',
  `imgold` varchar(255) NOT NULL COMMENT '原图片路径',
  `create_time` int(10) NOT NULL COMMENT '增加时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='景区简洁的';

--
-- 转存表中的数据 `cy_bing_branch_details`
--

INSERT INTO `cy_bing_branch_details` (`id`, `datesign`, `title`, `description`, `content`, `img`, `imgold`, `create_time`) VALUES
(1, 20171215, '蓝指海星', '蓝指海星也叫蓝海星，生活在珊瑚礁及珊瑚礁边缘的阳光充足地区。身体呈亮蓝色，有时带有红色或紫色斑块。它们很喜欢生活在光照充足的沙底或碎珊瑚底的水族箱，有很多岩石藏身处。它们通常单独生活，但可以容纳其它海星和对它没威胁的鱼。在自然界，蓝指海星身体的任何部分掉落都可产生新的下一代。', '', '0d7853984ee7da9f9eed2c06a916359a.jpg', 'http://s2.cn.bing.net/th?id=OJ.hvdkMP0tg2ANgg&pid=MSNJVFeeds', 1513329629),
(2, 20171215, '面包海星', '面包海星又称馒头海星，是属于瘤星科的一种海星。一般为5只腕足，但腕足特别粗短，区分不明显，与体盘连成一团，形如超大型的波罗面包或前一阵子风行一时的巨蛋面包。个体的颜色变异颇大，但主要为红、褐色系，体表上会有许多末端为黄色的小突起。主要以珊瑚虫的活组织为食，因此在珊瑚礁区才有分布。', '', '64e4c6bb0e8f57b7bb8def4b8a9d8e40.jpg', 'http://s.cn.bing.net/th?id=OJ.ADnLvhhV0wJEoQ&pid=MSNJVFeeds', 1513329629);

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
(1, 20171215, 'SeychellesCCSS_ZH-CN9574865698_1366x768.jpg', 'SeychellesCCSS_ZH-CN9574865698.jpg', '塞舌尔群岛附近软珊瑚树中的一颗薄荷海星，塞舌尔', '塞舌尔群岛附近软珊瑚树中的一颗薄荷海星，塞舌尔 (© Norbert Wu/Minden Pictures)', 'Norbert Wu/Minden Pictures', '这种色彩斑斓的海洋生物是在印度洋和南太平洋的软珊瑚床中发现的。它们通常被称为“瓦海星”或“项链海星”。这些名字指的是海星的皮肤的图案和颜色，因为它们并不总是红色和白色的。但潜水员们通常把一些被发现的红色和白色的海星标本称为薄荷海星。不过我们很确定那些海星不喜欢糖果的味道。', '会再生的“星鱼”', '塞舌尔，塞舌尔群岛', '无脊椎的肉食性动物', '浑身都是棘皮的海洋动物', 'http://cn.bing.com/az/hprichbg/rb/SeychellesCCSS_ZH-CN9574865698_1366x768.jpg', 2017, 12, 1513329628, 1513329628, 'CN', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cy_bing_branch_brief`
--
ALTER TABLE `cy_bing_branch_brief`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cy_bing_branch_details`
--
ALTER TABLE `cy_bing_branch_details`
  ADD PRIMARY KEY (`id`);

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
-- 使用表AUTO_INCREMENT `cy_bing_branch_brief`
--
ALTER TABLE `cy_bing_branch_brief`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增id', AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `cy_bing_branch_details`
--
ALTER TABLE `cy_bing_branch_details`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增id', AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `cy_bing_wallpaper`
--
ALTER TABLE `cy_bing_wallpaper`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
