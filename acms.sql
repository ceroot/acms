-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2018-01-02 09:32:29
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
-- 表的结构 `cy_document`
--

CREATE TABLE `cy_document` (
  `id` int(11) NOT NULL COMMENT '自增id',
  `cid` int(11) NOT NULL DEFAULT '0' COMMENT '分类id',
  `title` char(128) NOT NULL COMMENT '标题',
  `keywords` char(128) NOT NULL COMMENT '关键字',
  `description` char(255) NOT NULL COMMENT '描述',
  `cover_id` int(10) NOT NULL DEFAULT '0' COMMENT '封面ID',
  `source` char(56) NOT NULL COMMENT '来源',
  `view` int(11) NOT NULL DEFAULT '0' COMMENT '访问次数',
  `bookmark` int(10) NOT NULL DEFAULT '0' COMMENT '收藏数',
  `template` char(56) NOT NULL COMMENT '模板',
  `model_id` tinyint(3) NOT NULL DEFAULT '0' COMMENT '模型ID',
  `position` smallint(5) NOT NULL DEFAULT '0' COMMENT '推荐位',
  `deadline` int(10) NOT NULL DEFAULT '0' COMMENT '截至时间',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态，1为正常，0为禁用',
  `comment` int(10) NOT NULL DEFAULT '0' COMMENT '评论数',
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
-- 转存表中的数据 `cy_document`
--

INSERT INTO `cy_document` (`id`, `cid`, `title`, `keywords`, `description`, `cover_id`, `source`, `view`, `bookmark`, `template`, `model_id`, `position`, `deadline`, `status`, `comment`, `create_uid`, `create_time`, `create_ip`, `update_uid`, `update_time`, `update_ip`, `delete_uid`, `delete_time`, `delete_ip`) VALUES
(1, 0, '这是标题', '这是关键字', '这是描述1', 0, '', 0, 0, '', 0, 0, 0, 1, 0, 0, 0, 0, 1, 1511944012, 2130706433, 1, 0, 2130706433),
(2, 39, '这是标题', '这是关键字', '这是描述', 20171129, '', 0, 0, '', 0, 0, 0, 1, 0, 0, 0, 0, 1, 1511948375, 2130706433, 0, NULL, 0),
(3, 1, 'test', '', 'test', 20171129, '', 0, 0, '', 0, 0, 0, 1, 0, 1, 1511944039, 2130706433, 1, 1511948425, 2130706433, 0, NULL, 0),
(4, 2, 'dddd', '', 'dddd', 20171129, '', 0, 0, '', 0, 0, 0, 1, 0, 1, 1511948483, 2130706433, 0, 1511948483, 0, 0, NULL, 0),
(5, 1, 'fdsafas', '', 'fdsafds', 20171129, '', 0, 0, '', 0, 0, 0, 1, 0, 1, 1511948606, 2130706433, 0, 1511948606, 0, 0, NULL, 0),
(6, 1, 'fdsafas', '', 'fdsafds', 20171129, '', 0, 0, '', 0, 0, 0, 1, 0, 1, 1511948937, 2130706433, 0, 1511948937, 0, 0, NULL, 0),
(7, 1, 'fdsafas', '', 'fdsafds', 20171129, '', 0, 0, '', 0, 0, 0, 1, 0, 1, 1511949012, 2130706433, 0, 1511949012, 0, 0, NULL, 0),
(8, 1, 'fdsafas', '', 'fdsafds', 20171129, '', 0, 0, '', 0, 0, 0, 1, 0, 1, 1511949365, 2130706433, 0, 1511949365, 0, 0, NULL, 0),
(9, 1, 'fdsafas', '', 'fdsafds', 20171129, '', 0, 0, '', 0, 0, 0, 1, 0, 1, 1511949712, 2130706433, 0, 1511949712, 0, 0, NULL, 0),
(10, 1, 'fsdafsa', '', 'fdsafsadf', 20171130, '', 0, 0, '', 0, 0, 0, 1, 0, 1, 1512005967, 2130706433, 0, 1512005967, 0, 0, NULL, 0),
(11, 1, 'fsdafsa', '', 'fdsafsadf', 20171130, '', 0, 0, '', 0, 0, 0, 1, 0, 1, 1512006224, 2130706433, 0, 1512006224, 0, 0, NULL, 0),
(12, 1, 'fsdafsa', '', 'fdsafsadf', 20171130, '', 0, 0, '', 0, 0, 0, 1, 0, 1, 1512006284, 2130706433, 0, 1512006284, 0, 0, NULL, 0),
(13, 1, 'fsdafsa', '', 'fdsafsadf', 20171130, '', 0, 0, '', 0, 0, 0, 1, 0, 1, 1512007202, 2130706433, 0, 1512007202, 0, 0, NULL, 0),
(14, 1, 'fsdafsa', '', 'fdsafsadf', 20171130, '', 0, 0, '', 0, 0, 0, 1, 0, 1, 1512007790, 2130706433, 0, 1512007790, 0, 0, NULL, 0),
(15, 1, 'fsdafsa', '', 'fdsafsadf', 20171130, '', 0, 0, '', 0, 0, 0, 1, 0, 1, 1512007812, 2130706433, 0, 1512007812, 0, 0, NULL, 0),
(16, 1, 'fsdafsa', '', 'fdsafsadf', 20171130, '', 0, 0, '', 0, 0, 0, 1, 0, 1, 1512007903, 2130706433, 0, 1512007903, 0, 0, NULL, 0),
(17, 1, 'fsdafsa', '', 'fdsafsadf', 20171130, '', 0, 0, '', 0, 0, 0, 1, 0, 1, 1512008316, 2130706433, 0, 1512008316, 0, 0, NULL, 0),
(18, 1, 'fsdafsa', '', 'fdsafsadf', 20171130, '', 0, 0, '', 0, 0, 0, 1, 0, 1, 1512008477, 2130706433, 0, 1512008477, 0, 0, NULL, 0),
(19, 1, 'fsdafsa', '', 'fdsafsadf', 20171130, '', 0, 0, '', 0, 0, 0, 1, 0, 1, 1512008482, 2130706433, 1, 1512012539, 2130706433, 0, NULL, 0),
(20, 1, '测试标题', '', '测试标题', 20171130, '', 0, 0, '', 0, 0, 0, 1, 0, 1, 1512012916, 2130706433, 1, 1512013002, 2130706433, 0, NULL, 0),
(21, 1, '中国共产党', '需要,南明,花溪,贵州省,黄平县,中国共产党,朝秦暮楚,贵阳,塔顶,顶替', '中国共产党黄平县贵州省贵阳南明花溪北京朝秦暮楚需要压根需要需要塔顶需要顶替一二三上上玩具上', 20171130, '', 0, 0, '', 0, 0, 0, 1, 0, 1, 1512015072, 2130706433, 0, 1512015072, 0, 0, NULL, 0),
(22, 1, '中国共产党', '需要,南明,花溪,贵州省,黄平县,中国共产党,朝秦暮楚,贵阳,塔顶,顶替', '中国共产党黄平县贵州省贵阳南明花溪北京朝秦暮楚需要压根需要需要塔顶需要顶替一二三上上玩具上', 20171130, '', 0, 0, '', 0, 0, 0, 1, 0, 1, 1512015096, 2130706433, 0, 1512015096, 0, 0, NULL, 0),
(23, 1, '中国共产党', '需要,南明,花溪,贵州省,黄平县,中国共产党,朝秦暮楚,贵阳,塔顶,顶替', '中国共产党黄平县贵州省贵阳南明花溪北京朝秦暮楚需要压根需要需要塔顶需要顶替一二三上上玩具上', 20171130, '', 0, 0, '', 0, 0, 0, 1, 0, 1, 1512015760, 2130706433, 1, 1512022811, 2130706433, 1, 1512022811, 2130706433),
(24, 40, '测试', '测试', '测试测试测试测试', 0, '', 0, 0, '', 0, 0, 0, 1, 0, 1, 1514875385, 2130706433, 0, 1514875385, 0, 0, NULL, 0);

-- --------------------------------------------------------

--
-- 表的结构 `cy_document_article`
--

CREATE TABLE `cy_document_article` (
  `id` int(10) NOT NULL DEFAULT '0' COMMENT '文档ID',
  `content` text NOT NULL COMMENT '文章内容 ',
  `template` varchar(100) NOT NULL COMMENT '详情页显示模板'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cy_document`
--
ALTER TABLE `cy_document`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cy_document_article`
--
ALTER TABLE `cy_document_article`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `cy_document`
--
ALTER TABLE `cy_document`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id', AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
