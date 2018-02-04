/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50720
 Source Host           : localhost:3306
 Source Schema         : think.admin

 Target Server Type    : MySQL
 Target Server Version : 50720
 File Encoding         : 65001

 Date: 03/02/2018 19:27:25
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for wechat_menu
-- ----------------------------
DROP TABLE IF EXISTS `wechat_menu`;
CREATE TABLE `wechat_menu`  (
  `id` bigint(16) UNSIGNED NOT NULL AUTO_INCREMENT,
  `index` bigint(20) NULL DEFAULT NULL,
  `pindex` bigint(20) UNSIGNED NOT NULL DEFAULT 0 COMMENT '父id',
  `type` varchar(24) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '菜单类型 null主菜单 link链接 keys关键字',
  `name` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '菜单名称',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文字内容',
  `sort` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '排序',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '状态(0禁用1启用)',
  `create_by` bigint(20) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建人',
  `create_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_wechat_menu_pindex`(`pindex`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 30 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '微信菜单配置' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wechat_menu
-- ----------------------------
INSERT INTO `wechat_menu` VALUES (22, 1, 0, 'text', '一级菜单', '', 0, 1, 0, '2018-02-03 19:19:23');
INSERT INTO `wechat_menu` VALUES (23, 11, 1, 'text', '二级菜单', '', 0, 1, 0, '2018-02-03 19:19:23');
INSERT INTO `wechat_menu` VALUES (24, 12, 1, 'text', '二级菜单', '', 1, 1, 0, '2018-02-03 19:19:23');
INSERT INTO `wechat_menu` VALUES (25, 13, 1, 'keys', '二级菜单', 'scancode_push', 2, 1, 0, '2018-02-03 19:19:23');
INSERT INTO `wechat_menu` VALUES (26, 14, 1, 'text', '二级菜单', '', 3, 1, 0, '2018-02-03 19:19:23');
INSERT INTO `wechat_menu` VALUES (27, 15, 1, 'customservice', '二级菜单', 'location_select', 4, 1, 0, '2018-02-03 19:19:23');
INSERT INTO `wechat_menu` VALUES (28, 2, 0, 'text', '一级菜单', '', 1, 1, 0, '2018-02-03 19:19:23');
INSERT INTO `wechat_menu` VALUES (29, 3, 0, 'text', '一级菜单', '', 2, 1, 0, '2018-02-03 19:19:23');

SET FOREIGN_KEY_CHECKS = 1;
