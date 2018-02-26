/*
Navicat MySQL Data Transfer

Source Server         : localhost_phpstudy
Source Server Version : 50553
Source Host           : 127.0.0.1:3306
Source Database       : tsrms

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-02-26 11:28:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin_unit
-- ----------------------------
DROP TABLE IF EXISTS `admin_unit`;
CREATE TABLE `admin_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` char(20) NOT NULL,
  `contact_man` varchar(255) NOT NULL,
  `contact_tel` char(20) NOT NULL,
  `infos` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='公产单位';

-- ----------------------------
-- Records of admin_unit
-- ----------------------------
INSERT INTO `admin_unit` VALUES ('1', '公产单位1', '渝北区', '023-88888888', '张三', '13012345678', null, '2018-02-22 15:25:24', '2018-02-22 15:25:24', null);

-- ----------------------------
-- Table structure for a_api
-- ----------------------------
DROP TABLE IF EXISTS `a_api`;
CREATE TABLE `a_api` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级ID，【必须】',
  `name` varchar(255) NOT NULL COMMENT '名称,【必须，唯一】',
  `url` varchar(255) NOT NULL COMMENT ' 地址，【必须,唯一】',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型，【必须】【0get,1post】',
  `infos` text COMMENT '描述',
  `req` text NOT NULL COMMENT ' 请求参数，【必须】【key-val-exp】',
  `res` text NOT NULL COMMENT '响应参数，【必须】【key-val-exp】',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序，【必须】',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='接口文档';

-- ----------------------------
-- Records of a_api
-- ----------------------------

-- ----------------------------
-- Table structure for a_control_cate
-- ----------------------------
DROP TABLE IF EXISTS `a_control_cate`;
CREATE TABLE `a_control_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名称【必须，唯一】',
  `infos` text COMMENT ' 描述',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) COMMENT '名称唯一'
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='项目控制类型分类';

-- ----------------------------
-- Records of a_control_cate
-- ----------------------------
INSERT INTO `a_control_cate` VALUES ('1', '评估机构投票时间', '被征收户线上投票选择评估机构的时间限制', '2018-02-09 15:08:32', '2018-02-09 15:12:16', null);
INSERT INTO `a_control_cate` VALUES ('2', '社会稳定风险评估时间', null, '2018-02-09 15:09:23', '2018-02-09 15:09:23', null);
INSERT INTO `a_control_cate` VALUES ('3', '排队预约选房时间', null, '2018-02-09 15:10:21', '2018-02-09 15:10:21', null);

-- ----------------------------
-- Table structure for a_file_table
-- ----------------------------
DROP TABLE IF EXISTS `a_file_table`;
CREATE TABLE `a_file_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '表名，【必须，唯一】',
  `infos` text COMMENT '描述',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) COMMENT '名称唯一'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='必备附件分类-数据表';

-- ----------------------------
-- Records of a_file_table
-- ----------------------------
INSERT INTO `a_file_table` VALUES ('1', 'item', '项目审查资料', null, '2018-02-09 15:28:20', null);

-- ----------------------------
-- Table structure for a_item_funds_cate
-- ----------------------------
DROP TABLE IF EXISTS `a_item_funds_cate`;
CREATE TABLE `a_item_funds_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名称【必须，唯一】',
  `infos` text COMMENT ' 描述',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) COMMENT '名称唯一'
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='项目资金进出类型';

-- ----------------------------
-- Records of a_item_funds_cate
-- ----------------------------
INSERT INTO `a_item_funds_cate` VALUES ('1', '项目筹备资金', null, '2018-02-09 15:58:50', '2018-02-09 15:58:50', null);
INSERT INTO `a_item_funds_cate` VALUES ('2', '补偿款与产权调换房价的差额', null, '2018-02-09 16:02:20', '2018-02-09 16:02:20', null);
INSERT INTO `a_item_funds_cate` VALUES ('3', '货币补偿款', null, '2018-02-09 16:02:34', '2018-02-09 16:02:34', null);
INSERT INTO `a_item_funds_cate` VALUES ('4', '产权调换结余补偿款', null, '2018-02-09 16:03:20', '2018-02-09 16:03:20', null);
INSERT INTO `a_item_funds_cate` VALUES ('5', '补充协议补偿金', null, '2018-02-09 16:03:49', '2018-02-09 16:03:49', null);
INSERT INTO `a_item_funds_cate` VALUES ('6', '公产单位补偿款', null, '2018-02-09 16:04:09', '2018-02-09 16:04:09', null);
INSERT INTO `a_item_funds_cate` VALUES ('7', '项目拆除费', null, '2018-02-09 16:04:28', '2018-02-09 16:04:28', null);
INSERT INTO `a_item_funds_cate` VALUES ('8', '项目评估费', null, '2018-02-09 16:04:40', '2018-02-09 16:04:55', null);

-- ----------------------------
-- Table structure for a_item_notice_cate
-- ----------------------------
DROP TABLE IF EXISTS `a_item_notice_cate`;
CREATE TABLE `a_item_notice_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名称【必须，唯一】',
  `infos` text COMMENT ' 描述',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) COMMENT '名称唯一'
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='项目内部通知分类';

-- ----------------------------
-- Records of a_item_notice_cate
-- ----------------------------
INSERT INTO `a_item_notice_cate` VALUES ('1', '项目不予受理通知', null, '2018-02-09 16:12:46', '2018-02-09 16:12:46', null);
INSERT INTO `a_item_notice_cate` VALUES ('2', '房屋征收补偿资金总额预算通知', null, '2018-02-09 16:13:53', '2018-02-09 16:13:53', null);
INSERT INTO `a_item_notice_cate` VALUES ('3', '征收房屋相关手续停办通知', null, '2018-02-09 16:16:41', '2018-02-09 16:16:41', null);

-- ----------------------------
-- Table structure for a_menu
-- ----------------------------
DROP TABLE IF EXISTS `a_menu`;
CREATE TABLE `a_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上級ID，【必须】',
  `name` varchar(255) NOT NULL COMMENT ' 名称，【必须】',
  `icon` varchar(255) DEFAULT NULL COMMENT ' 图标，【代码】',
  `module` tinyint(4) NOT NULL DEFAULT '0' COMMENT '模块，0征收部门，1评估机构，2被征收户，3触摸屏，4后台',
  `url` varchar(255) NOT NULL COMMENT ' 路由地址，【必须，目录级填#】',
  `method` varchar(255) DEFAULT NULL COMMENT ' 限制请求方法，【get，post，put，delete】',
  `login` tinyint(1) NOT NULL DEFAULT '1' COMMENT '限制登录访问，【0否，1是】',
  `auth` tinyint(1) NOT NULL DEFAULT '1' COMMENT '限制操作访问，【0否，1是】',
  `display` tinyint(1) NOT NULL DEFAULT '0' COMMENT '显示，【0隐藏，1显示】',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `infos` text COMMENT '描述',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`) COMMENT '上级ID'
) ENGINE=MyISAM AUTO_INCREMENT=230 DEFAULT CHARSET=utf8 COMMENT='功能与菜单';

-- ----------------------------
-- Records of a_menu
-- ----------------------------
INSERT INTO `a_menu` VALUES ('1', '0', '入口', '<i class=\"menu-icon fa fa-telegram bigger-120\"></i>', '4', '/sys', null, '0', '0', '0', '0', null, '2018-02-08 18:52:53', '2018-02-10 16:39:25', null);
INSERT INTO `a_menu` VALUES ('2', '1', '登录', null, '4', '/sys/login', 'post', '0', '0', '0', '0', null, '2018-02-08 18:54:09', '2018-02-08 18:54:09', null);
INSERT INTO `a_menu` VALUES ('3', '1', '退出', null, '4', '/sys/logout', null, '0', '0', '0', '0', null, '2018-02-08 18:55:49', '2018-02-08 18:55:49', null);
INSERT INTO `a_menu` VALUES ('4', '0', '首页', '<i class=\"menu-icon fa fa-home bigger-120\"></i>', '4', '/sys/home', null, '1', '0', '1', '0', null, '2018-02-08 19:37:44', '2018-02-11 14:16:27', null);
INSERT INTO `a_menu` VALUES ('5', '0', '功能与菜单', '<i class=\"menu-icon fa fa-list bigger-120\"></i>', '4', '/sys/menu', null, '1', '1', '1', '0', null, '2018-02-08 19:50:48', '2018-02-09 20:43:08', null);
INSERT INTO `a_menu` VALUES ('6', '5', '添加菜单', null, '4', '/sys/menu_add', null, '1', '1', '0', '0', null, '2018-02-08 19:51:33', '2018-02-09 20:50:54', null);
INSERT INTO `a_menu` VALUES ('7', '5', '菜单详情', null, '4', '/sys/menu_info', null, '1', '1', '0', '0', null, '2018-02-08 19:53:59', '2018-02-09 20:38:22', null);
INSERT INTO `a_menu` VALUES ('8', '5', '修改菜单', null, '4', '/sys/menu_edit', null, '1', '1', '0', '0', null, '2018-02-08 19:54:20', '2018-02-09 20:38:43', null);
INSERT INTO `a_menu` VALUES ('9', '0', '项目进度', '<i class=\"menu-icon fa fa-sort-amount-asc bigger-120\"></i>', '4', '/sys/schedule', null, '1', '1', '1', '0', null, '2018-02-09 10:56:57', '2018-02-09 20:44:31', null);
INSERT INTO `a_menu` VALUES ('10', '9', '添加项目进度', null, '4', '/sys/schedule_add', null, '1', '1', '0', '0', null, '2018-02-09 10:59:05', '2018-02-09 10:59:05', null);
INSERT INTO `a_menu` VALUES ('11', '9', '修改项目进度', null, '4', '/sys/schedule_edit', null, '1', '1', '0', '0', null, '2018-02-09 10:59:24', '2018-02-09 10:59:24', null);
INSERT INTO `a_menu` VALUES ('12', '0', '项目流程', '<i class=\"menu-icon fa fa-space-shuttle bigger-120\"></i>', '4', '/sys/process', null, '1', '1', '1', '0', null, '2018-02-09 10:59:52', '2018-02-09 20:45:27', null);
INSERT INTO `a_menu` VALUES ('13', '12', '添加项目流程', null, '4', '/sys/process_add', null, '1', '1', '0', '0', null, '2018-02-09 11:00:29', '2018-02-09 11:00:29', null);
INSERT INTO `a_menu` VALUES ('14', '12', '修改项目流程', null, '4', '/sys/process_edit', null, '1', '1', '0', '0', null, '2018-02-09 11:00:43', '2018-02-09 11:00:43', null);
INSERT INTO `a_menu` VALUES ('15', '0', '控制类型', '<i class=\"menu-icon fa fa-sliders bigger-120\"></i>', '4', '/sys/ctrlcate', null, '1', '1', '1', '0', null, '2018-02-10 09:01:12', '2018-02-10 09:01:12', null);
INSERT INTO `a_menu` VALUES ('16', '15', '添加控制类型', null, '4', '/sys/ctrlcate_add', null, '1', '1', '0', '0', null, '2018-02-10 09:23:33', '2018-02-10 09:23:33', null);
INSERT INTO `a_menu` VALUES ('17', '15', '修改控制类型', null, '4', '/sys/ctrlcate_edit', null, '1', '1', '0', '0', null, '2018-02-10 09:24:08', '2018-02-10 09:24:08', null);
INSERT INTO `a_menu` VALUES ('18', '0', '附件分类数据表', '<i class=\"menu-icon fa fa-server bigger-120\"></i>', '4', '/sys/filetable', null, '1', '1', '1', '0', null, '2018-02-10 09:25:58', '2018-02-10 09:27:12', null);
INSERT INTO `a_menu` VALUES ('19', '18', '添加数据表', null, '4', '/sys/filetable_add', null, '1', '1', '0', '0', null, '2018-02-10 09:27:35', '2018-02-10 09:27:35', null);
INSERT INTO `a_menu` VALUES ('20', '18', '修改数据表', null, '4', '/sys/filetable_edit', null, '1', '1', '0', '0', null, '2018-02-10 09:28:18', '2018-02-10 09:28:18', null);
INSERT INTO `a_menu` VALUES ('21', '0', '项目资金进出类型', '<i class=\"menu-icon fa fa-rmb bigger-120\"></i>', '4', '/sys/fundscate', null, '1', '1', '1', '0', null, '2018-02-10 09:30:52', '2018-02-10 09:30:52', null);
INSERT INTO `a_menu` VALUES ('22', '21', '添加进出类型', null, '4', '/sys/fundscate_add', null, '1', '1', '0', '0', null, '2018-02-10 09:31:13', '2018-02-10 09:31:13', null);
INSERT INTO `a_menu` VALUES ('23', '21', '修改进出类型', null, '4', '/sys/fundscate_edit', null, '1', '1', '0', '0', null, '2018-02-10 09:31:35', '2018-02-10 09:31:35', null);
INSERT INTO `a_menu` VALUES ('24', '0', '通知公告分类', '<i class=\"menu-icon fa fa-newspaper-o bigger-120\"></i>', '4', '/sys/newscate', null, '1', '1', '1', '0', null, '2018-02-10 09:33:34', '2018-02-10 09:33:34', null);
INSERT INTO `a_menu` VALUES ('25', '24', '添加公告分类', null, '4', '/sys/newscate_add', null, '1', '1', '0', '0', null, '2018-02-10 09:34:04', '2018-02-10 09:34:04', null);
INSERT INTO `a_menu` VALUES ('26', '24', '修改公告分类', null, '4', '/sys/newscate_edit', null, '1', '1', '0', '0', null, '2018-02-10 09:34:26', '2018-02-10 09:34:26', null);
INSERT INTO `a_menu` VALUES ('27', '0', '项目内部通知分类', '<i class=\"menu-icon fa fa-rss-square bigger-120\"></i>', '4', '/sys/noticecate', null, '1', '1', '1', '0', null, '2018-02-10 09:36:13', '2018-02-10 09:36:13', null);
INSERT INTO `a_menu` VALUES ('28', '27', '添加通知分类', null, '4', '/sys/noticecate_add', null, '1', '1', '0', '0', null, '2018-02-10 09:36:50', '2018-02-10 09:36:50', null);
INSERT INTO `a_menu` VALUES ('29', '27', '修改通知分类', null, '4', '/sys/noticecate', null, '1', '1', '0', '0', null, '2018-02-10 09:37:09', '2018-02-10 09:37:09', null);
INSERT INTO `a_menu` VALUES ('30', '0', '项目状态代码', '<i class=\"menu-icon fa fa-code bigger-120\"></i>', '4', '/sys/statecode', null, '1', '1', '1', '0', null, '2018-02-10 09:37:55', '2018-02-10 09:37:55', null);
INSERT INTO `a_menu` VALUES ('31', '30', '添加状态代码', null, '4', '/sys/statecode_add', null, '1', '1', '0', '0', null, '2018-02-10 09:38:21', '2018-02-10 09:38:21', null);
INSERT INTO `a_menu` VALUES ('32', '30', '修改状态代码', null, '4', '/sys/statecode_edit', null, '1', '1', '0', '0', null, '2018-02-10 09:38:44', '2018-02-10 09:38:44', null);
INSERT INTO `a_menu` VALUES ('33', '0', '重要补偿科目', '<i class=\"menu-icon fa fa-object-group bigger-120\"></i>', '4', '/sys/subject', null, '1', '1', '1', '0', null, '2018-02-10 09:40:46', '2018-02-10 09:40:46', null);
INSERT INTO `a_menu` VALUES ('34', '33', '添加补偿科目', null, '4', '/sys/subject_add', null, '1', '1', '0', '0', null, '2018-02-10 09:41:25', '2018-02-10 09:41:25', null);
INSERT INTO `a_menu` VALUES ('35', '33', '修改补偿科目', null, '4', '/sys/subject_edit', null, '1', '1', '0', '0', null, '2018-02-10 09:41:44', '2018-02-10 09:41:44', null);
INSERT INTO `a_menu` VALUES ('36', '0', '入口', '<i class=\"menu-icon fa fa-telegram bigger-120\"></i>', '0', '/gov', null, '0', '0', '0', '0', null, '2018-02-10 11:42:38', '2018-02-10 16:39:05', null);
INSERT INTO `a_menu` VALUES ('37', '36', '登录', null, '0', '/gov/login', 'post', '0', '0', '0', '0', null, '2018-02-10 11:43:09', '2018-02-10 11:44:31', null);
INSERT INTO `a_menu` VALUES ('38', '36', '退出', null, '0', '/gov/logout', null, '0', '0', '0', '0', null, '2018-02-10 11:43:30', '2018-02-10 11:44:45', null);
INSERT INTO `a_menu` VALUES ('39', '0', '首页', '<i class=\"menu-icon fa fa-dashboard bigger-120\"></i>', '0', '/gov/home', null, '1', '0', '1', '0', null, '2018-02-10 11:44:08', '2018-02-11 14:16:09', null);
INSERT INTO `a_menu` VALUES ('40', '0', '项目', '<i class=\"menu-icon fa fa-th bigger-120\"></i>', '0', '/gov/item#', null, '1', '1', '1', '0', null, '2018-02-10 12:20:16', '2018-02-10 16:30:07', null);
INSERT INTO `a_menu` VALUES ('41', '40', '项目管理', null, '0', '/gov/item#', null, '1', '1', '1', '0', null, '2018-02-10 12:25:16', '2018-02-10 12:31:43', null);
INSERT INTO `a_menu` VALUES ('42', '41', '我的项目', '<i class=\"menu-icon fa fa-grav bigger-120\"></i>', '0', '/gov/item', null, '1', '1', '1', '0', null, '2018-02-10 12:25:59', '2018-02-10 17:41:25', null);
INSERT INTO `a_menu` VALUES ('43', '41', '所有项目', '<i class=\"menu-icon fa fa-cubes bigger-120\"></i>', '0', '/gov/item_all', null, '1', '1', '1', '0', null, '2018-02-10 12:26:44', '2018-02-10 17:42:25', null);
INSERT INTO `a_menu` VALUES ('44', '41', '新建项目', '<i class=\"menu-icon fa fa-puzzle-piece bigger-120\"></i>', '0', '/gov/item_add', null, '1', '1', '1', '0', null, '2018-02-10 12:27:28', '2018-02-10 17:43:17', null);
INSERT INTO `a_menu` VALUES ('45', '40', '项目配置', null, '0', '/gov/iteminfo#', null, '1', '1', '1', '0', null, '2018-02-10 12:29:22', '2018-02-10 12:32:04', null);
INSERT INTO `a_menu` VALUES ('46', '45', '项目概述', null, '0', '/gov/iteminfo', null, '1', '1', '1', '0', null, '2018-02-10 12:33:05', '2018-02-10 12:33:05', null);
INSERT INTO `a_menu` VALUES ('47', '45', '项目信息', null, '0', '/gov/iteminfo_info', null, '1', '1', '1', '0', null, '2018-02-10 12:33:47', '2018-02-10 12:33:47', null);
INSERT INTO `a_menu` VALUES ('48', '47', '修改项目资料', null, '0', '/gov/iteminfo_edit', null, '1', '1', '0', '0', null, '2018-02-10 12:34:45', '2018-02-10 12:34:45', null);
INSERT INTO `a_menu` VALUES ('49', '0', '房源', '<i class=\"menu-icon fa fa-home bigger-120\"></i>', '0', '/gov/house#', null, '1', '1', '1', '0', null, '2018-02-10 13:54:58', '2018-02-10 16:32:15', null);
INSERT INTO `a_menu` VALUES ('50', '0', '评估机构', '<i class=\"menu-icon fa fa-industry bigger-120\"></i>', '0', '/gov/company#', null, '1', '1', '1', '0', null, '2018-02-10 13:55:37', '2018-02-10 16:34:46', null);
INSERT INTO `a_menu` VALUES ('51', '0', '基础资料', '<i class=\"menu-icon fa fa-group bigger-120\"></i>', '0', '/gov/adminunit#', null, '1', '1', '1', '0', null, '2018-02-10 13:57:48', '2018-02-10 16:35:22', null);
INSERT INTO `a_menu` VALUES ('52', '0', '设置', '<i class=\"menu-icon fa fa-cogs bigger-120\"></i>', '0', '/gov/userself#', null, '1', '0', '1', '0', null, '2018-02-10 13:59:20', '2018-02-11 14:17:09', null);
INSERT INTO `a_menu` VALUES ('53', '0', '工作提醒', '<i class=\"menu-icon fa fa-comments bigger-120\"></i>', '0', '/gov/infos', null, '1', '0', '0', '0', null, '2018-02-10 14:01:05', '2018-02-10 16:41:23', null);
INSERT INTO `a_menu` VALUES ('54', '0', '常用工具', '<i class=\"menu-icon fa fa-wrench bigger-120\"></i>', '0', '#', null, '1', '0', '0', '0', null, '2018-02-10 14:02:43', '2018-02-10 16:37:58', null);
INSERT INTO `a_menu` VALUES ('55', '54', '文件上传', null, '0', '/gov/upl', null, '1', '0', '0', '0', null, '2018-02-10 14:03:37', '2018-02-10 14:03:37', null);
INSERT INTO `a_menu` VALUES ('56', '52', '组织与部门', null, '0', '/gov/dept', null, '1', '1', '1', '0', null, '2018-02-10 14:04:39', '2018-02-10 14:04:39', null);
INSERT INTO `a_menu` VALUES ('57', '56', '添加部门', null, '0', '/gov/dept_add', null, '1', '1', '0', '0', null, '2018-02-10 14:05:01', '2018-02-10 14:05:01', null);
INSERT INTO `a_menu` VALUES ('58', '56', '部门详情', null, '0', '/gov/dept_info', null, '1', '1', '0', '0', null, '2018-02-10 14:05:21', '2018-02-10 14:05:21', null);
INSERT INTO `a_menu` VALUES ('59', '56', '修改部门', null, '0', '/gov/dept_edit', null, '1', '1', '0', '0', null, '2018-02-10 14:05:44', '2018-02-10 14:05:44', null);
INSERT INTO `a_menu` VALUES ('60', '52', '权限与角色', null, '0', '/gov/role', null, '1', '1', '1', '0', null, '2018-02-10 14:06:19', '2018-02-10 14:06:19', null);
INSERT INTO `a_menu` VALUES ('61', '60', '添加角色', null, '0', '/gov/role_add', null, '1', '1', '0', '0', null, '2018-02-10 14:06:54', '2018-02-10 14:06:54', null);
INSERT INTO `a_menu` VALUES ('62', '60', '角色详情', null, '0', '/gov/role_info', null, '1', '1', '0', '0', null, '2018-02-10 14:07:14', '2018-02-10 14:07:14', null);
INSERT INTO `a_menu` VALUES ('63', '60', '修改角色', null, '0', '/gov/role_edit', null, '1', '1', '0', '0', null, '2018-02-10 14:07:33', '2018-02-10 14:07:33', null);
INSERT INTO `a_menu` VALUES ('64', '52', '人员管理', null, '0', '/gov/user', null, '1', '1', '1', '0', null, '2018-02-10 14:07:56', '2018-02-10 14:07:56', null);
INSERT INTO `a_menu` VALUES ('65', '64', '添加人员', null, '0', '/gov/user_add', null, '1', '1', '0', '0', null, '2018-02-10 14:08:12', '2018-02-10 14:08:12', null);
INSERT INTO `a_menu` VALUES ('66', '64', '人员详情', null, '0', '/gov/user_info', null, '1', '1', '0', '0', null, '2018-02-10 14:08:35', '2018-02-10 14:08:35', null);
INSERT INTO `a_menu` VALUES ('67', '64', '修改人员', null, '0', '/gov/user_edit', null, '1', '1', '0', '0', null, '2018-02-10 14:09:54', '2018-02-10 14:09:54', null);
INSERT INTO `a_menu` VALUES ('68', '64', '重置密码', null, '0', '/gov/user_resetpwd', null, '1', '1', '0', '0', null, '2018-02-10 14:10:51', '2018-02-10 14:10:51', null);
INSERT INTO `a_menu` VALUES ('69', '52', '个人中心', null, '0', '/gov/userself', null, '1', '0', '1', '0', null, '2018-02-10 14:12:38', '2018-02-10 14:12:38', null);
INSERT INTO `a_menu` VALUES ('70', '69', '修改个人资料', null, '0', '/gov/userself_edit', null, '1', '0', '0', '0', null, '2018-02-10 14:13:19', '2018-02-10 14:13:55', null);
INSERT INTO `a_menu` VALUES ('71', '69', '修改密码', null, '0', '/gov/userself_pwd', null, '1', '0', '0', '0', null, '2018-02-10 14:14:26', '2018-02-10 14:14:26', null);
INSERT INTO `a_menu` VALUES ('72', '51', '公产单位', null, '0', '/gov/adminunit', null, '1', '1', '1', '0', null, '2018-02-11 13:30:34', '2018-02-11 13:30:34', null);
INSERT INTO `a_menu` VALUES ('73', '72', '添加公产单位', null, '0', '/gov/adminunit_add', null, '1', '1', '0', '0', null, '2018-02-11 13:31:16', '2018-02-11 13:31:16', null);
INSERT INTO `a_menu` VALUES ('74', '72', '公产单位详情', null, '0', '/gov/adminunit_info', null, '1', '1', '0', '0', null, '2018-02-11 13:31:43', '2018-02-11 13:31:43', null);
INSERT INTO `a_menu` VALUES ('75', '72', '修改公产单位', null, '0', '/gov/adminunit_edit', null, '1', '1', '0', '0', null, '2018-02-11 13:32:12', '2018-02-11 13:32:12', null);
INSERT INTO `a_menu` VALUES ('76', '51', '银行列表', null, '0', '/gov/bank', null, '1', '1', '1', '0', null, '2018-02-11 13:32:36', '2018-02-11 13:32:36', null);
INSERT INTO `a_menu` VALUES ('77', '76', '添加银行', null, '0', '/gov/bank_add', null, '1', '1', '0', '0', null, '2018-02-11 13:32:55', '2018-02-11 13:32:55', null);
INSERT INTO `a_menu` VALUES ('78', '76', '银行详情', null, '0', '/gov/bank_info', null, '1', '1', '0', '0', null, '2018-02-11 13:33:26', '2018-02-11 13:33:26', null);
INSERT INTO `a_menu` VALUES ('79', '76', '修改银行', null, '0', '/gov/bank_edit', null, '1', '1', '0', '0', null, '2018-02-11 13:34:05', '2018-02-11 13:34:05', null);
INSERT INTO `a_menu` VALUES ('80', '54', '错误提示', null, '0', '/gov/error', null, '1', '0', '0', '0', null, '2018-02-11 14:53:02', '2018-02-11 14:53:02', null);
INSERT INTO `a_menu` VALUES ('81', '51', '建筑结构类型', null, '0', '/gov/buildingstruct', null, '1', '1', '1', '0', null, '2018-02-22 09:38:38', '2018-02-22 09:38:38', null);
INSERT INTO `a_menu` VALUES ('82', '81', '添加建筑结构类型', null, '0', '/gov/buildingstruct_add', null, '1', '1', '0', '0', null, '2018-02-22 09:39:50', '2018-02-22 09:40:33', null);
INSERT INTO `a_menu` VALUES ('83', '81', '建筑结构类型详情', null, '0', '/gov/buildingstruct_info', null, '1', '1', '0', '0', null, '2018-02-22 09:41:28', '2018-02-22 09:42:32', null);
INSERT INTO `a_menu` VALUES ('84', '81', '修改建筑结构类型', null, '0', '/gov/buildingstruct_edit', null, '1', '1', '0', '0', null, '2018-02-22 09:43:27', '2018-02-22 09:43:27', null);
INSERT INTO `a_menu` VALUES ('85', '51', '建筑用途', null, '0', '/gov/buildinguse', null, '1', '1', '1', '0', null, '2018-02-22 09:44:53', '2018-02-22 09:44:53', null);
INSERT INTO `a_menu` VALUES ('86', '85', '添加建筑用途', null, '0', '/gov/buildinguse_add', null, '1', '1', '0', '0', null, '2018-02-22 09:45:44', '2018-02-22 09:45:44', null);
INSERT INTO `a_menu` VALUES ('87', '85', '建筑用途详情', null, '0', '/gov/buildinguse_info', null, '1', '1', '0', '0', null, '2018-02-22 09:48:41', '2018-02-22 09:48:41', null);
INSERT INTO `a_menu` VALUES ('88', '85', '修改建筑用途', null, '0', '/gov/buildinguse_edit', null, '1', '1', '0', '0', null, '2018-02-22 09:51:07', '2018-02-22 09:51:07', null);
INSERT INTO `a_menu` VALUES ('89', '50', '评估机构', null, '0', '/gov/company', null, '1', '1', '1', '0', null, '2018-02-22 09:56:00', '2018-02-22 09:56:00', null);
INSERT INTO `a_menu` VALUES ('90', '89', '添加评估机构', null, '0', '/gov/company_add', null, '1', '1', '0', '0', null, '2018-02-22 09:59:24', '2018-02-22 10:00:26', null);
INSERT INTO `a_menu` VALUES ('91', '89', '评估机构详情', null, '0', '/gov/company_info', null, '1', '1', '0', '0', null, '2018-02-22 10:03:45', '2018-02-22 10:03:45', null);
INSERT INTO `a_menu` VALUES ('92', '89', '修改评估机构', null, '0', '/gov/company_edit', null, '1', '1', '0', '0', null, '2018-02-22 10:06:11', '2018-02-22 10:06:11', null);
INSERT INTO `a_menu` VALUES ('93', '50', '评估机构(操作员)', null, '0', '/gov/companyuser', null, '1', '1', '1', '0', null, '2018-02-22 10:12:04', '2018-02-22 10:12:04', null);
INSERT INTO `a_menu` VALUES ('94', '93', '添加操作员', null, '0', '/gov/companyuser_add', null, '1', '1', '0', '0', null, '2018-02-22 10:13:02', '2018-02-22 10:13:02', null);
INSERT INTO `a_menu` VALUES ('95', '93', '操作员详情', null, '0', '/gov/companyuser_info', null, '1', '1', '0', '0', null, '2018-02-22 10:13:52', '2018-02-22 10:13:52', null);
INSERT INTO `a_menu` VALUES ('96', '93', '修改操作员', null, '0', '/gov/companyuser_edit', null, '1', '1', '0', '0', null, '2018-02-22 10:14:31', '2018-02-22 10:14:31', null);
INSERT INTO `a_menu` VALUES ('97', '50', '评估机构(评估师)', null, '0', '/gov/companyvaluer', null, '1', '1', '1', '0', null, '2018-02-22 10:15:40', '2018-02-22 10:15:40', null);
INSERT INTO `a_menu` VALUES ('98', '97', '添加评估师', null, '0', '/gov/companyvaluer_add', null, '1', '1', '0', '0', null, '2018-02-22 10:16:18', '2018-02-22 10:16:18', null);
INSERT INTO `a_menu` VALUES ('99', '97', '评估师详情', null, '0', '/gov/companyvaluer_info', null, '1', '1', '0', '0', null, '2018-02-22 10:17:20', '2018-02-22 10:17:20', null);
INSERT INTO `a_menu` VALUES ('100', '97', '修改评估师', null, '0', '/gov/companyvaluer_edit', null, '1', '1', '0', '0', null, '2018-02-22 10:18:26', '2018-02-22 10:18:26', null);
INSERT INTO `a_menu` VALUES ('101', '51', '特殊人群', null, '0', '/gov/crowd', null, '1', '1', '1', '0', null, '2018-02-22 10:20:07', '2018-02-22 10:20:07', null);
INSERT INTO `a_menu` VALUES ('102', '101', '添加特殊人群', null, '0', '/gov/crowd_add', null, '1', '1', '0', '0', null, '2018-02-22 10:21:19', '2018-02-22 10:21:19', null);
INSERT INTO `a_menu` VALUES ('103', '101', '特殊人群详情', null, '0', '/gov/crowd_info', null, '1', '1', '0', '0', null, '2018-02-22 10:22:08', '2018-02-22 10:22:08', null);
INSERT INTO `a_menu` VALUES ('104', '101', '修改特殊人群', null, '0', '/gov/crowd_edit', null, '1', '1', '0', '0', null, '2018-02-22 10:22:54', '2018-02-22 10:22:54', null);
INSERT INTO `a_menu` VALUES ('105', '51', '必备附件分类', null, '0', '/gov/filecate', null, '1', '1', '1', '0', null, '2018-02-22 10:27:30', '2018-02-22 10:27:30', null);
INSERT INTO `a_menu` VALUES ('106', '105', '必备附件分类详情', null, '0', '/gov/filecate_info', null, '1', '1', '0', '0', null, '2018-02-22 10:30:29', '2018-02-22 10:30:29', null);
INSERT INTO `a_menu` VALUES ('107', '51', '房屋户型', null, '0', '/gov/layout', null, '1', '1', '1', '0', null, '2018-02-22 10:31:47', '2018-02-22 10:31:47', null);
INSERT INTO `a_menu` VALUES ('108', '107', '添加房屋户型', null, '0', '/gov/layout_add', null, '1', '1', '0', '0', null, '2018-02-22 10:32:49', '2018-02-22 10:32:49', null);
INSERT INTO `a_menu` VALUES ('109', '107', '房屋户型详情', null, '0', '/gov/layout_info', null, '1', '1', '0', '0', null, '2018-02-22 10:33:37', '2018-02-22 10:33:37', null);
INSERT INTO `a_menu` VALUES ('110', '107', '修改房屋户型', null, '0', '/gov/layout_edit', null, '1', '1', '0', '0', null, '2018-02-22 10:35:04', '2018-02-22 10:35:04', null);
INSERT INTO `a_menu` VALUES ('111', '51', '民族', null, '0', '/gov/nation', null, '1', '1', '1', '0', null, '2018-02-22 10:36:56', '2018-02-22 10:36:56', null);
INSERT INTO `a_menu` VALUES ('112', '111', '添加民族', null, '0', '/gov/nation_add', null, '1', '1', '0', '0', null, '2018-02-22 10:37:50', '2018-02-22 10:37:50', null);
INSERT INTO `a_menu` VALUES ('113', '111', '民族详情', null, '0', '/gov/nation_info', null, '1', '1', '0', '0', null, '2018-02-22 10:38:43', '2018-02-22 10:39:36', null);
INSERT INTO `a_menu` VALUES ('114', '111', '修改民族', null, '0', '/gov/nation_edit', null, '1', '1', '0', '0', null, '2018-02-22 10:39:21', '2018-02-22 10:39:21', null);
INSERT INTO `a_menu` VALUES ('115', '51', '其他补偿事项', null, '0', '/gov/object', null, '1', '1', '1', '0', null, '2018-02-22 10:41:40', '2018-02-22 10:41:40', null);
INSERT INTO `a_menu` VALUES ('116', '115', '添加其他补偿事项', null, '0', '/gov/object_add', null, '1', '1', '0', '0', null, '2018-02-22 10:45:54', '2018-02-22 10:45:54', null);
INSERT INTO `a_menu` VALUES ('117', '115', '其他补偿事项详情', null, '0', '/gov/object_info', null, '1', '1', '0', '0', null, '2018-02-22 10:48:04', '2018-02-22 10:48:04', null);
INSERT INTO `a_menu` VALUES ('118', '115', '修改其他补偿事项', null, '0', '/gov/object_edit', null, '1', '1', '0', '0', null, '2018-02-22 10:48:46', '2018-02-22 10:48:46', null);
INSERT INTO `a_menu` VALUES ('119', '51', '社会风险评估调查话题', null, '0', '/gov/topic', null, '1', '1', '1', '0', null, '2018-02-22 10:50:28', '2018-02-22 10:50:28', null);
INSERT INTO `a_menu` VALUES ('120', '119', '添加调查话题', null, '0', '/gov/topic_add', null, '1', '1', '0', '0', null, '2018-02-22 10:51:06', '2018-02-22 10:51:06', null);
INSERT INTO `a_menu` VALUES ('121', '119', '调查话题详情', null, '0', '/gov/topic_info', null, '1', '1', '0', '0', null, '2018-02-22 10:52:02', '2018-02-22 10:52:38', null);
INSERT INTO `a_menu` VALUES ('122', '119', '修改调查话题', null, '0', '/gov/topic_edit', null, '1', '1', '0', '0', null, '2018-02-22 10:53:30', '2018-02-22 10:53:30', null);
INSERT INTO `a_menu` VALUES ('123', '49', '房源管理机构', null, '0', '/gov/housecompany', null, '1', '1', '1', '0', null, '2018-02-22 10:54:57', '2018-02-22 10:54:57', null);
INSERT INTO `a_menu` VALUES ('124', '123', '添加房源管理机构', null, '0', '/gov/housecompany_add', null, '1', '1', '0', '0', null, '2018-02-22 10:55:39', '2018-02-22 10:55:39', null);
INSERT INTO `a_menu` VALUES ('125', '123', '房源管理机构详情', null, '0', '/gov/housecompany_info', null, '1', '1', '0', '0', null, '2018-02-22 10:56:29', '2018-02-22 10:56:29', null);
INSERT INTO `a_menu` VALUES ('126', '123', '修改房源管理机构', null, '0', '/gov/housecompany_edit', null, '1', '1', '0', '0', null, '2018-02-22 10:57:23', '2018-02-22 10:57:39', null);
INSERT INTO `a_menu` VALUES ('127', '49', '房源社区', null, '0', '/gov/housecommunity', null, '1', '1', '1', '0', null, '2018-02-22 11:02:32', '2018-02-22 11:02:32', null);
INSERT INTO `a_menu` VALUES ('128', '127', '添加房源社区', null, '0', '/gov/housecommunity_add', null, '1', '1', '0', '0', null, '2018-02-22 11:04:02', '2018-02-22 11:04:02', null);
INSERT INTO `a_menu` VALUES ('129', '127', '房源社区详情', null, '0', '/gov/housecommunity_info', null, '1', '1', '0', '0', null, '2018-02-22 11:06:07', '2018-02-22 11:06:07', null);
INSERT INTO `a_menu` VALUES ('130', '127', '修改房源社区', null, '0', '/gov/housecommunity_edit', null, '1', '1', '0', '0', null, '2018-02-22 11:06:56', '2018-02-22 11:06:56', null);
INSERT INTO `a_menu` VALUES ('131', '49', '房源户型图', null, '0', '/gov/houselayoutimg', null, '1', '1', '1', '0', null, '2018-02-22 11:09:29', '2018-02-22 11:09:29', null);
INSERT INTO `a_menu` VALUES ('132', '131', '添加房源户型图', null, '0', '/gov/houselayoutimg_add', null, '1', '1', '0', '0', null, '2018-02-22 11:10:52', '2018-02-22 11:10:52', null);
INSERT INTO `a_menu` VALUES ('133', '131', '房源户型图详情', null, '0', '/gov/houselayoutimg_info', null, '1', '1', '0', '0', null, '2018-02-22 11:12:10', '2018-02-22 11:12:10', null);
INSERT INTO `a_menu` VALUES ('134', '131', '修改房源户型图', null, '0', '/gov/houselayoutimg_edit', null, '1', '1', '0', '0', null, '2018-02-22 11:13:08', '2018-02-22 11:13:08', null);
INSERT INTO `a_menu` VALUES ('135', '49', '房源', null, '0', '/gov/house', null, '1', '1', '1', '0', null, '2018-02-22 11:14:18', '2018-02-22 11:14:18', null);
INSERT INTO `a_menu` VALUES ('136', '135', '添加房源', null, '0', '/gov/house_add', null, '1', '1', '0', '0', null, '2018-02-22 11:15:34', '2018-02-22 11:15:34', null);
INSERT INTO `a_menu` VALUES ('137', '135', '房源详情', null, '0', '/gov/house_info', null, '1', '1', '0', '0', null, '2018-02-22 11:16:38', '2018-02-22 11:17:06', null);
INSERT INTO `a_menu` VALUES ('138', '135', '修改房源', null, '0', '/gov/house_edit', null, '1', '1', '0', '0', null, '2018-02-22 11:18:05', '2018-02-22 11:18:05', null);
INSERT INTO `a_menu` VALUES ('139', '135', '房源评估单价', null, '0', '/gov/houseprice', null, '1', '1', '0', '0', null, '2018-02-22 11:25:10', '2018-02-22 11:50:19', null);
INSERT INTO `a_menu` VALUES ('140', '139', '添加房源评估单价', null, '0', '/gov/houseprice_add', null, '1', '1', '0', '0', null, '2018-02-22 11:26:07', '2018-02-22 11:26:07', null);
INSERT INTO `a_menu` VALUES ('141', '139', '房源评估单价详情', null, '0', '/gov/houseprice_info', null, '1', '1', '0', '0', null, '2018-02-22 11:26:50', '2018-02-22 11:26:50', null);
INSERT INTO `a_menu` VALUES ('142', '139', '修改房源评估单价', null, '0', '/gov/houseprice_edit', null, '1', '1', '0', '0', null, '2018-02-22 11:28:04', '2018-02-22 11:28:04', null);
INSERT INTO `a_menu` VALUES ('143', '135', '购置管理费单价', null, '0', '/gov/housemanageprice', null, '1', '1', '0', '0', null, '2018-02-22 11:29:39', '2018-02-22 11:50:34', null);
INSERT INTO `a_menu` VALUES ('144', '143', '添加购置管理费单价', null, '0', '/gov/housemanageprice_add', null, '1', '1', '0', '0', null, '2018-02-22 11:30:31', '2018-02-22 11:30:31', null);
INSERT INTO `a_menu` VALUES ('145', '143', '购置管理费单价详情', null, '0', '/gov/housemanageprice_info', null, '1', '1', '0', '0', null, '2018-02-22 11:32:06', '2018-02-22 11:32:06', null);
INSERT INTO `a_menu` VALUES ('146', '143', '修改购置管理费单价', null, '0', '/gov/housemanageprice_edit', null, '1', '1', '0', '0', null, '2018-02-22 11:32:51', '2018-02-22 11:32:51', null);
INSERT INTO `a_menu` VALUES ('147', '51', '土地性质', null, '0', '/gov/landprop', null, '1', '1', '1', '0', null, '2018-02-22 11:35:00', '2018-02-22 11:35:00', null);
INSERT INTO `a_menu` VALUES ('148', '147', '添加土地性质', null, '0', '/gov/landprop_add', null, '1', '1', '0', '0', null, '2018-02-22 11:35:55', '2018-02-22 11:35:55', null);
INSERT INTO `a_menu` VALUES ('149', '147', '土地性质详情', null, '0', '/gov/landprop_info', null, '1', '1', '0', '0', null, '2018-02-22 11:37:27', '2018-02-22 11:37:27', null);
INSERT INTO `a_menu` VALUES ('150', '147', '修改土地性质', null, '0', '/gov/landprop_edit', null, '1', '1', '0', '0', null, '2018-02-22 11:38:13', '2018-02-22 11:38:13', null);
INSERT INTO `a_menu` VALUES ('151', '147', '土地来源', null, '0', '/gov/landsource', null, '1', '1', '0', '0', null, '2018-02-22 11:39:35', '2018-02-22 14:58:28', null);
INSERT INTO `a_menu` VALUES ('152', '151', '添加土地来源', null, '0', '/gov/landsource_add', null, '1', '1', '0', '0', null, '2018-02-22 11:40:53', '2018-02-22 11:40:53', null);
INSERT INTO `a_menu` VALUES ('153', '151', '土地来源详情', null, '0', '/gov/landsource_info', null, '1', '1', '0', '0', null, '2018-02-22 11:41:55', '2018-02-22 11:41:55', null);
INSERT INTO `a_menu` VALUES ('154', '151', '修改土地来源', null, '0', '/gov/landsource_edit', null, '1', '1', '0', '0', null, '2018-02-22 11:43:39', '2018-02-22 11:43:39', null);
INSERT INTO `a_menu` VALUES ('155', '151', '土地权益状况', null, '0', '/gov/landstate', null, '1', '1', '1', '0', null, '2018-02-22 11:44:49', '2018-02-22 11:44:49', null);
INSERT INTO `a_menu` VALUES ('156', '155', '添加土地权益状况', null, '0', '/gov/landstate_add', null, '1', '1', '0', '0', null, '2018-02-22 11:46:17', '2018-02-22 11:46:17', null);
INSERT INTO `a_menu` VALUES ('157', '155', '土地权益状况详情', null, '0', '/gov/landstate_info', null, '1', '1', '0', '0', null, '2018-02-22 11:48:33', '2018-02-22 11:48:33', null);
INSERT INTO `a_menu` VALUES ('158', '155', '修改土地权益状况', null, '0', '/gov/landstate_edit', null, '1', '1', '0', '0', null, '2018-02-22 11:49:39', '2018-02-22 11:49:39', null);
INSERT INTO `a_menu` VALUES ('159', '40', '调查建档', null, '0', '/gov/itemland#', null, '1', '1', '1', '0', null, '2018-02-22 13:41:45', '2018-02-22 15:09:40', null);
INSERT INTO `a_menu` VALUES ('160', '159', '项目地块', null, '0', '/gov/itemland', null, '1', '1', '1', '0', null, '2018-02-22 13:43:51', '2018-02-22 13:43:51', null);
INSERT INTO `a_menu` VALUES ('161', '160', '添加项目地块', null, '0', '/gov/itemland_add', null, '1', '1', '0', '0', null, '2018-02-22 13:44:53', '2018-02-22 13:44:53', null);
INSERT INTO `a_menu` VALUES ('162', '160', '项目地块详情', null, '0', '/gov/itemland_info', null, '1', '1', '0', '0', null, '2018-02-22 13:46:17', '2018-02-22 13:46:17', null);
INSERT INTO `a_menu` VALUES ('163', '160', '修改项目地块', null, '0', '/gov/itemland_edit', null, '1', '1', '0', '0', null, '2018-02-22 13:47:07', '2018-02-22 13:47:07', null);
INSERT INTO `a_menu` VALUES ('164', '160', '地块楼栋', null, '0', '/gov/itembuilding', null, '1', '1', '1', '0', null, '2018-02-22 13:48:08', '2018-02-22 13:48:08', null);
INSERT INTO `a_menu` VALUES ('165', '164', '添加地块楼栋', null, '0', '/gov/itembuilding_add', null, '1', '1', '0', '0', null, '2018-02-22 13:49:47', '2018-02-22 13:49:47', null);
INSERT INTO `a_menu` VALUES ('166', '164', '地块楼栋详情', null, '0', '/gov/itembuilding_info', null, '1', '1', '0', '0', null, '2018-02-22 13:50:40', '2018-02-22 13:50:40', null);
INSERT INTO `a_menu` VALUES ('167', '164', '修改地块楼栋', null, '0', '/gov/itembuilding_edit', null, '1', '1', '0', '0', null, '2018-02-22 13:51:42', '2018-02-22 13:51:42', null);
INSERT INTO `a_menu` VALUES ('168', '160', '公共附属物', null, '0', '/gov/itempublic', null, '1', '1', '1', '0', null, '2018-02-22 13:53:25', '2018-02-22 13:53:25', null);
INSERT INTO `a_menu` VALUES ('169', '168', '添加公共附属物', null, '0', '/gov/itempublic_add', null, '1', '1', '0', '0', null, '2018-02-22 13:55:53', '2018-02-22 13:55:53', null);
INSERT INTO `a_menu` VALUES ('170', '168', '公共附属物详情', null, '0', '/gov/itempublic_info', null, '1', '1', '0', '0', null, '2018-02-22 14:00:59', '2018-02-22 14:00:59', null);
INSERT INTO `a_menu` VALUES ('171', '168', '修改公共附属物', null, '0', '/gov/itempublic_edit', null, '1', '1', '0', '0', null, '2018-02-22 14:02:04', '2018-02-22 14:02:04', null);
INSERT INTO `a_menu` VALUES ('172', '40', '征收决定', null, '0', '/gov/itemprogram_info#', null, '1', '1', '1', '0', null, '2018-02-22 14:04:50', '2018-02-22 15:12:05', null);
INSERT INTO `a_menu` VALUES ('173', '172', '社会风险评估', null, '0', '/gov/itemtopic#', null, '1', '1', '1', '0', null, '2018-02-22 14:06:05', '2018-02-22 15:10:15', null);
INSERT INTO `a_menu` VALUES ('174', '173', '自选社会风险评估调查话题', null, '0', '/gov/itemtopic', null, '1', '1', '1', '0', null, '2018-02-22 14:06:35', '2018-02-22 14:06:35', null);
INSERT INTO `a_menu` VALUES ('175', '174', '添加自选社会风险评估调查话题', null, '0', '/gov/itemtopic_add', null, '1', '1', '0', '0', null, '2018-02-22 14:07:55', '2018-02-22 14:07:55', null);
INSERT INTO `a_menu` VALUES ('176', '174', '自选社会风险评估调查话题详情', null, '0', '/gov/itemtopic_info', null, '1', '1', '0', '0', null, '2018-02-22 14:08:46', '2018-02-22 14:08:46', null);
INSERT INTO `a_menu` VALUES ('177', '174', '修改自选社会风险评估调查话题', null, '0', '/gov/itemtopic_edit', null, '1', '1', '0', '0', null, '2018-02-22 14:10:01', '2018-02-22 14:10:01', null);
INSERT INTO `a_menu` VALUES ('178', '159', '其他补偿事项单价', null, '0', '/gov/itemobject', null, '1', '1', '1', '0', null, '2018-02-22 14:13:20', '2018-02-22 14:13:20', null);
INSERT INTO `a_menu` VALUES ('179', '178', '添加其他补偿事项单价', null, '0', '/gov/itemobject_add', null, '1', '1', '0', '0', null, '2018-02-22 14:14:44', '2018-02-22 14:14:44', null);
INSERT INTO `a_menu` VALUES ('180', '178', '其他补偿事项单价详情', null, '0', '/gov/itemobject_info', null, '1', '1', '0', '0', null, '2018-02-22 14:15:31', '2018-02-22 14:15:31', null);
INSERT INTO `a_menu` VALUES ('181', '178', '修改其他补偿事项单价', null, '0', '/gov/itemobject_edit', null, '1', '1', '0', '0', null, '2018-02-22 14:16:31', '2018-02-22 14:16:31', null);
INSERT INTO `a_menu` VALUES ('182', '159', '补偿科目说明', null, '0', '/gov/itemsubject', null, '1', '1', '1', '0', null, '2018-02-22 14:18:08', '2018-02-22 14:18:08', null);
INSERT INTO `a_menu` VALUES ('183', '182', '添加补偿科目说明', null, '0', '/gov/itemsubject_add', null, '1', '1', '0', '0', null, '2018-02-22 14:18:58', '2018-02-22 14:18:58', null);
INSERT INTO `a_menu` VALUES ('184', '182', '补偿科目说明详情', null, '0', '/gov/itemsubject_info', null, '1', '1', '0', '0', null, '2018-02-22 14:20:15', '2018-02-22 14:20:15', null);
INSERT INTO `a_menu` VALUES ('185', '182', '修改补偿科目说明', null, '0', '/gov/itemsubject_edit', null, '1', '1', '0', '0', null, '2018-02-22 14:21:39', '2018-02-22 14:21:39', null);
INSERT INTO `a_menu` VALUES ('186', '40', '通知公告', null, '0', '/gov/itemnotice#', null, '1', '1', '1', '0', null, '2018-02-22 14:24:46', '2018-02-22 14:24:46', null);
INSERT INTO `a_menu` VALUES ('187', '186', '内部通知', null, '0', '/gov/itemnotice', null, '1', '1', '1', '0', null, '2018-02-22 14:26:35', '2018-02-22 14:26:35', null);
INSERT INTO `a_menu` VALUES ('188', '187', '添加内部通知', null, '0', '/gov/itemnotice_add', null, '1', '1', '0', '0', null, '2018-02-22 14:27:37', '2018-02-22 14:27:37', null);
INSERT INTO `a_menu` VALUES ('189', '187', '内部通知详情', null, '0', '/gov/itemnotice_info', null, '1', '1', '0', '0', null, '2018-02-22 14:29:02', '2018-02-22 14:29:02', null);
INSERT INTO `a_menu` VALUES ('190', '187', '修改内部通知', null, '0', '/gov/itemnotice_edit', null, '1', '1', '0', '0', null, '2018-02-22 14:29:56', '2018-02-22 14:29:56', null);
INSERT INTO `a_menu` VALUES ('191', '172', '添加征收方案', null, '0', '/gov/itemprogram_add', null, '1', '1', '0', '0', null, '2018-02-22 14:33:24', '2018-02-22 14:33:24', null);
INSERT INTO `a_menu` VALUES ('192', '172', '征收方案详情', null, '0', '/gov/itemprogram_info', null, '1', '1', '0', '0', null, '2018-02-22 14:34:52', '2018-02-22 14:34:52', null);
INSERT INTO `a_menu` VALUES ('193', '172', '修改征收方案', null, '0', '/gov/itemprogram_edit', null, '1', '1', '0', '0', null, '2018-02-22 14:35:55', '2018-02-22 14:35:55', null);
INSERT INTO `a_menu` VALUES ('194', '45', '时间规划', null, '0', '/gov/itemtime', null, '1', '1', '1', '0', null, '2018-02-22 15:58:09', '2018-02-22 15:58:09', null);
INSERT INTO `a_menu` VALUES ('195', '194', '修改时间规划', null, '0', '/gov/itemtime_edit', null, '1', '1', '0', '0', null, '2018-02-22 16:01:35', '2018-02-22 16:01:35', null);
INSERT INTO `a_menu` VALUES ('196', '45', '项目人员', null, '0', '/gov/itemuser', null, '1', '1', '1', '0', null, '2018-02-22 16:19:25', '2018-02-22 16:20:15', null);
INSERT INTO `a_menu` VALUES ('197', '196', '添加项目人员', null, '0', '/gov/itemuser_add', null, '1', '1', '0', '0', null, '2018-02-22 16:21:26', '2018-02-22 16:21:26', null);
INSERT INTO `a_menu` VALUES ('198', '196', '调整项目人员', null, '0', '/gov/itemuser_edit', null, '1', '1', '0', '0', null, '2018-02-22 16:43:17', '2018-02-22 16:43:17', null);
INSERT INTO `a_menu` VALUES ('199', '196', '删除项目人员', null, '0', '/gov/itemuser_del', null, '1', '1', '0', '0', null, '2018-02-22 16:43:46', '2018-02-22 16:43:46', null);
INSERT INTO `a_menu` VALUES ('200', '196', '项目负责人', null, '0', '/gov/itemadmin', null, '1', '1', '0', '0', null, '2018-02-22 16:45:07', '2018-02-22 16:45:07', null);
INSERT INTO `a_menu` VALUES ('201', '200', '添加项目负责人', null, '0', '/gov/itemadmin_add', null, '1', '1', '0', '0', null, '2018-02-22 16:46:42', '2018-02-22 16:46:42', null);
INSERT INTO `a_menu` VALUES ('202', '200', '删除项目负责人', null, '0', '/gov/itemadmin_del', null, '1', '1', '0', '0', null, '2018-02-22 16:47:11', '2018-02-22 16:47:11', null);
INSERT INTO `a_menu` VALUES ('203', '211', '被征收户', null, '0', '/gov/householddetail', null, '1', '1', '1', '0', null, '2018-02-22 17:37:38', '2018-02-26 09:13:58', null);
INSERT INTO `a_menu` VALUES ('204', '212', '添加被征收户账号', null, '0', '/gov/household_add', null, '1', '1', '0', '0', null, '2018-02-22 17:38:43', '2018-02-22 17:38:43', null);
INSERT INTO `a_menu` VALUES ('205', '212', '被征收户账号详情', null, '0', '/gov/household_info', null, '1', '1', '0', '0', null, '2018-02-22 17:40:05', '2018-02-22 17:40:05', null);
INSERT INTO `a_menu` VALUES ('206', '212', '修改被征收户账号', null, '0', '/gov/household_edit', null, '1', '1', '0', '0', null, '2018-02-22 17:42:54', '2018-02-22 17:42:54', null);
INSERT INTO `a_menu` VALUES ('207', '45', '进度与流程', null, '0', '/gov/itemprocess', null, '1', '1', '1', '0', null, '2018-02-23 10:47:58', '2018-02-23 11:55:14', null);
INSERT INTO `a_menu` VALUES ('208', '203', '添加被征收户', null, '0', '/gov/householddetail_add', null, '1', '1', '0', '0', null, '2018-02-23 11:28:53', '2018-02-23 11:28:53', null);
INSERT INTO `a_menu` VALUES ('209', '207', '提交部门审查（项目审查）', null, '0', '/gov/itemprocess_c2dc', null, '1', '1', '0', '0', null, '2018-02-23 11:58:55', '2018-02-23 11:58:55', null);
INSERT INTO `a_menu` VALUES ('210', '203', '修改被征收户', null, '0', '/gov/householddetail_edit', null, '1', '1', '0', '0', null, '2018-02-23 18:18:16', '2018-02-23 18:18:16', null);
INSERT INTO `a_menu` VALUES ('211', '159', '入户摸底', null, '0', '/gov/householddetail', null, '1', '1', '1', '0', null, '2018-02-24 09:01:14', '2018-02-26 09:48:08', null);
INSERT INTO `a_menu` VALUES ('212', '159', '被征户账号', null, '0', '/gov/household', null, '1', '1', '1', '0', null, '2018-02-24 09:16:21', '2018-02-24 09:16:21', null);
INSERT INTO `a_menu` VALUES ('214', '203', '家庭成员', null, '0', '/gov/householdmember', null, '1', '1', '1', '0', null, '2018-02-24 10:18:31', '2018-02-24 10:18:31', null);
INSERT INTO `a_menu` VALUES ('215', '214', '添加家庭成员', null, '0', '/gov/householdmember_add', null, '1', '1', '0', '0', null, '2018-02-24 10:26:47', '2018-02-24 10:26:47', null);
INSERT INTO `a_menu` VALUES ('216', '214', '家庭成员详情', null, '0', '/gov/householdmember_info', null, '1', '1', '0', '0', null, '2018-02-24 10:27:24', '2018-02-24 10:27:24', null);
INSERT INTO `a_menu` VALUES ('217', '216', '修改家庭成员', null, '0', '/gov/householdmember_edit', null, '1', '1', '0', '0', null, '2018-02-24 10:28:21', '2018-02-24 10:28:21', null);
INSERT INTO `a_menu` VALUES ('218', '207', '部门审查（项目审查）', null, '0', '/gov/itemprocess_cdc', null, '1', '1', '0', '0', null, '2018-02-24 11:39:45', '2018-02-24 11:39:45', null);
INSERT INTO `a_menu` VALUES ('219', '216', '添加特殊人群', null, '0', '/gov/householdmembercrowd_add', null, '1', '1', '0', '0', null, '2018-02-24 16:23:19', '2018-02-24 16:23:19', null);
INSERT INTO `a_menu` VALUES ('220', '216', '特殊人群信息', null, '0', '/gov/householdmembercrowd_info', null, '1', '1', '0', '0', null, '2018-02-24 16:32:59', '2018-02-24 16:34:59', null);
INSERT INTO `a_menu` VALUES ('221', '220', '修改特殊人群', null, '0', '/gov/householdmembercrowd_edit', null, '1', '1', '0', '0', null, '2018-02-24 16:34:17', '2018-02-24 16:34:17', null);
INSERT INTO `a_menu` VALUES ('222', '207', '审查驳回处理（项目审查）', null, '0', '/gov/itemprocess_crb', null, '1', '1', '0', '0', null, '2018-02-24 18:17:24', '2018-02-24 18:18:20', null);
INSERT INTO `a_menu` VALUES ('223', '207', '重新提交审查资料（项目审查）', null, '0', '/gov/itemprocess_retry', null, '1', '1', '0', '0', null, '2018-02-24 18:17:55', '2018-02-24 18:18:33', null);
INSERT INTO `a_menu` VALUES ('224', '207', '提交区政府审查（项目审查）', null, '0', '/gov/itemprocess_c2gc', null, '1', '1', '0', '0', null, '2018-02-24 18:19:27', '2018-02-24 18:19:27', null);
INSERT INTO `a_menu` VALUES ('225', '207', '不予受理（项目审查）', null, '0', '/gov/itemprocess_stop', null, '1', '1', '0', '0', null, '2018-02-24 18:34:11', '2018-02-24 18:35:04', null);
INSERT INTO `a_menu` VALUES ('226', '203', '被征收户详情', null, '0', '/gov/householddetail_info', null, '1', '1', '0', '0', null, '2018-02-26 09:34:47', '2018-02-26 09:34:47', null);
INSERT INTO `a_menu` VALUES ('227', '211', '其他事项', null, '0', '/gov/householddetails', null, '1', '1', '1', '0', null, '2018-02-26 09:46:27', '2018-02-26 09:47:08', null);
INSERT INTO `a_menu` VALUES ('228', '211', '被征户-其他补偿事项', null, '0', '/gov/householdobject', null, '1', '1', '1', '0', null, '2018-02-26 11:05:59', '2018-02-26 11:05:59', null);
INSERT INTO `a_menu` VALUES ('229', '228', '添加其他事项', null, '0', '/gov/householdobject_add', null, '1', '1', '1', '0', null, '2018-02-26 11:06:57', '2018-02-26 11:06:57', null);

-- ----------------------------
-- Table structure for a_news_cate
-- ----------------------------
DROP TABLE IF EXISTS `a_news_cate`;
CREATE TABLE `a_news_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名称，【必须，唯一】',
  `infos` text COMMENT '描述',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='通知公告-分类';

-- ----------------------------
-- Records of a_news_cate
-- ----------------------------
INSERT INTO `a_news_cate` VALUES ('1', '征收范围公告', null, '2018-02-09 16:24:03', '2018-02-09 16:27:03', null);

-- ----------------------------
-- Table structure for a_pact_cate
-- ----------------------------
DROP TABLE IF EXISTS `a_pact_cate`;
CREATE TABLE `a_pact_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名称【必须，唯一】',
  `infos` text COMMENT ' 描述',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) COMMENT '名称唯一'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='协议分类';

-- ----------------------------
-- Records of a_pact_cate
-- ----------------------------

-- ----------------------------
-- Table structure for a_process
-- ----------------------------
DROP TABLE IF EXISTS `a_process`;
CREATE TABLE `a_process` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schedule_id` int(11) NOT NULL DEFAULT '0' COMMENT '所在项目进度ID，【必须】',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级ID，【必须】',
  `name` varchar(255) NOT NULL COMMENT '流程名称，【必须】',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '操作类型，1数据，2审查',
  `menu_id` int(11) NOT NULL COMMENT '菜单ID',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '顺序，【必须,唯一】',
  `number` int(11) NOT NULL DEFAULT '1' COMMENT '同级角色执行限制人数',
  `infos` text COMMENT '流程描述',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sort` (`sort`) COMMENT '顺序唯一',
  UNIQUE KEY `menu_id` (`menu_id`) COMMENT '菜单 ID',
  KEY `schedule_id` (`schedule_id`) COMMENT '进度ID'
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='项目流程';

-- ----------------------------
-- Records of a_process
-- ----------------------------
INSERT INTO `a_process` VALUES ('1', '1', '0', '新建项目', '1', '44', '1', '1', null, '2018-02-23 11:52:40', '2018-02-23 11:52:40', null);
INSERT INTO `a_process` VALUES ('2', '1', '0', '提交部门审查', '1', '209', '10', '1', null, '2018-02-23 12:01:22', '2018-02-23 12:01:22', null);
INSERT INTO `a_process` VALUES ('3', '1', '0', '部门审查', '2', '218', '20', '1', null, '2018-02-23 12:02:44', '2018-02-24 11:40:05', null);
INSERT INTO `a_process` VALUES ('4', '1', '3', '重新提交审查资料', '1', '223', '9', '1', null, '2018-02-23 12:03:32', '2018-02-24 18:20:58', null);
INSERT INTO `a_process` VALUES ('5', '1', '3', '审查驳回处理', '1', '222', '21', '1', null, '2018-02-23 12:04:06', '2018-02-24 18:29:29', null);
INSERT INTO `a_process` VALUES ('6', '1', '0', '提交区政府审查', '1', '224', '30', '1', null, '2018-02-23 12:04:29', '2018-02-24 18:21:38', null);
INSERT INTO `a_process` VALUES ('7', '1', '0', '区政府审查', '2', '43', '40', '1', null, '2018-02-23 12:04:53', '2018-02-23 12:04:53', null);
INSERT INTO `a_process` VALUES ('8', '1', '0', '项目启动配置', '1', '45', '50', '1', null, '2018-02-23 12:05:41', '2018-02-23 12:05:41', null);
INSERT INTO `a_process` VALUES ('9', '1', '8', '配置项目人员', '1', '196', '51', '1', null, '2018-02-23 13:34:31', '2018-02-23 13:34:50', null);
INSERT INTO `a_process` VALUES ('10', '1', '8', '项目时间规划', '1', '194', '52', '1', null, '2018-02-23 13:35:40', '2018-02-23 13:35:40', null);
INSERT INTO `a_process` VALUES ('11', '1', '0', '项目配置提交审查', '1', '46', '60', '1', null, '2018-02-23 13:36:37', '2018-02-23 13:36:37', null);
INSERT INTO `a_process` VALUES ('12', '1', '0', '项目配置审查', '2', '47', '70', '1', null, '2018-02-23 13:37:14', '2018-02-23 13:37:14', null);
INSERT INTO `a_process` VALUES ('13', '1', '0', '项目启动', '1', '48', '80', '1', null, '2018-02-23 13:37:45', '2018-02-23 13:37:45', null);
INSERT INTO `a_process` VALUES ('14', '2', '0', '项目初步预算', '1', '52', '90', '1', null, '2018-02-23 13:38:11', '2018-02-23 13:38:11', null);
INSERT INTO `a_process` VALUES ('15', '1', '3', '不予受理', '1', '225', '22', '1', null, '2018-02-24 18:32:07', '2018-02-24 18:34:43', null);

-- ----------------------------
-- Table structure for a_schedule
-- ----------------------------
DROP TABLE IF EXISTS `a_schedule`;
CREATE TABLE `a_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '项目进度名称，【必须，唯一】',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '顺序，【必须，唯一】',
  `infos` text COMMENT '进度描述',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) COMMENT '名称唯一',
  UNIQUE KEY `sort` (`sort`) COMMENT '顺序唯一'
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='项目进度';

-- ----------------------------
-- Records of a_schedule
-- ----------------------------
INSERT INTO `a_schedule` VALUES ('1', '项目审查', '1', '提交征收部门审查，区政府审查，项目人员，时间规划，项目负责人，项目启动', '2018-02-08 21:08:43', '2018-02-08 21:31:04', null);
INSERT INTO `a_schedule` VALUES ('2', '项目准备', '2', null, '2018-02-08 21:14:14', '2018-02-08 21:30:57', null);
INSERT INTO `a_schedule` VALUES ('3', '调查建档', '3', null, '2018-02-08 21:16:08', '2018-02-08 21:30:45', null);
INSERT INTO `a_schedule` VALUES ('4', '征收决定', '4', null, '2018-02-09 12:02:29', '2018-02-09 12:02:29', null);
INSERT INTO `a_schedule` VALUES ('5', '项目实施', '5', null, '2018-02-09 12:02:50', '2018-02-09 12:02:50', null);
INSERT INTO `a_schedule` VALUES ('6', '项目审计', '6', null, '2018-02-09 12:03:10', '2018-02-09 12:03:10', null);

-- ----------------------------
-- Table structure for a_state_code
-- ----------------------------
DROP TABLE IF EXISTS `a_state_code`;
CREATE TABLE `a_state_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` char(20) NOT NULL COMMENT '状态代码',
  `name` varchar(255) NOT NULL COMMENT '状态名称',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`) COMMENT '代码唯一'
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='状态代码';

-- ----------------------------
-- Records of a_state_code
-- ----------------------------
INSERT INTO `a_state_code` VALUES ('1', '0', '待处理', '2018-02-09 17:11:21', '2018-02-23 09:36:02', null);
INSERT INTO `a_state_code` VALUES ('2', '1', '处理中', '2018-02-09 17:12:46', '2018-02-23 09:36:17', null);
INSERT INTO `a_state_code` VALUES ('3', '2', '已完成', '2018-02-22 19:01:01', '2018-02-23 19:11:20', null);
INSERT INTO `a_state_code` VALUES ('4', '3', '已取消', '2018-02-23 09:22:33', '2018-02-23 19:11:51', null);
INSERT INTO `a_state_code` VALUES ('5', '20', '待审查', '2018-02-23 09:41:36', '2018-02-23 09:41:36', null);
INSERT INTO `a_state_code` VALUES ('6', '21', '审查中', '2018-02-23 09:41:48', '2018-02-23 09:41:48', null);
INSERT INTO `a_state_code` VALUES ('7', '22', '审查通过', '2018-02-23 09:42:00', '2018-02-23 09:42:00', null);
INSERT INTO `a_state_code` VALUES ('8', '23', '审查驳回', '2018-02-23 09:42:11', '2018-02-23 09:42:11', null);

-- ----------------------------
-- Table structure for a_subject
-- ----------------------------
DROP TABLE IF EXISTS `a_subject`;
CREATE TABLE `a_subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名称【必须，唯一】',
  `main` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否固定科目，0否，1是',
  `infos` text COMMENT '补偿说明',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) COMMENT '名称唯一'
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='重要补偿科目';

-- ----------------------------
-- Records of a_subject
-- ----------------------------
INSERT INTO `a_subject` VALUES ('1', '合法房屋及附属物', '1', null, '2018-02-09 16:39:25', '2018-02-09 16:39:40', null);
INSERT INTO `a_subject` VALUES ('2', '合法临建', '1', null, '2018-02-09 16:41:14', '2018-02-09 16:41:14', null);
INSERT INTO `a_subject` VALUES ('3', '违建自行拆除补助', '1', null, '2018-02-09 16:41:48', '2018-02-09 16:41:48', null);
INSERT INTO `a_subject` VALUES ('4', '公共附属物', '1', null, '2018-02-09 16:42:11', '2018-02-09 16:42:11', null);
INSERT INTO `a_subject` VALUES ('5', '其他补偿事项', '1', null, '2018-02-09 16:43:46', '2018-02-09 16:43:46', null);
INSERT INTO `a_subject` VALUES ('6', '装饰装修补偿', '0', null, '2018-02-09 16:44:09', '2018-02-09 16:46:36', null);
INSERT INTO `a_subject` VALUES ('7', '停产停业损失补偿', '0', null, '2018-02-09 16:44:22', '2018-02-09 16:44:22', null);
INSERT INTO `a_subject` VALUES ('8', '搬迁补助', '0', null, '2018-02-09 16:44:39', '2018-02-09 16:44:39', null);
INSERT INTO `a_subject` VALUES ('9', '住宅签约奖励', '0', null, '2018-02-09 16:45:28', '2018-02-09 16:45:28', null);
INSERT INTO `a_subject` VALUES ('10', '非住宅签约奖励', '0', null, '2018-02-09 16:45:45', '2018-02-09 16:45:45', null);
INSERT INTO `a_subject` VALUES ('11', '货币补偿签约奖励', '0', null, '2018-02-09 16:46:20', '2018-02-09 16:46:20', null);
INSERT INTO `a_subject` VALUES ('12', '临时安置费', '0', null, '2018-02-09 16:47:38', '2018-02-09 16:47:38', null);
INSERT INTO `a_subject` VALUES ('13', '临时安置费特殊人群优惠补助', '0', null, '2018-02-09 16:48:21', '2018-02-09 16:48:21', null);
INSERT INTO `a_subject` VALUES ('14', '困难家庭补助', '0', null, '2018-02-09 16:48:57', '2018-02-09 16:50:07', null);
INSERT INTO `a_subject` VALUES ('15', '按约搬迁奖励', '0', null, '2018-02-09 16:50:38', '2018-02-09 16:50:38', null);
INSERT INTO `a_subject` VALUES ('16', '房屋征收奖励', '0', null, '2018-02-09 16:52:38', '2018-02-09 16:52:38', null);

-- ----------------------------
-- Table structure for bank
-- ----------------------------
DROP TABLE IF EXISTS `bank`;
CREATE TABLE `bank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名称【必须，唯一】',
  `infos` text COMMENT ' 描述',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) COMMENT '名称唯一'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='银行';

-- ----------------------------
-- Records of bank
-- ----------------------------
INSERT INTO `bank` VALUES ('1', '中国工商银行', null, '2018-02-09 15:32:05', '2018-02-09 15:32:05', null);

-- ----------------------------
-- Table structure for building_struct
-- ----------------------------
DROP TABLE IF EXISTS `building_struct`;
CREATE TABLE `building_struct` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名称【必须，唯一】',
  `infos` text COMMENT ' 描述',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) COMMENT '名称唯一'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='建筑结构类型';

-- ----------------------------
-- Records of building_struct
-- ----------------------------
INSERT INTO `building_struct` VALUES ('1', '水泥', null, '2018-02-22 16:00:49', '2018-02-22 16:00:49', null);

-- ----------------------------
-- Table structure for building_use
-- ----------------------------
DROP TABLE IF EXISTS `building_use`;
CREATE TABLE `building_use` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名称【必须，唯一】',
  `infos` text COMMENT ' 描述',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) COMMENT '名称唯一'
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='建筑用途';

-- ----------------------------
-- Records of building_use
-- ----------------------------
INSERT INTO `building_use` VALUES ('1', '住宅', null, '2018-02-23 10:21:47', '2018-02-23 10:21:47', null);
INSERT INTO `building_use` VALUES ('2', '店铺', null, '2018-02-23 10:22:20', '2018-02-23 10:22:20', null);

-- ----------------------------
-- Table structure for company
-- ----------------------------
DROP TABLE IF EXISTS `company`;
CREATE TABLE `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型，0房产评估机构，1资产评估机构',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `address` varchar(255) NOT NULL COMMENT ' 地址',
  `phone` char(20) NOT NULL COMMENT ' 电话',
  `fax` char(20) DEFAULT NULL COMMENT ' 传真',
  `contact_man` varchar(255) DEFAULT NULL COMMENT ' 联系人',
  `contact_tel` char(20) DEFAULT NULL COMMENT ' 联系电话',
  `logo` text COMMENT ' ',
  `infos` text COMMENT '描述',
  `content` text NOT NULL COMMENT '简介',
  `picture` text COMMENT ' 图片',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '评估机构操作员ID，【管理员】',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT ' 状态，0未通过审查，1通过审查',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评估机构';

-- ----------------------------
-- Records of company
-- ----------------------------

-- ----------------------------
-- Table structure for company_user
-- ----------------------------
DROP TABLE IF EXISTS `company_user`;
CREATE TABLE `company_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL COMMENT '评估机构ID',
  `name` varchar(255) DEFAULT NULL COMMENT ' 名称',
  `phone` char(20) DEFAULT NULL COMMENT ' 电话',
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `password` varchar(255) NOT NULL COMMENT ' 密码',
  `secret` varchar(255) NOT NULL COMMENT ' 密钥',
  `session` varchar(255) DEFAULT NULL COMMENT ' 登录sessionID',
  `action_at` datetime DEFAULT NULL COMMENT ' 最近操作时间',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评估机构-操作员';

-- ----------------------------
-- Records of company_user
-- ----------------------------

-- ----------------------------
-- Table structure for company_valuer
-- ----------------------------
DROP TABLE IF EXISTS `company_valuer`;
CREATE TABLE `company_valuer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL COMMENT '评估机构 ID',
  `name` varchar(255) NOT NULL COMMENT ' 姓名',
  `phone` char(20) DEFAULT NULL COMMENT ' 电话',
  `register` varchar(255) NOT NULL COMMENT ' 注册号',
  `valid_at` date NOT NULL COMMENT ' 有效期',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评估机构-评估师';

-- ----------------------------
-- Records of company_valuer
-- ----------------------------

-- ----------------------------
-- Table structure for com_assess
-- ----------------------------
DROP TABLE IF EXISTS `com_assess`;
CREATE TABLE `com_assess` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `assets` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT ' 资产评估总价',
  `estate` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT ' 房产评估总价',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态，0待评估，1评估中，2完成，3通过，4驳回，5反对，6同意',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评估-汇总';

-- ----------------------------
-- Records of com_assess
-- ----------------------------

-- ----------------------------
-- Table structure for com_assess_assets
-- ----------------------------
DROP TABLE IF EXISTS `com_assess_assets`;
CREATE TABLE `com_assess_assets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT ' 项目ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `assess_id` int(11) NOT NULL COMMENT ' 评估ID',
  `company_id` int(11) NOT NULL COMMENT ' 评估公司ID',
  `total` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT '评估总价',
  `picture` text COMMENT '评估报告',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态，0待评估，1评估中，2完成，3通过，4驳回，5反对，6同意，7失效',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`),
  KEY `assess_id` (`assess_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评估-资产评估';

-- ----------------------------
-- Records of com_assess_assets
-- ----------------------------

-- ----------------------------
-- Table structure for com_assess_estate
-- ----------------------------
DROP TABLE IF EXISTS `com_assess_estate`;
CREATE TABLE `com_assess_estate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT ' 项目ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `assess_id` int(11) NOT NULL COMMENT ' 评估ID',
  `company_id` int(11) NOT NULL COMMENT ' 评估公司ID',
  `main_total` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT ' 主体建筑评估总价',
  `tag_total` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT ' 附属物评估总价',
  `total` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT '评估总价',
  `picture` text COMMENT '评估报告',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态，0待评估，1评估中，2完成，3通过，4驳回，5反对，6同意，7失效',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`),
  KEY `assess_id` (`assess_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评估-房产评估';

-- ----------------------------
-- Records of com_assess_estate
-- ----------------------------

-- ----------------------------
-- Table structure for com_assess_valuer
-- ----------------------------
DROP TABLE IF EXISTS `com_assess_valuer`;
CREATE TABLE `com_assess_valuer` (
  `item_id` int(11) NOT NULL COMMENT '项目iD',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `assess_id` int(11) NOT NULL COMMENT ' 评估ID',
  `assets_id` int(11) NOT NULL DEFAULT '0' COMMENT '资产评估ID',
  `estate_id` int(11) NOT NULL DEFAULT '0' COMMENT ' 房产评估ID',
  `company_id` int(11) NOT NULL COMMENT ' 评估公司ID',
  `valuer_id` int(11) NOT NULL COMMENT ' 评估师ID',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`),
  KEY `assess_id` (`assess_id`),
  KEY `estate_id` (`estate_id`),
  KEY `company_id` (`company_id`),
  KEY `valuer_id` (`valuer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评估-评估师';

-- ----------------------------
-- Records of com_assess_valuer
-- ----------------------------

-- ----------------------------
-- Table structure for com_estate_building
-- ----------------------------
DROP TABLE IF EXISTS `com_estate_building`;
CREATE TABLE `com_estate_building` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `company_id` int(11) NOT NULL COMMENT '评估公司ID',
  `assess_id` int(11) NOT NULL COMMENT '评估ID',
  `estate_id` int(11) NOT NULL COMMENT '评估-房产评估ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `household_building_id` int(11) NOT NULL COMMENT ' 被征收户-房屋建筑ID',
  `real_outer` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT ' 实际建筑面积',
  `real_use` int(11) NOT NULL DEFAULT '0' COMMENT ' 实际用途ID',
  `struct_id` int(11) NOT NULL COMMENT ' 结构类型ID',
  `direct` varchar(255) NOT NULL COMMENT ' 朝向',
  `floor` int(11) NOT NULL COMMENT ' 楼层',
  `layout_img` text NOT NULL COMMENT '户型图',
  `picture` text NOT NULL COMMENT ' 图片',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '评估单价',
  `amount` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT ' 评估总价',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`),
  KEY `company_id` (`company_id`),
  KEY `assess_id` (`assess_id`),
  KEY `estate_id` (`estate_id`),
  KEY `household_building_id` (`household_building_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评估-房产-房屋建筑';

-- ----------------------------
-- Records of com_estate_building
-- ----------------------------

-- ----------------------------
-- Table structure for com_public
-- ----------------------------
DROP TABLE IF EXISTS `com_public`;
CREATE TABLE `com_public` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `company_id` int(11) NOT NULL COMMENT '评估公司ID',
  `total` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT ' 评估总价',
  `picture` text NOT NULL COMMENT '评估报告',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评估-公共附属物';

-- ----------------------------
-- Records of com_public
-- ----------------------------

-- ----------------------------
-- Table structure for com_public_detail
-- ----------------------------
DROP TABLE IF EXISTS `com_public_detail`;
CREATE TABLE `com_public_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `item_public_id` int(11) NOT NULL COMMENT '公共附属物ID',
  `company_id` int(11) NOT NULL COMMENT '评估公司ID',
  `com_public_id` int(11) NOT NULL COMMENT '公共附属物评估ID',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '评估单价',
  `amount` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT ' 评估总价',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`),
  KEY `company_id` (`company_id`),
  KEY `item_public_id` (`item_public_id`),
  KEY `com_public_id` (`com_public_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评估-公共附属物明细';

-- ----------------------------
-- Records of com_public_detail
-- ----------------------------

-- ----------------------------
-- Table structure for crowd
-- ----------------------------
DROP TABLE IF EXISTS `crowd`;
CREATE TABLE `crowd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL COMMENT '分类ID',
  `name` varchar(255) NOT NULL COMMENT '名称【必须，唯一】',
  `infos` text COMMENT ' 描述',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) COMMENT '名称唯一'
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='特殊人群分类';

-- ----------------------------
-- Records of crowd
-- ----------------------------
INSERT INTO `crowd` VALUES ('1', '0', '一级分类', null, '2018-02-24 15:51:11', '2018-02-24 15:51:11', null);
INSERT INTO `crowd` VALUES ('2', '1', '一级残疾', null, '2018-02-24 15:51:33', '2018-02-24 15:51:33', null);
INSERT INTO `crowd` VALUES ('3', '0', '二级分类', null, '2018-02-24 17:08:32', '2018-02-24 17:08:32', null);
INSERT INTO `crowd` VALUES ('4', '3', 'xxx', null, '2018-02-24 17:08:55', '2018-02-24 17:08:55', null);

-- ----------------------------
-- Table structure for dept
-- ----------------------------
DROP TABLE IF EXISTS `dept`;
CREATE TABLE `dept` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上級ID，【必须】',
  `name` varchar(255) NOT NULL COMMENT ' 名称，【必须，唯一】',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型，【0直属，1从属】',
  `infos` text COMMENT '描述',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE COMMENT '名称唯一',
  KEY `parent_id` (`parent_id`) COMMENT '上级ID'
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='组织与部门';

-- ----------------------------
-- Records of dept
-- ----------------------------
INSERT INTO `dept` VALUES ('1', '0', '征收管理中心', '0', null, '2018-02-02 19:44:47', '2018-02-02 21:47:11', null);
INSERT INTO `dept` VALUES ('2', '1', '政策法规股', '0', '按照《天水市秦州区人民政府关于天水信号厂片区土地熟化项目二期房屋征收补偿安置实施方案》及《天水信号厂片区土地熟化项目二期房屋征收补偿安置协议书(一)》的规定，甲乙双方本着公平合理、平等协商的原则，就乙方的临时安置及搬迁奖励等达成如下协议。', '2018-02-02 19:45:31', '2018-02-03 09:18:48', null);
INSERT INTO `dept` VALUES ('3', '1', '征收股', '0', null, '2018-02-02 19:45:49', '2018-02-02 19:45:49', null);
INSERT INTO `dept` VALUES ('4', '1', '安置股', '0', null, '2018-02-02 19:46:04', '2018-02-02 19:46:04', null);
INSERT INTO `dept` VALUES ('5', '1', '账务股', '0', null, '2018-02-02 19:50:14', '2018-02-03 09:17:22', null);

-- ----------------------------
-- Table structure for file_cate
-- ----------------------------
DROP TABLE IF EXISTS `file_cate`;
CREATE TABLE `file_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_table_id` int(11) NOT NULL COMMENT '分类数据表ID',
  `name` varchar(255) NOT NULL COMMENT '名称，【必须，唯一】',
  `filename` varchar(255) NOT NULL COMMENT '保存文件名，【必须】',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) COMMENT '名称唯一',
  UNIQUE KEY `file_table_file_name` (`file_table_id`,`filename`) COMMENT '同类文件名唯一'
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='必备附件分类';

-- ----------------------------
-- Records of file_cate
-- ----------------------------
INSERT INTO `file_cate` VALUES ('1', '1', '符合国民经济和社会发展规划的证明文件', 'file1', null, null, null);
INSERT INTO `file_cate` VALUES ('2', '1', '符合土地利用总体规划的证明文件', 'file2', null, null, null);
INSERT INTO `file_cate` VALUES ('3', '1', '符合城乡规划和专项规划的证明文件', 'file3', null, null, null);
INSERT INTO `file_cate` VALUES ('4', '1', '保障性安居工程建设和旧城区改造纳入国民经济和社会发展年度计划的证明文件', 'file4', null, null, null);

-- ----------------------------
-- Table structure for house
-- ----------------------------
DROP TABLE IF EXISTS `house`;
CREATE TABLE `house` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL DEFAULT '0' COMMENT '管理机构ID',
  `community_id` int(11) NOT NULL COMMENT '房源社区ID',
  `layout_id` int(11) NOT NULL COMMENT '户型ID',
  `layout_img_id` int(11) NOT NULL COMMENT ' 户型图ID',
  `building` int(11) NOT NULL COMMENT ' 楼栋',
  `unit` int(11) NOT NULL COMMENT ' 单元',
  `floor` int(11) NOT NULL COMMENT ' 楼层',
  `number` varchar(255) NOT NULL COMMENT ' 房号',
  `area` decimal(20,2) NOT NULL COMMENT ' 面积（㎡）',
  `total_floor` int(11) NOT NULL COMMENT ' 总楼层',
  `lift` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有电梯，0否，1是',
  `is_real` tinyint(1) NOT NULL DEFAULT '0' COMMENT '房源类型，0期房，1现房',
  `is_buy` tinyint(1) NOT NULL DEFAULT '0' COMMENT '房源购置状态，0未购买，1已购买',
  `is_transit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '可临时周转状况，0不可作临时周转，1可作临时周转',
  `is_public` tinyint(1) NOT NULL DEFAULT '0' COMMENT '可项目共享状况，0不可项目共享，1可项目共享',
  `picture` text COMMENT ' 房源图片',
  `delive_at` date DEFAULT NULL COMMENT '购置交付日期',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT ' 房源状况，0空闲，1冻结，2临时周转，3产权调换，4失效，5售出，6锁定',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `community_id` (`community_id`),
  KEY `layout_id` (`layout_id`),
  KEY `layout_img_id` (`layout_img_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='房源';

-- ----------------------------
-- Records of house
-- ----------------------------

-- ----------------------------
-- Table structure for house_community
-- ----------------------------
DROP TABLE IF EXISTS `house_community`;
CREATE TABLE `house_community` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL DEFAULT '0' COMMENT '房源管理机构ID',
  `name` varchar(255) NOT NULL COMMENT '社区名称',
  `address` varchar(255) NOT NULL COMMENT '地址',
  `infos` text COMMENT ' 描述',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='房源社区';

-- ----------------------------
-- Records of house_community
-- ----------------------------

-- ----------------------------
-- Table structure for house_company
-- ----------------------------
DROP TABLE IF EXISTS `house_company`;
CREATE TABLE `house_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名称',
  `address` varchar(255) NOT NULL COMMENT '地址',
  `phone` char(20) DEFAULT NULL COMMENT '电话',
  `contact_man` varchar(255) DEFAULT NULL COMMENT '联系人',
  `contact_tel` char(20) DEFAULT NULL COMMENT ' 联系电话',
  `infos` text COMMENT ' 描述',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='房源管理机构';

-- ----------------------------
-- Records of house_company
-- ----------------------------

-- ----------------------------
-- Table structure for house_layout_img
-- ----------------------------
DROP TABLE IF EXISTS `house_layout_img`;
CREATE TABLE `house_layout_img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `community_id` int(11) NOT NULL COMMENT '社区ID',
  `layout_id` int(11) NOT NULL COMMENT ' 户型ID',
  `name` varchar(255) NOT NULL COMMENT '户型图名称',
  `picture` text NOT NULL COMMENT ' 户型图',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `community_id` (`community_id`),
  KEY `layout_id` (`layout_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='房源社区户型图';

-- ----------------------------
-- Records of house_layout_img
-- ----------------------------

-- ----------------------------
-- Table structure for house_manage_fee
-- ----------------------------
DROP TABLE IF EXISTS `house_manage_fee`;
CREATE TABLE `house_manage_fee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `house_id` int(11) NOT NULL COMMENT '房源ID',
  `manage_at` char(10) NOT NULL COMMENT ' 管理日期（年-月）',
  `manage_fee` decimal(10,2) NOT NULL COMMENT '月管理费',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `house_id` (`house_id`),
  KEY `manage_at` (`manage_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='房源-购置管理费';

-- ----------------------------
-- Records of house_manage_fee
-- ----------------------------

-- ----------------------------
-- Table structure for house_manage_price
-- ----------------------------
DROP TABLE IF EXISTS `house_manage_price`;
CREATE TABLE `house_manage_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `house_id` int(11) NOT NULL COMMENT '房源ID',
  `manage_price` decimal(10,2) NOT NULL COMMENT ' 房源每月管理费单价（元/月）',
  `start_at` year(4) NOT NULL,
  `end_at` year(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `house_id` (`house_id`),
  KEY `start_at` (`start_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='房源-购置管理费单价';

-- ----------------------------
-- Records of house_manage_price
-- ----------------------------

-- ----------------------------
-- Table structure for house_price
-- ----------------------------
DROP TABLE IF EXISTS `house_price`;
CREATE TABLE `house_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `house_id` int(11) NOT NULL COMMENT '房源ID',
  `start_at` date NOT NULL COMMENT '起始时间',
  `end_at` date NOT NULL COMMENT ' 结束时间 ',
  `market` decimal(10,2) NOT NULL COMMENT ' 市场评估价',
  `price` decimal(10,2) NOT NULL COMMENT ' 安置优惠价',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `house_id` (`house_id`),
  KEY `start_at` (`start_at`),
  KEY `end_at` (`end_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='房源-评估单价';

-- ----------------------------
-- Records of house_price
-- ----------------------------

-- ----------------------------
-- Table structure for house_resettle
-- ----------------------------
DROP TABLE IF EXISTS `house_resettle`;
CREATE TABLE `house_resettle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT ' 项目ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `pay_id` int(11) NOT NULL COMMENT '兑付ID',
  `pact_id` int(11) NOT NULL COMMENT '协议ID',
  `house_id` int(11) NOT NULL COMMENT '房源ID',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态，0安置中，1调换完成，2取消调换',
  `settle_at` date NOT NULL COMMENT '安置日期',
  `hold_at` date DEFAULT NULL COMMENT '产权调换日期',
  `end_at` date DEFAULT NULL COMMENT '取消调换日期',
  `register` varchar(255) DEFAULT NULL COMMENT '新证件号',
  `picture` text COMMENT '图片',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`),
  KEY `pay_id` (`pay_id`),
  KEY `pact_id` (`pact_id`),
  KEY `house_id` (`house_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产权调换';

-- ----------------------------
-- Records of house_resettle
-- ----------------------------

-- ----------------------------
-- Table structure for house_resettle_notice
-- ----------------------------
DROP TABLE IF EXISTS `house_resettle_notice`;
CREATE TABLE `house_resettle_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT ' 项目ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `member_id` int(11) DEFAULT NULL COMMENT '被征收人ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `pay_id` int(11) NOT NULL COMMENT '兑付ID',
  `pact_id` int(11) NOT NULL COMMENT '协议ID',
  `company_id` int(11) NOT NULL DEFAULT '0' COMMENT '管理机构',
  `community_id` int(11) NOT NULL COMMENT '房源社区ID',
  `house_id` int(11) NOT NULL COMMENT '房源ID',
  `serial` int(11) NOT NULL DEFAULT '1' COMMENT '序号',
  `content` text COMMENT '内容',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`),
  KEY `pay_id` (`pay_id`),
  KEY `pact_id` (`pact_id`),
  KEY `house_id` (`house_id`),
  KEY `company_id` (`company_id`),
  KEY `community_id` (`community_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产权调换-入住通知单';

-- ----------------------------
-- Records of house_resettle_notice
-- ----------------------------

-- ----------------------------
-- Table structure for house_transit
-- ----------------------------
DROP TABLE IF EXISTS `house_transit`;
CREATE TABLE `house_transit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT ' 项目ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `pay_id` int(11) NOT NULL COMMENT '兑付ID',
  `pact_id` int(11) NOT NULL COMMENT '协议ID',
  `house_id` int(11) NOT NULL COMMENT '房源ID',
  `start_at` date NOT NULL COMMENT '开始日期',
  `exp_end` date NOT NULL COMMENT ' 预计结束日期',
  `end_at` date DEFAULT NULL COMMENT ' 结束日期',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`),
  KEY `pay_id` (`pay_id`),
  KEY `pact_id` (`pact_id`),
  KEY `house_id` (`house_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='临时周转';

-- ----------------------------
-- Records of house_transit
-- ----------------------------

-- ----------------------------
-- Table structure for item
-- ----------------------------
DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '项目名称，【必须，唯一】',
  `place` text NOT NULL COMMENT ' 项目范围，【必须】',
  `map` text NOT NULL COMMENT ' 项目范围地图',
  `infos` text COMMENT ' 项目描述',
  `picture` text NOT NULL COMMENT '项目审查必备资料，【必须】',
  `schedule_id` int(11) DEFAULT NULL COMMENT '进度ID',
  `process_id` int(11) DEFAULT NULL COMMENT '流程ID',
  `code` char(20) NOT NULL DEFAULT '' COMMENT '项目状态代码',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE COMMENT '名称唯一',
  KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='项目-基本信息';

-- ----------------------------
-- Records of item
-- ----------------------------
INSERT INTO `item` VALUES ('1', '西关片区棚户区改造项目', '东至自由路、西至双桥路、北至成纪大道、南至解放路', '/storage/180223/mK5owDrG1mq9Ptpa2IgHCB3sz3F2n75jW92myUDV.png', null, '{\"file1\":[\"\\/storage\\/180223\\/NZjbyaVk6rZ6HJIWyoR3pkOSrRsQTdsvfiNjE6Rg.jpeg\"],\"file2\":[\"\\/storage\\/180223\\/JftNYwrUVh0Pg5xDxEfiU829gJSm245TOjAAUZWu.png\"],\"file3\":[\"\\/storage\\/180223\\/0PHJnAKiV91iIyomMMyQstD3IgkgCDusHxki0Kxr.jpeg\"],\"file4\":[\"\\/storage\\/180223\\/kjwiM1uWs7uk1wfnTVtwnD8FK0eBMOYJIxmQBVdR.jpeg\"]}', '1', '4', '1', '2018-02-23 17:35:06', '2018-02-26 11:04:18', null);

-- ----------------------------
-- Table structure for item_admin
-- ----------------------------
DROP TABLE IF EXISTS `item_admin`;
CREATE TABLE `item_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `dept_id` int(11) NOT NULL COMMENT ' 部门ID',
  `role_id` int(11) NOT NULL COMMENT ' 角色ID',
  `user_id` int(11) NOT NULL COMMENT ' 用户ID',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='项目-负责人';

-- ----------------------------
-- Records of item_admin
-- ----------------------------
INSERT INTO `item_admin` VALUES ('1', '1', '1', '3', '4', '2018-02-22 16:47:24', '2018-02-22 16:47:24', null);

-- ----------------------------
-- Table structure for item_assess_report
-- ----------------------------
DROP TABLE IF EXISTS `item_assess_report`;
CREATE TABLE `item_assess_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `name` varchar(255) NOT NULL COMMENT ' 名称',
  `content` text NOT NULL COMMENT ' 内容',
  `picture` text NOT NULL COMMENT ' 图片',
  `code` char(20) NOT NULL COMMENT '状态代码',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目-评估报告';

-- ----------------------------
-- Records of item_assess_report
-- ----------------------------

-- ----------------------------
-- Table structure for item_audit
-- ----------------------------
DROP TABLE IF EXISTS `item_audit`;
CREATE TABLE `item_audit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `infos` text NOT NULL COMMENT '审计结论',
  `picture` text NOT NULL COMMENT '审计报告',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目-审计报告';

-- ----------------------------
-- Records of item_audit
-- ----------------------------

-- ----------------------------
-- Table structure for item_building
-- ----------------------------
DROP TABLE IF EXISTS `item_building`;
CREATE TABLE `item_building` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building` int(11) NOT NULL COMMENT ' 楼栋号',
  `total_floor` int(11) NOT NULL COMMENT '总楼层',
  `area` decimal(30,2) NOT NULL COMMENT ' 占地面积',
  `build_year` int(11) NOT NULL COMMENT ' 建造年份',
  `struct_id` int(11) NOT NULL COMMENT ' 结构类型ID',
  `infos` text COMMENT ' 描述',
  `picture` text COMMENT ' 图片',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `land_id` (`land_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='项目-地块楼栋';

-- ----------------------------
-- Records of item_building
-- ----------------------------
INSERT INTO `item_building` VALUES ('1', '1', '1', '11', '28', '120.00', '2014', '1', null, '[\"\\/storage\\/180222\\/aYpSfQhW6VWC8Hbs9o3dGJKaNGopv2oORid6DArZ.jpeg\"]', '2018-02-22 16:01:10', '2018-02-22 16:15:33', null);
INSERT INTO `item_building` VALUES ('2', '1', '1', '9', '28', '120.00', '2014', '1', null, null, '2018-02-22 16:02:25', '2018-02-22 16:02:25', null);

-- ----------------------------
-- Table structure for item_company
-- ----------------------------
DROP TABLE IF EXISTS `item_company`;
CREATE TABLE `item_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `type` tinyint(1) NOT NULL COMMENT '评估机构类型，0房产评估机构，1资产评估机构',
  `company_id` int(11) NOT NULL COMMENT '评估机构ID',
  `picture` text COMMENT '评估委托书',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目-选定评估机构';

-- ----------------------------
-- Records of item_company
-- ----------------------------

-- ----------------------------
-- Table structure for item_company_household
-- ----------------------------
DROP TABLE IF EXISTS `item_company_household`;
CREATE TABLE `item_company_household` (
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `company_id` int(11) NOT NULL COMMENT ' 评估机构ID',
  `item_company_id` int(11) NOT NULL COMMENT ' 选定评估机构ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `created_at` datetime NOT NULL COMMENT '添加时间',
  KEY `item_id` (`item_id`),
  KEY `company_id` (`company_id`),
  KEY `item_company_id` (`item_company_id`),
  KEY `household_id` (`household_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目-评估机构评估范围';

-- ----------------------------
-- Records of item_company_household
-- ----------------------------

-- ----------------------------
-- Table structure for item_company_vote
-- ----------------------------
DROP TABLE IF EXISTS `item_company_vote`;
CREATE TABLE `item_company_vote` (
  `item_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `household_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  KEY `item_id` (`item_id`),
  KEY `company_id` (`company_id`),
  KEY `household_id` (`household_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目-评估公司投票';

-- ----------------------------
-- Records of item_company_vote
-- ----------------------------

-- ----------------------------
-- Table structure for item_control
-- ----------------------------
DROP TABLE IF EXISTS `item_control`;
CREATE TABLE `item_control` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT ' 项目ID',
  `cate_id` int(11) NOT NULL COMMENT '控制类型ID',
  `serial` char(1) NOT NULL DEFAULT 'A' COMMENT '序列，A,B,C,……',
  `start_at` datetime NOT NULL COMMENT ' 开始时间',
  `end_at` datetime NOT NULL COMMENT ' 结束时间',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `cate_id` (`cate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目-时间控制';

-- ----------------------------
-- Records of item_control
-- ----------------------------

-- ----------------------------
-- Table structure for item_crowd
-- ----------------------------
DROP TABLE IF EXISTS `item_crowd`;
CREATE TABLE `item_crowd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `crowd_cate_id` int(11) NOT NULL COMMENT '特殊人群分类ID',
  `crowd_id` int(11) NOT NULL COMMENT ' 特殊人群ID',
  `rate` decimal(10,2) NOT NULL COMMENT ' 特殊人群优惠上浮率（%）',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `crowd_id` (`crowd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目-特殊人群优惠上浮率';

-- ----------------------------
-- Records of item_crowd
-- ----------------------------

-- ----------------------------
-- Table structure for item_draft
-- ----------------------------
DROP TABLE IF EXISTS `item_draft`;
CREATE TABLE `item_draft` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `name` varchar(255) NOT NULL COMMENT ' 名称',
  `content` text NOT NULL COMMENT ' 内容',
  `code` char(20) NOT NULL COMMENT '状态代码',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目-征收意见稿';

-- ----------------------------
-- Records of item_draft
-- ----------------------------

-- ----------------------------
-- Table structure for item_draft_report
-- ----------------------------
DROP TABLE IF EXISTS `item_draft_report`;
CREATE TABLE `item_draft_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `draft_id` int(11) NOT NULL COMMENT '征收意见稿ID',
  `content` text NOT NULL COMMENT '听证会修改意见',
  `code` char(20) NOT NULL COMMENT '状态代码',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目-征收意见稿-听证会修改意见';

-- ----------------------------
-- Records of item_draft_report
-- ----------------------------

-- ----------------------------
-- Table structure for item_funds
-- ----------------------------
DROP TABLE IF EXISTS `item_funds`;
CREATE TABLE `item_funds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL DEFAULT '0' COMMENT '项目ID',
  `cate_id` int(11) NOT NULL DEFAULT '0' COMMENT '进出类型ID',
  `total_id` int(11) NOT NULL DEFAULT '0' COMMENT '兑付总单ID',
  `amount` decimal(20,2) NOT NULL COMMENT '金额，收入为正，支出为负',
  `voucher` varchar(255) NOT NULL COMMENT '转账凭证号',
  `bank_id` int(11) NOT NULL COMMENT ' 银行ID',
  `account` varchar(255) NOT NULL COMMENT '银行账号',
  `name` varchar(255) NOT NULL COMMENT '银行账户姓名',
  `entry_at` datetime NOT NULL COMMENT ' 到账时间',
  `infos` text NOT NULL COMMENT ' 款项说明',
  `picture` text NOT NULL COMMENT ' 转账凭证',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`) USING BTREE,
  KEY `cate_id` (`cate_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目-资金收入支出流水';

-- ----------------------------
-- Records of item_funds
-- ----------------------------

-- ----------------------------
-- Table structure for item_funds_total
-- ----------------------------
DROP TABLE IF EXISTS `item_funds_total`;
CREATE TABLE `item_funds_total` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL DEFAULT '0' COMMENT '项目ID',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '兑付对象，0被征收户，1公产单位',
  `val_id` int(11) NOT NULL DEFAULT '0' COMMENT '被征收户（公产单位）ID',
  `cate_id` int(11) NOT NULL DEFAULT '0' COMMENT '进出类型ID',
  `amount` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '兑付状态，0待兑付，1兑付中，2已兑付',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`) USING BTREE,
  KEY `cate_id` (`cate_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目-支出总单';

-- ----------------------------
-- Records of item_funds_total
-- ----------------------------

-- ----------------------------
-- Table structure for item_house
-- ----------------------------
DROP TABLE IF EXISTS `item_house`;
CREATE TABLE `item_house` (
  `item_id` int(11) NOT NULL,
  `house_id` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '添加时期，0筹备期，1补充期',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  KEY `item_id` (`item_id`),
  KEY `house_id` (`house_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目-冻结房源';

-- ----------------------------
-- Records of item_house
-- ----------------------------

-- ----------------------------
-- Table structure for item_household
-- ----------------------------
DROP TABLE IF EXISTS `item_household`;
CREATE TABLE `item_household` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `land_id` int(11) NOT NULL COMMENT ' 地块ID',
  `building_id` int(11) NOT NULL DEFAULT '0' COMMENT '楼栋ID',
  `unit` int(11) NOT NULL DEFAULT '0' COMMENT '单元号',
  `floor` int(11) NOT NULL DEFAULT '0' COMMENT ' 楼层',
  `number` varchar(255) NOT NULL COMMENT '房号',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '房产类型，0私产，1公产',
  `username` varchar(255) NOT NULL COMMENT ' 用户名',
  `password` varchar(255) NOT NULL COMMENT ' 密码',
  `secret` varchar(255) NOT NULL COMMENT ' 密钥',
  `infos` text COMMENT ' 描述',
  `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态，0调查中，1已调查，2评估中，3已评估，4未签约，5已签约，6已搬迁，7强制搬迁，8临时周转，9安置中（分期兑付或产权证未完成办理），10已安置',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `item_id` (`item_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='项目-被征收户';

-- ----------------------------
-- Records of item_household
-- ----------------------------
INSERT INTO `item_household` VALUES ('1', '1', '1', '2', '1', '1', '1', '0', '1234567', 'eyJpdiI6IkdpUldJZ3B1N3hxNHNPbDd1SCtWOUE9PSIsInZhbHVlIjoiNnRpUGRsVlk1TldYYkYyVGJWYTYydz09IiwibWFjIjoiMjYyZDY3MjBmM2FiYmZmMWZkOTNmMTE2MzEwZGU4ZDYyMDgzYzIwYmQwMWJjZDlkZDAxMDJkZjNhMDU5YWRjOSJ9', '', '123', '0', null, '2018-02-23 19:06:35', null);
INSERT INTO `item_household` VALUES ('2', '1', '1', '1', '1', '2', '3', '1', '123456', '111111', '26C89384-C673-EC32-8C3C-C4472EB347ED', '214124', '0', '2018-02-22 18:38:39', '2018-02-23 09:47:26', null);
INSERT INTO `item_household` VALUES ('3', '1', '1', '1', '1', '12', '1', '0', '1111111', 'eyJpdiI6IkhvaEdOQVk2REVJeTVuV3Y5XC9QaXFBPT0iLCJ2YWx1ZSI6ImpZYis5b0grVTBYTThNeG9NOUNmeHc9PSIsIm1hYyI6Ijg0Zjk3MTdmNmU1N2UzNTVhNDQyYWNjODRlODVkNjBlZTM4NzZhMzk4ZmJiNTMyZjE0ODljYzBiMjViZDUyZjgifQ==', 'B04CF561-FCEC-1FD7-B9C8-E84027B47BB8', null, '0', '2018-02-26 10:00:51', '2018-02-26 10:00:51', null);

-- ----------------------------
-- Table structure for item_household_building
-- ----------------------------
DROP TABLE IF EXISTS `item_household_building`;
CREATE TABLE `item_household_building` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `register` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否登记，0否，1是',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态，0合法登记，1待认定，2认定合法，3认定非法，4自行拆除，5转为合法',
  `reg_inner` decimal(30,2) NOT NULL COMMENT '登记套内面积',
  `reg_outer` decimal(30,2) NOT NULL COMMENT '登记建筑面积',
  `balcony` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT ' 其中阳台面积',
  `dispute` tinyint(1) NOT NULL DEFAULT '0' COMMENT ' 面积争议，0没有争议，1存在争议，2测量面积，3明确面积，4测量争议，5测绘面积',
  `real_inner` decimal(30,2) NOT NULL COMMENT '实际套内面积',
  `real_outer` decimal(30,2) NOT NULL COMMENT ' 实际建筑面积',
  `def_use` int(11) DEFAULT NULL COMMENT ' 批准用途ID',
  `real_use` int(11) NOT NULL COMMENT ' 实际用途ID',
  `struct_id` int(11) NOT NULL COMMENT ' 结构类型ID',
  `direct` varchar(255) NOT NULL COMMENT ' 朝向',
  `floor` int(11) NOT NULL COMMENT ' 楼层',
  `layout_img` text NOT NULL COMMENT ' 图形',
  `picture` text NOT NULL COMMENT ' 图片及证件',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目-被征收户-房屋建筑';

-- ----------------------------
-- Records of item_household_building
-- ----------------------------

-- ----------------------------
-- Table structure for item_household_building_area
-- ----------------------------
DROP TABLE IF EXISTS `item_household_building_area`;
CREATE TABLE `item_household_building_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `household_building_id` int(11) NOT NULL,
  `way` tinyint(1) NOT NULL DEFAULT '0' COMMENT '解决方式，0现场测量，1委托测绘',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态，0待确认，1确认有效，2确认无效',
  `picture` text NOT NULL COMMENT '争议解决结果',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`),
  KEY `household_building_id` (`household_building_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目-被征收户-房屋建筑-面积争议';

-- ----------------------------
-- Records of item_household_building_area
-- ----------------------------

-- ----------------------------
-- Table structure for item_household_building_deal
-- ----------------------------
DROP TABLE IF EXISTS `item_household_building_deal`;
CREATE TABLE `item_household_building_deal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `household_building_id` int(11) NOT NULL,
  `way` tinyint(1) NOT NULL DEFAULT '0' COMMENT '处理方式，0自选拆除，1转为合法',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态，0待确认，1确认有效',
  `picture` text NOT NULL COMMENT '解决结果',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`),
  KEY `household_building_id` (`household_building_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目-被征收户-房屋建筑-违建处理';

-- ----------------------------
-- Records of item_household_building_deal
-- ----------------------------

-- ----------------------------
-- Table structure for item_household_detail
-- ----------------------------
DROP TABLE IF EXISTS `item_household_detail`;
CREATE TABLE `item_household_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT '楼栋ID',
  `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态，0正常，1存在新建，2存在改建，3存在扩建',
  `register` varchar(255) DEFAULT NULL COMMENT ' 房屋产权证号',
  `reg_inner` decimal(30,2) DEFAULT NULL COMMENT '登记套内面积',
  `reg_outer` decimal(30,2) DEFAULT NULL COMMENT '登记建筑面积',
  `balcony` decimal(10,2) DEFAULT NULL COMMENT '其中阳台面积',
  `dispute` tinyint(1) NOT NULL DEFAULT '0' COMMENT '产权争议，0无争议，1存在争议，2产权明确',
  `layout_img` text NOT NULL COMMENT '房屋户型图',
  `picture` text COMMENT ' 房屋证件',
  `house_img` text COMMENT '房屋图片',
  `def_use` int(11) DEFAULT NULL COMMENT ' 批准用途ID',
  `real_use` int(11) NOT NULL COMMENT ' 实际用途ID',
  `has_assets` tinyint(1) NOT NULL DEFAULT '0' COMMENT ' 是否需要评估资产，0否，1是',
  `agree` tinyint(1) NOT NULL DEFAULT '1' COMMENT '征收意见，0拒绝，1同意',
  `repay_way` tinyint(1) NOT NULL DEFAULT '0' COMMENT '补偿方式，0货币补偿，1产权调换',
  `house_price` decimal(10,2) DEFAULT NULL COMMENT '产权调换意向-房源单价',
  `house_area` decimal(30,2) DEFAULT NULL COMMENT '产权调换意向-房源面积',
  `house_num` int(11) DEFAULT NULL COMMENT '产权调换意向-房源数量',
  `house_addr` text COMMENT '产权调换意向-房源地址',
  `more_price` decimal(10,2) DEFAULT NULL COMMENT '产权调换意向-增加面积单价',
  `layout_id` int(11) DEFAULT NULL COMMENT '产权调换意向-房源户型ID',
  `opinion` varchar(255) DEFAULT NULL COMMENT '其他意见',
  `receive_man` varchar(255) DEFAULT NULL COMMENT '收件人',
  `receive_tel` char(20) DEFAULT NULL COMMENT ' 收件 电话',
  `receive_addr` text COMMENT ' 收件地址',
  `sign` text NOT NULL COMMENT '被征收人签名',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`),
  KEY `def_use` (`def_use`),
  KEY `real_use` (`real_use`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='项目-被征收户详情';

-- ----------------------------
-- Records of item_household_detail
-- ----------------------------
INSERT INTO `item_household_detail` VALUES ('1', '1', '2', '1', '1', '0', null, null, null, null, '0', '[\"\\/storage\\/180223\\/x9JS9gpTAUQ9HdKBCi4zn4IdUEyM478EW9fQBeob.jpeg\"]', null, null, '0', '0', '0', '1', '0', null, null, null, null, null, '0', null, null, null, null, '/storage/180223/qUR5ev90im034dCd9KEHuUDYftZB794dk8WzDR3A.jpeg', '2018-02-23 16:54:14', '2018-02-23 16:54:14', null);
INSERT INTO `item_household_detail` VALUES ('2', '1', '1', '1', '2', '0', '123456789', '120.00', '120.00', '10.00', '1', '[\"\\/storage\\/180223\\/7Z0pk0fiHJ1aV17hvaQOkco3guDj8ziDxyd9u06S.jpeg\"]', '[\"\\/storage\\/180223\\/KD6e30jryo1B8FXVJFD8DnC13HycmPrtspReZxtC.jpeg\",\"\\/storage\\/180223\\/CoZwY9wa6uOTgqgMqckzainO9M6jkAr8ELfV6x31.jpeg\"]', '[\"\\/storage\\/180223\\/vW4LFk4Epp66oooj4iuX7aSPFgosTqXzq6eEIFJt.jpeg\"]', '1', '1', '0', '1', '1', '2000.00', '120.00', '2', '渝北区', '120.00', '1', '111', '张三', '13012345678', '江北区', '/storage/180223/eaW37GKRcWyZ0rPjVhQKBQtxe9kW6ghUNFXet6o9.jpeg', '2018-02-23 17:44:55', '2018-02-24 09:06:31', null);

-- ----------------------------
-- Table structure for item_household_member
-- ----------------------------
DROP TABLE IF EXISTS `item_household_member`;
CREATE TABLE `item_household_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `name` varchar(255) NOT NULL COMMENT ' 姓名',
  `relation` varchar(255) NOT NULL COMMENT '与户主关系',
  `card_num` varchar(255) NOT NULL COMMENT '身份证',
  `phone` char(20) NOT NULL COMMENT ' 电话',
  `nation_id` int(11) NOT NULL COMMENT ' 民族ID',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT ' 性别，0男，1女',
  `age` int(11) NOT NULL COMMENT '年龄',
  `crowd` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否享受特殊人群优惠，0否，1是',
  `holder` tinyint(1) NOT NULL DEFAULT '0' COMMENT '权属类型，0非权属人，1产权人，2承租人',
  `portion` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '权属分配比例（%）',
  `picture` text NOT NULL COMMENT '身份证，户口本页',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='项目-被征收户-家庭成员';

-- ----------------------------
-- Records of item_household_member
-- ----------------------------
INSERT INTO `item_household_member` VALUES ('1', '1', '1', '1', '2', '张三', '户主', '50024019950230201', '13012345678', '1', '0', '25', '1', '1', '80.00', '[\"\\/storage\\/180224\\/vbA2OzNnFIJt2Y7ixz6VQ4gdYrEbCgpMdMInXbio.jpeg\",\"\\/storage\\/180224\\/mdX6IWVNG7RutSA3BoM3JXWPD7rqappxUzyKNU3O.jpeg\"]', '2018-02-24 11:30:41', '2018-02-24 11:30:41', null);
INSERT INTO `item_household_member` VALUES ('2', '1', '1', '1', '2', '李四', '父子', '513246455454654', '13012340000', '1', '0', '1', '0', '0', '10.00', '[\"\\/storage\\/180224\\/7ajlR0c3k7sTFGfXFioCamNvDadtbCK8GqtzVnYC.jpeg\"]', '2018-02-24 11:38:42', '2018-02-24 11:38:42', null);
INSERT INTO `item_household_member` VALUES ('3', '1', '2', '1', '1', 'zhang', '1', '1321546', '1325', '2', '0', '21', '0', '2', '10.00', '[\"\\/storage\\/180224\\/XDBvoL3z4xwsytVrtfVL86fOH3g2RnYvfCydjoje.jpeg\"]', '2018-02-24 15:11:35', '2018-02-24 15:11:35', null);
INSERT INTO `item_household_member` VALUES ('4', '1', '2', '1', '1', 'ces', '423', '45464654564', '130', '2', '0', '35', '1', '0', '10.00', '[\"\\/storage\\/180224\\/2SJd2PqO71kDcoCDiRQ6aKuYHVBuIemULEetx7o6.jpeg\"]', '2018-02-24 15:12:04', '2018-02-24 15:41:03', null);
INSERT INTO `item_household_member` VALUES ('5', '1', '2', '1', '1', '42342', '4235', '352', '532', '2', '0', '432', '0', '0', '80.00', '[\"\\/storage\\/180224\\/O2DiKGNpBwZO7JveJPJHjoyAPs1ahp6gPbwdqHDi.jpeg\"]', '2018-02-24 15:14:02', '2018-02-24 15:14:02', null);

-- ----------------------------
-- Table structure for item_household_member_crowd
-- ----------------------------
DROP TABLE IF EXISTS `item_household_member_crowd`;
CREATE TABLE `item_household_member_crowd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `member_id` int(11) NOT NULL COMMENT '成员ID',
  `crowd_id` int(11) NOT NULL COMMENT '特殊人群ID',
  `picture` text NOT NULL COMMENT '证件',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`),
  KEY `member_id` (`member_id`),
  KEY `crowd_id` (`crowd_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='项目-被征收户-家庭成员-特殊人群';

-- ----------------------------
-- Records of item_household_member_crowd
-- ----------------------------
INSERT INTO `item_household_member_crowd` VALUES ('1', '1', '2', '1', '1', '4', '2', '[\"\\/storage\\/180224\\/faFRqWZ0EzLHPQopDUkcpNBmVnYvqDH3XzKEJK02.jpeg\"]', '2018-02-24 17:23:30', '2018-02-24 17:23:30', null);
INSERT INTO `item_household_member_crowd` VALUES ('2', '1', '2', '1', '1', '4', '4', '[\"\\/storage\\/180224\\/8308RmXipD4nSoZd5rKukQEgHaYlN1rmjyZZdN9U.jpeg\"]', '2018-02-24 17:41:05', '2018-02-24 17:41:05', null);
INSERT INTO `item_household_member_crowd` VALUES ('3', '1', '1', '1', '2', '1', '2', '[\"\\/storage\\/180224\\/OkgCwHnwA1F59h7QtDz6UALi8w7lGv73IXWUd6k0.jpeg\"]', '2018-02-24 17:41:40', '2018-02-24 17:41:40', null);

-- ----------------------------
-- Table structure for item_household_object
-- ----------------------------
DROP TABLE IF EXISTS `item_household_object`;
CREATE TABLE `item_household_object` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `object_id` int(11) NOT NULL DEFAULT '0' COMMENT '其他补偿事项ID',
  `number` int(11) NOT NULL DEFAULT '1' COMMENT '数量',
  `picture` text NOT NULL COMMENT '图片',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目-被征收户-其他补偿事项';

-- ----------------------------
-- Records of item_household_object
-- ----------------------------

-- ----------------------------
-- Table structure for item_household_right
-- ----------------------------
DROP TABLE IF EXISTS `item_household_right`;
CREATE TABLE `item_household_right` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `way` varchar(255) NOT NULL COMMENT '解决方式',
  `picture` text NOT NULL COMMENT '证明',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目-被征收户-产权争议解决';

-- ----------------------------
-- Records of item_household_right
-- ----------------------------

-- ----------------------------
-- Table structure for item_house_rate
-- ----------------------------
DROP TABLE IF EXISTS `item_house_rate`;
CREATE TABLE `item_house_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT ' 项目ID',
  `start_area` decimal(10,2) NOT NULL COMMENT ' 超出面积起',
  `end_area` decimal(10,2) NOT NULL COMMENT ' 超出面积止【为0则结束优惠】',
  `rate` decimal(10,2) NOT NULL COMMENT '优惠上浮率（%）【为0则结束优惠，按市场评估价上浮】',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目-产权调换优惠上浮';

-- ----------------------------
-- Records of item_house_rate
-- ----------------------------

-- ----------------------------
-- Table structure for item_init_budget
-- ----------------------------
DROP TABLE IF EXISTS `item_init_budget`;
CREATE TABLE `item_init_budget` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `holder` int(11) NOT NULL COMMENT '预计户数',
  `money` decimal(20,2) NOT NULL COMMENT ' 预算总金额',
  `house` int(11) NOT NULL COMMENT ' 预备房源数',
  `picture` text COMMENT ' 预算报告',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`) COMMENT '项目'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目-初步预算';

-- ----------------------------
-- Records of item_init_budget
-- ----------------------------

-- ----------------------------
-- Table structure for item_land
-- ----------------------------
DROP TABLE IF EXISTS `item_land`;
CREATE TABLE `item_land` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `address` varchar(255) NOT NULL COMMENT ' 地址',
  `land_prop_id` int(11) NOT NULL COMMENT ' 土地性质ID',
  `land_source_id` int(11) NOT NULL COMMENT ' 土地来源ID',
  `land_state_id` int(11) NOT NULL COMMENT ' 土地权益状况ID',
  `admin_unit_id` int(11) NOT NULL DEFAULT '0' COMMENT ' 所属公产单位ID，0为私产',
  `area` decimal(30,2) NOT NULL COMMENT '占地面积，（㎡）',
  `infos` text COMMENT '备注',
  `picture` text COMMENT ' 图片',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='项目-地块';

-- ----------------------------
-- Records of item_land
-- ----------------------------
INSERT INTO `item_land` VALUES ('1', '1', '渝北区力华科谷', '1', '1', '3', '1', '100.00', null, '[\"\\/storage\\/180222\\/Xdtt0E5BMvKaUVb1qlXQ192vg2YAhw6IV1ra50uu.jpeg\"]', '2018-02-22 15:46:09', '2018-02-22 15:51:35', null);
INSERT INTO `item_land` VALUES ('2', '1', '渝北区', '1', '1', '3', '1', '100.00', null, null, '2018-02-22 18:24:57', '2018-02-22 18:24:57', null);

-- ----------------------------
-- Table structure for item_notice
-- ----------------------------
DROP TABLE IF EXISTS `item_notice`;
CREATE TABLE `item_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `cate_id` int(11) NOT NULL COMMENT '分类ID',
  `infos` text NOT NULL COMMENT '通知摘要',
  `picture` text NOT NULL COMMENT '通知书',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='项目-内部通知';

-- ----------------------------
-- Records of item_notice
-- ----------------------------
INSERT INTO `item_notice` VALUES ('1', '1', '1', '通知摘要内容1', '[\"\\/storage\\/180222\\/c3ldGxfqeU5ZHpGUldKNEf2ybihj1G1TGyHQ6MaS.jpeg\"]', '2018-02-22 17:07:24', '2018-02-22 17:08:10', null);

-- ----------------------------
-- Table structure for item_object
-- ----------------------------
DROP TABLE IF EXISTS `item_object`;
CREATE TABLE `item_object` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `object_id` int(11) NOT NULL COMMENT '其他补偿事项ID',
  `price` decimal(10,2) NOT NULL COMMENT ' 补偿单价',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `object_id` (`object_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='项目-其他补偿事项单价';

-- ----------------------------
-- Records of item_object
-- ----------------------------
INSERT INTO `item_object` VALUES ('1', '1', '1', '200.00', '2018-02-22 16:43:15', '2018-02-22 16:43:15', null);

-- ----------------------------
-- Table structure for item_program
-- ----------------------------
DROP TABLE IF EXISTS `item_program`;
CREATE TABLE `item_program` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `name` varchar(255) NOT NULL COMMENT ' 名称',
  `content` text NOT NULL COMMENT ' 内容',
  `code` char(20) NOT NULL COMMENT '状态代码',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目-征收方案';

-- ----------------------------
-- Records of item_program
-- ----------------------------

-- ----------------------------
-- Table structure for item_public
-- ----------------------------
DROP TABLE IF EXISTS `item_public`;
CREATE TABLE `item_public` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `land_id` int(11) NOT NULL COMMENT ' 地块ID',
  `building_id` int(11) NOT NULL DEFAULT '0' COMMENT ' 楼栋ID，0为地块公共附属物',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `num_unit` varchar(255) NOT NULL COMMENT '计量单位',
  `number` decimal(20,2) NOT NULL COMMENT ' 数量',
  `infos` text,
  `picture` text COMMENT '图片',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='项目-公共附属物';

-- ----------------------------
-- Records of item_public
-- ----------------------------
INSERT INTO `item_public` VALUES ('1', '1', '1', '0', '围墙', '面', '10.00', null, '[\"\\/storage\\/180222\\/pQV935pvcSIZm5mwMSXPr7Wsex8Xx3aP2iKQ8po5.jpeg\"]', '2018-02-22 15:59:58', '2018-02-22 15:59:58', null);
INSERT INTO `item_public` VALUES ('2', '1', '1', '1', '砖', '块', '50.00', null, '[\"\\/storage\\/180222\\/L74CBwrIxTrGxdY7H2tLI8JvfoMVgDWCIxPtVm4x.jpeg\"]', '2018-02-22 16:31:26', '2018-02-22 16:31:26', null);

-- ----------------------------
-- Table structure for item_risk
-- ----------------------------
DROP TABLE IF EXISTS `item_risk`;
CREATE TABLE `item_risk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `agree` tinyint(1) NOT NULL DEFAULT '1' COMMENT ' 征收意见稿态度，0反对，1同意',
  `repay_way` tinyint(1) NOT NULL DEFAULT '0' COMMENT '补偿方式，0货币补偿，1产权调换',
  `house_price` decimal(10,2) DEFAULT NULL COMMENT '产权调换意向-房源单价',
  `house_area` decimal(30,2) DEFAULT NULL COMMENT '产权调换意向-房源面积',
  `house_num` int(11) DEFAULT NULL COMMENT '产权调换意向-房源数量',
  `house_addr` text COMMENT '产权调换意向-房源地址',
  `more_price` decimal(10,2) DEFAULT NULL COMMENT '产权调换意向-增加面积单价',
  `layout_id` int(11) DEFAULT NULL COMMENT '产权调换意向-房源户型ID',
  `transit_way` tinyint(1) DEFAULT '0' COMMENT '过渡方式，0货币过渡，1临时周转房',
  `move_way` tinyint(1) DEFAULT '0' COMMENT '搬迁方式，0自行搬迁，1政府协助',
  `move_fee` decimal(10,2) DEFAULT NULL COMMENT '搬迁补偿',
  `decoration` decimal(10,2) DEFAULT NULL COMMENT '装修补偿',
  `device` decimal(20,2) DEFAULT NULL COMMENT ' 设备拆移费',
  `business` decimal(20,2) DEFAULT NULL COMMENT ' 停产停业损失补偿',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目-社会稳定风险评估';

-- ----------------------------
-- Records of item_risk
-- ----------------------------

-- ----------------------------
-- Table structure for item_risk_report
-- ----------------------------
DROP TABLE IF EXISTS `item_risk_report`;
CREATE TABLE `item_risk_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `name` varchar(255) NOT NULL COMMENT ' 名称',
  `content` text NOT NULL COMMENT ' 内容',
  `picture` text NOT NULL COMMENT ' 图片',
  `agree` tinyint(1) NOT NULL DEFAULT '1' COMMENT '评估结论，0风险高，1风险低',
  `code` char(20) NOT NULL COMMENT '状态代码',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目-风险评估报告';

-- ----------------------------
-- Records of item_risk_report
-- ----------------------------

-- ----------------------------
-- Table structure for item_risk_topic
-- ----------------------------
DROP TABLE IF EXISTS `item_risk_topic`;
CREATE TABLE `item_risk_topic` (
  `risk_id` int(11) NOT NULL COMMENT '风险评估ID',
  `item_id` int(11) NOT NULL COMMENT ' 项目ID',
  `topic_id` int(11) NOT NULL COMMENT ' 话题ID',
  `answer` text COMMENT '答案',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  KEY `risk_id` (`risk_id`),
  KEY `item_id` (`item_id`),
  KEY `topic_id` (`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目-风险评估-自选话题结果';

-- ----------------------------
-- Records of item_risk_topic
-- ----------------------------

-- ----------------------------
-- Table structure for item_subject
-- ----------------------------
DROP TABLE IF EXISTS `item_subject`;
CREATE TABLE `item_subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `subject_id` int(11) NOT NULL COMMENT '重要补偿科目ID',
  `infos` text NOT NULL COMMENT ' 补偿说明',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `subject_id` (`subject_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='项目-补偿科目说明';

-- ----------------------------
-- Records of item_subject
-- ----------------------------
INSERT INTO `item_subject` VALUES ('1', '1', '1', '', '2018-02-22 15:05:40', '2018-02-22 15:05:40', null);
INSERT INTO `item_subject` VALUES ('2', '1', '2', '', '2018-02-22 15:05:40', '2018-02-22 15:05:40', null);
INSERT INTO `item_subject` VALUES ('3', '1', '3', '', '2018-02-22 15:05:40', '2018-02-22 15:05:40', null);
INSERT INTO `item_subject` VALUES ('4', '1', '4', '', '2018-02-22 15:05:40', '2018-02-22 15:05:40', null);
INSERT INTO `item_subject` VALUES ('5', '1', '5', '', '2018-02-22 15:05:40', '2018-02-22 15:05:40', null);

-- ----------------------------
-- Table structure for item_time
-- ----------------------------
DROP TABLE IF EXISTS `item_time`;
CREATE TABLE `item_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `schedule_id` int(11) NOT NULL COMMENT '项目进度ID',
  `start_at` date NOT NULL COMMENT '开始时间',
  `end_at` date NOT NULL COMMENT ' 结束时间',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `schedule_id` (`schedule_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='项目-时间规划';

-- ----------------------------
-- Records of item_time
-- ----------------------------
INSERT INTO `item_time` VALUES ('1', '1', '1', '2018-01-01', '2018-01-15', null, '2018-02-07 09:58:03', null);
INSERT INTO `item_time` VALUES ('2', '1', '2', '2018-01-16', '2018-01-31', null, '2018-02-07 10:00:13', null);
INSERT INTO `item_time` VALUES ('3', '1', '3', '2018-02-01', '2018-02-15', null, '2018-02-07 10:00:28', null);
INSERT INTO `item_time` VALUES ('4', '1', '4', '2018-02-16', '2018-02-28', null, '2018-02-07 10:00:52', null);
INSERT INTO `item_time` VALUES ('5', '1', '5', '2018-03-01', '2018-03-15', null, '2018-02-07 10:01:13', null);
INSERT INTO `item_time` VALUES ('6', '1', '6', '2018-03-16', '2018-03-31', null, '2018-02-07 10:02:34', null);

-- ----------------------------
-- Table structure for item_topic
-- ----------------------------
DROP TABLE IF EXISTS `item_topic`;
CREATE TABLE `item_topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `topic_id` (`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目-自选社会风险评估调查话题';

-- ----------------------------
-- Records of item_topic
-- ----------------------------

-- ----------------------------
-- Table structure for item_user
-- ----------------------------
DROP TABLE IF EXISTS `item_user`;
CREATE TABLE `item_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `schedule_id` int(11) NOT NULL DEFAULT '0' COMMENT '进度ID',
  `process_id` int(11) NOT NULL DEFAULT '0' COMMENT ' 流程ID，【必须】',
  `menu_id` int(11) NOT NULL DEFAULT '0' COMMENT ' 菜单ID',
  `dept_id` int(11) NOT NULL DEFAULT '0' COMMENT ' 部门ID',
  `role_id` int(11) NOT NULL DEFAULT '0' COMMENT '角色ID',
  `user_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `process_id` (`process_id`),
  KEY `menu_id` (`menu_id`),
  KEY `dept_id` (`dept_id`),
  KEY `role_id` (`role_id`),
  KEY `user_id` (`user_id`),
  KEY `schedule_id` (`schedule_id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='项目-流程人员配置';

-- ----------------------------
-- Records of item_user
-- ----------------------------
INSERT INTO `item_user` VALUES ('1', '1', '1', '3', '6', '1', '3', '4', '2018-02-22 16:53:24', '2018-02-22 16:53:24', null);
INSERT INTO `item_user` VALUES ('2', '1', '1', '1', '4', '1', '3', '4', '2018-02-22 16:53:24', '2018-02-22 16:53:24', null);
INSERT INTO `item_user` VALUES ('3', '1', '1', '2', '5', '1', '3', '4', '2018-02-22 16:53:24', '2018-02-22 16:53:24', null);
INSERT INTO `item_user` VALUES ('4', '1', '1', '4', '9', '1', '3', '4', '2018-02-22 16:53:24', '2018-02-22 16:53:24', null);
INSERT INTO `item_user` VALUES ('5', '1', '1', '5', '10', '1', '3', '4', '2018-02-22 16:53:24', '2018-02-22 16:53:24', null);
INSERT INTO `item_user` VALUES ('6', '1', '1', '6', '12', '1', '3', '4', '2018-02-22 16:53:24', '2018-02-22 16:53:24', null);

-- ----------------------------
-- Table structure for item_work_notice
-- ----------------------------
DROP TABLE IF EXISTS `item_work_notice`;
CREATE TABLE `item_work_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL DEFAULT '0' COMMENT '项目ID',
  `schedule_id` int(11) NOT NULL DEFAULT '0' COMMENT '进度ID',
  `process_id` int(11) NOT NULL DEFAULT '0' COMMENT '流程ID',
  `menu_id` int(11) NOT NULL DEFAULT '0' COMMENT ' 菜单 ID',
  `dept_id` int(11) NOT NULL DEFAULT '0' COMMENT '部门ID',
  `parent_id` int(11) NOT NULL COMMENT '角色上级ID',
  `role_id` int(11) NOT NULL DEFAULT '0' COMMENT ' 角色ID',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `url` varchar(255) NOT NULL COMMENT ' 操作链接',
  `code` char(20) NOT NULL COMMENT '状态代码',
  `sign` text COMMENT '签字',
  `infos` text COMMENT '意见',
  `picture` text COMMENT '附件',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `process_id` (`process_id`),
  KEY `menu_id` (`menu_id`),
  KEY `role_id` (`role_id`),
  KEY `user_id` (`user_id`),
  KEY `schedule_id` (`schedule_id`),
  KEY `dept_id` (`dept_id`),
  KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='项目-工作提醒及处理结果';

-- ----------------------------
-- Records of item_work_notice
-- ----------------------------
INSERT INTO `item_work_notice` VALUES ('3', '1', '1', '1', '44', '1', '0', '1', '3', 'http://ts.rms.cn:8008/gov/item_add', '2', null, null, null, '2018-02-23 17:35:06', '2018-02-23 17:35:06', null);
INSERT INTO `item_work_notice` VALUES ('4', '1', '1', '2', '209', '0', '0', '1', '1', 'http://ts.rms.cn:8008/gov/iteminfo_info?item=1', '0', null, null, null, '2018-02-23 17:35:06', '2018-02-24 11:41:17', '2018-02-24 11:41:17');
INSERT INTO `item_work_notice` VALUES ('5', '1', '1', '2', '209', '1', '0', '1', '3', 'http://ts.rms.cn:8008/gov/iteminfo_info?item=1', '2', null, null, null, '2018-02-23 17:35:06', '2018-02-24 11:52:55', null);
INSERT INTO `item_work_notice` VALUES ('6', '1', '1', '2', '209', '1', '2', '3', '4', 'http://ts.rms.cn:8008/gov/iteminfo_info?item=1', '0', null, null, null, '2018-02-23 17:35:06', '2018-02-24 11:41:17', '2018-02-24 11:41:17');
INSERT INTO `item_work_notice` VALUES ('7', '1', '1', '3', '218', '1', '2', '3', '4', 'http://ts.rms.cn:8008/gov/itemprocess_cdc?item=1', '20', null, null, null, '2018-02-24 11:41:17', '2018-02-26 09:36:16', '2018-02-26 09:36:16');
INSERT INTO `item_work_notice` VALUES ('8', '1', '1', '3', '218', '0', '0', '1', '1', 'http://ts.rms.cn:8008/gov/itemprocess_cdc?item=1', '20', null, null, null, '2018-02-24 11:52:55', '2018-02-24 16:42:22', '2018-02-24 16:42:22');
INSERT INTO `item_work_notice` VALUES ('9', '1', '1', '3', '218', '1', '0', '1', '3', 'http://ts.rms.cn:8008/gov/itemprocess_cdc?item=1', '23', null, '驳回', null, '2018-02-24 11:52:55', '2018-02-26 09:36:16', null);
INSERT INTO `item_work_notice` VALUES ('10', '1', '1', '3', '218', '1', '2', '3', '4', 'http://ts.rms.cn:8008/gov/itemprocess_cdc?item=1', '20', null, null, null, '2018-02-24 11:52:55', '2018-02-26 09:36:16', '2018-02-26 09:36:16');
INSERT INTO `item_work_notice` VALUES ('11', '1', '1', '5', '222', '0', '0', '1', '1', 'http://ts.rms.cn:8008/gov/itemprocess_crb?item=1', '0', null, null, null, '2018-02-26 09:36:16', '2018-02-26 10:21:37', '2018-02-26 10:21:37');
INSERT INTO `item_work_notice` VALUES ('12', '1', '1', '5', '222', '1', '0', '1', '3', 'http://ts.rms.cn:8008/gov/itemprocess_crb?item=1', '2', null, null, null, '2018-02-26 09:36:16', '2018-02-26 10:58:59', null);
INSERT INTO `item_work_notice` VALUES ('13', '1', '1', '5', '222', '1', '2', '3', '4', 'http://ts.rms.cn:8008/gov/itemprocess_crb?item=1', '0', null, null, null, '2018-02-26 09:36:16', '2018-02-26 10:21:37', '2018-02-26 10:21:37');
INSERT INTO `item_work_notice` VALUES ('14', '1', '1', '4', '223', '0', '0', '1', '1', 'http://ts.rms.cn:8008/gov/itemprocess_retry?item=1', '0', null, null, null, '2018-02-26 10:58:59', '2018-02-26 10:58:59', null);
INSERT INTO `item_work_notice` VALUES ('15', '1', '1', '4', '223', '1', '0', '1', '3', 'http://ts.rms.cn:8008/gov/itemprocess_retry?item=1', '0', null, null, null, '2018-02-26 10:58:59', '2018-02-26 10:58:59', null);
INSERT INTO `item_work_notice` VALUES ('16', '1', '1', '4', '223', '1', '2', '3', '4', 'http://ts.rms.cn:8008/gov/itemprocess_retry?item=1', '0', null, null, null, '2018-02-26 10:58:59', '2018-02-26 10:58:59', null);

-- ----------------------------
-- Table structure for land_prop
-- ----------------------------
DROP TABLE IF EXISTS `land_prop`;
CREATE TABLE `land_prop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名称',
  `infos` text COMMENT ' 描述',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='土地性质';

-- ----------------------------
-- Records of land_prop
-- ----------------------------
INSERT INTO `land_prop` VALUES ('1', '国有', null, '2018-02-22 15:19:27', '2018-02-22 15:19:27', null);
INSERT INTO `land_prop` VALUES ('2', '集体', null, '2018-02-22 15:19:38', '2018-02-22 15:19:38', null);

-- ----------------------------
-- Table structure for land_source
-- ----------------------------
DROP TABLE IF EXISTS `land_source`;
CREATE TABLE `land_source` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prop_id` int(11) NOT NULL COMMENT '土地性质ID',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `infos` text COMMENT ' 描述',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='土地来源';

-- ----------------------------
-- Records of land_source
-- ----------------------------
INSERT INTO `land_source` VALUES ('1', '1', '出让', null, '2018-02-22 15:20:03', '2018-02-22 15:20:03', null);
INSERT INTO `land_source` VALUES ('2', '1', '划拨', null, '2018-02-22 15:20:16', '2018-02-22 15:20:16', null);
INSERT INTO `land_source` VALUES ('3', '2', '征收', null, '2018-02-22 15:20:33', '2018-02-22 15:20:33', null);

-- ----------------------------
-- Table structure for land_state
-- ----------------------------
DROP TABLE IF EXISTS `land_state`;
CREATE TABLE `land_state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prop_id` int(11) NOT NULL COMMENT '土地性质ID',
  `source_id` int(11) NOT NULL COMMENT '土地来源ID',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `infos` text COMMENT ' 描述',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='土地权益状况';

-- ----------------------------
-- Records of land_state
-- ----------------------------
INSERT INTO `land_state` VALUES ('1', '2', '3', '出租', null, '2018-02-22 15:20:54', '2018-02-22 15:20:54', null);
INSERT INTO `land_state` VALUES ('2', '2', '3', '转让', null, '2018-02-22 15:22:56', '2018-02-22 15:22:56', null);
INSERT INTO `land_state` VALUES ('3', '1', '1', '协议', null, '2018-02-22 15:23:25', '2018-02-22 15:23:25', null);
INSERT INTO `land_state` VALUES ('4', '1', '1', '招标', null, '2018-02-22 15:23:34', '2018-02-22 15:23:34', null);
INSERT INTO `land_state` VALUES ('5', '1', '1', '111', null, '2018-02-24 18:38:31', '2018-02-24 18:38:31', null);

-- ----------------------------
-- Table structure for layout
-- ----------------------------
DROP TABLE IF EXISTS `layout`;
CREATE TABLE `layout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名称【必须，唯一】',
  `infos` text COMMENT ' 描述',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) COMMENT '名称唯一'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='房屋户型';

-- ----------------------------
-- Records of layout
-- ----------------------------
INSERT INTO `layout` VALUES ('1', '一室一厅', null, '2018-02-23 14:49:30', '2018-02-23 14:49:30', null);
INSERT INTO `layout` VALUES ('2', '两室一厅', null, '2018-02-23 14:49:42', '2018-02-23 14:49:42', null);

-- ----------------------------
-- Table structure for log
-- ----------------------------
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL DEFAULT '0' COMMENT '项目ID',
  `schedule_id` int(11) NOT NULL DEFAULT '0' COMMENT '进度ID',
  `process_id` int(11) NOT NULL DEFAULT '0' COMMENT '流程ID',
  `menu_id` int(11) NOT NULL DEFAULT '0' COMMENT '菜单ID，【必须】',
  `dept_id` int(11) NOT NULL DEFAULT '0' COMMENT '部门ID',
  `role_id` int(11) NOT NULL DEFAULT '0' COMMENT '角色ID',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '人员ID，【必须】',
  `infos` text NOT NULL COMMENT '操作描述',
  `created_at` datetime NOT NULL COMMENT '操作时间',
  `action_ip` varchar(255) DEFAULT '' COMMENT ' 操作IP',
  `brower` varchar(255) DEFAULT NULL COMMENT '浏览器',
  `device` varchar(255) DEFAULT NULL COMMENT ' 使用设备',
  `agent` varchar(255) DEFAULT NULL COMMENT ' 代理字符串',
  `url` varchar(255) DEFAULT NULL COMMENT '地址',
  `input` text COMMENT '输入数据',
  `resp` text COMMENT '响应数据',
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`) USING BTREE COMMENT '菜单',
  KEY `user_id` (`user_id`) COMMENT '人员',
  KEY `item_id` (`item_id`) COMMENT '项目ID'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='操作日志';

-- ----------------------------
-- Records of log
-- ----------------------------

-- ----------------------------
-- Table structure for nation
-- ----------------------------
DROP TABLE IF EXISTS `nation`;
CREATE TABLE `nation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名称【必须，唯一】',
  `infos` text COMMENT ' 描述',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) COMMENT '名称唯一'
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='民族';

-- ----------------------------
-- Records of nation
-- ----------------------------
INSERT INTO `nation` VALUES ('1', '土家族', null, '2018-02-24 11:14:07', '2018-02-24 11:14:07', null);
INSERT INTO `nation` VALUES ('2', '汉族', null, '2018-02-24 11:14:15', '2018-02-24 11:14:15', null);

-- ----------------------------
-- Table structure for news
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_id` int(11) NOT NULL COMMENT '分类 ID',
  `item_id` int(11) NOT NULL DEFAULT '0' COMMENT ' 项目ID',
  `name` varchar(255) NOT NULL COMMENT ' 标题',
  `release_at` date NOT NULL COMMENT ' 发布时间',
  `keys` varchar(255) DEFAULT NULL COMMENT ' 关键词',
  `infos` text COMMENT ' 摘要',
  `content` text NOT NULL COMMENT '富文本内容',
  `picture` text NOT NULL COMMENT '扫描件',
  `is_top` tinyint(1) NOT NULL DEFAULT '0' COMMENT ' 是否置顶，0否，1是',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cate_id` (`cate_id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='通知公告';

-- ----------------------------
-- Records of news
-- ----------------------------

-- ----------------------------
-- Table structure for object
-- ----------------------------
DROP TABLE IF EXISTS `object`;
CREATE TABLE `object` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名称【必须，唯一】',
  `num_unit` varchar(255) NOT NULL COMMENT '计量单位',
  `infos` text COMMENT ' 描述',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) COMMENT '名称唯一'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='其他补偿事项';

-- ----------------------------
-- Records of object
-- ----------------------------
INSERT INTO `object` VALUES ('1', '宽带', '条', null, '2018-02-22 16:39:48', '2018-02-22 16:39:48', null);

-- ----------------------------
-- Table structure for pact
-- ----------------------------
DROP TABLE IF EXISTS `pact`;
CREATE TABLE `pact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `household_id` int(11) NOT NULL COMMENT '被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `pay_id` int(11) NOT NULL COMMENT ' 兑付ID',
  `cate_id` int(11) NOT NULL COMMENT ' 协议分类ID',
  `content` longtext NOT NULL COMMENT ' 协议内容',
  `sign_at` date DEFAULT NULL COMMENT ' 签约时间',
  `sign` text COMMENT '被征收人签字',
  `code` char(20) DEFAULT NULL COMMENT '状态代码',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT ' 有效状态，0未生效，1生效，2失效',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`),
  KEY `pay_id` (`pay_id`),
  KEY `cate_id` (`cate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='兑付-协议';

-- ----------------------------
-- Records of pact
-- ----------------------------

-- ----------------------------
-- Table structure for pay
-- ----------------------------
DROP TABLE IF EXISTS `pay`;
CREATE TABLE `pay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT ' 项目ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `repay_way` tinyint(1) NOT NULL DEFAULT '0' COMMENT '补偿方式，0货币补偿，1产权调换',
  `transit_way` tinyint(1) NOT NULL DEFAULT '0' COMMENT '过渡方式，0货币过渡，1临时周转房',
  `move_way` tinyint(1) NOT NULL DEFAULT '0' COMMENT '搬迁方式，0自选搬迁，1政府协助',
  `total` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT '被征户补偿总额',
  `picture` text COMMENT '补偿决定（达不成协议时）',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='兑付-汇总';

-- ----------------------------
-- Records of pay
-- ----------------------------

-- ----------------------------
-- Table structure for pay_building
-- ----------------------------
DROP TABLE IF EXISTS `pay_building`;
CREATE TABLE `pay_building` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT ' 项目ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `assess_id` int(11) NOT NULL COMMENT '评估ID',
  `estate_id` int(11) NOT NULL COMMENT '房产评估ID',
  `household_building_id` int(11) NOT NULL COMMENT '被征收户建筑ID',
  `pay_id` int(11) NOT NULL COMMENT ' 兑付ID',
  `register` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否登记，0否，1是',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态，0合法登记，1待认定，2认定合法，3认定非法，4自行拆除，5转为合法',
  `real_outer` decimal(30,2) NOT NULL COMMENT ' 实际建筑面积',
  `real_use` int(11) NOT NULL COMMENT ' 实际用途ID',
  `struct_id` int(11) NOT NULL COMMENT ' 结构类型ID',
  `direct` varchar(255) NOT NULL COMMENT ' 朝向',
  `floor` int(11) NOT NULL COMMENT ' 楼层',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '评估单价(拆除单价)',
  `amount` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT '评估总价(拆除补助）',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`),
  KEY `assess_id` (`assess_id`),
  KEY `estate_id` (`estate_id`),
  KEY `household_building_id` (`household_building_id`),
  KEY `pay_id` (`pay_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='兑付-建筑';

-- ----------------------------
-- Records of pay_building
-- ----------------------------

-- ----------------------------
-- Table structure for pay_crowd
-- ----------------------------
DROP TABLE IF EXISTS `pay_crowd`;
CREATE TABLE `pay_crowd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT ' 项目ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `pay_id` int(11) NOT NULL COMMENT '兑付ID',
  `pay_subject_id` int(11) NOT NULL COMMENT ' 兑付重要补偿科目ID',
  `item_subject_id` int(11) NOT NULL COMMENT ' 项目重要补偿科目ID',
  `subject_id` int(11) NOT NULL COMMENT '重要补偿科目ID',
  `item_crowd_id` int(11) NOT NULL COMMENT ' 项目特殊人群ID',
  `member_crowd_id` int(11) NOT NULL COMMENT ' 被征收户特殊人群ID',
  `crowd_cate_id` int(11) NOT NULL COMMENT ' 特殊人群分类ID',
  `crowd_id` int(11) NOT NULL COMMENT ' 特殊人群ID',
  `transit` decimal(30,2) NOT NULL COMMENT ' 临时安置费',
  `rate` decimal(10,0) NOT NULL COMMENT ' 上浮率（%）',
  `amount` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT '上浮金额',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`),
  KEY `pay_id` (`pay_id`),
  KEY `pay_subject_id` (`pay_subject_id`),
  KEY `item_subject_id` (`item_subject_id`),
  KEY `subject_id` (`subject_id`),
  KEY `item_crowd_id` (`item_crowd_id`),
  KEY `member_crowd_id` (`member_crowd_id`),
  KEY `crowd_cate_id` (`crowd_cate_id`),
  KEY `crowd_id` (`crowd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='兑付-临时安置费特殊人群上浮';

-- ----------------------------
-- Records of pay_crowd
-- ----------------------------

-- ----------------------------
-- Table structure for pay_house
-- ----------------------------
DROP TABLE IF EXISTS `pay_house`;
CREATE TABLE `pay_house` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT ' 项目ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `house_id` int(11) NOT NULL COMMENT '房源ID',
  `area` decimal(20,2) NOT NULL COMMENT '面积',
  `market` decimal(10,2) NOT NULL COMMENT ' 市场评估价',
  `price` decimal(10,2) NOT NULL COMMENT ' 安置优惠价',
  `amount` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT '安置优惠总价',
  `amount_plus` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT '优惠上浮总额',
  `total` decimal(30,2) NOT NULL COMMENT '房源安置总值',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`),
  KEY `house_id` (`house_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='兑付-安置房';

-- ----------------------------
-- Records of pay_house
-- ----------------------------

-- ----------------------------
-- Table structure for pay_house_plus
-- ----------------------------
DROP TABLE IF EXISTS `pay_house_plus`;
CREATE TABLE `pay_house_plus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT ' 项目ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `house_id` int(11) NOT NULL COMMENT '房源ID',
  `pay_house_id` int(11) NOT NULL COMMENT '兑付安置房ID',
  `start` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '上浮面积起',
  `end` decimal(10,2) DEFAULT '0.00' COMMENT '上浮面积止,（0为市场评估价上浮）',
  `area` decimal(20,2) NOT NULL COMMENT '上浮面积',
  `market` decimal(10,2) NOT NULL COMMENT '市场评估价',
  `price` decimal(10,2) NOT NULL COMMENT ' 安置优惠价',
  `rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '上浮比例（%）',
  `agio` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场评估与安置优惠差价',
  `amount` decimal(30,2) NOT NULL COMMENT '上浮金额',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`),
  KEY `house_id` (`house_id`),
  KEY `pay_house_id` (`pay_house_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='兑付-安置房上浮';

-- ----------------------------
-- Records of pay_house_plus
-- ----------------------------

-- ----------------------------
-- Table structure for pay_object
-- ----------------------------
DROP TABLE IF EXISTS `pay_object`;
CREATE TABLE `pay_object` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT ' 项目ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `household_obj_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `item_object_id` int(11) NOT NULL COMMENT '项目其他补偿事项ID',
  `object_id` int(11) NOT NULL DEFAULT '0' COMMENT '其他补偿事项ID',
  `pay_id` int(11) NOT NULL COMMENT '兑付ID',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `num_unit` varchar(255) NOT NULL COMMENT '计量单位',
  `number` int(11) NOT NULL DEFAULT '1' COMMENT '数量',
  `price` decimal(10,2) NOT NULL COMMENT '补偿单价',
  `amount` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT '补偿总价',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`),
  KEY `household_obj_id` (`household_obj_id`),
  KEY `item_object_id` (`item_object_id`),
  KEY `object_id` (`object_id`),
  KEY `pay_id` (`pay_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='兑付-其他补偿事项';

-- ----------------------------
-- Records of pay_object
-- ----------------------------

-- ----------------------------
-- Table structure for pay_public
-- ----------------------------
DROP TABLE IF EXISTS `pay_public`;
CREATE TABLE `pay_public` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT ' 项目ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL DEFAULT '0' COMMENT ' 楼栋ID',
  `item_public_id` int(11) NOT NULL COMMENT '项目公共附属物ID',
  `com_public_id` int(11) NOT NULL COMMENT '评估公共附属物ID',
  `com_pub_detail_id` int(11) NOT NULL COMMENT '评估公共附属物明细ID',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `num_unit` varchar(255) NOT NULL COMMENT '计量单位',
  `number` decimal(20,2) NOT NULL COMMENT ' 数量',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '评估单价',
  `amount` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT ' 评估总价',
  `household` int(11) NOT NULL DEFAULT '1' COMMENT '平分户数',
  `avg` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT ' 平均补偿',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`),
  KEY `item_public_id` (`item_public_id`),
  KEY `com_public_id` (`com_public_id`),
  KEY `com_pub_detail_id` (`com_pub_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='兑付-公共附属物';

-- ----------------------------
-- Records of pay_public
-- ----------------------------

-- ----------------------------
-- Table structure for pay_reserve
-- ----------------------------
DROP TABLE IF EXISTS `pay_reserve`;
CREATE TABLE `pay_reserve` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT ' 项目ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `pay_id` int(11) NOT NULL COMMENT '兑付ID',
  `control_id` int(11) NOT NULL COMMENT '项目控制ID（选房）',
  `serial` char(1) NOT NULL COMMENT '序列',
  `number` int(11) NOT NULL COMMENT ' 预约号',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`),
  KEY `pay_id` (`pay_id`),
  KEY `reserve_id` (`control_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='兑付-选房预约号';

-- ----------------------------
-- Records of pay_reserve
-- ----------------------------

-- ----------------------------
-- Table structure for pay_subject
-- ----------------------------
DROP TABLE IF EXISTS `pay_subject`;
CREATE TABLE `pay_subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT ' 项目ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `pay_id` int(11) NOT NULL COMMENT '兑付ID',
  `pact_id` int(11) NOT NULL DEFAULT '0' COMMENT '协议ID',
  `item_subject_id` int(11) NOT NULL COMMENT '项目重要补偿科目ID',
  `subject_id` int(11) NOT NULL COMMENT '重要补偿科目 ID',
  `total_id` int(11) NOT NULL DEFAULT '0' COMMENT '兑付总单ID',
  `calculate` text COMMENT '计算公式',
  `amount` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT '补偿小计',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '兑付状态，0未兑付，1签约，2兑付中，3已兑付',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`),
  KEY `pay_id` (`pay_id`),
  KEY `item_subject_id` (`item_subject_id`),
  KEY `subject_id` (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='兑付-科目';

-- ----------------------------
-- Records of pay_subject
-- ----------------------------

-- ----------------------------
-- Table structure for pay_transit
-- ----------------------------
DROP TABLE IF EXISTS `pay_transit`;
CREATE TABLE `pay_transit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT ' 项目ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `pay_id` int(11) NOT NULL COMMENT '兑付ID',
  `pact_id` int(11) NOT NULL DEFAULT '0' COMMENT '协议ID',
  `house_id` int(11) NOT NULL COMMENT '房源ID',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`),
  KEY `house_id` (`house_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='兑付-临时周转房';

-- ----------------------------
-- Records of pay_transit
-- ----------------------------

-- ----------------------------
-- Table structure for pay_unit
-- ----------------------------
DROP TABLE IF EXISTS `pay_unit`;
CREATE TABLE `pay_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT ' 项目ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `unit_id` int(11) NOT NULL COMMENT ' 公产单位ID',
  `pay_id` int(11) NOT NULL COMMENT '兑付ID',
  `pact_id` int(11) NOT NULL DEFAULT '0' COMMENT '公产单位协议ID',
  `total_id` int(11) NOT NULL DEFAULT '0' COMMENT '兑付总单ID',
  `calculate` text NOT NULL COMMENT '计算公式',
  `amount` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT '补偿小计',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '兑付状态，0未兑付，1签约，2兑付中，3已兑付',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `pay_id` (`pay_id`),
  KEY `unit_id` (`unit_id`) USING BTREE,
  KEY `pact_id` (`pact_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='兑付-公产单位';

-- ----------------------------
-- Records of pay_unit
-- ----------------------------

-- ----------------------------
-- Table structure for pay_unit_pact
-- ----------------------------
DROP TABLE IF EXISTS `pay_unit_pact`;
CREATE TABLE `pay_unit_pact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `unit_id` int(11) NOT NULL COMMENT '公产单位ID',
  `cate_id` int(11) NOT NULL COMMENT ' 协议分类ID',
  `content` longtext NOT NULL COMMENT ' 协议内容',
  `sign_at` date DEFAULT NULL COMMENT ' 签约时间',
  `sign` text COMMENT '公产单位签字',
  `code` char(20) DEFAULT NULL COMMENT '状态代码',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT ' 有效状态，0未生效，1生效，2失效',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `cate_id` (`cate_id`),
  KEY `unit_id` (`unit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='兑付-公产单位协议';

-- ----------------------------
-- Records of pay_unit_pact
-- ----------------------------

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上級ID，【必须】',
  `name` varchar(255) NOT NULL COMMENT ' 名称，【必须，唯一】',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型，0普通，1管理员',
  `infos` text COMMENT '描述',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE COMMENT '名称唯一',
  KEY `parent_id` (`parent_id`) COMMENT '上级ID'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='权限与角色';

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES ('1', '0', '超级管理员', '1', '内置超级管理员', '2018-02-03 10:41:50', '2018-02-03 10:41:50', null);
INSERT INTO `role` VALUES ('2', '0', '主管', '1', '房屋征收补偿管理中心主管', '2018-02-03 10:42:13', '2018-02-03 10:43:59', null);
INSERT INTO `role` VALUES ('3', '2', '分管', '1', null, '2018-02-03 11:39:22', '2018-02-03 11:39:22', null);
INSERT INTO `role` VALUES ('4', '3', '安置股长', '1', null, '2018-02-03 14:53:19', '2018-02-03 14:53:19', null);
INSERT INTO `role` VALUES ('5', '3', '账务股长', '1', null, '2018-02-03 14:56:10', '2018-02-03 14:56:10', null);

-- ----------------------------
-- Table structure for role_menu
-- ----------------------------
DROP TABLE IF EXISTS `role_menu`;
CREATE TABLE `role_menu` (
  `role_id` int(11) NOT NULL COMMENT '角色ID，【必须】',
  `menu_id` int(11) NOT NULL COMMENT '菜单ID，【必须】',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  UNIQUE KEY `role_menu` (`role_id`,`menu_id`) COMMENT '角色-菜单',
  KEY `role_id` (`role_id`) COMMENT '角色',
  KEY `menu_id` (`menu_id`) COMMENT ' 菜单'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限与角色-授权菜单';

-- ----------------------------
-- Records of role_menu
-- ----------------------------
INSERT INTO `role_menu` VALUES ('1', '209', null, null);
INSERT INTO `role_menu` VALUES ('1', '218', null, null);
INSERT INTO `role_menu` VALUES ('1', '222', null, null);
INSERT INTO `role_menu` VALUES ('1', '223', null, null);
INSERT INTO `role_menu` VALUES ('2', '39', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '40', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '41', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '42', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '43', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '44', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '45', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '46', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '47', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '48', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '49', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '50', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '51', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '52', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '56', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '57', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '58', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '59', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '60', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '61', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '62', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '63', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '64', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '65', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '66', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '67', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '68', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '72', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '73', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '74', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '75', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '76', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '77', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '78', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '79', '2018-02-11 13:39:18', '2018-02-11 13:39:18');
INSERT INTO `role_menu` VALUES ('2', '209', null, null);
INSERT INTO `role_menu` VALUES ('2', '218', null, null);
INSERT INTO `role_menu` VALUES ('2', '222', null, null);
INSERT INTO `role_menu` VALUES ('2', '223', null, null);
INSERT INTO `role_menu` VALUES ('3', '209', null, null);
INSERT INTO `role_menu` VALUES ('3', '218', null, null);
INSERT INTO `role_menu` VALUES ('3', '222', null, null);
INSERT INTO `role_menu` VALUES ('3', '223', null, null);
INSERT INTO `role_menu` VALUES ('4', '209', null, null);
INSERT INTO `role_menu` VALUES ('4', '218', null, null);
INSERT INTO `role_menu` VALUES ('4', '222', null, null);
INSERT INTO `role_menu` VALUES ('4', '223', null, null);
INSERT INTO `role_menu` VALUES ('5', '209', null, null);
INSERT INTO `role_menu` VALUES ('5', '218', null, null);
INSERT INTO `role_menu` VALUES ('5', '222', null, null);
INSERT INTO `role_menu` VALUES ('5', '223', null, null);

-- ----------------------------
-- Table structure for tear
-- ----------------------------
DROP TABLE IF EXISTS `tear`;
CREATE TABLE `tear` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `sign_at` date NOT NULL COMMENT '委托时间',
  `picture` text COMMENT '委托合同',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态，0未开始，1拆除中，2拆除完成',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='拆除委托';

-- ----------------------------
-- Records of tear
-- ----------------------------

-- ----------------------------
-- Table structure for tear_detail
-- ----------------------------
DROP TABLE IF EXISTS `tear_detail`;
CREATE TABLE `tear_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `tear_id` int(11) NOT NULL COMMENT '拆除ID',
  `picture` text NOT NULL COMMENT '拆除图片',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='拆除-详细过程';

-- ----------------------------
-- Records of tear_detail
-- ----------------------------

-- ----------------------------
-- Table structure for topic
-- ----------------------------
DROP TABLE IF EXISTS `topic`;
CREATE TABLE `topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名称【必须，唯一】',
  `infos` text COMMENT ' 描述',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) COMMENT '名称唯一'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='社会风险评估调查话题';

-- ----------------------------
-- Records of topic
-- ----------------------------
INSERT INTO `topic` VALUES ('1', '调查话题1', null, '2018-02-22 17:17:23', '2018-02-22 17:17:23', null);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_id` int(11) NOT NULL DEFAULT '0' COMMENT '部门ID',
  `role_id` int(11) NOT NULL COMMENT '角色ID，【必须】',
  `username` varchar(255) NOT NULL COMMENT '用户名，【必须，唯一】',
  `password` varchar(255) NOT NULL COMMENT '登录密码，【必须，唯一】',
  `secret` varchar(255) NOT NULL COMMENT '用户密钥，【必须，唯一】',
  `name` varchar(255) NOT NULL COMMENT '姓名',
  `phone` char(20) DEFAULT NULL COMMENT '电话，',
  `email` varchar(255) DEFAULT NULL COMMENT '邮箱',
  `infos` text COMMENT '描述',
  `login_at` datetime DEFAULT NULL COMMENT '最近登录时间',
  `login_ip` varchar(255) DEFAULT NULL COMMENT '最近登录IP',
  `session` varchar(255) DEFAULT NULL COMMENT '登录sessionID',
  `action_at` datetime DEFAULT NULL COMMENT '最后操作时间',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE COMMENT '用户名唯一',
  UNIQUE KEY `secret` (`secret`) COMMENT '用户密钥唯一',
  KEY `role_id` (`role_id`) COMMENT '角色',
  KEY `dept_id` (`dept_id`) COMMENT ' 部门',
  KEY `session` (`session`) COMMENT '登录sessionID'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='人员管理';

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', '0', '1', 'demo', 'eyJpdiI6ImhOTm1oa3JHQzduR2JqbzdLY1NEckE9PSIsInZhbHVlIjoiTlpaTFVmdjlNbUFLMjN2Q3hzYW1RZz09IiwibWFjIjoiYzc3M2VhZWEyYjg5NTMzYjMyNmFmNjg2ZDNiNjIyMjMwOTYyZjMxMzlhZDE5MWJmNDIxMTUxNzZjYzk4YjRlNSJ9', '0860480D-B2FB-C834-2336-F4A9B0DB5AA9', '测试演示账号', null, null, null, '2018-02-26 09:04:12', '127.0.0.1', 'KTO1zA28ThcJC29ZFNzTMWhqOZMq1jo1LjH5Nolr', '2018-02-26 10:32:35', '2018-02-05 09:38:29', '2018-02-26 10:32:35', null);
INSERT INTO `user` VALUES ('3', '1', '1', 'admin', 'eyJpdiI6IlpzbzB5UUJvc2d6dWZSVlZvQmtIWXc9PSIsInZhbHVlIjoiclM5WkdYVk1sc0FQZ1lzbHRwVnY1dz09IiwibWFjIjoiMzNiNjZiYWZiMjEyZjAwNDkyMzFjZDEwN2I1Mzk3ZWJhNmRkYWMyZmE1MjQ2M2RmOWJiOTE5ODgxMjQzM2QwOCJ9', '0860480D-B2FB-C834-2336-F4A9B0DB5AA8', '我是主管', null, null, null, '2018-02-26 08:48:34', '127.0.0.1', 'yDw6xuwnzncGPMpQZ6GaLpolMzYhMMYgId7EWeot', '2018-02-26 11:22:47', '2018-02-05 09:38:29', '2018-02-26 11:22:47', null);
INSERT INTO `user` VALUES ('4', '1', '3', 'user', 'eyJpdiI6ImhOTm1oa3JHQzduR2JqbzdLY1NEckE9PSIsInZhbHVlIjoiTlpaTFVmdjlNbUFLMjN2Q3hzYW1RZz09IiwibWFjIjoiYzc3M2VhZWEyYjg5NTMzYjMyNmFmNjg2ZDNiNjIyMjMwOTYyZjMxMzlhZDE5MWJmNDIxMTUxNzZjYzk4YjRlNSJ9', '0860480D-B2FB-C834-2336-F4A9B0DB5AA1', '分管', null, null, null, '2018-02-11 14:53:53', '127.0.0.1', 'xpqasUo0jZY12LoGRgUQmSHThFHlOg8BHh0BN1W8', '2018-02-11 14:54:37', '2018-02-05 09:38:29', '2018-02-11 14:54:37', null);
