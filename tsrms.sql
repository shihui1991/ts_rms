/*
Navicat MySQL Data Transfer

Source Server         : 192.168.1.88
Source Server Version : 50553
Source Host           : 192.168.1.88:3306
Source Database       : tsrms

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-03-14 18:48:36
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin_unit
-- ----------------------------
DROP TABLE IF EXISTS `admin_unit`;
CREATE TABLE `admin_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名称',
  `address` varchar(255) NOT NULL COMMENT '地址',
  `phone` char(20) NOT NULL COMMENT ' 电话',
  `contact_man` varchar(255) NOT NULL COMMENT ' 联系人',
  `contact_tel` char(20) NOT NULL COMMENT ' 联系电话',
  `infos` text COMMENT '描述',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='公房单位';

-- ----------------------------
-- Records of admin_unit
-- ----------------------------
INSERT INTO `admin_unit` VALUES ('1', '公产单位1', '渝北区', '023-88888888', '张三', '13012345678', null, '2018-02-22 15:25:24', '2018-02-22 15:25:24', null);
INSERT INTO `admin_unit` VALUES ('2', '公产单位2', '渝北', '12135465', '张是', '1221454', '21321', '2018-03-09 15:15:02', '2018-03-09 15:15:02', null);

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
INSERT INTO `a_control_cate` VALUES ('3', '选房时间', null, '2018-02-09 15:10:21', '2018-03-12 17:36:04', null);

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
) ENGINE=MyISAM AUTO_INCREMENT=363 DEFAULT CHARSET=utf8 COMMENT='功能与菜单';

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
INSERT INTO `a_menu` VALUES ('30', '0', '状态代码', '<i class=\"menu-icon fa fa-code bigger-120\"></i>', '4', '/sys/statecode', null, '1', '1', '1', '0', null, '2018-02-10 09:37:55', '2018-02-27 16:21:13', null);
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
INSERT INTO `a_menu` VALUES ('53', '39', '工作详情', '<i class=\"menu-icon fa fa-comments bigger-120\"></i>', '0', '/gov/infos', null, '1', '0', '0', '0', null, '2018-02-10 14:01:05', '2018-03-01 10:17:26', null);
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
INSERT INTO `a_menu` VALUES ('93', '89', '评估机构(操作员)', null, '0', '/gov/companyuser', null, '1', '1', '0', '0', null, '2018-02-22 10:12:04', '2018-02-22 10:12:04', null);
INSERT INTO `a_menu` VALUES ('94', '93', '添加操作员', null, '0', '/gov/companyuser_add', null, '1', '1', '0', '0', null, '2018-02-22 10:13:02', '2018-02-22 10:13:02', null);
INSERT INTO `a_menu` VALUES ('95', '93', '操作员详情', null, '0', '/gov/companyuser_info', null, '1', '1', '0', '0', null, '2018-02-22 10:13:52', '2018-02-22 10:13:52', null);
INSERT INTO `a_menu` VALUES ('96', '93', '修改操作员', null, '0', '/gov/companyuser_edit', null, '1', '1', '0', '0', null, '2018-02-22 10:14:31', '2018-02-22 10:14:31', null);
INSERT INTO `a_menu` VALUES ('97', '89', '评估机构(评估师)', null, '0', '/gov/companyvaluer', null, '1', '1', '0', '0', null, '2018-02-22 10:15:40', '2018-02-22 10:15:40', null);
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
INSERT INTO `a_menu` VALUES ('259', '257', '修改初步预算', null, '0', '/gov/initbudget_edit', null, '1', '1', '0', '0', null, '2018-03-01 13:46:43', '2018-03-01 13:46:43', null);
INSERT INTO `a_menu` VALUES ('150', '147', '修改土地性质', null, '0', '/gov/landprop_edit', null, '1', '1', '0', '0', null, '2018-02-22 11:38:13', '2018-02-22 11:38:13', null);
INSERT INTO `a_menu` VALUES ('152', '147', '添加土地来源', null, '0', '/gov/landsource_add', null, '1', '1', '0', '0', null, '2018-02-22 11:40:53', '2018-02-22 11:40:53', null);
INSERT INTO `a_menu` VALUES ('260', '173', '添加社会稳定风险评估报告', null, '0', '/gov/itemriskreport_add', null, '1', '1', '0', '0', null, '2018-03-01 14:05:53', '2018-03-01 16:54:00', null);
INSERT INTO `a_menu` VALUES ('154', '147', '修改土地来源', null, '0', '/gov/landsource_edit', null, '1', '1', '0', '0', null, '2018-02-22 11:43:39', '2018-02-22 11:43:39', null);
INSERT INTO `a_menu` VALUES ('261', '173', '修改社会稳定风险评估报告', null, '0', '/gov/itemriskreport_edit', null, '1', '1', '0', '0', null, '2018-03-01 14:06:34', '2018-03-01 19:08:04', null);
INSERT INTO `a_menu` VALUES ('156', '147', '添加土地权益状况', null, '0', '/gov/landstate_add', null, '1', '1', '0', '0', null, '2018-02-22 11:46:17', '2018-02-22 11:46:17', null);
INSERT INTO `a_menu` VALUES ('158', '147', '修改土地权益状况', null, '0', '/gov/landstate_edit', null, '1', '1', '0', '0', null, '2018-02-22 11:49:39', '2018-02-22 11:49:39', null);
INSERT INTO `a_menu` VALUES ('159', '40', '调查建档', null, '0', '/gov/itemland#', null, '1', '1', '1', '0', null, '2018-02-22 13:41:45', '2018-02-22 15:09:40', null);
INSERT INTO `a_menu` VALUES ('160', '159', '项目地块', null, '0', '/gov/itemland', null, '1', '1', '1', '0', null, '2018-02-22 13:43:51', '2018-02-22 13:43:51', null);
INSERT INTO `a_menu` VALUES ('161', '160', '添加项目地块', null, '0', '/gov/itemland_add', null, '1', '1', '0', '0', null, '2018-02-22 13:44:53', '2018-02-22 13:44:53', null);
INSERT INTO `a_menu` VALUES ('162', '160', '项目地块详情', null, '0', '/gov/itemland_info', null, '1', '1', '0', '0', null, '2018-02-22 13:46:17', '2018-02-22 13:46:17', null);
INSERT INTO `a_menu` VALUES ('163', '160', '修改项目地块', null, '0', '/gov/itemland_edit', null, '1', '1', '0', '0', null, '2018-02-22 13:47:07', '2018-02-22 13:47:07', null);
INSERT INTO `a_menu` VALUES ('164', '160', '地块楼栋', null, '0', '/gov/itembuilding', null, '1', '1', '0', '0', null, '2018-02-22 13:48:08', '2018-03-02 15:10:42', null);
INSERT INTO `a_menu` VALUES ('165', '164', '添加地块楼栋', null, '0', '/gov/itembuilding_add', null, '1', '1', '0', '0', null, '2018-02-22 13:49:47', '2018-02-22 13:49:47', null);
INSERT INTO `a_menu` VALUES ('166', '164', '地块楼栋详情', null, '0', '/gov/itembuilding_info', null, '1', '1', '0', '0', null, '2018-02-22 13:50:40', '2018-02-22 13:50:40', null);
INSERT INTO `a_menu` VALUES ('167', '164', '修改地块楼栋', null, '0', '/gov/itembuilding_edit', null, '1', '1', '0', '0', null, '2018-02-22 13:51:42', '2018-02-22 13:51:42', null);
INSERT INTO `a_menu` VALUES ('168', '160', '公共附属物', null, '0', '/gov/itempublic', null, '1', '1', '0', '0', null, '2018-02-22 13:53:25', '2018-03-02 15:11:01', null);
INSERT INTO `a_menu` VALUES ('169', '168', '添加公共附属物', null, '0', '/gov/itempublic_add', null, '1', '1', '0', '0', null, '2018-02-22 13:55:53', '2018-02-22 13:55:53', null);
INSERT INTO `a_menu` VALUES ('170', '168', '公共附属物详情', null, '0', '/gov/itempublic_info', null, '1', '1', '0', '0', null, '2018-02-22 14:00:59', '2018-02-22 14:00:59', null);
INSERT INTO `a_menu` VALUES ('171', '168', '修改公共附属物', null, '0', '/gov/itempublic_edit', null, '1', '1', '0', '0', null, '2018-02-22 14:02:04', '2018-02-22 14:02:04', null);
INSERT INTO `a_menu` VALUES ('172', '40', '征收决定', null, '0', '/gov/itemdraft#', null, '1', '1', '1', '0', null, '2018-02-22 14:04:50', '2018-03-05 18:38:59', null);
INSERT INTO `a_menu` VALUES ('173', '172', '社会风险评估报告', null, '0', '/gov/itemriskreport', null, '1', '1', '1', '0', null, '2018-02-22 14:06:05', '2018-03-01 16:53:25', null);
INSERT INTO `a_menu` VALUES ('174', '173', '自选社会风险评估调查话题', null, '0', '/gov/itemtopic', null, '1', '1', '1', '0', null, '2018-02-22 14:06:35', '2018-02-22 14:06:35', null);
INSERT INTO `a_menu` VALUES ('175', '174', '添加自选社会风险评估调查话题', null, '0', '/gov/itemtopic_add', null, '1', '1', '0', '0', null, '2018-02-22 14:07:55', '2018-02-22 14:07:55', null);
INSERT INTO `a_menu` VALUES ('176', '174', '自选社会风险评估调查话题详情', null, '0', '/gov/itemtopic_info', null, '1', '1', '0', '0', null, '2018-02-22 14:08:46', '2018-02-22 14:08:46', null);
INSERT INTO `a_menu` VALUES ('177', '174', '修改自选社会风险评估调查话题', null, '0', '/gov/itemtopic_edit', null, '1', '1', '0', '0', null, '2018-02-22 14:10:01', '2018-02-22 14:10:01', null);
INSERT INTO `a_menu` VALUES ('178', '172', '其他补偿事项单价', null, '0', '/gov/itemobject', null, '1', '1', '1', '0', null, '2018-02-22 14:13:20', '2018-02-22 14:13:20', null);
INSERT INTO `a_menu` VALUES ('179', '178', '添加其他补偿事项单价', null, '0', '/gov/itemobject_add', null, '1', '1', '0', '0', null, '2018-02-22 14:14:44', '2018-02-22 14:14:44', null);
INSERT INTO `a_menu` VALUES ('180', '178', '其他补偿事项单价详情', null, '0', '/gov/itemobject_info', null, '1', '1', '0', '0', null, '2018-02-22 14:15:31', '2018-02-22 14:15:31', null);
INSERT INTO `a_menu` VALUES ('181', '178', '修改其他补偿事项单价', null, '0', '/gov/itemobject_edit', null, '1', '1', '0', '0', null, '2018-02-22 14:16:31', '2018-02-22 14:16:31', null);
INSERT INTO `a_menu` VALUES ('182', '172', '补偿科目说明', null, '0', '/gov/itemsubject', null, '1', '1', '1', '0', null, '2018-02-22 14:18:08', '2018-02-22 14:18:08', null);
INSERT INTO `a_menu` VALUES ('183', '182', '添加补偿科目说明', null, '0', '/gov/itemsubject_add', null, '1', '1', '0', '0', null, '2018-02-22 14:18:58', '2018-02-22 14:18:58', null);
INSERT INTO `a_menu` VALUES ('184', '182', '补偿科目说明详情', null, '0', '/gov/itemsubject_info', null, '1', '1', '0', '0', null, '2018-02-22 14:20:15', '2018-02-22 14:20:15', null);
INSERT INTO `a_menu` VALUES ('185', '182', '修改补偿科目说明', null, '0', '/gov/itemsubject_edit', null, '1', '1', '0', '0', null, '2018-02-22 14:21:39', '2018-02-22 14:21:39', null);
INSERT INTO `a_menu` VALUES ('186', '40', '通知公告', null, '0', '/gov/itemnotice#', null, '1', '1', '1', '0', null, '2018-02-22 14:24:46', '2018-02-22 14:24:46', null);
INSERT INTO `a_menu` VALUES ('187', '186', '内部通知', null, '0', '/gov/itemnotice', null, '1', '1', '1', '0', null, '2018-02-22 14:26:35', '2018-03-02 09:08:23', null);
INSERT INTO `a_menu` VALUES ('188', '187', '添加内部通知', null, '0', '/gov/itemnotice_add', null, '1', '1', '0', '0', null, '2018-02-22 14:27:37', '2018-02-22 14:27:37', null);
INSERT INTO `a_menu` VALUES ('189', '187', '内部通知详情', null, '0', '/gov/itemnotice_info', null, '1', '1', '0', '0', null, '2018-02-22 14:29:02', '2018-02-22 14:29:02', null);
INSERT INTO `a_menu` VALUES ('190', '187', '修改内部通知', null, '0', '/gov/itemnotice_edit', null, '1', '1', '0', '0', null, '2018-02-22 14:29:56', '2018-02-22 14:29:56', null);
INSERT INTO `a_menu` VALUES ('191', '192', '添加征收方案', null, '0', '/gov/itemprogram_add', null, '1', '1', '0', '0', null, '2018-02-22 14:33:24', '2018-02-22 14:33:24', null);
INSERT INTO `a_menu` VALUES ('192', '172', '征收方案', null, '0', '/gov/itemprogram_info', null, '1', '1', '1', '0', null, '2018-02-22 14:34:52', '2018-03-05 18:36:02', null);
INSERT INTO `a_menu` VALUES ('193', '192', '修改征收方案', null, '0', '/gov/itemprogram_edit', null, '1', '1', '0', '0', null, '2018-02-22 14:35:55', '2018-02-22 14:35:55', null);
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
INSERT INTO `a_menu` VALUES ('209', '207', '提交部门审查（项目审查）', null, '0', '/gov/check_to_dept_check', null, '1', '1', '0', '0', null, '2018-02-23 11:58:55', '2018-02-23 11:58:55', null);
INSERT INTO `a_menu` VALUES ('210', '203', '修改被征收户', null, '0', '/gov/householddetail_edit', null, '1', '1', '0', '0', null, '2018-02-23 18:18:16', '2018-02-23 18:18:16', null);
INSERT INTO `a_menu` VALUES ('211', '159', '入户摸底', null, '0', '/gov/householddetail', null, '1', '1', '1', '0', null, '2018-02-24 09:01:14', '2018-02-26 09:48:08', null);
INSERT INTO `a_menu` VALUES ('212', '211', '被征户账号', null, '0', '/gov/household', null, '1', '1', '1', '0', null, '2018-02-24 09:16:21', '2018-02-24 09:16:21', null);
INSERT INTO `a_menu` VALUES ('214', '211', '家庭成员', null, '0', '/gov/householdmember', null, '1', '1', '1', '0', null, '2018-02-24 10:18:31', '2018-02-24 10:18:31', null);
INSERT INTO `a_menu` VALUES ('215', '214', '添加家庭成员', null, '0', '/gov/householdmember_add', null, '1', '1', '0', '0', null, '2018-02-24 10:26:47', '2018-02-24 10:26:47', null);
INSERT INTO `a_menu` VALUES ('216', '214', '家庭成员详情', null, '0', '/gov/householdmember_info', null, '1', '1', '0', '0', null, '2018-02-24 10:27:24', '2018-02-24 10:27:24', null);
INSERT INTO `a_menu` VALUES ('217', '216', '修改家庭成员', null, '0', '/gov/householdmember_edit', null, '1', '1', '0', '0', null, '2018-02-24 10:28:21', '2018-02-24 10:28:21', null);
INSERT INTO `a_menu` VALUES ('218', '207', '部门审查（项目审查）', null, '0', '/gov/check_dept_check', null, '1', '1', '0', '0', null, '2018-02-24 11:39:45', '2018-02-24 11:39:45', null);
INSERT INTO `a_menu` VALUES ('219', '216', '添加特殊人群', null, '0', '/gov/householdmembercrowd_add', null, '1', '1', '0', '0', null, '2018-02-24 16:23:19', '2018-02-24 16:23:19', null);
INSERT INTO `a_menu` VALUES ('220', '216', '特殊人群信息', null, '0', '/gov/householdmembercrowd_info', null, '1', '1', '0', '0', null, '2018-02-24 16:32:59', '2018-02-24 16:34:59', null);
INSERT INTO `a_menu` VALUES ('221', '220', '修改特殊人群', null, '0', '/gov/householdmembercrowd_edit', null, '1', '1', '0', '0', null, '2018-02-24 16:34:17', '2018-02-24 16:34:17', null);
INSERT INTO `a_menu` VALUES ('222', '207', '审查驳回处理（项目审查）', null, '0', '/gov/check_roll_back', null, '1', '1', '0', '0', null, '2018-02-24 18:17:24', '2018-02-24 18:18:20', null);
INSERT INTO `a_menu` VALUES ('223', '207', '重新提交审查资料（项目审查）', null, '0', '/gov/check_iteminfo_retry', null, '1', '1', '0', '0', null, '2018-02-24 18:17:55', '2018-02-24 18:18:33', null);
INSERT INTO `a_menu` VALUES ('224', '207', '提交区政府审查（项目审查）', null, '0', '/gov/check_to_gov_check', null, '1', '1', '0', '0', null, '2018-02-24 18:19:27', '2018-02-24 18:19:27', null);
INSERT INTO `a_menu` VALUES ('225', '207', '不予受理（项目审查）', null, '0', '/gov/check_item_stop', null, '1', '1', '0', '0', null, '2018-02-24 18:34:11', '2018-02-24 18:35:04', null);
INSERT INTO `a_menu` VALUES ('226', '203', '被征收户详情', null, '0', '/gov/householddetail_info', null, '1', '1', '0', '0', null, '2018-02-26 09:34:47', '2018-02-26 09:34:47', null);
INSERT INTO `a_menu` VALUES ('253', '242', '听证会意见', null, '0', '/gov/itemdraftreport', null, '1', '1', '0', '0', null, '2018-02-28 17:36:16', '2018-03-01 11:21:10', null);
INSERT INTO `a_menu` VALUES ('228', '211', '被征户-其他补偿事项', null, '0', '/gov/householdobject', null, '1', '1', '1', '0', null, '2018-02-26 11:05:59', '2018-02-26 11:05:59', null);
INSERT INTO `a_menu` VALUES ('229', '228', '添加其他事项', null, '0', '/gov/householdobject_add', null, '1', '1', '0', '0', null, '2018-02-26 11:06:57', '2018-02-26 11:36:00', null);
INSERT INTO `a_menu` VALUES ('230', '207', '区政府审查（项目审查）', null, '0', '/gov/check_gov_check', null, '1', '1', '0', '0', null, '2018-02-26 15:58:15', '2018-02-26 15:59:38', null);
INSERT INTO `a_menu` VALUES ('231', '207', '开启项目启动配置（项目审查）', null, '0', '/gov/check_start_set', null, '1', '1', '0', '0', null, '2018-02-26 16:52:22', '2018-02-26 19:56:18', null);
INSERT INTO `a_menu` VALUES ('232', '228', '其他事项详情', null, '0', '/gov/householdobject_info', null, '1', '1', '0', '0', null, '2018-02-26 11:34:48', '2018-02-26 11:34:48', null);
INSERT INTO `a_menu` VALUES ('233', '228', '修改其他事项', null, '0', '/gov/householdobject_edit', null, '1', '1', '0', '0', null, '2018-02-26 11:35:36', '2018-02-26 11:35:36', null);
INSERT INTO `a_menu` VALUES ('234', '40', '房源控制', null, '0', '/gov/itemhouse#', null, '1', '1', '1', '0', null, '2018-02-26 16:12:36', '2018-02-26 16:12:36', null);
INSERT INTO `a_menu` VALUES ('235', '234', '冻结房源', null, '0', '/gov/itemhouse', null, '1', '1', '1', '0', null, '2018-02-26 16:13:29', '2018-02-26 16:13:29', null);
INSERT INTO `a_menu` VALUES ('236', '235', '添加冻结房源', null, '0', '/gov/itemhouse_add', null, '1', '1', '0', '0', null, '2018-02-26 16:30:36', '2018-02-26 16:30:36', null);
INSERT INTO `a_menu` VALUES ('237', '235', '冻结房源详情', null, '0', '/gov/itemhouse_info', null, '1', '1', '0', '0', null, '2018-02-27 09:18:40', '2018-02-27 09:18:40', null);
INSERT INTO `a_menu` VALUES ('238', '40', '入围机构', null, '0', '/gov/itemcompany#', null, '1', '1', '1', '0', null, '2018-02-27 11:06:59', '2018-02-27 11:06:59', null);
INSERT INTO `a_menu` VALUES ('239', '238', '选定评估机构', null, '0', '/gov/itemcompany', null, '1', '1', '1', '0', null, '2018-02-27 11:21:37', '2018-02-27 11:21:37', null);
INSERT INTO `a_menu` VALUES ('240', '239', '选定评估机构-添加', null, '0', '/gov/itemcompany_add', null, '1', '1', '0', '0', null, '2018-02-27 11:57:51', '2018-02-27 11:57:51', null);
INSERT INTO `a_menu` VALUES ('241', '194', '添加时间规划', null, '0', '/gov/itemtime_add', null, '1', '1', '0', '0', null, '2018-02-27 18:55:38', '2018-02-27 18:55:38', null);
INSERT INTO `a_menu` VALUES ('242', '172', '征收意见稿', null, '0', '/gov/itemdraft', null, '1', '1', '1', '0', null, '2018-02-28 09:41:23', '2018-02-28 10:12:04', null);
INSERT INTO `a_menu` VALUES ('243', '239', '选定评估机构-详情', null, '0', '/gov/itemcompany_info', null, '1', '1', '0', '0', null, '2018-02-28 09:45:06', '2018-02-28 09:45:06', null);
INSERT INTO `a_menu` VALUES ('244', '231', '配置项目负责人（项目审查）', null, '0', '/gov/check_set_itemadmin', null, '1', '1', '0', '0', null, '2018-02-28 09:53:25', '2018-02-28 09:53:25', null);
INSERT INTO `a_menu` VALUES ('245', '231', '配置项目人员（项目审查）', null, '0', '/gov/check_set_itemuser', null, '1', '1', '0', '0', null, '2018-02-28 09:59:47', '2018-02-28 09:59:47', null);
INSERT INTO `a_menu` VALUES ('246', '231', '配置项目时间规划（项目审查）', null, '0', '/gov/check_set_itemtime', null, '1', '1', '0', '0', null, '2018-02-28 10:00:33', '2018-02-28 10:00:33', null);
INSERT INTO `a_menu` VALUES ('247', '239', '选定评估机构-修改', null, '0', '/gov/itemcompany_edit', null, '1', '1', '0', '0', null, '2018-02-28 10:52:24', '2018-02-28 10:52:24', null);
INSERT INTO `a_menu` VALUES ('248', '207', '项目配置提交审查（项目审查）', null, '0', '/gov/check_set_to_check', null, '1', '1', '0', '0', null, '2018-02-28 11:24:32', '2018-02-28 11:24:32', null);
INSERT INTO `a_menu` VALUES ('249', '207', '项目配置审查（项目审查）', null, '0', '/gov/check_set_check', null, '1', '1', '0', '0', null, '2018-02-28 11:44:47', '2018-02-28 14:42:53', null);
INSERT INTO `a_menu` VALUES ('250', '242', '添加征收意见稿', null, '0', '/gov/itemdraft_add', null, '1', '1', '0', '0', null, '2018-02-28 13:59:35', '2018-02-28 17:34:08', null);
INSERT INTO `a_menu` VALUES ('251', '242', '修改征收意见稿', null, '0', '/gov/itemdraft_edit', null, '1', '1', '0', '0', null, '2018-02-28 14:00:18', '2018-02-28 17:32:42', null);
INSERT INTO `a_menu` VALUES ('252', '207', '项目启动（项目审查）', null, '0', '/gov/check_item_start', null, '1', '1', '0', '0', null, '2018-02-28 16:59:44', '2018-02-28 16:59:44', null);
INSERT INTO `a_menu` VALUES ('254', '253', '添加听证会意见', null, '0', '/gov/itemdraftreport_add', null, '1', '1', '0', '0', null, '2018-02-28 18:56:24', '2018-02-28 18:56:24', null);
INSERT INTO `a_menu` VALUES ('255', '253', '听证会详情', null, '0', '/gov/itemdraftreport_info', null, '1', '1', '0', '0', null, '2018-02-28 19:30:33', '2018-02-28 19:30:33', null);
INSERT INTO `a_menu` VALUES ('256', '253', '修改听证会意见', null, '0', '/gov/itemdraftreport_edit', null, '1', '1', '0', '0', null, '2018-02-28 19:39:01', '2018-02-28 19:39:01', null);
INSERT INTO `a_menu` VALUES ('257', '45', '初步预算', null, '0', '/gov/initbudget', null, '1', '1', '1', '0', null, '2018-02-28 19:55:21', '2018-02-28 19:55:21', null);
INSERT INTO `a_menu` VALUES ('258', '257', '添加初步预算', null, '0', '/gov/initbudget_add', null, '1', '1', '0', '0', null, '2018-02-28 19:56:27', '2018-02-28 19:56:27', null);
INSERT INTO `a_menu` VALUES ('262', '173', '社会稳定风险评估', null, '0', '/gov/itemrisk', null, '1', '1', '0', '0', null, '2018-03-01 14:07:26', '2018-03-01 19:08:28', null);
INSERT INTO `a_menu` VALUES ('263', '0', '首页', '<i class=\"menu-icon fa fa-home bigger-120\"></i>', '1', '/com/home#', null, '1', '1', '1', '0', null, '2018-03-01 14:29:00', '2018-03-08 15:10:08', null);
INSERT INTO `a_menu` VALUES ('264', '0', '简介', '<i class=\"menu-icon fa fa-list bigger-120\"></i>', '1', '/com/company_info#', null, '1', '1', '1', '0', null, '2018-03-01 14:29:45', '2018-03-08 15:26:41', null);
INSERT INTO `a_menu` VALUES ('265', '0', '我的项目', '<i class=\"menu-icon fa fa-th bigger-120\"></i>', '1', '/com/item', null, '1', '1', '1', '0', null, '2018-03-01 14:30:37', '2018-03-01 14:48:19', null);
INSERT INTO `a_menu` VALUES ('266', '0', '管理', '<i class=\"menu-icon fa fa-server bigger-120\"></i>', '1', '/com/companyuser#', null, '1', '1', '1', '0', null, '2018-03-01 14:57:35', '2018-03-08 15:57:40', null);
INSERT INTO `a_menu` VALUES ('267', '0', '设置', '<i class=\"menu-icon fa fa-cogs bigger-120\"></i>', '1', '/com/userself#', null, '1', '1', '1', '0', null, '2018-03-01 14:59:04', '2018-03-01 14:59:04', null);
INSERT INTO `a_menu` VALUES ('268', '40', '资金管理', null, '0', '/gov/funds#', null, '1', '1', '1', '0', null, '2018-03-01 15:30:36', '2018-03-01 15:31:10', null);
INSERT INTO `a_menu` VALUES ('269', '265', '摸底资料', null, '1', '/com/household', null, '1', '1', '1', '0', null, '2018-03-01 15:37:28', '2018-03-08 14:43:57', null);
INSERT INTO `a_menu` VALUES ('270', '268', '资金预览', null, '0', '/gov/funds', null, '1', '1', '1', '0', null, '2018-03-01 17:25:43', '2018-03-01 17:25:43', null);
INSERT INTO `a_menu` VALUES ('271', '211', '被征收户-房屋建筑', null, '0', '/gov/householdbuilding', null, '1', '1', '1', '0', null, '2018-03-01 18:57:04', '2018-03-01 18:57:04', null);
INSERT INTO `a_menu` VALUES ('272', '268', '录入资金', null, '0', '/gov/funds_add', null, '1', '1', '1', '0', null, '2018-03-01 18:58:36', '2018-03-01 18:58:36', null);
INSERT INTO `a_menu` VALUES ('273', '271', '添加被征收户-房屋建筑', null, '0', '/gov/householdbuilding_add', null, '1', '1', '0', '0', null, '2018-03-01 18:57:48', '2018-03-01 18:57:48', null);
INSERT INTO `a_menu` VALUES ('274', '271', '被征收户-房屋建筑详情', null, '0', '/gov/householdbuilding_info', null, '1', '1', '0', '0', null, '2018-03-01 19:02:26', '2018-03-01 19:02:26', null);
INSERT INTO `a_menu` VALUES ('275', '271', '修改被征收户-房屋建筑', null, '0', '/gov/householdbuilding_edit', null, '1', '1', '0', '0', null, '2018-03-01 19:03:36', '2018-03-01 19:03:36', null);
INSERT INTO `a_menu` VALUES ('276', '283', '社会稳定性风险评估详情', null, '0', '/gov/itemrisk_info', null, '1', '1', '0', '0', null, '2018-03-01 19:09:36', '2018-03-01 19:09:36', null);
INSERT INTO `a_menu` VALUES ('277', '270', '转账详情', null, '0', '/gov/funds_info', null, '1', '1', '0', '0', null, '2018-03-01 20:31:34', '2018-03-01 20:31:34', null);
INSERT INTO `a_menu` VALUES ('278', '186', '政务公告', null, '0', '/gov/news', null, '1', '1', '1', '0', null, '2018-03-02 09:09:12', '2018-03-02 09:09:12', null);
INSERT INTO `a_menu` VALUES ('279', '278', '添加公告', null, '0', '/gov/news_add', null, '1', '1', '0', '0', null, '2018-03-02 09:09:49', '2018-03-02 09:09:49', null);
INSERT INTO `a_menu` VALUES ('280', '278', '公告详情', null, '0', '/gov/news_info', null, '1', '1', '0', '0', null, '2018-03-02 10:44:46', '2018-03-02 10:44:46', null);
INSERT INTO `a_menu` VALUES ('281', '278', '修改公告', null, '0', '/gov/news_edit', null, '1', '1', '0', '0', null, '2018-03-02 10:56:31', '2018-03-02 10:56:31', null);
INSERT INTO `a_menu` VALUES ('282', '0', '首页', '<i class=\"menu-icon fa fa-dashboard bigger-120\"></i>', '2', '/household/home', '', '1', '1', '1', '0', null, '2018-03-02 11:10:50', '2018-03-02 11:10:50', null);
INSERT INTO `a_menu` VALUES ('283', '321', '意见调查', '<i class=\"menu-icon fa fa-info bigger-120\"></i>', '2', '/household/itemrisk_info', null, '1', '1', '1', '0', null, '2018-03-02 11:18:04', '2018-03-08 10:24:24', null);
INSERT INTO `a_menu` VALUES ('287', '238', '评估机构投票', '', '0', '/gov/companyvote', null, '1', '1', '1', '0', null, '2018-03-02 18:13:54', '2018-03-02 18:13:54', null);
INSERT INTO `a_menu` VALUES ('285', '283', '添加社会稳定风险评估', null, '2', '/household/itemrisk_add', null, '1', '0', '0', '0', null, '2018-03-02 15:26:29', '2018-03-02 15:31:12', null);
INSERT INTO `a_menu` VALUES ('286', '283', '修改社会稳定风险评估', null, '2', '/household/itemrisk_edit', null, '1', '0', '0', '0', null, '2018-03-02 15:31:54', '2018-03-02 15:31:54', null);
INSERT INTO `a_menu` VALUES ('288', '287', '评估机构投票详情', null, '0', '/gov/companyvote_info', null, '1', '1', '0', '0', null, '2018-03-02 18:14:55', '2018-03-02 18:14:55', null);
INSERT INTO `a_menu` VALUES ('289', '40', '协商协议', null, '0', '/gov/pay#', null, '1', '1', '1', '0', null, '2018-03-05 08:43:01', '2018-03-05 08:43:01', null);
INSERT INTO `a_menu` VALUES ('290', '289', '补偿兑付', null, '0', '/gov/pay', null, '1', '1', '1', '0', null, '2018-03-05 08:43:40', '2018-03-05 08:43:40', null);
INSERT INTO `a_menu` VALUES ('291', '290', '补偿决定', null, '0', '/gov/pay_add', null, '1', '1', '0', '0', null, '2018-03-05 08:44:26', '2018-03-10 15:51:49', null);
INSERT INTO `a_menu` VALUES ('292', '290', '兑付详情', null, '0', '/gov/pay_info', null, '1', '1', '0', '0', null, '2018-03-05 08:44:46', '2018-03-05 08:44:46', null);
INSERT INTO `a_menu` VALUES ('293', '290', '修改兑付', null, '0', '/gov/pay_edit', null, '1', '1', '0', '0', null, '2018-03-05 08:46:34', '2018-03-05 08:46:34', null);
INSERT INTO `a_menu` VALUES ('294', '319', '评估机构投票', null, '2', '/household/itemcompanyvote', null, '1', '0', '1', '0', null, '2018-03-05 09:25:24', '2018-03-07 14:05:16', null);
INSERT INTO `a_menu` VALUES ('320', '294', '我的投票', null, '2', '/household/itemcompanyvote_info', null, '1', '1', '0', '0', null, '2018-03-07 15:28:14', '2018-03-07 15:28:14', null);
INSERT INTO `a_menu` VALUES ('295', '294', '添加评估机构投票', null, '2', '/household/itemcompanyvote_add', null, '1', '0', '0', '0', null, '2018-03-05 09:45:55', '2018-03-05 10:35:44', null);
INSERT INTO `a_menu` VALUES ('296', '294', '修改评估机构投票', null, '2', '/household/itemcompanyvote_edit', null, '1', '0', '0', '0', null, '2018-03-05 09:46:52', '2018-03-05 11:14:38', null);
INSERT INTO `a_menu` VALUES ('297', '172', '特殊人群优惠', null, '0', '/gov/itemcrowd', null, '1', '1', '1', '0', null, '2018-03-05 14:09:06', '2018-03-05 14:09:34', null);
INSERT INTO `a_menu` VALUES ('298', '297', '添加特殊人群优惠上浮率', null, '0', '/gov/itemcrowd_add', null, '1', '1', '0', '0', null, '2018-03-05 14:12:18', '2018-03-05 14:12:18', null);
INSERT INTO `a_menu` VALUES ('299', '297', '特殊人群优惠上浮率详情', null, '0', '/gov/itemcrowd_info', null, '1', '1', '0', '0', null, '2018-03-05 14:13:12', '2018-03-05 14:13:12', null);
INSERT INTO `a_menu` VALUES ('300', '297', '修改特殊人群优惠上浮率', null, '0', '/gov/itemcrowd_edit', null, '1', '1', '0', '0', null, '2018-03-05 14:14:01', '2018-03-05 14:14:01', null);
INSERT INTO `a_menu` VALUES ('301', '54', '工作提醒数量', null, '0', '/gov/noticenum', null, '1', '0', '0', '0', null, '2018-03-05 16:19:43', '2018-03-05 16:19:43', null);
INSERT INTO `a_menu` VALUES ('302', '172', '产权调换优惠', null, '0', '/gov/itemhouserate', null, '1', '1', '1', '0', null, '2018-03-05 16:45:03', '2018-03-05 16:45:03', null);
INSERT INTO `a_menu` VALUES ('303', '302', '产权调换优惠详情', null, '0', '/gov/itemhouserate_info', null, '1', '1', '0', '0', null, '2018-03-05 16:46:18', '2018-03-05 16:46:18', null);
INSERT INTO `a_menu` VALUES ('304', '302', '添加产权调换优惠', null, '0', '/gov/itemhouserate_add', null, '1', '1', '0', '0', null, '2018-03-05 16:46:49', '2018-03-05 16:46:49', null);
INSERT INTO `a_menu` VALUES ('305', '302', '修改产权调换优惠', null, '0', '/gov/itemhouserate_edit', null, '1', '1', '0', '0', null, '2018-03-05 16:47:26', '2018-03-05 16:47:26', null);
INSERT INTO `a_menu` VALUES ('306', '290', '添加补偿科目', null, '0', '/gov/paysubject_add', null, '1', '1', '0', '0', null, '2018-03-05 20:26:33', '2018-03-05 20:26:33', null);
INSERT INTO `a_menu` VALUES ('307', '324', '被征户信息', '<i class=\"menu-icon fa fa-home bigger-120\"></i>', '2', '/household/householddetail_info', null, '1', '1', '1', '0', null, '2018-03-06 10:31:12', '2018-03-08 10:54:01', null);
INSERT INTO `a_menu` VALUES ('308', '307', '被征户详情', null, '2', '/household/householddetail_info', null, '1', '1', '0', '0', null, '2018-03-06 11:14:35', '2018-03-06 11:14:35', null);
INSERT INTO `a_menu` VALUES ('309', '45', '操作控制', null, '0', '/gov/itemctrl', null, '1', '1', '1', '0', null, '2018-03-06 11:26:23', '2018-03-06 11:26:23', null);
INSERT INTO `a_menu` VALUES ('310', '309', '添加操作', null, '0', '/gov/itemctrl_add', null, '1', '1', '0', '0', null, '2018-03-06 11:27:05', '2018-03-06 11:27:05', null);
INSERT INTO `a_menu` VALUES ('311', '309', '修改操作', null, '0', '/gov/itemctrl_edit', null, '1', '1', '0', '0', null, '2018-03-06 13:54:01', '2018-03-06 13:54:01', null);
INSERT INTO `a_menu` VALUES ('312', '307', '房屋建筑', null, '2', '/household/householdbuilding_info', null, '1', '1', '0', '0', null, '2018-03-06 13:54:13', '2018-03-06 13:54:13', null);
INSERT INTO `a_menu` VALUES ('313', '307', '家庭成员', null, '2', '/household/householdmember_info', null, '1', '1', '0', '0', null, '2018-03-06 13:54:52', '2018-03-06 13:54:52', null);
INSERT INTO `a_menu` VALUES ('314', '290', '开始选房', null, '0', '/gov/payhouse_add', null, '1', '1', '0', '0', null, '2018-03-06 13:56:44', '2018-03-13 08:55:15', null);
INSERT INTO `a_menu` VALUES ('315', '307', '其他补偿事项', null, '2', '/household/householdobject_info', null, '1', '1', '0', '0', null, '2018-03-06 13:56:49', '2018-03-06 13:57:52', null);
INSERT INTO `a_menu` VALUES ('316', '307', '特殊人群信息', null, '2', '/household/householdmembercrowd_info', null, '1', '1', '0', '0', null, '2018-03-06 14:47:41', '2018-03-06 14:47:41', null);
INSERT INTO `a_menu` VALUES ('317', '321', '征收补偿', '<i class=\"menu-icon fa fa-money bigger-120\"></i>', '2', '/household/pay_info', null, '1', '1', '1', '0', null, '2018-03-06 15:02:20', '2018-03-08 14:12:28', null);
INSERT INTO `a_menu` VALUES ('318', '265', '公共附属物', null, '1', '/com/compublic', null, '1', '1', '1', '0', null, '2018-03-07 09:11:44', '2018-03-07 09:11:44', null);
INSERT INTO `a_menu` VALUES ('319', '0', '投票', '<i class=\"menu-icon fa fa-comment bigger-120\"></i>', '2', '/household/itemcompanyvote#', null, '1', '1', '1', '0', null, '2018-03-07 13:41:51', '2018-03-07 14:03:24', null);
INSERT INTO `a_menu` VALUES ('321', '0', '更多', '<i class=\"menu-icon fa fa-th-large bigger-120\"></i>', '2', '/household/pay#', null, '1', '1', '1', '10', null, '2018-03-07 15:56:59', '2018-03-07 15:56:59', null);
INSERT INTO `a_menu` VALUES ('322', '319', '入围机构', null, '2', '/household/itemcompany', null, '1', '1', '1', '0', null, '2018-03-07 16:24:34', '2018-03-07 16:24:34', null);
INSERT INTO `a_menu` VALUES ('323', '294', '评估机构详情', null, '2', '/household/company_info', null, '1', '1', '0', '0', null, '2018-03-07 17:07:40', '2018-03-07 17:07:40', null);
INSERT INTO `a_menu` VALUES ('324', '0', '产权', '<i class=\"menu-icon fa fa-home bigger-120\"></i>', '2', '/household/householddetail#', null, '1', '1', '1', '0', null, '2018-03-08 09:37:19', '2018-03-08 09:37:19', null);
INSERT INTO `a_menu` VALUES ('326', '0', '房源', '<i class=\"menu-icon fa fa-building bigger-120\"></i>', '2', '/household/itemhouse#', null, '1', '1', '1', '0', null, '2018-03-08 10:27:37', '2018-03-08 10:27:37', null);
INSERT INTO `a_menu` VALUES ('327', '326', '所有房源', null, '2', '/household/itemhouse', null, '1', '1', '1', '0', null, '2018-03-08 10:28:31', '2018-03-08 10:28:31', null);
INSERT INTO `a_menu` VALUES ('328', '264', '简介详情', null, '1', '/com/company_info', null, '1', '1', '0', '0', null, '2018-03-08 15:10:47', '2018-03-08 15:10:47', null);
INSERT INTO `a_menu` VALUES ('329', '264', '修改简介', null, '1', '/com/company_edit', null, '1', '1', '0', '0', null, '2018-03-08 15:11:30', '2018-03-08 15:11:30', null);
INSERT INTO `a_menu` VALUES ('330', '267', '个人中心', null, '1', '/com/userself', null, '1', '1', '1', '0', null, '2018-03-08 15:25:30', '2018-03-08 15:25:30', null);
INSERT INTO `a_menu` VALUES ('331', '321', '评估报告', null, '2', '/household/assess_info', null, '1', '1', '1', '0', null, '2018-03-08 15:31:27', '2018-03-08 15:31:27', null);
INSERT INTO `a_menu` VALUES ('332', '266', '操作员管理', null, '1', '/com/companyuser', null, '1', '1', '1', '0', null, '2018-03-08 15:58:06', '2018-03-08 15:58:06', null);
INSERT INTO `a_menu` VALUES ('333', '266', '评估师管理', null, '1', '/com/companyvaluer', null, '1', '1', '1', '0', null, '2018-03-08 15:58:54', '2018-03-08 15:58:54', null);
INSERT INTO `a_menu` VALUES ('334', '332', '添加操作员', null, '1', '/com/companyuser_add', null, '1', '1', '0', '0', null, '2018-03-08 16:01:07', '2018-03-08 16:01:07', null);
INSERT INTO `a_menu` VALUES ('335', '332', '操作员详情', null, '1', '/com/companyuser_info', null, '1', '1', '0', '0', null, '2018-03-08 16:01:48', '2018-03-08 16:01:48', null);
INSERT INTO `a_menu` VALUES ('336', '332', '修改操作员', null, '1', '/com/companyuser_edit', null, '1', '1', '0', '0', null, '2018-03-08 16:02:15', '2018-03-08 16:02:15', null);
INSERT INTO `a_menu` VALUES ('337', '333', '添加评估师', null, '1', '/com/companyvaluer_add', null, '1', '1', '0', '0', null, '2018-03-08 16:02:56', '2018-03-08 16:02:56', null);
INSERT INTO `a_menu` VALUES ('338', '333', '评估师详情', null, '1', '/com/companyvaluer_info', null, '1', '1', '0', '0', null, '2018-03-08 16:03:20', '2018-03-08 16:03:20', null);
INSERT INTO `a_menu` VALUES ('339', '333', '修改评估师', null, '1', '/com/companyvaluer_edit', null, '1', '1', '0', '0', null, '2018-03-08 16:03:59', '2018-03-08 16:03:59', null);
INSERT INTO `a_menu` VALUES ('340', '321', '个人中心', null, '2', '/household/itemhousehold_info', null, '1', '1', '1', '0', null, '2018-03-09 09:44:54', '2018-03-09 10:27:08', null);
INSERT INTO `a_menu` VALUES ('341', '340', '修改信息', null, '2', '/household/itemhousehold_edit', null, '1', '1', '0', '0', null, '2018-03-09 10:09:10', '2018-03-09 10:09:10', null);
INSERT INTO `a_menu` VALUES ('342', '340', '修改密码', null, '2', '/household/itemhousehold_password', null, '1', '1', '0', '0', null, '2018-03-09 10:09:43', '2018-03-09 10:09:43', null);
INSERT INTO `a_menu` VALUES ('343', '160', '地块户型', null, '0', '/gov/landlayout', null, '1', '1', '0', '0', null, '2018-03-12 18:55:21', '2018-03-12 18:55:44', null);
INSERT INTO `a_menu` VALUES ('344', '343', '添加地块户型', null, '0', '/gov/landlayout_add', null, '1', '1', '0', '0', null, '2018-03-12 18:57:01', '2018-03-12 18:57:01', null);
INSERT INTO `a_menu` VALUES ('345', '343', '地块户型详情', null, '0', '/gov/landlayout_info', null, '1', '1', '0', '0', null, '2018-03-12 18:59:28', '2018-03-12 18:59:28', null);
INSERT INTO `a_menu` VALUES ('346', '343', '修改地块户型', null, '0', '/gov/landlayout_edit', null, '1', '1', '0', '0', null, '2018-03-12 19:00:19', '2018-03-12 19:00:19', null);
INSERT INTO `a_menu` VALUES ('347', '290', '选房计算', null, '0', '/gov/payhouse_cal', null, '1', '1', '0', '0', null, '2018-03-13 08:57:33', '2018-03-13 08:57:33', null);
INSERT INTO `a_menu` VALUES ('348', '290', '补偿科目详情', null, '0', '/gov/paysubject_info', null, '1', '1', '0', '0', null, '2018-03-13 09:01:25', '2018-03-13 09:01:25', null);
INSERT INTO `a_menu` VALUES ('349', '290', '修改补偿科目', null, '0', '/gov/paysubject_edit', null, '1', '1', '0', '0', null, '2018-03-13 09:01:59', '2018-03-13 09:01:59', null);
INSERT INTO `a_menu` VALUES ('350', '290', '重新计算补偿', null, '0', '/gov/paysubject_recal', null, '1', '1', '0', '0', null, '2018-03-13 09:03:42', '2018-03-13 09:37:21', null);
INSERT INTO `a_menu` VALUES ('351', '0', '协议类型', '<i class=\"menu-icon fa fa-file-word-o bigger-120\"></i>', '4', '/sys/pactcate', null, '1', '1', '1', '0', null, '2018-03-13 14:43:04', '2018-03-13 14:44:36', null);
INSERT INTO `a_menu` VALUES ('352', '351', '添加协议类型', null, '4', '/sys/pactcate_add', null, '1', '1', '0', '0', null, '2018-03-13 14:45:04', '2018-03-13 14:45:04', null);
INSERT INTO `a_menu` VALUES ('353', '351', '修改协议类型', null, '4', '/sys/pactcate_edit', null, '1', '1', '0', '0', null, '2018-03-13 14:45:31', '2018-03-13 14:45:31', null);
INSERT INTO `a_menu` VALUES ('354', '211', '被征收户-资产', null, '0', '/gov/householdassets', null, '1', '1', '1', '0', null, '2018-03-13 14:45:36', '2018-03-13 14:46:31', null);
INSERT INTO `a_menu` VALUES ('355', '354', '添加被征收户-资产', null, '0', '/gov/householdassets_add', null, '1', '1', '0', '0', null, '2018-03-13 14:47:14', '2018-03-13 14:47:14', null);
INSERT INTO `a_menu` VALUES ('356', '354', '被征收户-资产详情', null, '0', '/gov/householdassets_info', null, '1', '1', '0', '0', null, '2018-03-13 14:48:28', '2018-03-13 14:48:28', null);
INSERT INTO `a_menu` VALUES ('357', '354', '修改被征收户-资产', null, '0', '/gov/householdassets_edit', null, '1', '1', '0', '0', null, '2018-03-13 14:49:41', '2018-03-13 14:49:41', null);
INSERT INTO `a_menu` VALUES ('358', '159', '确权确户', null, '0', '/gov/householdright', null, '1', '1', '1', '0', null, '2018-03-14 15:57:32', '2018-03-14 16:41:32', null);
INSERT INTO `a_menu` VALUES ('359', '358', '处理产权争议', null, '0', '/gov/householdright_add', null, '1', '1', '0', '0', null, '2018-03-14 17:26:24', '2018-03-14 17:26:24', null);
INSERT INTO `a_menu` VALUES ('360', '358', '产权争议解决详情', null, '0', '/gov/householdright_info', null, '1', '1', '0', '0', null, '2018-03-14 17:27:45', '2018-03-14 17:27:45', null);
INSERT INTO `a_menu` VALUES ('361', '207', '初步预算审查（项目准备）', null, '0', '/gov/ready_init_check', null, '1', '1', '0', '0', null, '2018-03-14 18:07:22', '2018-03-14 18:08:09', null);
INSERT INTO `a_menu` VALUES ('362', '207', '开启项目筹备（项目准备）', null, '0', '/gov/ready_prepare', null, '1', '1', '0', '0', null, '2018-03-14 18:27:05', '2018-03-14 18:38:25', null);

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='协议分类';

-- ----------------------------
-- Records of a_pact_cate
-- ----------------------------
INSERT INTO `a_pact_cate` VALUES ('1', '补偿安置协议', null, '2018-03-13 14:49:28', '2018-03-13 14:49:28', null);
INSERT INTO `a_pact_cate` VALUES ('2', '补偿安置补充协议', null, '2018-03-13 14:49:40', '2018-03-13 14:49:40', null);

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
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='项目流程';

-- ----------------------------
-- Records of a_process
-- ----------------------------
INSERT INTO `a_process` VALUES ('1', '1', '0', '新建项目', '1', '44', '1', '1', null, '2018-02-23 11:52:40', '2018-02-23 11:52:40', null);
INSERT INTO `a_process` VALUES ('2', '1', '0', '提交部门审查', '1', '209', '10', '1', null, '2018-02-23 12:01:22', '2018-02-23 12:01:22', null);
INSERT INTO `a_process` VALUES ('3', '1', '0', '部门审查', '2', '218', '20', '1', null, '2018-02-23 12:02:44', '2018-02-24 11:40:05', null);
INSERT INTO `a_process` VALUES ('4', '1', '3', '重新提交审查资料', '1', '223', '9', '1', null, '2018-02-23 12:03:32', '2018-02-24 18:20:58', null);
INSERT INTO `a_process` VALUES ('5', '1', '3', '审查驳回处理', '1', '222', '21', '1', null, '2018-02-23 12:04:06', '2018-02-24 18:29:29', null);
INSERT INTO `a_process` VALUES ('6', '1', '0', '提交区政府审查', '1', '224', '30', '1', null, '2018-02-23 12:04:29', '2018-02-24 18:21:38', null);
INSERT INTO `a_process` VALUES ('7', '1', '0', '区政府审查', '2', '230', '40', '1', null, '2018-02-23 12:04:53', '2018-02-26 15:59:03', null);
INSERT INTO `a_process` VALUES ('8', '1', '0', '项目启动配置', '1', '231', '50', '1', null, '2018-02-23 12:05:41', '2018-02-26 16:52:39', null);
INSERT INTO `a_process` VALUES ('9', '1', '8', '项目人员', '1', '245', '51', '1', null, '2018-02-23 13:34:31', '2018-02-28 10:02:11', null);
INSERT INTO `a_process` VALUES ('10', '1', '8', '项目时间规划', '1', '246', '52', '1', null, '2018-02-23 13:35:40', '2018-02-28 10:01:31', null);
INSERT INTO `a_process` VALUES ('11', '1', '0', '项目配置提交审查', '1', '248', '60', '1', null, '2018-02-23 13:36:37', '2018-02-28 11:25:05', null);
INSERT INTO `a_process` VALUES ('12', '1', '0', '项目配置审查', '2', '249', '70', '1', null, '2018-02-23 13:37:14', '2018-02-28 14:42:16', null);
INSERT INTO `a_process` VALUES ('13', '1', '0', '项目启动', '1', '252', '80', '1', null, '2018-02-23 13:37:45', '2018-02-28 17:00:00', null);
INSERT INTO `a_process` VALUES ('14', '2', '0', '项目初步预算', '1', '258', '90', '1', null, '2018-02-23 13:38:11', '2018-03-14 14:23:42', null);
INSERT INTO `a_process` VALUES ('15', '1', '3', '不予受理', '1', '225', '22', '1', null, '2018-02-24 18:32:07', '2018-02-24 18:34:43', null);
INSERT INTO `a_process` VALUES ('16', '1', '8', '项目负责人', '1', '244', '53', '1', null, '2018-02-26 19:36:44', '2018-02-28 10:01:54', null);
INSERT INTO `a_process` VALUES ('17', '2', '0', '初步预算审查', '2', '361', '100', '1', null, '2018-02-28 13:41:32', '2018-03-14 18:07:44', null);
INSERT INTO `a_process` VALUES ('18', '2', '0', '项目筹备', '1', '362', '110', '1', null, '2018-02-28 13:42:22', '2018-03-14 18:27:28', null);
INSERT INTO `a_process` VALUES ('19', '2', '0', '项目筹备提交审查', '1', '49', '120', '1', null, '2018-02-28 13:46:04', '2018-03-14 14:52:39', null);
INSERT INTO `a_process` VALUES ('20', '2', '17', '重新预算', '1', '259', '101', '1', null, '2018-03-14 16:46:39', '2018-03-14 18:08:44', null);
INSERT INTO `a_process` VALUES ('21', '2', '18', '录入项目资金', '1', '272', '111', '1', null, '2018-03-14 18:13:15', '2018-03-14 18:13:15', null);
INSERT INTO `a_process` VALUES ('22', '2', '18', '冻结房源', '1', '39', '112', '1', null, '2018-03-14 18:28:34', '2018-03-14 18:28:34', null);

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
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COMMENT='状态代码';

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
INSERT INTO `a_state_code` VALUES ('9', '40', '评估机构-待审查', '2018-03-10 11:37:50', '2018-03-10 11:37:50', null);
INSERT INTO `a_state_code` VALUES ('10', '41', '评估机构-审查通过', '2018-03-10 11:38:11', '2018-03-10 11:38:11', null);
INSERT INTO `a_state_code` VALUES ('11', '42', '评估机构-审查驳回', '2018-03-10 11:39:09', '2018-03-10 11:48:08', null);
INSERT INTO `a_state_code` VALUES ('12', '43', '评估机构-暂停业务', '2018-03-10 11:39:44', '2018-03-10 11:39:44', null);
INSERT INTO `a_state_code` VALUES ('13', '60', '调查中（被征收户）', '2018-03-10 13:45:40', '2018-03-10 13:45:40', null);
INSERT INTO `a_state_code` VALUES ('14', '61', '已调查（被征收户）', '2018-03-10 13:50:58', '2018-03-10 13:50:58', null);
INSERT INTO `a_state_code` VALUES ('15', '62', '确权中（被征收户）', '2018-03-10 13:51:41', '2018-03-10 13:51:41', null);
INSERT INTO `a_state_code` VALUES ('16', '63', '已确权（被征收户）', '2018-03-10 13:52:13', '2018-03-10 13:52:13', null);
INSERT INTO `a_state_code` VALUES ('17', '64', '评估中（被征收户）', '2018-03-10 14:11:25', '2018-03-10 14:11:25', null);
INSERT INTO `a_state_code` VALUES ('18', '65', '已评估（被征收户）', '2018-03-10 14:11:40', '2018-03-10 14:11:40', null);
INSERT INTO `a_state_code` VALUES ('19', '66', '征求意见中（被征收户）', '2018-03-10 14:16:39', '2018-03-10 14:16:39', null);
INSERT INTO `a_state_code` VALUES ('20', '67', '已征求意见（被征收户）', '2018-03-10 14:16:55', '2018-03-10 14:16:55', null);
INSERT INTO `a_state_code` VALUES ('21', '68', '协商协议中（被征收户）', '2018-03-10 14:17:46', '2018-03-10 14:32:37', null);
INSERT INTO `a_state_code` VALUES ('22', '69', '签约中（被征收户）', '2018-03-10 14:19:50', '2018-03-10 14:35:53', null);
INSERT INTO `a_state_code` VALUES ('23', '70', '已签约（被征收户）', '2018-03-10 14:20:17', '2018-03-10 14:44:00', null);
INSERT INTO `a_state_code` VALUES ('24', '71', '搬迁中（被征收户）', '2018-03-10 14:38:11', '2018-03-10 14:38:11', null);
INSERT INTO `a_state_code` VALUES ('25', '72', '已搬迁（被征收户）', '2018-03-10 14:44:25', '2018-03-10 14:44:25', null);
INSERT INTO `a_state_code` VALUES ('26', '90', '合法登记（房屋建筑）', '2018-03-10 14:46:36', '2018-03-10 14:51:07', null);
INSERT INTO `a_state_code` VALUES ('27', '91', '待认定（房屋建筑）', '2018-03-10 14:46:56', '2018-03-10 14:51:35', null);
INSERT INTO `a_state_code` VALUES ('28', '92', '认定合法（房屋建筑）', '2018-03-10 14:47:10', '2018-03-10 14:52:06', null);
INSERT INTO `a_state_code` VALUES ('29', '93', '认定非法（房屋建筑）', '2018-03-10 14:47:21', '2018-03-10 14:52:19', null);
INSERT INTO `a_state_code` VALUES ('30', '94', '自行拆除（房屋建筑）', '2018-03-10 14:47:31', '2018-03-10 14:52:33', null);
INSERT INTO `a_state_code` VALUES ('31', '95', '转为合法（房屋建筑）', '2018-03-10 14:52:53', '2018-03-10 14:52:53', null);
INSERT INTO `a_state_code` VALUES ('32', '73', '结算中（被征收户）', '2018-03-10 14:55:52', '2018-03-10 14:55:52', null);
INSERT INTO `a_state_code` VALUES ('33', '74', '已结算（被征收户）', '2018-03-10 15:08:02', '2018-03-10 15:08:14', null);
INSERT INTO `a_state_code` VALUES ('34', '75', '达不成补偿协议（被征收户）', '2018-03-10 15:09:32', '2018-03-10 15:09:32', null);
INSERT INTO `a_state_code` VALUES ('35', '76', '行政补偿决定（被征收户）', '2018-03-10 15:16:44', '2018-03-10 15:16:44', null);
INSERT INTO `a_state_code` VALUES ('36', '77', '法院强制执行（被征收户）', '2018-03-10 15:17:42', '2018-03-10 15:17:42', null);
INSERT INTO `a_state_code` VALUES ('37', '78', '临时周转中（被征收户）', '2018-03-10 15:18:44', '2018-03-10 15:18:44', null);
INSERT INTO `a_state_code` VALUES ('38', '79', '产权调换安置中（被征收户）', '2018-03-10 15:21:33', '2018-03-10 15:21:33', null);
INSERT INTO `a_state_code` VALUES ('39', '110', '未兑付（补偿科目）', '2018-03-10 15:21:38', '2018-03-10 15:21:38', null);
INSERT INTO `a_state_code` VALUES ('40', '111', '签约（补偿科目）', '2018-03-10 15:22:17', '2018-03-10 15:22:17', null);
INSERT INTO `a_state_code` VALUES ('41', '112', '兑付中（补偿科目）', '2018-03-10 15:22:37', '2018-03-10 15:22:37', null);
INSERT INTO `a_state_code` VALUES ('42', '113', '已兑付（补偿科目）', '2018-03-10 15:22:54', '2018-03-10 15:23:04', null);
INSERT INTO `a_state_code` VALUES ('43', '130', '待评估（房产评估）', '2018-03-10 15:31:16', '2018-03-10 15:31:16', null);
INSERT INTO `a_state_code` VALUES ('44', '131', '评估中（房产评估）', '2018-03-10 15:31:32', '2018-03-10 15:31:32', null);
INSERT INTO `a_state_code` VALUES ('45', '132', '完成（房产评估）', '2018-03-10 15:31:55', '2018-03-10 15:31:55', null);
INSERT INTO `a_state_code` VALUES ('46', '80', '征收补偿完成（被征收户）', '2018-03-10 15:32:15', '2018-03-10 15:32:15', null);
INSERT INTO `a_state_code` VALUES ('47', '133', '通过（房产评估）', '2018-03-10 15:32:17', '2018-03-10 15:32:17', null);
INSERT INTO `a_state_code` VALUES ('48', '134', '驳回（房产评估）', '2018-03-10 15:33:10', '2018-03-10 15:33:10', null);
INSERT INTO `a_state_code` VALUES ('49', '135', '反对（房产评估）', '2018-03-10 15:33:29', '2018-03-10 15:33:29', null);
INSERT INTO `a_state_code` VALUES ('50', '136', '同意（房产评估）', '2018-03-10 15:33:43', '2018-03-10 15:33:43', null);
INSERT INTO `a_state_code` VALUES ('51', '150', '空闲（房源）', '2018-03-10 17:00:30', '2018-03-10 17:00:30', null);
INSERT INTO `a_state_code` VALUES ('52', '151', '冻结（房源）', '2018-03-10 17:00:44', '2018-03-10 17:00:44', null);
INSERT INTO `a_state_code` VALUES ('53', '152', '临时周转（房源）', '2018-03-10 17:01:03', '2018-03-10 17:01:03', null);
INSERT INTO `a_state_code` VALUES ('54', '153', '产权调换（房源）', '2018-03-10 17:01:20', '2018-03-10 17:01:20', null);
INSERT INTO `a_state_code` VALUES ('55', '154', '失效（房源）', '2018-03-10 17:01:40', '2018-03-10 17:01:40', null);
INSERT INTO `a_state_code` VALUES ('56', '155', '售出（房源）', '2018-03-10 17:01:54', '2018-03-10 17:01:54', null);

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
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='重要补偿科目';

-- ----------------------------
-- Records of a_subject
-- ----------------------------
INSERT INTO `a_subject` VALUES ('1', '合法房屋及附属物', '1', null, '2018-02-09 16:39:25', '2018-02-09 16:39:40', null);
INSERT INTO `a_subject` VALUES ('2', '合法临建', '1', null, '2018-02-09 16:41:14', '2018-02-09 16:41:14', null);
INSERT INTO `a_subject` VALUES ('3', '违建自行拆除补助', '1', null, '2018-02-09 16:41:48', '2018-02-09 16:41:48', null);
INSERT INTO `a_subject` VALUES ('4', '公共附属物', '1', null, '2018-02-09 16:42:11', '2018-02-09 16:42:11', null);
INSERT INTO `a_subject` VALUES ('5', '其他补偿事项', '1', null, '2018-02-09 16:43:46', '2018-02-09 16:43:46', null);
INSERT INTO `a_subject` VALUES ('6', '固定资产', '1', null, '2018-02-09 16:44:09', '2018-02-09 16:46:36', null);
INSERT INTO `a_subject` VALUES ('7', '装饰装修补偿', '0', null, '2018-02-09 16:44:22', '2018-02-09 16:44:22', null);
INSERT INTO `a_subject` VALUES ('8', '停产停业损失补偿', '0', null, '2018-02-09 16:44:39', '2018-02-09 16:44:39', null);
INSERT INTO `a_subject` VALUES ('9', '搬迁补助', '0', null, '2018-02-09 16:45:28', '2018-02-09 16:45:28', null);
INSERT INTO `a_subject` VALUES ('10', '设备拆移补助', '0', null, '2018-02-09 16:45:45', '2018-02-09 16:45:45', null);
INSERT INTO `a_subject` VALUES ('11', '签约奖励（住宅）', '0', null, '2018-02-09 16:46:20', '2018-02-09 16:46:20', null);
INSERT INTO `a_subject` VALUES ('12', '签约奖励（非住宅）', '0', null, '2018-02-09 16:47:38', '2018-02-09 16:47:38', null);
INSERT INTO `a_subject` VALUES ('13', '临时安置费', '0', null, '2018-02-09 16:48:21', '2018-03-12 14:51:28', null);
INSERT INTO `a_subject` VALUES ('14', '临时安置费特殊人群优惠补助', '0', null, '2018-02-09 16:48:57', '2018-02-09 16:50:07', null);
INSERT INTO `a_subject` VALUES ('15', '按约搬迁奖励', '0', null, '2018-02-09 16:50:38', '2018-02-09 16:50:38', null);
INSERT INTO `a_subject` VALUES ('16', '房屋状况与登记相符的奖励', '0', null, '2018-02-09 16:52:38', '2018-03-10 17:58:39', null);
INSERT INTO `a_subject` VALUES ('17', '超期临时安置费', '0', null, '2018-03-05 09:44:13', '2018-03-05 09:44:13', null);
INSERT INTO `a_subject` VALUES ('18', '超期临时安置费特殊人群优惠补助', '0', null, '2018-03-10 17:45:50', '2018-03-10 17:45:50', null);

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='建筑结构类型';

-- ----------------------------
-- Records of building_struct
-- ----------------------------
INSERT INTO `building_struct` VALUES ('1', '砖混', null, '2018-02-22 16:00:49', '2018-03-01 10:01:16', null);
INSERT INTO `building_struct` VALUES ('2', '钢混', null, '2018-03-01 10:01:31', '2018-03-01 10:01:31', null);

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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='建筑用途';

-- ----------------------------
-- Records of building_use
-- ----------------------------
INSERT INTO `building_use` VALUES ('1', '住宅', null, '2018-02-23 10:21:47', '2018-02-23 10:21:47', null);
INSERT INTO `building_use` VALUES ('2', '商服', null, '2018-02-23 10:22:20', '2018-03-01 09:57:06', null);
INSERT INTO `building_use` VALUES ('3', '办公', null, '2018-03-01 10:00:26', '2018-03-01 10:00:26', null);
INSERT INTO `building_use` VALUES ('4', '生产加工', null, '2018-03-01 10:00:36', '2018-03-01 10:00:36', null);
INSERT INTO `building_use` VALUES ('5', '附属物', null, '2018-03-01 10:00:51', '2018-03-01 10:00:51', null);

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
  `code` char(20) NOT NULL DEFAULT '' COMMENT ' 状态代码',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='评估机构';

-- ----------------------------
-- Records of company
-- ----------------------------
INSERT INTO `company` VALUES ('1', '0', '房产评估机构', '渝北区力华科谷', '023-12345678', '023-12345678', '张三', '13012345678', null, null, '房产评估机构的简介内容', null, '1', '41', '2018-03-12 09:09:39', '2018-03-12 09:09:39', null);
INSERT INTO `company` VALUES ('2', '1', '资产评估机构', '渝北区力华科谷A区', '023-87654321', '023-87654321', '李四', '13012341234', null, null, '资产评估机构的简介内容', null, '2', '41', '2018-03-12 09:36:27', '2018-03-12 09:36:27', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='评估机构-操作员';

-- ----------------------------
-- Records of company_user
-- ----------------------------
INSERT INTO `company_user` VALUES ('1', '1', null, null, '123456', 'eyJpdiI6Im9Vck15OThVNGRhbEUzWHdqbDZlY0E9PSIsInZhbHVlIjoib0VwMzNOcWEyMXpZMEVcL2hxeEJPaEE9PSIsIm1hYyI6ImM5ZjY1YzdmZTA4YTM2N2JiMTJhYjNkZGE5ZTFhMGRkOWYxMTNlYmFkN2Q0NGRkY2YxNDMzMDc0YjY1OTAxYTYifQ==', '457320B0-B96E-3EBF-B302-BD12880D258A', 'mOy7VydkXi19WPs0unyYqwJatT8glwxOlmDFYIrf', '2018-03-14 09:16:06', '2018-03-12 09:09:39', '2018-03-14 09:16:06', null);
INSERT INTO `company_user` VALUES ('2', '2', null, null, '654321', 'eyJpdiI6InQxdm1DaFdEaFBobFpcL3FcL1R2WWxFZz09IiwidmFsdWUiOiJVbXhZSk5rTjFuMjFLVXVRRXpQQUN3PT0iLCJtYWMiOiJiZGJjNmEzMTcwMTAwYTZjMWMyODIzNTg3NTYyOGU3YjJjMTJhNDA4M2NlMWZmYTY4YTk0YTE5NTcwODA5MmI5In0=', 'EE7867F0-B340-5CD3-394A-D0C2D789A6FE', 'mOy7VydkXi19WPs0unyYqwJatT8glwxOlmDFYIrf', '2018-03-14 14:38:11', '2018-03-12 09:36:27', '2018-03-14 14:38:11', null);

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
  `assets` decimal(30,2) DEFAULT '0.00' COMMENT ' 资产评估总价',
  `estate` decimal(30,2) DEFAULT '0.00' COMMENT ' 房产评估总价',
  `code` char(20) NOT NULL COMMENT '状态代码',
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
  `code` char(20) NOT NULL COMMENT '状态',
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
  `main_total` decimal(30,2) DEFAULT '0.00' COMMENT ' 主体建筑评估总价',
  `tag_total` decimal(30,2) DEFAULT '0.00' COMMENT ' 附属物评估总价',
  `total` decimal(30,2) DEFAULT '0.00' COMMENT '评估总价',
  `picture` text COMMENT '评估报告',
  `code` char(20) NOT NULL COMMENT '状态代码(评估)',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '房屋状态，0正常，1存在新建，2存在改建，3存在扩建',
  `register` varchar(255) DEFAULT NULL COMMENT ' 房屋产权证号',
  `reg_inner` decimal(30,2) DEFAULT NULL COMMENT '套内面积',
  `reg_outer` decimal(30,2) DEFAULT NULL COMMENT '建筑面积',
  `balcony` decimal(10,2) DEFAULT NULL COMMENT '其中阳台面积',
  `dispute` tinyint(1) NOT NULL DEFAULT '0' COMMENT '产权争议，0无争议，1存在争议，2产权明确',
  `area_dispute` tinyint(1) NOT NULL DEFAULT '0' COMMENT '面积争议，0无争议，1待测绘，2面积明确',
  `house_pic` text COMMENT ' 房屋证件，户型图，房屋图片',
  `def_use` int(11) DEFAULT NULL COMMENT ' 批准用途ID',
  `real_use` int(11) NOT NULL COMMENT ' 实际用途ID',
  `has_assets` tinyint(1) NOT NULL DEFAULT '0' COMMENT ' 是否有固定资产，0否，1是',
  `business` varchar(255) DEFAULT NULL COMMENT '经营项目',
  `sign` text NOT NULL COMMENT '被征收人签名',
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='评估-房产评估';

-- ----------------------------
-- Records of com_assess_estate
-- ----------------------------
INSERT INTO `com_assess_estate` VALUES ('1', '1', '1', '1', '1', '0', '1', '0.00', '0.00', '0.00', '', '130', '0', '123456789', null, '100.00', '10.00', '0', '0', '[\"\\/storage\\/180314\\/oYeWrYBNdTsvFRTF14cKq36MkpTxQAWurqa3XddD.jpeg\",\"\\/storage\\/180314\\/xi2u5EBKnddH4sA9EMO6HwIS31dc3XtdUDF5IvkJ.jpeg\"]', '1', '1', '1', null, '/storage/180314/lMjVjLuOt5DRLtk1CnnBB7oa3N0p9jRa9NLrLpFE.jpeg', '2018-03-14 11:29:33', '2018-03-14 14:23:15', null);

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
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '评估单价',
  `amount` decimal(30,2) DEFAULT '0.00' COMMENT ' 评估总价',
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `code` char(20) NOT NULL COMMENT '状态代码',
  `reg_inner` decimal(30,2) DEFAULT NULL COMMENT '套内面积',
  `reg_outer` decimal(30,2) NOT NULL COMMENT '建筑面积',
  `balcony` decimal(10,2) DEFAULT '0.00' COMMENT ' 其中阳台面积',
  `real_inner` decimal(30,2) DEFAULT NULL COMMENT '实际套内面积',
  `real_outer` decimal(30,2) NOT NULL COMMENT ' 实际建筑面积',
  `def_use` int(11) DEFAULT NULL COMMENT ' 批准用途ID',
  `real_use` int(11) NOT NULL COMMENT ' 实际用途ID',
  `struct_id` int(11) NOT NULL COMMENT ' 结构类型ID',
  `direct` varchar(255) NOT NULL COMMENT ' 朝向',
  `floor` int(11) NOT NULL COMMENT ' 楼层',
  `layout_id` int(11) DEFAULT NULL COMMENT '地块户型',
  `picture` text NOT NULL COMMENT ' 图片',
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
  `land_id` int(11) NOT NULL DEFAULT '0' COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL DEFAULT '0' COMMENT ' 楼栋ID',
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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='特殊人群分类';

-- ----------------------------
-- Records of crowd
-- ----------------------------
INSERT INTO `crowd` VALUES ('1', '0', '残疾', null, '2018-02-24 15:51:11', '2018-03-01 09:51:28', null);
INSERT INTO `crowd` VALUES ('2', '1', '一级残疾', '重度残疾', '2018-02-24 15:51:33', '2018-03-12 10:00:44', null);
INSERT INTO `crowd` VALUES ('3', '0', '优抚对象', null, '2018-02-24 17:08:32', '2018-03-12 09:55:03', null);
INSERT INTO `crowd` VALUES ('4', '3', '低保', '持有城市居民最低生活保障证', '2018-02-24 17:08:55', '2018-03-12 09:59:08', null);
INSERT INTO `crowd` VALUES ('5', '1', '二级残疾', '重度残疾', '2018-03-01 09:51:42', '2018-03-12 10:00:32', null);
INSERT INTO `crowd` VALUES ('6', '1', '三级残疾', '中度残疾', '2018-03-01 09:51:51', '2018-03-12 10:00:10', null);
INSERT INTO `crowd` VALUES ('7', '1', '四级残疾', '轻度残疾', '2018-03-01 09:52:06', '2018-03-12 09:59:56', null);
INSERT INTO `crowd` VALUES ('8', '3', '伤残军人及优抚对象', '伤残军人、烈士家属、因公牺牲军人家属、病故军人家属', '2018-03-01 09:54:55', '2018-03-12 09:57:19', null);
INSERT INTO `crowd` VALUES ('9', '3', '困难家庭', '建档困难职工家庭、特困职工家庭', '2018-03-01 09:55:22', '2018-03-12 09:58:22', null);
INSERT INTO `crowd` VALUES ('10', '0', '失独', null, '2018-03-01 09:55:43', '2018-03-12 09:55:19', null);
INSERT INTO `crowd` VALUES ('11', '10', '失独家庭', null, '2018-03-01 09:56:01', '2018-03-12 09:55:31', null);

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
  `code` char(20) NOT NULL COMMENT ' 房源状况',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `community_id` (`community_id`),
  KEY `layout_id` (`layout_id`),
  KEY `layout_img_id` (`layout_img_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='房源';

-- ----------------------------
-- Records of house
-- ----------------------------
INSERT INTO `house` VALUES ('1', '1', '1', '1', '1', '1', '1', '1', '1', '90.00', '20', '1', '0', '0', '0', '0', null, null, '1', '2018-03-01 14:55:29', '2018-03-01 15:23:48', null);
INSERT INTO `house` VALUES ('2', '2', '3', '2', '6', '2', '2', '2', '2', '100.00', '9', '0', '1', '1', '0', '0', null, '2017-03-01', '1', '2018-03-01 15:01:47', '2018-03-01 15:23:48', null);
INSERT INTO `house` VALUES ('3', '1', '2', '2', '4', '1', '2', '20', '1', '100.00', '30', '1', '1', '1', '1', '1', '[\"\\/storage\\/180308\\/2htQfYDAwT9OiUUnZr2oRThBpVtWGvr8pPHItfGF.jpeg\"]', '2018-03-08', '1', '2018-03-08 16:53:43', '2018-03-08 17:06:14', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='房源社区';

-- ----------------------------
-- Records of house_community
-- ----------------------------
INSERT INTO `house_community` VALUES ('1', '1', '房源社区1', '房源社区1地址', null, '2018-03-01 13:56:56', '2018-03-01 13:56:56', null);
INSERT INTO `house_community` VALUES ('2', '1', '房源社区2', '房源社区2地址', null, '2018-03-01 13:57:23', '2018-03-01 13:57:23', null);
INSERT INTO `house_community` VALUES ('3', '2', '房源社区3', '房源社区3地址', null, '2018-03-01 13:57:47', '2018-03-01 13:57:47', null);
INSERT INTO `house_community` VALUES ('4', '2', '房源社区4', '房源社区4地址', null, '2018-03-01 13:58:13', '2018-03-01 13:58:13', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='房源管理机构';

-- ----------------------------
-- Records of house_company
-- ----------------------------
INSERT INTO `house_company` VALUES ('1', '房源管理公司1', '房源管理公司1地址', '房源管理公司1电话', '房源管理公司1联系人', '房源管理公司1联系电话', null, '2018-03-01 13:55:10', '2018-03-01 13:55:39', null);
INSERT INTO `house_company` VALUES ('2', '房源管理公司2', '房源管理公司2地址', '房源管理公司2电话', '房源管理公司2联系人', '房源管理公司2联系电话', null, '2018-03-01 13:56:21', '2018-03-01 13:56:21', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='房源社区户型图';

-- ----------------------------
-- Records of house_layout_img
-- ----------------------------
INSERT INTO `house_layout_img` VALUES ('1', '1', '1', '111', '/storage/180301/sqj6oEsK7C5OdyO2awTzUaamtyn7ZxcuDXTQMpVm.jpeg', '2018-03-01 14:04:15', '2018-03-01 14:04:15', null);
INSERT INTO `house_layout_img` VALUES ('2', '1', '2', '121', '/storage/180301/jG1J1NWtVUVvm84QBpLnAv1sFjnadX3KuTOBUxbO.png', '2018-03-01 14:06:59', '2018-03-01 14:06:59', null);
INSERT INTO `house_layout_img` VALUES ('3', '2', '1', '211', '/storage/180301/v4Cuc5Xdl7nuJemXaLXsjCW1R3D9ysKFm75b9ToW.png', '2018-03-01 14:07:14', '2018-03-01 14:07:14', null);
INSERT INTO `house_layout_img` VALUES ('4', '2', '2', '221', '/storage/180301/6IrmQLMUfxrdjC15kEb9A6eWPyX29qWtALtlSgap.jpeg', '2018-03-01 14:07:28', '2018-03-01 14:07:28', null);
INSERT INTO `house_layout_img` VALUES ('5', '3', '1', '311', '/storage/180301/mfAr82gvFHocHh0YFB2wVp2Pkf5y8PR1A9weCmjW.jpeg', '2018-03-01 14:07:49', '2018-03-01 14:07:49', null);
INSERT INTO `house_layout_img` VALUES ('6', '3', '2', '321', '/storage/180301/F8c6kkKF1YSrznGY2oZeYzZ2MOwJrKFUsyo2036f.jpeg', '2018-03-01 14:08:03', '2018-03-01 14:08:03', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='房源-购置管理费单价';

-- ----------------------------
-- Records of house_manage_price
-- ----------------------------
INSERT INTO `house_manage_price` VALUES ('1', '1', '90.00', '2015', '2018', '2018-03-01 14:55:29', '2018-03-01 14:55:29', null);
INSERT INTO `house_manage_price` VALUES ('2', '2', '100.00', '2015', '2018', '2018-03-01 15:01:47', '2018-03-01 15:01:47', null);
INSERT INTO `house_manage_price` VALUES ('3', '3', '10.00', '2018', '2018', '2018-03-08 16:53:43', '2018-03-08 16:53:43', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='房源-评估单价';

-- ----------------------------
-- Records of house_price
-- ----------------------------
INSERT INTO `house_price` VALUES ('1', '1', '2018-01-01', '2018-12-31', '5000.00', '4000.00', '2018-03-01 14:55:29', '2018-03-01 14:55:29', null);
INSERT INTO `house_price` VALUES ('2', '2', '2017-01-01', '2017-12-31', '6000.00', '5000.00', '2018-03-01 15:01:47', '2018-03-01 15:01:47', null);
INSERT INTO `house_price` VALUES ('3', '3', '2018-03-08', '2018-03-08', '12121212.00', '1323213.00', '2018-03-08 16:53:43', '2018-03-08 16:53:43', null);

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
  `code` char(20) NOT NULL DEFAULT '' COMMENT '状态代码',
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
INSERT INTO `item` VALUES ('1', '西关片区棚户区改造项目', '东至自由路、西至双桥路、北至成纪大道、南至解放路', '/storage/180223/mK5owDrG1mq9Ptpa2IgHCB3sz3F2n75jW92myUDV.png', null, '{\"file1\":[\"\\/storage\\/180223\\/NZjbyaVk6rZ6HJIWyoR3pkOSrRsQTdsvfiNjE6Rg.jpeg\"],\"file2\":[\"\\/storage\\/180223\\/JftNYwrUVh0Pg5xDxEfiU829gJSm245TOjAAUZWu.png\"],\"file3\":[\"\\/storage\\/180223\\/0PHJnAKiV91iIyomMMyQstD3IgkgCDusHxki0Kxr.jpeg\"],\"file4\":[\"\\/storage\\/180223\\/kjwiM1uWs7uk1wfnTVtwnD8FK0eBMOYJIxmQBVdR.jpeg\"]}', '1', '12', '22', '2018-02-23 17:35:06', '2018-03-14 13:55:34', null);

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
INSERT INTO `item_admin` VALUES ('1', '1', '1', '2', '5', '2018-02-28 11:04:14', '2018-02-28 11:04:14', null);

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
  `gov_pic` text COMMENT '征收-图片',
  `com_pic` text COMMENT '评估-图片',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `land_id` (`land_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='项目-地块楼栋';

-- ----------------------------
-- Records of item_building
-- ----------------------------
INSERT INTO `item_building` VALUES ('1', '1', '1', '1', '28', '100.00', '2017', '2', null, '[\"\\/storage\\/180310\\/Qc3WBDF0BmkaSyVJge2B0AbzrJRLPgokV9ISny2H.jpeg\"]', null, '2018-03-10 16:38:20', '2018-03-10 16:38:20', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='项目-选定评估机构';

-- ----------------------------
-- Records of item_company
-- ----------------------------
INSERT INTO `item_company` VALUES ('1', '1', '0', '1', null, '2018-03-13 17:33:17', '2018-03-13 17:33:17', null);
INSERT INTO `item_company` VALUES ('2', '1', '1', '2', null, '2018-03-14 14:32:35', '2018-03-14 14:32:35', null);

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
INSERT INTO `item_company_household` VALUES ('1', '1', '1', '1', '2018-03-13 17:33:17');
INSERT INTO `item_company_household` VALUES ('1', '2', '2', '1', '2018-03-14 14:32:35');

-- ----------------------------
-- Table structure for item_company_vote
-- ----------------------------
DROP TABLE IF EXISTS `item_company_vote`;
CREATE TABLE `item_company_vote` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `household_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `company_id` (`company_id`),
  KEY `household_id` (`household_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='项目-评估公司投票';

-- ----------------------------
-- Records of item_company_vote
-- ----------------------------
INSERT INTO `item_company_vote` VALUES ('1', '1', '1', '1', '2018-03-13 16:14:09', '2018-03-13 16:14:09');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='项目-时间控制';

-- ----------------------------
-- Records of item_control
-- ----------------------------
INSERT INTO `item_control` VALUES ('2', '1', '1', 'A', '2018-03-06 08:00:00', '2018-03-07 17:00:00', '2018-03-06 13:41:08', '2018-03-06 13:54:15', null);
INSERT INTO `item_control` VALUES ('3', '1', '3', 'A', '2018-03-05 00:00:00', '2018-03-15 17:00:00', '2018-03-06 17:48:48', '2018-03-06 17:48:48', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='项目-特殊人群优惠上浮率';

-- ----------------------------
-- Records of item_crowd
-- ----------------------------
INSERT INTO `item_crowd` VALUES ('1', '1', '1', '2', '21.00', '2018-03-05 15:08:14', '2018-03-05 15:55:21', null);
INSERT INTO `item_crowd` VALUES ('2', '1', '1', '2', '21.00', '2018-03-05 15:08:14', '2018-03-05 15:55:21', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='项目-征收意见稿';

-- ----------------------------
-- Records of item_draft
-- ----------------------------
INSERT INTO `item_draft` VALUES ('2', '1', '标题测试', '<p>1</p>', '20', '2018-02-28 14:58:00', '2018-03-01 10:25:20', null);

-- ----------------------------
-- Table structure for item_draft_report
-- ----------------------------
DROP TABLE IF EXISTS `item_draft_report`;
CREATE TABLE `item_draft_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `draft_id` int(11) NOT NULL COMMENT '征收意见稿ID',
  `name` varchar(255) DEFAULT NULL,
  `content` text NOT NULL COMMENT '听证会修改意见',
  `code` char(20) NOT NULL COMMENT '状态代码',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='项目-征收意见稿-听证会修改意见';

-- ----------------------------
-- Records of item_draft_report
-- ----------------------------
INSERT INTO `item_draft_report` VALUES ('10', '1', '2', '标题测试', '<p><strong>test</strong></p><p><strong>45656</strong></p><p><strong><img src=\"/ueditor/php/upload/image/20180301/1519872915204711.png\" title=\"1519872915204711.png\" alt=\"棋牌.png\"/></strong></p>', '20', '2018-02-28 19:19:03', '2018-03-01 10:55:17', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='项目-资金收入支出流水';

-- ----------------------------
-- Records of item_funds
-- ----------------------------
INSERT INTO `item_funds` VALUES ('1', '1', '1', '0', '-20000.00', '100001', '1', '6666666666666666', '项目筹备资金1', '2018-03-01 00:00:00', '项目筹备资金1', '[\"\\/storage\\/180301\\/HK4lR6WyYtEStVHxXEeCiXjHMyvSMRvQYHuTMvmt.png\"]', '2018-03-01 19:28:16', '2018-03-01 19:28:16', null);

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
  `code` char(20) NOT NULL DEFAULT '' COMMENT ' 状态代码',
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
INSERT INTO `item_house` VALUES ('1', '1', '0', '2018-03-01 15:23:48', '2018-03-01 15:23:48', null);
INSERT INTO `item_house` VALUES ('1', '2', '0', '2018-03-01 15:23:48', '2018-03-01 15:23:48', null);
INSERT INTO `item_house` VALUES ('1', '3', '0', '2018-03-08 17:06:14', '2018-03-08 17:06:14', null);

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
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '房产类型，0私产，1公房',
  `username` varchar(255) NOT NULL COMMENT ' 用户名',
  `password` varchar(255) NOT NULL COMMENT ' 密码',
  `secret` varchar(255) NOT NULL COMMENT ' 密钥',
  `infos` text COMMENT ' 描述',
  `code` char(20) NOT NULL DEFAULT '' COMMENT ' 状态代码',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `item_id` (`item_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='项目-被征收户';

-- ----------------------------
-- Records of item_household
-- ----------------------------
INSERT INTO `item_household` VALUES ('1', '1', '1', '1', '1', '1', '1', '0', 'test', 'eyJpdiI6ImdMU01yY1dkZlJIVm5Yd1dQM1NvbGc9PSIsInZhbHVlIjoiTVZJZXJWYlZ0cUJodFwvYkZybW9GOHc9PSIsIm1hYyI6ImZiYWI3MDQ4NWRmOWRkMDM2YjQzMGZmODIxODhkNmU3MWExN2Y5MDUyZWQxNjRkYWMwZWE4ZGQxNWJlOGZiOTAifQ==', '6C8EC565-6B2C-ADD1-16FB-2D6563930893', null, '60', '2018-03-12 15:00:22', '2018-03-12 15:59:30', null);
INSERT INTO `item_household` VALUES ('2', '1', '1', '1', '1', '13', '1', '0', 'asdfg', 'eyJpdiI6Imo3cWVkWXZKVEZnZjhoaUhuSTN2Mnc9PSIsInZhbHVlIjoiNG1yVGc2dFwvZ3Zpd1VJbU01ZnhmR0E9PSIsIm1hYyI6ImYxMWFiNjc0ZDEzZmQ1YWQzNzcyYzhkYWVkYzVjZmY1OTAyNjI2NTg5ZjA4NzNlMzRiMzYwNTNhNGY5ZDYzZGQifQ==', '48A1C9EC-3883-6F07-3338-620BD306525C', null, '60', '2018-03-14 17:03:01', '2018-03-14 17:03:01', null);

-- ----------------------------
-- Table structure for item_household_assets
-- ----------------------------
DROP TABLE IF EXISTS `item_household_assets`;
CREATE TABLE `item_household_assets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `num_unit` varchar(255) NOT NULL COMMENT ' 计量单位',
  `gov_num` int(11) DEFAULT NULL COMMENT '征收-数量',
  `com_num` int(11) DEFAULT NULL COMMENT '评估-数量',
  `number` int(11) DEFAULT NULL COMMENT '数量',
  `gov_pic` text COMMENT '征收-图片',
  `com_pic` text COMMENT '评估-图片',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='项目-被征收户-资产';

-- ----------------------------
-- Records of item_household_assets
-- ----------------------------
INSERT INTO `item_household_assets` VALUES ('1', '1', '1', '1', '1', '资产', '个', '100', '10', null, '[\"\\/storage\\/180313\\/2KWa4h2G1CBxKsNuoQjSZS3xldfBHxplQ3b34DR4.jpeg\"]', '[\"\\/storage\\/180314\\/93jXAMXRkF4NK9xLBvmAdSpdemJHVMYLPMMVGIpY.jpeg\"]', '2018-03-13 14:59:27', '2018-03-14 15:19:16', null);
INSERT INTO `item_household_assets` VALUES ('2', '1', '1', '1', '1', '资产2', '件', '13', '102', null, '[\"\\/storage\\/180313\\/m7IliBzSrthAGv42fIkhqKu8qC3BSuhdxS3m7RKE.jpeg\"]', '[\"\\/storage\\/180314\\/04Gt59dEzC4e3D9Cjn5DacZQGPxLMHmRdLyZZqVq.jpeg\"]', '2018-03-13 15:42:58', '2018-03-14 15:08:24', null);
INSERT INTO `item_household_assets` VALUES ('3', '1', '1', '1', '1', '资产3', '件', null, '3', null, null, '[\"\\/storage\\/180314\\/VeD9HJ20DX2Y4hpECx1zJJcPgrfXdlLO8KM1EMbY.jpeg\"]', '2018-03-14 15:07:56', '2018-03-14 15:07:56', null);

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
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `code` char(20) NOT NULL COMMENT '状态代码',
  `reg_inner` decimal(30,2) DEFAULT NULL COMMENT '套内面积',
  `reg_outer` decimal(30,2) NOT NULL COMMENT '建筑面积',
  `balcony` decimal(10,2) DEFAULT '0.00' COMMENT ' 其中阳台面积',
  `real_inner` decimal(30,2) DEFAULT NULL COMMENT '实际套内面积',
  `real_outer` decimal(30,2) NOT NULL COMMENT ' 实际建筑面积',
  `def_use` int(11) DEFAULT NULL COMMENT ' 批准用途ID',
  `real_use` int(11) NOT NULL COMMENT ' 实际用途ID',
  `struct_id` int(11) NOT NULL COMMENT ' 结构类型ID',
  `direct` varchar(255) NOT NULL COMMENT ' 朝向',
  `floor` int(11) NOT NULL COMMENT ' 楼层',
  `layout_id` int(11) DEFAULT NULL COMMENT '地块户型',
  `picture` text NOT NULL COMMENT ' 图片',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='项目-被征收户-房屋建筑';

-- ----------------------------
-- Records of item_household_building
-- ----------------------------
INSERT INTO `item_household_building` VALUES ('4', '1', '1', '1', '1', null, '90', null, '120.00', '20.00', null, '120.00', '1', '1', '1', '东', '3', '1', '[\"\\/storage\\/180312\\/aA2Wi54YOvniaiYDKEwlsjzX68uZ6YB57VaWa4al.jpeg\"]', '2018-03-12 17:19:19', '2018-03-12 17:19:19', null);
INSERT INTO `item_household_building` VALUES ('5', '1', '1', '1', '1', null, '90', null, '111.00', '11.00', null, '111.00', '2', '2', '2', '南', '3', '2', '[\"\\/storage\\/180312\\/KbeZ1GX6d965i664QzyJtAoyGNsyD6X5FHy2Trrg.jpeg\"]', '2018-03-12 17:28:30', '2018-03-12 17:28:30', null);
INSERT INTO `item_household_building` VALUES ('6', '1', '1', '1', '1', null, '90', null, '120.00', '20.00', null, '100.00', '1', '1', '1', '西', '12', '1', '[\"\\/storage\\/180313\\/aTLtm221sZMfnKJ8AvJLZt2VoyGk5DuzM8qZPovP.jpeg\"]', '2018-03-13 11:34:52', '2018-03-13 11:34:52', null);

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
  `code` char(20) NOT NULL COMMENT '状态代码',
  `picture` text NOT NULL COMMENT '争议解决结果',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`)
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
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '拆除补助单价（罚款单价）',
  `amount` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT '拆除补助总价（罚款总价）',
  `code` char(20) NOT NULL COMMENT '状态代码',
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
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态，0正常，1存在新建，2存在改建，3存在扩建',
  `register` varchar(255) DEFAULT NULL COMMENT ' 房屋产权证号',
  `reg_inner` decimal(30,2) DEFAULT NULL COMMENT '套内面积',
  `reg_outer` decimal(30,2) DEFAULT NULL COMMENT '建筑面积',
  `balcony` decimal(10,2) DEFAULT NULL COMMENT '其中阳台面积',
  `dispute` tinyint(1) NOT NULL DEFAULT '0' COMMENT '产权争议，0无争议，1存在争议，2产权明确',
  `area_dispute` tinyint(1) NOT NULL DEFAULT '0' COMMENT '面积争议，0无争议，1待测绘，2面积明确',
  `picture` text COMMENT ' 房屋证件，户型图，房屋图片',
  `def_use` int(11) DEFAULT NULL COMMENT ' 批准用途ID',
  `real_use` int(11) NOT NULL COMMENT ' 实际用途ID',
  `has_assets` tinyint(1) NOT NULL DEFAULT '0' COMMENT ' 是否有固定资产，0否，1是',
  `business` varchar(255) DEFAULT NULL COMMENT '经营项目',
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
INSERT INTO `item_household_detail` VALUES ('1', '1', '1', '1', '1', '0', null, null, null, null, '0', '0', '[\"\\/storage\\/180312\\/DDzzAMX0IsaXpYrTWHO2SWYD3GMmNG4zDByyjeyG.jpeg\"]', '0', '0', '1', null, '1', '0', null, null, null, null, null, '0', null, null, null, null, '/storage/180312/1qY6Fcr7SAIUH3O6KifW33pFAirAzoXPovoz8L4Y.jpeg', '2018-03-12 15:41:48', '2018-03-14 14:32:16', null);
INSERT INTO `item_household_detail` VALUES ('2', '1', '2', '1', '1', '2', '123456', null, '100.00', '10.00', '2', '1', '[\"\\/storage\\/180314\\/GgGeN4Ftcpgl256VY9eTMiDBt9QV0rHCjnTWwOZS.jpeg\"]', '1', '1', '1', null, '1', '0', null, null, null, null, null, '0', null, 'wang', '13043211234', '渝北', '/storage/180314/8m6GJsw6lfRwiwN1taIMV0RzBKNJYUppPTaUBN7S.jpeg', '2018-03-14 17:04:17', '2018-03-14 17:58:14', null);

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
  `portion` decimal(10,2) DEFAULT '0.00' COMMENT '权属分配比例（%）',
  `picture` text NOT NULL COMMENT '身份证，户口本页',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='项目-被征收户-家庭成员';

-- ----------------------------
-- Records of item_household_member
-- ----------------------------
INSERT INTO `item_household_member` VALUES ('1', '1', '1', '1', '1', '张三', '户主', '123456789', '13012341234', '1', '0', '26', '0', '1', '100.00', '[\"\\/storage\\/180314\\/TGiFKfvJeBfx81nd9OU9bpUn2BYU4Re85bQsySIX.jpeg\"]', '2018-03-14 15:22:56', '2018-03-14 15:22:56', null);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目-被征收户-家庭成员-特殊人群';

-- ----------------------------
-- Records of item_household_member_crowd
-- ----------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='项目-被征收户-产权争议解决';

-- ----------------------------
-- Records of item_household_right
-- ----------------------------
INSERT INTO `item_household_right` VALUES ('1', '1', '2', '1', '1', '协商解决', '[\"\\/storage\\/180314\\/ltC4LM1O8Fk001BVg7v6NRxdXiP3rXr2UqoiTz6h.jpeg\"]', '2018-03-14 17:58:14', '2018-03-14 17:58:14', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='项目-产权调换优惠上浮';

-- ----------------------------
-- Records of item_house_rate
-- ----------------------------
INSERT INTO `item_house_rate` VALUES ('1', '1', '0.00', '15.00', '10.00', '2018-03-05 17:37:10', '2018-03-05 17:55:58', null);
INSERT INTO `item_house_rate` VALUES ('2', '1', '15.00', '30.00', '15.00', '2018-03-09 16:52:22', '2018-03-09 17:52:24', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='项目-初步预算';

-- ----------------------------
-- Records of item_init_budget
-- ----------------------------
INSERT INTO `item_init_budget` VALUES ('1', '1', '100', '200000.00', '200', '[\"\\/storage\\/180301\\/0BKgnI32JiqAc5aXDM3J3CsZWhy6D3YSLHFsUh8k.jpeg\"]', '2018-03-01 12:02:58', '2018-03-01 13:50:30', null);

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
  `admin_unit_id` int(11) NOT NULL DEFAULT '0' COMMENT ' 所属公房单位ID，0为私产',
  `area` decimal(30,2) NOT NULL COMMENT '占地面积，（㎡）',
  `infos` text COMMENT '备注',
  `gov_pic` text COMMENT '征收-图片',
  `com_pic` text COMMENT '评估-图片',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='项目-地块';

-- ----------------------------
-- Records of item_land
-- ----------------------------
INSERT INTO `item_land` VALUES ('1', '1', '渝北区力华科谷', '1', '1', '3', '1', '1000.00', null, '[\"\\/storage\\/180310\\/S32hugYRnerv3b44GOjZ8Bs0niTzB4jCfs7Fj6uI.jpeg\"]', '[\"\\/storage\\/180310\\/ere6KiVBbmgUWToYCZbWvWTMDOe6oyydlS69hMnx.jpeg\"]', '2018-03-10 16:30:46', '2018-03-10 18:35:41', null);

-- ----------------------------
-- Table structure for item_land_layout
-- ----------------------------
DROP TABLE IF EXISTS `item_land_layout`;
CREATE TABLE `item_land_layout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `area` decimal(30,2) DEFAULT NULL COMMENT '面积',
  `gov_img` text COMMENT '征收-户型图',
  `com_img` text COMMENT '评估-户型图',
  `picture` text COMMENT '测绘报告',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `land_id` (`land_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='项目-地块户型';

-- ----------------------------
-- Records of item_land_layout
-- ----------------------------
INSERT INTO `item_land_layout` VALUES ('1', '1', '1', '三室一厅', '120.00', '[\"\\/storage\\/180312\\/OmVYsoxhkshPQ1FVjBrWhfKk09szbU7k40xRRNxF.jpeg\"]', null, null, '2018-03-12 17:19:19', '2018-03-12 17:19:19', null);
INSERT INTO `item_land_layout` VALUES ('2', '1', '1', '商场', '100.00', '[\"\\/storage\\/180312\\/6Oc82HSdLL5Qjjw3Iq92mgJkRdj9y2fAn2uGRPJv.jpeg\",\"\\/storage\\/180312\\/76XGYmcGMxITwDdEdWcS4Mnklu0r8wX9tqgWRvs5.jpeg\",\"\\/storage\\/180312\\/QMbAVK1cj6S1XfqGFkaVvILubbF1H4RvQmKR60uK.jpeg\"]', null, null, '2018-03-12 17:28:30', '2018-03-12 18:07:05', null);
INSERT INTO `item_land_layout` VALUES ('3', '1', '1', '一室一厅', '100.00', '[\"\\/storage\\/180312\\/Nf2gENx21Yd4WgTD9xw3tC5L4C69gysyrLTGLNOg.jpeg\"]', '[\"\\/storage\\/180313\\/F8UJ7sEKftCspl6Mfsqi18QQM59UZj6XL78CIZDn.jpeg\"]', null, '2018-03-12 19:05:05', '2018-03-13 16:11:55', null);
INSERT INTO `item_land_layout` VALUES ('4', '1', '1', '两室一厅A', null, '[\"\\/storage\\/180313\\/GbzUOaaZEyhL5S1lOBmbfoLxX2yDY90oI9W0rjk4.jpeg\"]', null, null, '2018-03-13 10:48:49', '2018-03-13 10:48:49', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='项目-内部通知';

-- ----------------------------
-- Records of item_notice
-- ----------------------------
INSERT INTO `item_notice` VALUES ('1', '1', '1', '通知摘要内容1', '[\"\\/storage\\/180222\\/c3ldGxfqeU5ZHpGUldKNEf2ybihj1G1TGyHQ6MaS.jpeg\"]', '2018-02-22 17:07:24', '2018-02-22 17:08:10', null);
INSERT INTO `item_notice` VALUES ('2', '1', '1', '不予受理', '[\"\\/storage\\/180226\\/MQ4XdJnQwL0jCzsNYpMMJRxuHWbjvCtD6T3Ruosi.jpeg\"]', '2018-02-26 15:05:02', '2018-02-26 15:05:02', null);
INSERT INTO `item_notice` VALUES ('3', '1', '2', '房屋征收补偿资金总额预算通知', '[\"\\/storage\\/180301\\/L3yytTPPwyVm86n6TeKTgzJV00VyLDQbU6PRdQPU.jpeg\"]', '2018-03-01 12:02:58', '2018-03-01 13:50:30', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='项目-其他补偿事项单价';

-- ----------------------------
-- Records of item_object
-- ----------------------------
INSERT INTO `item_object` VALUES ('1', '1', '1', '200.00', '2018-02-22 16:43:15', '2018-02-22 16:43:15', null);
INSERT INTO `item_object` VALUES ('2', '1', '2', '50.00', '2018-03-09 18:13:55', '2018-03-09 18:13:55', null);

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
  `item_end` date DEFAULT NULL COMMENT '项目期限',
  `portion_holder` decimal(10,2) DEFAULT '0.00' COMMENT ' 被征收人比例（%）',
  `portion_renter` decimal(10,2) DEFAULT '0.00' COMMENT '承租人比例（%）',
  `move_base` decimal(10,2) DEFAULT '0.00' COMMENT '搬迁补助-基本',
  `move_house` decimal(10,2) DEFAULT '0.00' COMMENT '搬迁补助单价-住宅',
  `move_office` decimal(10,2) DEFAULT '0.00' COMMENT '搬迁补助单价-办公',
  `move_business` decimal(10,2) DEFAULT '0.00' COMMENT '搬迁补助单价-商服',
  `move_factory` decimal(10,2) DEFAULT '0.00' COMMENT '搬迁补助单价-生产加工',
  `transit_base` decimal(10,2) DEFAULT '0.00' COMMENT '临时安置-基本',
  `transit_house` decimal(10,2) DEFAULT '0.00' COMMENT '临时安置单价-住宅',
  `transit_other` decimal(10,2) DEFAULT '0.00' COMMENT '临时安置单价-非住宅',
  `transit_real` int(11) DEFAULT '6' COMMENT '临时安置时长（月）-现房',
  `transit_future` int(11) DEFAULT '30' COMMENT '临时安置时长（月）-期房',
  `reward_house` decimal(10,2) DEFAULT '0.00' COMMENT '选择货币补偿的签约追加奖励单价-住宅',
  `reward_other` decimal(10,2) DEFAULT '0.00' COMMENT '选择货币补偿的签约追加奖励比例（%）-非住宅',
  `reward_real` decimal(10,2) DEFAULT '0.00' COMMENT '房屋奖励单价',
  `reward_move` decimal(10,2) DEFAULT '0.00' COMMENT '搬迁奖励',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='项目-征收方案';

-- ----------------------------
-- Records of item_program
-- ----------------------------
INSERT INTO `item_program` VALUES ('2', '1', '测试', '<p>修改测试<img src=\"/ueditor/php/upload/image/20180312/1520824497997680.png\" title=\"1520824497997680.png\" alt=\"棋牌.png\"/></p>', '20', '2018-03-31', '1.00', '1.00', '1.00', '1.00', '1.00', '1.00', '1.00', '1.00', '1.00', '1.00', '1', '1', '1.00', '1.00', '1.00', '1.00', '2018-03-12 11:14:59', '2018-03-12 11:18:48', null);

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
  `gov_num` int(11) DEFAULT NULL COMMENT '征收-数量',
  `com_num` int(11) DEFAULT NULL COMMENT '评估-数量',
  `number` decimal(20,2) DEFAULT NULL COMMENT ' 数量',
  `infos` text,
  `gov_pic` text COMMENT '征收-图片',
  `com_pic` text COMMENT '评估-图片',
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
INSERT INTO `item_public` VALUES ('1', '1', '1', '1', '砖', '块', '120', '120', null, null, '[\"\\/storage\\/180310\\/vBTcY0u9bkNb5VeWHV52ch88I3uNT7QcvGdCvyjW.jpeg\"]', '[\"\\/storage\\/180312\\/JqukckHrtKcsREaUBJbVyrjHsrw6sAlLA9qkcedB.jpeg\"]', '2018-03-10 17:12:20', '2018-03-12 09:31:33', null);
INSERT INTO `item_public` VALUES ('2', '1', '1', '0', '围墙', '面', '4', '4', null, null, '[\"\\/storage\\/180310\\/eH0urX1pn4e01Qf9YcuuyBayT2gwiI9JX2W1TIXS.jpeg\"]', '[\"\\/storage\\/180313\\/5YjU9Y71YrowzUDZTpKaMM4lDaTCFVBqLNzPWCKS.jpeg\"]', '2018-03-10 17:12:58', '2018-03-13 16:34:43', null);

-- ----------------------------
-- Table structure for item_reward
-- ----------------------------
DROP TABLE IF EXISTS `item_reward`;
CREATE TABLE `item_reward` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `start_at` date NOT NULL COMMENT '签约开始日期',
  `end_at` date NOT NULL COMMENT '签约开始日期',
  `price` decimal(10,2) NOT NULL COMMENT '奖励单价-住宅',
  `portion` decimal(10,2) NOT NULL COMMENT '奖励比例（%）-非住宅',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='项目-签约奖励';

-- ----------------------------
-- Records of item_reward
-- ----------------------------
INSERT INTO `item_reward` VALUES ('1', '1', '0000-00-00', '0000-00-00', '200.00', '0.00', '2018-02-22 16:43:15', '2018-02-22 16:43:15', null);
INSERT INTO `item_reward` VALUES ('2', '1', '0000-00-00', '0000-00-00', '50.00', '0.00', '2018-03-09 18:13:55', '2018-03-09 18:13:55', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='项目-社会稳定风险评估';

-- ----------------------------
-- Records of item_risk
-- ----------------------------
INSERT INTO `item_risk` VALUES ('1', '1', '2', '1', '1', '1', '0', '200.00', '20.00', '1', '来庆路二单元三号', '500.00', '1', '0', '1', '200.00', '300.00', '200.00', '5000.00', null, null, null);
INSERT INTO `item_risk` VALUES ('8', '1', '1', '1', '2', '0', '0', null, null, null, null, null, '1', '1', '0', null, null, null, null, '2018-03-02 19:36:18', '2018-03-05 08:53:10', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='项目-风险评估报告';

-- ----------------------------
-- Records of item_risk_report
-- ----------------------------
INSERT INTO `item_risk_report` VALUES ('1', '1', '社会稳定风险评估报告', '<p>测试<img src=\"/ueditor/php/upload/image/20180312/1520825973170959.png\" title=\"1520825973170959.png\" alt=\"棋牌.png\"/></p>', '[\"\\/storage\\/180312\\/jBlJpySG0B2LCAd7m76nRxTk8ZfbXLxk2hYwzRv5.png\"]', '0', '20', '2018-03-12 11:33:02', '2018-03-12 11:39:35', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='项目-补偿科目说明（非固定项）';

-- ----------------------------
-- Records of item_subject
-- ----------------------------
INSERT INTO `item_subject` VALUES ('1', '1', '1', '', '2018-02-22 15:05:40', '2018-02-22 15:05:40', null);
INSERT INTO `item_subject` VALUES ('2', '1', '2', '', '2018-02-22 15:05:40', '2018-02-22 15:05:40', null);
INSERT INTO `item_subject` VALUES ('3', '1', '3', '', '2018-02-22 15:05:40', '2018-02-22 15:05:40', null);
INSERT INTO `item_subject` VALUES ('4', '1', '4', '', '2018-02-22 15:05:40', '2018-02-22 15:05:40', null);
INSERT INTO `item_subject` VALUES ('5', '1', '5', '', '2018-02-22 15:05:40', '2018-02-22 15:05:40', null);
INSERT INTO `item_subject` VALUES ('6', '1', '17', '', '2018-03-05 11:42:55', '2018-03-05 11:42:55', null);
INSERT INTO `item_subject` VALUES ('7', '1', '6', '', '2018-03-13 16:46:02', '2018-03-13 16:46:02', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='项目-时间规划';

-- ----------------------------
-- Records of item_time
-- ----------------------------
INSERT INTO `item_time` VALUES ('7', '1', '1', '2018-02-01', '2018-02-28', '2018-02-28 11:07:34', '2018-02-28 11:07:34', null);
INSERT INTO `item_time` VALUES ('8', '1', '2', '2018-02-01', '2018-02-28', '2018-02-28 11:07:34', '2018-02-28 11:07:34', null);
INSERT INTO `item_time` VALUES ('9', '1', '3', '2018-02-01', '2018-02-28', '2018-02-28 11:07:34', '2018-02-28 11:07:34', null);
INSERT INTO `item_time` VALUES ('10', '1', '4', '2018-02-01', '2018-02-28', '2018-02-28 11:07:34', '2018-02-28 11:07:34', null);
INSERT INTO `item_time` VALUES ('11', '1', '5', '2018-02-01', '2018-02-28', '2018-02-28 11:07:34', '2018-02-28 11:07:34', null);
INSERT INTO `item_time` VALUES ('12', '1', '6', '2018-02-01', '2018-02-28', '2018-02-28 11:07:34', '2018-02-28 11:07:34', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='项目-自选社会风险评估调查话题';

-- ----------------------------
-- Records of item_topic
-- ----------------------------
INSERT INTO `item_topic` VALUES ('1', '1', '1', '2018-03-09 18:04:30', '2018-03-09 18:04:30', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='项目-流程人员配置';

-- ----------------------------
-- Records of item_user
-- ----------------------------
INSERT INTO `item_user` VALUES ('1', '1', '1', '1', '44', '4', '4', '7', '2018-02-28 11:15:30', '2018-02-28 11:15:30', null);
INSERT INTO `item_user` VALUES ('2', '1', '1', '4', '223', '4', '4', '7', '2018-02-28 11:15:30', '2018-02-28 11:15:30', null);
INSERT INTO `item_user` VALUES ('3', '1', '1', '2', '209', '4', '4', '7', '2018-02-28 11:15:30', '2018-02-28 11:15:30', null);
INSERT INTO `item_user` VALUES ('4', '1', '1', '3', '218', '4', '4', '7', '2018-02-28 11:15:30', '2018-02-28 11:15:30', null);
INSERT INTO `item_user` VALUES ('5', '1', '1', '5', '222', '4', '4', '7', '2018-02-28 11:15:30', '2018-02-28 11:15:30', null);
INSERT INTO `item_user` VALUES ('6', '1', '1', '15', '225', '4', '4', '7', '2018-02-28 11:15:30', '2018-02-28 11:15:30', null);
INSERT INTO `item_user` VALUES ('7', '1', '1', '6', '224', '4', '4', '7', '2018-02-28 11:15:30', '2018-02-28 11:15:30', null);
INSERT INTO `item_user` VALUES ('8', '1', '1', '7', '230', '4', '4', '7', '2018-02-28 11:15:30', '2018-02-28 11:15:30', null);
INSERT INTO `item_user` VALUES ('9', '1', '1', '8', '231', '4', '4', '7', '2018-02-28 11:15:30', '2018-02-28 11:15:30', null);
INSERT INTO `item_user` VALUES ('10', '1', '1', '9', '245', '4', '4', '7', '2018-02-28 11:15:30', '2018-02-28 11:15:30', null);
INSERT INTO `item_user` VALUES ('11', '1', '1', '10', '246', '4', '4', '7', '2018-02-28 11:15:30', '2018-02-28 11:15:30', null);
INSERT INTO `item_user` VALUES ('12', '1', '1', '16', '244', '4', '4', '7', '2018-02-28 11:15:30', '2018-02-28 11:15:30', null);
INSERT INTO `item_user` VALUES ('13', '1', '1', '11', '46', '4', '4', '7', '2018-02-28 11:15:30', '2018-02-28 11:15:30', null);
INSERT INTO `item_user` VALUES ('14', '1', '1', '12', '47', '4', '4', '7', '2018-02-28 11:15:30', '2018-02-28 11:15:30', null);
INSERT INTO `item_user` VALUES ('15', '1', '1', '13', '48', '4', '4', '7', '2018-02-28 11:15:30', '2018-02-28 11:15:30', null);
INSERT INTO `item_user` VALUES ('16', '1', '2', '14', '52', '4', '4', '7', '2018-02-28 11:15:30', '2018-02-28 11:15:30', null);
INSERT INTO `item_user` VALUES ('17', '1', '1', '1', '44', '1', '2', '5', '2018-02-28 11:16:44', '2018-02-28 11:16:44', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8 COMMENT='项目-工作提醒及处理结果';

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
INSERT INTO `item_work_notice` VALUES ('14', '1', '1', '4', '223', '0', '0', '1', '1', 'http://ts.rms.cn:8008/gov/itemprocess_retry?item=1', '0', null, null, null, '2018-02-26 10:58:59', '2018-02-26 14:38:10', '2018-02-26 14:38:10');
INSERT INTO `item_work_notice` VALUES ('15', '1', '1', '4', '223', '1', '0', '1', '3', 'http://ts.rms.cn:8008/gov/itemprocess_retry?item=1', '2', null, null, null, '2018-02-26 10:58:59', '2018-02-26 14:38:10', null);
INSERT INTO `item_work_notice` VALUES ('16', '1', '1', '4', '223', '1', '2', '3', '4', 'http://ts.rms.cn:8008/gov/itemprocess_retry?item=1', '0', null, null, null, '2018-02-26 10:58:59', '2018-02-26 14:38:10', '2018-02-26 14:38:10');
INSERT INTO `item_work_notice` VALUES ('17', '1', '1', '2', '209', '0', '0', '1', '1', 'http://ts.rms.cn:8008/gov/iteminfo_info?item=1', '0', null, null, null, '2018-02-26 14:38:10', '2018-02-26 14:38:59', '2018-02-26 14:38:59');
INSERT INTO `item_work_notice` VALUES ('18', '1', '1', '2', '209', '1', '0', '1', '3', 'http://ts.rms.cn:8008/gov/iteminfo_info?item=1', '2', null, null, null, '2018-02-26 14:38:10', '2018-02-26 14:38:59', null);
INSERT INTO `item_work_notice` VALUES ('19', '1', '1', '2', '209', '1', '2', '3', '4', 'http://ts.rms.cn:8008/gov/iteminfo_info?item=1', '0', null, null, null, '2018-02-26 14:38:10', '2018-02-26 14:38:59', '2018-02-26 14:38:59');
INSERT INTO `item_work_notice` VALUES ('20', '1', '1', '3', '218', '0', '0', '1', '1', 'http://ts.rms.cn:8008/gov/itemprocess_cdc?item=1', '20', null, null, null, '2018-02-26 14:38:59', '2018-02-26 14:42:18', '2018-02-26 14:42:18');
INSERT INTO `item_work_notice` VALUES ('21', '1', '1', '3', '218', '1', '0', '1', '3', 'http://ts.rms.cn:8008/gov/itemprocess_cdc?item=1', '22', null, '通过', null, '2018-02-26 14:38:59', '2018-02-26 15:40:11', null);
INSERT INTO `item_work_notice` VALUES ('22', '1', '1', '3', '218', '1', '2', '3', '4', 'http://ts.rms.cn:8008/gov/itemprocess_cdc?item=1', '20', null, null, null, '2018-02-26 14:38:59', '2018-02-26 14:42:18', '2018-02-26 14:42:18');
INSERT INTO `item_work_notice` VALUES ('23', '1', '1', '5', '222', '0', '0', '1', '1', 'http://ts.rms.cn:8008/gov/itemprocess_crb?item=1', '0', null, null, null, '2018-02-26 14:42:18', '2018-02-26 14:43:42', '2018-02-26 14:43:42');
INSERT INTO `item_work_notice` VALUES ('24', '1', '1', '5', '222', '1', '0', '1', '3', 'http://ts.rms.cn:8008/gov/itemprocess_crb?item=1', '2', null, null, null, '2018-02-26 14:42:18', '2018-02-26 14:43:42', null);
INSERT INTO `item_work_notice` VALUES ('25', '1', '1', '5', '222', '1', '2', '3', '4', 'http://ts.rms.cn:8008/gov/itemprocess_crb?item=1', '0', null, null, null, '2018-02-26 14:42:18', '2018-02-26 14:43:42', '2018-02-26 14:43:42');
INSERT INTO `item_work_notice` VALUES ('26', '1', '1', '15', '225', '0', '0', '1', '1', 'http://ts.rms.cn:8008/gov/itemprocess_stop?item=1', '0', null, null, null, '2018-02-26 14:43:42', '2018-02-26 15:05:02', '2018-02-26 15:05:02');
INSERT INTO `item_work_notice` VALUES ('27', '1', '1', '15', '225', '1', '0', '1', '3', 'http://ts.rms.cn:8008/gov/itemprocess_stop?item=1', '2', null, null, null, '2018-02-26 14:43:42', '2018-02-26 15:05:02', null);
INSERT INTO `item_work_notice` VALUES ('28', '1', '1', '15', '225', '1', '2', '3', '4', 'http://ts.rms.cn:8008/gov/itemprocess_stop?item=1', '0', null, null, null, '2018-02-26 14:43:42', '2018-02-26 15:05:02', '2018-02-26 15:05:02');
INSERT INTO `item_work_notice` VALUES ('29', '1', '1', '6', '224', '0', '0', '1', '1', 'http://ts.rms.cn:8008/gov/iteminfo_info?item=1', '0', null, null, null, '2018-02-26 15:40:11', '2018-02-26 16:09:31', '2018-02-26 16:09:31');
INSERT INTO `item_work_notice` VALUES ('30', '1', '1', '6', '224', '1', '0', '1', '3', 'http://ts.rms.cn:8008/gov/iteminfo_info?item=1', '2', null, null, null, '2018-02-26 15:40:11', '2018-02-26 16:09:31', null);
INSERT INTO `item_work_notice` VALUES ('31', '1', '1', '6', '224', '1', '2', '3', '4', 'http://ts.rms.cn:8008/gov/iteminfo_info?item=1', '0', null, null, null, '2018-02-26 15:40:11', '2018-02-26 16:09:31', '2018-02-26 16:09:31');
INSERT INTO `item_work_notice` VALUES ('32', '1', '1', '7', '230', '0', '0', '1', '1', 'http://ts.rms.cn:8008/gov/itemprocess_cgc?item=1', '20', null, null, null, '2018-02-26 16:09:31', '2018-02-26 17:56:22', '2018-02-26 17:56:22');
INSERT INTO `item_work_notice` VALUES ('33', '1', '1', '7', '230', '1', '0', '1', '3', 'http://ts.rms.cn:8008/gov/itemprocess_cgc?item=1', '22', null, '通过', null, '2018-02-26 16:09:31', '2018-02-26 17:56:22', null);
INSERT INTO `item_work_notice` VALUES ('34', '1', '1', '7', '230', '1', '2', '3', '4', 'http://ts.rms.cn:8008/gov/itemprocess_cgc?item=1', '20', null, null, null, '2018-02-26 16:09:31', '2018-02-26 17:56:22', '2018-02-26 17:56:22');
INSERT INTO `item_work_notice` VALUES ('35', '1', '1', '8', '231', '0', '0', '1', '1', 'http://ts.rms.cn:8008/gov/itemprocess_css?item=1', '0', null, null, null, '2018-02-26 17:56:22', '2018-02-28 10:04:17', '2018-02-28 10:04:17');
INSERT INTO `item_work_notice` VALUES ('36', '1', '1', '8', '231', '1', '0', '1', '3', 'http://ts.rms.cn:8008/gov/itemprocess_css?item=1', '0', null, null, null, '2018-02-26 17:56:22', '2018-02-28 10:04:17', '2018-02-28 10:04:17');
INSERT INTO `item_work_notice` VALUES ('37', '1', '1', '8', '231', '1', '0', '1', '4', 'http://ts.rms.cn:8008/gov/itemprocess_css?item=1', '1', null, null, null, '2018-02-26 17:56:22', '2018-02-28 10:52:39', null);
INSERT INTO `item_work_notice` VALUES ('47', '1', '1', '9', '245', '0', '0', '1', '1', 'http://ts.rms.cn:8008/gov/itemuser?item=1', '0', null, null, null, '2018-02-28 10:52:39', '2018-02-28 11:25:45', '2018-02-28 11:25:45');
INSERT INTO `item_work_notice` VALUES ('48', '1', '1', '9', '245', '1', '0', '1', '3', 'http://ts.rms.cn:8008/gov/itemuser?item=1', '0', null, null, null, '2018-02-28 10:52:39', '2018-02-28 11:25:45', '2018-02-28 11:25:45');
INSERT INTO `item_work_notice` VALUES ('49', '1', '1', '9', '245', '1', '0', '1', '4', 'http://ts.rms.cn:8008/gov/itemuser?item=1', '2', null, null, null, '2018-02-28 10:52:39', '2018-02-28 11:25:45', null);
INSERT INTO `item_work_notice` VALUES ('50', '1', '1', '10', '246', '0', '0', '1', '1', 'http://ts.rms.cn:8008/gov/itemtime?item=1', '0', null, null, null, '2018-02-28 10:52:39', '2018-02-28 11:12:00', '2018-02-28 11:12:00');
INSERT INTO `item_work_notice` VALUES ('51', '1', '1', '10', '246', '1', '0', '1', '3', 'http://ts.rms.cn:8008/gov/itemtime?item=1', '0', null, null, null, '2018-02-28 10:52:39', '2018-02-28 11:12:00', '2018-02-28 11:12:00');
INSERT INTO `item_work_notice` VALUES ('52', '1', '1', '10', '246', '1', '0', '1', '4', 'http://ts.rms.cn:8008/gov/itemtime?item=1', '2', null, null, null, '2018-02-28 10:52:39', '2018-02-28 11:12:00', null);
INSERT INTO `item_work_notice` VALUES ('53', '1', '1', '16', '244', '0', '0', '1', '1', 'http://ts.rms.cn:8008/gov/itemadmin?item=1', '0', null, null, null, '2018-02-28 10:52:39', '2018-02-28 11:07:58', '2018-02-28 11:07:58');
INSERT INTO `item_work_notice` VALUES ('54', '1', '1', '16', '244', '1', '0', '1', '3', 'http://ts.rms.cn:8008/gov/itemadmin?item=1', '0', null, null, null, '2018-02-28 10:52:39', '2018-02-28 11:07:58', '2018-02-28 11:07:58');
INSERT INTO `item_work_notice` VALUES ('55', '1', '1', '16', '244', '1', '0', '1', '4', 'http://ts.rms.cn:8008/gov/itemadmin?item=1', '2', null, null, null, '2018-02-28 10:52:39', '2018-02-28 11:07:58', null);
INSERT INTO `item_work_notice` VALUES ('56', '1', '1', '11', '248', '0', '0', '1', '1', 'http://ts.rms.cn:8008/gov/itemprocess_cs2c?item=1', '0', null, null, null, '2018-02-28 11:25:45', '2018-02-28 14:58:47', '2018-02-28 14:58:47');
INSERT INTO `item_work_notice` VALUES ('57', '1', '1', '11', '248', '1', '0', '1', '3', 'http://ts.rms.cn:8008/gov/itemprocess_cs2c?item=1', '0', null, null, null, '2018-02-28 11:25:45', '2018-02-28 14:58:47', '2018-02-28 14:58:47');
INSERT INTO `item_work_notice` VALUES ('58', '1', '1', '11', '248', '1', '0', '1', '4', 'http://ts.rms.cn:8008/gov/itemprocess_cs2c?item=1', '2', null, null, null, '2018-02-28 11:25:45', '2018-02-28 14:58:47', null);
INSERT INTO `item_work_notice` VALUES ('59', '1', '1', '12', '249', '0', '0', '1', '1', 'http://ts.rms.cn:8008/gov/itemprocess_csc?item=1', '20', null, null, null, '2018-02-28 14:58:47', '2018-02-28 17:07:14', '2018-02-28 17:07:14');
INSERT INTO `item_work_notice` VALUES ('60', '1', '1', '12', '249', '1', '0', '1', '3', 'http://ts.rms.cn:8008/gov/itemprocess_csc?item=1', '20', null, null, null, '2018-02-28 14:58:47', '2018-02-28 17:07:14', '2018-02-28 17:07:14');
INSERT INTO `item_work_notice` VALUES ('61', '1', '1', '12', '249', '1', '0', '1', '4', 'http://ts.rms.cn:8008/gov/itemprocess_csc?item=1', '22', null, '审查通过', null, '2018-02-28 14:58:47', '2018-02-28 17:32:03', null);
INSERT INTO `item_work_notice` VALUES ('74', '1', '1', '13', '252', '0', '0', '1', '1', 'http://ts.rms.cn:8008/gov/check_item_start?item=1', '0', null, null, null, '2018-02-28 17:32:03', '2018-03-14 13:47:46', '2018-03-14 13:47:46');
INSERT INTO `item_work_notice` VALUES ('75', '1', '1', '13', '252', '1', '0', '1', '3', 'http://ts.rms.cn:8008/gov/check_item_start?item=1', '0', null, null, null, '2018-02-28 17:32:03', '2018-03-14 13:47:46', '2018-03-14 13:47:46');
INSERT INTO `item_work_notice` VALUES ('76', '1', '1', '13', '252', '1', '0', '1', '4', 'http://ts.rms.cn:8008/gov/check_item_start?item=1', '0', null, null, null, '2018-02-28 17:32:03', '2018-03-14 13:55:34', null);

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
INSERT INTO `land_source` VALUES ('2', '1', '划拨', null, '2018-02-22 15:20:16', '2018-03-01 09:29:03', null);
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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='土地权益状况';

-- ----------------------------
-- Records of land_state
-- ----------------------------
INSERT INTO `land_state` VALUES ('1', '2', '3', '出租', null, '2018-02-22 15:20:54', '2018-02-22 15:20:54', null);
INSERT INTO `land_state` VALUES ('2', '2', '3', '转让', null, '2018-02-22 15:22:56', '2018-02-22 15:22:56', null);
INSERT INTO `land_state` VALUES ('3', '1', '1', '协议', null, '2018-02-22 15:23:25', '2018-02-22 15:23:25', null);
INSERT INTO `land_state` VALUES ('4', '1', '1', '招标', null, '2018-02-22 15:23:34', '2018-02-22 15:23:34', null);
INSERT INTO `land_state` VALUES ('5', '1', '1', '拍卖', null, '2018-02-24 18:38:31', '2018-03-01 09:15:16', null);
INSERT INTO `land_state` VALUES ('6', '1', '1', '其他', null, '2018-03-01 09:15:38', '2018-03-01 09:15:38', null);
INSERT INTO `land_state` VALUES ('7', '1', '2', '转让', null, '2018-03-01 09:35:25', '2018-03-01 09:35:43', null);

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
  `code` char(20) NOT NULL COMMENT '状态代码',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cate_id` (`cate_id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='通知公告';

-- ----------------------------
-- Records of news
-- ----------------------------
INSERT INTO `news` VALUES ('1', '1', '1', '西关片区棚户区改造项目房屋征收范围的公告', '2018-03-01', null, '西关片区棚户区改造项目房屋征收范围的公告', '<p><img src=\"/ueditor/php/upload/image/20180302/1519960168.jpg\" alt=\"1519960168.jpg\" width=\"316\" height=\"194\"/></p><p>西关片区棚户区改造项目房屋征收范围的公告</p><p><br/></p><p>西关片区棚户区改造项目房屋征收范围的公告</p>', '[\"\\/storage\\/180302\\/lzz2FqIqLjZDDv2arwjKhmm5JZmEiFDC4mX51hsK.jpeg\"]', '0', '20', '2018-03-02 10:11:23', '2018-03-02 11:10:47', null);

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='其他补偿事项';

-- ----------------------------
-- Records of object
-- ----------------------------
INSERT INTO `object` VALUES ('1', '宽带', '户', null, '2018-02-22 16:39:48', '2018-03-01 09:46:47', null);
INSERT INTO `object` VALUES ('2', '固定电话', '部', null, '2018-03-01 09:47:02', '2018-03-01 09:47:02', null);
INSERT INTO `object` VALUES ('3', '有线电视', '户', null, '2018-03-01 09:47:15', '2018-03-01 09:47:15', null);
INSERT INTO `object` VALUES ('4', '空调', '台', null, '2018-03-01 09:47:29', '2018-03-01 09:47:29', null);

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
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT ' 有效状态，0未生效，1生效，2失效',
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COMMENT='兑付-汇总';

-- ----------------------------
-- Records of pay
-- ----------------------------
INSERT INTO `pay` VALUES ('23', '1', '1', '1', '2', '0', '1', '0', '56358.00', null, '2018-03-08 15:15:03', '2018-03-08 15:15:03', null);

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
  `household_building_id` int(11) NOT NULL COMMENT '被征收户-建筑ID',
  `estate_building_id` int(11) NOT NULL COMMENT '房产评估-建筑ID',
  `pay_id` int(11) NOT NULL COMMENT ' 兑付ID',
  `code` char(20) NOT NULL COMMENT '状态代码',
  `real_outer` decimal(30,2) NOT NULL COMMENT ' 实际建筑面积',
  `real_use` int(11) NOT NULL COMMENT ' 实际用途ID',
  `struct_id` int(11) NOT NULL COMMENT ' 结构类型ID',
  `layout_id` int(11) DEFAULT '0' COMMENT '地块户型',
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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='兑付-建筑';

-- ----------------------------
-- Records of pay_building
-- ----------------------------
INSERT INTO `pay_building` VALUES ('18', '1', '1', '1', '2', '1', '1', '4', '0', '20', '', '100.00', '1', '2', '0', '南', '10', '8000.00', '800000.00', '2018-03-06 19:31:33', '2018-03-06 19:31:33', null);
INSERT INTO `pay_building` VALUES ('21', '1', '1', '1', '2', '1', '1', '4', '0', '23', '', '100.00', '2', '1', '0', '东', '20', '0.00', '0.00', '2018-03-08 15:15:03', '2018-03-08 15:15:03', null);
INSERT INTO `pay_building` VALUES ('22', '1', '1', '1', '2', '1', '1', '5', '0', '23', '', '100.00', '1', '2', '0', '东', '21', '8000.00', '800000.00', '2018-03-08 15:15:03', '2018-03-08 15:15:03', null);

-- ----------------------------
-- Table structure for pay_crowd
-- ----------------------------
DROP TABLE IF EXISTS `pay_crowd`;
CREATE TABLE `pay_crowd` (
  `item_id` int(11) NOT NULL COMMENT ' 项目ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `pay_id` int(11) NOT NULL COMMENT '兑付ID',
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
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`),
  KEY `pay_id` (`pay_id`),
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
  `item_id` int(11) NOT NULL COMMENT ' 项目ID',
  `household_id` int(11) NOT NULL COMMENT ' 被征收户ID',
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `house_id` int(11) NOT NULL COMMENT '房源ID',
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
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`),
  KEY `house_id` (`house_id`)
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='兑付-公共附属物';

-- ----------------------------
-- Records of pay_public
-- ----------------------------
INSERT INTO `pay_public` VALUES ('1', '1', '1', '1', '2', '1', '1', '砖', '块', '50.00', '111.00', '5550.00', '1', '5550.00', '2018-03-08 15:15:03', '2018-03-08 15:15:03', null);
INSERT INTO `pay_public` VALUES ('2', '1', '1', '0', '3', '1', '2', '大门', '扇', '2.00', '1212.00', '2424.00', '3', '808.00', '2018-03-08 15:15:03', '2018-03-08 15:15:03', null);

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
  `control_id` int(11) NOT NULL COMMENT '操作控制ID（选房）',
  `serial` char(1) NOT NULL COMMENT '序列',
  `number` int(11) NOT NULL COMMENT ' 预约号',
  `code` char(20) NOT NULL COMMENT '状态',
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
  `subject_id` int(11) NOT NULL COMMENT '重要补偿科目 ID',
  `total_id` int(11) NOT NULL DEFAULT '0' COMMENT '兑付总单ID',
  `calculate` text COMMENT '计算公式',
  `amount` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT '补偿小计',
  `code` char(20) NOT NULL COMMENT '兑付状态',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`),
  KEY `pay_id` (`pay_id`),
  KEY `subject_id` (`subject_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='兑付-科目';

-- ----------------------------
-- Records of pay_subject
-- ----------------------------
INSERT INTO `pay_subject` VALUES ('23', '1', '1', '1', '2', '20', '0', '1', '0', '', '800000.00', '110', '2018-03-06 15:26:53', '2018-03-06 19:31:33', null);
INSERT INTO `pay_subject` VALUES ('24', '1', '1', '1', '2', '20', '0', '17', '0', '', '3453.00', '111', '2018-03-06 19:31:33', '2018-03-06 19:31:33', null);
INSERT INTO `pay_subject` VALUES ('29', '1', '1', '1', '2', '23', '0', '17', '0', '', '50000.00', '112', '2018-03-08 15:15:03', '2018-03-08 15:15:03', null);
INSERT INTO `pay_subject` VALUES ('30', '1', '1', '1', '2', '23', '0', '4', '0', '', '6358.00', '113', '2018-03-08 15:15:03', '2018-03-08 15:15:03', null);

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
  `code` char(20) NOT NULL COMMENT '兑付状态',
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
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT ' 有效状态，0未生效，1生效，2失效',
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
INSERT INTO `role_menu` VALUES ('1', '231', null, null);
INSERT INTO `role_menu` VALUES ('1', '244', null, null);
INSERT INTO `role_menu` VALUES ('1', '245', null, null);
INSERT INTO `role_menu` VALUES ('1', '246', null, null);
INSERT INTO `role_menu` VALUES ('1', '248', null, null);
INSERT INTO `role_menu` VALUES ('1', '249', null, null);
INSERT INTO `role_menu` VALUES ('1', '252', null, null);

-- ----------------------------
-- Table structure for tear
-- ----------------------------
DROP TABLE IF EXISTS `tear`;
CREATE TABLE `tear` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL COMMENT '项目ID',
  `sign_at` date NOT NULL COMMENT '委托时间',
  `picture` text COMMENT '委托合同',
  `code` char(20) NOT NULL COMMENT '状态代码',
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
  `tear_at` date NOT NULL COMMENT '拆除日期',
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='人员管理';

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', '0', '1', 'demo', 'eyJpdiI6ImhOTm1oa3JHQzduR2JqbzdLY1NEckE9PSIsInZhbHVlIjoiTlpaTFVmdjlNbUFLMjN2Q3hzYW1RZz09IiwibWFjIjoiYzc3M2VhZWEyYjg5NTMzYjMyNmFmNjg2ZDNiNjIyMjMwOTYyZjMxMzlhZDE5MWJmNDIxMTUxNzZjYzk4YjRlNSJ9', '0860480D-B2FB-C834-2336-F4A9B0DB5AA9', '测试演示账号', null, null, null, '2018-03-14 09:15:56', '127.0.0.1', 'mOy7VydkXi19WPs0unyYqwJatT8glwxOlmDFYIrf', '2018-03-14 18:04:39', '2018-02-05 09:38:29', '2018-03-14 18:04:39', null);
INSERT INTO `user` VALUES ('3', '1', '1', 'admin', 'eyJpdiI6IlpzbzB5UUJvc2d6dWZSVlZvQmtIWXc9PSIsInZhbHVlIjoiclM5WkdYVk1sc0FQZ1lzbHRwVnY1dz09IiwibWFjIjoiMzNiNjZiYWZiMjEyZjAwNDkyMzFjZDEwN2I1Mzk3ZWJhNmRkYWMyZmE1MjQ2M2RmOWJiOTE5ODgxMjQzM2QwOCJ9', '0860480D-B2FB-C834-2336-F4A9B0DB5AA8', '我是主管', null, null, null, '2018-03-14 09:27:20', '::1', 'iIcm9EkdUrfKBmwcuhv2H25Ed0DVDl47T0Lnvu7j', '2018-03-14 14:20:23', '2018-02-05 09:38:29', '2018-03-14 14:20:23', null);
INSERT INTO `user` VALUES ('4', '1', '1', 'user', 'eyJpdiI6IlJCTXJaOFN3MWxOeUdqZWwyZ0JkTHc9PSIsInZhbHVlIjoia1wvd1EzTzY1MlE2WENwcUNid3M5aGc9PSIsIm1hYyI6IjI0NTAwNjA1OWY4MDg2NGRhNjE1YjhiMGEyYzIzY2FkNTk2NmRmYWNkMWM4ZDBhNmRjY2ZiOWM0ODI5YzJmNzIifQ==', '0860480D-B2FB-C834-2336-F4A9B0DB5AA1', '测试超管', null, null, null, '2018-03-14 13:54:37', '127.0.0.1', 'XoR8xdN6HBrytkRtAxaMN6r7eKrhDM2t7d2KxurQ', '2018-03-14 18:41:30', '2018-02-05 09:38:29', '2018-03-14 18:41:30', null);
INSERT INTO `user` VALUES ('5', '1', '2', 'main', 'eyJpdiI6IlwvUmg3Vnk3S2loQUhtaFk4QTFMWUh3PT0iLCJ2YWx1ZSI6InZPOG5zYmlDcGZkbm9BTHlSZXNGakE9PSIsIm1hYyI6IjFmYzlmOWFmZTFlYjllMWYyMGQwYmQwNGViODA5OTZlYzBiNDlkZGQ1Y2EzYjBlYmU4MjczYzVkZDk2MjlkN2MifQ==', '06F043FD-D1CA-FDC3-1CFA-D6B4F669453B', '主管是我', null, null, null, null, null, null, null, '2018-02-27 16:50:35', '2018-02-27 16:50:35', null);
INSERT INTO `user` VALUES ('6', '1', '3', 'second', 'eyJpdiI6IktiZVJFejdpbk8wbVh3VFN3MkxidkE9PSIsInZhbHVlIjoiQitpZGN6UXVNTmR5aklqTmVWeHRpQT09IiwibWFjIjoiZDFjM2E4ZjgzMGI4MjQyNjNhNjc3ODI4ZDA0ZmJmZDNkNmNmOGVmYTBmYjBhMmEwMzI1ZjYzM2ZmNzkxNjllMSJ9', 'BA43A48B-A125-1B88-B194-12C4F2ADFC1D', '我是分管', null, null, null, null, null, null, null, '2018-02-27 16:51:51', '2018-02-27 16:51:51', null);
INSERT INTO `user` VALUES ('7', '4', '4', 'resettle', 'eyJpdiI6IkwrMXRWRHRDaTJjeTY2TmVJUk1MWFE9PSIsInZhbHVlIjoiUGJ5cyt0cEFLS0lCdGdjQmRkZkoyZz09IiwibWFjIjoiYjUyZjVmNjJmNmFlMjEwZThmY2VmMWNiZjdlOTNkMmJiOTViMTZkMzc2MGY3MWE2NzgzN2Q4NDczMzFiMmNkZSJ9', 'AFE32CCA-C87E-D703-F577-254D58C08BB6', '安置', null, null, null, '2018-03-14 13:51:05', '127.0.0.1', 'XoR8xdN6HBrytkRtAxaMN6r7eKrhDM2t7d2KxurQ', '2018-03-14 13:52:59', '2018-02-27 16:52:32', '2018-03-14 13:52:59', null);
INSERT INTO `user` VALUES ('8', '5', '5', 'funds', 'eyJpdiI6Im5PbDRicSswbzBIaEdFaGxRWTk0NHc9PSIsInZhbHVlIjoiTXFwMlVxWHpUZ1h3ZlNwRG0wUkhNdz09IiwibWFjIjoiOGEyNmI2OGE2MGQyMGFmODE1OThiZDUzZjU5NjVjOWU1OTEwODBhNGViYWYxMzIzMzg3ODYxZGQ2YmQ1MmUwNSJ9', 'C7A3C540-74F1-64E1-041A-A91D9A7D078B', '账务', null, null, null, null, null, null, null, '2018-02-27 16:53:04', '2018-02-27 16:53:04', null);
