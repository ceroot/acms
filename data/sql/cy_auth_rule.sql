-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2017-12-01 04:24:04
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
-- 表的结构 `cy_auth_rule`
--

CREATE TABLE `cy_auth_rule` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `pid` mediumint(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父级id',
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(80) NOT NULL DEFAULT '',
  `url` char(255) DEFAULT NULL COMMENT 'url地址，默认为null，当为null时使用方法调用name',
  `condition` char(100) NOT NULL DEFAULT '',
  `controller` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是控制器，0不是，1是',
  `instantiation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否需要实例化，0为不需要，1为需要',
  `auth` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否需要权限验证，0为不需要，1为需要',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，0为禁用，1为正常',
  `isnavshow` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示导航，0为隐藏，1为显示',
  `icon` char(40) NOT NULL COMMENT '图标',
  `sort` smallint(6) NOT NULL DEFAULT '100' COMMENT '排序，越大越往后',
  `create_time` int(11) NOT NULL COMMENT '添加时间',
  `update_time` int(11) NOT NULL COMMENT '修改时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `cy_auth_rule`
--

INSERT INTO `cy_auth_rule` (`id`, `pid`, `name`, `title`, `url`, `condition`, `controller`, `instantiation`, `auth`, `type`, `status`, `isnavshow`, `icon`, `sort`, `create_time`, `update_time`) VALUES
(1, 0, 'index', '控制台', 'index/index', '', 1, 0, 0, 1, 1, 1, 'fa-home', 100, 0, 1509601626),
(2, 0, 'Product', '产品管理', NULL, '', 1, 1, 1, 1, 1, 0, 'fa-product-hunt', 100, 0, 1506756056),
(3, 0, 'order', '订单管理', NULL, '', 1, 0, 1, 1, 1, 0, 'fa-home', 100, 0, 1506756056),
(4, 0, 'Business', '商家管理', NULL, '', 1, 1, 1, 1, 1, 0, 'fa-reorder', 100, 0, 1506756056),
(5, 0, 'articles', '内容', '', '', 0, 0, 1, 1, 1, 1, 'fa-list-alt', 100, 0, 1506756056),
(6, 0, 'UcenterMember/index', '用户管理', '', '', 1, 1, 1, 1, 1, 1, 'fa-home', 100, 0, 1509700426),
(7, 0, 'auth', '权限管理', 'authRule/index', '', 0, 0, 1, 1, 1, 1, 'fa-random', 100, 0, 1506756056),
(8, 0, 'System', '系统管理', '/console/config/index/group/base', '', 0, 0, 1, 1, 1, 1, 'fa-gears', 100, 0, 1510889329),
(21, 2, 'product/lists', '产品管理', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(22, 2, 'Examine', '审核管理', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(23, 21, 'Scenery', '旅游线路管理', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(24, 21, 'Hotel', '酒店管理', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(25, 21, 'Travelticket', '景区门票', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(26, 21, 'Group', '休闲美食', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(27, 1, 'index/index', '控制台首页', NULL, '', 0, 0, 0, 1, 1, 1, '', 100, 0, 1506756056),
(28, 22, 'Hotel/hotelListt', '酒店审核', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(29, 22, 'TravelTicket/ticketListt', '景区门票审核', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(30, 22, 'Group/indexx', '美食审核', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(31, 3, 'order/index', '旅游路线订单列表', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(32, 31, 'order/index2', '酒店订单列表', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(33, 3, 'order/index3', '景区门票订单列表', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(34, 33, 'order/index4', '休闲美食订单列表', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(35, 33, 'order/index5', '旅游路线订单列表', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(52, 5, 'article/index', '内容管理', '', '', 1, 1, 1, 1, 1, 1, '', 100, 0, 1506756056),
(53, 52, 'Article', '内容管理控制器', '', '', 1, 1, 1, 1, 1, 0, '', 100, 0, 1511942512),
(54, 5, 'Ad', '广告管理', NULL, '', 0, 0, 1, 1, 1, 0, '', 100, 0, 1506756056),
(61, 6, 'UcenterMember', '用户控制器', '', '', 1, 1, 1, 1, 1, 0, '', 100, 0, 1509700315),
(62, 6, 'UcenterMember/lists', '本系统用户列表', '', '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1509700370),
(71, 7, 'manager/index', '管理员管理', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(72, 7, 'authRule/index', '规则管理', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(73, 72, 'authRule/lists', '规则列表', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(74, 72, 'authRule/add', '添加规则', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(75, 72, 'authRule/edit', '编辑规则', NULL, '', 0, 0, 1, 1, 1, 0, '', 100, 0, 1506756056),
(76, 72, 'authRule/del', '删除规则', NULL, '', 0, 0, 1, 1, 1, 0, '', 100, 0, 1506756056),
(77, 71, 'manager/lists', '管理员列表', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(78, 71, 'manager/add', '添加管理员', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(79, 71, 'Manager/edit', '编辑管理员', NULL, '', 0, 0, 1, 1, 1, 0, '', 100, 0, 1506756056),
(80, 71, 'manager/log', '管理员日志', NULL, '', 0, 0, 1, 1, 1, 0, '', 100, 0, 1506756056),
(81, 8, 'cache/index', '缓存管理', NULL, '', 1, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(82, 8, 'MobileCode', '短信管理', NULL, '', 0, 0, 1, 1, 1, 0, '', 100, 0, 1506756056),
(83, 8, 'DataBackup/index', '数据库管理', '', '', 1, 0, 1, 1, 1, 1, '', 100, 0, 1511766037),
(84, 81, 'cache/cache', '更新缓存', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(85, 8, 'Visitcount', '访问统计', NULL, '', 1, 1, 1, 1, 1, 0, '', 100, 0, 1506756056),
(86, 85, 'Visitcount/index', '访问概况', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(87, 85, 'Visitcount/today', '今日访问排行', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(88, 8, 'Pay', '支付设置', NULL, '', 1, 0, 1, 1, 1, 0, '', 100, 0, 1506756056),
(101, 7, 'authGroup/index', '角色管理', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(102, 101, 'AuthGroup/add', '角色添加', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(103, 101, 'AuthGroup/edit', '角色编辑', NULL, '', 0, 0, 1, 1, 1, 0, '', 100, 0, 1506756056),
(104, 101, 'AuthGroup/del', '角色删除', NULL, '', 0, 0, 1, 1, 1, 0, '', 100, 0, 1506756056),
(105, 101, 'AuthGroup/rule', '分配权限', NULL, '', 0, 0, 1, 1, 1, 0, '', 100, 0, 1506756056),
(106, 85, 'Visitcount/latest', '实时访客', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(107, 7, 'action/index', '行为管理', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(108, 107, 'action/lists', '用户行为', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(109, 107, 'action', '行为管理控制器', '', '', 1, 1, 1, 1, 1, 0, '', 100, 0, 1506756056),
(110, 107, 'actionLog/lists', '行为日志', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 1448348339, 1506756056),
(111, 88, 'Pay/chinabanck', '网银在线设置', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 1448348382, 1506756056),
(112, 1, 'index/index111', '首页控制器', NULL, '', 0, 0, 0, 1, 1, 0, '', 100, 1448369860, 1506756056),
(113, 1, 'index/copyright', '系统信息', NULL, '', 0, 0, 0, 1, 1, 1, '', 100, 1448369952, 1506756056),
(114, 83, 'DataBackup', '数据库管理控制器', '', '', 0, 0, 1, 1, 1, 0, '', 100, 1448437926, 1511919778),
(115, 81, 'cache/update', '更新缓存操作', NULL, '', 0, 0, 1, 1, 1, 0, '', 100, 1448439236, 1506756056),
(116, 1, 'manager/info', '修改个人信息', NULL, '', 0, 0, 0, 1, 1, 1, '', 100, 1448593741, 1506756056),
(117, 1, 'manager/password', '修改密码', NULL, '', 0, 0, 0, 1, 1, 1, '', 100, 1448594855, 1506756056),
(118, 71, 'ManagerActionLog', '管理员日志控制器', NULL, '', 1, 1, 1, 1, 1, 0, '', 100, 1450409832, 1506756056),
(152, 107, 'action/add', '添加行为', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(153, 107, 'action/edit', '修改行为', NULL, '', 0, 0, 1, 1, 1, 0, '', 100, 0, 1506756056),
(204, 101, 'authGroup/lists', '角色列表', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 1462695390, 1506756056),
(218, 71, 'manager/disable', '禁用用户', NULL, '', 0, 0, 1, 1, 1, 0, '', 100, 1463234283, 1506756056),
(219, 72, 'authRule/updateshow', '设置是否在控制台菜单显示', NULL, '', 0, 0, 1, 1, 1, 0, '', 100, 1463288822, 1506756056),
(220, 72, 'authRule/updateauth', '设置验证状态', NULL, '', 0, 0, 1, 1, 1, 0, '', 100, 1463289399, 1506756056),
(221, 5, 'category/index', '类别管理', '', '', 0, 0, 1, 1, 1, 1, '', 100, 1463657943, 1506756056),
(222, 221, 'category', '类别管理控制器', NULL, '', 1, 1, 1, 1, 1, 0, '', 100, 1463658455, 1506756056),
(223, 221, 'category/lists', '类别列表', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 1463659472, 1506756056),
(224, 221, 'category/add', '添加类别', NULL, '', 0, 0, 1, 1, 1, 1, '', 100, 1463662072, 1506756056),
(225, 72, 'authRule/disable', '设置规则状态', NULL, '', 0, 0, 1, 1, 1, 0, '', 100, 1463664692, 1506756056),
(226, 221, 'category/edit', '编辑类别', NULL, '', 0, 0, 1, 1, 1, 0, '', 100, 1463664960, 1506756056),
(227, 221, 'category/status', '设置类别状态', NULL, '', 0, 0, 1, 1, 1, 0, '', 100, 1463666434, 1506756056),
(228, 221, 'category/updateshow', '设置类别显示状态', NULL, '', 0, 0, 1, 1, 1, 0, '', 100, 1463928513, 1506756056),
(229, 8, 'developer/index', '开发管理', '', '', 0, 0, 1, 1, 1, 0, '', 100, 1464406829, 1506756056),
(230, 229, 'developer', '开发管理控制器', '', '', 1, 1, 1, 1, 1, 0, '', 100, 1464406877, 1506756056),
(231, 229, 'developer/lists', '开发日志列表', '', '', 0, 0, 1, 1, 1, 1, '', 100, 1464406930, 1506756056),
(232, 229, 'developer/add', '添加开发日志', '', '', 0, 0, 1, 1, 1, 1, '', 100, 1464406968, 1506756056),
(233, 229, 'developer/edit', '编辑开发日志', '', '', 0, 0, 1, 1, 1, 0, '', 100, 1464406994, 1506756056),
(234, 229, 'developer/view', '查看开发日志', '', '', 0, 0, 1, 1, 1, 0, '', 100, 1464410488, 1506756056),
(279, 71, 'manager', '管理员控制器', '', '', 1, 1, 1, 1, 1, 0, '', 100, 1466309256, 1506756056),
(280, 72, 'authRule', '规则管理控制器', '', '', 1, 1, 1, 1, 1, 0, '', 100, 1466309532, 1506756056),
(281, 101, 'authGroup', '角色管理控制器', '', '', 1, 1, 1, 1, 1, 0, '', 100, 1466309578, 1506756056),
(282, 8, 'config/index', '网站设置', '/console/config/index/group/base.html', '', 0, 0, 1, 1, 1, 1, '', 100, 1466310323, 1511856027),
(283, 284, 'config', '网站设置控制器', '', '', 1, 1, 1, 1, 1, 0, '', 100, 1466310459, 1506756056),
(284, 8, 'config/lists', '配置管理', '', '', 0, 0, 1, 1, 1, 1, '', 100, 1466311812, 1506756056),
(285, 284, 'config/add', '添加配置', '', '', 0, 0, 1, 1, 1, 1, '', 100, 1466311991, 1506756056),
(286, 284, 'config/edit', '编辑配置', '', '', 0, 0, 1, 1, 1, 0, '', 100, 1466312050, 1506756056),
(287, 284, 'config/del', '删除配置', '', '', 0, 0, 1, 1, 1, 0, '', 100, 1466312086, 1506756056),
(288, 284, 'config/sort', '排序配置', '', '', 0, 0, 1, 1, 1, 0, '', 100, 1466312110, 1506756056),
(289, 110, 'actionLog', '日志控制器', '', '', 1, 1, 1, 1, 1, 0, '', 100, 1466350259, 1506756056),
(290, 6, 'oauthUser', '第三方用户控制器', '', '', 1, 1, 1, 1, 1, 0, '', 100, 1466682341, 1506756056),
(291, 6, 'oauthUser/lists', '第三方用户列表', '', '', 0, 0, 1, 1, 1, 0, '', 100, 1466682386, 1506756056),
(292, 8, 'model/index', '模型管理', '', '', 0, 0, 1, 1, 1, 0, '', 100, 1466783831, 1506756056),
(293, 292, 'model', '模型管理控制器', '', '', 1, 1, 1, 1, 1, 0, '', 100, 1466783851, 1506756056),
(294, 292, 'model/lists', '模型列表', '', '', 0, 0, 1, 1, 1, 1, '', 100, 1466783877, 1506756056),
(295, 292, 'model/add', '添加模型', '', '', 0, 0, 1, 1, 1, 1, '', 100, 1466784186, 1506756056),
(296, 292, 'model/edit', '编辑模型', '', '', 0, 0, 1, 1, 1, 0, '', 100, 1466784200, 1506756056),
(297, 8, 'attribute/index', '字段属性管理', '', '', 0, 0, 1, 1, 1, 0, '', 100, 1466833500, 1506756056),
(298, 297, 'attribute', '字段属性控制器', '', '', 1, 1, 1, 1, 1, 0, '', 100, 1466833586, 1506756056),
(299, 297, 'attribute/lists', '字段属性列表', '', '', 0, 0, 1, 1, 1, 1, '', 100, 1466833616, 1506756056),
(300, 301, 'WebLog', '网站日志控制器', '', '', 1, 1, 1, 1, 1, 0, '', 100, 0, 1506756056),
(301, 8, 'WebLog/index', '网站日志管理', '', '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(302, 301, 'WebLog/lists', '网站日志列表', '', '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(303, 301, 'WebLog/seting', '网站日志设置', '', '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(311, 110, 'actionLog/view', '行为查看详情', '', '', 0, 0, 1, 1, 1, 0, '', 100, 0, 1506756056),
(312, 52, 'article/lists', '内容列表', '', '', 0, 0, 1, 1, 1, 1, '', 100, 0, 1506756056),
(314, 5, 'article/add', '内容增加', '', '', 1, 1, 1, 1, 1, 1, '', 100, 1493710128, 1506756056),
(327, 25, 'test/test2', 'fdsafdd1', '', '', 1, 1, 1, 1, 1, 1, '', 100, 1509588149, 1509588149),
(328, 62, 'UcenterMember/edit', '本地用户编辑', '', '', 0, 0, 1, 1, 1, 0, '', 100, 1509948212, 1509948212),
(329, 62, 'UcenterMember/details', '本地用户查看', '', '', 0, 0, 1, 1, 1, 0, '', 100, 1509948258, 1509948258),
(331, 107, 'action/renew', '行为操作方法', '', '', 0, 0, 1, 1, 1, 0, '', 100, 1510722686, 1510722686),
(332, 107, 'action/details', '行为详情', '', '', 0, 0, 1, 1, 1, 0, '', 100, 1510813548, 1510813548),
(333, 107, 'actionLog/details', '行为日志详情', '', '', 0, 0, 1, 1, 1, 0, '', 100, 1510813735, 1510813860),
(334, 284, 'config/details', '配置详情', '', '', 0, 0, 1, 1, 1, 0, '', 100, 1510814008, 1510814008),
(335, 301, 'WebLog/details', '网站日志详情', '', '', 0, 0, 1, 1, 1, 0, '', 100, 1510814209, 1510814209),
(336, 83, 'DataBackup/lists', '数据库列表', '', '', 0, 0, 1, 1, 1, 1, '', 100, 1511754703, 1511754703),
(337, 83, 'DataBackup/import', '数据库备份列表', '', '', 0, 0, 1, 1, 1, 1, '', 100, 1511755154, 1511848619),
(338, 83, 'DataBackup/del', '删除数据库备份', '', '', 0, 0, 1, 1, 1, 0, '', 100, 1511755178, 1511755199),
(339, 83, 'DataBackup/revert', '还原数据库', '', '', 0, 0, 1, 1, 1, 0, '', 100, 1511848687, 1511848687),
(340, 83, 'DataBackup/optimize', '优化表', '', '', 0, 0, 1, 1, 1, 0, '', 100, 1511848716, 1511848716),
(341, 83, 'DataBackup/repair', '修复表', '', '', 0, 0, 1, 1, 1, 0, '', 100, 1511848737, 1511848737),
(342, 83, 'DataBackup/export', '数据库备份', '', '', 0, 0, 1, 1, 1, 0, '', 100, 1511854274, 1511854274),
(343, 83, 'DataBackup/set', '数据库备份设置', '/console/config/index/group/database.html', '', 0, 0, 1, 1, 1, 1, '', 100, 1511855298, 1511856060),
(344, 52, 'article/edit', '内容编辑', '', '', 0, 0, 1, 1, 1, 0, '', 100, 1511945555, 1511945555);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cy_auth_rule`
--
ALTER TABLE `cy_auth_rule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `cy_auth_rule`
--
ALTER TABLE `cy_auth_rule`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=345;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;