-- -----------------------------
-- Think MySQL Data Transfer 
-- 
-- Host     : 
-- Port     : 
-- Database : 
-- 
-- Part : #1
-- Date : 2017-11-27 17:49:43
-- -----------------------------

SET FOREIGN_KEY_CHECKS = 0;


-- -----------------------------
-- Table structure for `cy_action`
-- -----------------------------
DROP TABLE IF EXISTS `cy_action`;
CREATE TABLE `cy_action` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '行为唯一标识',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '行为说明',
  `remark` char(140) NOT NULL DEFAULT '' COMMENT '行为描述',
  `rule` text COMMENT '行为规则',
  `log` text COMMENT '日志规则',
  `type` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '类型',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态，1为正常，0为禁用',
  `create_uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加者的id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `create_ip` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加ip',
  `update_uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改者id',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `update_ip` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改ip',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间（软删除）',
  `delete_uid` int(10) NOT NULL COMMENT '删除用户 id',
  `delete_ip` bigint(11) NOT NULL COMMENT '删除 ip',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统行为表';

-- -----------------------------
-- Records of `cy_action`
-- -----------------------------
INSERT INTO `cy_action` VALUES ('1', 'manager_login', '用户登录', '记录管理员登录管理系统日志', '', '[user_id|get_realname]在[time|time_format]登录了管理系统', '1', '1', '0', '0', '0', '1', '1464054349', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('2', 'manager_logout', '用户注销', '记录管理员退出管理系统日志', '', '[user_id|get_realname]在[time|time_format]退出了管理系统', '1', '1', '1', '1463465048', '2130706433', '0', '0', '0', '', '0', '0');
INSERT INTO `cy_action` VALUES ('3', 'cache_cache', '更新缓存', '记录更新缓存操作日志', '', '[user_id|get_realname]在[time|time_format]更新了缓存', '1', '1', '0', '0', '0', '1', '1464280463', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('4', 'action_add', '添加行为', '记录添加行为操作日志', '', '[user_id|get_realname]在[time|time_format]添加了行为', '1', '1', '0', '1462456882', '2130706433', '1', '1464068270', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('5', 'action_edit', '修改行为', '记录修改行为操作日志', '', '[user_id|get_realname]在[time|time_format]修改了行为', '1', '1', '1', '1462457125', '2130706433', '1', '1464074125', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('6', 'action_del', '删除行为', '记录删除行为操作日志', '', '[user_id|get_realname]在[time|time_format]删除了行为', '1', '1', '1', '1462457125', '2130706433', '1', '1464074130', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('7', 'action_updatestatus', '设置行为状态', '记录行为状态操作日志', '', '[user_id|get_realname]在[time|time_format]操作了行为的状态', '1', '1', '1', '1462458377', '2130706433', '1', '1506654943', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('8', 'manager_add', '添加管理员', '记录新增管理员操作日志', '', '[user_id|get_realname]在[time|time_format]添加了管理用户', '1', '1', '0', '0', '0', '0', '0', '0', '', '0', '0');
INSERT INTO `cy_action` VALUES ('9', 'manager_edit', '修改管理员', '记录修改管理员操作日志', '', '[user_id|get_realname]在[time|time_format]修改了管理用户', '1', '1', '0', '0', '0', '0', '0', '0', '', '0', '0');
INSERT INTO `cy_action` VALUES ('10', 'manager_del', '删除用户', '记录删除管理员操作日志', '', '[user_id|get_realname]在[time|time_format]删除了用户', '1', '1', '1', '1462811355', '2130706433', '0', '0', '0', '', '0', '0');
INSERT INTO `cy_action` VALUES ('11', 'manager_updatestatus', '禁用[启用]用户', '记录禁用启用管理员操作日志', '', '[user_id|get_realname]在[time|time_format][table_id|status_text]了管理用户', '1', '1', '0', '0', '0', '1', '1464067399', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('12', 'authrule_add', '添加规则', '记录添加规则操作日志', '', '[user_id|get_realname]在[time|time_format]添加了规则', '1', '1', '1', '1463722274', '2130706433', '1', '1485228082', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('13', 'authrule_edit', '编辑规则', '记录修改规则操作日志', '', '[user_id|get_realname]在[time|time_format]修改了规则', '1', '1', '1', '1462463721', '2130706433', '1', '1485228092', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('14', 'authrule_del', '删除规则', '记录删除规则操作日志', '', '[user_id|get_realname]在[time|time_format]删除了规则', '1', '1', '1', '1463284593', '2130706433', '1', '1485228110', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('15', 'authrule_updatestatus', '禁用[启用]规则', '记录禁用启用规则操作日志', '', '[user_id|get_realname]在[time|time_format][table_id|status_text]了规则', '1', '1', '1', '1463279149', '2130706433', '1', '1485228117', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('16', 'authrule_updateshow', '设置控制台菜单显示', '记录设置控制台菜单项显示操作记录', '', '[user_id|get_realname]在[time|time_format]设置了控制台菜单显示状态', '1', '1', '1', '1463289050', '2130706433', '1', '1485228130', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('17', 'authrule_updateauth', '设置权限认证状态', '记录设置权限认证状态操作日志', '', '[user_id|get_realname]在[time|time_format]更新了权限认证状态', '1', '1', '1', '1463290047', '2130706433', '1', '1485228137', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('18', 'authrule_sort', '规则排序操作', '', '', '[user_id|get_realname]在[time|time_format]更新了规则排序', '1', '1', '1', '1463290047', '2130706433', '1', '1485228144', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('19', 'authgroup_add', '增加角色', '记录新增角色操作日志', '', '[user_id|get_realname]在[time|time_format]新增了角色', '1', '1', '1', '1463295059', '2130706433', '1', '1485228157', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('20', 'authgroup_edit', '修改角色', '记录编辑角色操作日志', '', '[user_id|get_realname]在[time|time_format]修改了角色', '1', '1', '1', '1463295110', '2130706433', '1', '1509950164', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('21', 'authgroup_del', '删除角色', '记录删除角色操作日志', '', '[user_id|get_realname]在[time|time_format]删除了角色', '1', '1', '1', '1463295145', '2130706433', '1', '1485228174', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('22', 'authgroup_updatestatus', '禁用[启用]角色', '记录禁用启用角色操作日志', '', '[user_id|get_realname]在[time|time_format][table_id|status_text]了角色', '1', '1', '1', '1463294873', '2130706433', '1', '1464067636', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('23', 'category_add', '添加类别', '记录添加类别操作日志', '', '[user_id|get_realname]在[time|time_format]新增了类别', '1', '1', '1', '1463971338', '2130706433', '0', '1463971338', '0', '', '0', '0');
INSERT INTO `cy_action` VALUES ('24', 'category_edit', '编辑类别', '记录编辑类别操作日志', '', '[user_id|get_realname]在[time|time_format]编辑了类别', '1', '1', '1', '1463971377', '2130706433', '0', '1463971377', '0', '', '0', '0');
INSERT INTO `cy_action` VALUES ('25', 'category_del', '删除类别', '记录删除类别操作日志', '', '[user_id|get_realname]在[time|time_format]删除了类别', '1', '1', '1', '0', '2130706433', '1', '1463991724', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('26', 'category_updateshow', '更改类别菜单显示状态', '', '', '[user_id|get_realname]在[time|time_format]设置了类别显示状态', '1', '1', '1', '1463289050', '2130706433', '0', '0', '0', '', '0', '0');
INSERT INTO `cy_action` VALUES ('27', 'category_updatestatus', '设置类别状态', '记录设置类别状态操作日志', '', '[user_id|get_realname]在[time|time_format][table_id|status_text]了类别', '1', '1', '1', '1463971458', '2130706433', '1', '1464067682', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('28', 'category_sort', '类别排序操作', '', '', '[user_id|get_realname]在[time|time_format]更新了类别排序', '1', '1', '1', '1463290047', '2130706433', '1', '1464183572', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('29', 'manager_password', '修改密码', '', '', '[user_id|get_realname]在[time|time_format]修改了密码', '1', '1', '1', '1464262601', '2130706433', '0', '1464262601', '0', '', '0', '0');
INSERT INTO `cy_action` VALUES ('30', 'manager_info', '用户信息修改', '记录用户修改自己的信息操作记录', '', '[user_id|get_realname]在[time|time_format]修改了个人信息', '1', '1', '1', '1464268539', '2130706433', '0', '1464268539', '0', '', '0', '0');
INSERT INTO `cy_action` VALUES ('31', 'developer_add', '添加开发日志', '记录添加开发日志操作日志', '', '[user_id|get_realname]在[time|time_format]添加了一篇开发日志', '1', '1', '1', '1464410542', '2130706433', '0', '1464410542', '0', '', '0', '0');
INSERT INTO `cy_action` VALUES ('32', 'developer_edit', '编辑开发日志', '记录编辑开发日志操作日志', '', '[user_id|get_realname]在[time|time_format]编辑了开发日志', '1', '1', '1', '1464410581', '2130706433', '1', '1464786410', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('33', 'index_dotMenu', '菜单管理', '', '', '[user_id|get_realname]在[time|time_format]添加了菜单管理', '1', '0', '1', '1464955794', '2130706433', '1', '1464956119', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('34', 'list_dotMenu', '菜单列表', '', '', '[user_id|get_realname]在[time|time_format]添加了菜单列表', '1', '0', '1', '1464955909', '2130706433', '1', '1464956120', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('35', 'dotmenu_add', '添加菜单', '', '', '[user_id|get_realname]在[time|time_format]添加了添加菜单', '1', '1', '1', '1464955953', '2130706433', '1', '1464956708', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('36', 'dotmenu_edit', '编辑菜单', '', '', '[user_id|get_realname]在[time|time_format]操作了编辑菜单', '1', '1', '1', '1464956182', '2130706433', '1', '1464956644', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('37', 'dotcategory_add', '添加类别', '', '', '[user_id|get_realname]在[time|time_format]添加了类别', '1', '1', '1', '1464957300', '2130706433', '0', '1464957300', '0', '', '0', '0');
INSERT INTO `cy_action` VALUES ('38', 'dotcategory_edit', '编辑类别', '', '', '[user_id|get_realname]在[time|time_format]操作了编辑类别', '1', '1', '1', '1464957306', '2130706433', '0', '1464957306', '0', '', '0', '0');
INSERT INTO `cy_action` VALUES ('39', 'dotcases_add', '添加成功案例', '', '', '[user_id|get_realname]在[time|time_format]添加了成功案例', '1', '1', '1', '1464957517', '2130706433', '0', '1464957517', '0', '', '0', '0');
INSERT INTO `cy_action` VALUES ('40', 'dotcases_edit', '编辑成功案例', '', '', '[user_id|get_realname]在[time|time_format]操作了编辑成功案例', '1', '1', '1', '1464957544', '2130706433', '0', '1464957544', '0', '', '0', '0');
INSERT INTO `cy_action` VALUES ('41', 'dotwebinfo_edit', '网站信息编辑', '', '', '[user_id|get_realname]在[time|time_format]操作了网站信息编辑', '1', '1', '1', '1465118687', '2130706433', '0', '1465118687', '0', '', '0', '0');
INSERT INTO `cy_action` VALUES ('42', 'dotwebinfo_link', '联系我们设置', '', '', '[user_id|get_realname]在[time|time_format]修改了联系我们', '1', '1', '1', '1465143786', '2130706433', '0', '1465143786', '0', '', '0', '0');
INSERT INTO `cy_action` VALUES ('43', 'dotwebinfo_about', '关于我们', '', '', '[user_id|get_realname]在[time|time_format]操作了关于我们', '1', '1', '1', '1465144287', '2130706433', '0', '1465144287', '0', '', '0', '0');
INSERT INTO `cy_action` VALUES ('44', 'dot_article_add', '内容添加', '', '', '[user_id|get_realname]在[time|time_format]操作了内容添加', '1', '1', '1', '1465212939', '2130706433', '0', '1465212939', '0', '', '0', '0');
INSERT INTO `cy_action` VALUES ('45', 'dot_article_edit', '内容编辑', '', '', '[user_id|get_realname]在[time|time_format]操作了内容编辑', '1', '1', '1', '1465212957', '2130706433', '1', '1493780955', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('46', 'dotcategory_updatestatus', '更新类别状态', '', '', '[user_id|get_realname]在[time|time_format]操作了更新类别状态', '1', '1', '1', '1465823733', '2130706433', '0', '1465823733', '0', '', '0', '0');
INSERT INTO `cy_action` VALUES ('47', 'dotcategory_updatehidden', '更新类别显示状态', '', '', '[user_id|get_realname]在[time|time_format]操作了更新类别显示状态', '1', '1', '1', '1465823764', '2130706433', '0', '1465823764', '0', '', '0', '0');
INSERT INTO `cy_action` VALUES ('48', 'addons_config', '插件设置', '', '', '[user_id|get_realname]在[time|time_format]操作了插件设置', '1', '1', '1', '1466229201', '2130706433', '0', '1466229201', '0', '', '0', '0');
INSERT INTO `cy_action` VALUES ('49', 'hooks_add', '钩子添加', '', '', '[user_id|get_realname]在[time|time_format]操作了钩子添加', '1', '1', '1', '1466231186', '2130706433', '0', '1466231186', '0', '', '0', '0');
INSERT INTO `cy_action` VALUES ('50', 'hooks_addsa', '钩子添加', '', '', '[user_id|get_realname]在[time|time_format]操作了钩子添加', '1', '1', '1', '1466231194', '2130706433', '1', '1509356631', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('51', 'this is test', '这是测试行为', '', '', '[user_id|get_realname]在[time|time_format]设置了控制台菜单显示状态', '1', '1', '1', '1466239001', '2130706433', '1', '1466250482', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('52', 'config_add', '添加配置', '', '', '[user_id|get_realname]在[time|time_format]操作了添加配置', '1', '1', '1', '1466311991', '2130706433', '0', '1466311991', '0', '', '0', '0');
INSERT INTO `cy_action` VALUES ('53', 'config_groupupdate', '网站设置', '', '', '[user_id|get_realname]在[time|time_format]操作了网站设置', '1', '1', '1', '1466312050', '2130706433', '1', '1506669704', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('54', 'config_del', '删除配置', '', '', '[user_id|get_realname]在[time|time_format]操作了删除配置', '1', '1', '1', '1466312086', '2130706433', '0', '1466312086', '0', '', '0', '0');
INSERT INTO `cy_action` VALUES ('55', 'config_sort', '排序配置', '', '', '[user_id|get_realname]在[time|time_format]操作了排序配置', '1', '1', '1', '1466312110', '2130706433', '0', '1466312110', '0', '', '0', '0');
INSERT INTO `cy_action` VALUES ('56', 'config_base', '基本配置', '', '', '[user_id|get_realname]在[time|time_format]操作了基本配置', '1', '1', '1', '1466312280', '2130706433', '0', '1466312280', '0', '', '0', '0');
INSERT INTO `cy_action` VALUES ('57', 'model_add', '添加模型', '', '', '[user_id|get_realname]在[time|time_format]操作了添加模型', '1', '1', '1', '1466784186', '2130706433', '0', '1466784186', '0', '', '0', '0');
INSERT INTO `cy_action` VALUES ('58', 'model_edit', '编辑模型', '122333311', '', '[user_id|get_realname]在[time|time_format]操作了编辑模型', '1', '1', '1', '1466784200', '2130706433', '1', '1466784200', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('61', 'config_edit', '编辑配置', '记录编辑配置', '', '[user_id|get_realname]在[time|time_format]操作了编辑配置', '1', '1', '1', '1506578880', '2130706433', '1', '1509432251', '2130706433', '', '0', '0');
INSERT INTO `cy_action` VALUES ('60', 'actionlog_del', '删除管理用户行为日志', '记录删除管理用户行为日志', '', '[user_id|get_realname]在[time|time_format]删除了管理用户行为日志', '1', '1', '0', '0', '0', '0', '0', '0', '', '0', '0');
INSERT INTO `cy_action` VALUES ('83', 'ucentermember_edit', '本地用户编辑', '', '', '[user_id|get_realname]在[time|time_format]修改了本地用户编辑', '2', '1', '1', '1509948212', '2130706433', '1', '1509948966', '2130706433', '', '0', '0');

-- -----------------------------
-- Table structure for `cy_action_log`
-- -----------------------------
DROP TABLE IF EXISTS `cy_action_log`;
CREATE TABLE `cy_action_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `action_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '行为id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '执行用户id',
  `model` varchar(64) NOT NULL DEFAULT '' COMMENT '触发行为的表（控制器）',
  `method` varchar(10) NOT NULL DEFAULT 'POST' COMMENT '请求方法',
  `record_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '触发行为的数据id',
  `url` varchar(255) NOT NULL COMMENT 'url',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '日志备注',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态，1为正常，0为禁用',
  `device` varchar(50) NOT NULL COMMENT '操作设备',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '执行行为的时间',
  `create_ip` bigint(20) NOT NULL COMMENT '执行行为者ip',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间（软删除）',
  `delete_uid` int(10) NOT NULL COMMENT '删除者 id',
  `delete_ip` int(10) NOT NULL COMMENT '删除ip',
  PRIMARY KEY (`id`),
  KEY `action_ip_ix` (`create_ip`),
  KEY `action_id_ix` (`action_id`),
  KEY `user_id_ix` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=252 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='行为日志表';

-- -----------------------------
-- Records of `cy_action_log`
-- -----------------------------
INSERT INTO `cy_action_log` VALUES ('1', '1', '1', 'manager', 'POST', '1', '/console/start/index/time/1510713633.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole', '超级管理员在2017-11-15 10:40:43登录了管理系统', '1', 'pc', '1510713643', '30160667', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('2', '16', '1', 'AuthRule', 'GET', '291', '/console/auth_rule/updateshow/id/8292lF%5Ex3R5QfiSw4tvDlZOhV4aguM71EbCexJZ860s.html', '超级管理员在2017-11-15 10:54:18设置了控制台菜单显示状态', '1', 'pc', '1510714458', '30160667', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('3', '2', '1', 'manager', 'POST', '1', '/console/start/logout/time/20171115105458L6wW2SKEzCSyHF2kHNPeX2brvX3LWRpSzanKyhEzaVTGVqEPfpJeYxDySqgPsYcfgLXywywM3XG6UbhBB7KyAPkk5cejFEdHChm5KrhdNKEpJN84Q2HBq89uknwhz4KY.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Findex%2Fcopyright.html', '超级管理员在2017-11-15 10:55:04退出了管理系统', '1', 'pc', '1510714504', '30160667', '', '0', '0');
