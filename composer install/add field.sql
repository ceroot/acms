ALTER TABLE `cy_theme`
ADD `create_uid` INT(11) NOT NULL DEFAULT '0' COMMENT '添加者 id' AFTER `remark`,
ADD `create_time` INT(11) NOT NULL DEFAULT '0' COMMENT '添加时间' AFTER `create_uid`,
ADD `create_ip` BIGINT(11) NOT NULL DEFAULT '0' COMMENT '添加 ip' AFTER `create_time`,
ADD `update_uid` INT(11) NOT NULL DEFAULT '0' COMMENT '修改者 id' AFTER `create_ip`,
ADD `update_time` INT(11) NOT NULL DEFAULT '0' COMMENT '修改时间' AFTER `update_uid`,
ADD `update_ip` BIGINT(11) NOT NULL DEFAULT '0' COMMENT '修改 ip' AFTER `update_time`,
ADD `delete_uid` INT(11) NOT NULL DEFAULT '0' COMMENT '删除者 id' AFTER `update_ip`,
ADD `delete_time` INT(11) NULL DEFAULT NULL COMMENT '删除时间（软删除）' AFTER `delete_uid`,
ADD `delete_ip` BIGINT(11) NOT NULL DEFAULT '0' COMMENT '删除 ip' AFTER `delete_time`;