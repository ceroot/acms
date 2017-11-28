-- -----------------------------
-- Think MySQL Data Transfer 
-- 
-- Host     : 
-- Port     : 
-- Database : 
-- 
-- Part : #1
-- Date : 2017-11-27 16:52:23
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
INSERT INTO `cy_action_log` VALUES ('4', '1', '1', 'manager', 'POST', '1', '/console/start/index/time/1510714504.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Findex%2Fcopyright.html', '超级管理员在2017-11-15 10:55:10登录了管理系统', '1', 'pc', '1510714510', '30160667', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('5', '30', '1', 'manager', 'POST', '1', '/console/manager/info.html', '超级管理员在2017-11-15 11:26:33修改了个人信息', '1', 'pc', '1510716393', '30160667', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('6', '30', '1', 'manager', 'POST', '1', '/console/manager/info.html', '超级管理员在2017-11-15 12:11:23修改了个人信息', '1', 'pc', '1510719083', '30160667', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('7', '1', '1', 'manager', 'POST', '1', '/console/start/index/time/1510724216.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole', '超级管理员在2017-11-15 13:37:24登录了管理系统', '1', 'mobile', '1510724244', '3748159399', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('8', '2', '1', 'manager', 'POST', '1', '/console/start/logout/time/20171115133908YHWqJn67Vwx7ALzjJHhWhedQAjjKU2sKmk2UAK7kuxpafWJntU5tgDpkDpMTjMfsBQFswvWbsHACDW5j2DKNTYpbRttgHeVF99tDSNk86BYp26K3PYUwdxWxxYacQDFm.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fweb_log%2Flists.html', '超级管理员在2017-11-15 13:39:31退出了管理系统', '1', 'mobile', '1510724371', '3748159399', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('9', '1', '1', 'manager', 'POST', '1', '/console/start/index/time/1510738569.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole', '超级管理员在2017-11-15 17:36:27登录了管理系统', '1', 'pc', '1510738587', '30160667', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('10', '9', '1', 'manager', 'POST', '2', '/console/manager/renew.html', '超级管理员在2017-11-15 17:38:32修改了管理用户', '1', 'pc', '1510738712', '30160667', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('11', '9', '1', 'manager', 'POST', '2', '/console/manager/renew.html', '超级管理员在2017-11-15 17:38:36修改了管理用户', '1', 'pc', '1510738716', '30160667', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('12', '2', '1', 'manager', 'POST', '1', '/console/start/logout/time/20171115173923cPDUmGWhbyt5BvrP8qWchCbPA4uDCRmzUNvRezvRtGVgL6uzuRjauz6NPCa92m6vZ7S2mVAaYUqrhtNgShMNYkwnHUNEuAxu8Wb8P64qMAaRytvbf7hGD9r5rD9DPgaK.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fauth_group%2Frule%2Fid%2F5f39Ut', '超级管理员在2017-11-15 17:40:17退出了管理系统', '1', 'pc', '1510738817', '30160667', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('13', '1', '2', 'manager', 'POST', '2', '/console/start/index/time/1510738817.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fauth_group%2Frule%2Fid%2F5f39Ut-M7j-TRFQ6sct%255EBkjqwO7Q533%255EGhxaym8G.html', 'ceroot在2017-11-15 17:40:25登录了管理系统', '1', 'pc', '1510738825', '30160667', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('14', '2', '2', 'manager', 'POST', '2', '/console/start/logout/time/20171115174030dwLmxWPwFRfZ5TKeBdsYk5draYpL5hADPD8WY2G5Kss9rNVUASeMpM7Ub9Pv4wf2MCeGUDYDFgGXyyMFUAw4GWv5Kyeu29BS9hVHaWq6xYtdHfeaJPGL73ec8crgQy2h.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Findex%2Findex%2Ftime%2F15107388', 'ceroot在2017-11-15 17:40:40退出了管理系统', '1', 'pc', '1510738840', '30160667', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('15', '1', '1', 'manager', 'POST', '1', '/console/start/index/time/1510738840.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Findex%2Findex%2Ftime%2F1510738827.html%3Fbackurl%3Dhttp%253A%252F%252Fwww.benweng.com%252Fconsole%252Fauth_group%252Frule%252Fid%252F5f39Ut-M7j-TRFQ6sct%25255EBkjqw', '超级管理员在2017-11-15 17:40:48登录了管理系统', '1', 'pc', '1510738848', '30160667', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('16', '9', '1', 'manager', 'POST', '2', '/console/manager/renew.html', '超级管理员在2017-11-15 17:41:06修改了管理用户', '1', 'pc', '1510738866', '30160667', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('17', '2', '1', 'manager', 'POST', '1', '/console/start/logout/time/20171115174056kKnBLjMMrbRNcLhM7neUvy9gjW5MpZZxr9yXARnNmC8KQsnmt4epcKEhYhmc4mSsd7LuSnyDcKaFBXxVGzbYAbfUZfB8Ha9WXpz3cAXgh8gbfKWugq7a4cCTAE5pMXsE.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fmanager%2Flists.html', '超级管理员在2017-11-15 17:41:12退出了管理系统', '1', 'pc', '1510738872', '30160667', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('18', '1', '2', 'manager', 'POST', '2', '/console/start/index/time/1510738872.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fmanager%2Flists.html', 'ceroot在2017-11-15 17:41:18登录了管理系统', '1', 'pc', '1510738878', '30160667', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('19', '2', '2', 'manager', 'POST', '2', '/console/start/logout/time/20171115174154bRzG6GEz6eNrf7ZtzsUZTu6bMQZ8u6qpXTLXx85nQZTvUsx7Q5m57ueCPMntLW5gdAjB6tEerPcQs5Ya8GFPMJz6h32uyKMFmGTADy6YD3Pk835DY3yrh6Bc9GNQ9LQk.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fweb_log%2Flists.html', 'ceroot在2017-11-15 17:55:09退出了管理系统', '1', 'pc', '1510739709', '30160667', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('20', '1', '2', 'manager', 'POST', '2', '/console/start/index/time/1510724371.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fweb_log%2Flists.html', 'ceroot在2017-11-15 21:01:48登录了管理系统', '1', 'mobile', '1510750908', '1971836001', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('21', '30', '2', 'manager', 'POST', '2', '/console/manager/info.html', 'ceroot在2017-11-16 07:47:42修改了个人信息', '1', 'mobile', '1510789662', '1971836024', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('22', '30', '2', 'manager', 'POST', '2', '/console/manager/info.html', 'ceroot在2017-11-16 07:47:45修改了个人信息', '1', 'mobile', '1510789665', '1971836024', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('23', '1', '1', 'manager', 'POST', '1', '/console/start/index/time/1510801176.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole', '超级管理员在2017-11-16 10:59:47登录了管理系统', '1', 'mobile', '1510801187', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('24', '1', '1', 'manager', 'POST', '1', '/console/start/index/time/1510804608.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole', '超级管理员在2017-11-16 11:56:55登录了管理系统', '1', 'pc', '1510804615', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('25', '2', '1', 'manager', 'POST', '1', '/console/start/logout/time/20171116115657NJxGfbrxVgHk6zVRychhrdnqmqvRDtwggzChFvr6D8cxYVsx5QmgqKnSqKek2d7QxpLvAzQzgchpmMLfvh2vHtjJ5ZeH2hmSEK3xGtXYjzgekudhQcGk8sYpkkAk9Gdr.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole', '超级管理员在2017-11-16 11:57:01退出了管理系统', '1', 'pc', '1510804621', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('26', '1', '1', 'manager', 'POST', '1', '/console/start/index/time/1510804621.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole', '超级管理员在2017-11-16 11:58:58登录了管理系统', '1', 'pc', '1510804738', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('27', '1', '1', 'manager', 'POST', '1', '/console/start/', '超级管理员在2017-11-16 12:24:15登录了管理系统', '1', 'pc', '1510806255', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('28', '1', '1', 'manager', 'POST', '1', '/console/start', '超级管理员在2017-11-16 13:19:50登录了管理系统', '1', 'weixin', '1510809590', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('29', '1', '1', 'manager', 'POST', '1', '/console/start/index/time/1510822647.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole', '超级管理员在2017-11-16 16:57:37登录了管理系统', '1', 'pc', '1510822657', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('30', '9', '1', 'manager', 'POST', '3', '/console/manager/renew.html', '超级管理员在2017-11-16 17:15:57修改了管理用户', '1', 'pc', '1510823757', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('31', '10', '1', 'Manager', 'DELETE', '4', '/console/manager/del.html?id=db66P7FThYJ2Xc--Lka5EftPa35RAydFTzTIRMxn', '超级管理员在2017-11-16 17:16:10删除了用户', '1', 'pc', '1510823770', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('32', '10', '1', 'Manager', 'DELETE', '5', '/console/manager/del.html?id=8ad7FHEbEESq0ZUm4FdwbDY7ETSBBtFcR2PgBkFY', '超级管理员在2017-11-16 17:16:21删除了用户', '1', 'pc', '1510823781', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('33', '10', '1', 'Manager', 'DELETE', '6', '/console/manager/del.html?id=6023C9jsNv3zhbtdnY4MO2MQM6id2eyGvjkar2ju', '超级管理员在2017-11-16 17:16:23删除了用户', '1', 'pc', '1510823783', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('34', '16', '1', 'AuthRule', 'GET', '80', '/console/auth_rule/updateshow/id/ca87-q7C0rGH8cpDtB8HC2y5gYz-w8GDwwUa4cHGHw.html', '超级管理员在2017-11-16 17:16:54设置了控制台菜单显示状态', '1', 'pc', '1510823814', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('35', '16', '1', 'AuthRule', 'GET', '291', '/console/auth_rule/updateshow/id/b3acV2oVN5FafrEskQ10QwE8cxL3z-9lhpWt1BvBmwQ.html', '超级管理员在2017-11-16 17:18:07设置了控制台菜单显示状态', '1', 'pc', '1510823887', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('36', '83', '1', 'UcenterMember', 'POST', '2', '/console/ucenter_member/renew.html', '超级管理员在2017-11-16 17:19:02修改了本地用户编辑', '1', 'pc', '1510823942', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('37', '2', '1', 'manager', 'POST', '1', '/console/start/logout/time/20171116171939EhXxK2yNBAAhaLYDvFP5EsW4DqK66Xu8tDve54tQYC3j3QDF3N9LGF8QAdRuDhSPER4DzeFxXQbLejvq2SQzbRBACxNQVHawaYjyqfSs6U5SG8s4Wut5mfRK3BZJZyBD.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fucenter_member%2Flists.html', '超级管理员在2017-11-16 17:20:00退出了管理系统', '1', 'pc', '1510824000', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('38', '1', '1', 'manager', 'POST', '1', '/console/start/index/time/1510824000.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fucenter_member%2Flists.html', '超级管理员在2017-11-16 17:20:07登录了管理系统', '1', 'pc', '1510824007', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('39', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510824034.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fucenter_member%2Flists.html', '测试用户在2017-11-16 17:20:42登录了管理系统', '1', 'pc', '1510824042', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('40', '9', '1', 'manager', 'POST', '3', '/console/manager/renew.html', '超级管理员在2017-11-16 17:21:13修改了管理用户', '1', 'pc', '1510824073', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('41', '2', '1', 'manager', 'POST', '1', '/console/start/logout/time/20171116172107G63n6r8fPddA8c6btsUKkZFsRXwxtJ7hQARR8DHWhL5gn6WsMHTrt9ukhHmQq3zwyzFeVebEZyxup9d2JfDswucVXyvdDGmB2NqxQczDJE4zDUyFecmHUqkdkjFzHejk.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fmanager%2Flists.html', '超级管理员在2017-11-16 17:21:41退出了管理系统', '1', 'pc', '1510824101', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('42', '1', '1', 'manager', 'POST', '1', '/console/start/index/time/1510824101.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fmanager%2Flists.html', '超级管理员在2017-11-16 17:22:13登录了管理系统', '1', 'pc', '1510824133', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('43', '29', '1', 'Manager', 'POST', '1', '/console/manager/password.html', '超级管理员在2017-11-16 17:22:28修改了密码', '1', 'pc', '1510824148', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('44', '2', '1', 'manager', 'POST', '1', '/console/start/logout/time/20171116172220EeCFmXTKKnaY6s7PjyQPn6GnMBYSW6c8cujxLsrpyqjvU6cWh5ZmQfhk4LXJu5V7wC4tHQestuvLFRN3QEpRpT8GnStH6VxzEPYrTWjdD95yeQueddfQy9hCAkpRmUk4.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fmanager%2Fpassword.html', '超级管理员在2017-11-16 17:22:31退出了管理系统', '1', 'pc', '1510824151', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('45', '1', '1', 'manager', 'POST', '1', '/console/start/index/time/1510824151.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fmanager%2Fpassword.html', '超级管理员在2017-11-16 17:22:38登录了管理系统', '1', 'pc', '1510824158', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('46', '6', '1', 'Action', 'DELETE', '82', '/console/action/del.html?id=8e9cgW9WENJIgeY3crlZzAkHe7lHOYHArmWeLn8lbg', '超级管理员在2017-11-16 17:31:06删除了行为', '1', 'pc', '1510824666', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('47', '6', '1', 'Action', 'DELETE', '81', '/console/action/del.html?id=b5a2BgTAWUvTz4jZVjKh0zahFSoO2ObsrxNFIV6CkA', '超级管理员在2017-11-16 17:31:09删除了行为', '1', 'pc', '1510824669', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('48', '6', '1', 'Action', 'DELETE', '80', '/console/action/del.html?id=5bd4KJHfTtr9XSUZ^WNF-jQr5CKnT^x8qPmCdDFWSA', '超级管理员在2017-11-16 17:31:12删除了行为', '1', 'pc', '1510824672', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('49', '6', '1', 'Action', 'DELETE', '79', '/console/action/del.html?id=7a37jvtSnog-J7EAw7g3zHkFwjMtSCn0IMz-4phE-w', '超级管理员在2017-11-16 17:31:14删除了行为', '1', 'pc', '1510824674', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('50', '6', '1', 'Action', 'DELETE', '78', '/console/action/del.html?id=fdd8Ox10DLJJ5WU^l3awVxBjWdxLoNGSpTQVIpCwOg', '超级管理员在2017-11-16 17:31:17删除了行为', '1', 'pc', '1510824677', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('51', '6', '1', 'Action', 'DELETE', '77', '/console/action/del.html?id=4ba2glnqzOlB-Qbtwx38ZvTyDAm8bUKWQ-7ohRnSow', '超级管理员在2017-11-16 17:31:19删除了行为', '1', 'pc', '1510824679', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('52', '6', '1', 'Action', 'DELETE', '76', '/console/action/del.html?id=7fe1vX^V9CNyJ0x0Y00NNjC9u-OLLhiYotbWFKUX1w', '超级管理员在2017-11-16 17:31:22删除了行为', '1', 'pc', '1510824682', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('53', '6', '1', 'Action', 'DELETE', '75', '/console/action/del.html?id=77b905iRKCuzpsRG75Ktat^andiF^IX6xDDPIxHdMg', '超级管理员在2017-11-16 17:31:26删除了行为', '1', 'pc', '1510824686', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('54', '6', '1', 'Action', 'DELETE', '65', '/console/action/del.html?id=b48fb7H8cdwlRkg87peqT2UyDbXqrvspKi0fhsUyqA', '超级管理员在2017-11-16 17:31:30删除了行为', '1', 'pc', '1510824690', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('55', '6', '1', 'Action', 'DELETE', '64', '/console/action/del.html?id=92e8ap1rPZv9-8nTyavb2dEMQHaUrqEgOK0jmHdFPg', '超级管理员在2017-11-16 17:31:33删除了行为', '1', 'pc', '1510824693', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('56', '6', '1', 'Action', 'DELETE', '63', '/console/action/del.html?id=3ccfif3p489cd0AlIzY6AXhMk5YeQ0NBkZRqC449Fw', '超级管理员在2017-11-16 17:31:36删除了行为', '1', 'pc', '1510824696', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('57', '2', '1', 'manager', 'POST', '1', '/console/start/logout/time/20171116174858vyMbgGV2X2sqdt478LcJNXrQLqZ8U3Pxr3x3nq9p9KVEhuxTbjTPdAWqVzLZhGwn2ExA3bNGtDMjfdsHpDdjhFeJnpG88j5yCjhBGrqxM8b7tm2PvAJfmJDTwNtWqt5e.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fmanager%2Finfo.html', '超级管理员在2017-11-16 17:49:03退出了管理系统', '1', 'weixin', '1510825743', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('58', '9', '1', 'manager', 'POST', '3', '/console/manager/renew.html', '超级管理员在2017-11-16 17:50:39修改了管理用户', '1', 'pc', '1510825839', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('59', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510825743.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fmanager%2Finfo.html', '测试用户在2017-11-16 17:50:45登录了管理系统', '1', 'weixin', '1510825845', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('60', '2', '3', 'manager', 'POST', '3', '/console/start/logout/time/20171116172125xqgz4B6pt6Hc6xWWavxWLXxrGjLNjtpfCNzXmyuXhLsESQ3WHZKvqGK6RkEydjkEeTA3aM46VnRJcXTHJU3La43eqAq8yFhPH9WKu3S3Yay7yRcDJFFPydGw7cdZCp6z.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Findex%2Findex%2Ftime%2F20171116', '测试用户在2017-11-16 17:53:49退出了管理系统', '1', 'pc', '1510826029', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('61', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510826029.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Findex%2Findex%2Ftime%2F20171116172117AHvM4vPp6aG5He5x4qKmHdtAj4GpSg6kET4NvKRFf5HAY4w4WmQnbdEs7TUKZbvuLXcY68eAatejTu8T2G5HnLJ77KeSkaNLHwmX9CfsywabpFVJKAtMURxzUghBqUv', '测试用户在2017-11-16 17:55:56登录了管理系统', '1', 'pc', '1510826156', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('62', '2', '3', 'manager', 'POST', '3', '/console/start/logout/time/201711161804304eFYAVuJ6sUj8p7AUHHLTB3WQ3umJuEDWGq89bEBMAha6t6SpX5szTb9Gsj6JS9ZpdQqhNP6mfPqCPCBWAkwURGfKtuJ8Wvd4wyW5mCkX7Rm4dC7vZaCYJSRCd2hKUSh.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole', '测试用户在2017-11-16 18:04:41退出了管理系统', '1', 'weixin', '1510826681', '3748159210', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('63', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510826681.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole', '测试用户在2017-11-16 18:05:00登录了管理系统', '1', 'weixin', '1510826700', '3748159210', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('64', '1', '1', 'manager', 'POST', '1', '/console/start/index/time/1510833895.html?backurl=http%3A%2F%2Fbenweng.com%2Fconsole', '超级管理员在2017-11-16 20:05:23登录了管理系统', '1', 'mobile', '1510833923', '1971836024', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('65', '1', '1', 'manager', 'POST', '1', '/console/start/index/time/1510841712.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fweb_log%2Flists.html', '超级管理员在2017-11-16 22:15:35登录了管理系统', '1', 'mobile', '1510841735', '1971836024', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('66', '2', '1', 'manager', 'POST', '1', '/console/start/logout/time/20171116230649GKZkvA4H5kEq6crsVPRmfXHFVFMutzEG8ME8kNfyEp4EXE7z8YjRMEdNHZCSsh5fgEqwcGVVMbzpxrfxCNG7YqEPVtHUEGC97dfmG4dgTH3yDCYGLyFrwz6P6SQyScHP.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Faction_log%2Flists.html', '超级管理员在2017-11-16 23:06:57退出了管理系统', '1', 'mobile', '1510844817', '1971836024', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('67', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:09:41登录了管理系统', '1', 'mobile', '1510844981', '1971836024', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('68', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:09:51登录了管理系统', '1', 'pc', '1510844991', '2876231973', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('69', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:10:01登录了管理系统', '1', 'pc', '1510845001', '3083523669', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('70', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:10:08登录了管理系统', '1', 'pc', '1510845008', '244331890', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('71', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:10:08登录了管理系统', '1', 'mobile', '1510845008', '3748178559', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('72', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:10:45登录了管理系统', '1', 'mobile', '1510845045', '1971859059', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('73', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:10:55登录了管理系统', '1', 'mobile', '1510845055', '3748178559', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('74', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:12:37登录了管理系统', '1', 'mobile', '1510845157', '1894077401', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('75', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:13:25登录了管理系统', '1', 'mobile', '1510845205', '3748135880', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('76', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:13:38登录了管理系统', '1', 'mobile', '1510845218', '1960928114', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('77', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:14:10登录了管理系统', '1', 'mobile', '1510845250', '3748135880', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('78', '1', '1', 'manager', 'POST', '1', '/console/start', '超级管理员在2017-11-16 23:14:54登录了管理系统', '1', 'weixin', '1510845294', '1971836024', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('79', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:14:57登录了管理系统', '1', 'mobile', '1510845297', '1960928114', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('80', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:15:03登录了管理系统', '1', 'weixin', '1510845303', '1894077401', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('81', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:15:43登录了管理系统', '1', 'mobile', '1510845343', '1960928114', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('82', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:16:07登录了管理系统', '1', 'mobile', '1510845367', '1960928114', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('83', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:16:19登录了管理系统', '1', 'mobile', '1510845379', '2032138997', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('84', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:16:22登录了管理系统', '1', 'mobile', '1510845382', '29663824', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('85', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:17:01登录了管理系统', '1', 'pc', '1510845421', '2004602272', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('86', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:17:24登录了管理系统', '1', 'mobile', '1510845444', '608163229', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('87', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:18:04登录了管理系统', '1', 'mobile', '1510845484', '828019014', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('88', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:20:53登录了管理系统', '1', 'pc', '1510845653', '976995722', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('89', '2', '3', 'manager', 'POST', '3', '/console/start/logout/time/201711162321382LTFCZbUrmWVLWxGZeVSQ6VsuKSZb9XDwCj5cZat8DBEQqSEw7HbyJETvn2v3ATnxMnZcYA9LTqYb9C8Cs6qFaAJ2dG7mADCQTDEPhZk5Wb5GMFDtVZ9SvmUCkjDyyWd.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fcache%2Findex.html', '测试用户在2017-11-16 23:21:43退出了管理系统', '1', 'mobile', '1510845703', '29663824', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('90', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:22:39登录了管理系统', '1', 'mobile', '1510845759', '1700254389', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('91', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:23:40登录了管理系统', '1', 'pc', '1510845820', '2004587537', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('92', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:24:08登录了管理系统', '1', 'pc', '1510845848', '658995407', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('93', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:25:03登录了管理系统', '1', 'mobile', '1510845903', '2102573716', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('94', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:25:18登录了管理系统', '1', 'mobile', '1510845918', '2102573716', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('95', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:25:50登录了管理系统', '1', 'mobile', '1510845950', '606152123', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('96', '1', '1', 'manager', 'POST', '1', '/console/start', '超级管理员在2017-11-16 23:27:34登录了管理系统', '1', 'weixin', '1510846054', '1971836024', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('97', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:27:43登录了管理系统', '1', 'pc', '1510846063', '1918251059', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('98', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:29:16登录了管理系统', '1', 'mobile', '1510846156', '3550560674', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('99', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:30:31登录了管理系统', '1', 'pc', '1510846231', '2875069690', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('100', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:32:48登录了管理系统', '1', 'mobile', '1510846368', '659801306', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('101', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:36:34登录了管理系统', '1', 'mobile', '1510846594', '1968241713', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('102', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:47:20登录了管理系统', '1', 'mobile', '1510847240', '1971865132', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('103', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:49:11登录了管理系统', '1', 'mobile', '1510847351', '1974344306', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('104', '1', '1', 'manager', 'POST', '1', '/console/start', '超级管理员在2017-11-16 23:51:30登录了管理系统', '1', 'weixin', '1510847490', '1971836024', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('105', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:52:20登录了管理系统', '1', 'pc', '1510847540', '3070850006', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('106', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-16 23:54:39登录了管理系统', '1', 'pc', '1510847679', '3736520103', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('107', '1', '1', 'manager', 'POST', '1', '/console/start', '超级管理员在2017-11-17 00:23:41登录了管理系统', '1', 'weixin', '1510849421', '1971836024', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('108', '14', '1', 'AuthRule', 'GET', '266', '/console/auth_rule/del/id/2dde9lYBDfr9HQFHM50HWDm4N0Axy6MOtrUubXDzefE.html', '超级管理员在2017-11-17 00:27:24删除了规则', '1', 'weixin', '1510849644', '1971836024', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('109', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-17 06:09:48登录了管理系统', '1', 'mobile', '1510870188', '1971867598', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('110', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-17 07:37:04登录了管理系统', '1', 'mobile', '1510875424', '3746215043', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('111', '1', '1', 'manager', 'POST', '1', '/console/start', '超级管理员在2017-11-17 07:42:32登录了管理系统', '1', 'weixin', '1510875752', '1971836024', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('112', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-17 08:01:54登录了管理系统', '1', 'mobile', '1510876914', '18744889', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('113', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-17 08:50:40登录了管理系统', '1', 'pc', '1510879840', '607102932', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('114', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-17 08:50:59登录了管理系统', '1', 'pc', '1510879859', '607102932', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('115', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-17 09:02:27登录了管理系统', '1', 'pc', '1510880547', '1987736281', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('116', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-17 09:08:18登录了管理系统', '1', 'mobile', '1510880898', '29175289', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('117', '1', '1', 'manager', 'POST', '1', '/console/start/index/time/1510882170.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fucenter_member%2Findex.html', '超级管理员在2017-11-17 09:29:37登录了管理系统', '1', 'pc', '1510882177', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('118', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-17 09:33:08登录了管理系统', '1', 'pc', '1510882388', '1875874946', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('119', '1', '3', 'manager', 'POST', '3', '/console/start', '测试用户在2017-11-17 10:30:42登录了管理系统', '1', 'weixin', '1510885842', '1020329143', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('120', '14', '1', 'AuthRule', 'GET', '307', '/console/auth_rule/del/id/b608zyxSc%5E9PM18Lg26wlvIoOCizaDDbVDjs9Hhlou8.html', '超级管理员在2017-11-17 11:08:56删除了规则', '1', 'pc', '1510888136', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('121', '14', '1', 'AuthRule', 'GET', '306', '/console/auth_rule/del/id/2d00dva9q3z0W61TUgTjk5Eb%5E4tQoWGMtV6ypQ3uQsY.html', '超级管理员在2017-11-17 11:09:02删除了规则', '1', 'pc', '1510888142', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('122', '14', '1', 'AuthRule', 'GET', '278', '/console/auth_rule/del/id/2f70i-mY%5EnVg6H%5EtRA2Dfl7Vwkh%5EBTrP%5ENPkuNXXpg8.html', '超级管理员在2017-11-17 11:09:08删除了规则', '1', 'pc', '1510888148', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('123', '14', '1', 'AuthRule', 'GET', '277', '/console/auth_rule/del/id/65b9XRMcfKqySCodz%5EkRY2S%5EPsghSg0bv6ZqT70A-5Y.html', '超级管理员在2017-11-17 11:09:14删除了规则', '1', 'pc', '1510888154', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('124', '14', '1', 'AuthRule', 'GET', '276', '/console/auth_rule/del/id/78cdsVz48taWs5AdE6yovLDUzo1i18i--e5B0exMfl8.html', '超级管理员在2017-11-17 11:09:22删除了规则', '1', 'pc', '1510888162', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('125', '14', '1', 'AuthRule', 'GET', '275', '/console/auth_rule/del/id/58fcpS7FYTOssqhHFjmu2bbSZUrIdFZvJpcq6PwIea0.html', '超级管理员在2017-11-17 11:09:28删除了规则', '1', 'pc', '1510888168', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('126', '14', '1', 'AuthRule', 'GET', '274', '/console/auth_rule/del/id/379apEXL1sIwgppR3ILbxlaBBY4dRKzat%5EZmwgCD3nU.html', '超级管理员在2017-11-17 11:09:35删除了规则', '1', 'pc', '1510888175', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('127', '14', '1', 'AuthRule', 'GET', '273', '/console/auth_rule/del/id/1f9fUQ0hH-lBzjASLbPCpx3KO355OX3vLpDFzzjLjCo.html', '超级管理员在2017-11-17 11:09:40删除了规则', '1', 'pc', '1510888180', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('128', '14', '1', 'AuthRule', 'GET', '272', '/console/auth_rule/del/id/d61dJHohTlXv5ok4miDPG-NznjPoSBKDxH%5ElTfsCWNg.html', '超级管理员在2017-11-17 11:09:45删除了规则', '1', 'pc', '1510888185', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('129', '14', '1', 'AuthRule', 'GET', '271', '/console/auth_rule/del/id/e160izB%5EnVuF3A%5EHL3NSo2aTzDu50UzgR%5ENvGoNQnW8.html', '超级管理员在2017-11-17 11:09:51删除了规则', '1', 'pc', '1510888191', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('130', '14', '1', 'AuthRule', 'GET', '270', '/console/auth_rule/del/id/290eRDtx8DCAX3C%5EmJ4tIfrJokjsBbUBlv1o32QBfWs.html', '超级管理员在2017-11-17 11:09:56删除了规则', '1', 'pc', '1510888196', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('131', '14', '1', 'AuthRule', 'GET', '269', '/console/auth_rule/del/id/15a4cgt2uInDA4KRsI7J92grBIHmYDEdAGYsOr83vOc.html', '超级管理员在2017-11-17 11:10:03删除了规则', '1', 'pc', '1510888203', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('132', '14', '1', 'AuthRule', 'GET', '265', '/console/auth_rule/del/id/5500Dqxrwq5MnRZKjlUn%5E2XsFD9mmqF3J4Mgy9VFw78.html', '超级管理员在2017-11-17 11:10:10删除了规则', '1', 'pc', '1510888210', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('133', '14', '1', 'AuthRule', 'GET', '264', '/console/auth_rule/del/id/3ca1XUiq1ikPC769BC3SWSrlXLaHb8HIzHnkLD-aMFM.html', '超级管理员在2017-11-17 11:10:20删除了规则', '1', 'pc', '1510888220', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('134', '14', '1', 'AuthRule', 'GET', '263', '/console/auth_rule/del/id/0047ZBwz9vKIKFK7yb58bHdMNWMh%5Eztb4rbK3WQO%5Elw.html', '超级管理员在2017-11-17 11:10:28删除了规则', '1', 'pc', '1510888228', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('135', '14', '1', 'AuthRule', 'GET', '262', '/console/auth_rule/del/id/7f50RY6BC2%5ERm4shlhKPQ3zXUDXvJJXURv2OlJYK0RE.html', '超级管理员在2017-11-17 11:10:34删除了规则', '1', 'pc', '1510888234', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('136', '14', '1', 'AuthRule', 'GET', '261', '/console/auth_rule/del/id/b0c6lTtplUeeOf44ZgVeK4HFz5YmWyZAlZL1fETYgyY.html', '超级管理员在2017-11-17 11:10:42删除了规则', '1', 'pc', '1510888242', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('137', '14', '1', 'AuthRule', 'GET', '260', '/console/auth_rule/del/id/2b24Mq47bvAhnW6A6rwb7wrQbqy2Sp0j3IWIs4B6zT0.html', '超级管理员在2017-11-17 11:10:48删除了规则', '1', 'pc', '1510888248', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('138', '14', '1', 'AuthRule', 'GET', '259', '/console/auth_rule/del/id/1fd47F9IagvOC9mX4X8HEZQSOBaw%5EWtCVglqAYLNxqg.html', '超级管理员在2017-11-17 11:10:55删除了规则', '1', 'pc', '1510888255', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('139', '14', '1', 'AuthRule', 'GET', '258', '/console/auth_rule/del/id/ed1d%5E5%5ERcxkgLY4RjskH%5EXXcwP-nvYM8d2M%5E3X0JbtU.html', '超级管理员在2017-11-17 11:11:00删除了规则', '1', 'pc', '1510888260', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('140', '14', '1', 'AuthRule', 'GET', '257', '/console/auth_rule/del/id/046b2mijnk1XgYsmhA5jH12b2nAKjH0wwVXJzdt74N4.html', '超级管理员在2017-11-17 11:11:07删除了规则', '1', 'pc', '1510888267', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('141', '14', '1', 'AuthRule', 'GET', '256', '/console/auth_rule/del/id/a726SBZpzv3HzG3GFK4bBTB4oSzzhdWUxeeb516hCcM.html', '超级管理员在2017-11-17 11:11:14删除了规则', '1', 'pc', '1510888274', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('142', '14', '1', 'AuthRule', 'GET', '255', '/console/auth_rule/del/id/e16cSCs4UdiE3VIj0iMqPz-bljqXZyiub7ztUSkcKHk.html', '超级管理员在2017-11-17 11:11:21删除了规则', '1', 'pc', '1510888281', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('143', '14', '1', 'AuthRule', 'GET', '254', '/console/auth_rule/del/id/0800J0A8TpLCg7BSucx8eimdp4NKeQekERdnUDk8BNY.html', '超级管理员在2017-11-17 11:11:29删除了规则', '1', 'pc', '1510888289', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('144', '14', '1', 'AuthRule', 'GET', '253', '/console/auth_rule/del/id/2985ZT7mIQSdYz9yGf3s2PQI-UCQwEDTrBvAxUmZI-I.html', '超级管理员在2017-11-17 11:11:36删除了规则', '1', 'pc', '1510888296', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('145', '14', '1', 'AuthRule', 'GET', '252', '/console/auth_rule/del/id/62a2ys%5EEH73TqWR1isLQ8phO0EM-FgE0RouUCr9OW9A.html', '超级管理员在2017-11-17 11:11:44删除了规则', '1', 'pc', '1510888304', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('146', '14', '1', 'AuthRule', 'GET', '268', '/console/auth_rule/del/id/9788tS4M9vul3rcm1u0pWhGvDDjuXZrCyiwD4ECPFok.html', '超级管理员在2017-11-17 11:11:51删除了规则', '1', 'pc', '1510888311', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('147', '14', '1', 'AuthRule', 'GET', '267', '/console/auth_rule/del/id/eccc%5EiQ7qRxPJbi2gH0gKdr0zqRrJGUFIyrKDA8Xbqw.html', '超级管理员在2017-11-17 11:11:58删除了规则', '1', 'pc', '1510888318', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('148', '14', '1', 'AuthRule', 'GET', '251', '/console/auth_rule/del/id/5208KJqkJWfMQZC3Kof52-cRfZtoUf%5Ebt5gRXRYFPh4.html', '超级管理员在2017-11-17 11:12:05删除了规则', '1', 'pc', '1510888325', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('149', '14', '1', 'AuthRule', 'GET', '250', '/console/auth_rule/del/id/ff71lI3ctBJmvtDqWm1Pi4cRiXFkQD7bqz%5EZk500bYk.html', '超级管理员在2017-11-17 11:12:10删除了规则', '1', 'pc', '1510888330', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('150', '14', '1', 'AuthRule', 'GET', '249', '/console/auth_rule/del/id/eeabh4epZUB1S0UontgCsKrPw7b8vQphRdzEi31fwL0.html', '超级管理员在2017-11-17 11:12:15删除了规则', '1', 'pc', '1510888335', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('151', '14', '1', 'AuthRule', 'GET', '248', '/console/auth_rule/del/id/cff9ZBZdY5WGsUXUQmEyxcETR-v%5EMD8NXiv0-mosdkE.html', '超级管理员在2017-11-17 11:12:19删除了规则', '1', 'pc', '1510888339', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('152', '14', '1', 'AuthRule', 'GET', '247', '/console/auth_rule/del/id/53b02OEwrTK4O0lOmYGpysQYgNBCUU0NLj47qeLC3NM.html', '超级管理员在2017-11-17 11:12:25删除了规则', '1', 'pc', '1510888345', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('153', '14', '1', 'AuthRule', 'GET', '246', '/console/auth_rule/del/id/90fdzSWpqeMxNoMVqcj2t15EaX-Bpx2dFrzs4sjDTKU.html', '超级管理员在2017-11-17 11:12:30删除了规则', '1', 'pc', '1510888350', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('154', '14', '1', 'AuthRule', 'GET', '245', '/console/auth_rule/del/id/4985ClmVSELI0o9ewY-9APPhrMYLHAUD3x%5EX48DddhA.html', '超级管理员在2017-11-17 11:12:35删除了规则', '1', 'pc', '1510888355', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('155', '14', '1', 'AuthRule', 'GET', '244', '/console/auth_rule/del/id/ad75yV0wXtW1CNFo9H%5EGc%5EClIdvsg%5EXFy1-UyocxiHs.html', '超级管理员在2017-11-17 11:12:40删除了规则', '1', 'pc', '1510888360', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('156', '14', '1', 'AuthRule', 'GET', '243', '/console/auth_rule/del/id/d808ccx5ONvd8ofmXQR3EtvjHKJ6DdLv82d3sxgs83U.html', '超级管理员在2017-11-17 11:12:45删除了规则', '1', 'pc', '1510888365', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('157', '14', '1', 'AuthRule', 'GET', '242', '/console/auth_rule/del/id/97518Pw9n7e07Br8cD1E7p3vMK4Aa-0CRNRG6jAKkp8.html', '超级管理员在2017-11-17 11:12:49删除了规则', '1', 'pc', '1510888369', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('158', '14', '1', 'AuthRule', 'GET', '241', '/console/auth_rule/del/id/20aajkUMHiU5J1cyoDl1rDjQ7pRcyd-F-uKd0pLp9ZY.html', '超级管理员在2017-11-17 11:12:53删除了规则', '1', 'pc', '1510888373', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('159', '14', '1', 'AuthRule', 'GET', '240', '/console/auth_rule/del/id/17b6aska1abLFE-wV6zR7LG77dYcVi2sW6VuikWwfoM.html', '超级管理员在2017-11-17 11:12:59删除了规则', '1', 'pc', '1510888379', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('160', '14', '1', 'AuthRule', 'GET', '239', '/console/auth_rule/del/id/d00dpFjv0jbjMC40mjJb8Nlr1vsuN6e7vK9PGaudlwA.html', '超级管理员在2017-11-17 11:13:05删除了规则', '1', 'pc', '1510888385', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('161', '14', '1', 'AuthRule', 'GET', '238', '/console/auth_rule/del/id/ea2flM8gMBnaAfprRWLvyhoO6gSiQpd14ecf9sC7LZY.html', '超级管理员在2017-11-17 11:13:10删除了规则', '1', 'pc', '1510888390', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('162', '14', '1', 'AuthRule', 'GET', '237', '/console/auth_rule/del/id/79c7sAkd876-nJfaLtoVs0glB1NaPRaEX-00WHr0fkk.html', '超级管理员在2017-11-17 11:13:16删除了规则', '1', 'pc', '1510888396', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('163', '14', '1', 'AuthRule', 'GET', '236', '/console/auth_rule/del/id/188dZ2XqQ9reuavnO48oYwg4kTbzjtK1Yc8sUR3Imf4.html', '超级管理员在2017-11-17 11:13:24删除了规则', '1', 'pc', '1510888404', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('164', '14', '1', 'AuthRule', 'GET', '235', '/console/auth_rule/del/id/27c1JdfmZ2UaO76-4kKLqlKHV20TyC94J9fc52atT-I.html', '超级管理员在2017-11-17 11:13:30删除了规则', '1', 'pc', '1510888410', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('165', '14', '1', 'AuthRule', 'GET', '91', '/console/auth_rule/del/id/00a6iyjx0Bm4fhYkGEQkQ7CMRYVAYBVirG9qX4jSwA.html', '超级管理员在2017-11-17 11:13:35删除了规则', '1', 'pc', '1510888415', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('166', '13', '1', 'AuthRule', 'POST', '8', '/console/auth_rule/renew.html', '超级管理员在2017-11-17 11:28:17修改了规则', '1', 'pc', '1510889297', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('167', '13', '1', 'AuthRule', 'POST', '8', '/console/auth_rule/renew.html', '超级管理员在2017-11-17 11:28:49修改了规则', '1', 'pc', '1510889329', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('168', '2', '1', 'manager', 'POST', '1', '/console/start/logout/time/20171117115001MsN8p9yz9XKtEMYwwATFJZ57Vk6aY58MBEu7pL4jpG2EeQBvAKSQa3zJ37bKjvjTNzjgCW7SpR9BesfSD3fc9fQwznCZTA48zxVhN2GxK4JbxPHU6pJGsvzDnY9tBq2d.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fauth_group%2Flists.html%3Fpage%', '超级管理员在2017-11-17 11:50:13退出了管理系统', '1', 'pc', '1510890613', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('169', '1', '1', 'manager', 'POST', '1', '/console/start/index/time/1510890613.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fauth_group%2Flists.html%3Fpage%3D2', '超级管理员在2017-11-17 11:50:25登录了管理系统', '1', 'pc', '1510890625', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('170', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510896039.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fweb_log%2Flists.html', '测试用户在2017-11-17 13:23:16登录了管理系统', '1', 'pc', '1510896196', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('171', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510896198.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fweb_log%2Flists.html', '测试用户在2017-11-17 13:23:32登录了管理系统', '1', 'pc', '1510896212', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('172', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510896214.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fweb_log%2Flists.html', '测试用户在2017-11-17 13:27:37登录了管理系统', '1', 'pc', '1510896457', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('173', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510896481.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fweb_log%2Flists.html', '测试用户在2017-11-17 13:28:07登录了管理系统', '1', 'pc', '1510896487', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('174', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510896490.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fweb_log%2Flists.html', '测试用户在2017-11-17 13:30:22登录了管理系统', '1', 'pc', '1510896622', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('175', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510896624.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fweb_log%2Flists.html', '测试用户在2017-11-17 13:32:14登录了管理系统', '1', 'pc', '1510896734', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('176', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510896736.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fweb_log%2Flists.html', '测试用户在2017-11-17 13:33:01登录了管理系统', '1', 'pc', '1510896781', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('177', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510896783.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fweb_log%2Flists.html', '测试用户在2017-11-17 13:33:36登录了管理系统', '1', 'pc', '1510896816', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('178', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510896818.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fweb_log%2Flists.html', '测试用户在2017-11-17 13:37:49登录了管理系统', '1', 'pc', '1510897069', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('179', '1', '1', 'manager', 'POST', '1', '/console/start/index/time/1510896818.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fweb_log%2Flists.html', '超级管理员在2017-11-17 13:38:09登录了管理系统', '1', 'pc', '1510897089', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('180', '11', '1', 'Manager', 'POST', '3', '/console/manager/updatestatus.html?id=d241SB9K5RFxEh8RxBxqEGkqawLFVn4i4cHygweR', '超级管理员在2017-11-17 13:38:27禁用了管理用户', '1', 'pc', '1510897107', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('181', '11', '1', 'Manager', 'POST', '3', '/console/manager/updatestatus.html?id=d01c5kV5qf-m%5EVujRqMaz%5EDOL31X5ifEHDc7h8-P', '超级管理员在2017-11-17 13:39:28启用了管理用户', '1', 'pc', '1510897168', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('182', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510897071.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fweb_log%2Flists.html', '测试用户在2017-11-17 13:40:58登录了管理系统', '1', 'pc', '1510897258', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('183', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510897071.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fweb_log%2Flists.html', '测试用户在2017-11-17 13:53:48登录了管理系统', '1', 'pc', '1510898028', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('184', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510897260.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fweb_log%2Flists.html', '测试用户在2017-11-17 13:54:08登录了管理系统', '1', 'pc', '1510898048', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('185', '1', '1', 'manager', 'POST', '1', '/console/start/index/time/1510898120.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fmanager%2Flists.html', '超级管理员在2017-11-17 13:55:47登录了管理系统', '1', 'pc', '1510898147', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('186', '11', '1', 'Manager', 'POST', '3', '/console/manager/updatestatus.html?id=9844SZ6TpXiwzpDKHPIYqgJQMg2q%5Eopl1AiDLip9', '超级管理员在2017-11-17 13:56:16禁用了管理用户', '1', 'pc', '1510898176', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('187', '11', '1', 'Manager', 'POST', '3', '/console/manager/updatestatus.html?id=9844SZ6TpXiwzpDKHPIYqgJQMg2q%5Eopl1AiDLip9', '超级管理员在2017-11-17 13:58:27启用了管理用户', '1', 'pc', '1510898307', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('188', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510898050.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fweb_log%2Flists.html', '测试用户在2017-11-17 13:58:30登录了管理系统', '1', 'pc', '1510898310', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('189', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510898312.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fweb_log%2Flists.html', '测试用户在2017-11-17 13:58:41登录了管理系统', '1', 'pc', '1510898321', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('190', '11', '1', 'Manager', 'POST', '3', '/console/manager/updatestatus.html?id=9844SZ6TpXiwzpDKHPIYqgJQMg2q%5Eopl1AiDLip9', '超级管理员在2017-11-17 13:58:55禁用了管理用户', '1', 'pc', '1510898335', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('191', '11', '1', 'Manager', 'POST', '3', '/console/manager/updatestatus.html?id=9844SZ6TpXiwzpDKHPIYqgJQMg2q%5Eopl1AiDLip9', '超级管理员在2017-11-17 13:59:08启用了管理用户', '1', 'pc', '1510898348', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('192', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510898322.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fweb_log%2Flists.html', '测试用户在2017-11-17 13:59:15登录了管理系统', '1', 'pc', '1510898355', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('193', '11', '1', 'Manager', 'POST', '3', '/console/manager/updatestatus.html?id=9844SZ6TpXiwzpDKHPIYqgJQMg2q%5Eopl1AiDLip9', '超级管理员在2017-11-17 14:00:00禁用了管理用户', '1', 'pc', '1510898400', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('194', '11', '1', 'Manager', 'POST', '3', '/console/manager/updatestatus.html?id=9844SZ6TpXiwzpDKHPIYqgJQMg2q%5Eopl1AiDLip9', '超级管理员在2017-11-17 14:00:12启用了管理用户', '1', 'pc', '1510898412', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('195', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510898357.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fweb_log%2Flists.html', '测试用户在2017-11-17 14:00:15登录了管理系统', '1', 'pc', '1510898415', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('196', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510898417.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fweb_log%2Flists.html', '测试用户在2017-11-17 14:02:21登录了管理系统', '1', 'pc', '1510898541', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('197', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510898542.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fweb_log%2Flists.html', '测试用户在2017-11-17 14:04:19登录了管理系统', '1', 'pc', '1510898659', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('198', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510898662.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fweb_log%2Flists.html', '测试用户在2017-11-17 14:04:40登录了管理系统', '1', 'pc', '1510898680', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('199', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510898682.html', '测试用户在2017-11-17 14:04:53登录了管理系统', '1', 'pc', '1510898693', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('200', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510898694.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Findex%2Findex%2Ftime%2F20171117140453%2Fauthcode%2F3542hnI0syrVL6UJLWrwyxBrsCSvXDYIv4tYCwAK%255EmYdQ42WOMt2q66OQQ.html', '测试用户在2017-11-17 14:07:27登录了管理系统', '1', 'pc', '1510898847', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('201', '1', '1', 'manager', 'POST', '1', '/console/start/index/time/1510898848.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Findex%2Findex%2Ftime%2F20171117140453%2Fauthcode%2F3542hnI0syrVL6UJLWrwyxBrsCSvXDYIv4tYCwAK%255EmYdQ42WOMt2q66OQQ.html', '超级管理员在2017-11-17 14:07:52登录了管理系统', '1', 'pc', '1510898872', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('202', '2', '1', 'manager', 'POST', '1', '/console/start/logout/time/20171117140754KKWRvy2Zy36EAmabnB46y64K73RP57g4dwynjvMkzbRKR6HLAWRR5A4uegQ2fECrQbBgq6GBFwB6vJgSLVZvYR5eyApcTUXUehnXdgCwKDvaSRfSu7SaDeZXJNRNVxTS.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Findex%2Findex%2Ftime%2F20171117', '超级管理员在2017-11-17 14:07:58退出了管理系统', '1', 'pc', '1510898878', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('203', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510898878.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Findex%2Findex%2Ftime%2F20171117140453%2Fauthcode%2F3542hnI0syrVL6UJLWrwyxBrsCSvXDYIv4tYCwAK%255EmYdQ42WOMt2q66OQQ.html', '测试用户在2017-11-17 14:08:07登录了管理系统', '1', 'pc', '1510898887', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('204', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510898889.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Findex%2Findex%2Ftime%2F20171117140453%2Fauthcode%2F3542hnI0syrVL6UJLWrwyxBrsCSvXDYIv4tYCwAK%255EmYdQ42WOMt2q66OQQ.html', '测试用户在2017-11-17 14:13:12登录了管理系统', '1', 'pc', '1510899192', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('205', '2', '3', 'manager', 'POST', '3', '/console/start/logout/time/20171117141314YwqKbjGZUjtyuSRNCEbyMYGuKfGQZHESjhZ7RTMwAqNsUHDBgZGFvF7vpB8b7Y58quJQRe7WsHMuyT94CZ4xG3x8qVY6BYhgvxx4yb32SKjXYMYFSERaW8hKpzFXnq8z.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Findex%2Findex%2Ftime%2F20171117', '测试用户在2017-11-17 14:14:00退出了管理系统', '1', 'pc', '1510899240', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('206', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510899240.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Findex%2Findex%2Ftime%2F20171117140453%2Fauthcode%2F3542hnI0syrVL6UJLWrwyxBrsCSvXDYIv4tYCwAK%255EmYdQ42WOMt2q66OQQ.html', '测试用户在2017-11-17 14:14:06登录了管理系统', '1', 'pc', '1510899246', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('207', '2', '3', 'manager', 'POST', '3', '/console/start/logout/time/20171117141408t9yQSvC2GnH7a7dgVJjQW7A3nxktQkLZMR2cWpx6U5y6AzxkrcT9zbJceH9CNR5UvwrjdnBMPawpALq8HgeqMhJTt2CAwpfyB25GegpnZKbp6gWcuUKDHqvknLvDbxKc.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Findex%2Findex%2Ftime%2F20171117', '测试用户在2017-11-17 14:14:18退出了管理系统', '1', 'pc', '1510899258', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('208', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510899258.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Findex%2Findex%2Ftime%2F20171117140453%2Fauthcode%2F3542hnI0syrVL6UJLWrwyxBrsCSvXDYIv4tYCwAK%255EmYdQ42WOMt2q66OQQ.html', '测试用户在2017-11-17 14:14:23登录了管理系统', '1', 'pc', '1510899263', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('209', '2', '3', 'manager', 'POST', '3', '/console/start/logout/time/20171117141425YWMwkRdPKWQYB4gJhE6GDYupZZMS3gwbH4rhLTJqTNEa6GxGKfUjvvUq9uPhtayMAeDtaUY5vaZY2jS3zedNMk7fMgyAZJfL42QAK3FCS6GvbWfDpDVcPmfaGLMd72gv.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Findex%2Findex%2Ftime%2F20171117', '测试用户在2017-11-17 14:15:31退出了管理系统', '1', 'pc', '1510899331', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('210', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510899331.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Findex%2Findex%2Ftime%2F20171117140453%2Fauthcode%2F3542hnI0syrVL6UJLWrwyxBrsCSvXDYIv4tYCwAK%255EmYdQ42WOMt2q66OQQ.html', '测试用户在2017-11-17 14:15:36登录了管理系统', '1', 'pc', '1510899336', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('211', '2', '3', 'manager', 'POST', '3', '/console/start/logout/time/20171117141538uW3QnVKxLrQY9fSjhhC7aPSP8wf2XdhcqqHzKeRWTd69TPFzZa8NBCcrRsFnhP5N7Lj8fzG9hQd7t3hw3DkkxcxNdUveDfG9HTwXWUyDES8VZZbFEZLnccgrmtTgWe4t.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Findex%2Findex%2Ftime%2F20171117', '测试用户在2017-11-17 14:16:01退出了管理系统', '1', 'pc', '1510899361', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('212', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510899361.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Findex%2Findex%2Ftime%2F20171117140453%2Fauthcode%2F3542hnI0syrVL6UJLWrwyxBrsCSvXDYIv4tYCwAK%255EmYdQ42WOMt2q66OQQ.html', '测试用户在2017-11-17 14:16:06登录了管理系统', '1', 'pc', '1510899366', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('213', '2', '3', 'manager', 'POST', '3', '/console/start/logout/time/201711171419364MDaTngCUmBrmJfHQmHhC6gjUSsbFPfpKyh5uEGABZ5bFLw3Jq4LEqsVB6Lrtb46HXFX3GVgrueymgZz6cz3YrzbBYAwkKf4AjzXBK3N3vsEg4Kfdzb2R8wJtTTMpJES.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Findex%2Findex%2Ftime%2F20171117', '测试用户在2017-11-17 14:19:42退出了管理系统', '1', 'pc', '1510899582', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('214', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510899582.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Findex%2Findex%2Ftime%2F20171117140453%2Fauthcode%2F3542hnI0syrVL6UJLWrwyxBrsCSvXDYIv4tYCwAK%255EmYdQ42WOMt2q66OQQ.html', '测试用户在2017-11-17 14:19:46登录了管理系统', '1', 'pc', '1510899586', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('215', '2', '1', 'manager', 'POST', '1', '/console/start/logout/time/20171117144047RyaUJZcCtmdJwjeETqWsQ94sem9Hduerf3bPFLHDHtBX6jASPxr7UpDwSWyffH7LcPxVP4rNAcVDytsmYq6Wms9fFrjXkp4qxRKmxg2Av9V9GnngmGc5De3BFKc595Lr.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fucenter_member%2Flists.html', '超级管理员在2017-11-17 14:40:52退出了管理系统', '1', 'pc', '1510900852', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('216', '2', '3', 'manager', 'POST', '3', '/console/start/logout/time/20171117141947UH57UW8DUkyCR4qrEQcSbamWtb5BUvrZAEgUeRw3NMGTFF5SBsYuMaS5RppxxRpz3X5aMJD647N5G9xzgvSa6vexsWzaD6TntkteKgtJ53jRmp4pEXWdT5eKqqk7rBnY.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Findex%2Findex%2Ftime%2F20171117', '测试用户在2017-11-17 14:41:34退出了管理系统', '1', 'pc', '1510900894', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('217', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510900894.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Findex%2Findex%2Ftime%2F20171117140453%2Fauthcode%2F3542hnI0syrVL6UJLWrwyxBrsCSvXDYIv4tYCwAK%255EmYdQ42WOMt2q66OQQ.html', '测试用户在2017-11-17 14:44:36登录了管理系统', '1', 'pc', '1510901076', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('218', '2', '3', 'manager', 'POST', '3', '/console/start/logout/time/20171117144439MWC6rn5vnbfhHKhvbhjusHAbZpfHxhfZJKzQgNbdA3vKC6FesUXkZ6KFhZpBa43xH2rj6nnMXd5mGebPhueuAsL6ffxXCm2CsLTNPvcGS9yYFGcFX28gMjWUVaRfnGtW.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Findex%2Findex%2Ftime%2F20171117', '测试用户在2017-11-17 14:46:08退出了管理系统', '1', 'pc', '1510901168', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('219', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510901168.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Findex%2Findex%2Ftime%2F20171117140453%2Fauthcode%2F3542hnI0syrVL6UJLWrwyxBrsCSvXDYIv4tYCwAK%255EmYdQ42WOMt2q66OQQ.html', '测试用户在2017-11-17 14:46:12登录了管理系统', '1', 'pc', '1510901172', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('220', '1', '1', 'manager', 'POST', '1', '/console/start/index/time/1510900852.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fucenter_member%2Flists.html', '超级管理员在2017-11-17 14:53:45登录了管理系统', '1', 'pc', '1510901625', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('221', '9', '1', 'manager', 'POST', '1', '/console/manager/renew.html', '超级管理员在2017-11-17 14:54:47修改了管理用户', '1', 'pc', '1510901687', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('222', '2', '1', 'manager', 'POST', '1', '/console/start/logout/time/20171116172044XLTf92FVBPCyAjg2jKjZJN79g3zcdEbTrbyqwfhmvVzRhRD483BhFwBL296Nu2gQNpUcwfNwqSsTqnV2sgwx8mgCsztV4EsZKFr8am3gvC9wB6yVyBKcEXLYuc66VyvP.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Findex%2Findex%2Ftime%2F15108240', '超级管理员在2017-11-17 15:11:35退出了管理系统', '1', 'pc', '1510902695', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('223', '1', '1', 'manager', 'POST', '1', '/console/start', '超级管理员在2017-11-17 15:37:14登录了管理系统', '1', 'pc', '1510904234', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('224', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510906113.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fauth_rule%2Findex.html', '测试用户在2017-11-17 16:08:41登录了管理系统', '1', 'pc', '1510906121', '30156822', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('225', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1510912610.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fucenter_member%2Findex.html', '测试用户在2017-11-17 17:57:15登录了管理系统', '1', 'pc', '1510912635', '1875874946', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('226', '2', '3', 'manager', 'POST', '3', '/console/start/logout/time/20171117180105QLD4Ye3syP9FZ3RzHzuNKsAvpHLc4LHqrrxaFRBharzU8STq4cNYpHxXLbHaHfGy229TqwQXzhuencJsBk6edQ8H5vBKpjTXvFjfXHnPGDMx7DCjuTugf8FPeS3ycxLq.html?backurl=http%3A%2F%2Fwww.benweng.com%2Fconsole%2Fcache%2Findex.html', '测试用户在2017-11-17 18:01:11退出了管理系统', '1', 'pc', '1510912871', '1875874946', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('227', '1', '1', 'manager', 'POST', '1', '/console/start', '超级管理员在2017-11-17 19:46:47登录了管理系统', '1', 'weixin', '1510919207', '1971836024', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('228', '1', '1', 'manager', 'POST', '1', '/console/start', '超级管理员在2017-11-20 17:24:16登录了管理系统', '1', 'weixin', '1511169856', '1971851863', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('229', '1', '1', 'manager', 'POST', '1', '/console/start', '超级管理员在2017-11-23 12:11:50登录了管理系统', '1', 'pc', '1511410310', '1971836024', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('230', '1', '1', 'manager', 'POST', '1', '/console/start', '超级管理员在2017-11-23 12:18:50登录了管理系统', '1', 'pc', '1511410730', '1971836024', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('231', '29', '1', 'Manager', 'POST', '1', '/console/manager/password.html', '超级管理员在2017-11-23 18:52:12修改了密码', '1', 'pc', '1511434332', '1971836024', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('232', '29', '1', 'Manager', 'POST', '1', '/console/manager/password.html', '超级管理员在2017-11-23 18:52:38修改了密码', '1', 'pc', '1511434358', '1971836024', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('233', '2', '1', 'manager', 'POST', '1', '/console/start/logout/time/20171123185205GFbLKcNv74CPQGHKKP5SxvJbzeCLZwALe2D5MCEejuvy8cS9Sw6wKHV3n37MUCNr3chzQupAg8gn8C8yEZNzpZjBkpzRaL9HGh7BhGb92X5VqjQ2bCQUJRzDtFbGVB6x.html?backurl=http%3A%2F%2Fbenweng.com%2Fconsole%2Fmanager%2Fpassword.html', '超级管理员在2017-11-23 18:52:57退出了管理系统', '1', 'pc', '1511434377', '1971836024', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('234', '1', '1', 'manager', 'POST', '1', '/console/start/index/time/1511434377.html?backurl=http%3A%2F%2Fbenweng.com%2Fconsole%2Fmanager%2Fpassword.html', '超级管理员在2017-11-23 18:53:02登录了管理系统', '1', 'pc', '1511434382', '1971836024', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('235', '2', '1', 'manager', 'POST', '1', '/console/start/logout/time/20171123185303zm7WWNUUS9BYXXQ97jZBPA3sDhERPEMp43HtgpEWmqxDbGc5buxU4W3pKqYQbbuKqYnwehhmPDFk3avZswQJJ9zdy7pdb43cpwKwcF8MFkX7xvF5XZnWf4vaY2mTw8cE.html?backurl=http%3A%2F%2Fbenweng.com%2Fconsole%2Fmanager%2Fpassword.html', '超级管理员在2017-11-23 18:53:07退出了管理系统', '1', 'pc', '1511434387', '1971836024', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('236', '1', '1', 'manager', 'POST', '1', '/console/start/index/time/1511434387.html?backurl=http%3A%2F%2Fbenweng.com%2Fconsole%2Fmanager%2Fpassword.html', '超级管理员在2017-11-23 18:53:15登录了管理系统', '1', 'pc', '1511434395', '1971836024', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('237', '1', '3', 'manager', 'POST', '3', '/console/start/index/time/1511764443.html?backurl=http%3A%2F%2F127.0.0.1%3A888%2Fconsole%2Findex%2Findex%2Ftime%2F20171127143350%2Fauthcode%2Fdc4eDen2XITIlrVZnKVFqHbc%255Eyu7BOPo1Djl8KenywAZWv52HGamnb%255ESVQ.html', '测试用户在2017-11-27 14:51:22登录了管理系统', '1', 'pc', '1511765482', '2130706433', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('238', '2', '3', 'manager', 'POST', '3', '/console/start/logout/time/20171127145124Sje2xsbzpJdUs4qZCkhaUr3ufT7WmGdRqCtgQd8X9zuLP7WuVTkxCQWxQwEATyyJU5CsmKTf8YtCdbGsEs9bHkWpaK8vbuKzLp8N3XrDBJrsyPhQmqJTyXb8hvr5E3zC.html?backurl=http%3A%2F%2F127.0.0.1%3A888%2Fconsole%2Findex%2Findex%2Ftime%2F20171127', '测试用户在2017-11-27 14:52:12退出了管理系统', '1', 'pc', '1511765532', '2130706433', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('239', '1', '1', 'manager', 'POST', '1', '/console/start/index/time/1511765532.html?backurl=http%3A%2F%2F127.0.0.1%3A888%2Fconsole%2Findex%2Findex%2Ftime%2F20171127143350%2Fauthcode%2Fdc4eDen2XITIlrVZnKVFqHbc%255Eyu7BOPo1Djl8KenywAZWv52HGamnb%255ESVQ.html', '超级管理员在2017-11-27 14:52:19登录了管理系统', '1', 'pc', '1511765539', '2130706433', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('240', '13', '1', 'AuthRule', 'POST', '83', '/console/auth_rule/renew.html', '超级管理员在2017-11-27 14:57:21修改了规则', '1', 'pc', '1511765841', '2130706433', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('241', '13', '1', 'AuthRule', 'POST', '114', '/console/auth_rule/renew.html', '超级管理员在2017-11-27 14:57:38修改了规则', '1', 'pc', '1511765858', '2130706433', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('242', '16', '1', 'AuthRule', 'GET', '83', '/console/auth_rule/updateshow/id/8e0474lHalMdfw6belXOhM17IDt5-sVAGUr9T5i6wg.html', '超级管理员在2017-11-27 14:58:38设置了控制台菜单显示状态', '1', 'pc', '1511765918', '2130706433', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('243', '16', '1', 'AuthRule', 'GET', '114', '/console/auth_rule/updateshow/id/4b7eCuzKEPsdCzsRfR9drPoM07qGVj2iD6r1g9ceRhU.html', '超级管理员在2017-11-27 14:58:39设置了控制台菜单显示状态', '1', 'pc', '1511765919', '2130706433', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('244', '13', '1', 'AuthRule', 'POST', '114', '/console/auth_rule/renew.html', '超级管理员在2017-11-27 15:00:25修改了规则', '1', 'pc', '1511766025', '2130706433', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('245', '13', '1', 'AuthRule', 'POST', '83', '/console/auth_rule/renew.html', '超级管理员在2017-11-27 15:00:37修改了规则', '1', 'pc', '1511766037', '2130706433', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('246', '2', '1', 'manager', 'POST', '1', '/console/start/logout/time/201711271501378CfLLenEd79Ed6zASqMvuV7eM54b8kmaqXKJuCvVsFDeyfYP4DAPfVfDXFhak6QLczQCUzwpnKGt8QkLT6geAZ5d54EaazWsNDdAesRjhe6P9NDKMMVpbMCFrZY27RuP.html?backurl=http%3A%2F%2F127.0.0.1%3A888%2Fconsole%2Fdata_backup%2Fimport.html', '超级管理员在2017-11-27 15:01:41退出了管理系统', '1', 'pc', '1511766101', '2130706433', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('247', '1', '1', 'manager', 'POST', '1', '/console/start/index/time/1511766101.html?backurl=http%3A%2F%2F127.0.0.1%3A888%2Fconsole%2Fdata_backup%2Fimport.html', '超级管理员在2017-11-27 15:01:44登录了管理系统', '1', 'pc', '1511766104', '2130706433', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('248', '16', '1', 'AuthRule', 'GET', '114', '/console/auth_rule/updateshow/id/65c7XjME4lB4CRN9DUPQClQqFmiP2l2-TVvLOsFLCs8.html', '超级管理员在2017-11-27 15:02:49设置了控制台菜单显示状态', '1', 'pc', '1511766169', '2130706433', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('249', '1', '1', 'manager', 'POST', '1', '/console/start/index/time/1511768815.html?backurl=http%3A%2F%2F127.0.0.1%3A888%2Fconsole%2Fdata_backup%2Fimport.html', '超级管理员在2017-11-27 15:47:59登录了管理系统', '1', 'pc', '1511768879', '2130706433', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('250', '13', '1', 'AuthRule', 'POST', '337', '/console/auth_rule/renew.html', '超级管理员在2017-11-27 16:29:43修改了规则', '1', 'pc', '1511771383', '2130706433', '', '0', '0');
INSERT INTO `cy_action_log` VALUES ('251', '1', '1', 'manager', 'POST', '1', '/console/start/index/time/1511772051.html?backurl=http%3A%2F%2F127.0.0.1%3A888%2Fconsole%2Fdata_backup%2Flists.html', '超级管理员在2017-11-27 16:40:58登录了管理系统', '1', 'pc', '1511772058', '2130706433', '', '0', '0');

-- -----------------------------
-- Table structure for `cy_addons`
-- -----------------------------
DROP TABLE IF EXISTS `cy_addons`;
CREATE TABLE `cy_addons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(40) NOT NULL COMMENT '插件名或标识',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '中文名',
  `description` text COMMENT '插件描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `config` text COMMENT '配置',
  `author` varchar(40) DEFAULT '' COMMENT '作者',
  `version` varchar(20) DEFAULT '' COMMENT '版本号',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `has_adminlist` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有后台列表',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=utf8 COMMENT='插件表';

-- -----------------------------
-- Records of `cy_addons`
-- -----------------------------
INSERT INTO `cy_addons` VALUES ('76', 'EditorForAdmin', '后台编辑器', '用于增强整站长文本的输入和显示', '1', '{\"editor_type\":\"1\",\"editor_wysiwyg\":\"2\",\"editor_markdownpreview\":\"1\",\"editor_height\":\"500px\",\"editor_resize_type\":\"1\"}', 'thinkphp', '0.2', '1466602751', '0');
INSERT INTO `cy_addons` VALUES ('4', 'SystemInfo', '系统环境信息', '用于显示一些服务器的信息', '1', '{\"title\":\"\\u7cfb\\u7edf\\u4fe1\\u606f\",\"width\":\"2\",\"display\":\"1\"}', 'thinkphp', '0.1', '1379512036', '0');
INSERT INTO `cy_addons` VALUES ('5', 'Editor', '前台编辑器', '用于增强整站长文本的输入和显示', '1', '{\"editor_type\":\"2\",\"editor_wysiwyg\":\"1\",\"editor_height\":\"300px\",\"editor_resize_type\":\"1\"}', 'thinkphp', '0.1', '1379830910', '0');
INSERT INTO `cy_addons` VALUES ('64', 'Attachment', '附件', '用于文档模型上传附件', '1', 'null', 'thinkphp', '0.1', '1466100356', '1');
INSERT INTO `cy_addons` VALUES ('9', 'SocialComment', '通用社交化评论', '集成了各种社交化评论插件，轻松集成到系统中。', '1', '{\"comment_type\":\"1\",\"comment_uid_youyan\":\"\",\"comment_short_name_duoshuo\":\"\",\"comment_data_list_duoshuo\":\"\"}', 'thinkphp', '0.1', '1380273962', '0');
INSERT INTO `cy_addons` VALUES ('75', 'Oauth', '第三方登录插件', '用于第三方登录设置', '1', '{\"oauth_status\":\"1\",\"think_sdk_qq_app_key\":\"100251165\",\"think_sdk_qq_app_secret\":\"114d7761ae3f641f82aded9acce3c5a4\",\"think_sdk_qq_callback\":\"http:\\/\\/www.benweng.com\\/oauthcallback?type=qq\",\"think_sdk_qq_on\":\"1\",\"think_sdk_sina_app_key\":\"4198022214\",\"think_sdk_sina_app_secret\":\"bfaf29ca1f9586af79060947856b42e9\",\"think_sdk_sina_callback\":\"http:\\/\\/www.benweng.com\\/oauthcallback?type=sina\",\"think_sdk_sina_on\":\"1\",\"think_sdk_baidu_app_key\":\"00VgPgxfGjNPwi2WzBAsVOAy\",\"think_sdk_baidu_app_secret\":\"VjQ3Dw2l6DGpfoveQQyCms3iIErYqHYz\",\"think_sdk_baidu_callback\":\"http:\\/\\/www.benweng.com\\/oauthcallback?type=baidu\",\"think_sdk_baidu_on\":\"1\"}', 'SpringYang', '0.1', '1466602553', '0');
INSERT INTO `cy_addons` VALUES ('70', 'YcEditor', '测试编辑器', '测试编辑器，这是说明', '1', 'null', 'thinkphp', '0.2', '1466299750', '0');
INSERT INTO `cy_addons` VALUES ('61', 'DevTeam', '开发团队信息', '开发团队成员信息', '1', '{\"title\":\"OneThink\\u5f00\\u53d1\\u56e2\\u961f\",\"width\":\"2\",\"display\":\"1\"}', 'thinkphp', '0.1', '1466099774', '0');
INSERT INTO `cy_addons` VALUES ('71', 'SiteStat', '站点统计信息', '统计站点的基础信息', '1', '{\"title\":\"\\u7cfb\\u7edf\\u4fe1\\u606f\",\"width\":\"2\",\"display\":\"1\"}', 'thinkphp', '0.1', '1466300563', '0');

-- -----------------------------
-- Table structure for `cy_article`
-- -----------------------------
DROP TABLE IF EXISTS `cy_article`;
CREATE TABLE `cy_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `cid` int(11) NOT NULL DEFAULT '0' COMMENT '类型id',
  `title` char(128) NOT NULL COMMENT '标题',
  `keywords` char(128) NOT NULL COMMENT '关键字',
  `description` char(128) NOT NULL COMMENT '描述',
  `content` text NOT NULL COMMENT '内容',
  `cover` char(128) NOT NULL COMMENT '封面',
  `source` char(56) NOT NULL COMMENT '来源',
  `view` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '访问次数',
  `template` char(56) NOT NULL COMMENT '模板',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '状态，1为正常，0为禁用',
  `create_uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `create_ip` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建ip',
  `update_uid` int(11) unsigned DEFAULT '0' COMMENT '更新者id',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `update_ip` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新ip',
  `delete_status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '删除状态',
  `delete_uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '删除操作者id',
  `delete_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '删除操作时间',
  `delete_ip` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '删除操作ip',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- -----------------------------
-- Table structure for `cy_attribute`
-- -----------------------------
DROP TABLE IF EXISTS `cy_attribute`;
CREATE TABLE `cy_attribute` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '字段名',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '字段注释',
  `field` varchar(100) NOT NULL DEFAULT '' COMMENT '字段定义',
  `type` varchar(20) NOT NULL DEFAULT '' COMMENT '数据类型',
  `value` varchar(100) NOT NULL DEFAULT '' COMMENT '字段默认值',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '表单是否显示',
  `list_show` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '列表默认显示，0为不显示，1为显示',
  `extra` varchar(255) NOT NULL DEFAULT '' COMMENT '参数',
  `model_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模型id',
  `is_must` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否必填',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `validate_rule` varchar(255) NOT NULL DEFAULT '',
  `validate_time` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `error_info` varchar(100) NOT NULL DEFAULT '',
  `validate_type` varchar(25) NOT NULL DEFAULT '',
  `auto_rule` varchar(100) NOT NULL DEFAULT '',
  `auto_time` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `auto_type` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `model_id` (`model_id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COMMENT='模型属性表';

-- -----------------------------
-- Records of `cy_attribute`
-- -----------------------------
INSERT INTO `cy_attribute` VALUES ('1', 'uid', '用户ID', 'int(10) unsigned NOT NULL ', 'num', '0', '', '0', '0', '', '1', '0', '1', '1384508362', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cy_attribute` VALUES ('2', 'name', '标识', 'char(40) NOT NULL ', 'string', '', '同一根节点下标识不重复', '1', '0', '', '1', '0', '1', '1383894743', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cy_attribute` VALUES ('3', 'title', '标题', 'char(80) NOT NULL ', 'string', '', '文档标题', '1', '0', '', '1', '0', '1', '1383894778', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cy_attribute` VALUES ('4', 'category_id', '所属分类', 'int(10) unsigned NOT NULL ', 'string', '', '', '0', '0', '', '1', '0', '1', '1384508336', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cy_attribute` VALUES ('5', 'description', '描述', 'char(140) NOT NULL ', 'textarea', '', '', '1', '0', '', '1', '0', '1', '1383894927', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cy_attribute` VALUES ('6', 'root', '根节点', 'int(10) unsigned NOT NULL ', 'num', '0', '该文档的顶级文档编号', '0', '0', '', '1', '0', '1', '1384508323', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cy_attribute` VALUES ('7', 'pid', '所属ID', 'int(10) unsigned NOT NULL ', 'num', '0', '父文档编号', '0', '0', '', '1', '0', '1', '1384508543', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cy_attribute` VALUES ('8', 'model_id', '内容模型ID', 'tinyint(3) unsigned NOT NULL ', 'num', '0', '该文档所对应的模型', '0', '0', '', '1', '0', '1', '1384508350', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cy_attribute` VALUES ('9', 'type', '内容类型', 'tinyint(3) unsigned NOT NULL ', 'select', '2', '', '1', '0', '1:目录\r\n2:主题\r\n3:段落', '1', '0', '1', '1384511157', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cy_attribute` VALUES ('10', 'position', '推荐位', 'smallint(5) unsigned NOT NULL ', 'checkbox', '0', '多个推荐则将其推荐值相加', '1', '0', '[DOCUMENT_POSITION]', '1', '0', '1', '1383895640', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cy_attribute` VALUES ('11', 'link_id', '外链', 'int(10) unsigned NOT NULL ', 'num', '0', '0-非外链，大于0-外链ID,需要函数进行链接与编号的转换', '1', '0', '', '1', '0', '1', '1383895757', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cy_attribute` VALUES ('12', 'cover_id', '封面', 'int(10) unsigned NOT NULL ', 'picture', '0', '0-无封面，大于0-封面图片ID，需要函数处理', '1', '0', '', '1', '0', '1', '1384147827', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cy_attribute` VALUES ('13', 'display', '可见性', 'tinyint(3) unsigned NOT NULL ', 'radio', '1', '', '1', '0', '0:不可见\r\n1:所有人可见', '1', '0', '1', '1386662271', '1383891233', '', '0', '', 'regex', '', '0', 'function');
INSERT INTO `cy_attribute` VALUES ('14', 'deadline', '截至时间', 'int(10) unsigned NOT NULL ', 'datetime', '0', '0-永久有效', '1', '0', '', '1', '0', '1', '1387163248', '1383891233', '', '0', '', 'regex', '', '0', 'function');
INSERT INTO `cy_attribute` VALUES ('15', 'attach', '附件数量', 'tinyint(3) unsigned NOT NULL ', 'num', '0', '', '0', '0', '', '1', '0', '1', '1387260355', '1383891233', '', '0', '', 'regex', '', '0', 'function');
INSERT INTO `cy_attribute` VALUES ('16', 'view', '浏览量', 'int(10) unsigned NOT NULL ', 'num', '0', '', '1', '0', '', '1', '0', '1', '1383895835', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cy_attribute` VALUES ('17', 'comment', '评论数', 'int(10) unsigned NOT NULL ', 'num', '0', '', '1', '0', '', '1', '0', '1', '1383895846', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cy_attribute` VALUES ('18', 'extend', '扩展统计字段', 'int(10) unsigned NOT NULL ', 'num', '0', '根据需求自行使用', '0', '0', '', '1', '0', '1', '1384508264', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cy_attribute` VALUES ('19', 'level', '优先级', 'int(10) unsigned NOT NULL ', 'num', '0', '越高排序越靠前', '1', '0', '', '1', '0', '1', '1383895894', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cy_attribute` VALUES ('20', 'create_time', '创建时间', 'int(10) unsigned NOT NULL ', 'datetime', '0', '', '1', '0', '', '1', '0', '1', '1383895903', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cy_attribute` VALUES ('21', 'update_time', '更新时间', 'int(10) unsigned NOT NULL ', 'datetime', '0', '', '0', '0', '', '1', '0', '1', '1384508277', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cy_attribute` VALUES ('22', 'status', '数据状态', 'tinyint(4) NOT NULL ', 'radio', '0', '', '0', '0', '-1:删除\r\n0:禁用\r\n1:正常\r\n2:待审核\r\n3:草稿', '1', '0', '1', '1384508496', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cy_attribute` VALUES ('23', 'parse', '内容解析类型', 'tinyint(3) unsigned NOT NULL ', 'select', '0', '', '0', '0', '0:html\r\n1:ubb\r\n2:markdown', '2', '0', '1', '1384511049', '1383891243', '', '0', '', '', '', '0', '');
INSERT INTO `cy_attribute` VALUES ('24', 'content', '文章内容', 'text NOT NULL ', 'editor', '', '', '1', '0', '', '2', '0', '1', '1383896225', '1383891243', '', '0', '', '', '', '0', '');
INSERT INTO `cy_attribute` VALUES ('25', 'template', '详情页显示模板', 'varchar(100) NOT NULL ', 'string', '', '参照display方法参数的定义', '1', '0', '', '2', '0', '1', '1383896190', '1383891243', '', '0', '', '', '', '0', '');
INSERT INTO `cy_attribute` VALUES ('26', 'bookmark', '收藏数', 'int(10) unsigned NOT NULL ', 'num', '0', '', '1', '0', '', '2', '0', '1', '1383896103', '1383891243', '', '0', '', '', '', '0', '');
INSERT INTO `cy_attribute` VALUES ('27', 'parse', '内容解析类型', 'tinyint(3) unsigned NOT NULL ', 'select', '0', '', '0', '0', '0:html\r\n1:ubb\r\n2:markdown', '3', '0', '1', '1387260461', '1383891252', '', '0', '', 'regex', '', '0', 'function');
INSERT INTO `cy_attribute` VALUES ('28', 'content', '下载详细描述', 'text NOT NULL ', 'editor', '', '', '1', '0', '', '3', '0', '1', '1383896438', '1383891252', '', '0', '', '', '', '0', '');
INSERT INTO `cy_attribute` VALUES ('29', 'template', '详情页显示模板', 'varchar(100) NOT NULL ', 'string', '', '', '1', '0', '', '3', '0', '1', '1383896429', '1383891252', '', '0', '', '', '', '0', '');
INSERT INTO `cy_attribute` VALUES ('30', 'file_id', '文件ID', 'int(10) unsigned NOT NULL ', 'file', '0', '需要函数处理', '1', '0', '', '3', '0', '1', '1383896415', '1383891252', '', '0', '', '', '', '0', '');
INSERT INTO `cy_attribute` VALUES ('31', 'download', '下载次数', 'int(10) unsigned NOT NULL ', 'num', '0', '', '1', '0', '', '3', '0', '1', '1383896380', '1383891252', '', '0', '', '', '', '0', '');
INSERT INTO `cy_attribute` VALUES ('32', 'size', '文件大小', 'bigint(20) unsigned NOT NULL ', 'num', '0', '单位bit', '1', '0', '', '3', '0', '1', '1383896371', '1383891252', '', '0', '', '', '', '0', '');

-- -----------------------------
-- Table structure for `cy_attribute_user_list`
-- -----------------------------
DROP TABLE IF EXISTS `cy_attribute_user_list`;
CREATE TABLE `cy_attribute_user_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '表自增id',
  `uid` int(11) unsigned DEFAULT '0' COMMENT '用户id',
  `model_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '模型id',
  `attribute` varchar(128) NOT NULL COMMENT '属性列表',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '状态，1为正常，0为禁用',
  `create_uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `create_ip` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建ip',
  `update_uid` int(11) unsigned DEFAULT '0' COMMENT '更新者id',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `update_ip` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新ip',
  `delete_status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '删除状态，1为正常，0为删除',
  `delete_uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '删除操作者id',
  `delete_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '删除操作时间',
  `delete_ip` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '删除操作ip',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户自定义属性列表';

-- -----------------------------
-- Records of `cy_attribute_user_list`
-- -----------------------------
INSERT INTO `cy_attribute_user_list` VALUES ('1', '1', '1', '2,3,5,4', '1', '0', '0', '0', '0', '0', '0', '1', '0', '0', '0');

-- -----------------------------
-- Table structure for `cy_auth_group`
-- -----------------------------
DROP TABLE IF EXISTS `cy_auth_group`;
CREATE TABLE `cy_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，1为正常，0为禁用',
  `rules` text NOT NULL,
  `describe` char(50) NOT NULL DEFAULT '',
  `create_uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `create_ip` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建ip',
  `update_uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新者id',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `update_ip` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新ip',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- -----------------------------
-- Records of `cy_auth_group`
-- -----------------------------
INSERT INTO `cy_auth_group` VALUES ('1', '超级管理员', '1', '', '拥有全部权限', '0', '0', '0', '0', '0', '0');
INSERT INTO `cy_auth_group` VALUES ('2', '网站管理员', '1', '7,107,108,109,110,152,153,331', '拥有相对多的权限', '0', '0', '0', '1', '1493794260', '2130706433');
INSERT INTO `cy_auth_group` VALUES ('3', '发布人员', '1', '1,27', '拥有发布、修改文章的权限', '0', '0', '0', '1', '1493705940', '2130706433');
INSERT INTO `cy_auth_group` VALUES ('4', '编辑', '1', '1,27,112,113,116,117,119,2,21,23,25,26,22,28,29,30,3,31,32,33,34,35', '拥有文章模块的所有权限', '0', '0', '0', '1', '1493705820', '2130706433');
INSERT INTO `cy_auth_group` VALUES ('8', '默认组', '0', '1,27,112,113,116,117', '拥有一些通用的权限', '0', '0', '0', '1', '1493705591', '2130706433');
INSERT INTO `cy_auth_group` VALUES ('9', 'test', '1', '1,27,112,113,116,117,6,61,62,328,329,7,71,77,78,79,80,118,279,72,73,74,75,280,101,102,103,204,281,107,108,109,110,152,153,332,333,8,81,84,115,282,284,283,285,286,288,334,301,300,302,303,335', '', '0', '0', '0', '1', '1510812407', '3232235785');

-- -----------------------------
-- Table structure for `cy_auth_group_access`
-- -----------------------------
DROP TABLE IF EXISTS `cy_auth_group_access`;
CREATE TABLE `cy_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- -----------------------------
-- Records of `cy_auth_group_access`
-- -----------------------------
INSERT INTO `cy_auth_group_access` VALUES ('0', '3');
INSERT INTO `cy_auth_group_access` VALUES ('1', '0');
INSERT INTO `cy_auth_group_access` VALUES ('2', '2');
INSERT INTO `cy_auth_group_access` VALUES ('3', '9');
INSERT INTO `cy_auth_group_access` VALUES ('11', '1');

-- -----------------------------
-- Table structure for `cy_auth_rule`
-- -----------------------------
DROP TABLE IF EXISTS `cy_auth_rule`;
CREATE TABLE `cy_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
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
  `update_time` int(11) NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=339 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- -----------------------------
-- Records of `cy_auth_rule`
-- -----------------------------
INSERT INTO `cy_auth_rule` VALUES ('1', '0', 'index', '控制台', 'index/index', '', '1', '0', '0', '1', '1', '1', 'fa-home', '100', '0', '1509601626');
INSERT INTO `cy_auth_rule` VALUES ('2', '0', 'Product', '产品管理', '', '', '1', '1', '1', '1', '1', '0', 'fa-product-hunt', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('3', '0', 'order', '订单管理', '', '', '1', '0', '1', '1', '1', '0', 'fa-home', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('4', '0', 'Business', '商家管理', '', '', '1', '1', '1', '1', '1', '0', 'fa-reorder', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('5', '0', 'articles', '内容', '', '', '0', '0', '1', '1', '1', '0', 'fa-list-alt', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('6', '0', 'UcenterMember/index', '用户管理', '', '', '1', '1', '1', '1', '1', '1', 'fa-home', '100', '0', '1509700426');
INSERT INTO `cy_auth_rule` VALUES ('7', '0', 'auth', '权限管理', 'authRule/index', '', '0', '0', '1', '1', '1', '1', 'fa-random', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('8', '0', 'System', '系统管理', '/console/config/index/group/base', '', '0', '0', '1', '1', '1', '1', 'fa-gears', '100', '0', '1510889329');
INSERT INTO `cy_auth_rule` VALUES ('21', '2', 'product/lists', '产品管理', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('22', '2', 'Examine', '审核管理', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('23', '21', 'Scenery', '旅游线路管理', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('24', '21', 'Hotel', '酒店管理', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('25', '21', 'Travelticket', '景区门票', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('26', '21', 'Group', '休闲美食', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('27', '1', 'index/index', '控制台首页', '', '', '0', '0', '0', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('28', '22', 'Hotel/hotelListt', '酒店审核', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('29', '22', 'TravelTicket/ticketListt', '景区门票审核', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('30', '22', 'Group/indexx', '美食审核', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('31', '3', 'order/index', '旅游路线订单列表', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('32', '31', 'order/index2', '酒店订单列表', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('33', '3', 'order/index3', '景区门票订单列表', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('34', '33', 'order/index4', '休闲美食订单列表', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('35', '33', 'order/index5', '旅游路线订单列表', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('52', '5', 'article/index', '内容管理', '', '', '1', '1', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('53', '52', 'article', '内容管理控制器', '', '', '1', '1', '1', '1', '1', '0', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('54', '5', 'Ad', '广告管理', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('61', '6', 'UcenterMember', '用户控制器', '', '', '1', '1', '1', '1', '1', '0', '', '100', '0', '1509700315');
INSERT INTO `cy_auth_rule` VALUES ('62', '6', 'UcenterMember/lists', '本系统用户列表', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1509700370');
INSERT INTO `cy_auth_rule` VALUES ('71', '7', 'manager/index', '管理员管理', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('72', '7', 'authRule/index', '规则管理', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('73', '72', 'authRule/lists', '规则列表', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('74', '72', 'authRule/add', '添加规则', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('75', '72', 'authRule/edit', '编辑规则', '', '', '0', '0', '1', '1', '1', '0', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('76', '72', 'authRule/del', '删除规则', '', '', '0', '0', '1', '1', '1', '0', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('77', '71', 'manager/lists', '管理员列表', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('78', '71', 'manager/add', '添加管理员', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('79', '71', 'Manager/edit', '编辑管理员', '', '', '0', '0', '1', '1', '1', '0', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('80', '71', 'manager/log', '管理员日志', '', '', '0', '0', '1', '1', '1', '0', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('81', '8', 'cache/index', '缓存管理', '', '', '1', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('82', '8', 'MobileCode', '短信管理', '', '', '0', '0', '1', '1', '1', '0', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('83', '8', 'DataBackup/index', '数据库管理', '', '', '1', '0', '1', '1', '1', '1', '', '100', '0', '1511766037');
INSERT INTO `cy_auth_rule` VALUES ('84', '81', 'cache/cache', '更新缓存', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('85', '8', 'Visitcount', '访问统计', '', '', '1', '1', '1', '1', '1', '0', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('86', '85', 'Visitcount/index', '访问概况', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('87', '85', 'Visitcount/today', '今日访问排行', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('88', '8', 'Pay', '支付设置', '', '', '1', '0', '1', '1', '1', '0', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('101', '7', 'authGroup/index', '角色管理', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('102', '101', 'AuthGroup/add', '角色添加', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('103', '101', 'AuthGroup/edit', '角色编辑', '', '', '0', '0', '1', '1', '1', '0', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('104', '101', 'AuthGroup/del', '角色删除', '', '', '0', '0', '1', '1', '1', '0', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('105', '101', 'AuthGroup/rule', '分配权限', '', '', '0', '0', '1', '1', '1', '0', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('106', '85', 'Visitcount/latest', '实时访客', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('107', '7', 'action/index', '行为管理', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('108', '107', 'action/lists', '用户行为', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('109', '107', 'action', '行为管理控制器', '', '', '1', '1', '1', '1', '1', '0', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('110', '107', 'actionLog/lists', '行为日志', '', '', '0', '0', '1', '1', '1', '1', '', '100', '1448348339', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('111', '88', 'Pay/chinabanck', '网银在线设置', '', '', '0', '0', '1', '1', '1', '1', '', '100', '1448348382', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('112', '1', 'index/index111', '首页控制器', '', '', '0', '0', '0', '1', '1', '0', '', '100', '1448369860', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('113', '1', 'index/copyright', '系统信息', '', '', '0', '0', '0', '1', '1', '1', '', '100', '1448369952', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('114', '83', 'DataBackup/index1', '数据库', '', '', '0', '1', '1', '1', '1', '0', '', '100', '1448437926', '1511766024');
INSERT INTO `cy_auth_rule` VALUES ('115', '81', 'cache/update', '更新缓存操作', '', '', '0', '0', '1', '1', '1', '0', '', '100', '1448439236', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('116', '1', 'manager/info', '修改个人信息', '', '', '0', '0', '0', '1', '1', '1', '', '100', '1448593741', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('117', '1', 'manager/password', '修改密码', '', '', '0', '0', '0', '1', '1', '1', '', '100', '1448594855', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('118', '71', 'ManagerActionLog', '管理员日志控制器', '', '', '1', '1', '1', '1', '1', '0', '', '100', '1450409832', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('152', '107', 'action/add', '添加行为', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('153', '107', 'action/edit', '修改行为', '', '', '0', '0', '1', '1', '1', '0', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('204', '101', 'authGroup/lists', '角色列表', '', '', '0', '0', '1', '1', '1', '1', '', '100', '1462695390', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('218', '71', 'manager/disable', '禁用用户', '', '', '0', '0', '1', '1', '1', '0', '', '100', '1463234283', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('219', '72', 'authRule/updateshow', '设置是否在控制台菜单显示', '', '', '0', '0', '1', '1', '1', '0', '', '100', '1463288822', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('220', '72', 'authRule/updateauth', '设置验证状态', '', '', '0', '0', '1', '1', '1', '0', '', '100', '1463289399', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('221', '5', 'category/index', '类别管理', '', '', '0', '0', '1', '1', '1', '1', '', '100', '1463657943', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('222', '221', 'category', '类别管理控制器', '', '', '1', '1', '1', '1', '1', '0', '', '100', '1463658455', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('223', '221', 'category/lists', '类别列表', '', '', '0', '0', '1', '1', '1', '1', '', '100', '1463659472', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('224', '221', 'category/add', '添加类别', '', '', '0', '0', '1', '1', '1', '1', '', '100', '1463662072', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('225', '72', 'authRule/disable', '设置规则状态', '', '', '0', '0', '1', '1', '1', '0', '', '100', '1463664692', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('226', '221', 'category/edit', '编辑类别', '', '', '0', '0', '1', '1', '1', '0', '', '100', '1463664960', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('227', '221', 'category/status', '设置类别状态', '', '', '0', '0', '1', '1', '1', '0', '', '100', '1463666434', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('228', '221', 'category/updateshow', '设置类别显示状态', '', '', '0', '0', '1', '1', '1', '0', '', '100', '1463928513', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('229', '8', 'developer/index', '开发管理', '', '', '0', '0', '1', '1', '1', '0', '', '100', '1464406829', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('230', '229', 'developer', '开发管理控制器', '', '', '1', '1', '1', '1', '1', '0', '', '100', '1464406877', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('231', '229', 'developer/lists', '开发日志列表', '', '', '0', '0', '1', '1', '1', '1', '', '100', '1464406930', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('232', '229', 'developer/add', '添加开发日志', '', '', '0', '0', '1', '1', '1', '1', '', '100', '1464406968', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('233', '229', 'developer/edit', '编辑开发日志', '', '', '0', '0', '1', '1', '1', '0', '', '100', '1464406994', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('234', '229', 'developer/view', '查看开发日志', '', '', '0', '0', '1', '1', '1', '0', '', '100', '1464410488', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('279', '71', 'manager', '管理员控制器', '', '', '1', '1', '1', '1', '1', '0', '', '100', '1466309256', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('280', '72', 'authRule', '规则管理控制器', '', '', '1', '1', '1', '1', '1', '0', '', '100', '1466309532', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('281', '101', 'authGroup', '角色管理控制器', '', '', '1', '1', '1', '1', '1', '0', '', '100', '1466309578', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('282', '8', 'config/index', '网站设置', 'config/index?group=base', '', '0', '0', '1', '1', '1', '1', '', '100', '1466310323', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('283', '284', 'config', '网站设置控制器', '', '', '1', '1', '1', '1', '1', '0', '', '100', '1466310459', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('284', '8', 'config/lists', '配置管理', '', '', '0', '0', '1', '1', '1', '1', '', '100', '1466311812', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('285', '284', 'config/add', '添加配置', '', '', '0', '0', '1', '1', '1', '1', '', '100', '1466311991', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('286', '284', 'config/edit', '编辑配置', '', '', '0', '0', '1', '1', '1', '0', '', '100', '1466312050', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('287', '284', 'config/del', '删除配置', '', '', '0', '0', '1', '1', '1', '0', '', '100', '1466312086', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('288', '284', 'config/sort', '排序配置', '', '', '0', '0', '1', '1', '1', '0', '', '100', '1466312110', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('289', '110', 'actionLog', '日志控制器', '', '', '1', '1', '1', '1', '1', '0', '', '100', '1466350259', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('290', '6', 'oauthUser', '第三方用户控制器', '', '', '1', '1', '1', '1', '1', '0', '', '100', '1466682341', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('291', '6', 'oauthUser/lists', '第三方用户列表', '', '', '0', '0', '1', '1', '1', '0', '', '100', '1466682386', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('292', '8', 'model/index', '模型管理', '', '', '0', '0', '1', '1', '1', '0', '', '100', '1466783831', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('293', '292', 'model', '模型管理控制器', '', '', '1', '1', '1', '1', '1', '0', '', '100', '1466783851', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('294', '292', 'model/lists', '模型列表', '', '', '0', '0', '1', '1', '1', '1', '', '100', '1466783877', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('295', '292', 'model/add', '添加模型', '', '', '0', '0', '1', '1', '1', '1', '', '100', '1466784186', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('296', '292', 'model/edit', '编辑模型', '', '', '0', '0', '1', '1', '1', '0', '', '100', '1466784200', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('297', '8', 'attribute/index', '字段属性管理', '', '', '0', '0', '1', '1', '1', '0', '', '100', '1466833500', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('298', '297', 'attribute', '字段属性控制器', '', '', '1', '1', '1', '1', '1', '0', '', '100', '1466833586', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('299', '297', 'attribute/lists', '字段属性列表', '', '', '0', '0', '1', '1', '1', '1', '', '100', '1466833616', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('300', '301', 'WebLog', '网站日志控制器', '', '', '1', '1', '1', '1', '1', '0', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('301', '8', 'WebLog/index', '网站日志管理', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('302', '301', 'WebLog/lists', '网站日志列表', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('303', '301', 'WebLog/seting', '网站日志设置', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('311', '110', 'actionLog/view', '行为查看详情', '', '', '0', '0', '1', '1', '1', '0', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('312', '52', 'article/lists', '内容列表', '', '', '0', '0', '1', '1', '1', '1', '', '100', '0', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('314', '5', 'article/add', '内容增加', '', '', '1', '1', '1', '1', '1', '1', '', '100', '1493710128', '1506756056');
INSERT INTO `cy_auth_rule` VALUES ('327', '25', 'test/test2', 'fdsafdd1', '', '', '1', '1', '1', '1', '1', '1', '', '100', '1509588149', '1509588149');
INSERT INTO `cy_auth_rule` VALUES ('328', '62', 'UcenterMember/edit', '本地用户编辑', '', '', '0', '0', '1', '1', '1', '0', '', '100', '1509948212', '1509948212');
INSERT INTO `cy_auth_rule` VALUES ('329', '62', 'UcenterMember/details', '本地用户查看', '', '', '0', '0', '1', '1', '1', '0', '', '100', '1509948258', '1509948258');
INSERT INTO `cy_auth_rule` VALUES ('331', '107', 'action/renew', '行为操作方法', '', '', '0', '0', '1', '1', '1', '0', '', '100', '1510722686', '1510722686');
INSERT INTO `cy_auth_rule` VALUES ('332', '107', 'action/details', '行为详情', '', '', '0', '0', '1', '1', '1', '0', '', '100', '1510813548', '1510813548');
INSERT INTO `cy_auth_rule` VALUES ('333', '107', 'actionLog/details', '行为日志详情', '', '', '0', '0', '1', '1', '1', '0', '', '100', '1510813735', '1510813860');
INSERT INTO `cy_auth_rule` VALUES ('334', '284', 'config/details', '配置详情', '', '', '0', '0', '1', '1', '1', '0', '', '100', '1510814008', '1510814008');
INSERT INTO `cy_auth_rule` VALUES ('335', '301', 'WebLog/details', '网站日志详情', '', '', '0', '0', '1', '1', '1', '0', '', '100', '1510814209', '1510814209');
INSERT INTO `cy_auth_rule` VALUES ('336', '83', 'DataBackup/lists', '数据库列表', '', '', '0', '0', '1', '1', '1', '1', '', '100', '1511754703', '1511754703');
INSERT INTO `cy_auth_rule` VALUES ('337', '83', 'DataBackup/importlist', '还原数据库', '', '', '0', '0', '1', '1', '1', '1', '', '100', '1511755154', '1511771383');
INSERT INTO `cy_auth_rule` VALUES ('338', '83', 'DataBackup/del', '删除数据库备份', '', '', '0', '0', '1', '1', '1', '0', '', '100', '1511755178', '1511755199');

-- -----------------------------
-- Table structure for `cy_category`
-- -----------------------------
DROP TABLE IF EXISTS `cy_category`;
CREATE TABLE `cy_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `name` varchar(30) NOT NULL COMMENT '标志',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `list_row` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '列表每页行数',
  `meta_title` varchar(50) NOT NULL DEFAULT '' COMMENT 'SEO的网页标题',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `template_index` varchar(100) NOT NULL DEFAULT '' COMMENT '频道页模板',
  `template_lists` varchar(100) NOT NULL DEFAULT '' COMMENT '列表页模板',
  `template_detail` varchar(100) NOT NULL DEFAULT '' COMMENT '详情页模板',
  `template_edit` varchar(100) NOT NULL DEFAULT '' COMMENT '编辑页模板',
  `model` varchar(100) NOT NULL DEFAULT '' COMMENT '列表绑定模型',
  `model_sub` varchar(100) NOT NULL DEFAULT '' COMMENT '子文档绑定模型',
  `type` varchar(100) NOT NULL DEFAULT '' COMMENT '允许发布的内容类型',
  `link_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '外链',
  `allow_publish` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否允许发布内容',
  `display` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '可见性',
  `reply` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否允许回复',
  `check` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发布的文章是否需要审核',
  `reply_model` varchar(100) NOT NULL DEFAULT '',
  `extend` text COMMENT '扩展设置',
  `create_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建者id',
  `create_ip` bigint(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建ip',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '数据状态',
  `icon` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分类图标',
  `groups` varchar(255) NOT NULL DEFAULT '' COMMENT '分组定义',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COMMENT='分类表';

-- -----------------------------
-- Records of `cy_category`
-- -----------------------------
INSERT INTO `cy_category` VALUES ('1', 'blog', '博客', '0', '0', '10', '', '', '', '', '', '', '', '2,3', '2', '2,1', '0', '0', '1', '0', '0', '1', '', '0', '0', '1379474947', '1382701539', '1', '0', '');
INSERT INTO `cy_category` VALUES ('2', 'default_blog', '默认分类', '1', '1', '10', '', '', '', '', '', '', '', '2,3', '2', '2,1,3', '0', '1', '1', '0', '1', '1', '', '0', '0', '1379475028', '1386839751', '1', '0', '');
INSERT INTO `cy_category` VALUES ('39', 'test', '测试', '0', '0', '10', '', '', '', '', '', '', '', '2', '', '2', '0', '1', '1', '0', '0', '', '', '0', '0', '1466845410', '1466845473', '1', '0', '');
INSERT INTO `cy_category` VALUES ('40', 'devloper', '开发日志', '0', '0', '10', '', '', '', '', '', '', '', '', '', '', '0', '0', '0', '0', '0', '', '', '1', '2130706433', '1493273997', '1493273997', '1', '0', '');

-- -----------------------------
-- Table structure for `cy_config`
-- -----------------------------
DROP TABLE IF EXISTS `cy_config`;
CREATE TABLE `cy_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '配置名称',
  `type` varchar(32) NOT NULL DEFAULT '0' COMMENT '配置类型',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '配置说明',
  `group` varchar(32) NOT NULL DEFAULT '0' COMMENT '配置分组',
  `extra` varchar(255) NOT NULL DEFAULT '' COMMENT '配置值',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '配置说明',
  `value` text COMMENT '配置值',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`),
  KEY `type` (`type`),
  KEY `group` (`group`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `cy_config`
-- -----------------------------
INSERT INTO `cy_config` VALUES ('1', 'web_site_title', 'text', '网站标题', 'base', '', '网站标题前台显示标题：<code>config(\'web_site_title\')</code>', '笨翁网', '0', '1', '1378898976', '1509691597');
INSERT INTO `cy_config` VALUES ('2', 'web_site_description', 'textarea', '网站描述', 'base', '', '网站搜索引擎描述', '笨翁网', '0', '1', '1378898976', '1506670255');
INSERT INTO `cy_config` VALUES ('3', 'web_site_keyword', 'textarea', '网站关键字', 'base', '', '网站搜索引擎关键字', 'cycms,笨翁网fds', '0', '1', '1378898976', '1506670255');
INSERT INTO `cy_config` VALUES ('4', 'web_site_close', 'switch', '关闭站点', 'base', '0:关闭,1:开启', '站点关闭后其他用户不能访问，管理员可以正常访问', '1', '1', '1', '1378898976', '1506670255');
INSERT INTO `cy_config` VALUES ('9', 'config_type_list', 'array', '配置类型列表', 'system', '', '主要用于数据解析和页面表单的生成', 'text:单行文本\ntextarea:多行文本\nstatic:静态文本\npassword:密码\ncheckbox:复选框\nradio:单选按钮\ndate:日期\ndatetime:日期+时间\nhidden:隐藏\nswitch:开关\narray:数组\nselect:下拉框\nlinkage:普通联动下拉框\nlinkages:快速联动下拉框\nimage:单张图片\nimages:多张图片\nfile:单个文件\nfiles:多个文件\nueditor:UEditor 编辑器\nwangeditor:wangEditor 编辑器\neditormd:markdown 编辑器\nckeditor:ckeditor 编辑器\nicon:字体图标\ntags:标签\nnumber:数字\nbmap:百度地图\ncolorpicker:取色器\njcrop:图片裁剪\nmasked:格式文本\nrange:范围\ntime:时间', '2', '1', '1378898976', '1509690187');
INSERT INTO `cy_config` VALUES ('10', 'web_site_icp', 'text', '网站备案号', 'base', '', '设置在网站底部显示的备案号，如“沪ICP备12007941号-2', '贵3', '9', '1', '1378900335', '1506670255');
INSERT INTO `cy_config` VALUES ('11', 'document_position', 'array', '文档推荐位', 'base', '', '文档推荐位，推荐到多个位置KEY值相加即可', '1:列表推荐\n2:频道推荐\n4:首页推荐', '3', '1', '1379053380', '1506670255');
INSERT INTO `cy_config` VALUES ('12', 'cocument_display', 'array', '文档可见性', 'base', '', '文章可见性仅影响前台显示，后台不收影响', '0:所有人可见\n1:仅注册会员可见\n2:仅管理员可见', '4', '1', '1379056370', '1506670255');
INSERT INTO `cy_config` VALUES ('13', 'color_style', 'textarea', '后台色系', 'upload', 'default_color:默认\nblue_color:紫罗兰', '后台颜色风格', 'default_color', '10', '1', '1379122533', '1466348008');
INSERT INTO `cy_config` VALUES ('20', 'config_group_list', 'array', '配置分组', 'system', '', '配置分组', 'base:基本\nsystem:系统\nupload:上传\ndevelop:开发\ndatabase:数据库', '4', '1', '1379228036', '1509690187');
INSERT INTO `cy_config` VALUES ('21', 'kooks_type', 'array', '钩子的类型', 'system', '', '类型 1-用于扩展显示内容，2-用于扩展业务处理', '1:视图\n2:控制器', '6', '1', '1379313397', '1509690187');
INSERT INTO `cy_config` VALUES ('22', 'auth_config', 'array', 'Auth配置', 'system', '', '自定义Auth.class.php类配置', 'AUTH_ON:1\nAUTH_TYPE:2', '8', '1', '1379409310', '1509690187');
INSERT INTO `cy_config` VALUES ('23', 'open_draftbox', 'switch', '是否开启草稿功能', 'base', '0:关闭草稿功能\n1:开启草稿功能\n', '新增文章时的草稿功能配置', '1', '1', '1', '1379484332', '1506670255');
INSERT INTO `cy_config` VALUES ('24', 'draft_aotosave_interval', 'text', '自动保存草稿时间', 'system', '', '自动保存草稿的时间间隔，单位：秒', '60', '2', '1', '1379484574', '1509690187');
INSERT INTO `cy_config` VALUES ('25', 'list_rows', 'text', '后台每页记录数', 'base', '', '后台数据每页显示记录数', '10', '10', '1', '1379503896', '1506670255');
INSERT INTO `cy_config` VALUES ('26', 'user_allow_register', 'switch', '是否允许用户注册', 'base', '0:关闭注册\n1:允许注册', '是否开放用户注册', '1', '1', '1', '1379504487', '1506670255');
INSERT INTO `cy_config` VALUES ('27', 'codemirror_theme', 'textarea', '预览插件的CodeMirror主题', 'system', '3024-day:3024 day\n3024-night:3024 night\nambiance:ambiance\nbase16-dark:base16 dark\nbase16-light:base16 light\nblackboard:blackboard\ncobalt:cobalt\neclipse:eclipse\nelegant:elegant\nerlang-dark:erlang-dark\nlesser-dark:lesser-dark\nmidnight:midnight', '详情见CodeMirror官网', 'ambiance', '3', '1', '1379814385', '1509690187');
INSERT INTO `cy_config` VALUES ('28', 'data_backup_path', 'text', '数据库备份根路径d', 'database', '', '路径必须以 / 结尾aa', './Data/', '5', '1', '1381482411', '1509696951');
INSERT INTO `cy_config` VALUES ('29', 'data_backup_part_size', 'text', '数据库备份卷大小', 'database', '', '该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M', '20971520', '7', '1', '1381482488', '1509696951');
INSERT INTO `cy_config` VALUES ('30', 'data_backup_compress', 'switch', '数据库备份文件是否启用压缩', 'database', '0:不压缩\n1:启用压缩', '压缩备份文件需要PHP环境支持gzopen,gzwrite函数ddddd', '1', '9', '1', '1381713345', '1509696951');
INSERT INTO `cy_config` VALUES ('31', 'data_backup_compress_level', 'radio', '数据库备份文件压缩级别', 'database', '1:普通\n4:一般\n9:最高', '数据库备份文件的压缩级别，该配置在开启压缩时生效', '9', '10', '1', '1381713408', '1506653407');
INSERT INTO `cy_config` VALUES ('32', 'develop_mode', 'switch', '开启开发者模式', 'develop', '0:关闭\n1:开启', '是否开启开发者模式1dsadsafdsf', '0', '11', '1', '1383105995', '1511418770');
INSERT INTO `cy_config` VALUES ('33', 'allow_visit', 'array', '不受限控制器方法', 'system', '', '', '0:article/draftbox\n1:article/mydocument\n2:Category/tree\n3:Index/verify\n4:file/upload\n5:file/download\n6:user/updatePassword\n7:user/updateNickname\n8:user/submitPassword\n9:user/submitNickname\n10:file/uploadpicture', '0', '1', '1386644047', '1509690187');
INSERT INTO `cy_config` VALUES ('34', 'deny_visit', 'array', '超管专限控制器方法', 'system', '', '仅超级管理员可访问的控制器方法', '0:Addons/addhook\n1:Addons/edithook\n2:Addons/delhook\n3:Addons/updateHook\n4:Admin/getMenus\n5:Admin/recordList\n6:AuthManager/updateRules\n7:AuthManager/tree', '0', '1', '1386644141', '1509690187');
INSERT INTO `cy_config` VALUES ('35', 'reply_list_rows', 'text', '回复列表每页条数', 'base', '', '', '10', '0', '0', '1386645376', '1506063234');
INSERT INTO `cy_config` VALUES ('36', 'admin_allow_ip', 'textarea', '后台允许访问IP', 'system', '', '多个用逗号分隔，如果不配置表示不限制IP访问d', '', '12', '1', '1387165454', '1509690187');
INSERT INTO `cy_config` VALUES ('37', 'show_page_trace', 'switch', '是否显示页面Trace', 'develop', '0:关闭\n1:开启', '是否显示页面Trace信息', '1', '1', '1', '1387165685', '1511418770');
INSERT INTO `cy_config` VALUES ('38', 'app_debug', 'switch', '是否开启调试模式', 'develop', '0:关闭\n1:开启', '是否开启调试模式状态，true 开启，false 关闭', '1', '1', '1', '1466342586', '1511418770');
INSERT INTO `cy_config` VALUES ('39', 'paginate', 'array', '分页配置', 'base', '', '用于配置分页选项，type分页样式，var_page分页参数，list_rows，每页显示条数', 'type:\\page\\Layui\nvar_page:page\npath:\nlist_rows:5', '6', '1', '1466346454', '1506670255');
INSERT INTO `cy_config` VALUES ('40', 'url_domain_deploy', 'switch', '域名部署路由', 'base', '0:关闭\n1:开启', '是否启用域名部署配置', '1', '1', '0', '1466347093', '1506063224');
INSERT INTO `cy_config` VALUES ('41', 'actionlog', 'switch', '开启行为记录', 'system', '0:关闭,1:开启', '', '1', '1', '1', '1506492553', '1509691793');
INSERT INTO `cy_config` VALUES ('43', 'actionlog_list', 'array', '行为记录特殊列表', 'base', '', '行为记录特殊方法列表，因为行为记录里排除了 get 请求的记录，这里的列表主要是为这些 get 请求增加记录操作标识，格式要求：控制器_方法（比如：actionlog_del）', 'actionlog_del\nactionlog_dd\nactionlog_ee', '3', '1', '1506503913', '1506670255');

-- -----------------------------
-- Table structure for `cy_developer`
-- -----------------------------
DROP TABLE IF EXISTS `cy_developer`;
CREATE TABLE `cy_developer` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `title` varchar(128) NOT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '状态，1为正常，0为禁用',
  `create_uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `create_ip` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建ip',
  `update_uid` int(11) unsigned DEFAULT '0' COMMENT '更新者id',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `update_ip` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新ip',
  `delete_status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '删除状态',
  `delete_uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '删除操作者id',
  `delete_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '删除操作时间',
  `delete_ip` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '删除操作ip',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `cy_developer`
-- -----------------------------
INSERT INTO `cy_developer` VALUES ('1', '添加开发日志功能-开发日志[20160528]', '<p>&nbsp;&nbsp;&nbsp;&nbsp;想记录着些什么，可不知道从哪里开始记录，一直想把这开发的过程记录起来，所以今天添加了开发日志的功能，用以来记录这一路走来的点点滴滴。<br/></p><p>&nbsp;&nbsp;&nbsp;&nbsp;随着 thinkphp 5 的不段完善，想着用新版本的框架来做一个东西，所以一开始就跟着官方在进步，每一次更新框架都是一个考验，当把新版本的框架更新完之后，再到程序里去运行，每一次都希望自己的东西在新版本的框架里运行时不会出现什么问题，当然，这过程也遇到过很多的报错，所以说每一次更新框架都是需要很大的勇气，但是又不得不更新，因为只能跟着官方走，官方的框架也在一步一步的完善。<br/></p><p>&nbsp;&nbsp;&nbsp;&nbsp;当然，有时候也傻逼傻逼地向官方反馈些根本不是错误的错误，全是自己不理解开发文档的错，但也不免会有些是bug，只是自己不知道罢了，半路出家，学业不精，只能这样的。<br/></p><p>&nbsp;&nbsp;&nbsp;&nbsp;好吧，时间也不早了，废话了一大堆，该记记今天的日志了。<br/></p><p>&nbsp;&nbsp;&nbsp;&nbsp;这是第一篇开发日志，因为开发日志记录功能才刚刚完善，此时的版本升级到了0.8<br/></p><p><br/></p><p>[20160528]</p><p>一、新增</p><ol><li><p>开发日志，这就不用说了</p></li><li><p>新增了developer表<br/></p></li><li><p>新增了ueditor编辑器</p></li></ol><p><br/></p><p>二、更新</p><ol><li><p>更新了基本模板</p></li><li><p>更新了缓存操作</p></li><li><p>更新了侧边栏</p></li></ol><p><br/></p><p>&nbsp;&nbsp;&nbsp;&nbsp;第一每写开发日志，写着写着就想不起来这一天以来都做了些什么，只知道做了很多的东西，可真正到写的时候全部都忘得一干二净，脑海里什么都没有，好吧，就这样。<br/></p><p>&nbsp;&nbsp;&nbsp;&nbsp;晚安。<br/></p><p>&nbsp;&nbsp;&nbsp;&nbsp;晚安，宝贝。<br/></p>', '1', '1', '1464453027', '2130706433', '1', '1464504470', '2130706433', '1', '0', '0', '0');
INSERT INTO `cy_developer` VALUES ('2', '测试插件编辑器', '<p>测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器测试插件编辑器</p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><img src=\"/data/images/20160621/c117bae9c082a5e49560add921952554.jpg\" title=\"测试插件编辑器\" alt=\"测试插件编辑器\"/></p><p><br/></p><p><br/></p><p><br/></p><p>工载城</p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p>', '1', '1', '1466441432', '2130706433', '1', '1466441589', '2130706433', '1', '0', '0', '0');

-- -----------------------------
-- Table structure for `cy_document`
-- -----------------------------
DROP TABLE IF EXISTS `cy_document`;
CREATE TABLE `cy_document` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文档ID',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `name` char(40) NOT NULL DEFAULT '' COMMENT '标识',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '标题',
  `category_id` int(10) unsigned NOT NULL COMMENT '所属分类',
  `group_id` smallint(3) unsigned NOT NULL COMMENT '所属分组',
  `description` char(140) NOT NULL DEFAULT '' COMMENT '描述',
  `root` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '根节点',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属ID',
  `model_id` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '内容模型ID',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '2' COMMENT '内容类型',
  `position` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '推荐位',
  `link_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '外链',
  `cover_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '封面',
  `display` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '可见性',
  `deadline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '截至时间',
  `attach` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '附件数量',
  `view` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `comment` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `extend` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '扩展统计字段',
  `level` int(10) NOT NULL DEFAULT '0' COMMENT '优先级',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '数据状态',
  PRIMARY KEY (`id`),
  KEY `idx_category_status` (`category_id`,`status`),
  KEY `idx_status_type_pid` (`status`,`uid`,`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='文档模型基础表';

-- -----------------------------
-- Records of `cy_document`
-- -----------------------------
INSERT INTO `cy_document` VALUES ('1', '1', '', 'OneThink1.1开发版发布', '2', '0', '期待已久的OneThink最新版发布', '0', '0', '2', '2', '0', '0', '0', '1', '0', '0', '37', '0', '0', '0', '1406001413', '1406001413', '1');
INSERT INTO `cy_document` VALUES ('2', '1', '', '成功案例1', '2', '0', '', '0', '0', '2', '2', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0', '1466442682', '1466442682', '2');
INSERT INTO `cy_document` VALUES ('3', '1', '', 'ds sdf', '2', '0', '', '0', '0', '2', '2', '0', '0', '0', '1', '0', '0', '1', '0', '0', '0', '1466442722', '1466442722', '1');

-- -----------------------------
-- Table structure for `cy_document_article`
-- -----------------------------
DROP TABLE IF EXISTS `cy_document_article`;
CREATE TABLE `cy_document_article` (
  `id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文档ID',
  `parse` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '内容解析类型',
  `content` text NOT NULL COMMENT '文章内容',
  `template` varchar(100) NOT NULL DEFAULT '' COMMENT '详情页显示模板',
  `bookmark` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文档模型文章表';

-- -----------------------------
-- Records of `cy_document_article`
-- -----------------------------
INSERT INTO `cy_document_article` VALUES ('1', '0', '<h1>\r\n	OneThink1.1开发版发布&nbsp;\r\n</h1>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	<strong>OneThink是一个开源的内容管理框架，基于最新的ThinkPHP3.2版本开发，提供更方便、更安全的WEB应用开发体验，采用了全新的架构设计和命名空间机制，融合了模块化、驱动化和插件化的设计理念于一体，开启了国内WEB应用傻瓜式开发的新潮流。&nbsp;</strong> \r\n</p>\r\n<h2>\r\n	主要特性：\r\n</h2>\r\n<p>\r\n	1. 基于ThinkPHP最新3.2版本。\r\n</p>\r\n<p>\r\n	2. 模块化：全新的架构和模块化的开发机制，便于灵活扩展和二次开发。&nbsp;\r\n</p>\r\n<p>\r\n	3. 文档模型/分类体系：通过和文档模型绑定，以及不同的文档类型，不同分类可以实现差异化的功能，轻松实现诸如资讯、下载、讨论和图片等功能。\r\n</p>\r\n<p>\r\n	4. 开源免费：OneThink遵循Apache2开源协议,免费提供使用。&nbsp;\r\n</p>\r\n<p>\r\n	5. 用户行为：支持自定义用户行为，可以对单个用户或者群体用户的行为进行记录及分享，为您的运营决策提供有效参考数据。\r\n</p>\r\n<p>\r\n	6. 云端部署：通过驱动的方式可以轻松支持平台的部署，让您的网站无缝迁移，内置已经支持SAE和BAE3.0。\r\n</p>\r\n<p>\r\n	7. 云服务支持：即将启动支持云存储、云安全、云过滤和云统计等服务，更多贴心的服务让您的网站更安心。\r\n</p>\r\n<p>\r\n	8. 安全稳健：提供稳健的安全策略，包括备份恢复、容错、防止恶意攻击登录，网页防篡改等多项安全管理功能，保证系统安全，可靠、稳定的运行。&nbsp;\r\n</p>\r\n<p>\r\n	9. 应用仓库：官方应用仓库拥有大量来自第三方插件和应用模块、模板主题，有众多来自开源社区的贡献，让您的网站“One”美无缺。&nbsp;\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	<strong>&nbsp;OneThink集成了一个完善的后台管理体系和前台模板标签系统，让你轻松管理数据和进行前台网站的标签式开发。&nbsp;</strong> \r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<h2>\r\n	后台主要功能：\r\n</h2>\r\n<p>\r\n	1. 用户Passport系统\r\n</p>\r\n<p>\r\n	2. 配置管理系统&nbsp;\r\n</p>\r\n<p>\r\n	3. 权限控制系统\r\n</p>\r\n<p>\r\n	4. 后台建模系统&nbsp;\r\n</p>\r\n<p>\r\n	5. 多级分类系统&nbsp;\r\n</p>\r\n<p>\r\n	6. 用户行为系统&nbsp;\r\n</p>\r\n<p>\r\n	7. 钩子和插件系统\r\n</p>\r\n<p>\r\n	8. 系统日志系统&nbsp;\r\n</p>\r\n<p>\r\n	9. 数据备份和还原\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	&nbsp;[ 官方下载：&nbsp;<a href=\"http://www.onethink.cn/download.html\" target=\"_blank\">http://www.onethink.cn/download.html</a>&nbsp;&nbsp;开发手册：<a href=\"http://document.onethink.cn/\" target=\"_blank\">http://document.onethink.cn/</a>&nbsp;]&nbsp;\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	<strong>OneThink开发团队 2013~2014</strong> \r\n</p>', '', '0');
INSERT INTO `cy_document_article` VALUES ('2', '2', 'fds afds ads ads dsa \r\nfads \r\ndsf \r\nsadf 1. * > \r\n* * * * *\r\n\r\n* * * * *\r\n\r\n* * * * *\r\n\r\n* * * * *\r\n\r\n* * * * *[]()\r\n\r\n* * * * *\r\n\r\n* * * * *\r\n\r\n* * * * *\r\n\r\n* * * * *\r\n\r\n* * * * *\r\n\r\ndsaf \r\nsad \r\ndsf \r\ndsaf s\r\nadf \r\ndsaf adsf\r\n s\r\nadf sad\r\n \r\nadsf \r\ndsaf \r\ndsf \r\nads \r\nsadf\r\n sadf\r\n ads\r\n \r\nads \r\ndsa \r\ndsa \r\nads \r\nsd\r\n sd\r\n \r\nds \r\nsd \r\nsad\r\n \r\ndsa \r\nas \r\nasdf\r\n fads\r\n d\r\nas \r\nfds asdf\r\n sd\r\n sd\r\n sad\r\n as\r\n as\r\n \r\nsd\r\n s\r\ndf \r\nsdf\r\n sad\r\nf \r\nasfd \r\nsad sad\r\n fsd\r\n fs\r\nd \r\nasdf \r\nadsf \r\nsadf\r\n sadf\r\n \r\nsfd \r\nsdf\r\n s df', '', '0');
INSERT INTO `cy_document_article` VALUES ('3', '2', 'dsfa fdsa sadf ', '', '0');

-- -----------------------------
-- Table structure for `cy_hooks`
-- -----------------------------
DROP TABLE IF EXISTS `cy_hooks`;
CREATE TABLE `cy_hooks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '钩子名称',
  `description` text COMMENT '描述',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类型',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `addons` varchar(255) NOT NULL DEFAULT '' COMMENT '钩子挂载的插件 ''，''分割',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `cy_hooks`
-- -----------------------------
INSERT INTO `cy_hooks` VALUES ('1', 'pageHeader', '页面header钩子，一般用于加载插件CSS文件和代码', '1', '0', '', '1');
INSERT INTO `cy_hooks` VALUES ('2', 'pageFooter', '页面footer钩子，一般用于加载插件JS文件和JS代码', '1', '0', 'ReturnTop', '1');
INSERT INTO `cy_hooks` VALUES ('3', 'documentEditForm', '添加编辑表单的 扩展内容钩子', '1', '0', 'Attachment', '1');
INSERT INTO `cy_hooks` VALUES ('4', 'documentDetailAfter', '文档末尾显示', '1', '0', 'SocialComment,Attachment', '1');
INSERT INTO `cy_hooks` VALUES ('5', 'documentDetailBefore', '页面内容前显示用钩子', '1', '0', '', '1');
INSERT INTO `cy_hooks` VALUES ('6', 'documentSaveComplete', '保存文档数据后的扩展钩子', '2', '0', 'Attachment', '1');
INSERT INTO `cy_hooks` VALUES ('7', 'documentEditFormContent', '添加编辑表单的内容显示钩子', '1', '0', 'Editor', '1');
INSERT INTO `cy_hooks` VALUES ('8', 'adminArticleEdit', '后台内容编辑页编辑器', '1', '1378982734', 'YcEditor,EditorForAdmin', '1');
INSERT INTO `cy_hooks` VALUES ('13', 'AdminIndex', '首页小格子个性化显示', '1', '1382596073', 'SystemInfo,DevTeam,SiteStat', '1');
INSERT INTO `cy_hooks` VALUES ('14', 'topicComment', '评论提交方式扩展钩子。', '1', '1380163518', 'Editor', '1');
INSERT INTO `cy_hooks` VALUES ('16', 'app_begin', '应用开始', '2', '1384481614', '', '1');
INSERT INTO `cy_hooks` VALUES ('17', 'oauth', '第三方登录钩子', '2', '1384481614', 'Oauth', '1');
INSERT INTO `cy_hooks` VALUES ('18', 'testEditor', '这是测试编辑器', '2', '1384481614', 'YcEditor', '1');

-- -----------------------------
-- Table structure for `cy_manager`
-- -----------------------------
DROP TABLE IF EXISTS `cy_manager`;
CREATE TABLE `cy_manager` (
  `id` mediumint(11) NOT NULL AUTO_INCREMENT COMMENT '管理员id',
  `uid` mediumint(11) NOT NULL DEFAULT '0' COMMENT '用户表id',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '管理员状态，0为禁用，1为正常',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `cy_manager`
-- -----------------------------
INSERT INTO `cy_manager` VALUES ('1', '1', '1');
INSERT INTO `cy_manager` VALUES ('2', '2', '1');
INSERT INTO `cy_manager` VALUES ('3', '3', '1');

-- -----------------------------
-- Table structure for `cy_model`
-- -----------------------------
DROP TABLE IF EXISTS `cy_model`;
CREATE TABLE `cy_model` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '模型ID',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '模型标识',
  `title` char(30) NOT NULL DEFAULT '' COMMENT '模型名称',
  `extend` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '继承的模型',
  `relation` varchar(30) NOT NULL DEFAULT '' COMMENT '继承与被继承模型的关联字段',
  `need_pk` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '新建表时是否需要主键字段',
  `field_sort` text COMMENT '表单字段排序',
  `field_group` varchar(255) NOT NULL DEFAULT '1:基础' COMMENT '字段分组',
  `attribute_list` text COMMENT '属性列表（表的字段）',
  `attribute_alias` varchar(255) NOT NULL DEFAULT '' COMMENT '属性别名定义',
  `template_list` varchar(100) NOT NULL DEFAULT '' COMMENT '列表模板',
  `template_add` varchar(100) NOT NULL DEFAULT '' COMMENT '新增模板',
  `template_edit` varchar(100) NOT NULL DEFAULT '' COMMENT '编辑模板',
  `list_grid` text COMMENT '列表定义',
  `list_row` smallint(2) unsigned NOT NULL DEFAULT '10' COMMENT '列表数据长度',
  `search_key` varchar(50) NOT NULL DEFAULT '' COMMENT '默认搜索字段',
  `search_list` varchar(255) NOT NULL DEFAULT '' COMMENT '高级搜索的字段',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `engine_type` varchar(25) NOT NULL DEFAULT 'MyISAM' COMMENT '数据库引擎',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='文档模型表';

-- -----------------------------
-- Records of `cy_model`
-- -----------------------------
INSERT INTO `cy_model` VALUES ('1', 'document', '基础文档', '0', '', '1', '{\"1\":[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"20\",\"21\",\"22\"]}', '1:基础', '', '', '', '', '', 'id:编号\ntitle:标题:[EDIT]\ntype:类型\nupdate_time:最后更新\nstatus:状态\nview:浏览\nid:操作:[EDIT]|编辑,[DELETE]|删除', '0', '', '', '1383891233', '1384507827', '1', 'MyISAM');
INSERT INTO `cy_model` VALUES ('2', 'article', '文章', '1', '', '1', '{\"1\":[\"3\",\"24\",\"2\",\"5\"],\"2\":[\"9\",\"13\",\"19\",\"10\",\"12\",\"16\",\"17\",\"26\",\"20\",\"14\",\"11\",\"25\"]}', '1:基础,2:扩展', '', '', '', '', '', 'title:标题:[EDIT]\ntype:类型\nupdate_time:最后更新', '0', '', '', '1383891243', '1466851058', '1', 'MyISAM');
INSERT INTO `cy_model` VALUES ('3', 'download', '下载', '1', '', '1', '{\"1\":[\"3\",\"28\",\"30\",\"32\",\"2\",\"5\",\"31\"],\"2\":[\"13\",\"10\",\"9\",\"12\",\"16\",\"17\",\"19\",\"11\",\"20\",\"14\",\"29\"]}', '1:基础,2:扩展', '', '', '', '', '', '', '0', '', '', '1383891252', '1466832628', '1', 'MyISAM');

-- -----------------------------
-- Table structure for `cy_oauth_user`
-- -----------------------------
DROP TABLE IF EXISTS `cy_oauth_user`;
CREATE TABLE `cy_oauth_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '表自增id',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户表id',
  `name` varchar(64) NOT NULL COMMENT '名称',
  `nick` varchar(64) NOT NULL COMMENT '昵称',
  `head_img` varchar(200) NOT NULL COMMENT '头像',
  `access_token` varchar(512) NOT NULL COMMENT '第三方token',
  `openid` varchar(64) NOT NULL COMMENT '第三方openid',
  `expires_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '第三方登录过期时间',
  `refresh_token` varchar(512) NOT NULL COMMENT '在授权自动续期步骤中，获取新的Access_Token时需要提供的参数',
  `type` varchar(20) NOT NULL COMMENT '来自第三方',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '状态，1为正常，0为禁用',
  `times` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `create_uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `create_ip` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建ip',
  `update_uid` int(11) unsigned DEFAULT '0' COMMENT '更新者id',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `update_ip` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新ip',
  `delete_status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '删除状态',
  `delete_uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '删除操作者id',
  `delete_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '删除操作时间',
  `delete_ip` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '删除操作ip',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='第三方登录用户表';


-- -----------------------------
-- Table structure for `cy_picture`
-- -----------------------------
DROP TABLE IF EXISTS `cy_picture`;
CREATE TABLE `cy_picture` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id自增',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '路径',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '图片链接',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- -----------------------------
-- Table structure for `cy_ucenter_member`
-- -----------------------------
DROP TABLE IF EXISTS `cy_ucenter_member`;
CREATE TABLE `cy_ucenter_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` char(16) NOT NULL COMMENT '用户名',
  `password` char(64) NOT NULL COMMENT '密码',
  `salt` char(10) NOT NULL COMMENT '盐值',
  `email` char(32) NOT NULL COMMENT '用户邮箱',
  `mobile` char(15) NOT NULL DEFAULT '' COMMENT '用户手机',
  `nickname` char(30) NOT NULL COMMENT '昵称',
  `realname` char(30) NOT NULL COMMENT '真实姓名',
  `status` tinyint(4) DEFAULT '1' COMMENT '用户状态,1为正常，0为禁用',
  `times` int(10) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `avatar` varchar(255) NOT NULL COMMENT '头像',
  `create_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建者id',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `create_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '注册IP',
  `update_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新者id',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `update_ip` int(10) NOT NULL DEFAULT '0' COMMENT '更新ip',
  `login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `login_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `delete_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '删除标识，1为正常，0为删除',
  `delete_uid` int(10) NOT NULL DEFAULT '0' COMMENT '删除操作人id',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间（软删除）',
  `delete_ip` bigint(10) NOT NULL DEFAULT '0' COMMENT '删除ip',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE,
  UNIQUE KEY `email` (`email`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- -----------------------------
-- Records of `cy_ucenter_member`
-- -----------------------------
INSERT INTO `cy_ucenter_member` VALUES ('1', 'admin', '$2a$08$QSV/.uhMhfDpHRZy6dNXoORz9nWNuMh1lBxSyZZZYUFdJ6n8Ny3K.', 'yaIDbJHVTh', 'ceroot@163.com', '13985558113', '超级管理员', '超级管理员', '1', '753', '', '0', '1487836709', '2130706433', '1', '1511772058', '2130706433', '1511772058', '2130706433', '1', '1', '', '2130706433');
INSERT INTO `cy_ucenter_member` VALUES ('2', 'manager', 'df22257f6865fc25d93eba3611efa014', 'snaxwhq3fN', 'manager@benweng.com', '', 'manager', 'manager', '1', '3', '', '1', '1509600463', '2130706433', '1', '1510823942', '30156822', '1510750908', '1971836001', '1', '0', '', '0');
INSERT INTO `cy_ucenter_member` VALUES ('3', 'test', '$2a$08$xfHVJXc8hrMUfjZzOC9zD.yLzLSmSMja08v4pgkF4rmFjZIlbI9MG', 'WFPtvQMT5T', 'test@benweng.com', '', 'test', '测试用户', '1', '82', '', '1', '1509600499', '2130706433', '1', '1511765482', '2130706433', '1511765482', '2130706433', '1', '0', '', '0');

-- -----------------------------
-- Table structure for `cy_user`
-- -----------------------------
DROP TABLE IF EXISTS `cy_user`;
CREATE TABLE `cy_user` (
  `uid` mediumint(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `username` varchar(30) NOT NULL COMMENT '用户名称',
  `password` char(32) NOT NULL COMMENT '用户密码',
  `nickname` char(30) NOT NULL COMMENT '用户昵称',
  `realname` char(30) NOT NULL COMMENT '真实姓名',
  `email` varchar(60) NOT NULL COMMENT '邮箱',
  `create_uid` mediumint(11) NOT NULL DEFAULT '0' COMMENT '创建者id',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `create_ip` bigint(11) NOT NULL DEFAULT '0' COMMENT '创建ip',
  `update_uid` mediumint(11) NOT NULL DEFAULT '0' COMMENT '更新者id',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `update_ip` bigint(11) NOT NULL DEFAULT '0' COMMENT '更新ip',
  `login_time` int(11) NOT NULL DEFAULT '0' COMMENT '登录时间',
  `login_ip` bigint(11) NOT NULL DEFAULT '0' COMMENT '登录ip',
  `role` tinyint(2) NOT NULL DEFAULT '1' COMMENT '角色',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态，0为正常，1为禁用',
  `times` int(6) NOT NULL DEFAULT '0' COMMENT '登录次数',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

