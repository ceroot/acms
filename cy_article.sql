-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2017-11-29 12:41:29
-- 服务器版本： 5.5.53
-- PHP Version: 7.0.12

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
-- 表的结构 `cy_article`
--

CREATE TABLE `cy_article` (
  `id` int(11) NOT NULL COMMENT '自增id',
  `cid` int(11) NOT NULL DEFAULT '0' COMMENT '分类id',
  `title` char(128) NOT NULL COMMENT '标题',
  `keywords` char(128) NOT NULL COMMENT '关键字',
  `description` char(255) NOT NULL COMMENT '描述',
  `content` text NOT NULL COMMENT '内容',
  `cover` char(128) NOT NULL COMMENT '封面',
  `source` char(56) NOT NULL COMMENT '来源',
  `view` int(11) NOT NULL DEFAULT '0' COMMENT '访问次数',
  `template` char(56) NOT NULL COMMENT '模板',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态，1为正常，0为禁用',
  `create_uid` int(11) NOT NULL DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `create_ip` int(11) NOT NULL DEFAULT '0' COMMENT '创建ip',
  `update_uid` int(11) NOT NULL DEFAULT '0' COMMENT '更新者id',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `update_ip` int(11) NOT NULL DEFAULT '0' COMMENT '更新ip',
  `delete_uid` int(11) NOT NULL DEFAULT '0' COMMENT '删除操作者id',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `delete_ip` int(11) NOT NULL DEFAULT '0' COMMENT '删除ip'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='内容表';

--
-- 转存表中的数据 `cy_article`
--

INSERT INTO `cy_article` (`id`, `cid`, `title`, `keywords`, `description`, `content`, `cover`, `source`, `view`, `template`, `status`, `create_uid`, `create_time`, `create_ip`, `update_uid`, `update_time`, `update_ip`, `delete_uid`, `delete_time`, `delete_ip`) VALUES
(1, 0, '这是标题', '这是关键字', '这是描述1', '这是内容', '', '', 0, '', 1, 0, 0, 0, 1, 1511944012, 2130706433, 1, 0, 2130706433),
(2, 39, '这是标题', '这是关键字', '这是描述', '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;这是内容 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>', '20171129/1511948375.jpeg', '', 0, '', 1, 0, 0, 0, 1, 1511948375, 2130706433, 0, NULL, 0),
(3, 1, 'test', '', 'test', '<p>test1111</p>', '20171129/1511948424.jpeg', '', 0, '', 1, 1, 1511944039, 2130706433, 1, 1511948425, 2130706433, 0, NULL, 0),
(4, 2, 'dddd', '', 'dddd', '<p>ddddddd<br/></p>', '20171129/1511948483.jpeg', '', 0, '', 1, 1, 1511948483, 2130706433, 0, 1511948483, 0, 0, NULL, 0),
(5, 1, 'fdsafas', '', 'fdsafds', '<p>fdsaf<br/></p>', '20171129/1511948606.jpeg', '', 0, '', 1, 1, 1511948606, 2130706433, 0, 1511948606, 0, 0, NULL, 0),
(6, 1, 'fdsafas', '', 'fdsafds', '<p>fdsaf<br/></p>', '20171129/1511948937.jpeg', '', 0, '', 1, 1, 1511948937, 2130706433, 0, 1511948937, 0, 0, NULL, 0),
(7, 1, 'fdsafas', '', 'fdsafds', '<p>fdsaf<br/></p>', '20171129/1511949012.jpeg', '', 0, '', 1, 1, 1511949012, 2130706433, 0, 1511949012, 0, 0, NULL, 0),
(8, 1, 'fdsafas', '', 'fdsafds', '<p>fdsaf<br/></p>', '20171129/1511949364.jpeg', '', 0, '', 1, 1, 1511949365, 2130706433, 0, 1511949365, 0, 0, NULL, 0),
(9, 1, 'fdsafas', '', 'fdsafds', '<p>fdsaf<br/></p>', '20171129/1511949712.jpeg', '', 0, '', 1, 1, 1511949712, 2130706433, 0, 1511949712, 0, 0, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cy_article`
--
ALTER TABLE `cy_article`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `cy_article`
--
ALTER TABLE `cy_article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id', AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
