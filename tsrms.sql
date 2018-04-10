/*
Navicat MySQL Data Transfer

Source Server         : 192.168.1.88
Source Server Version : 50553
Source Host           : 192.168.1.88:3306
Source Database       : tsrms

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-04-09 16:51:00
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='公房单位';

-- ----------------------------
-- Records of admin_unit
-- ----------------------------
INSERT INTO `admin_unit` VALUES ('1', '公产单位1', '渝北区', '023-88888888', '张三', '13012345678', null, '2018-02-22 15:25:24', '2018-02-22 15:25:24', null);
INSERT INTO `admin_unit` VALUES ('2', '公产单位2', '渝北', '12135465', '张是', '1221454', '21321', '2018-03-09 15:15:02', '2018-03-09 15:15:02', null);
INSERT INTO `admin_unit` VALUES ('3', '工坊', '渝中', '023-12345678', '李四', '13012345678', '描述内容', '2018-03-24 10:39:23', '2018-03-24 10:39:23', null);

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='必备附件分类-数据表';

-- ----------------------------
-- Records of a_file_table
-- ----------------------------
INSERT INTO `a_file_table` VALUES ('1', 'item', '项目审查资料', '2018-03-24 11:24:56', '2018-03-24 11:24:56', null);
INSERT INTO `a_file_table` VALUES ('2', 'item_household_detail', '征收管理-被征户资料', '2018-03-24 11:32:19', '2018-03-26 11:02:24', null);
INSERT INTO `a_file_table` VALUES ('3', 'item_household_member', '被征户家庭成员资料', '2018-03-26 09:28:54', '2018-03-26 09:28:54', null);
INSERT INTO `a_file_table` VALUES ('4', 'com_assess_estate', '评估机构-被征收户资料', '2018-03-26 11:01:52', '2018-03-26 11:02:35', null);

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
INSERT INTO `a_item_funds_cate` VALUES ('2', '补偿款与产权调换房价之差额', null, '2018-02-09 16:02:20', '2018-03-14 18:50:39', null);
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
) ENGINE=MyISAM AUTO_INCREMENT=515 DEFAULT CHARSET=utf8 COMMENT='功能与菜单';

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
INSERT INTO `a_menu` VALUES ('41', '40', '项目管理', '<i class=\"menu-icon fa fa-folder bigger-120\"></i>', '0', '/gov/item#', null, '1', '1', '1', '1', null, '2018-02-10 12:25:16', '2018-02-10 12:31:43', null);
INSERT INTO `a_menu` VALUES ('42', '41', '我的项目', '<i class=\"menu-icon fa fa-grav bigger-120\"></i>', '0', '/gov/item', null, '1', '1', '1', '0', null, '2018-02-10 12:25:59', '2018-02-10 17:41:25', null);
INSERT INTO `a_menu` VALUES ('43', '41', '所有项目', '<i class=\"menu-icon fa fa-cubes bigger-120\"></i>', '0', '/gov/item_all', null, '1', '1', '1', '0', null, '2018-02-10 12:26:44', '2018-02-10 17:42:25', null);
INSERT INTO `a_menu` VALUES ('44', '41', '新建项目', '<i class=\"menu-icon fa fa-puzzle-piece bigger-120\"></i>', '0', '/gov/item_add', null, '1', '1', '1', '0', null, '2018-02-10 12:27:28', '2018-02-10 17:43:17', null);
INSERT INTO `a_menu` VALUES ('45', '40', '项目配置', '<i class=\"menu-icon fa fa-cog bigger-120\"></i>', '0', '/gov/iteminfo#', null, '1', '1', '1', '2', null, '2018-02-10 12:29:22', '2018-02-10 12:32:04', null);
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
INSERT INTO `a_menu` VALUES ('72', '51', '公房单位', null, '0', '/gov/adminunit', null, '1', '1', '1', '0', null, '2018-02-11 13:30:34', '2018-03-20 14:54:52', null);
INSERT INTO `a_menu` VALUES ('73', '72', '添加公房单位', null, '0', '/gov/adminunit_add', null, '1', '1', '0', '0', null, '2018-02-11 13:31:16', '2018-03-20 14:55:14', null);
INSERT INTO `a_menu` VALUES ('74', '72', '公房单位详情', null, '0', '/gov/adminunit_info', null, '1', '1', '0', '0', null, '2018-02-11 13:31:43', '2018-03-20 14:55:25', null);
INSERT INTO `a_menu` VALUES ('75', '72', '修改公房单位', null, '0', '/gov/adminunit_edit', null, '1', '1', '0', '0', null, '2018-02-11 13:32:12', '2018-03-20 14:55:36', null);
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
INSERT INTO `a_menu` VALUES ('106', '105', '添加必备附件分类', null, '0', '/gov/filecate_add', null, '1', '1', '0', '0', null, '2018-02-22 10:30:29', '2018-03-24 11:26:52', null);
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
INSERT INTO `a_menu` VALUES ('159', '40', '调查建档', '<i class=\"menu-icon fa fa-book bigger-120\"></i>', '0', '/gov/itemland#', null, '1', '1', '1', '4', null, '2018-02-22 13:41:45', '2018-02-22 15:09:40', null);
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
INSERT INTO `a_menu` VALUES ('172', '40', '征收决定', '<i class=\"menu-icon fa fa-file bigger-120\"></i>', '0', '/gov/itemdraft#', null, '1', '1', '1', '8', null, '2018-02-22 14:04:50', '2018-03-05 18:38:59', null);
INSERT INTO `a_menu` VALUES ('173', '172', '社会稳定风险评估', null, '0', '/gov/itemriskreport', null, '1', '1', '1', '2', null, '2018-02-22 14:06:05', '2018-03-20 15:20:35', null);
INSERT INTO `a_menu` VALUES ('174', '173', '自选社会风险评估调查话题', null, '0', '/gov/itemtopic', null, '1', '1', '1', '0', null, '2018-02-22 14:06:35', '2018-02-22 14:06:35', null);
INSERT INTO `a_menu` VALUES ('175', '174', '添加自选社会风险评估调查话题', null, '0', '/gov/itemtopic_add', null, '1', '1', '0', '0', null, '2018-02-22 14:07:55', '2018-02-22 14:07:55', null);
INSERT INTO `a_menu` VALUES ('176', '174', '自选社会风险评估调查话题详情', null, '0', '/gov/itemtopic_info', null, '1', '1', '0', '0', null, '2018-02-22 14:08:46', '2018-02-22 14:08:46', null);
INSERT INTO `a_menu` VALUES ('177', '174', '修改自选社会风险评估调查话题', null, '0', '/gov/itemtopic_edit', null, '1', '1', '0', '0', null, '2018-02-22 14:10:01', '2018-02-22 14:10:01', null);
INSERT INTO `a_menu` VALUES ('178', '192', '其他补偿事项单价', null, '0', '/gov/itemobject', null, '1', '1', '1', '0', null, '2018-02-22 14:13:20', '2018-02-22 14:13:20', null);
INSERT INTO `a_menu` VALUES ('179', '178', '添加其他补偿事项单价', null, '0', '/gov/itemobject_add', null, '1', '1', '0', '0', null, '2018-02-22 14:14:44', '2018-02-22 14:14:44', null);
INSERT INTO `a_menu` VALUES ('180', '178', '其他补偿事项单价详情', null, '0', '/gov/itemobject_info', null, '1', '1', '0', '0', null, '2018-02-22 14:15:31', '2018-02-22 14:15:31', null);
INSERT INTO `a_menu` VALUES ('181', '178', '修改其他补偿事项单价', null, '0', '/gov/itemobject_edit', null, '1', '1', '0', '0', null, '2018-02-22 14:16:31', '2018-02-22 14:16:31', null);
INSERT INTO `a_menu` VALUES ('182', '192', '补偿科目说明', null, '0', '/gov/itemsubject', null, '1', '1', '1', '0', null, '2018-02-22 14:18:08', '2018-02-22 14:18:08', null);
INSERT INTO `a_menu` VALUES ('183', '182', '添加补偿科目说明', null, '0', '/gov/itemsubject_add', null, '1', '1', '0', '0', null, '2018-02-22 14:18:58', '2018-02-22 14:18:58', null);
INSERT INTO `a_menu` VALUES ('184', '182', '补偿科目说明详情', null, '0', '/gov/itemsubject_info', null, '1', '1', '0', '0', null, '2018-02-22 14:20:15', '2018-02-22 14:20:15', null);
INSERT INTO `a_menu` VALUES ('185', '182', '修改补偿科目说明', null, '0', '/gov/itemsubject_edit', null, '1', '1', '0', '0', null, '2018-02-22 14:21:39', '2018-02-22 14:21:39', null);
INSERT INTO `a_menu` VALUES ('186', '40', '通知公告', '<i class=\"menu-icon fa fa-newspaper-o bigger-120\"></i>', '0', '/gov/itemnotice#', null, '1', '1', '1', '3', null, '2018-02-22 14:24:46', '2018-02-22 14:24:46', null);
INSERT INTO `a_menu` VALUES ('187', '186', '内部通知', null, '0', '/gov/itemnotice', null, '1', '1', '1', '0', null, '2018-02-22 14:26:35', '2018-03-02 09:08:23', null);
INSERT INTO `a_menu` VALUES ('188', '187', '添加内部通知', null, '0', '/gov/itemnotice_add', null, '1', '1', '0', '0', null, '2018-02-22 14:27:37', '2018-02-22 14:27:37', null);
INSERT INTO `a_menu` VALUES ('189', '187', '内部通知详情', null, '0', '/gov/itemnotice_info', null, '1', '1', '0', '0', null, '2018-02-22 14:29:02', '2018-02-22 14:29:02', null);
INSERT INTO `a_menu` VALUES ('190', '187', '修改内部通知', null, '0', '/gov/itemnotice_edit', null, '1', '1', '0', '0', null, '2018-02-22 14:29:56', '2018-02-22 14:29:56', null);
INSERT INTO `a_menu` VALUES ('191', '192', '添加征收方案', null, '0', '/gov/itemprogram_add', null, '1', '1', '0', '0', null, '2018-02-22 14:33:24', '2018-02-22 14:33:24', null);
INSERT INTO `a_menu` VALUES ('192', '172', '征收方案', null, '0', '/gov/itemprogram', null, '1', '1', '1', '3', null, '2018-02-22 14:34:52', '2018-03-20 15:20:57', null);
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
INSERT INTO `a_menu` VALUES ('211', '159', '入户摸底', null, '0', '/gov/household', null, '1', '1', '1', '0', null, '2018-02-24 09:01:14', '2018-03-26 14:03:28', null);
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
INSERT INTO `a_menu` VALUES ('234', '40', '房源控制', '<i class=\"menu-icon fa fa-building bigger-120\"></i>', '0', '/gov/itemhouse#', null, '1', '1', '1', '6', null, '2018-02-26 16:12:36', '2018-02-26 16:12:36', null);
INSERT INTO `a_menu` VALUES ('235', '234', '冻结房源', null, '0', '/gov/itemhouse', null, '1', '1', '1', '0', null, '2018-02-26 16:13:29', '2018-02-26 16:13:29', null);
INSERT INTO `a_menu` VALUES ('236', '235', '添加冻结房源', null, '0', '/gov/itemhouse_add', null, '1', '1', '0', '0', null, '2018-02-26 16:30:36', '2018-02-26 16:30:36', null);
INSERT INTO `a_menu` VALUES ('237', '235', '冻结房源详情', null, '0', '/gov/itemhouse_info', null, '1', '1', '0', '0', null, '2018-02-27 09:18:40', '2018-02-27 09:18:40', null);
INSERT INTO `a_menu` VALUES ('238', '40', '入围机构', '<i class=\"menu-icon fa fa-bank bigger-120\"></i>', '0', '/gov/itemcompany#', null, '1', '1', '1', '5', null, '2018-02-27 11:06:59', '2018-02-27 11:06:59', null);
INSERT INTO `a_menu` VALUES ('239', '238', '选定评估机构', null, '0', '/gov/itemcompany', null, '1', '1', '1', '0', null, '2018-02-27 11:21:37', '2018-02-27 11:21:37', null);
INSERT INTO `a_menu` VALUES ('240', '239', '选定评估机构-添加', null, '0', '/gov/itemcompany_add', null, '1', '1', '0', '0', null, '2018-02-27 11:57:51', '2018-02-27 11:57:51', null);
INSERT INTO `a_menu` VALUES ('241', '194', '添加时间规划', null, '0', '/gov/itemtime_add', null, '1', '1', '0', '0', null, '2018-02-27 18:55:38', '2018-02-27 18:55:38', null);
INSERT INTO `a_menu` VALUES ('242', '172', '征收意见稿', null, '0', '/gov/itemdraft', null, '1', '1', '1', '1', null, '2018-02-28 09:41:23', '2018-03-20 15:20:12', null);
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
INSERT INTO `a_menu` VALUES ('263', '0', '首页', '<i class=\"menu-icon fa fa-home bigger-120\"></i>', '1', '/com/home', null, '1', '1', '1', '0', null, '2018-03-01 14:29:00', '2018-03-22 10:19:51', null);
INSERT INTO `a_menu` VALUES ('264', '0', '简介', '<i class=\"menu-icon fa fa-list bigger-120\"></i>', '1', '/com/company_info#', null, '1', '1', '1', '0', null, '2018-03-01 14:29:45', '2018-03-08 15:26:41', null);
INSERT INTO `a_menu` VALUES ('265', '0', '我的项目', '<i class=\"menu-icon fa fa-th bigger-120\"></i>', '1', '/com/item', null, '1', '1', '1', '0', null, '2018-03-01 14:30:37', '2018-03-22 10:20:32', null);
INSERT INTO `a_menu` VALUES ('266', '0', '管理', '<i class=\"menu-icon fa fa-server bigger-120\"></i>', '1', '/com/companyuser#', null, '1', '1', '1', '0', null, '2018-03-01 14:57:35', '2018-03-08 15:57:40', null);
INSERT INTO `a_menu` VALUES ('267', '0', '设置', '<i class=\"menu-icon fa fa-cogs bigger-120\"></i>', '1', '/com/userself#', null, '1', '1', '1', '0', null, '2018-03-01 14:59:04', '2018-03-01 14:59:04', null);
INSERT INTO `a_menu` VALUES ('268', '40', '资金管理', '<i class=\"menu-icon fa fa-cny bigger-120\"></i>', '0', '/gov/funds#', null, '1', '1', '1', '7', null, '2018-03-01 15:30:36', '2018-03-01 15:31:10', null);
INSERT INTO `a_menu` VALUES ('269', '265', '项目地块', null, '1', '/com/itemland', null, '1', '1', '1', '0', null, '2018-03-01 15:37:28', '2018-03-22 09:19:47', null);
INSERT INTO `a_menu` VALUES ('270', '268', '资金预览', null, '0', '/gov/funds', null, '1', '1', '1', '0', null, '2018-03-01 17:25:43', '2018-03-01 17:25:43', null);
INSERT INTO `a_menu` VALUES ('271', '211', '被征收户-房屋建筑', null, '0', '/gov/householdbuilding', null, '1', '1', '1', '0', null, '2018-03-01 18:57:04', '2018-03-01 18:57:04', null);
INSERT INTO `a_menu` VALUES ('272', '268', '录入资金', null, '0', '/gov/funds_add', null, '1', '1', '1', '0', null, '2018-03-01 18:58:36', '2018-03-01 18:58:36', null);
INSERT INTO `a_menu` VALUES ('273', '271', '添加被征收户-房屋建筑', null, '0', '/gov/householdbuilding_add', null, '1', '1', '0', '0', null, '2018-03-01 18:57:48', '2018-03-01 18:57:48', null);
INSERT INTO `a_menu` VALUES ('274', '271', '被征收户-房屋建筑详情', null, '0', '/gov/householdbuilding_info', null, '1', '1', '0', '0', null, '2018-03-01 19:02:26', '2018-03-01 19:02:26', null);
INSERT INTO `a_menu` VALUES ('275', '271', '修改被征收户-房屋建筑', null, '0', '/gov/householdbuilding_edit', null, '1', '1', '0', '0', null, '2018-03-01 19:03:36', '2018-03-01 19:03:36', null);
INSERT INTO `a_menu` VALUES ('276', '283', '社会稳定性风险评估详情', null, '0', '/gov/itemrisk_info', null, '1', '1', '0', '0', null, '2018-03-01 19:09:36', '2018-03-01 19:09:36', null);
INSERT INTO `a_menu` VALUES ('277', '270', '转账详情', null, '0', '/gov/funds_info', null, '1', '1', '0', '0', null, '2018-03-01 20:31:34', '2018-03-01 20:31:34', null);
INSERT INTO `a_menu` VALUES ('278', '186', '政务公告', null, '0', '/gov/news', null, '1', '1', '1', '0', null, '2018-03-02 09:09:12', '2018-03-02 09:09:12', null);
INSERT INTO `a_menu` VALUES ('279', '278', '添加征收范围公告', null, '0', '/gov/news_add', null, '1', '1', '0', '0', null, '2018-03-02 09:09:49', '2018-03-15 18:52:07', null);
INSERT INTO `a_menu` VALUES ('280', '278', '公告详情', null, '0', '/gov/news_info', null, '1', '1', '0', '0', null, '2018-03-02 10:44:46', '2018-03-02 10:44:46', null);
INSERT INTO `a_menu` VALUES ('281', '278', '修改征收范围公告', null, '0', '/gov/news_edit', null, '1', '1', '0', '0', null, '2018-03-02 10:56:31', '2018-03-15 18:52:29', null);
INSERT INTO `a_menu` VALUES ('282', '0', '首页', '<i class=\"menu-icon fa fa-dashboard bigger-120\"></i>', '2', '/household/home', '', '1', '1', '1', '0', null, '2018-03-02 11:10:50', '2018-03-02 11:10:50', null);
INSERT INTO `a_menu` VALUES ('283', '321', '意见调查', '<i class=\"menu-icon fa fa-info bigger-120\"></i>', '2', '/household/itemrisk_info', null, '1', '1', '1', '0', null, '2018-03-02 11:18:04', '2018-03-08 10:24:24', null);
INSERT INTO `a_menu` VALUES ('287', '238', '评估机构投票', '', '0', '/gov/companyvote', null, '1', '1', '1', '0', null, '2018-03-02 18:13:54', '2018-03-02 18:13:54', null);
INSERT INTO `a_menu` VALUES ('285', '283', '添加社会稳定风险评估', null, '2', '/household/itemrisk_add', null, '1', '0', '0', '0', null, '2018-03-02 15:26:29', '2018-03-02 15:31:12', null);
INSERT INTO `a_menu` VALUES ('286', '283', '修改社会稳定风险评估', null, '2', '/household/itemrisk_edit', null, '1', '0', '0', '0', null, '2018-03-02 15:31:54', '2018-03-02 15:31:54', null);
INSERT INTO `a_menu` VALUES ('288', '287', '评估机构投票详情', null, '0', '/gov/companyvote_info', null, '1', '1', '0', '0', null, '2018-03-02 18:14:55', '2018-03-02 18:14:55', null);
INSERT INTO `a_menu` VALUES ('289', '40', '项目实施', '<i class=\"menu-icon fa fa-balance-scale bigger-120\"></i>', '0', '/gov/pay#', null, '1', '1', '1', '9', null, '2018-03-05 08:43:01', '2018-03-20 15:39:16', null);
INSERT INTO `a_menu` VALUES ('290', '289', '协商协议', null, '0', '/gov/pay', null, '1', '1', '1', '0', null, '2018-03-05 08:43:40', '2018-03-20 14:50:29', null);
INSERT INTO `a_menu` VALUES ('291', '290', '补偿决定', null, '0', '/gov/pay_add', null, '1', '1', '0', '0', null, '2018-03-05 08:44:26', '2018-03-10 15:51:49', null);
INSERT INTO `a_menu` VALUES ('292', '290', '补偿详情', null, '0', '/gov/pay_info', null, '1', '1', '0', '0', null, '2018-03-05 08:44:46', '2018-03-20 14:50:47', null);
INSERT INTO `a_menu` VALUES ('293', '290', '修改兑付', null, '0', '/gov/pay_edit', null, '1', '1', '0', '0', null, '2018-03-05 08:46:34', '2018-03-05 08:46:34', null);
INSERT INTO `a_menu` VALUES ('294', '319', '评估机构投票', null, '2', '/household/itemcompanyvote', null, '1', '1', '1', '0', null, '2018-03-05 09:25:24', '2018-03-19 09:45:40', null);
INSERT INTO `a_menu` VALUES ('320', '294', '我的投票', null, '2', '/household/itemcompanyvote_info', null, '1', '1', '0', '0', null, '2018-03-07 15:28:14', '2018-03-07 15:28:14', null);
INSERT INTO `a_menu` VALUES ('295', '294', '添加评估机构投票', null, '2', '/household/itemcompanyvote_add', null, '1', '0', '0', '0', null, '2018-03-05 09:45:55', '2018-03-05 10:35:44', null);
INSERT INTO `a_menu` VALUES ('296', '294', '修改评估机构投票', null, '2', '/household/itemcompanyvote_edit', null, '1', '0', '0', '0', null, '2018-03-05 09:46:52', '2018-03-05 11:14:38', null);
INSERT INTO `a_menu` VALUES ('297', '192', '特殊人群的优惠上浮', null, '0', '/gov/itemcrowd', null, '1', '1', '1', '0', null, '2018-03-05 14:09:06', '2018-03-19 21:00:22', null);
INSERT INTO `a_menu` VALUES ('298', '297', '添加特殊人群优惠上浮率', null, '0', '/gov/itemcrowd_add', null, '1', '1', '0', '0', null, '2018-03-05 14:12:18', '2018-03-05 14:12:18', null);
INSERT INTO `a_menu` VALUES ('299', '297', '特殊人群优惠上浮率详情', null, '0', '/gov/itemcrowd_info', null, '1', '1', '0', '0', null, '2018-03-05 14:13:12', '2018-03-05 14:13:12', null);
INSERT INTO `a_menu` VALUES ('300', '297', '修改特殊人群优惠上浮率', null, '0', '/gov/itemcrowd_edit', null, '1', '1', '0', '0', null, '2018-03-05 14:14:01', '2018-03-05 14:14:01', null);
INSERT INTO `a_menu` VALUES ('301', '54', '工作提醒数量', null, '0', '/gov/noticenum', null, '1', '0', '0', '0', null, '2018-03-05 16:19:43', '2018-03-05 16:19:43', null);
INSERT INTO `a_menu` VALUES ('302', '192', '产权调换房的优惠上浮', null, '0', '/gov/itemhouserate', null, '1', '1', '1', '0', null, '2018-03-05 16:45:03', '2018-03-19 21:00:02', null);
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
INSERT INTO `a_menu` VALUES ('318', '265', '入户摸底', null, '1', '/com/household', null, '1', '1', '1', '0', null, '2018-03-07 09:11:44', '2018-03-22 09:20:17', null);
INSERT INTO `a_menu` VALUES ('319', '0', '投票', '<i class=\"menu-icon fa fa-comment bigger-120\"></i>', '2', '/household/itemcompanyvote#', null, '1', '1', '1', '0', null, '2018-03-07 13:41:51', '2018-03-07 14:03:24', null);
INSERT INTO `a_menu` VALUES ('321', '0', '更多', '<i class=\"menu-icon fa fa-th-large bigger-120\"></i>', '2', '/household/pay#', null, '1', '1', '1', '10', null, '2018-03-07 15:56:59', '2018-03-07 15:56:59', null);
INSERT INTO `a_menu` VALUES ('322', '319', '入围机构', null, '2', '/household/itemcompany', null, '1', '1', '1', '0', null, '2018-03-07 16:24:34', '2018-03-07 16:24:34', null);
INSERT INTO `a_menu` VALUES ('323', '294', '评估机构详情', null, '2', '/household/company_info', null, '1', '1', '0', '0', null, '2018-03-07 17:07:40', '2018-03-07 17:07:40', null);
INSERT INTO `a_menu` VALUES ('324', '0', '产权', '<i class=\"menu-icon fa fa-home bigger-120\"></i>', '2', '/household/householddetail#', null, '1', '1', '1', '0', null, '2018-03-08 09:37:19', '2018-03-08 09:37:19', null);
INSERT INTO `a_menu` VALUES ('326', '0', '房源', '<i class=\"menu-icon fa fa-building bigger-120\"></i>', '2', '/household/itemhouse#', null, '1', '1', '1', '0', null, '2018-03-08 10:27:37', '2018-03-08 10:27:37', null);
INSERT INTO `a_menu` VALUES ('327', '326', '所有房源', null, '2', '/household/itemhouse', null, '1', '1', '1', '0', null, '2018-03-08 10:28:31', '2018-03-08 10:28:31', null);
INSERT INTO `a_menu` VALUES ('328', '264', '简介详情', null, '1', '/com/company_info', null, '1', '1', '1', '0', null, '2018-03-08 15:10:47', '2018-03-23 14:30:52', null);
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
INSERT INTO `a_menu` VALUES ('359', '366', '处理产权争议', null, '0', '/gov/householdright_add', null, '1', '1', '0', '0', null, '2018-03-14 17:26:24', '2018-03-14 17:26:24', null);
INSERT INTO `a_menu` VALUES ('360', '366', '产权争议解决详情', null, '0', '/gov/householdright_info', null, '1', '1', '0', '0', null, '2018-03-14 17:27:45', '2018-03-14 17:27:45', null);
INSERT INTO `a_menu` VALUES ('361', '207', '初步预算审查（项目准备）', null, '0', '/gov/ready_init_check', null, '1', '1', '0', '0', null, '2018-03-14 18:07:22', '2018-03-14 18:08:09', null);
INSERT INTO `a_menu` VALUES ('362', '207', '开启项目筹备（项目准备）', null, '0', '/gov/ready_prepare', null, '1', '1', '0', '0', null, '2018-03-14 18:27:05', '2018-03-14 18:38:25', null);
INSERT INTO `a_menu` VALUES ('363', '207', '项目资金（项目准备）', null, '0', '/gov/ready_funds', null, '1', '1', '0', '0', null, '2018-03-15 09:13:22', '2018-03-15 09:14:30', null);
INSERT INTO `a_menu` VALUES ('364', '207', '项目房源（项目准备）', null, '0', '/gov/ready_house', null, '1', '1', '0', '0', null, '2018-03-15 09:16:24', '2018-03-15 09:16:24', null);
INSERT INTO `a_menu` VALUES ('365', '207', '项目筹备审查 （项目准备）', null, '0', '/gov/ready_prepare_check', null, '1', '1', '0', '0', null, '2018-03-15 09:20:57', '2018-03-15 20:20:57', null);
INSERT INTO `a_menu` VALUES ('366', '358', '产权争议', null, '0', '/gov/householdright', null, '1', '1', '1', '0', null, '2018-03-15 09:41:33', '2018-03-15 09:41:33', null);
INSERT INTO `a_menu` VALUES ('367', '358', '违建处理', null, '0', '/gov/householdbuildingdeal', null, '1', '1', '1', '0', null, '2018-03-15 09:44:50', '2018-03-15 09:44:50', null);
INSERT INTO `a_menu` VALUES ('368', '367', '添加违建处理', null, '0', '/gov/householdbuildingdeal_add', null, '1', '1', '0', '0', null, '2018-03-15 09:45:44', '2018-03-15 11:26:49', null);
INSERT INTO `a_menu` VALUES ('369', '367', '违建处理详情', null, '0', '/gov/householdbuildingdeal_info', null, '1', '1', '0', '0', null, '2018-03-15 09:46:50', '2018-03-15 11:26:07', null);
INSERT INTO `a_menu` VALUES ('370', '358', '面积争议', null, '0', '/gov/householdbuildingarea', null, '1', '1', '1', '0', null, '2018-03-15 09:47:32', '2018-03-15 09:47:32', null);
INSERT INTO `a_menu` VALUES ('371', '370', '处理面积争议', null, '0', '/gov/householdbuildingarea_add', null, '1', '1', '0', '0', null, '2018-03-15 09:48:16', '2018-03-15 09:48:16', null);
INSERT INTO `a_menu` VALUES ('372', '370', '面积争议解决详情', null, '0', '/gov/householdbuildingarea_info', null, '1', '1', '0', '0', null, '2018-03-15 09:48:59', '2018-03-15 09:48:59', null);
INSERT INTO `a_menu` VALUES ('373', '367', '违建处理-违建建筑列表', null, '0', '/gov/householdbuildingdeal_infos', null, '1', '1', '0', '0', null, '2018-03-15 11:23:44', '2018-03-15 11:23:44', null);
INSERT INTO `a_menu` VALUES ('374', '367', '合法性认定', null, '0', '/gov/householdbuildingdeal_status', null, '1', '1', '0', '0', null, '2018-03-15 11:28:38', '2018-03-15 11:28:38', null);
INSERT INTO `a_menu` VALUES ('375', '207', '征收范围公告审查（项目准备）', null, '0', '/gov/ready_range_check', null, '1', '1', '0', '0', null, '2018-03-15 20:21:36', '2018-03-15 20:21:36', null);
INSERT INTO `a_menu` VALUES ('376', '159', '调查统计', null, '0', '/gov/survey', null, '1', '1', '1', '0', null, '2018-03-16 09:25:39', '2018-03-16 10:37:09', null);
INSERT INTO `a_menu` VALUES ('377', '207', '入户调查数据审查（调查建档）', null, '0', '/gov/survey_check', null, '1', '1', '0', '0', null, '2018-03-16 09:27:12', '2018-03-16 09:27:12', null);
INSERT INTO `a_menu` VALUES ('378', '358', '测绘报告', null, '0', '/gov/landlayout_reportlist', null, '1', '1', '1', '0', null, '2018-03-16 09:38:52', '2018-03-16 09:38:52', null);
INSERT INTO `a_menu` VALUES ('379', '378', '添加测绘报告', null, '0', '/gov/landlayout_reportadd', null, '1', '1', '0', '0', null, '2018-03-16 09:40:01', '2018-03-16 09:40:01', null);
INSERT INTO `a_menu` VALUES ('380', '378', '测绘报告详情', null, '0', '/gov/landlayout_reportinfo', null, '1', '1', '0', '0', null, '2018-03-16 09:40:57', '2018-03-16 09:40:57', null);
INSERT INTO `a_menu` VALUES ('381', '358', '资产确认', null, '0', '/gov/householdassets_report', null, '1', '1', '1', '0', null, '2018-03-16 09:50:39', '2018-03-16 09:50:39', null);
INSERT INTO `a_menu` VALUES ('382', '381', '添加资产确认', null, '0', '/gov/householdassets_reportadd', null, '1', '1', '0', '0', null, '2018-03-16 09:51:28', '2018-03-16 09:51:28', null);
INSERT INTO `a_menu` VALUES ('383', '381', '资产确认详情', null, '0', '/gov/householdassets_reportinfo', null, '1', '1', '0', '0', null, '2018-03-16 09:52:02', '2018-03-16 09:52:02', null);
INSERT INTO `a_menu` VALUES ('384', '381', '资产列表', null, '0', '/gov/householdassets_reportlist', null, '1', '1', '0', '0', null, '2018-03-16 11:33:42', '2018-03-16 11:33:42', null);
INSERT INTO `a_menu` VALUES ('385', '327', '房源详情', null, '2', '/household/itemhouse_info', null, '1', '1', '0', '0', null, '2018-03-16 17:25:58', '2018-03-16 17:25:58', null);
INSERT INTO `a_menu` VALUES ('386', '327', '添加备选安置房', null, '2', '/household/payhousebak_add', null, '1', '1', '0', '0', null, '2018-03-16 18:03:40', '2018-03-21 11:18:51', null);
INSERT INTO `a_menu` VALUES ('387', '326', '我的选房', null, '2', '/household/payhousebak', null, '1', '1', '1', '0', null, '2018-03-19 09:23:10', '2018-03-19 09:46:36', null);
INSERT INTO `a_menu` VALUES ('388', '358', '房产确认', null, '0', '/gov/buildingconfirm', null, '1', '1', '1', '0', null, '2018-03-19 10:13:53', '2018-03-19 10:13:53', null);
INSERT INTO `a_menu` VALUES ('389', '388', '房产确认详情', null, '0', '/gov/buildingconfirm_info', null, '1', '1', '0', '0', null, '2018-03-19 10:15:26', '2018-03-19 10:15:26', null);
INSERT INTO `a_menu` VALUES ('390', '207', '征收意见稿审查（征收决定）', null, '0', '/gov/draft_check', null, '1', '1', '0', '0', null, '2018-03-19 11:06:04', '2018-03-19 11:08:25', null);
INSERT INTO `a_menu` VALUES ('391', '278', '添加征收意见稿公告', null, '0', '/gov/draft_notice_add', null, '1', '1', '0', '0', null, '2018-03-19 12:03:00', '2018-03-19 12:03:00', null);
INSERT INTO `a_menu` VALUES ('392', '278', '修改征收意见稿公告', null, '0', '/gov/draft_notice_edit', null, '1', '1', '0', '0', null, '2018-03-19 12:03:41', '2018-03-19 12:03:41', null);
INSERT INTO `a_menu` VALUES ('393', '388', '关联建筑-房屋建筑列表', null, '0', '/gov/buildingrelated', null, '1', '1', '0', '0', null, '2018-03-19 14:43:46', '2018-03-19 14:55:18', null);
INSERT INTO `a_menu` VALUES ('394', '388', '关联建筑-关联评估数据', null, '0', '/gov/buildingrelated_com', null, '1', '1', '0', '0', null, '2018-03-19 15:13:44', '2018-03-19 15:13:44', null);
INSERT INTO `a_menu` VALUES ('395', '317', '修改兑付方式', null, '2', '/household/pay_edit', null, '1', '1', '0', '0', null, '2018-03-19 16:54:58', '2018-03-19 16:54:58', null);
INSERT INTO `a_menu` VALUES ('396', '207', '风险评估报告审查（征收决定）', null, '0', '/gov/riskreport_check', null, '1', '1', '0', '0', null, '2018-03-19 17:20:26', '2018-03-19 17:20:26', null);
INSERT INTO `a_menu` VALUES ('397', '388', '关联建筑-关联评估数据详情', null, '0', '/gov/relatedcom_info', null, '1', '1', '0', '0', null, '2018-03-19 17:23:03', '2018-03-19 17:23:03', null);
INSERT INTO `a_menu` VALUES ('398', '207', '正式征收方案提交审查（征收决定）', null, '0', '/gov/program_to_check', null, '1', '1', '0', '0', null, '2018-03-19 17:51:13', '2018-03-19 17:51:13', null);
INSERT INTO `a_menu` VALUES ('399', '207', '正式征收方案审查（征收决定）', null, '0', '/gov/program_check', null, '1', '1', '0', '0', null, '2018-03-19 17:51:37', '2018-03-19 17:51:37', null);
INSERT INTO `a_menu` VALUES ('400', '192', '产权调换房的签约奖励', null, '0', '/gov/itemreward', null, '1', '1', '0', '0', null, '2018-03-19 20:56:39', '2018-03-19 20:56:39', null);
INSERT INTO `a_menu` VALUES ('401', '400', '添加签约奖励', null, '0', '/gov/itemreward_add', null, '1', '1', '0', '0', null, '2018-03-19 20:57:36', '2018-03-19 20:57:36', null);
INSERT INTO `a_menu` VALUES ('402', '400', '修改签约奖励', null, '0', '/gov/itemreward_edit', null, '1', '1', '0', '0', null, '2018-03-19 20:57:59', '2018-03-19 20:57:59', null);
INSERT INTO `a_menu` VALUES ('403', '278', '添加征收决定公告', null, '0', '/gov/program_notice_add', null, '1', '1', '0', '0', null, '2018-03-20 11:57:55', '2018-03-20 11:57:55', null);
INSERT INTO `a_menu` VALUES ('404', '278', '修改征收决定公告', null, '0', '/gov/program_notice_edit', null, '1', '1', '0', '0', null, '2018-03-20 11:58:23', '2018-03-20 11:58:23', null);
INSERT INTO `a_menu` VALUES ('405', '207', '项目开始实施（项目实施）', null, '0', '/gov/pay_start', null, '1', '1', '0', '0', null, '2018-03-20 13:58:32', '2018-03-20 13:58:32', null);
INSERT INTO `a_menu` VALUES ('406', '234', '临时周转', null, '0', '/gov/transit', null, '1', '1', '1', '0', null, '2018-03-20 14:36:48', '2018-03-20 14:36:48', null);
INSERT INTO `a_menu` VALUES ('407', '234', '产权调换', null, '0', '/gov/resettle', null, '1', '1', '1', '0', null, '2018-03-20 14:37:17', '2018-03-20 14:37:17', null);
INSERT INTO `a_menu` VALUES ('408', '49', '房源管理费', null, '0', '/gov/housemanagefee', null, '1', '1', '1', '0', null, '2018-03-20 14:54:25', '2018-03-20 14:54:25', null);
INSERT INTO `a_menu` VALUES ('409', '268', '被征收户', null, '0', '/gov/funds_household', null, '1', '1', '1', '0', null, '2018-03-20 15:07:43', '2018-03-20 15:07:43', null);
INSERT INTO `a_menu` VALUES ('410', '268', '公房单位', null, '0', '/gov/funds_unit', null, '1', '1', '1', '0', null, '2018-03-20 15:08:14', '2018-03-20 15:08:14', null);
INSERT INTO `a_menu` VALUES ('411', '268', '项目支出', null, '0', '/gov/funds_out', null, '1', '1', '1', '0', null, '2018-03-20 15:09:01', '2018-03-20 15:09:01', null);
INSERT INTO `a_menu` VALUES ('412', '289', '公房单位', null, '0', '/gov/payunit', null, '1', '1', '1', '0', null, '2018-03-20 15:15:26', '2018-03-20 15:15:26', null);
INSERT INTO `a_menu` VALUES ('413', '289', '腾空搬迁', null, '0', '/gov/move', null, '1', '1', '1', '0', null, '2018-03-20 15:17:11', '2018-03-20 15:17:11', null);
INSERT INTO `a_menu` VALUES ('414', '40', '项目审计', '<i class=\"menu-icon fa fa-legal bigger-120\"></i>', '0', '/gov/audit#', null, '1', '1', '1', '10', null, '2018-03-20 15:18:45', '2018-03-20 15:18:45', null);
INSERT INTO `a_menu` VALUES ('415', '414', '审计报告', null, '0', '/gov/audit', null, '1', '1', '1', '0', null, '2018-03-20 15:19:24', '2018-03-20 15:19:24', null);
INSERT INTO `a_menu` VALUES ('416', '278', '添加其他公告', null, '0', '/gov/news_other_add', null, '1', '1', '0', '0', null, '2018-03-20 15:59:16', '2018-03-20 15:59:16', null);
INSERT INTO `a_menu` VALUES ('417', '278', '修改公告', null, '0', '/gov/news_other_edit', null, '1', '1', '0', '0', null, '2018-03-20 15:59:36', '2018-03-20 15:59:36', null);
INSERT INTO `a_menu` VALUES ('418', '409', '被征收户补偿详情', null, '0', '/gov/funds_household_info', null, '1', '1', '0', '0', null, '2018-03-20 18:50:04', '2018-03-20 18:50:04', null);
INSERT INTO `a_menu` VALUES ('422', '420', '公共附属物信息确认', null, '0', '/gov/publicinfo', null, '1', '1', '0', '0', null, '2018-03-21 14:21:17', '2018-03-21 14:21:17', null);
INSERT INTO `a_menu` VALUES ('420', '358', '公共附属物确认', null, '0', '/gov/landiist', null, '1', '1', '1', '0', null, '2018-03-21 11:17:17', '2018-03-21 11:17:17', null);
INSERT INTO `a_menu` VALUES ('421', '420', '公共附属物列表', null, '0', '/gov/publiclist', null, '1', '1', '0', '0', null, '2018-03-21 11:18:29', '2018-03-21 11:18:29', null);
INSERT INTO `a_menu` VALUES ('423', '387', '移除房源', null, '2', '/household/payhousebak_remove', null, '1', '1', '0', '0', null, '2018-03-21 16:54:41', '2018-03-21 16:54:41', null);
INSERT INTO `a_menu` VALUES ('424', '289', '监督拆除', null, '0', '/gov/tear', null, '1', '1', '1', '0', null, '2018-03-21 17:02:57', '2018-03-21 17:02:57', null);
INSERT INTO `a_menu` VALUES ('425', '317', '补偿科目详情', null, '2', '/household/paysubject_info', null, '1', '1', '0', '0', null, '2018-03-21 17:48:22', '2018-03-21 17:48:22', null);
INSERT INTO `a_menu` VALUES ('426', '265', '信息评估', null, '1', '/com/comassess', null, '1', '1', '1', '0', null, '2018-03-21 18:00:18', '2018-03-22 09:20:51', null);
INSERT INTO `a_menu` VALUES ('463', '415', '添加审计报告', null, '0', '/gov/audit_add', null, '1', '1', '0', '0', null, '2018-03-22 10:27:34', '2018-03-22 10:27:34', null);
INSERT INTO `a_menu` VALUES ('427', '269', '项目地块-添加', null, '1', '/com/itemland_add', null, '1', '1', '0', '0', null, '2018-03-22 09:22:30', '2018-03-22 09:22:30', null);
INSERT INTO `a_menu` VALUES ('428', '269', '项目地块-详情', null, '1', '/com/itemland_info', null, '1', '1', '0', '0', null, '2018-03-22 09:23:11', '2018-03-22 09:23:11', null);
INSERT INTO `a_menu` VALUES ('429', '269', '项目地块-修改', null, '1', '/com/itemland_edit', null, '1', '1', '0', '0', null, '2018-03-22 09:23:58', '2018-03-22 09:23:58', null);
INSERT INTO `a_menu` VALUES ('430', '269', '地块楼栋', null, '1', '/com/itembuilding', null, '1', '1', '0', '0', null, '2018-03-22 09:27:44', '2018-03-22 10:35:14', null);
INSERT INTO `a_menu` VALUES ('431', '430', '地块楼栋-添加', null, '1', '/com/itembuilding_add', null, '1', '1', '0', '0', null, '2018-03-22 09:28:47', '2018-03-22 09:28:47', null);
INSERT INTO `a_menu` VALUES ('432', '430', '地块楼栋-详情', null, '1', '/com/itembuilding_info', null, '1', '1', '0', '0', null, '2018-03-22 09:28:47', '2018-03-22 09:28:47', null);
INSERT INTO `a_menu` VALUES ('433', '430', '地块楼栋-修改', null, '1', '/com/itembuilding_edit', null, '1', '1', '0', '0', null, '2018-03-22 09:28:47', '2018-03-22 09:28:47', null);
INSERT INTO `a_menu` VALUES ('434', '269', '公共附属物', null, '1', '/com/itempublic', null, '1', '1', '0', '0', null, '2018-03-22 09:33:22', '2018-03-22 10:35:31', null);
INSERT INTO `a_menu` VALUES ('435', '434', '公共附属物-添加', null, '1', '/com/itempublic_add', null, '1', '1', '0', '0', null, '2018-03-22 09:36:10', '2018-03-22 09:36:10', null);
INSERT INTO `a_menu` VALUES ('436', '434', '公共附属物-详情', null, '1', '/com/itempublic_info', null, '1', '1', '0', '0', null, '2018-03-22 09:36:10', '2018-03-22 09:36:10', null);
INSERT INTO `a_menu` VALUES ('437', '434', '公共附属物-修改', null, '1', '/com/itempublic_edit', null, '1', '1', '0', '0', null, '2018-03-22 09:36:10', '2018-03-22 09:36:10', null);
INSERT INTO `a_menu` VALUES ('438', '269', '地块户型', null, '1', '/comlandlayout', null, '1', '1', '0', '0', null, '2018-03-22 09:50:44', '2018-03-22 10:36:06', null);
INSERT INTO `a_menu` VALUES ('439', '412', '补偿详情', null, '0', '/gov/payunit_info', null, '1', '1', '0', '0', null, '2018-03-22 09:52:40', '2018-03-22 09:52:40', null);
INSERT INTO `a_menu` VALUES ('440', '409', '生成支付总单', null, '0', '/gov/funds_pay_total', null, '1', '1', '0', '0', null, '2018-03-22 09:54:13', '2018-03-22 09:54:13', null);
INSERT INTO `a_menu` VALUES ('441', '438', '地块户型-添加', null, '1', '/com/landlayout_add', null, '1', '1', '0', '0', null, '2018-03-22 09:53:38', '2018-03-22 09:53:38', null);
INSERT INTO `a_menu` VALUES ('442', '268', '支付总单支付', null, '0', '/gov/funds_pay_total_funds', null, '1', '1', '0', '0', null, '2018-03-22 09:56:24', '2018-03-22 09:56:24', null);
INSERT INTO `a_menu` VALUES ('443', '410', '补偿详情', null, '0', '/gov/funds_unit_info', null, '1', '1', '0', '0', null, '2018-03-22 09:56:55', '2018-03-22 09:56:55', null);
INSERT INTO `a_menu` VALUES ('444', '410', '生成支付总单', null, '0', '/gov/funds_unit_total', null, '1', '1', '0', '0', null, '2018-03-22 09:57:22', '2018-03-22 09:57:22', null);
INSERT INTO `a_menu` VALUES ('445', '438', '地块户型-详情', null, '1', '/com/landlayout_info', null, '1', '1', '0', '0', null, '2018-03-22 09:55:55', '2018-03-22 09:55:55', null);
INSERT INTO `a_menu` VALUES ('446', '438', '地块户型-修改', null, '1', '/com/landlayout_edit', null, '1', '1', '0', '0', null, '2018-03-22 09:56:46', '2018-03-22 09:56:46', null);
INSERT INTO `a_menu` VALUES ('447', '413', '标记已搬迁', null, '0', '/gov/move_edit', null, '1', '1', '0', '0', null, '2018-03-22 10:00:12', '2018-03-22 10:00:12', null);
INSERT INTO `a_menu` VALUES ('448', '424', '添加拆除委托', null, '0', '/gov/tear_add', null, '1', '1', '0', '0', null, '2018-03-22 10:01:07', '2018-03-22 10:01:07', null);
INSERT INTO `a_menu` VALUES ('449', '318', '入户摸底详情', null, '1', '/com/household_info', null, '1', '1', '0', '0', null, '2018-03-22 10:04:06', '2018-03-22 10:04:06', null);
INSERT INTO `a_menu` VALUES ('450', '318', '摸底信息-添加', null, '1', '/com/household_add', null, '1', '1', '0', '0', null, '2018-03-22 10:05:08', '2018-03-22 10:05:08', null);
INSERT INTO `a_menu` VALUES ('451', '318', '摸底信息-修改', null, '1', '/com/household_edit', null, '1', '1', '0', '0', null, '2018-03-22 10:05:57', '2018-03-22 10:05:57', null);
INSERT INTO `a_menu` VALUES ('452', '318', '添加房屋建筑', null, '1', '/com/household_buildingadd', null, '1', '1', '0', '0', null, '2018-03-22 10:07:20', '2018-03-22 10:07:20', null);
INSERT INTO `a_menu` VALUES ('453', '318', '房屋建筑详情', null, '1', '/com/household_buildinginfo', null, '1', '1', '0', '0', null, '2018-03-22 10:08:14', '2018-03-22 10:08:14', null);
INSERT INTO `a_menu` VALUES ('454', '318', '修改房屋建筑信息', null, '1', '/com/household_buildingedit', null, '1', '1', '0', '0', null, '2018-03-22 10:08:50', '2018-03-22 10:08:50', null);
INSERT INTO `a_menu` VALUES ('455', '426', '开始评估', null, '1', '/com/comassess_add', null, '1', '1', '0', '0', null, '2018-03-22 10:10:51', '2018-03-22 10:10:51', null);
INSERT INTO `a_menu` VALUES ('456', '426', '修改评估', null, '1', '/com/comassess_info', null, '1', '1', '0', '0', null, '2018-03-22 10:12:29', '2018-03-22 10:12:29', null);
INSERT INTO `a_menu` VALUES ('457', '426', '评估公共附属物-地块列表', null, '1', '/com/comassess_publiclist', null, '1', '1', '0', '0', null, '2018-03-22 10:13:40', '2018-03-22 10:13:40', null);
INSERT INTO `a_menu` VALUES ('458', '426', '评估公共附属物-开始评估', null, '1', '/com/comassess_publiclist', null, '1', '1', '0', '0', null, '2018-03-22 10:14:23', '2018-03-22 10:14:23', null);
INSERT INTO `a_menu` VALUES ('459', '267', '修改信息', null, '1', '/com/userself_edit', null, '1', '1', '0', '0', null, '2018-03-22 10:15:18', '2018-03-22 10:15:18', null);
INSERT INTO `a_menu` VALUES ('460', '424', '修改拆除委托', null, '0', '/gov/tear_edit', null, '1', '1', '0', '0', null, '2018-03-22 10:17:25', '2018-03-22 10:17:25', null);
INSERT INTO `a_menu` VALUES ('461', '267', '修改密码', null, '1', '/com/userself_pwd', null, '1', '1', '0', '0', null, '2018-03-22 10:15:48', '2018-03-22 10:15:48', null);
INSERT INTO `a_menu` VALUES ('462', '424', '添加拆除记录', null, '0', '/gov/tear_detail_add', null, '1', '1', '0', '0', null, '2018-03-22 10:18:00', '2018-03-22 10:18:00', null);
INSERT INTO `a_menu` VALUES ('464', '0', '常用工具', null, '1', '#', null, '1', '1', '0', '0', null, '2018-03-22 11:57:01', '2018-03-22 11:57:01', null);
INSERT INTO `a_menu` VALUES ('465', '464', '错误提示页', null, '1', '/com/error', null, '1', '1', '0', '0', null, '2018-03-22 11:57:32', '2018-03-22 11:57:32', null);
INSERT INTO `a_menu` VALUES ('466', '464', '文件上传', null, '1', '/com/upl', null, '1', '1', '0', '0', null, '2018-03-22 11:58:09', '2018-03-22 11:58:09', null);
INSERT INTO `a_menu` VALUES ('467', '406', '临时周转详情', null, '0', '/gov/transit_info', null, '1', '1', '0', '0', null, '2018-03-22 15:29:55', '2018-03-22 15:29:55', null);
INSERT INTO `a_menu` VALUES ('468', '406', '开始过渡', null, '0', '/gov/transit_add', null, '1', '1', '0', '0', null, '2018-03-22 15:30:21', '2018-03-22 15:30:21', null);
INSERT INTO `a_menu` VALUES ('469', '406', '结束过渡', null, '0', '/gov/transit_edit', null, '1', '1', '0', '0', null, '2018-03-22 15:30:43', '2018-03-22 15:30:43', null);
INSERT INTO `a_menu` VALUES ('470', '407', '产权调换详情', null, '0', '/gov/resettle_info', null, '1', '1', '0', '0', null, '2018-03-22 17:18:56', '2018-03-22 17:18:56', null);
INSERT INTO `a_menu` VALUES ('471', '407', '开始安置', null, '0', '/gov/resettle_add', null, '1', '1', '0', '0', null, '2018-03-22 17:19:25', '2018-03-22 17:19:25', null);
INSERT INTO `a_menu` VALUES ('472', '407', '更新安置状态', null, '0', '/gov/resettle_edit', null, '1', '1', '0', '0', null, '2018-03-22 17:19:59', '2018-03-22 17:19:59', null);
INSERT INTO `a_menu` VALUES ('473', '408', '计算房源管理费', null, '0', '/gov/housemanagefee_add', null, '1', '1', '0', '0', null, '2018-03-22 18:32:49', '2018-03-22 18:32:49', null);
INSERT INTO `a_menu` VALUES ('474', '282', '通知公告详情', null, '2', '/household/news_info', null, '1', '1', '0', '0', null, '2018-03-23 14:12:41', '2018-03-23 14:12:41', null);
INSERT INTO `a_menu` VALUES ('475', '105', '修改必备附件分类', null, '0', '/gov/filecate_edit', null, '1', '1', '0', '0', null, '2018-03-24 11:41:57', '2018-03-24 11:42:19', null);
INSERT INTO `a_menu` VALUES ('476', '290', '补偿安置协议', null, '0', '/gov/pact_add', null, '1', '1', '0', '0', null, '2018-03-24 13:55:39', '2018-03-24 13:55:39', null);
INSERT INTO `a_menu` VALUES ('477', '239', '评估委托书', null, '0', '/gov/itemcompany_pic', null, '1', '1', '0', '0', null, '2018-03-26 15:05:16', '2018-03-26 15:05:16', null);
INSERT INTO `a_menu` VALUES ('478', '172', '评估报告', null, '0', '/gov/assess', null, '1', '1', '1', '0', null, '2018-03-26 16:58:10', '2018-03-26 16:58:10', null);
INSERT INTO `a_menu` VALUES ('479', '478', '分户评估报告', null, '0', '/gov/assess_info', null, '1', '1', '0', '0', null, '2018-03-26 16:58:58', '2018-03-26 16:58:58', null);
INSERT INTO `a_menu` VALUES ('480', '388', '房产信息确认', null, '0', '/gov/edit_status', null, '1', '1', '0', '0', null, '2018-03-26 17:01:32', '2018-03-26 17:01:32', null);
INSERT INTO `a_menu` VALUES ('481', '317', '确认签约', null, '2', '/household/payhouse_add', null, '1', '1', '0', '0', null, '2018-03-26 18:07:21', '2018-03-26 18:19:10', null);
INSERT INTO `a_menu` VALUES ('482', '478', '评估报告审查', null, '0', '/gov/assess_check', null, '1', '1', '0', '0', null, '2018-03-29 15:22:07', '2018-03-29 15:22:07', null);
INSERT INTO `a_menu` VALUES ('483', '331', '确认评估报告', null, '2', '/household/assess_confirm', null, '1', '1', '0', '0', null, '2018-03-29 16:51:20', '2018-03-29 16:51:20', null);
INSERT INTO `a_menu` VALUES ('484', '123', '删除房源管理机构', null, '0', '/gov/housecompany_del', null, '1', '1', '0', '0', null, '2018-04-02 10:22:59', '2018-04-02 10:22:59', null);
INSERT INTO `a_menu` VALUES ('485', '127', '删除房源社区', null, '0', '/gov/housecommunity_del', null, '1', '1', '0', '0', null, '2018-04-02 11:47:24', '2018-04-02 11:47:24', null);
INSERT INTO `a_menu` VALUES ('486', '131', '删除房源户型图', null, '0', '/gov/houselayoutimg_del', null, '1', '1', '0', '0', null, '2018-04-02 11:58:37', '2018-04-02 11:58:37', null);
INSERT INTO `a_menu` VALUES ('487', '135', '删除房源', null, '0', '/gov/house_del', null, '1', '1', '0', '0', null, '2018-04-02 14:20:45', '2018-04-02 14:20:45', null);
INSERT INTO `a_menu` VALUES ('488', '89', '删除评估机构', null, '0', '/gov/company_del', null, '1', '1', '0', '0', null, '2018-04-02 15:03:23', '2018-04-02 15:03:23', null);
INSERT INTO `a_menu` VALUES ('489', '89', '评估机构-审查', null, '0', '/gov/company_status', null, '1', '1', '0', '0', null, '2018-04-02 15:47:55', '2018-04-02 15:47:55', null);
INSERT INTO `a_menu` VALUES ('490', '343', '删除地块户型', null, '0', '/gov/landlayout_del', null, '1', '1', '0', '0', null, '2018-04-02 16:20:08', '2018-04-02 16:20:08', null);
INSERT INTO `a_menu` VALUES ('491', '168', '删除公共附属物', null, '0', '/gov/itempublic_del', null, '1', '1', '0', '0', null, '2018-04-02 17:03:05', '2018-04-02 17:03:05', null);
INSERT INTO `a_menu` VALUES ('492', '164', '删除地块楼栋', null, '0', '/gov/itembuilding_del', null, '1', '1', '0', '0', null, '2018-04-02 17:47:46', '2018-04-02 17:47:46', null);
INSERT INTO `a_menu` VALUES ('493', '160', '删除项目地块', null, '0', '/gov/itemland_del', null, '1', '1', '0', '0', null, '2018-04-02 18:20:16', '2018-04-02 18:20:16', null);
INSERT INTO `a_menu` VALUES ('494', '476', '重新生成协议', null, '0', '/gov/pact_reset_pact', null, '1', '1', '0', '0', null, '2018-04-03 09:28:00', '2018-04-03 14:51:17', null);
INSERT INTO `a_menu` VALUES ('495', '228', '删除其他事项', null, '0', '/gov/householdobject_del', null, '1', '1', '0', '0', null, '2018-04-03 09:53:44', '2018-04-03 09:53:44', null);
INSERT INTO `a_menu` VALUES ('496', '220', '删除特殊人群', null, '0', '/gov/householdmembercrowd_del', null, '1', '1', '0', '0', null, '2018-04-03 11:26:37', '2018-04-03 11:26:37', null);
INSERT INTO `a_menu` VALUES ('497', '476', '协议详情', null, '0', '/gov/pact_info', null, '1', '1', '0', '0', null, '2018-04-03 11:33:44', '2018-04-03 11:33:44', null);
INSERT INTO `a_menu` VALUES ('498', '214', '删除家庭成员', null, '0', '/gov/householdmember_del', null, '1', '1', '0', '0', null, '2018-04-03 11:54:17', '2018-04-03 11:54:17', null);
INSERT INTO `a_menu` VALUES ('499', '354', '删除被征收户-资产', null, '0', '/gov/householdassets_del', null, '1', '1', '0', '0', null, '2018-04-03 13:52:43', '2018-04-03 13:52:43', null);
INSERT INTO `a_menu` VALUES ('500', '271', '删除被征收户-房屋建筑', null, '0', '/gov/householdbuilding_del', null, '1', '1', '0', '0', null, '2018-04-03 14:22:52', '2018-04-03 14:22:52', null);
INSERT INTO `a_menu` VALUES ('501', '212', '删除被征户账号', null, '0', '/gov/household_del', null, '1', '1', '0', '0', null, '2018-04-03 14:45:34', '2018-04-03 14:45:34', null);
INSERT INTO `a_menu` VALUES ('502', '318', '删除房屋建筑', null, '1', '/com/household_buildingdel', null, '1', '1', '0', '0', null, '2018-04-03 15:27:22', '2018-04-03 15:27:22', null);
INSERT INTO `a_menu` VALUES ('503', '332', '删除操作员', null, '1', '/com/companyuser_del', null, '1', '1', '0', '0', null, '2018-04-03 15:35:14', '2018-04-03 15:35:14', null);
INSERT INTO `a_menu` VALUES ('504', '333', '删除评估师', null, '1', '/com/companyvaluer_del', null, '1', '1', '0', '0', null, '2018-04-03 15:35:54', '2018-04-03 15:35:54', null);
INSERT INTO `a_menu` VALUES ('505', '278', '添加评估报告', null, '0', '/gov/assess_report_add', null, '1', '1', '0', '0', null, '2018-04-03 15:50:14', '2018-04-03 15:50:14', null);
INSERT INTO `a_menu` VALUES ('506', '278', '修改评估报告', null, '0', '/gov/assess_report_edit', null, '1', '1', '0', '0', null, '2018-04-03 15:50:37', '2018-04-03 15:50:37', null);
INSERT INTO `a_menu` VALUES ('507', '207', '项目实施完成', null, '0', '/gov/pay_end', null, '1', '1', '0', '0', null, '2018-04-03 16:14:48', '2018-04-03 16:14:48', null);
INSERT INTO `a_menu` VALUES ('508', '207', '项目结束', null, '0', '/gov/item_end', null, '1', '1', '0', '0', null, '2018-04-03 16:30:58', '2018-04-03 16:30:58', null);
INSERT INTO `a_menu` VALUES ('509', '290', '补偿协议审查', null, '0', '/gov/pact_check', null, '1', '1', '0', '0', null, '2018-04-03 16:34:07', '2018-04-03 16:34:07', null);
INSERT INTO `a_menu` VALUES ('510', '407', '添加入住通知', null, '0', '/gov/resettle_notice_add', null, '1', '1', '0', '0', null, '2018-04-08 10:37:02', '2018-04-08 10:37:02', null);
INSERT INTO `a_menu` VALUES ('511', '407', '入住通知详情', null, '0', '/gov/resettle_notice_info', null, '1', '1', '0', '0', null, '2018-04-08 10:37:44', '2018-04-08 10:37:44', null);
INSERT INTO `a_menu` VALUES ('512', '317', '确认签约', null, '2', '/household/pay_confirm', null, '1', '0', '0', '0', null, '2018-04-08 11:29:08', '2018-04-08 11:29:08', null);
INSERT INTO `a_menu` VALUES ('513', '476', '兑付表', null, '0', '/gov/pay_table', null, '1', '1', '0', '0', null, '2018-04-09 14:05:41', '2018-04-09 14:05:41', null);
INSERT INTO `a_menu` VALUES ('514', '476', '评估报告', null, '0', '/gov/assess_pic', null, '1', '1', '0', '0', null, '2018-04-09 15:38:35', '2018-04-09 15:38:35', null);

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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='通知公告-分类';

-- ----------------------------
-- Records of a_news_cate
-- ----------------------------
INSERT INTO `a_news_cate` VALUES ('1', '征收范围公告', null, '2018-02-09 16:24:03', '2018-02-09 16:27:03', null);
INSERT INTO `a_news_cate` VALUES ('2', '征收意见稿公告', null, '2018-03-19 11:31:26', '2018-03-19 11:31:26', null);
INSERT INTO `a_news_cate` VALUES ('3', '征收决定公告', null, '2018-03-20 11:22:50', '2018-03-20 11:22:50', null);
INSERT INTO `a_news_cate` VALUES ('4', '评估报告', null, '2018-03-20 13:35:04', '2018-03-20 13:35:04', null);
INSERT INTO `a_news_cate` VALUES ('5', '其他公告', null, '2018-03-20 15:52:55', '2018-03-20 15:52:55', null);

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='协议分类';

-- ----------------------------
-- Records of a_pact_cate
-- ----------------------------
INSERT INTO `a_pact_cate` VALUES ('1', '补偿安置协议', null, '2018-03-13 14:49:28', '2018-03-13 14:49:28', null);
INSERT INTO `a_pact_cate` VALUES ('2', '补偿安置补充协议', null, '2018-03-13 14:49:40', '2018-03-13 14:49:40', null);
INSERT INTO `a_pact_cate` VALUES ('3', '公房单位补偿协议', null, '2018-03-21 16:28:44', '2018-03-21 16:28:44', null);

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
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COMMENT='项目流程';

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
INSERT INTO `a_process` VALUES ('19', '2', '0', '项目筹备审查', '2', '365', '120', '1', null, '2018-02-28 13:46:04', '2018-03-15 09:21:17', null);
INSERT INTO `a_process` VALUES ('20', '2', '17', '重新预算', '1', '259', '101', '1', null, '2018-03-14 16:46:39', '2018-03-14 18:08:44', null);
INSERT INTO `a_process` VALUES ('21', '2', '18', '项目资金', '1', '363', '111', '1', null, '2018-03-14 18:13:15', '2018-03-15 09:14:56', null);
INSERT INTO `a_process` VALUES ('22', '2', '18', '冻结房源', '1', '364', '112', '1', null, '2018-03-14 18:28:34', '2018-03-15 09:16:45', null);
INSERT INTO `a_process` VALUES ('23', '2', '0', '征收范围公告', '1', '279', '130', '1', null, '2018-03-15 09:25:27', '2018-03-15 18:51:40', null);
INSERT INTO `a_process` VALUES ('24', '2', '0', '征收范围公告审查', '2', '375', '140', '1', null, '2018-03-15 09:26:13', '2018-03-15 20:21:53', null);
INSERT INTO `a_process` VALUES ('25', '3', '0', '入户调查', '1', '376', '150', '1', null, '2018-03-16 09:00:58', '2018-03-16 09:27:52', null);
INSERT INTO `a_process` VALUES ('26', '3', '25', '项目地块', '1', '160', '151', '1', null, '2018-03-16 09:02:50', '2018-03-16 09:09:31', null);
INSERT INTO `a_process` VALUES ('27', '3', '25', '入户摸底', '1', '211', '152', '1', null, '2018-03-16 09:03:35', '2018-03-16 09:10:16', null);
INSERT INTO `a_process` VALUES ('28', '3', '25', '确权确户', '1', '358', '153', '1', null, '2018-03-16 09:04:24', '2018-03-16 09:10:30', null);
INSERT INTO `a_process` VALUES ('29', '3', '25', '选定评估机构', '1', '239', '154', '1', null, '2018-03-16 09:07:03', '2018-03-16 09:10:49', null);
INSERT INTO `a_process` VALUES ('30', '3', '0', '入户调查数据审查', '2', '377', '160', '1', null, '2018-03-16 09:09:12', '2018-03-16 17:50:52', null);
INSERT INTO `a_process` VALUES ('31', '4', '0', '拟定征收意见稿', '1', '250', '170', '1', null, '2018-03-16 17:19:16', '2018-03-16 17:19:16', null);
INSERT INTO `a_process` VALUES ('32', '4', '0', '征收意见稿审查', '2', '390', '180', '1', null, '2018-03-16 17:21:24', '2018-03-19 11:06:35', null);
INSERT INTO `a_process` VALUES ('33', '4', '0', '发布征收意见稿', '1', '391', '190', '1', null, '2018-03-16 17:23:24', '2018-03-19 13:35:45', null);
INSERT INTO `a_process` VALUES ('34', '4', '0', '社会稳定风险评估', '1', '260', '200', '1', null, '2018-03-16 17:24:16', '2018-03-19 13:38:50', null);
INSERT INTO `a_process` VALUES ('35', '4', '0', '风险评估报告审查', '2', '396', '210', '1', null, '2018-03-19 13:52:22', '2018-03-19 17:50:15', null);
INSERT INTO `a_process` VALUES ('36', '4', '0', '正式征收方案', '1', '398', '220', '1', null, '2018-03-19 13:54:28', '2018-03-19 17:52:14', null);
INSERT INTO `a_process` VALUES ('37', '4', '0', '正式征收方案审查', '2', '399', '230', '1', null, '2018-03-20 10:14:28', '2018-03-20 10:14:39', null);
INSERT INTO `a_process` VALUES ('38', '4', '0', '发布征收决定公告', '1', '403', '240', '1', null, '2018-03-20 10:58:08', '2018-03-20 11:58:37', null);
INSERT INTO `a_process` VALUES ('39', '5', '0', '项目实施', '1', '405', '250', '1', null, '2018-03-20 11:42:56', '2018-03-20 13:58:50', null);
INSERT INTO `a_process` VALUES ('40', '5', '39', '协商协议', '1', '476', '251', '1', null, '2018-03-20 13:36:51', '2018-04-03 09:27:04', null);
INSERT INTO `a_process` VALUES ('41', '5', '39', '补偿协议审查', '2', '509', '252', '1', null, '2018-03-20 13:37:25', '2018-04-03 16:34:27', null);
INSERT INTO `a_process` VALUES ('42', '5', '39', '腾空搬迁', '1', '413', '253', '1', null, '2018-03-20 13:38:15', '2018-04-03 16:02:40', null);
INSERT INTO `a_process` VALUES ('43', '5', '39', '监督拆除', '1', '424', '254', '1', null, '2018-04-03 09:13:24', '2018-04-03 16:02:53', null);
INSERT INTO `a_process` VALUES ('44', '5', '0', '项目实施完成', '1', '507', '260', '1', null, '2018-04-03 09:14:43', '2018-04-03 16:15:10', null);
INSERT INTO `a_process` VALUES ('45', '6', '0', '审计报告', '1', '463', '270', '1', null, '2018-04-03 10:03:21', '2018-04-03 10:03:47', null);
INSERT INTO `a_process` VALUES ('46', '6', '0', '项目结束', '1', '508', '280', '1', null, '2018-04-03 10:06:28', '2018-04-03 16:31:20', null);

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
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 COMMENT='状态代码';

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
INSERT INTO `a_state_code` VALUES ('56', '155', '锁定（房源）', '2018-03-10 17:01:54', '2018-03-20 17:13:13', null);
INSERT INTO `a_state_code` VALUES ('57', '170', '待签约（协议）', '2018-03-22 15:56:46', '2018-03-22 15:56:46', null);
INSERT INTO `a_state_code` VALUES ('58', '171', '已签约（协议）', '2018-03-22 15:57:03', '2018-03-22 15:57:03', null);
INSERT INTO `a_state_code` VALUES ('59', '172', '审查中（协议）', '2018-03-22 15:57:17', '2018-03-22 15:57:17', null);
INSERT INTO `a_state_code` VALUES ('60', '173', '审查通过（协议）', '2018-03-22 15:57:33', '2018-03-22 15:57:33', null);
INSERT INTO `a_state_code` VALUES ('61', '174', '审查驳回（协议）', '2018-03-22 15:59:30', '2018-03-22 15:59:30', null);
INSERT INTO `a_state_code` VALUES ('62', '175', '兑付中（协议）', '2018-03-22 16:01:28', '2018-03-22 16:01:28', null);
INSERT INTO `a_state_code` VALUES ('63', '176', '兑付完成（协议）', '2018-03-22 16:01:44', '2018-03-22 16:01:44', null);

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='银行';

-- ----------------------------
-- Records of bank
-- ----------------------------
INSERT INTO `bank` VALUES ('1', '中国工商银行', null, '2018-02-09 15:32:05', '2018-02-09 15:32:05', null);
INSERT INTO `bank` VALUES ('2', '中国银行', '描述内容', '2018-03-24 10:43:45', '2018-03-24 10:43:45', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='评估机构';

-- ----------------------------
-- Records of company
-- ----------------------------
INSERT INTO `company` VALUES ('1', '0', '房产估价公司', '渝北区力华科谷', '023-12345678', '023-12345678', '张三', '13012345678', null, null, '房产评估机构的简介内容', null, '1', '41', '2018-03-12 09:09:39', '2018-03-16 18:46:06', null);
INSERT INTO `company` VALUES ('2', '1', '资产评估机构', '渝北区力华科谷A区', '023-87654321', '023-87654321', '李四', '13012341234', null, null, '资产评估机构的简介内容', null, '2', '41', '2018-03-12 09:36:27', '2018-03-12 09:36:27', null);
INSERT INTO `company` VALUES ('3', '0', '房产1', '1', '1', '1', '1', '1', null, '1', '1', null, '3', '41', '2018-04-02 15:51:22', '2018-04-02 15:53:24', '2018-04-02 15:53:24');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='评估机构-操作员';

-- ----------------------------
-- Records of company_user
-- ----------------------------
INSERT INTO `company_user` VALUES ('1', '1', '操作员', null, '123456', 'eyJpdiI6IjNHUzJiU1VzcFhkZGo0RWdwZTJ1d1E9PSIsInZhbHVlIjoiOHFTY0htaHJyXC9iVHJ1djVSaEdVTVE9PSIsIm1hYyI6ImM1YjNlZDc0M2ZjMTAyNmUyYmIwYzVlNGUxOGQ0MTlhNGNhOTI3MWM2YzVjYjJmNWU2NTcyOGZiNjUyYWI3MTUifQ==', '457320B0-B96E-3EBF-B302-BD12880D258A', '8NbEf7pDDQANnWo7Nd5mC1jW84gKjqd8ez5f1K4X', '2018-04-08 09:08:13', '2018-03-12 09:09:39', '2018-04-08 09:08:13', null);
INSERT INTO `company_user` VALUES ('2', '2', '操作员2', null, '654321', 'eyJpdiI6InQxdm1DaFdEaFBobFpcL3FcL1R2WWxFZz09IiwidmFsdWUiOiJVbXhZSk5rTjFuMjFLVXVRRXpQQUN3PT0iLCJtYWMiOiJiZGJjNmEzMTcwMTAwYTZjMWMyODIzNTg3NTYyOGU3YjJjMTJhNDA4M2NlMWZmYTY4YTk0YTE5NTcwODA5MmI5In0=', 'EE7867F0-B340-5CD3-394A-D0C2D789A6FE', '3GBdrBJ5u31xVGocSIZIo36NzWnJP1b19c2s2Z3P', '2018-04-04 17:43:51', '2018-03-12 09:36:27', '2018-04-04 17:43:51', null);
INSERT INTO `company_user` VALUES ('3', '3', null, null, '124564', 'eyJpdiI6IkZGck1GUnViUVwvaHVTeHFaTHJOSFV3PT0iLCJ2YWx1ZSI6ImxpYlBxREpxMlNtYitUMHhjWWxCMEE9PSIsIm1hYyI6IjM2OWM5OGVkMzQ0NWQxYTdmZWU5NzU1ZjFjOTVkYjMzYmE4NDkyZDRlOGZjYTUxOWU3YjIwMDUyNWFkNTQ1NTkifQ==', 'C85F5CB7-AEDA-F6D8-1A77-BFD3754C7E0F', null, null, '2018-04-02 15:51:22', '2018-04-02 15:53:24', '2018-04-02 15:53:24');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='评估机构-评估师';

-- ----------------------------
-- Records of company_valuer
-- ----------------------------
INSERT INTO `company_valuer` VALUES ('1', '1', '张三', '13012341234', '21546957465456', '2018-03-31', '2018-03-20 15:07:42', '2018-03-27 15:40:01', null);
INSERT INTO `company_valuer` VALUES ('2', '1', '李四', '123545644', '3213254', '2018-07-19', '2018-03-20 15:08:05', '2018-04-03 16:42:05', null);
INSERT INTO `company_valuer` VALUES ('3', '2', '资产评估师', '4564612', '13246845', '2018-03-24', '2018-03-21 09:58:37', '2018-03-21 09:58:37', null);
INSERT INTO `company_valuer` VALUES ('4', '2', '资产2', '1545641', '13216464', '2018-03-31', '2018-03-21 09:58:54', '2018-03-21 09:58:54', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='评估-汇总';

-- ----------------------------
-- Records of com_assess
-- ----------------------------
INSERT INTO `com_assess` VALUES ('3', '1', '2', '1', '1', '0.00', '1.00', '132', '2018-03-20 16:20:00', '2018-03-21 10:50:01', null);
INSERT INTO `com_assess` VALUES ('4', '1', '1', '1', '1', '5000.00', '1200.00', '136', null, '2018-03-28 14:01:56', null);
INSERT INTO `com_assess` VALUES ('5', '3', '4', '6', '2', '0.00', '100.00', '136', '2018-03-29 10:42:10', '2018-03-29 16:59:05', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='评估-资产评估';

-- ----------------------------
-- Records of com_assess_assets
-- ----------------------------
INSERT INTO `com_assess_assets` VALUES ('1', '1', '1', '1', '1', '4', '2', '50000.00', '[\"\\/storage\\/180321\\/BLcZekN0ORFQyJbh9wKvEqTTqoQqMNWXgOGLOjEP.jpeg\"]', '136', '2018-03-20 18:04:49', '2018-03-21 10:50:01', null);
INSERT INTO `com_assess_assets` VALUES ('2', '1', '2', '1', '1', '4', '2', '100000.00', '[\"\\/storage\\/180321\\/1EjnPvbymhVAArgWkG2eH12QlDNJcFz6EuuyPtbd.jpeg\"]', '136', '2018-03-20 18:04:49', '2018-03-21 10:30:57', null);
INSERT INTO `com_assess_assets` VALUES ('3', '3', '4', '6', '2', '5', '2', '100.00', '[\"\\/storage\\/180329\\/5yFanxSgOL2SSlquX8zcaN2yPjaMLc48QycXWzNg.jpeg\"]', '132', '2018-03-29 10:46:19', '2018-03-29 11:15:33', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='评估-房产评估';

-- ----------------------------
-- Records of com_assess_estate
-- ----------------------------
INSERT INTO `com_assess_estate` VALUES ('2', '1', '2', '1', '1', '4', '1', '2241.00', '0.00', '2241.00', '[\"\\/storage\\/180320\\/NaVJhlPc6M5WvYvOUvm4EYmRRuTOSz1WV9unFQcv.jpeg\"]', '136', '0', '123456789', null, '100.00', '10.00', '0', '0', '{\"com_house\":[\"\\/storage\\/180326\\/V84QOfJvy3K8i4gk262VfBmBkQqaNig4QVE0BTPU.jpeg\"],\"com_house2\":[\"\\/storage\\/180326\\/luQnyylQUNrOXBLseRLcyHilwAAWHAsRLwly2j53.jpeg\"],\"com_house3\":[\"\\/storage\\/180326\\/TsW4TX1jMznsNo1Ue5ax96r9Hb039cpB6jHU2fhY.jpeg\"]}', '1', '1', '1', null, '/storage/180314/lMjVjLuOt5DRLtk1CnnBB7oa3N0p9jRa9NLrLpFE.jpeg', '2018-03-14 11:29:33', '2018-03-20 17:46:17', null);
INSERT INTO `com_assess_estate` VALUES ('4', '1', '1', '1', '1', '4', '1', '1200.00', '0.00', '1200.00', null, '136', '0', '654321', null, '100.00', '10.00', '0', '0', '{\"com_house\":[\"\\/storage\\/180326\\/V84QOfJvy3K8i4gk262VfBmBkQqaNig4QVE0BTPU.jpeg\"],\"com_house2\":[\"\\/storage\\/180326\\/luQnyylQUNrOXBLseRLcyHilwAAWHAsRLwly2j53.jpeg\"],\"com_house3\":[\"\\/storage\\/180326\\/TsW4TX1jMznsNo1Ue5ax96r9Hb039cpB6jHU2fhY.jpeg\"]}', '1', '1', '1', '1', '/storage/180326/kXNvVP8oJd7HUeH5M6qTqFCWf2fNVaTaVNoq2EY4.jpeg', '2018-03-26 11:43:36', '2018-03-28 14:01:56', null);
INSERT INTO `com_assess_estate` VALUES ('5', '3', '4', '6', '2', '5', '1', '10000.00', '0.00', '10000.00', '[\"\\/storage\\/180329\\/X03Nb0EwJVFu7p5akE13m7MQ5OmhF4umHe8hbJru.jpeg\"]', '132', '0', '132121', null, '100.00', '10.00', '0', '0', '{\"com_house\":[\"\\/storage\\/180329\\/WPsCADykpMQdxBPSC5hNFFb3XIqi9lZSFFQ51iIo.jpeg\"],\"com_house2\":[\"\\/storage\\/180329\\/K3Y4fnzuV6JIoUrngVTfwn2xpCHwL5mij8xwq2sr.jpeg\"],\"com_house3\":[\"\\/storage\\/180329\\/CqZUGqDoUJThvbYpY1ayhipTtITaPdNwJ3FuRDCU.jpeg\"]}', '1', '1', '1', '21', '/storage/180329/yeWtSi69066s194VPJXbKnb73ivdoUXjWeSzFRvy.jpeg', '2018-03-29 09:33:56', '2018-03-29 11:14:51', null);

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
INSERT INTO `com_assess_valuer` VALUES ('1', '1', '1', '1', '3', '1', '0', '2', '3', '2018-03-21 10:50:01', '2018-03-21 10:50:01', null);
INSERT INTO `com_assess_valuer` VALUES ('1', '1', '1', '1', '4', '0', '4', '1', '1', '2018-03-28 14:01:56', '2018-03-28 14:01:56', null);
INSERT INTO `com_assess_valuer` VALUES ('3', '4', '6', '2', '5', '0', '5', '1', '1', '2018-03-29 11:14:51', '2018-03-29 11:14:51', null);
INSERT INTO `com_assess_valuer` VALUES ('3', '4', '6', '2', '5', '3', '0', '2', '4', '2018-03-29 11:15:33', '2018-03-29 11:15:33', null);

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
  `build_year` year(4) DEFAULT NULL COMMENT '建造年份',
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='评估-房产-房屋建筑';

-- ----------------------------
-- Records of com_estate_building
-- ----------------------------
INSERT INTO `com_estate_building` VALUES ('1', '1', '1', '4', '4', '1', '1', '1', '4', '10.00', '1200.00', '建筑A', '90', null, '100.00', '20.00', null, '120.00', '1', '1', '1', '东', '12', '2018', '1', '[\"\\/storage\\/180316\\/VXFFgitn4ylvifRLPXpmUUV3KkaUal9nt39n0HlR.jpeg\"]', '2018-03-16 16:47:43', '2018-03-28 14:01:56', null);
INSERT INTO `com_estate_building` VALUES ('2', '1', '1', '4', '2', '2', '1', '1', '6', '1.00', '2121.00', '建筑B', '90', null, '1212.00', '121.00', null, '2121.00', '1', '1', '1', '南', '35', null, '1', '[\"\\/storage\\/180319\\/f0AtZJLuguu57UMRBuXsN0is3cEO1VEtkIF6ZOoI.jpeg\"]', '2018-03-19 19:11:39', '2018-03-20 17:46:17', null);
INSERT INTO `com_estate_building` VALUES ('3', '3', '1', '0', '0', '4', '6', '2', '10', '100.00', '10000.00', '建筑A', '90', null, '100.00', '10.00', null, '100.00', '1', '1', '1', '东', '12', '2018', '5', '[\"\\/storage\\/180329\\/epSrCpUnn7UD4WC1pFxCsZxGMuYd2g9BZvDjc7UX.jpeg\"]', '2018-03-29 09:34:31', '2018-03-29 11:14:51', null);
INSERT INTO `com_estate_building` VALUES ('4', '1', '1', '0', '0', '1', '1', '1', '0', '0.00', '0.00', '1', '91', null, '1.00', '1.00', null, '1.00', '1', '1', '1', '1', '1', '2018', '1', '[\"\\/storage\\/180403\\/mVHtIBo9ScWUD3ouONfYYChvvVDKhCsmy6gZpTB0.jpeg\"]', '2018-04-03 16:07:50', '2018-04-03 16:17:22', '2018-04-03 16:17:22');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='评估-公共附属物';

-- ----------------------------
-- Records of com_public
-- ----------------------------
INSERT INTO `com_public` VALUES ('2', '1', '2', '220.00', '[\"\\/storage\\/180321\\/RoQLR6pjJA4K90vkzesP8rZT0W5YSMkiYgXOV8Ya.jpeg\"]', '2018-03-21 17:37:39', '2018-03-21 17:37:39', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='评估-公共附属物明细';

-- ----------------------------
-- Records of com_public_detail
-- ----------------------------
INSERT INTO `com_public_detail` VALUES ('3', '1', '1', '1', '1', '2', '2', '11.00', '110.00', '2018-03-21 17:37:39', '2018-03-21 17:37:39', null);
INSERT INTO `com_public_detail` VALUES ('4', '1', '1', '0', '2', '2', '2', '11.00', '110.00', '2018-03-21 17:37:39', '2018-03-21 17:37:39', null);

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
  UNIQUE KEY `name` (`name`,`parent_id`) USING BTREE COMMENT '名称唯一'
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='特殊人群分类';

-- ----------------------------
-- Records of crowd
-- ----------------------------
INSERT INTO `crowd` VALUES ('1', '0', '残疾', '根据残疾等级，按最高等级补助', '2018-04-02 18:15:28', '2018-04-02 18:15:28', null);
INSERT INTO `crowd` VALUES ('2', '1', '一级残疾', null, '2018-04-02 18:15:41', '2018-04-02 18:15:41', null);
INSERT INTO `crowd` VALUES ('3', '1', '二级残疾', null, '2018-04-02 18:15:49', '2018-04-02 18:15:49', null);
INSERT INTO `crowd` VALUES ('4', '1', '三级残疾', null, '2018-04-02 18:15:55', '2018-04-02 18:15:55', null);
INSERT INTO `crowd` VALUES ('5', '1', '四级残疾', null, '2018-04-02 18:16:03', '2018-04-02 18:16:03', null);
INSERT INTO `crowd` VALUES ('6', '0', '低保', '持有《城市居民最低生活保障证》', '2018-04-02 18:16:25', '2018-04-02 18:23:56', null);
INSERT INTO `crowd` VALUES ('7', '6', '最低生活保障', '持有《城市居民最低生活保障证》', '2018-04-02 18:23:27', '2018-04-02 18:23:27', null);
INSERT INTO `crowd` VALUES ('8', '0', '伤残军人', null, '2018-04-02 18:37:14', '2018-04-02 18:37:14', null);
INSERT INTO `crowd` VALUES ('9', '8', '伤残军人', null, '2018-04-02 18:37:19', '2018-04-02 18:37:19', null);
INSERT INTO `crowd` VALUES ('10', '0', '三属', '烈士家属、因公牺牲军人家属、病故军人家属', '2018-04-02 18:38:08', '2018-04-02 18:38:08', null);
INSERT INTO `crowd` VALUES ('11', '10', '烈士家属', null, '2018-04-02 18:38:17', '2018-04-02 18:38:17', null);
INSERT INTO `crowd` VALUES ('12', '10', '因公牺牲军人家属', null, '2018-04-02 18:38:24', '2018-04-02 18:38:24', null);
INSERT INTO `crowd` VALUES ('13', '10', '病故军人家属', null, '2018-04-02 18:38:31', '2018-04-02 18:38:31', null);
INSERT INTO `crowd` VALUES ('14', '0', '重点优抚对象', null, '2018-04-02 18:38:56', '2018-04-02 18:38:56', null);
INSERT INTO `crowd` VALUES ('15', '14', '老复原军人', null, '2018-04-02 18:39:14', '2018-04-02 18:39:14', null);
INSERT INTO `crowd` VALUES ('16', '14', '带病回乡退伍军人', null, '2018-04-02 18:40:00', '2018-04-02 18:40:00', null);
INSERT INTO `crowd` VALUES ('17', '14', '参战退役人员', null, '2018-04-02 18:40:16', '2018-04-02 18:40:16', null);
INSERT INTO `crowd` VALUES ('18', '0', '失独家庭', null, '2018-04-02 18:40:32', '2018-04-02 18:40:32', null);
INSERT INTO `crowd` VALUES ('19', '18', '失独家庭', null, '2018-04-02 18:40:42', '2018-04-02 18:40:42', null);
INSERT INTO `crowd` VALUES ('20', '0', '困难家庭', null, '2018-04-02 18:41:02', '2018-04-02 18:41:02', null);
INSERT INTO `crowd` VALUES ('21', '20', '建档困难职工家庭', null, '2018-04-02 18:41:31', '2018-04-02 18:41:31', null);
INSERT INTO `crowd` VALUES ('22', '20', '特困职工家庭', null, '2018-04-02 18:41:49', '2018-04-02 18:41:49', null);

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='组织与部门';

-- ----------------------------
-- Records of dept
-- ----------------------------
INSERT INTO `dept` VALUES ('1', '0', '秦州区房屋征收补偿管理局', '0', null, '2018-02-02 19:44:47', '2018-02-02 21:47:11', null);
INSERT INTO `dept` VALUES ('2', '1', '政策法规股', '0', '', '2018-02-02 19:45:31', '2018-02-03 09:18:48', null);
INSERT INTO `dept` VALUES ('3', '1', '社会稳定风险评估办公室', '0', null, '2018-03-20 16:36:11', '2018-03-20 16:36:14', null);
INSERT INTO `dept` VALUES ('4', '1', '办公室', '0', null, '2018-02-02 19:45:49', '2018-02-02 19:45:49', null);
INSERT INTO `dept` VALUES ('5', '1', '安置管理股', '0', null, '2018-02-02 19:46:04', '2018-02-02 19:46:04', null);
INSERT INTO `dept` VALUES ('6', '1', '计划账务股', '0', null, '2018-02-02 19:50:14', '2018-02-03 09:17:22', null);

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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='必备附件分类';

-- ----------------------------
-- Records of file_cate
-- ----------------------------
INSERT INTO `file_cate` VALUES ('1', '1', '符合国民经济和社会发展规划的证明文件', 'file1', '2018-03-24 11:31:22', '2018-04-04 13:56:39', null);
INSERT INTO `file_cate` VALUES ('2', '2', '房屋照片', 'house', '2018-03-24 11:33:02', '2018-03-24 11:33:02', null);
INSERT INTO `file_cate` VALUES ('3', '2', '房屋证件', 'house2', '2018-03-24 11:44:55', '2018-03-24 11:44:55', null);
INSERT INTO `file_cate` VALUES ('4', '2', '户型图', 'house3', '2018-03-24 11:45:54', '2018-03-24 11:45:54', null);
INSERT INTO `file_cate` VALUES ('5', '3', '身份证', 'member', '2018-03-26 09:29:58', '2018-03-26 09:29:58', null);
INSERT INTO `file_cate` VALUES ('6', '3', '户口本页', 'member2', '2018-03-26 09:32:43', '2018-03-26 09:32:43', null);
INSERT INTO `file_cate` VALUES ('7', '4', '房屋照片信息', 'com_house', '2018-03-26 11:04:54', '2018-03-26 11:04:54', null);
INSERT INTO `file_cate` VALUES ('8', '4', '房屋证件信息', 'com_house2', '2018-03-26 11:05:19', '2018-03-26 11:05:19', null);
INSERT INTO `file_cate` VALUES ('9', '4', '户型图信息', 'com_house3', '2018-03-26 11:05:51', '2018-03-26 11:05:51', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='房源';

-- ----------------------------
-- Records of house
-- ----------------------------
INSERT INTO `house` VALUES ('1', '1', '1', '1', '1', '1', '1', '1', '1', '90.00', '20', '1', '0', '0', '0', '0', null, null, '151', '2018-03-01 14:55:29', '2018-04-04 15:18:25', null);
INSERT INTO `house` VALUES ('2', '2', '3', '2', '6', '2', '2', '2', '2', '100.00', '9', '0', '1', '1', '0', '0', null, '2017-03-01', '151', '2018-03-01 15:01:47', '2018-04-04 15:18:42', null);
INSERT INTO `house` VALUES ('3', '1', '2', '2', '4', '1', '2', '20', '1', '100.00', '30', '1', '1', '1', '1', '1', '[\"\\/storage\\/180308\\/2htQfYDAwT9OiUUnZr2oRThBpVtWGvr8pPHItfGF.jpeg\"]', '2018-03-08', '151', '2018-03-08 16:53:43', '2018-04-04 15:30:57', null);
INSERT INTO `house` VALUES ('4', '1', '1', '2', '2', '5', '5', '5', '5', '500.00', '20', '1', '1', '0', '1', '0', '[\"\\/storage\\/180329\\/5TIa4Evcq5oORbKsiLhMjYqnWkSCz7ovxgMH6FIO.jpeg\"]', '2018-05-29', '150', '2018-03-29 09:22:01', '2018-03-29 09:22:27', null);
INSERT INTO `house` VALUES ('5', '2', '3', '1', '5', '1', '1', '1', '1', '100.00', '30', '1', '1', '0', '1', '1', '[\"\\/storage\\/180402\\/QRgAUfy1WmVktM2xrzaZe8NdS1JVXEbzuRYCWF69.jpeg\"]', '2018-04-02', '150', '2018-04-02 14:22:07', '2018-04-02 14:36:40', '2018-04-02 14:36:40');

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
INSERT INTO `house_community` VALUES ('3', '2', '房源社区3', '房源社区3地址', null, '2018-03-01 13:57:47', '2018-04-02 11:49:43', null);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='房源管理机构';

-- ----------------------------
-- Records of house_company
-- ----------------------------
INSERT INTO `house_company` VALUES ('1', '房源管理公司1', '房源管理公司1地址', '房源管理公司1电话', '房源管理公司1联系人', '房源管理公司1联系电话', null, '2018-03-01 13:55:10', '2018-03-01 13:55:39', null);
INSERT INTO `house_company` VALUES ('2', '房源管理公司2', '房源管理公司2地址', '房源管理公司2电话', '房源管理公司2联系人', '房源管理公司2联系电话', null, '2018-03-01 13:56:21', '2018-03-01 13:56:21', null);
INSERT INTO `house_company` VALUES ('3', '房源管理机构3', '渝北区', '023-12341234', '王五', '13012345678', '内容描述', '2018-04-02 10:24:07', '2018-04-02 11:31:13', '2018-04-02 11:31:13');

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
INSERT INTO `house_layout_img` VALUES ('3', '2', '1', '211', '/storage/180301/v4Cuc5Xdl7nuJemXaLXsjCW1R3D9ysKFm75b9ToW.png', '2018-03-01 14:07:14', '2018-04-02 11:59:13', null);
INSERT INTO `house_layout_img` VALUES ('4', '2', '2', '221', '/storage/180301/6IrmQLMUfxrdjC15kEb9A6eWPyX29qWtALtlSgap.jpeg', '2018-03-01 14:07:28', '2018-03-01 14:07:28', null);
INSERT INTO `house_layout_img` VALUES ('5', '3', '1', '311', '/storage/180301/mfAr82gvFHocHh0YFB2wVp2Pkf5y8PR1A9weCmjW.jpeg', '2018-03-01 14:07:49', '2018-03-01 14:07:49', null);
INSERT INTO `house_layout_img` VALUES ('6', '3', '2', '321', '/storage/180301/F8c6kkKF1YSrznGY2oZeYzZ2MOwJrKFUsyo2036f.jpeg', '2018-03-01 14:08:03', '2018-03-01 14:08:03', null);

-- ----------------------------
-- Table structure for house_manage_fee
-- ----------------------------
DROP TABLE IF EXISTS `house_manage_fee`;
CREATE TABLE `house_manage_fee` (
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `house_id` int(11) NOT NULL COMMENT '房源ID',
  `manage_at` char(10) NOT NULL COMMENT ' 管理日期（年-月）',
  `manage_fee` decimal(10,2) NOT NULL COMMENT '月管理费',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `house_id` (`house_id`),
  KEY `manage_at` (`manage_at`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='房源-购置管理费';

-- ----------------------------
-- Records of house_manage_fee
-- ----------------------------
INSERT INTO `house_manage_fee` VALUES ('00000000001', '2', '2018-01', '100.00', '2018-04-02 09:16:34', '2018-04-02 09:16:34', null);
INSERT INTO `house_manage_fee` VALUES ('00000000002', '2', '2018-02', '100.00', '2018-04-02 09:16:34', '2018-04-02 09:16:34', null);
INSERT INTO `house_manage_fee` VALUES ('00000000003', '2', '2018-03', '100.00', '2018-04-02 09:16:34', '2018-04-02 09:16:34', null);
INSERT INTO `house_manage_fee` VALUES ('00000000004', '2', '2018-04', '100.00', '2018-04-02 09:16:34', '2018-04-02 09:16:34', null);
INSERT INTO `house_manage_fee` VALUES ('00000000005', '3', '2018-03', '10.00', '2018-04-02 09:16:34', '2018-04-02 09:16:34', null);
INSERT INTO `house_manage_fee` VALUES ('00000000006', '3', '2018-04', '10.00', '2018-04-02 09:16:34', '2018-04-02 09:16:34', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='房源-购置管理费单价';

-- ----------------------------
-- Records of house_manage_price
-- ----------------------------
INSERT INTO `house_manage_price` VALUES ('1', '1', '90.00', '2015', '2018', '2018-03-01 14:55:29', '2018-03-01 14:55:29', null);
INSERT INTO `house_manage_price` VALUES ('2', '2', '100.00', '2015', '2018', '2018-03-01 15:01:47', '2018-03-01 15:01:47', null);
INSERT INTO `house_manage_price` VALUES ('3', '3', '10.00', '2018', '2018', '2018-03-08 16:53:43', '2018-03-08 16:53:43', null);
INSERT INTO `house_manage_price` VALUES ('4', '4', '50.00', '2015', '2020', '2018-03-29 09:22:01', '2018-03-29 09:22:01', null);
INSERT INTO `house_manage_price` VALUES ('5', '5', '20.00', '2018', '2018', '2018-04-02 14:22:07', '2018-04-02 14:36:40', '2018-04-02 14:36:40');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='房源-评估单价';

-- ----------------------------
-- Records of house_price
-- ----------------------------
INSERT INTO `house_price` VALUES ('1', '1', '2018-01-01', '2018-12-31', '5000.00', '4000.00', '2018-03-01 14:55:29', '2018-03-01 14:55:29', null);
INSERT INTO `house_price` VALUES ('2', '2', '2018-01-01', '2018-12-31', '6000.00', '5000.00', '2018-03-01 15:01:47', '2018-03-20 15:01:47', null);
INSERT INTO `house_price` VALUES ('3', '3', '2018-01-01', '2018-12-31', '7000.00', '5500.00', '2018-03-08 16:53:43', '2018-03-08 16:53:43', null);
INSERT INTO `house_price` VALUES ('4', '1', '2019-01-01', '2019-12-31', '6000.00', '5000.00', '2018-03-19 14:42:42', '2018-03-19 14:42:44', null);
INSERT INTO `house_price` VALUES ('5', '4', '2018-03-01', '2018-04-07', '6000.00', '5000.00', '2018-03-29 09:22:01', '2018-03-29 09:22:01', null);
INSERT INTO `house_price` VALUES ('6', '5', '2018-04-02', '2018-04-02', '1000.00', '900.00', '2018-04-02 14:22:07', '2018-04-02 14:36:40', '2018-04-02 14:36:40');

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
  `house_id` int(11) NOT NULL COMMENT '房源ID',
  `settle_at` date NOT NULL COMMENT '安置日期',
  `hold_at` date DEFAULT NULL COMMENT '产权调换日期',
  `end_at` date DEFAULT NULL COMMENT '完成日期',
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
  `pact_id` int(11) NOT NULL DEFAULT '0' COMMENT '协议ID',
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
  `picture` text COMMENT '项目审查必备资料，【必须】',
  `schedule_id` int(11) DEFAULT NULL COMMENT '进度ID',
  `process_id` int(11) DEFAULT NULL COMMENT '流程ID',
  `code` char(20) NOT NULL DEFAULT '' COMMENT '项目状态代码',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE COMMENT '名称唯一',
  KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='项目-基本信息';

-- ----------------------------
-- Records of item
-- ----------------------------
INSERT INTO `item` VALUES ('1', '西关片区棚户区改造项目', '东至自由路、西至双桥路、北至成纪大道、南至解放路', '/storage/180223/mK5owDrG1mq9Ptpa2IgHCB3sz3F2n75jW92myUDV.png', null, '{\"file1\":[\"\\/storage\\/180223\\/NZjbyaVk6rZ6HJIWyoR3pkOSrRsQTdsvfiNjE6Rg.jpeg\"],\"file2\":[\"\\/storage\\/180223\\/JftNYwrUVh0Pg5xDxEfiU829gJSm245TOjAAUZWu.png\"],\"file3\":[\"\\/storage\\/180223\\/0PHJnAKiV91iIyomMMyQstD3IgkgCDusHxki0Kxr.jpeg\"],\"file4\":[\"\\/storage\\/180223\\/kjwiM1uWs7uk1wfnTVtwnD8FK0eBMOYJIxmQBVdR.jpeg\"]}', '1', '12', '22', '2018-03-09 17:35:06', '2018-03-14 13:55:34', null);
INSERT INTO `item` VALUES ('2', '测试项目', '渝北李华科谷', '/storage/180328/KsaGZXPgRl3KMIFLAZJLAKioG4NxTl58DRrlaCOq.jpeg', '项目测试', '{\"fild\":[\"\\/storage\\/180328\\/zl3msf7ZMq8HSYHQp5cWC71xRXpxbA3q6LJZvxFo.jpeg\"]}', '1', '1', '2', '2018-03-28 17:06:51', '2018-03-28 17:06:51', null);
INSERT INTO `item` VALUES ('3', '项目测试', '渝北区', '/storage/180328/Urep0TvaLX4I6Wnvbd0ideQtyp7OwFmsjOcGtKBA.jpeg', '测试', '{\"fild\":[\"\\/storage\\/180328\\/GzbMQkktrJmjyEB9IUAMXVL7VBioQEi5qaUGh5Fm.jpeg\"]}', '5', '39', '1', '2018-03-28 17:52:12', '2018-03-29 11:00:57', null);
INSERT INTO `item` VALUES ('4', '测试项目20180404', '测试项目20180404', '/storage/180404/VgHcfKRzVU4N2TOvBPUpDCZ9G6Ymh0Da5icHhSko.png', null, null, '3', '25', '1', '2018-04-04 14:01:53', '2018-04-04 16:30:04', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='项目-负责人';

-- ----------------------------
-- Records of item_admin
-- ----------------------------
INSERT INTO `item_admin` VALUES ('1', '1', '1', '2', '5', '2018-02-28 11:04:14', '2018-02-28 11:04:14', null);
INSERT INTO `item_admin` VALUES ('2', '3', '1', '2', '9', '2018-03-28 17:56:26', '2018-03-28 17:56:26', null);
INSERT INTO `item_admin` VALUES ('3', '3', '1', '3', '10', '2018-03-28 17:56:29', '2018-03-28 17:56:29', null);
INSERT INTO `item_admin` VALUES ('4', '4', '1', '2', '5', '2018-04-04 14:33:56', '2018-04-04 14:33:56', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='项目-地块楼栋';

-- ----------------------------
-- Records of item_building
-- ----------------------------
INSERT INTO `item_building` VALUES ('1', '1', '1', '1', '28', '100.00', '2017', '2', null, '[\"\\/storage\\/180310\\/Qc3WBDF0BmkaSyVJge2B0AbzrJRLPgokV9ISny2H.jpeg\"]', null, '2018-03-10 16:38:20', '2018-03-10 16:38:20', null);
INSERT INTO `item_building` VALUES ('2', '3', '6', '1', '30', '100.00', '2018', '1', null, '[\"\\/storage\\/180329\\/SClpvG2LUt4eDGeyRddgnPqLSvgUchFcN4BN3aXt.jpeg\"]', null, '2018-03-29 09:28:16', '2018-03-29 09:28:16', null);
INSERT INTO `item_building` VALUES ('3', '4', '7', '1', '10', '200.00', '2011', '1', null, '[\"\\/storage\\/180404\\/6l3HOLLzKQfj4TCUGSRxLr0AbELriPafG1Jmjfns.png\"]', null, '2018-04-04 16:32:23', '2018-04-04 16:32:23', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='项目-选定评估机构';

-- ----------------------------
-- Records of item_company
-- ----------------------------
INSERT INTO `item_company` VALUES ('1', '1', '0', '1', null, '2018-03-13 17:33:17', '2018-03-13 17:33:17', null);
INSERT INTO `item_company` VALUES ('2', '1', '1', '2', null, '2018-03-14 14:32:35', '2018-03-14 14:32:35', null);
INSERT INTO `item_company` VALUES ('3', '3', '0', '1', null, '2018-03-29 09:32:20', '2018-03-29 09:32:20', null);
INSERT INTO `item_company` VALUES ('4', '3', '1', '2', null, '2018-03-29 09:32:53', '2018-03-29 09:32:53', null);
INSERT INTO `item_company` VALUES ('6', '4', '0', '1', null, '2018-04-04 17:37:07', '2018-04-04 17:37:07', null);
INSERT INTO `item_company` VALUES ('7', '4', '1', '2', null, '2018-04-04 17:37:43', '2018-04-04 17:37:43', null);

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
  `updated_at` datetime DEFAULT NULL,
  KEY `item_id` (`item_id`),
  KEY `company_id` (`company_id`),
  KEY `item_company_id` (`item_company_id`),
  KEY `household_id` (`household_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目-评估机构评估范围';

-- ----------------------------
-- Records of item_company_household
-- ----------------------------
INSERT INTO `item_company_household` VALUES ('1', '1', '1', '1', '2018-03-13 17:33:17', null);
INSERT INTO `item_company_household` VALUES ('1', '2', '2', '1', '2018-03-16 21:21:57', '2018-03-16 21:21:57');
INSERT INTO `item_company_household` VALUES ('1', '2', '2', '2', '2018-03-16 21:21:57', '2018-03-16 21:21:57');
INSERT INTO `item_company_household` VALUES ('3', '1', '3', '4', '2018-03-29 09:32:20', '2018-03-29 09:32:20');
INSERT INTO `item_company_household` VALUES ('3', '2', '4', '4', '2018-03-29 09:32:53', '2018-03-29 09:32:53');
INSERT INTO `item_company_household` VALUES ('4', '1', '6', '6', '2018-04-04 17:37:07', '2018-04-04 17:37:07');
INSERT INTO `item_company_household` VALUES ('4', '2', '7', '6', '2018-04-04 17:37:43', '2018-04-04 17:37:43');

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='项目-评估公司投票';

-- ----------------------------
-- Records of item_company_vote
-- ----------------------------
INSERT INTO `item_company_vote` VALUES ('1', '1', '1', '1', '2018-03-13 16:14:09', '2018-03-13 16:14:09');
INSERT INTO `item_company_vote` VALUES ('2', '1', '1', '2', '2018-03-15 18:18:41', '2018-03-15 18:18:43');
INSERT INTO `item_company_vote` VALUES ('3', '1', '2', '3', '2018-03-15 18:18:57', '2018-03-15 18:19:00');
INSERT INTO `item_company_vote` VALUES ('4', '3', '1', '4', '2018-03-29 09:31:26', '2018-03-29 09:31:26');
INSERT INTO `item_company_vote` VALUES ('7', '4', '1', '6', '2018-04-04 17:14:16', '2018-04-04 17:14:16');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='项目-时间控制';

-- ----------------------------
-- Records of item_control
-- ----------------------------
INSERT INTO `item_control` VALUES ('2', '1', '1', 'A', '2018-03-06 08:00:00', '2018-03-07 17:00:00', '2018-03-06 13:41:08', '2018-03-06 13:54:15', null);
INSERT INTO `item_control` VALUES ('3', '1', '3', 'A', '2018-03-05 00:00:00', '2018-04-07 17:00:00', '2018-03-06 17:48:48', '2018-03-06 17:48:48', null);
INSERT INTO `item_control` VALUES ('4', '4', '1', '1', '2018-04-01 00:00:00', '2018-04-30 00:00:00', '2018-04-04 17:10:15', '2018-04-04 17:14:14', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='项目-征收意见稿';

-- ----------------------------
-- Records of item_draft
-- ----------------------------
INSERT INTO `item_draft` VALUES ('1', '1', '征收意见稿', '111111', '20', '2018-03-19 10:19:31', '2018-03-19 10:19:33', null);
INSERT INTO `item_draft` VALUES ('2', '3', '征收意见稿', '<p>内容测试</p>', '22', '2018-03-29 10:51:12', '2018-03-29 10:51:25', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='项目-资金收入支出流水';

-- ----------------------------
-- Records of item_funds
-- ----------------------------
INSERT INTO `item_funds` VALUES ('1', '1', '1', '0', '20000.00', '100001', '1', '6666666666666666', '项目筹备资金1', '2018-03-01 00:00:00', '项目筹备资金1', '[\"\\/storage\\/180301\\/HK4lR6WyYtEStVHxXEeCiXjHMyvSMRvQYHuTMvmt.png\"]', '2018-03-01 19:28:16', '2018-03-01 19:28:16', null);
INSERT INTO `item_funds` VALUES ('2', '3', '1', '0', '5000000.00', 'pingzheng', '1', 'test', 'test', '2018-04-07 00:00:00', 'test', '[\"\\/storage\\/180329\\/150pUfZbU2rwdjCnhWfazlABLlGpQFn9Y2xqDa9J.jpeg\"]', '2018-03-29 09:23:29', '2018-03-29 09:23:29', null);
INSERT INTO `item_funds` VALUES ('3', '3', '1', '0', '10000000000.00', 'pingzheng', '1', 'test', 'test', '2018-03-31 00:00:00', '说明', '[\"\\/storage\\/180329\\/bN40CyHsy5DIyN0Ur9ZVGfsqXVgIuGzbqt4gfJpE.jpeg\"]', '2018-03-29 09:24:15', '2018-03-29 09:24:15', null);
INSERT INTO `item_funds` VALUES ('4', '4', '1', '0', '20000.00', 'aaaa', '1', 'aaaa', 'aaaa', '2018-04-02 00:00:00', 'aaa', '[\"\\/storage\\/180404\\/amUW4LtB0Zvw9i5VkPDu2btJovdYM9tdyTMaJ629.png\"]', '2018-04-04 15:12:18', '2018-04-04 15:12:18', null);

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
INSERT INTO `item_house` VALUES ('3', '4', '0', '2018-03-29 09:22:27', '2018-03-29 09:22:27', null);
INSERT INTO `item_house` VALUES ('4', '1', '0', '2018-04-04 15:18:25', '2018-04-04 15:18:25', null);
INSERT INTO `item_house` VALUES ('4', '2', '0', '2018-04-04 15:18:42', '2018-04-04 15:18:42', null);
INSERT INTO `item_house` VALUES ('4', '3', '0', '2018-04-04 15:30:57', '2018-04-04 15:30:57', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='项目-被征收户';

-- ----------------------------
-- Records of item_household
-- ----------------------------
INSERT INTO `item_household` VALUES ('1', '1', '1', '1', '1', '1', '1', '0', 'test', 'eyJpdiI6ImdMU01yY1dkZlJIVm5Yd1dQM1NvbGc9PSIsInZhbHVlIjoiTVZJZXJWYlZ0cUJodFwvYkZybW9GOHc9PSIsIm1hYyI6ImZiYWI3MDQ4NWRmOWRkMDM2YjQzMGZmODIxODhkNmU3MWExN2Y5MDUyZWQxNjRkYWMwZWE4ZGQxNWJlOGZiOTAifQ==', '6C8EC565-6B2C-ADD1-16FB-2D6563930893', null, '69', '2018-03-12 15:00:22', '2018-04-04 10:41:55', null);
INSERT INTO `item_household` VALUES ('2', '1', '1', '1', '1', '13', '1', '0', 'asdfg', 'eyJpdiI6Imo3cWVkWXZKVEZnZjhoaUhuSTN2Mnc9PSIsInZhbHVlIjoiNG1yVGc2dFwvZ3Zpd1VJbU01ZnhmR0E9PSIsIm1hYyI6ImYxMWFiNjc0ZDEzZmQ1YWQzNzcyYzhkYWVkYzVjZmY1OTAyNjI2NTg5ZjA4NzNlMzRiMzYwNTNhNGY5ZDYzZGQifQ==', '48A1C9EC-3883-6F07-3338-620BD306525C', null, '76', '2018-03-14 17:03:01', '2018-03-14 17:03:01', null);
INSERT INTO `item_household` VALUES ('3', '1', '1', '1', '1', '3', '4', '0', 'zxc123', 'eyJpdiI6IjNsMXZFWDc0R3VMblp1dk42dzdMeXc9PSIsInZhbHVlIjoiSENVakdcL1I0cXBuMExKWDVnbzgwUmc9PSIsIm1hYyI6IjZlNWYwMDEyNmRiYjAyN2Y2OWU1YzA1NzhmMzhkYzMxMGEyMTY3NzUxMmU5N2MzZjc4NDA3YTg3MDUzZjZlN2MifQ==', '5997B9F2-BFBF-D52D-C2A3-4ABD1F9A142F', '描述', '60', '2018-03-24 11:49:18', '2018-03-24 14:52:12', null);
INSERT INTO `item_household` VALUES ('4', '3', '6', '2', '1', '1', '1', '0', '123456', 'eyJpdiI6IkxuOXFZNjFCMDhMUjM1NnBFSlwvUW5RPT0iLCJ2YWx1ZSI6Im9KYTBlV3RHMm5xV1wvRzZJVzlnU3FRPT0iLCJtYWMiOiJlOGQ0NjQ3NmJmNmYzNWIwYzI4YjY3YzRmZDBiZWRlOTgzMDlhYTYyMTM5ZDEzOTZjMWM2ZDMxZDhlYjFhM2EzIn0=', '954A1BCA-6CCB-EC6C-4664-190F68C89DBF', '描述', '63', '2018-03-29 09:29:06', '2018-03-29 10:41:52', null);
INSERT INTO `item_household` VALUES ('5', '1', '1', '1', '1', '1', '1', '0', '12231', 'eyJpdiI6ImdtUDAzUit0QVNuMlwvcFc3RERRSVlRPT0iLCJ2YWx1ZSI6IjJkR0JMRElzSzlOMjltWEp0eDc4SUE9PSIsIm1hYyI6IjU3MTNkZjBkNGJmOTdhMGVhMTk1ZDFjYmNlOGY5ZWMxOWQ3MWIzMTQ1NTBlMTUwOWJmMjY0MzFiN2ZiNTE0NjcifQ==', 'F994F161-FE07-6262-7F7E-C123A31A2FA2', '描述', '60', '2018-04-03 15:10:52', '2018-04-03 15:11:55', null);
INSERT INTO `item_household` VALUES ('6', '4', '7', '3', '1', '1', '1', '0', '987654321123456789', 'eyJpdiI6InNRZlR5WTBneUVXR3ZvWWl6NGhSZ0E9PSIsInZhbHVlIjoiaERGSTZtQkxrRStVU3pwOFBxTDZ3Zz09IiwibWFjIjoiMDQzMmRmMmJhODljZWY3ZjA2OGQ5MmU4NThjOWQwOTFmNTU2M2UzOTc3YzhmYjIyZGQzMTBhYzIyMjEyNWZiZSJ9', 'DB1AA082-DBCA-F709-DB7B-2E3DD8A1F50B', null, '60', '2018-04-04 16:37:37', '2018-04-04 16:37:37', null);
INSERT INTO `item_household` VALUES ('7', '4', '7', '3', '1', '2', '3', '0', '111122', 'eyJpdiI6ImFTNE8wUGRSeWxGXC96Y0daQUVHaFJnPT0iLCJ2YWx1ZSI6Ikk1czZ0XC9kTWV6OE5VaXorUXFhQjBnPT0iLCJtYWMiOiIzOTQ4ZGYwNmRmNTE5MTQ1MmU1ZmExODg3YTQ5YTk4MmM1MzVhNzZlZjYwYzExMWE1YTE1ZTZiYjViOThlZDdhIn0=', '65694EE5-237D-FDE4-2C37-A6B953665EA6', '描述', '60', '2018-04-04 16:48:10', '2018-04-04 16:48:10', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='项目-被征收户-资产';

-- ----------------------------
-- Records of item_household_assets
-- ----------------------------
INSERT INTO `item_household_assets` VALUES ('1', '1', '1', '1', '1', '资产', '个', '100', '10', '2', '[\"\\/storage\\/180313\\/2KWa4h2G1CBxKsNuoQjSZS3xldfBHxplQ3b34DR4.jpeg\"]', '[\"\\/storage\\/180314\\/93jXAMXRkF4NK9xLBvmAdSpdemJHVMYLPMMVGIpY.jpeg\"]', '2018-03-13 14:59:27', '2018-03-14 15:19:16', null);
INSERT INTO `item_household_assets` VALUES ('2', '1', '1', '1', '1', '资产2', '件', '13', '102', '200', '[\"\\/storage\\/180313\\/m7IliBzSrthAGv42fIkhqKu8qC3BSuhdxS3m7RKE.jpeg\"]', '[\"\\/storage\\/180314\\/04Gt59dEzC4e3D9Cjn5DacZQGPxLMHmRdLyZZqVq.jpeg\"]', '2018-03-13 15:42:58', '2018-03-16 14:19:16', null);
INSERT INTO `item_household_assets` VALUES ('3', '1', '1', '1', '1', '资产3', '件', null, '3', '1', null, '[\"\\/storage\\/180314\\/VeD9HJ20DX2Y4hpECx1zJJcPgrfXdlLO8KM1EMbY.jpeg\"]', '2018-03-14 15:07:56', '2018-03-16 14:23:31', null);
INSERT INTO `item_household_assets` VALUES ('4', '3', '4', '6', '2', '资产1', '个', '1', '2', '1', '[\"\\/storage\\/180329\\/moRKxkbe6xXwAUGU7Ov6KJxJf2BbAcIM40NvsF5M.jpeg\"]', '[\"\\/storage\\/180329\\/N6u44ngX0sCMekvLmihNdHePQB5EBbFcGvNTZy4W.jpeg\"]', '2018-03-29 09:36:41', '2018-03-29 09:38:34', null);
INSERT INTO `item_household_assets` VALUES ('5', '4', '6', '7', '3', '设备', '台', '1', null, null, '[\"\\/storage\\/180404\\/aNfRvkk63aI3u7WRqiON8fkmYlOiCooFnpvqg6Hv.png\"]', null, '2018-04-04 16:48:05', '2018-04-04 16:48:05', null);

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
  `build_year` year(4) DEFAULT NULL COMMENT '建造年份',
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='项目-被征收户-房屋建筑';

-- ----------------------------
-- Records of item_household_building
-- ----------------------------
INSERT INTO `item_household_building` VALUES ('4', '1', '1', '1', '1', '建筑A', '90', null, '100.00', '20.00', null, '120.00', '1', '1', '1', '东', '12', '2018', '1', '[\"\\/storage\\/180312\\/aA2Wi54YOvniaiYDKEwlsjzX68uZ6YB57VaWa4al.jpeg\"]', '2018-03-12 17:19:19', '2018-04-03 14:52:55', null);
INSERT INTO `item_household_building` VALUES ('6', '1', '2', '1', '1', null, '90', null, '120.00', '20.00', null, '100.00', '1', '1', '1', '西', '12', null, '1', '[\"\\/storage\\/180313\\/aTLtm221sZMfnKJ8AvJLZt2VoyGk5DuzM8qZPovP.jpeg\"]', '2018-03-13 11:34:52', '2018-03-13 11:34:52', null);
INSERT INTO `item_household_building` VALUES ('7', '1', '2', '1', '1', '建筑1', '94', null, '60.00', '0.00', null, '60.00', '4', '4', '1', '东', '2', null, '4', '[\"\\/storage\\/180315\\/oh7zWCY5Ul5Hv8WQmiYek9k3rPxAEYgRjsT2rWOC.jpeg\"]', '2018-03-15 14:09:15', '2018-03-15 16:39:52', null);
INSERT INTO `item_household_building` VALUES ('8', '1', '2', '1', '1', '建筑2', '90', null, '121.00', '12.00', null, '121.00', '1', '1', '1', '东', '3', null, '1', '[\"\\/storage\\/180315\\/RBz6gbaHqt9CVB0fIdauzVGlm8SCOWJrKldODumS.jpeg\"]', '2018-03-15 14:09:58', '2018-03-15 14:09:58', null);
INSERT INTO `item_household_building` VALUES ('9', '1', '3', '1', '1', '11', '91', null, '1.00', '1.00', null, '1.00', '1', '1', '1', '1', '1', '2017', '1', '[\"\\/storage\\/180324\\/O1EXJJXk4SwDDRfNYCaEzBy1y7C0aulXDt4SKju6.jpeg\"]', '2018-03-24 17:54:00', '2018-04-03 14:51:26', '2018-04-03 14:51:26');
INSERT INTO `item_household_building` VALUES ('10', '3', '4', '6', '2', '建筑A', '92', null, '100.00', '10.00', null, '100.00', '1', '1', '1', '东', '12', '2018', '5', '[\"\\/storage\\/180329\\/YnbPE1bSpufJidxUKOe0NHp9uw0QUbxqI8D5o2L4.jpeg\"]', '2018-03-29 09:35:17', '2018-03-29 09:35:39', null);
INSERT INTO `item_household_building` VALUES ('11', '4', '6', '7', '3', '主体房屋', '90', null, '50.00', '2.00', null, '60.00', '1', '1', '1', '南北', '6', '2011', '6', '[\"\\/storage\\/180404\\/5ZXoSpiEbcp83aXx1rARGaKIikJZA9GoU3eq9102.png\"]', '2018-04-04 16:42:04', '2018-04-04 16:42:04', null);
INSERT INTO `item_household_building` VALUES ('12', '4', '6', '7', '3', '柴房', '91', null, '30.00', '0.00', null, '30.00', '1', '5', '2', '东西', '1', '2013', null, '[\"\\/storage\\/180404\\/98TV0pjQNM9pW6MCc3eGKA17joiQqm0r7ldEPbSf.png\"]', '2018-04-04 16:45:47', '2018-04-04 16:45:47', null);
INSERT INTO `item_household_building` VALUES ('13', '4', '6', '7', '3', '停车位', '91', null, '10.00', '0.00', null, '10.00', '5', '5', '2', '南', '2', '2012', null, '[\"\\/storage\\/180404\\/BbaNTK6wraWlzL0VBZJ3Th2WOFH06p0wfQea8EYq.png\"]', '2018-04-04 16:47:21', '2018-04-04 16:47:21', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='项目-被征收户-房屋建筑-面积争议';

-- ----------------------------
-- Records of item_household_building_area
-- ----------------------------
INSERT INTO `item_household_building_area` VALUES ('1', '1', '2', '1', '1', '0', '[\"\\/storage\\/180315\\/HJAOA6ABiCGfaXBCFPH4uB9UODsfOPR51elDefCQ.jpeg\"]', '2018-03-15 19:16:17', '2018-03-15 19:16:17', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='项目-被征收户-房屋建筑-违建处理';

-- ----------------------------
-- Records of item_household_building_deal
-- ----------------------------
INSERT INTO `item_household_building_deal` VALUES ('2', '1', '2', '1', '1', '7', '0', '100.00', '6000.00', '0', '[\"\\/storage\\/180315\\/DbuZVxU6x6RDyoBaFzwSph6UHlfoFNOMO5ClJFrh.jpeg\"]', '2018-03-15 16:39:53', '2018-03-15 16:39:53', null);

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
  `area_dispute` tinyint(1) NOT NULL DEFAULT '0' COMMENT '面积争议，0无争议，1待测绘，2已测绘，3面积明确，4存在争议，5再测绘',
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='项目-被征收户详情';

-- ----------------------------
-- Records of item_household_detail
-- ----------------------------
INSERT INTO `item_household_detail` VALUES ('1', '1', '1', '1', '1', '0', '654321', null, '100.00', '10.00', '0', '0', '{\"house\":[\"\\/storage\\/180324\\/gocCvJcVH0hLh11Iwmc0fnoH235JtBVzKe8c5iFY.jpeg\"],\"house2\":[\"\\/storage\\/180324\\/sWKc5vFL3A0d2HLq9kcEuRrRwLp8OFrsKMBez2y9.jpeg\",\"\\/storage\\/180324\\/83CS6XBFNtyuOhokYh04Oq08NqYVTriwKjtv7OA9.jpeg\"],\"house3\":[\"\\/storage\\/180324\\/kGaIgvKQ4s4a6hUhQgRFY42XMDQfVgS8P9O2OXSN.jpeg\"]}', '1', '1', '1', '1', '1', '0', null, null, null, null, null, '0', null, null, null, null, '/storage/180312/1qY6Fcr7SAIUH3O6KifW33pFAirAzoXPovoz8L4Y.jpeg', '2018-03-12 15:41:48', '2018-03-26 16:43:44', null);
INSERT INTO `item_household_detail` VALUES ('2', '1', '2', '1', '1', '1', '123456', null, '100.00', '10.00', '2', '3', '{\"house\":[\"\\/storage\\/180324\\/gocCvJcVH0hLh11Iwmc0fnoH235JtBVzKe8c5iFY.jpeg\"],\"house2\":[\"\\/storage\\/180324\\/sWKc5vFL3A0d2HLq9kcEuRrRwLp8OFrsKMBez2y9.jpeg\",\"\\/storage\\/180324\\/83CS6XBFNtyuOhokYh04Oq08NqYVTriwKjtv7OA9.jpeg\"],\"house3\":[\"\\/storage\\/180324\\/kGaIgvKQ4s4a6hUhQgRFY42XMDQfVgS8P9O2OXSN.jpeg\"]}', '1', '1', '1', null, '1', '0', null, null, null, null, null, '0', null, 'wang', '13043211234', '渝北', '/storage/180314/8m6GJsw6lfRwiwN1taIMV0RzBKNJYUppPTaUBN7S.jpeg', '2018-03-14 17:04:17', '2018-03-15 19:16:17', null);
INSERT INTO `item_household_detail` VALUES ('7', '1', '3', '1', '1', '0', '1', null, '1.00', '1.00', '0', '0', '{\"house\":[\"\\/storage\\/180324\\/gocCvJcVH0hLh11Iwmc0fnoH235JtBVzKe8c5iFY.jpeg\"],\"house2\":[\"\\/storage\\/180324\\/sWKc5vFL3A0d2HLq9kcEuRrRwLp8OFrsKMBez2y9.jpeg\",\"\\/storage\\/180324\\/83CS6XBFNtyuOhokYh04Oq08NqYVTriwKjtv7OA9.jpeg\"],\"house3\":[\"\\/storage\\/180324\\/kGaIgvKQ4s4a6hUhQgRFY42XMDQfVgS8P9O2OXSN.jpeg\"]}', '1', '1', '0', '1', '1', '0', null, null, null, null, null, '0', null, null, null, null, '/storage/180324/BQ2ZZSAHPqkRj3o1lvR9oy8oBaaxYmN6nZm60XAt.jpeg', '2018-03-24 17:30:42', '2018-03-24 17:30:53', null);
INSERT INTO `item_household_detail` VALUES ('8', '3', '4', '6', '2', '0', '132121', null, '100.00', '10.00', '0', '0', '{\"house\":[\"\\/storage\\/180329\\/8wps4KdsAumb1SvPascLn4cAfKIj6xeTePqFICvJ.jpeg\"],\"house2\":[\"\\/storage\\/180329\\/04kLSEoDxYUa2VX3D2eAA6LzQJkx9JXquLi4QbXO.jpeg\"],\"house3\":[\"\\/storage\\/180329\\/piwMF4c9qZYidQICufjIdf6CXV2wFZb3EPrHAQtK.jpeg\"]}', '1', '1', '1', '21', '1', '1', '100.00', '100.00', '1', '渝北区', '1000.00', '1', null, '张三', '13012341234', '渝北', '/storage/180329/MRKGR9VFXBp64T0yuE0wTekSv6pWvM4AAlaknwlX.jpeg', '2018-03-29 09:30:29', '2018-03-29 10:03:35', null);
INSERT INTO `item_household_detail` VALUES ('9', '1', '5', '1', '1', '0', '12321154654', null, '100.00', '100.00', '0', '0', '{\"house\":[\"\\/storage\\/180403\\/6ESXWcKmnvHYkNcRIG4S3kcuW77hq7pZtAGWPFTv.jpeg\"],\"house2\":[\"\\/storage\\/180403\\/bMfqlul9QWpTSzixKL8TkI3i6yYmP6cSYOX2T7ba.jpeg\"],\"house3\":[\"\\/storage\\/180403\\/YzQBi3945tIq5hfdoWOhEdPQsuzFmR4ibjL4ZfRu.jpeg\"]}', '1', '1', '0', '1', '1', '0', null, null, null, null, null, '0', '意见', '1', '1', '1', '/storage/180403/ij9dPkxmwbXIDVYcJNc8115WGz3qMcdGzMgLyHOr.jpeg', '2018-04-03 15:11:46', '2018-04-03 15:11:55', null);
INSERT INTO `item_household_detail` VALUES ('10', '4', '6', '7', '3', '1', '1111', null, '60.00', '2.00', '1', '1', '{\"house\":[\"\\/storage\\/180404\\/MnWzxslPrcM5czbBWPLwqitXPxGUqdPAnII2sZAC.png\"],\"house2\":[\"\\/storage\\/180404\\/cHQ3Z8WtW3kr64sQ5Vx0OlAmWv9Psajm0V0gGikb.png\"],\"house3\":[\"\\/storage\\/180404\\/TBpiqmmezDZriGc10dgd8xd4rymT0ZnKgwQWkHQ3.png\"]}', '1', '1', '1', null, '1', '0', null, null, null, null, null, '0', null, null, null, null, '/storage/180404/MncQIsmWgSGxcNjO4MePRGZq4kDDjFPlMYVqG0zI.png', '2018-04-04 16:40:28', '2018-04-04 16:40:28', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='项目-被征收户-家庭成员';

-- ----------------------------
-- Records of item_household_member
-- ----------------------------
INSERT INTO `item_household_member` VALUES ('1', '1', '1', '1', '1', '张一', '户主', '123456789', '13012341234', '1', '0', '26', '1', '1', '100.00', '{\"member\":[\"\\/storage\\/180326\\/cQRhjgoNKBzbiwzOj4Aw1Kd9wAjdqs78gQnGgR47.jpeg\"],\"member2\":[\"\\/storage\\/180326\\/vDZl94OCx4vcN8AQt2UztYhUpGD3jAmdb6XyTbnz.jpeg\"]}', '2018-03-14 15:22:56', '2018-04-03 11:54:35', null);
INSERT INTO `item_household_member` VALUES ('2', '1', '2', '1', '1', '张三', '父子', '123154646546', '13032103210', '1', '0', '25', '0', '1', '80.00', '{\"member\":[\"\\/storage\\/180326\\/cQRhjgoNKBzbiwzOj4Aw1Kd9wAjdqs78gQnGgR47.jpeg\"],\"member2\":[\"\\/storage\\/180326\\/vDZl94OCx4vcN8AQt2UztYhUpGD3jAmdb6XyTbnz.jpeg\"]}', '2018-03-15 17:24:13', '2018-03-15 18:11:45', null);
INSERT INTO `item_household_member` VALUES ('3', '1', '2', '1', '1', '张四', '父子', '654654651213', '15012341234', '1', '0', '23', '0', '1', '20.00', '{\"member\":[\"\\/storage\\/180326\\/cQRhjgoNKBzbiwzOj4Aw1Kd9wAjdqs78gQnGgR47.jpeg\"],\"member2\":[\"\\/storage\\/180326\\/vDZl94OCx4vcN8AQt2UztYhUpGD3jAmdb6XyTbnz.jpeg\"]}', '2018-03-15 17:25:19', '2018-03-15 18:11:45', null);
INSERT INTO `item_household_member` VALUES ('4', '1', '3', '1', '1', 'wangwu', '父子', '1212', '1212', '1', '0', '10', '0', '0', '10.00', '{\"member\":[\"\\/storage\\/180326\\/cQRhjgoNKBzbiwzOj4Aw1Kd9wAjdqs78gQnGgR47.jpeg\"],\"member2\":[\"\\/storage\\/180326\\/vDZl94OCx4vcN8AQt2UztYhUpGD3jAmdb6XyTbnz.jpeg\"]}', '2018-03-26 10:03:40', '2018-03-26 10:03:40', null);
INSERT INTO `item_household_member` VALUES ('5', '1', '3', '1', '1', 'zzz', '1', '1', '1', '1', '0', '21', '1', '0', '1.00', '{\"member\":[\"\\/storage\\/180326\\/cQRhjgoNKBzbiwzOj4Aw1Kd9wAjdqs78gQnGgR47.jpeg\"],\"member2\":[\"\\/storage\\/180326\\/vDZl94OCx4vcN8AQt2UztYhUpGD3jAmdb6XyTbnz.jpeg\"]}', '2018-03-26 10:38:45', '2018-03-26 10:40:10', null);
INSERT INTO `item_household_member` VALUES ('6', '1', '3', '1', '1', 'zzzz', '1', '1', '1', '1', '0', '1', '0', '0', '1.00', '{\"member\":[\"\\/storage\\/180326\\/cQRhjgoNKBzbiwzOj4Aw1Kd9wAjdqs78gQnGgR47.jpeg\"],\"member2\":[\"\\/storage\\/180326\\/vDZl94OCx4vcN8AQt2UztYhUpGD3jAmdb6XyTbnz.jpeg\"]}', '2018-03-26 10:42:43', '2018-03-26 10:52:03', null);
INSERT INTO `item_household_member` VALUES ('7', '3', '4', '6', '2', '张三', '户主', '500024012231213', '132123132', '1', '0', '20', '0', '0', '100.00', '{\"member\":[\"\\/storage\\/180329\\/guuKtpwHRGMHiBrHbFKXmdf5A1itXfjM0pwbm3pO.jpeg\"],\"member2\":[\"\\/storage\\/180329\\/qUR5FI2zx1UGhMB7mN8u4ygiaFE0KMDB0Un63oIQ.jpeg\"]}', '2018-03-29 09:38:11', '2018-03-29 09:38:11', null);
INSERT INTO `item_household_member` VALUES ('8', '4', '6', '7', '3', 'xxx', 'xxx', 'xxx', 'xxx', '1', '0', '55', '1', '1', '100.00', '{\"member\":[\"\\/storage\\/180404\\/YwpXuhOy2DUKqsaFAWPr4yhNKrz5LDUvPAWePnmr.jpeg\"],\"member2\":[\"\\/storage\\/180404\\/OUdqeGNA4hNf68C5FGksA12RD8JWxt2PZrsvIjfM.jpeg\"]}', '2018-04-04 16:49:34', '2018-04-04 16:49:34', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='项目-被征收户-家庭成员-特殊人群';

-- ----------------------------
-- Records of item_household_member_crowd
-- ----------------------------
INSERT INTO `item_household_member_crowd` VALUES ('1', '1', '1', '1', '1', '1', '2', '[\"\\/storage\\/180403\\/ZIRQyBQ5qWARQ2VI7aw6fdbCYwvJ0rNIuFjejAY3.jpeg\"]', '2018-04-03 11:04:45', '2018-04-03 11:30:40', '2018-04-03 11:30:40');
INSERT INTO `item_household_member_crowd` VALUES ('2', '1', '1', '1', '1', '1', '3', '[\"\\/storage\\/180403\\/L5BVECJD1y2coghBayVKebguReC0gCEM6qWApkxD.jpeg\"]', '2018-04-03 11:46:30', '2018-04-03 11:54:35', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='项目-被征收户-其他补偿事项';

-- ----------------------------
-- Records of item_household_object
-- ----------------------------
INSERT INTO `item_household_object` VALUES ('1', '1', '1', '1', '1', '1', '200', '[\"\\/storage\\/180403\\/naiHudzupyBHvBN1MvJBE0gpxsUkqqUEr158pbaT.jpeg\"]', '2018-04-03 09:18:10', '2018-04-03 10:27:31', null);
INSERT INTO `item_household_object` VALUES ('2', '4', '6', '7', '3', '1', '1', '[\"\\/storage\\/180404\\/1yUbD330xnaKdwtVnSXTs3m1O10lRuXVTOhEkryz.png\"]', '2018-04-04 16:49:56', '2018-04-04 16:49:56', null);
INSERT INTO `item_household_object` VALUES ('3', '4', '6', '7', '3', '2', '1', '[\"\\/storage\\/180404\\/uYBnrRA44Pv4kqaKhFPf3FsslotULgulibhVt6t9.png\"]', '2018-04-04 16:50:08', '2018-04-04 16:50:08', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='项目-被征收户-产权争议解决';

-- ----------------------------
-- Records of item_household_right
-- ----------------------------
INSERT INTO `item_household_right` VALUES ('2', '1', '2', '1', '1', '11', '[\"\\/storage\\/180315\\/5RZAg4JzE6Yc7oXEaANHf9YWZGKQYihfbdQxaMGg.jpeg\"]', '2018-03-15 18:11:45', '2018-03-15 18:11:45', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='项目-产权调换优惠上浮';

-- ----------------------------
-- Records of item_house_rate
-- ----------------------------
INSERT INTO `item_house_rate` VALUES ('1', '1', '0.00', '15.00', '10.00', '2018-03-05 17:37:10', '2018-03-05 17:55:58', null);
INSERT INTO `item_house_rate` VALUES ('2', '1', '15.00', '25.00', '20.00', '2018-03-09 16:52:22', '2018-03-20 17:53:26', null);
INSERT INTO `item_house_rate` VALUES ('3', '1', '25.00', '30.00', '30.00', '2018-03-20 17:53:42', '2018-03-20 17:53:42', null);
INSERT INTO `item_house_rate` VALUES ('4', '1', '30.00', '0.00', '0.00', '2018-03-21 18:27:54', '2018-03-21 18:27:54', null);
INSERT INTO `item_house_rate` VALUES ('5', '3', '100.00', '120.00', '10.00', '2018-03-29 10:57:27', '2018-03-29 10:57:27', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='项目-初步预算';

-- ----------------------------
-- Records of item_init_budget
-- ----------------------------
INSERT INTO `item_init_budget` VALUES ('1', '1', '100', '200000.00', '200', '[\"\\/storage\\/180301\\/0BKgnI32JiqAc5aXDM3J3CsZWhy6D3YSLHFsUh8k.jpeg\"]', '2018-03-01 12:02:58', '2018-03-01 13:50:30', null);
INSERT INTO `item_init_budget` VALUES ('2', '3', '100', '50000000.00', '1', '[\"\\/storage\\/180329\\/QxULQTKEGJfYWEY8cbZnA4bLxO3JhPyqwudYFuLl.jpeg\"]', '2018-03-29 09:17:09', '2018-03-29 09:17:09', null);
INSERT INTO `item_init_budget` VALUES ('3', '4', '2', '2000.00', '2', '[\"\\/storage\\/180404\\/ZKJSJXx6suK7CIrkfFStoxCTmBsGXVyIn6oIRAoI.png\"]', '2018-04-04 15:08:29', '2018-04-04 15:08:29', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='项目-地块';

-- ----------------------------
-- Records of item_land
-- ----------------------------
INSERT INTO `item_land` VALUES ('1', '1', '渝北区力华科谷', '1', '1', '3', '1', '1000.00', null, '[\"\\/storage\\/180310\\/S32hugYRnerv3b44GOjZ8Bs0niTzB4jCfs7Fj6uI.jpeg\"]', '[\"\\/storage\\/180310\\/ere6KiVBbmgUWToYCZbWvWTMDOe6oyydlS69hMnx.jpeg\"]', '2018-03-10 16:30:46', '2018-03-16 19:17:06', null);
INSERT INTO `item_land` VALUES ('2', '1', '渝北区光电园', '1', '2', '7', '0', '1000.00', null, '[\"\\/storage\\/180316\\/juI0Qwx2BKf1DuvChBwVnuED0fuCFh30gjum1nYw.jpeg\"]', null, '2018-03-16 11:12:05', '2018-03-16 11:14:34', null);
INSERT INTO `item_land` VALUES ('3', '1', '渝北区照母山', '2', '3', '2', '0', '1200.00', null, '[\"\\/storage\\/180316\\/lFNFa79WvxXW1BeSVLbl1bdcm9mReQIxnFzYFydR.png\"]', null, '2018-03-16 11:13:05', '2018-03-16 11:13:05', null);
INSERT INTO `item_land` VALUES ('4', '1', '渝北区人和', '2', '3', '1', '1', '2000.00', null, '[\"\\/storage\\/180316\\/J2f3Ddtl6nFUIg2NTDOTl3L7u5eyygl3Vr5lTG29.png\"]', null, '2018-03-16 11:13:54', '2018-03-16 11:36:41', null);
INSERT INTO `item_land` VALUES ('5', '1', '渝北区冉家坝', '1', '1', '3', '2', '300.00', null, '[\"\\/storage\\/180316\\/328QUN2a2UmozkzkPwh5yAIyIYJSXyRPhwsyuYTd.jpeg\"]', null, '2018-03-16 11:37:20', '2018-03-16 11:37:20', null);
INSERT INTO `item_land` VALUES ('6', '3', '渝北区梨花客服', '1', '1', '3', '2', '500.00', null, '[\"\\/storage\\/180329\\/cGEPCW9KvDahm4afjowSxmZDajylYOJ4gcEqlYOf.jpeg\"]', null, '2018-03-29 09:27:47', '2018-03-29 09:27:47', null);
INSERT INTO `item_land` VALUES ('7', '4', '斯克雷皮斯某某某某', '1', '1', '3', '0', '300.00', null, '[\"\\/storage\\/180404\\/UAkxpdVdkpwbmCLaoTLDlILZDRCtFCKhiAYQSw4i.png\"]', null, '2018-04-04 16:30:25', '2018-04-04 16:30:25', null);
INSERT INTO `item_land` VALUES ('8', '4', '藏匿工工', '1', '1', '3', '1', '500.00', null, '[\"\\/storage\\/180404\\/1rUeBJqHnAaFRZ3iBAfIOqEd6AzDgca3RWSGGabh.png\"]', null, '2018-04-04 16:31:03', '2018-04-04 16:31:03', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='项目-地块户型';

-- ----------------------------
-- Records of item_land_layout
-- ----------------------------
INSERT INTO `item_land_layout` VALUES ('1', '1', '1', '三室一厅', '120.00', '[\"\\/storage\\/180312\\/OmVYsoxhkshPQ1FVjBrWhfKk09szbU7k40xRRNxF.jpeg\"]', null, null, '2018-03-12 17:19:19', '2018-03-12 17:19:19', null);
INSERT INTO `item_land_layout` VALUES ('2', '1', '1', '商场', '100.00', '[\"\\/storage\\/180312\\/6Oc82HSdLL5Qjjw3Iq92mgJkRdj9y2fAn2uGRPJv.jpeg\",\"\\/storage\\/180312\\/76XGYmcGMxITwDdEdWcS4Mnklu0r8wX9tqgWRvs5.jpeg\",\"\\/storage\\/180312\\/QMbAVK1cj6S1XfqGFkaVvILubbF1H4RvQmKR60uK.jpeg\"]', null, null, '2018-03-12 17:28:30', '2018-04-02 17:14:11', '2018-04-02 17:14:11');
INSERT INTO `item_land_layout` VALUES ('3', '1', '1', '一室一厅', '100.00', '[\"\\/storage\\/180312\\/Nf2gENx21Yd4WgTD9xw3tC5L4C69gysyrLTGLNOg.jpeg\"]', '[\"\\/storage\\/180313\\/F8UJ7sEKftCspl6Mfsqi18QQM59UZj6XL78CIZDn.jpeg\"]', '[\"\\/storage\\/180316\\/JQzGCUypZfwbocVnhM4zrij44xhfIti5EBMKVrse.jpeg\",\"\\/storage\\/180316\\/E6oyKWSTPFaG5nlBRadARJ1CRc8Ft2y7AwP3ZuWn.jpeg\"]', '2018-03-12 19:05:05', '2018-04-02 16:40:29', null);
INSERT INTO `item_land_layout` VALUES ('4', '1', '1', '两室一厅A', null, '[\"\\/storage\\/180313\\/GbzUOaaZEyhL5S1lOBmbfoLxX2yDY90oI9W0rjk4.jpeg\"]', null, null, '2018-03-13 10:48:49', '2018-03-13 10:48:49', null);
INSERT INTO `item_land_layout` VALUES ('5', '3', '6', '一室一厅', '100.00', '[\"\\/storage\\/180329\\/ICmodeXfN3BgW8yUeA2hBkmErg4VZ0SGMsWs9oUP.jpeg\"]', null, '[\"\\/storage\\/180329\\/AyfVaDFyGnDVYT3mXg0vYpJ31xOVRK0DwCKZko4r.jpeg\"]', '2018-03-29 09:28:38', '2018-03-29 09:36:02', null);
INSERT INTO `item_land_layout` VALUES ('6', '4', '7', '一室一厅', '50.00', '[\"\\/storage\\/180404\\/sXYnERc0ytbBpgDSQT2WktINsrSrq7Lti8y4syFd.png\"]', null, null, '2018-04-04 16:33:36', '2018-04-04 16:33:36', null);
INSERT INTO `item_land_layout` VALUES ('7', '4', '7', '一室二厅', '90.00', '[\"\\/storage\\/180404\\/oWwZRtNan5zbip5rdebBzNh6FWID58RLdLwNaCVG.png\"]', null, null, '2018-04-04 16:33:52', '2018-04-04 16:33:52', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='项目-内部通知';

-- ----------------------------
-- Records of item_notice
-- ----------------------------
INSERT INTO `item_notice` VALUES ('1', '1', '1', '通知摘要内容1', '[\"\\/storage\\/180222\\/c3ldGxfqeU5ZHpGUldKNEf2ybihj1G1TGyHQ6MaS.jpeg\"]', '2018-02-22 17:07:24', '2018-02-22 17:08:10', null);
INSERT INTO `item_notice` VALUES ('2', '1', '1', '不予受理', '[\"\\/storage\\/180226\\/MQ4XdJnQwL0jCzsNYpMMJRxuHWbjvCtD6T3Ruosi.jpeg\"]', '2018-02-26 15:05:02', '2018-02-26 15:05:02', null);
INSERT INTO `item_notice` VALUES ('3', '1', '2', '房屋征收补偿资金总额预算通知', '[\"\\/storage\\/180301\\/L3yytTPPwyVm86n6TeKTgzJV00VyLDQbU6PRdQPU.jpeg\"]', '2018-03-01 12:02:58', '2018-03-01 13:50:30', null);
INSERT INTO `item_notice` VALUES ('4', '3', '2', '再要内容', '[\"\\/storage\\/180329\\/jkWWNclh1O4DZNGzUoFKRf4fQ6XTsnqoi6LapsM2.jpeg\"]', '2018-03-29 09:17:09', '2018-03-29 09:17:09', null);
INSERT INTO `item_notice` VALUES ('5', '3', '3', '停办', '[\"\\/storage\\/180329\\/IbB0k3ZAt1lZgiVDPXhMrgRnfSu9oO1Ku4VJjq3h.jpeg\"]', '2018-03-29 09:27:54', '2018-03-29 09:27:54', null);
INSERT INTO `item_notice` VALUES ('6', '4', '2', '预算通知', '[\"\\/storage\\/180404\\/26Jrz0YKX8mj4VUl4xNktlbI7su6HQ0jzp0Omqrb.png\"]', '2018-04-04 15:08:29', '2018-04-04 15:08:29', null);
INSERT INTO `item_notice` VALUES ('8', '4', '3', '征收房屋相关手续停办通知', '[\"\\/storage\\/180404\\/SU2P6W2PjYPXnsSr5Q7QlxfsfpMlsBCXsmN2l65K.png\"]', '2018-04-04 16:21:57', '2018-04-04 16:21:57', null);

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
INSERT INTO `item_object` VALUES ('1', '1', '1', '2.00', '2018-04-03 11:15:36', '2018-04-03 11:15:38', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='项目-征收方案';

-- ----------------------------
-- Records of item_program
-- ----------------------------
INSERT INTO `item_program` VALUES ('2', '1', '测试', '<p>修改测试<img src=\"/ueditor/php/upload/image/20180312/1520824497997680.png\" title=\"1520824497997680.png\" alt=\"棋牌.png\"/></p>', '22', '2018-03-06', '22.00', '80.00', '900.00', '20.00', '20.00', '25.00', '40.00', '1000.00', '30.00', '130.00', '6', '30', '3000.00', '15.00', '300.00', '5000.00', '2018-03-12 11:14:59', '2018-03-12 11:18:48', null);
INSERT INTO `item_program` VALUES ('3', '3', '征收方案', '<p>内容</p>', '22', '2018-03-29', '10.00', '10.00', '1.00', '1.00', '1.00', '1.00', '1.00', '1.00', '1.00', '1.00', '1', '1', '10.00', '1.00', '1.00', '1.00', '2018-03-29 10:56:24', '2018-03-29 10:59:09', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='项目-公共附属物';

-- ----------------------------
-- Records of item_public
-- ----------------------------
INSERT INTO `item_public` VALUES ('1', '1', '1', '1', '砖', '块', '120', '120', '10.00', null, '[\"\\/storage\\/180310\\/vBTcY0u9bkNb5VeWHV52ch88I3uNT7QcvGdCvyjW.jpeg\"]', '[\"\\/storage\\/180312\\/JqukckHrtKcsREaUBJbVyrjHsrw6sAlLA9qkcedB.jpeg\"]', '2018-03-10 17:12:20', '2018-03-21 14:27:37', null);
INSERT INTO `item_public` VALUES ('2', '1', '1', '0', '围墙', '面', '4', '4', '10.00', null, '[\"\\/storage\\/180310\\/eH0urX1pn4e01Qf9YcuuyBayT2gwiI9JX2W1TIXS.jpeg\"]', '[\"\\/storage\\/180313\\/5YjU9Y71YrowzUDZTpKaMM4lDaTCFVBqLNzPWCKS.jpeg\"]', '2018-03-10 17:12:58', '2018-03-21 14:26:26', null);
INSERT INTO `item_public` VALUES ('3', '1', '1', '0', '1', '11', '1', null, null, '1', '[\"\\/storage\\/180402\\/fel3akLsKVjnAcoFzQh2VctR3gavhq8ZUP5SCqYp.jpeg\"]', null, '2018-04-02 17:12:03', '2018-04-02 17:12:46', '2018-04-02 17:12:46');
INSERT INTO `item_public` VALUES ('4', '4', '7', '0', '大门', '扇', '1', null, null, null, '[\"\\/storage\\/180404\\/jn3QTkhotSYN8B70DziLW2PUCrrMI5Kdv7EDVmOc.png\"]', null, '2018-04-04 16:33:00', '2018-04-04 16:33:00', null);

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
INSERT INTO `item_reward` VALUES ('1', '1', '2018-03-20', '2018-04-02', '800.00', '15.00', '2018-03-20 09:32:33', '2018-04-07 09:42:37', null);
INSERT INTO `item_reward` VALUES ('2', '3', '2018-03-29', '2018-07-29', '1000.00', '10.00', '2018-03-29 10:58:24', '2018-03-29 10:58:24', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='项目-社会稳定风险评估';

-- ----------------------------
-- Records of item_risk
-- ----------------------------
INSERT INTO `item_risk` VALUES ('1', '1', '2', '1', '1', '1', '0', '200.00', '20.00', '1', '来庆路二单元三号', '500.00', '1', '0', '1', '200.00', '300.00', '200.00', '5000.00', null, null, null);
INSERT INTO `item_risk` VALUES ('2', '1', '1', '1', '1', '0', '0', '200.00', '200.00', '1', '南岸', '20.00', '1', '1', '0', '200.00', null, null, null, null, null, null);
INSERT INTO `item_risk` VALUES ('12', '3', '4', '6', '2', '1', '0', '5000.00', '100.00', '1', '重庆渝北', '10.00', '2', '1', '1', '500.00', null, null, null, '2018-03-29 14:06:03', '2018-03-29 14:06:03', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='项目-风险评估报告';

-- ----------------------------
-- Records of item_risk_report
-- ----------------------------
INSERT INTO `item_risk_report` VALUES ('1', '1', '风险评估报告', '<p>风险评估报告</p>', '[\"\\/storage\\/180319\\/QlTvzIZ8fAPRrMDKgknI2P2pjMLhoe0uUtTyXUbs.jpeg\"]', '1', '20', '2018-03-19 16:19:25', '2018-03-19 16:19:25', null);
INSERT INTO `item_risk_report` VALUES ('2', '3', '征收报告', '<p>内容</p>', '[\"\\/storage\\/180329\\/sW0B8wqobQOcKNHLa1pWhtVAYYPVsYLbbVdHvG1X.jpeg\"]', '1', '22', '2018-03-29 10:54:59', '2018-03-29 10:55:29', null);

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
INSERT INTO `item_risk_topic` VALUES ('12', '3', '2', '测试话题答案', '2018-03-29 14:06:03', '2018-03-29 14:29:15', '2018-03-29 14:29:15');
INSERT INTO `item_risk_topic` VALUES ('12', '3', '1', '调查话题1答案', '2018-03-29 14:06:03', '2018-03-29 14:29:15', '2018-03-29 14:29:15');
INSERT INTO `item_risk_topic` VALUES ('12', '3', '1', '调查话题', '2018-03-29 14:29:15', '2018-03-29 14:29:15', null);
INSERT INTO `item_risk_topic` VALUES ('12', '3', '2', '测试话题', '2018-03-29 14:29:15', '2018-03-29 14:29:15', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='项目-补偿科目说明';

-- ----------------------------
-- Records of item_subject
-- ----------------------------
INSERT INTO `item_subject` VALUES ('1', '1', '1', '', '2018-03-23 15:36:13', '2018-03-23 15:36:13', null);
INSERT INTO `item_subject` VALUES ('2', '1', '2', '', '2018-03-23 15:36:13', '2018-03-23 15:36:13', null);
INSERT INTO `item_subject` VALUES ('3', '1', '3', '', '2018-03-23 15:36:13', '2018-03-23 15:36:13', null);
INSERT INTO `item_subject` VALUES ('4', '1', '4', '', '2018-03-23 15:36:13', '2018-03-23 15:36:13', null);
INSERT INTO `item_subject` VALUES ('5', '1', '5', '', '2018-03-23 15:36:13', '2018-03-23 15:36:13', null);
INSERT INTO `item_subject` VALUES ('6', '1', '6', '', '2018-03-23 15:36:13', '2018-03-23 15:36:13', null);
INSERT INTO `item_subject` VALUES ('7', '1', '7', 'aa', '2018-03-23 15:51:33', '2018-03-23 15:51:33', null);
INSERT INTO `item_subject` VALUES ('8', '1', '8', 'bb', '2018-03-23 15:52:02', '2018-03-23 15:52:02', null);
INSERT INTO `item_subject` VALUES ('9', '1', '9', 'c', '2018-03-23 15:52:18', '2018-03-23 15:52:18', null);
INSERT INTO `item_subject` VALUES ('10', '1', '10', 'x', '2018-03-23 15:52:26', '2018-03-23 15:52:26', null);
INSERT INTO `item_subject` VALUES ('11', '1', '11', 'ssfs', '2018-03-23 15:52:36', '2018-03-23 15:52:36', null);
INSERT INTO `item_subject` VALUES ('12', '1', '12', 'sf', '2018-03-23 15:52:42', '2018-03-23 15:52:42', null);
INSERT INTO `item_subject` VALUES ('13', '1', '13', 'asdf', '2018-03-23 15:52:49', '2018-03-23 15:52:49', null);
INSERT INTO `item_subject` VALUES ('14', '1', '14', 'dfsaf', '2018-03-23 15:52:56', '2018-03-23 15:52:56', null);
INSERT INTO `item_subject` VALUES ('15', '1', '15', 'asdf', '2018-03-23 15:53:09', '2018-03-23 15:53:09', null);
INSERT INTO `item_subject` VALUES ('16', '1', '16', 'aa', '2018-03-23 15:53:28', '2018-03-23 15:53:28', null);
INSERT INTO `item_subject` VALUES ('17', '1', '17', 'aa', '2018-03-23 15:53:49', '2018-03-23 15:53:49', null);
INSERT INTO `item_subject` VALUES ('18', '1', '18', 'sdf', '2018-03-23 15:53:57', '2018-03-23 15:53:57', null);
INSERT INTO `item_subject` VALUES ('19', '3', '1', '', '2018-03-29 10:56:34', '2018-03-29 10:56:34', null);
INSERT INTO `item_subject` VALUES ('20', '3', '2', '', '2018-03-29 10:56:34', '2018-03-29 10:56:34', null);
INSERT INTO `item_subject` VALUES ('21', '3', '3', '', '2018-03-29 10:56:34', '2018-03-29 10:56:34', null);
INSERT INTO `item_subject` VALUES ('22', '3', '4', '', '2018-03-29 10:56:34', '2018-03-29 10:56:34', null);
INSERT INTO `item_subject` VALUES ('23', '3', '5', '', '2018-03-29 10:56:34', '2018-03-29 10:56:34', null);
INSERT INTO `item_subject` VALUES ('24', '3', '6', '', '2018-03-29 10:56:34', '2018-03-29 10:56:34', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='项目-时间规划';

-- ----------------------------
-- Records of item_time
-- ----------------------------
INSERT INTO `item_time` VALUES ('7', '1', '1', '2018-02-01', '2018-02-28', '2018-02-28 11:07:34', '2018-02-28 11:07:34', null);
INSERT INTO `item_time` VALUES ('8', '1', '2', '2018-02-01', '2018-02-28', '2018-02-28 11:07:34', '2018-02-28 11:07:34', null);
INSERT INTO `item_time` VALUES ('9', '1', '3', '2018-02-01', '2018-02-28', '2018-02-28 11:07:34', '2018-02-28 11:07:34', null);
INSERT INTO `item_time` VALUES ('10', '1', '4', '2018-02-01', '2018-02-28', '2018-02-28 11:07:34', '2018-02-28 11:07:34', null);
INSERT INTO `item_time` VALUES ('11', '1', '5', '2018-02-01', '2018-02-28', '2018-02-28 11:07:34', '2018-02-28 11:07:34', null);
INSERT INTO `item_time` VALUES ('12', '1', '6', '2018-02-01', '2018-02-28', '2018-02-28 11:07:34', '2018-02-28 11:07:34', null);
INSERT INTO `item_time` VALUES ('13', '3', '1', '2018-03-01', '2018-03-31', '2018-03-28 18:01:05', '2018-03-28 18:01:05', null);
INSERT INTO `item_time` VALUES ('14', '3', '2', '2018-03-01', '2018-03-31', '2018-03-28 18:01:05', '2018-03-28 18:01:05', null);
INSERT INTO `item_time` VALUES ('15', '3', '3', '2018-03-01', '2018-03-31', '2018-03-28 18:01:05', '2018-03-28 18:01:05', null);
INSERT INTO `item_time` VALUES ('16', '3', '4', '2018-03-08', '2018-03-31', '2018-03-28 18:01:05', '2018-03-28 18:01:05', null);
INSERT INTO `item_time` VALUES ('17', '3', '5', '2018-03-01', '2018-03-31', '2018-03-28 18:01:05', '2018-03-28 18:01:05', null);
INSERT INTO `item_time` VALUES ('18', '3', '6', '2018-03-01', '2018-03-31', '2018-03-28 18:01:05', '2018-03-28 18:01:05', null);
INSERT INTO `item_time` VALUES ('19', '4', '1', '2018-04-01', '2018-04-04', '2018-04-04 14:39:10', '2018-04-04 14:39:10', null);
INSERT INTO `item_time` VALUES ('20', '4', '2', '2018-04-01', '2018-04-04', '2018-04-04 14:39:10', '2018-04-04 14:39:10', null);
INSERT INTO `item_time` VALUES ('21', '4', '3', '2018-04-01', '2018-04-04', '2018-04-04 14:39:10', '2018-04-04 14:39:10', null);
INSERT INTO `item_time` VALUES ('22', '4', '4', '2018-04-01', '2018-04-04', '2018-04-04 14:39:10', '2018-04-04 14:39:10', null);
INSERT INTO `item_time` VALUES ('23', '4', '5', '2018-04-01', '2018-04-04', '2018-04-04 14:39:10', '2018-04-04 14:39:10', null);
INSERT INTO `item_time` VALUES ('24', '4', '6', '2018-04-01', '2018-04-04', '2018-04-04 14:39:10', '2018-04-04 14:39:10', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='项目-自选社会风险评估调查话题';

-- ----------------------------
-- Records of item_topic
-- ----------------------------
INSERT INTO `item_topic` VALUES ('1', '1', '1', '2018-03-09 18:04:30', '2018-03-09 18:04:30', null);
INSERT INTO `item_topic` VALUES ('2', '1', '2', '2018-03-28 14:52:20', '2018-03-28 14:52:22', null);
INSERT INTO `item_topic` VALUES ('3', '3', '2', '2018-03-29 10:50:48', '2018-03-29 10:50:48', null);
INSERT INTO `item_topic` VALUES ('4', '3', '1', '2018-03-29 10:50:56', '2018-03-29 10:50:56', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8 COMMENT='项目-流程人员配置';

-- ----------------------------
-- Records of item_user
-- ----------------------------
INSERT INTO `item_user` VALUES ('1', '3', '1', '1', '44', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('2', '3', '1', '4', '223', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('3', '3', '1', '4', '223', '1', '3', '10', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('4', '3', '1', '2', '209', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('5', '3', '1', '2', '209', '1', '3', '10', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('6', '3', '1', '3', '218', '1', '3', '10', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('7', '3', '1', '5', '222', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('8', '3', '1', '15', '225', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('9', '3', '1', '6', '224', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('10', '3', '1', '7', '230', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('11', '3', '1', '7', '230', '1', '3', '10', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('12', '3', '1', '8', '231', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('13', '3', '1', '9', '245', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('14', '3', '1', '10', '246', '1', '3', '10', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('15', '3', '1', '16', '244', '1', '3', '10', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('16', '3', '1', '11', '248', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('17', '3', '1', '11', '248', '1', '3', '10', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('18', '3', '1', '12', '249', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('19', '3', '1', '12', '249', '1', '3', '10', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('20', '3', '1', '13', '252', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('21', '3', '2', '14', '258', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('22', '3', '2', '17', '361', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('23', '3', '2', '20', '259', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('24', '3', '2', '18', '362', '1', '3', '10', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('25', '3', '2', '21', '363', '1', '3', '10', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('26', '3', '2', '22', '364', '1', '3', '10', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('27', '3', '2', '19', '365', '1', '3', '10', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('28', '3', '2', '23', '279', '1', '3', '10', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('29', '3', '2', '24', '375', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('30', '3', '3', '25', '376', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('31', '3', '3', '26', '160', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('32', '3', '3', '27', '211', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('33', '3', '3', '28', '358', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('34', '3', '3', '29', '239', '1', '3', '10', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('35', '3', '3', '30', '377', '1', '3', '10', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('36', '3', '4', '31', '250', '1', '3', '10', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('37', '3', '4', '32', '390', '1', '3', '10', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('38', '3', '4', '33', '391', '1', '3', '10', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('39', '3', '4', '34', '260', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('40', '3', '4', '35', '396', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('41', '3', '4', '36', '398', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('42', '3', '4', '37', '399', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('43', '3', '4', '37', '399', '1', '3', '10', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('44', '3', '4', '38', '403', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('45', '3', '4', '38', '403', '1', '3', '10', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('46', '3', '5', '39', '405', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('47', '3', '5', '40', '39', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('48', '3', '6', '41', '40', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('49', '3', '6', '41', '40', '1', '3', '10', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('50', '3', '6', '42', '49', '1', '2', '9', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('51', '3', '6', '42', '49', '1', '3', '10', '2018-03-28 17:59:36', '2018-03-28 17:59:36', null);
INSERT INTO `item_user` VALUES ('52', '3', '1', '9', '245', '1', '3', '10', '2018-03-29 09:13:02', '2018-03-29 09:13:02', null);
INSERT INTO `item_user` VALUES ('53', '4', '1', '1', '44', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('54', '4', '1', '1', '44', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('55', '4', '1', '4', '223', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('56', '4', '1', '4', '223', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('57', '4', '1', '2', '209', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('58', '4', '1', '2', '209', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('59', '4', '1', '3', '218', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('60', '4', '1', '3', '218', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('61', '4', '1', '5', '222', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('62', '4', '1', '5', '222', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('63', '4', '1', '15', '225', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('64', '4', '1', '15', '225', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('65', '4', '1', '6', '224', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('66', '4', '1', '6', '224', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('67', '4', '1', '7', '230', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('68', '4', '1', '7', '230', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('69', '4', '1', '8', '231', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('70', '4', '1', '8', '231', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('71', '4', '1', '9', '245', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('72', '4', '1', '9', '245', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('73', '4', '1', '10', '246', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('74', '4', '1', '10', '246', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('75', '4', '1', '16', '244', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('76', '4', '1', '16', '244', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('77', '4', '1', '11', '248', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('78', '4', '1', '11', '248', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('79', '4', '1', '12', '249', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('80', '4', '1', '12', '249', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('81', '4', '1', '13', '252', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('82', '4', '1', '13', '252', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('83', '4', '2', '14', '258', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('84', '4', '2', '14', '258', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('85', '4', '2', '17', '361', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('86', '4', '2', '17', '361', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('87', '4', '2', '20', '259', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('88', '4', '2', '20', '259', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('89', '4', '2', '18', '362', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('90', '4', '2', '18', '362', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('91', '4', '2', '21', '363', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('92', '4', '2', '21', '363', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('93', '4', '2', '22', '364', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('94', '4', '2', '22', '364', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('95', '4', '2', '19', '365', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('96', '4', '2', '19', '365', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('97', '4', '2', '23', '279', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('98', '4', '2', '23', '279', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('99', '4', '2', '24', '375', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('100', '4', '2', '24', '375', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('101', '4', '3', '25', '376', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('102', '4', '3', '25', '376', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('103', '4', '3', '26', '160', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('104', '4', '3', '26', '160', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('105', '4', '3', '27', '211', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('106', '4', '3', '27', '211', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('107', '4', '3', '28', '358', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('108', '4', '3', '28', '358', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('109', '4', '3', '29', '239', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('110', '4', '3', '29', '239', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('111', '4', '3', '30', '377', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('112', '4', '3', '30', '377', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('113', '4', '4', '31', '250', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('114', '4', '4', '31', '250', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('115', '4', '4', '32', '390', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('116', '4', '4', '32', '390', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('117', '4', '4', '33', '391', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('118', '4', '4', '33', '391', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('119', '4', '4', '34', '260', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('120', '4', '4', '34', '260', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('121', '4', '4', '35', '396', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('122', '4', '4', '35', '396', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('123', '4', '4', '36', '398', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('124', '4', '4', '36', '398', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('125', '4', '4', '37', '399', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('126', '4', '4', '37', '399', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('127', '4', '4', '38', '403', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('128', '4', '4', '38', '403', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('129', '4', '5', '39', '405', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('130', '4', '5', '39', '405', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('131', '4', '5', '40', '476', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('132', '4', '5', '40', '476', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('133', '4', '5', '41', '509', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('134', '4', '5', '41', '509', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('135', '4', '5', '42', '413', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('136', '4', '5', '42', '413', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('137', '4', '5', '43', '424', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('138', '4', '5', '43', '424', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('139', '4', '5', '44', '507', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('140', '4', '5', '44', '507', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('141', '4', '6', '45', '463', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('142', '4', '6', '45', '463', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('143', '4', '6', '46', '508', '1', '2', '9', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);
INSERT INTO `item_user` VALUES ('144', '4', '6', '46', '508', '1', '3', '10', '2018-04-04 14:38:41', '2018-04-04 14:38:41', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=351 DEFAULT CHARSET=utf8 COMMENT='项目-工作提醒及处理结果';

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
INSERT INTO `item_work_notice` VALUES ('78', '3', '1', '1', '44', '1', '2', '3', '10', '/gov/item_add', '2', null, null, null, '2018-03-28 17:52:12', '2018-03-28 17:52:12', null);
INSERT INTO `item_work_notice` VALUES ('79', '3', '1', '2', '209', '1', '0', '2', '5', '/gov/iteminfo_info?item=3', '0', null, null, null, '2018-03-28 17:52:12', '2018-03-28 17:52:22', '2018-03-28 17:52:22');
INSERT INTO `item_work_notice` VALUES ('80', '3', '1', '2', '209', '1', '0', '2', '9', '/gov/iteminfo_info?item=3', '0', null, null, null, '2018-03-28 17:52:12', '2018-03-28 17:52:22', '2018-03-28 17:52:22');
INSERT INTO `item_work_notice` VALUES ('81', '3', '1', '2', '209', '1', '2', '3', '6', '/gov/iteminfo_info?item=3', '0', null, null, null, '2018-03-28 17:52:12', '2018-03-28 17:52:22', '2018-03-28 17:52:22');
INSERT INTO `item_work_notice` VALUES ('82', '3', '1', '2', '209', '1', '2', '3', '10', '/gov/iteminfo_info?item=3', '2', null, null, null, '2018-03-28 17:52:12', '2018-03-28 17:52:21', null);
INSERT INTO `item_work_notice` VALUES ('83', '3', '1', '3', '218', '1', '0', '2', '5', '/gov/check_dept_check?item=3', '20', null, null, null, '2018-03-28 17:52:22', '2018-03-28 17:52:10', '2018-03-28 17:52:10');
INSERT INTO `item_work_notice` VALUES ('84', '3', '1', '3', '218', '1', '0', '2', '9', '/gov/check_dept_check?item=3', '22', null, '通过', '[\"\\/storage\\/180328\\/whWkpgAo4Jx2cEXzZoXG89Zreeuhfztg2bOMGZ8o.jpeg\"]', '2018-03-28 17:52:22', '2018-03-28 17:52:10', null);
INSERT INTO `item_work_notice` VALUES ('85', '3', '1', '3', '218', '1', '2', '3', '6', '/gov/check_dept_check?item=3', '20', null, null, null, '2018-03-28 17:52:22', '2018-03-28 17:53:27', '2018-03-28 17:53:27');
INSERT INTO `item_work_notice` VALUES ('86', '3', '1', '3', '218', '1', '2', '3', '10', '/gov/check_dept_check?item=3', '22', null, '通过', '[\"\\/storage\\/180328\\/cJgMJfbeHvCMF4u52ZiO72Hs0LNCJjhqwUy4bfQ9.jpeg\"]', '2018-03-28 17:52:22', '2018-03-28 17:53:27', null);
INSERT INTO `item_work_notice` VALUES ('87', '3', '1', '6', '224', '1', '0', '2', '5', '/gov/iteminfo_info?item=3', '0', null, null, null, '2018-03-28 17:52:10', '2018-03-28 17:54:22', '2018-03-28 17:54:22');
INSERT INTO `item_work_notice` VALUES ('88', '3', '1', '6', '224', '1', '0', '2', '9', '/gov/iteminfo_info?item=3', '0', null, null, null, '2018-03-28 17:52:10', '2018-03-28 17:54:22', '2018-03-28 17:54:22');
INSERT INTO `item_work_notice` VALUES ('89', '3', '1', '6', '224', '1', '2', '3', '6', '/gov/iteminfo_info?item=3', '0', null, null, null, '2018-03-28 17:52:10', '2018-03-28 17:54:22', '2018-03-28 17:54:22');
INSERT INTO `item_work_notice` VALUES ('90', '3', '1', '6', '224', '1', '2', '3', '10', '/gov/iteminfo_info?item=3', '2', null, null, null, '2018-03-28 17:52:10', '2018-03-28 17:54:22', null);
INSERT INTO `item_work_notice` VALUES ('91', '3', '1', '7', '230', '1', '0', '2', '5', '/gov/check_gov_check?item=3', '20', null, null, null, '2018-03-28 17:54:22', '2018-03-28 17:55:12', '2018-03-28 17:55:12');
INSERT INTO `item_work_notice` VALUES ('92', '3', '1', '7', '230', '1', '0', '2', '9', '/gov/check_gov_check?item=3', '20', null, null, null, '2018-03-28 17:54:22', '2018-03-28 17:55:12', '2018-03-28 17:55:12');
INSERT INTO `item_work_notice` VALUES ('93', '3', '1', '7', '230', '1', '2', '3', '6', '/gov/check_gov_check?item=3', '20', null, null, null, '2018-03-28 17:54:22', '2018-03-28 17:55:12', '2018-03-28 17:55:12');
INSERT INTO `item_work_notice` VALUES ('94', '3', '1', '7', '230', '1', '2', '3', '10', '/gov/check_gov_check?item=3', '22', null, '同意', null, '2018-03-28 17:54:22', '2018-03-28 17:55:12', null);
INSERT INTO `item_work_notice` VALUES ('95', '3', '1', '8', '231', '0', '0', '1', '1', '/gov/check_start_set?item=3', '0', null, null, null, '2018-03-28 17:55:12', '2018-03-28 17:55:53', '2018-03-28 17:55:53');
INSERT INTO `item_work_notice` VALUES ('96', '3', '1', '8', '231', '1', '0', '1', '3', '/gov/check_start_set?item=3', '0', null, null, null, '2018-03-28 17:55:12', '2018-03-28 17:55:53', '2018-03-28 17:55:53');
INSERT INTO `item_work_notice` VALUES ('97', '3', '1', '8', '231', '1', '0', '1', '4', '/gov/check_start_set?item=3', '0', null, null, null, '2018-03-28 17:55:12', '2018-03-28 17:55:53', '2018-03-28 17:55:53');
INSERT INTO `item_work_notice` VALUES ('98', '3', '1', '8', '231', '1', '0', '2', '5', '/gov/check_start_set?item=3', '0', null, null, null, '2018-03-28 17:55:12', '2018-03-28 17:55:53', '2018-03-28 17:55:53');
INSERT INTO `item_work_notice` VALUES ('99', '3', '1', '8', '231', '1', '0', '2', '9', '/gov/check_start_set?item=3', '0', null, null, null, '2018-03-28 17:55:12', '2018-03-28 17:55:53', '2018-03-28 17:55:53');
INSERT INTO `item_work_notice` VALUES ('100', '3', '1', '8', '231', '1', '2', '3', '6', '/gov/check_start_set?item=3', '0', null, null, null, '2018-03-28 17:55:12', '2018-03-28 17:55:53', '2018-03-28 17:55:53');
INSERT INTO `item_work_notice` VALUES ('101', '3', '1', '8', '231', '1', '2', '3', '10', '/gov/check_start_set?item=3', '1', null, null, null, '2018-03-28 17:55:12', '2018-03-28 17:55:53', null);
INSERT INTO `item_work_notice` VALUES ('102', '3', '1', '9', '245', '0', '0', '1', '1', '/gov/itemuser?item=3', '0', null, null, null, '2018-03-28 17:55:53', '2018-03-29 09:13:09', '2018-03-29 09:13:09');
INSERT INTO `item_work_notice` VALUES ('103', '3', '1', '9', '245', '1', '0', '1', '3', '/gov/itemuser?item=3', '0', null, null, null, '2018-03-28 17:55:53', '2018-03-29 09:13:09', '2018-03-29 09:13:09');
INSERT INTO `item_work_notice` VALUES ('104', '3', '1', '9', '245', '1', '0', '1', '4', '/gov/itemuser?item=3', '0', null, null, null, '2018-03-28 17:55:53', '2018-03-29 09:13:09', '2018-03-29 09:13:09');
INSERT INTO `item_work_notice` VALUES ('105', '3', '1', '9', '245', '1', '0', '2', '5', '/gov/itemuser?item=3', '0', null, null, null, '2018-03-28 17:55:53', '2018-03-29 09:13:09', '2018-03-29 09:13:09');
INSERT INTO `item_work_notice` VALUES ('106', '3', '1', '9', '245', '1', '0', '2', '9', '/gov/itemuser?item=3', '2', null, null, null, '2018-03-28 17:55:53', '2018-03-29 09:13:09', null);
INSERT INTO `item_work_notice` VALUES ('107', '3', '1', '9', '245', '1', '2', '3', '6', '/gov/itemuser?item=3', '0', null, null, null, '2018-03-28 17:55:53', '2018-03-29 09:13:09', '2018-03-29 09:13:09');
INSERT INTO `item_work_notice` VALUES ('108', '3', '1', '9', '245', '1', '2', '3', '10', '/gov/itemuser?item=3', '1', null, null, null, '2018-03-28 17:55:53', '2018-03-29 09:13:09', '2018-03-29 09:13:09');
INSERT INTO `item_work_notice` VALUES ('109', '3', '1', '10', '246', '0', '0', '1', '1', '/gov/itemtime?item=3', '0', null, null, null, '2018-03-28 17:55:53', '2018-03-28 18:01:17', '2018-03-28 18:01:17');
INSERT INTO `item_work_notice` VALUES ('110', '3', '1', '10', '246', '1', '0', '1', '3', '/gov/itemtime?item=3', '0', null, null, null, '2018-03-28 17:55:53', '2018-03-28 18:01:17', '2018-03-28 18:01:17');
INSERT INTO `item_work_notice` VALUES ('111', '3', '1', '10', '246', '1', '0', '1', '4', '/gov/itemtime?item=3', '0', null, null, null, '2018-03-28 17:55:53', '2018-03-28 18:01:17', '2018-03-28 18:01:17');
INSERT INTO `item_work_notice` VALUES ('112', '3', '1', '10', '246', '1', '0', '2', '5', '/gov/itemtime?item=3', '0', null, null, null, '2018-03-28 17:55:53', '2018-03-28 18:01:17', '2018-03-28 18:01:17');
INSERT INTO `item_work_notice` VALUES ('113', '3', '1', '10', '246', '1', '0', '2', '9', '/gov/itemtime?item=3', '0', null, null, null, '2018-03-28 17:55:53', '2018-03-28 18:01:17', '2018-03-28 18:01:17');
INSERT INTO `item_work_notice` VALUES ('114', '3', '1', '10', '246', '1', '2', '3', '6', '/gov/itemtime?item=3', '0', null, null, null, '2018-03-28 17:55:53', '2018-03-28 18:01:17', '2018-03-28 18:01:17');
INSERT INTO `item_work_notice` VALUES ('115', '3', '1', '10', '246', '1', '2', '3', '10', '/gov/itemtime?item=3', '2', null, null, null, '2018-03-28 17:55:53', '2018-03-28 18:01:17', null);
INSERT INTO `item_work_notice` VALUES ('116', '3', '1', '16', '244', '0', '0', '1', '1', '/gov/itemadmin?item=3', '0', null, null, null, '2018-03-28 17:55:53', '2018-03-28 17:59:46', '2018-03-28 17:59:46');
INSERT INTO `item_work_notice` VALUES ('117', '3', '1', '16', '244', '1', '0', '1', '3', '/gov/itemadmin?item=3', '0', null, null, null, '2018-03-28 17:55:53', '2018-03-28 17:59:46', '2018-03-28 17:59:46');
INSERT INTO `item_work_notice` VALUES ('118', '3', '1', '16', '244', '1', '0', '1', '4', '/gov/itemadmin?item=3', '0', null, null, null, '2018-03-28 17:55:53', '2018-03-28 17:59:46', '2018-03-28 17:59:46');
INSERT INTO `item_work_notice` VALUES ('119', '3', '1', '16', '244', '1', '0', '2', '5', '/gov/itemadmin?item=3', '0', null, null, null, '2018-03-28 17:55:53', '2018-03-28 17:59:46', '2018-03-28 17:59:46');
INSERT INTO `item_work_notice` VALUES ('120', '3', '1', '16', '244', '1', '0', '2', '9', '/gov/itemadmin?item=3', '0', null, null, null, '2018-03-28 17:55:53', '2018-03-28 17:59:46', '2018-03-28 17:59:46');
INSERT INTO `item_work_notice` VALUES ('121', '3', '1', '16', '244', '1', '2', '3', '6', '/gov/itemadmin?item=3', '0', null, null, null, '2018-03-28 17:55:53', '2018-03-28 17:59:46', '2018-03-28 17:59:46');
INSERT INTO `item_work_notice` VALUES ('122', '3', '1', '16', '244', '1', '2', '3', '10', '/gov/itemadmin?item=3', '2', null, null, null, '2018-03-28 17:55:53', '2018-03-28 17:59:46', null);
INSERT INTO `item_work_notice` VALUES ('123', '3', '1', '11', '248', '0', '0', '1', '1', '/gov/check_set_to_check?item=3', '0', null, null, null, '2018-03-29 09:13:09', '2018-03-29 09:16:13', '2018-03-29 09:16:13');
INSERT INTO `item_work_notice` VALUES ('124', '3', '1', '11', '248', '1', '0', '1', '3', '/gov/check_set_to_check?item=3', '0', null, null, null, '2018-03-29 09:13:09', '2018-03-29 09:16:13', '2018-03-29 09:16:13');
INSERT INTO `item_work_notice` VALUES ('125', '3', '1', '11', '248', '1', '0', '1', '4', '/gov/check_set_to_check?item=3', '0', null, null, null, '2018-03-29 09:13:09', '2018-03-29 09:16:13', '2018-03-29 09:16:13');
INSERT INTO `item_work_notice` VALUES ('126', '3', '1', '11', '248', '1', '0', '2', '5', '/gov/check_set_to_check?item=3', '0', null, null, null, '2018-03-29 09:13:09', '2018-03-29 09:16:13', '2018-03-29 09:16:13');
INSERT INTO `item_work_notice` VALUES ('127', '3', '1', '11', '248', '1', '0', '2', '9', '/gov/check_set_to_check?item=3', '0', null, null, null, '2018-03-29 09:13:09', '2018-03-29 09:16:13', '2018-03-29 09:16:13');
INSERT INTO `item_work_notice` VALUES ('128', '3', '1', '11', '248', '1', '2', '3', '6', '/gov/check_set_to_check?item=3', '0', null, null, null, '2018-03-29 09:13:09', '2018-03-29 09:16:13', '2018-03-29 09:16:13');
INSERT INTO `item_work_notice` VALUES ('129', '3', '1', '11', '248', '1', '2', '3', '10', '/gov/check_set_to_check?item=3', '2', null, null, null, '2018-03-29 09:13:09', '2018-03-29 09:16:13', null);
INSERT INTO `item_work_notice` VALUES ('130', '3', '1', '12', '249', '0', '0', '1', '1', '/gov/check_set_check?item=3', '20', null, null, null, '2018-03-29 09:16:13', '2018-03-29 09:15:11', '2018-03-29 09:15:11');
INSERT INTO `item_work_notice` VALUES ('131', '3', '1', '12', '249', '1', '0', '1', '3', '/gov/check_set_check?item=3', '20', null, null, null, '2018-03-29 09:16:13', '2018-03-29 09:15:11', '2018-03-29 09:15:11');
INSERT INTO `item_work_notice` VALUES ('132', '3', '1', '12', '249', '1', '0', '1', '4', '/gov/check_set_check?item=3', '20', null, null, null, '2018-03-29 09:16:13', '2018-03-29 09:15:11', '2018-03-29 09:15:11');
INSERT INTO `item_work_notice` VALUES ('133', '3', '1', '12', '249', '1', '0', '2', '5', '/gov/check_set_check?item=3', '20', null, null, null, '2018-03-29 09:16:13', '2018-03-29 09:15:11', '2018-03-29 09:15:11');
INSERT INTO `item_work_notice` VALUES ('134', '3', '1', '12', '249', '1', '0', '2', '9', '/gov/check_set_check?item=3', '22', null, '通过', null, '2018-03-29 09:16:13', '2018-03-29 09:15:11', null);
INSERT INTO `item_work_notice` VALUES ('135', '3', '1', '12', '249', '1', '2', '3', '6', '/gov/check_set_check?item=3', '20', null, null, null, '2018-03-29 09:16:13', '2018-03-29 09:16:37', '2018-03-29 09:16:37');
INSERT INTO `item_work_notice` VALUES ('136', '3', '1', '12', '249', '1', '2', '3', '10', '/gov/check_set_check?item=3', '22', null, '审查通过', null, '2018-03-29 09:16:13', '2018-03-29 09:16:37', null);
INSERT INTO `item_work_notice` VALUES ('137', '3', '1', '13', '252', '0', '0', '1', '1', '/gov/check_item_start?item=3', '0', null, null, null, '2018-03-29 09:15:11', '2018-03-29 09:17:16', '2018-03-29 09:17:16');
INSERT INTO `item_work_notice` VALUES ('138', '3', '1', '13', '252', '1', '0', '1', '3', '/gov/check_item_start?item=3', '0', null, null, null, '2018-03-29 09:15:11', '2018-03-29 09:17:16', '2018-03-29 09:17:16');
INSERT INTO `item_work_notice` VALUES ('139', '3', '1', '13', '252', '1', '0', '1', '4', '/gov/check_item_start?item=3', '0', null, null, null, '2018-03-29 09:15:11', '2018-03-29 09:17:16', '2018-03-29 09:17:16');
INSERT INTO `item_work_notice` VALUES ('140', '3', '1', '13', '252', '1', '0', '2', '5', '/gov/check_item_start?item=3', '0', null, null, null, '2018-03-29 09:15:11', '2018-03-29 09:17:16', '2018-03-29 09:17:16');
INSERT INTO `item_work_notice` VALUES ('141', '3', '1', '13', '252', '1', '0', '2', '9', '/gov/check_item_start?item=3', '0', null, null, null, '2018-03-29 09:15:11', '2018-03-29 09:17:16', '2018-03-29 09:17:16');
INSERT INTO `item_work_notice` VALUES ('142', '3', '1', '13', '252', '1', '2', '3', '6', '/gov/check_item_start?item=3', '0', null, null, null, '2018-03-29 09:15:11', '2018-03-29 09:17:16', '2018-03-29 09:17:16');
INSERT INTO `item_work_notice` VALUES ('143', '3', '1', '13', '252', '1', '2', '3', '10', '/gov/check_item_start?item=3', '2', null, null, null, '2018-03-29 09:15:11', '2018-03-29 09:17:16', null);
INSERT INTO `item_work_notice` VALUES ('144', '3', '2', '14', '258', '1', '0', '2', '9', '/gov/initbudget?item=3', '2', null, null, null, '2018-03-29 09:17:16', '2018-03-29 09:17:09', null);
INSERT INTO `item_work_notice` VALUES ('145', '3', '2', '17', '361', '1', '0', '2', '9', '/gov/ready_init_check?item=3', '22', null, '通过', null, '2018-03-29 09:17:09', '2018-03-29 09:17:39', null);
INSERT INTO `item_work_notice` VALUES ('146', '3', '2', '18', '362', '1', '2', '3', '10', '/gov/ready_prepare?item=3', '1', null, null, null, '2018-03-29 09:17:39', '2018-03-29 09:19:43', null);
INSERT INTO `item_work_notice` VALUES ('147', '3', '2', '21', '363', '1', '0', '2', '5', '/gov/ready_funds?item=3', '0', null, null, null, '2018-03-29 09:19:43', '2018-03-29 09:24:29', '2018-03-29 09:24:29');
INSERT INTO `item_work_notice` VALUES ('148', '3', '2', '21', '363', '1', '0', '2', '9', '/gov/ready_funds?item=3', '0', null, null, null, '2018-03-29 09:19:43', '2018-03-29 09:24:29', '2018-03-29 09:24:29');
INSERT INTO `item_work_notice` VALUES ('149', '3', '2', '21', '363', '1', '2', '3', '6', '/gov/ready_funds?item=3', '0', null, null, null, '2018-03-29 09:19:43', '2018-03-29 09:24:29', '2018-03-29 09:24:29');
INSERT INTO `item_work_notice` VALUES ('150', '3', '2', '21', '363', '1', '2', '3', '10', '/gov/ready_funds?item=3', '2', null, null, null, '2018-03-29 09:19:43', '2018-03-29 09:24:29', null);
INSERT INTO `item_work_notice` VALUES ('151', '3', '2', '22', '364', '1', '0', '2', '5', '/gov/itemhouse?item=3', '0', null, null, null, '2018-03-29 09:19:43', '2018-03-29 09:26:50', '2018-03-29 09:26:50');
INSERT INTO `item_work_notice` VALUES ('152', '3', '2', '22', '364', '1', '0', '2', '9', '/gov/itemhouse?item=3', '0', null, null, null, '2018-03-29 09:19:43', '2018-03-29 09:26:50', '2018-03-29 09:26:50');
INSERT INTO `item_work_notice` VALUES ('153', '3', '2', '22', '364', '1', '2', '3', '6', '/gov/itemhouse?item=3', '0', null, null, null, '2018-03-29 09:19:43', '2018-03-29 09:26:50', '2018-03-29 09:26:50');
INSERT INTO `item_work_notice` VALUES ('154', '3', '2', '22', '364', '1', '2', '3', '10', '/gov/itemhouse?item=3', '2', null, null, null, '2018-03-29 09:19:43', '2018-03-29 09:26:50', null);
INSERT INTO `item_work_notice` VALUES ('155', '3', '2', '19', '365', '1', '2', '3', '10', '/gov/ready_prepare_check?item=3', '22', null, '审查通过', '[\"\\/storage\\/180329\\/ueyiyQiCQn6YTP5MiYfhrLln9QNdME7se3rrQBxz.jpeg\"]', '2018-03-29 09:26:50', '2018-03-29 09:27:19', null);
INSERT INTO `item_work_notice` VALUES ('156', '3', '2', '23', '279', '1', '2', '3', '10', '/gov/news_add?item=3', '2', null, null, null, '2018-03-29 09:27:19', '2018-03-29 09:27:54', null);
INSERT INTO `item_work_notice` VALUES ('157', '3', '2', '24', '375', '1', '0', '2', '9', '/gov/ready_range_check?item=3', '22', null, '通过', null, '2018-03-29 09:27:54', '2018-03-29 09:26:28', null);
INSERT INTO `item_work_notice` VALUES ('158', '3', '3', '25', '376', '1', '0', '2', '9', '/gov/survey?item=3', '2', null, null, null, '2018-03-29 09:26:29', '2018-03-29 10:10:04', null);
INSERT INTO `item_work_notice` VALUES ('159', '3', '3', '30', '377', '1', '2', '3', '10', '/gov/survey_check?item=3', '22', null, '通过', '[\"\\/storage\\/180329\\/00HI2AGtDBOTiafLbzOwq2t0Fltz3VTrYptngfOo.jpeg\"]', '2018-03-29 10:10:04', '2018-03-29 10:12:27', null);
INSERT INTO `item_work_notice` VALUES ('160', '3', '4', '31', '250', '1', '2', '3', '10', '/gov/itemdraft?item=3', '2', null, null, null, '2018-03-29 10:12:27', '2018-03-29 10:51:12', null);
INSERT INTO `item_work_notice` VALUES ('161', '3', '4', '32', '390', '1', '2', '3', '10', '/gov/draft_check?item=3', '22', null, '通过', null, '2018-03-29 10:51:12', '2018-03-29 10:51:25', null);
INSERT INTO `item_work_notice` VALUES ('162', '3', '4', '33', '391', '1', '2', '3', '10', '/gov/draft_notice_add?item=3', '2', null, null, null, '2018-03-29 10:51:25', '2018-03-29 10:52:01', null);
INSERT INTO `item_work_notice` VALUES ('163', '3', '4', '34', '260', '1', '0', '2', '9', '/gov/itemriskreport?item=3', '2', null, null, null, '2018-03-29 10:52:01', '2018-03-29 10:54:59', null);
INSERT INTO `item_work_notice` VALUES ('164', '3', '4', '35', '396', '1', '0', '2', '9', '/gov/riskreport_check?item=3', '22', null, '通过', null, '2018-03-29 10:54:59', '2018-03-29 10:55:28', null);
INSERT INTO `item_work_notice` VALUES ('165', '3', '4', '36', '398', '1', '0', '2', '9', '/gov/itemprogram?item=3', '2', null, null, null, '2018-03-29 10:55:28', '2018-03-29 10:58:31', null);
INSERT INTO `item_work_notice` VALUES ('166', '3', '4', '37', '399', '1', '0', '2', '9', '/gov/program_check?item=3', '22', null, '通过', null, '2018-03-29 10:58:31', '2018-03-29 10:59:09', null);
INSERT INTO `item_work_notice` VALUES ('167', '3', '4', '37', '399', '1', '2', '3', '10', '/gov/program_check?item=3', '22', null, '通过', null, '2018-03-29 10:58:31', '2018-03-29 11:00:39', null);
INSERT INTO `item_work_notice` VALUES ('168', '3', '4', '38', '403', '1', '0', '2', '9', '/gov/program_notice_add?item=3', '0', null, null, null, '2018-03-29 10:59:09', '2018-03-29 11:01:37', '2018-03-29 11:01:37');
INSERT INTO `item_work_notice` VALUES ('169', '3', '4', '38', '403', '1', '2', '3', '10', '/gov/program_notice_add?item=3', '2', null, null, null, '2018-03-29 10:59:09', '2018-03-29 11:01:37', null);
INSERT INTO `item_work_notice` VALUES ('170', '3', '5', '39', '405', '1', '0', '2', '9', '/gov/pay_start?item=3', '2', null, null, null, '2018-03-29 11:01:37', '2018-03-29 11:00:57', null);
INSERT INTO `item_work_notice` VALUES ('179', '1', '5', '40', '476', '1', '0', '2', '5', '/gov/pay_info?item=1&id=71', '20', null, null, null, '2018-04-04 10:41:55', '2018-04-04 10:41:55', null);
INSERT INTO `item_work_notice` VALUES ('180', '1', '5', '40', '476', '1', '0', '2', '9', '/gov/pay_info?item=1&id=71', '20', null, null, null, '2018-04-04 10:41:55', '2018-04-04 10:41:55', null);
INSERT INTO `item_work_notice` VALUES ('181', '1', '5', '40', '476', '1', '2', '3', '6', '/gov/pay_info?item=1&id=71', '20', null, null, null, '2018-04-04 10:41:55', '2018-04-04 10:41:55', null);
INSERT INTO `item_work_notice` VALUES ('182', '1', '5', '40', '476', '1', '2', '3', '10', '/gov/pay_info?item=1&id=71', '20', null, null, null, '2018-04-04 10:41:55', '2018-04-04 10:41:55', null);
INSERT INTO `item_work_notice` VALUES ('183', '4', '1', '1', '44', '1', '2', '3', '10', '/gov/item_add', '2', null, null, null, '2018-04-04 14:01:53', '2018-04-04 14:01:53', null);
INSERT INTO `item_work_notice` VALUES ('184', '4', '1', '2', '209', '1', '0', '2', '5', '/gov/iteminfo_info?item=4', '0', null, null, null, '2018-04-04 14:01:53', '2018-04-04 14:09:44', '2018-04-04 14:09:44');
INSERT INTO `item_work_notice` VALUES ('185', '4', '1', '2', '209', '1', '0', '2', '9', '/gov/iteminfo_info?item=4', '0', null, null, null, '2018-04-04 14:01:53', '2018-04-04 14:09:44', '2018-04-04 14:09:44');
INSERT INTO `item_work_notice` VALUES ('186', '4', '1', '2', '209', '1', '2', '3', '6', '/gov/iteminfo_info?item=4', '0', null, null, null, '2018-04-04 14:01:53', '2018-04-04 14:09:44', '2018-04-04 14:09:44');
INSERT INTO `item_work_notice` VALUES ('187', '4', '1', '2', '209', '1', '2', '3', '10', '/gov/iteminfo_info?item=4', '2', null, null, null, '2018-04-04 14:01:53', '2018-04-04 14:09:44', null);
INSERT INTO `item_work_notice` VALUES ('188', '4', '1', '3', '218', '1', '0', '2', '5', '/gov/check_dept_check?item=4', '20', null, null, null, '2018-04-04 14:09:44', '2018-04-04 14:10:49', '2018-04-04 14:10:49');
INSERT INTO `item_work_notice` VALUES ('189', '4', '1', '3', '218', '1', '0', '2', '9', '/gov/check_dept_check?item=4', '22', null, '审查通过', null, '2018-04-04 14:09:44', '2018-04-04 14:10:48', null);
INSERT INTO `item_work_notice` VALUES ('190', '4', '1', '3', '218', '1', '2', '3', '6', '/gov/check_dept_check?item=4', '20', null, null, null, '2018-04-04 14:09:44', '2018-04-04 14:11:52', '2018-04-04 14:11:52');
INSERT INTO `item_work_notice` VALUES ('191', '4', '1', '3', '218', '1', '2', '3', '10', '/gov/check_dept_check?item=4', '22', null, '审查通过', null, '2018-04-04 14:09:44', '2018-04-04 14:11:52', null);
INSERT INTO `item_work_notice` VALUES ('192', '4', '1', '6', '224', '1', '0', '2', '5', '/gov/iteminfo_info?item=4', '0', null, null, null, '2018-04-04 14:10:49', '2018-04-04 14:13:27', '2018-04-04 14:13:27');
INSERT INTO `item_work_notice` VALUES ('193', '4', '1', '6', '224', '1', '0', '2', '9', '/gov/iteminfo_info?item=4', '0', null, null, null, '2018-04-04 14:10:49', '2018-04-04 14:13:27', '2018-04-04 14:13:27');
INSERT INTO `item_work_notice` VALUES ('194', '4', '1', '6', '224', '1', '2', '3', '6', '/gov/iteminfo_info?item=4', '0', null, null, null, '2018-04-04 14:10:49', '2018-04-04 14:13:27', '2018-04-04 14:13:27');
INSERT INTO `item_work_notice` VALUES ('195', '4', '1', '6', '224', '1', '2', '3', '10', '/gov/iteminfo_info?item=4', '2', null, null, null, '2018-04-04 14:10:49', '2018-04-04 14:13:27', null);
INSERT INTO `item_work_notice` VALUES ('196', '4', '1', '7', '230', '1', '0', '2', '5', '/gov/check_gov_check?item=4', '20', null, null, null, '2018-04-04 14:13:27', '2018-04-04 14:14:42', '2018-04-04 14:14:42');
INSERT INTO `item_work_notice` VALUES ('197', '4', '1', '7', '230', '1', '0', '2', '9', '/gov/check_gov_check?item=4', '20', null, null, null, '2018-04-04 14:13:27', '2018-04-04 14:14:42', '2018-04-04 14:14:42');
INSERT INTO `item_work_notice` VALUES ('198', '4', '1', '7', '230', '1', '2', '3', '6', '/gov/check_gov_check?item=4', '20', null, null, null, '2018-04-04 14:13:27', '2018-04-04 14:14:42', '2018-04-04 14:14:42');
INSERT INTO `item_work_notice` VALUES ('199', '4', '1', '7', '230', '1', '2', '3', '10', '/gov/check_gov_check?item=4', '23', null, '审查驳回', null, '2018-04-04 14:13:27', '2018-04-04 14:14:42', null);
INSERT INTO `item_work_notice` VALUES ('200', '4', '1', '5', '222', '1', '0', '2', '5', '/gov/check_roll_back?item=4', '0', null, null, null, '2018-04-04 14:14:42', '2018-04-04 14:15:19', '2018-04-04 14:15:19');
INSERT INTO `item_work_notice` VALUES ('201', '4', '1', '5', '222', '1', '0', '2', '9', '/gov/check_roll_back?item=4', '0', null, null, null, '2018-04-04 14:14:42', '2018-04-04 14:15:19', '2018-04-04 14:15:19');
INSERT INTO `item_work_notice` VALUES ('202', '4', '1', '5', '222', '1', '2', '3', '6', '/gov/check_roll_back?item=4', '0', null, null, null, '2018-04-04 14:14:42', '2018-04-04 14:15:19', '2018-04-04 14:15:19');
INSERT INTO `item_work_notice` VALUES ('203', '4', '1', '5', '222', '1', '2', '3', '10', '/gov/check_roll_back?item=4', '2', null, null, null, '2018-04-04 14:14:42', '2018-04-04 14:15:19', null);
INSERT INTO `item_work_notice` VALUES ('204', '4', '1', '4', '223', '1', '0', '2', '5', '/gov/check_iteminfo_retry?item=4', '0', null, null, null, '2018-04-04 14:15:19', '2018-04-04 14:18:41', '2018-04-04 14:18:41');
INSERT INTO `item_work_notice` VALUES ('205', '4', '1', '4', '223', '1', '0', '2', '9', '/gov/check_iteminfo_retry?item=4', '0', null, null, null, '2018-04-04 14:15:19', '2018-04-04 14:18:41', '2018-04-04 14:18:41');
INSERT INTO `item_work_notice` VALUES ('206', '4', '1', '4', '223', '1', '2', '3', '6', '/gov/check_iteminfo_retry?item=4', '0', null, null, null, '2018-04-04 14:15:19', '2018-04-04 14:18:41', '2018-04-04 14:18:41');
INSERT INTO `item_work_notice` VALUES ('207', '4', '1', '4', '223', '1', '2', '3', '10', '/gov/check_iteminfo_retry?item=4', '2', null, null, null, '2018-04-04 14:15:19', '2018-04-04 14:18:41', null);
INSERT INTO `item_work_notice` VALUES ('208', '4', '1', '2', '209', '1', '0', '2', '5', '/gov/iteminfo_info?item=4', '0', null, null, null, '2018-04-04 14:18:41', '2018-04-04 14:18:47', '2018-04-04 14:18:47');
INSERT INTO `item_work_notice` VALUES ('209', '4', '1', '2', '209', '1', '0', '2', '9', '/gov/iteminfo_info?item=4', '0', null, null, null, '2018-04-04 14:18:41', '2018-04-04 14:18:47', '2018-04-04 14:18:47');
INSERT INTO `item_work_notice` VALUES ('210', '4', '1', '2', '209', '1', '2', '3', '6', '/gov/iteminfo_info?item=4', '0', null, null, null, '2018-04-04 14:18:41', '2018-04-04 14:18:47', '2018-04-04 14:18:47');
INSERT INTO `item_work_notice` VALUES ('211', '4', '1', '2', '209', '1', '2', '3', '10', '/gov/iteminfo_info?item=4', '2', null, null, null, '2018-04-04 14:18:41', '2018-04-04 14:18:47', null);
INSERT INTO `item_work_notice` VALUES ('212', '4', '1', '3', '218', '1', '0', '2', '5', '/gov/check_dept_check?item=4', '20', null, null, null, '2018-04-04 14:18:47', '2018-04-04 14:30:50', '2018-04-04 14:30:50');
INSERT INTO `item_work_notice` VALUES ('213', '4', '1', '3', '218', '1', '0', '2', '9', '/gov/check_dept_check?item=4', '22', null, '审查通过', null, '2018-04-04 14:18:47', '2018-04-04 14:30:50', null);
INSERT INTO `item_work_notice` VALUES ('214', '4', '1', '3', '218', '1', '2', '3', '6', '/gov/check_dept_check?item=4', '20', null, null, null, '2018-04-04 14:18:47', '2018-04-04 14:32:23', '2018-04-04 14:32:23');
INSERT INTO `item_work_notice` VALUES ('215', '4', '1', '3', '218', '1', '2', '3', '10', '/gov/check_dept_check?item=4', '22', null, '审查通过', null, '2018-04-04 14:18:47', '2018-04-04 14:32:23', null);
INSERT INTO `item_work_notice` VALUES ('216', '4', '1', '6', '224', '1', '0', '2', '5', '/gov/iteminfo_info?item=4', '0', null, null, null, '2018-04-04 14:30:50', '2018-04-04 14:33:08', '2018-04-04 14:33:08');
INSERT INTO `item_work_notice` VALUES ('217', '4', '1', '6', '224', '1', '0', '2', '9', '/gov/iteminfo_info?item=4', '0', null, null, null, '2018-04-04 14:30:50', '2018-04-04 14:33:08', '2018-04-04 14:33:08');
INSERT INTO `item_work_notice` VALUES ('218', '4', '1', '6', '224', '1', '2', '3', '6', '/gov/iteminfo_info?item=4', '0', null, null, null, '2018-04-04 14:30:50', '2018-04-04 14:33:08', '2018-04-04 14:33:08');
INSERT INTO `item_work_notice` VALUES ('219', '4', '1', '6', '224', '1', '2', '3', '10', '/gov/iteminfo_info?item=4', '2', null, null, null, '2018-04-04 14:30:50', '2018-04-04 14:33:08', null);
INSERT INTO `item_work_notice` VALUES ('220', '4', '1', '7', '230', '1', '0', '2', '5', '/gov/check_gov_check?item=4', '20', null, null, null, '2018-04-04 14:33:08', '2018-04-04 14:33:31', '2018-04-04 14:33:31');
INSERT INTO `item_work_notice` VALUES ('221', '4', '1', '7', '230', '1', '0', '2', '9', '/gov/check_gov_check?item=4', '20', null, null, null, '2018-04-04 14:33:08', '2018-04-04 14:33:31', '2018-04-04 14:33:31');
INSERT INTO `item_work_notice` VALUES ('222', '4', '1', '7', '230', '1', '2', '3', '6', '/gov/check_gov_check?item=4', '20', null, null, null, '2018-04-04 14:33:08', '2018-04-04 14:33:31', '2018-04-04 14:33:31');
INSERT INTO `item_work_notice` VALUES ('223', '4', '1', '7', '230', '1', '2', '3', '10', '/gov/check_gov_check?item=4', '22', null, '审查通过', null, '2018-04-04 14:33:08', '2018-04-04 14:33:31', null);
INSERT INTO `item_work_notice` VALUES ('224', '4', '1', '8', '231', '0', '0', '1', '1', '/gov/check_start_set?item=4', '0', null, null, null, '2018-04-04 14:33:31', '2018-04-04 14:33:42', '2018-04-04 14:33:42');
INSERT INTO `item_work_notice` VALUES ('225', '4', '1', '8', '231', '1', '0', '1', '3', '/gov/check_start_set?item=4', '0', null, null, null, '2018-04-04 14:33:31', '2018-04-04 14:33:42', '2018-04-04 14:33:42');
INSERT INTO `item_work_notice` VALUES ('226', '4', '1', '8', '231', '1', '0', '1', '4', '/gov/check_start_set?item=4', '0', null, null, null, '2018-04-04 14:33:31', '2018-04-04 14:33:42', '2018-04-04 14:33:42');
INSERT INTO `item_work_notice` VALUES ('227', '4', '1', '8', '231', '1', '0', '2', '5', '/gov/check_start_set?item=4', '0', null, null, null, '2018-04-04 14:33:31', '2018-04-04 14:33:42', '2018-04-04 14:33:42');
INSERT INTO `item_work_notice` VALUES ('228', '4', '1', '8', '231', '1', '0', '2', '9', '/gov/check_start_set?item=4', '0', null, null, null, '2018-04-04 14:33:31', '2018-04-04 14:33:42', '2018-04-04 14:33:42');
INSERT INTO `item_work_notice` VALUES ('229', '4', '1', '8', '231', '1', '2', '3', '6', '/gov/check_start_set?item=4', '0', null, null, null, '2018-04-04 14:33:31', '2018-04-04 14:33:42', '2018-04-04 14:33:42');
INSERT INTO `item_work_notice` VALUES ('230', '4', '1', '8', '231', '1', '2', '3', '10', '/gov/check_start_set?item=4', '1', null, null, null, '2018-04-04 14:33:31', '2018-04-04 14:33:42', null);
INSERT INTO `item_work_notice` VALUES ('231', '4', '1', '9', '245', '0', '0', '1', '1', '/gov/itemuser?item=4', '0', null, null, null, '2018-04-04 14:33:42', '2018-04-04 14:38:45', '2018-04-04 14:38:45');
INSERT INTO `item_work_notice` VALUES ('232', '4', '1', '9', '245', '1', '0', '1', '3', '/gov/itemuser?item=4', '0', null, null, null, '2018-04-04 14:33:42', '2018-04-04 14:38:45', '2018-04-04 14:38:45');
INSERT INTO `item_work_notice` VALUES ('233', '4', '1', '9', '245', '1', '0', '1', '4', '/gov/itemuser?item=4', '0', null, null, null, '2018-04-04 14:33:42', '2018-04-04 14:38:45', '2018-04-04 14:38:45');
INSERT INTO `item_work_notice` VALUES ('234', '4', '1', '9', '245', '1', '0', '2', '5', '/gov/itemuser?item=4', '0', null, null, null, '2018-04-04 14:33:42', '2018-04-04 14:38:45', '2018-04-04 14:38:45');
INSERT INTO `item_work_notice` VALUES ('235', '4', '1', '9', '245', '1', '0', '2', '9', '/gov/itemuser?item=4', '0', null, null, null, '2018-04-04 14:33:42', '2018-04-04 14:38:45', '2018-04-04 14:38:45');
INSERT INTO `item_work_notice` VALUES ('236', '4', '1', '9', '245', '1', '2', '3', '6', '/gov/itemuser?item=4', '0', null, null, null, '2018-04-04 14:33:42', '2018-04-04 14:38:45', '2018-04-04 14:38:45');
INSERT INTO `item_work_notice` VALUES ('237', '4', '1', '9', '245', '1', '2', '3', '10', '/gov/itemuser?item=4', '2', null, null, null, '2018-04-04 14:33:42', '2018-04-04 14:38:45', null);
INSERT INTO `item_work_notice` VALUES ('238', '4', '1', '10', '246', '0', '0', '1', '1', '/gov/itemtime?item=4', '0', null, null, null, '2018-04-04 14:33:42', '2018-04-04 14:39:12', '2018-04-04 14:39:12');
INSERT INTO `item_work_notice` VALUES ('239', '4', '1', '10', '246', '1', '0', '1', '3', '/gov/itemtime?item=4', '0', null, null, null, '2018-04-04 14:33:42', '2018-04-04 14:39:12', '2018-04-04 14:39:12');
INSERT INTO `item_work_notice` VALUES ('240', '4', '1', '10', '246', '1', '0', '1', '4', '/gov/itemtime?item=4', '0', null, null, null, '2018-04-04 14:33:42', '2018-04-04 14:39:12', '2018-04-04 14:39:12');
INSERT INTO `item_work_notice` VALUES ('241', '4', '1', '10', '246', '1', '0', '2', '5', '/gov/itemtime?item=4', '0', null, null, null, '2018-04-04 14:33:42', '2018-04-04 14:39:12', '2018-04-04 14:39:12');
INSERT INTO `item_work_notice` VALUES ('242', '4', '1', '10', '246', '1', '0', '2', '9', '/gov/itemtime?item=4', '0', null, null, null, '2018-04-04 14:33:42', '2018-04-04 14:39:12', '2018-04-04 14:39:12');
INSERT INTO `item_work_notice` VALUES ('243', '4', '1', '10', '246', '1', '2', '3', '6', '/gov/itemtime?item=4', '0', null, null, null, '2018-04-04 14:33:42', '2018-04-04 14:39:12', '2018-04-04 14:39:12');
INSERT INTO `item_work_notice` VALUES ('244', '4', '1', '10', '246', '1', '2', '3', '10', '/gov/itemtime?item=4', '2', null, null, null, '2018-04-04 14:33:42', '2018-04-04 14:39:12', null);
INSERT INTO `item_work_notice` VALUES ('245', '4', '1', '16', '244', '0', '0', '1', '1', '/gov/itemadmin?item=4', '0', null, null, null, '2018-04-04 14:33:42', '2018-04-04 14:34:06', '2018-04-04 14:34:06');
INSERT INTO `item_work_notice` VALUES ('246', '4', '1', '16', '244', '1', '0', '1', '3', '/gov/itemadmin?item=4', '0', null, null, null, '2018-04-04 14:33:42', '2018-04-04 14:34:06', '2018-04-04 14:34:06');
INSERT INTO `item_work_notice` VALUES ('247', '4', '1', '16', '244', '1', '0', '1', '4', '/gov/itemadmin?item=4', '0', null, null, null, '2018-04-04 14:33:42', '2018-04-04 14:34:06', '2018-04-04 14:34:06');
INSERT INTO `item_work_notice` VALUES ('248', '4', '1', '16', '244', '1', '0', '2', '5', '/gov/itemadmin?item=4', '0', null, null, null, '2018-04-04 14:33:42', '2018-04-04 14:34:06', '2018-04-04 14:34:06');
INSERT INTO `item_work_notice` VALUES ('249', '4', '1', '16', '244', '1', '0', '2', '9', '/gov/itemadmin?item=4', '0', null, null, null, '2018-04-04 14:33:42', '2018-04-04 14:34:06', '2018-04-04 14:34:06');
INSERT INTO `item_work_notice` VALUES ('250', '4', '1', '16', '244', '1', '2', '3', '6', '/gov/itemadmin?item=4', '0', null, null, null, '2018-04-04 14:33:42', '2018-04-04 14:34:06', '2018-04-04 14:34:06');
INSERT INTO `item_work_notice` VALUES ('251', '4', '1', '16', '244', '1', '2', '3', '10', '/gov/itemadmin?item=4', '2', null, null, null, '2018-04-04 14:33:42', '2018-04-04 14:34:05', null);
INSERT INTO `item_work_notice` VALUES ('252', '4', '1', '11', '248', '0', '0', '1', '1', '/gov/check_set_to_check?item=4', '0', null, null, null, '2018-04-04 14:39:12', '2018-04-04 14:39:20', '2018-04-04 14:39:20');
INSERT INTO `item_work_notice` VALUES ('253', '4', '1', '11', '248', '1', '0', '1', '3', '/gov/check_set_to_check?item=4', '0', null, null, null, '2018-04-04 14:39:12', '2018-04-04 14:39:20', '2018-04-04 14:39:20');
INSERT INTO `item_work_notice` VALUES ('254', '4', '1', '11', '248', '1', '0', '1', '4', '/gov/check_set_to_check?item=4', '0', null, null, null, '2018-04-04 14:39:12', '2018-04-04 14:39:20', '2018-04-04 14:39:20');
INSERT INTO `item_work_notice` VALUES ('255', '4', '1', '11', '248', '1', '0', '2', '5', '/gov/check_set_to_check?item=4', '0', null, null, null, '2018-04-04 14:39:12', '2018-04-04 14:39:20', '2018-04-04 14:39:20');
INSERT INTO `item_work_notice` VALUES ('256', '4', '1', '11', '248', '1', '0', '2', '9', '/gov/check_set_to_check?item=4', '0', null, null, null, '2018-04-04 14:39:12', '2018-04-04 14:39:20', '2018-04-04 14:39:20');
INSERT INTO `item_work_notice` VALUES ('257', '4', '1', '11', '248', '1', '2', '3', '6', '/gov/check_set_to_check?item=4', '0', null, null, null, '2018-04-04 14:39:12', '2018-04-04 14:39:20', '2018-04-04 14:39:20');
INSERT INTO `item_work_notice` VALUES ('258', '4', '1', '11', '248', '1', '2', '3', '10', '/gov/check_set_to_check?item=4', '2', null, null, null, '2018-04-04 14:39:12', '2018-04-04 14:39:20', null);
INSERT INTO `item_work_notice` VALUES ('259', '4', '1', '12', '249', '0', '0', '1', '1', '/gov/check_set_check?item=4', '20', null, null, null, '2018-04-04 14:39:20', '2018-04-04 14:44:11', '2018-04-04 14:44:11');
INSERT INTO `item_work_notice` VALUES ('260', '4', '1', '12', '249', '1', '0', '1', '3', '/gov/check_set_check?item=4', '20', null, null, null, '2018-04-04 14:39:20', '2018-04-04 14:44:11', '2018-04-04 14:44:11');
INSERT INTO `item_work_notice` VALUES ('261', '4', '1', '12', '249', '1', '0', '1', '4', '/gov/check_set_check?item=4', '20', null, null, null, '2018-04-04 14:39:20', '2018-04-04 14:44:11', '2018-04-04 14:44:11');
INSERT INTO `item_work_notice` VALUES ('262', '4', '1', '12', '249', '1', '0', '2', '5', '/gov/check_set_check?item=4', '20', null, null, null, '2018-04-04 14:39:20', '2018-04-04 14:44:11', '2018-04-04 14:44:11');
INSERT INTO `item_work_notice` VALUES ('263', '4', '1', '12', '249', '1', '0', '2', '9', '/gov/check_set_check?item=4', '23', null, '审查驳回', null, '2018-04-04 14:39:20', '2018-04-04 14:44:11', null);
INSERT INTO `item_work_notice` VALUES ('264', '4', '1', '12', '249', '1', '2', '3', '6', '/gov/check_set_check?item=4', '20', null, null, null, '2018-04-04 14:39:20', '2018-04-04 14:45:42', '2018-04-04 14:45:42');
INSERT INTO `item_work_notice` VALUES ('265', '4', '1', '12', '249', '1', '2', '3', '10', '/gov/check_set_check?item=4', '22', null, '审查通过', null, '2018-04-04 14:39:20', '2018-04-04 14:45:42', null);
INSERT INTO `item_work_notice` VALUES ('266', '4', '1', '9', '245', '0', '0', '1', '1', '/gov/itemuser?item=4', '0', null, null, null, '2018-04-04 14:44:11', '2018-04-04 15:00:01', '2018-04-04 15:00:01');
INSERT INTO `item_work_notice` VALUES ('267', '4', '1', '9', '245', '1', '0', '1', '3', '/gov/itemuser?item=4', '0', null, null, null, '2018-04-04 14:44:11', '2018-04-04 15:00:01', '2018-04-04 15:00:01');
INSERT INTO `item_work_notice` VALUES ('268', '4', '1', '9', '245', '1', '0', '1', '4', '/gov/itemuser?item=4', '0', null, null, null, '2018-04-04 14:44:11', '2018-04-04 15:00:01', '2018-04-04 15:00:01');
INSERT INTO `item_work_notice` VALUES ('269', '4', '1', '9', '245', '1', '0', '2', '5', '/gov/itemuser?item=4', '0', null, null, null, '2018-04-04 14:44:11', '2018-04-04 15:00:01', '2018-04-04 15:00:01');
INSERT INTO `item_work_notice` VALUES ('270', '4', '1', '9', '245', '1', '0', '2', '9', '/gov/itemuser?item=4', '2', null, null, null, '2018-04-04 14:44:11', '2018-04-04 15:00:01', null);
INSERT INTO `item_work_notice` VALUES ('271', '4', '1', '9', '245', '1', '2', '3', '6', '/gov/itemuser?item=4', '0', null, null, null, '2018-04-04 14:44:11', '2018-04-04 15:00:01', '2018-04-04 15:00:01');
INSERT INTO `item_work_notice` VALUES ('272', '4', '1', '9', '245', '1', '2', '3', '10', '/gov/itemuser?item=4', '0', null, null, null, '2018-04-04 14:44:11', '2018-04-04 15:00:01', '2018-04-04 15:00:01');
INSERT INTO `item_work_notice` VALUES ('273', '4', '1', '10', '246', '0', '0', '1', '1', '/gov/itemtime?item=4', '0', null, null, null, '2018-04-04 14:44:11', '2018-04-04 15:00:08', '2018-04-04 15:00:08');
INSERT INTO `item_work_notice` VALUES ('274', '4', '1', '10', '246', '1', '0', '1', '3', '/gov/itemtime?item=4', '0', null, null, null, '2018-04-04 14:44:11', '2018-04-04 15:00:08', '2018-04-04 15:00:08');
INSERT INTO `item_work_notice` VALUES ('275', '4', '1', '10', '246', '1', '0', '1', '4', '/gov/itemtime?item=4', '0', null, null, null, '2018-04-04 14:44:11', '2018-04-04 15:00:08', '2018-04-04 15:00:08');
INSERT INTO `item_work_notice` VALUES ('276', '4', '1', '10', '246', '1', '0', '2', '5', '/gov/itemtime?item=4', '0', null, null, null, '2018-04-04 14:44:11', '2018-04-04 15:00:08', '2018-04-04 15:00:08');
INSERT INTO `item_work_notice` VALUES ('277', '4', '1', '10', '246', '1', '0', '2', '9', '/gov/itemtime?item=4', '2', null, null, null, '2018-04-04 14:44:11', '2018-04-04 15:00:08', null);
INSERT INTO `item_work_notice` VALUES ('278', '4', '1', '10', '246', '1', '2', '3', '6', '/gov/itemtime?item=4', '0', null, null, null, '2018-04-04 14:44:11', '2018-04-04 15:00:08', '2018-04-04 15:00:08');
INSERT INTO `item_work_notice` VALUES ('279', '4', '1', '10', '246', '1', '2', '3', '10', '/gov/itemtime?item=4', '0', null, null, null, '2018-04-04 14:44:11', '2018-04-04 15:00:08', '2018-04-04 15:00:08');
INSERT INTO `item_work_notice` VALUES ('280', '4', '1', '16', '244', '0', '0', '1', '1', '/gov/itemadmin?item=4', '0', null, null, null, '2018-04-04 14:44:11', '2018-04-04 14:44:28', '2018-04-04 14:44:28');
INSERT INTO `item_work_notice` VALUES ('281', '4', '1', '16', '244', '1', '0', '1', '3', '/gov/itemadmin?item=4', '0', null, null, null, '2018-04-04 14:44:11', '2018-04-04 14:44:28', '2018-04-04 14:44:28');
INSERT INTO `item_work_notice` VALUES ('282', '4', '1', '16', '244', '1', '0', '1', '4', '/gov/itemadmin?item=4', '0', null, null, null, '2018-04-04 14:44:11', '2018-04-04 14:44:28', '2018-04-04 14:44:28');
INSERT INTO `item_work_notice` VALUES ('283', '4', '1', '16', '244', '1', '0', '2', '5', '/gov/itemadmin?item=4', '0', null, null, null, '2018-04-04 14:44:11', '2018-04-04 14:44:28', '2018-04-04 14:44:28');
INSERT INTO `item_work_notice` VALUES ('284', '4', '1', '16', '244', '1', '0', '2', '9', '/gov/itemadmin?item=4', '2', null, null, null, '2018-04-04 14:44:11', '2018-04-04 14:59:48', null);
INSERT INTO `item_work_notice` VALUES ('285', '4', '1', '16', '244', '1', '2', '3', '6', '/gov/itemadmin?item=4', '0', null, null, null, '2018-04-04 14:44:11', '2018-04-04 14:44:28', '2018-04-04 14:44:28');
INSERT INTO `item_work_notice` VALUES ('286', '4', '1', '16', '244', '1', '2', '3', '10', '/gov/itemadmin?item=4', '0', null, null, null, '2018-04-04 14:44:11', '2018-04-04 14:44:28', '2018-04-04 14:44:28');
INSERT INTO `item_work_notice` VALUES ('294', '4', '1', '11', '248', '0', '0', '1', '1', '/gov/check_set_to_check?item=4', '0', null, null, null, '2018-04-04 15:00:08', '2018-04-04 15:04:11', '2018-04-04 15:04:11');
INSERT INTO `item_work_notice` VALUES ('295', '4', '1', '11', '248', '1', '0', '1', '3', '/gov/check_set_to_check?item=4', '0', null, null, null, '2018-04-04 15:00:08', '2018-04-04 15:04:11', '2018-04-04 15:04:11');
INSERT INTO `item_work_notice` VALUES ('296', '4', '1', '11', '248', '1', '0', '1', '4', '/gov/check_set_to_check?item=4', '0', null, null, null, '2018-04-04 15:00:08', '2018-04-04 15:04:11', '2018-04-04 15:04:11');
INSERT INTO `item_work_notice` VALUES ('297', '4', '1', '11', '248', '1', '0', '2', '5', '/gov/check_set_to_check?item=4', '0', null, null, null, '2018-04-04 15:00:08', '2018-04-04 15:04:11', '2018-04-04 15:04:11');
INSERT INTO `item_work_notice` VALUES ('298', '4', '1', '11', '248', '1', '0', '2', '9', '/gov/check_set_to_check?item=4', '0', null, null, null, '2018-04-04 15:00:08', '2018-04-04 15:04:11', '2018-04-04 15:04:11');
INSERT INTO `item_work_notice` VALUES ('299', '4', '1', '11', '248', '1', '2', '3', '6', '/gov/check_set_to_check?item=4', '0', null, null, null, '2018-04-04 15:00:08', '2018-04-04 15:04:11', '2018-04-04 15:04:11');
INSERT INTO `item_work_notice` VALUES ('300', '4', '1', '11', '248', '1', '2', '3', '10', '/gov/check_set_to_check?item=4', '2', null, null, null, '2018-04-04 15:00:08', '2018-04-04 15:04:11', null);
INSERT INTO `item_work_notice` VALUES ('301', '4', '1', '12', '249', '0', '0', '1', '1', '/gov/check_set_check?item=4', '20', null, null, null, '2018-04-04 15:04:11', '2018-04-04 15:02:50', '2018-04-04 15:02:50');
INSERT INTO `item_work_notice` VALUES ('302', '4', '1', '12', '249', '1', '0', '1', '3', '/gov/check_set_check?item=4', '20', null, null, null, '2018-04-04 15:04:11', '2018-04-04 15:02:50', '2018-04-04 15:02:50');
INSERT INTO `item_work_notice` VALUES ('303', '4', '1', '12', '249', '1', '0', '1', '4', '/gov/check_set_check?item=4', '20', null, null, null, '2018-04-04 15:04:11', '2018-04-04 15:02:50', '2018-04-04 15:02:50');
INSERT INTO `item_work_notice` VALUES ('304', '4', '1', '12', '249', '1', '0', '2', '5', '/gov/check_set_check?item=4', '20', null, null, null, '2018-04-04 15:04:11', '2018-04-04 15:02:50', '2018-04-04 15:02:50');
INSERT INTO `item_work_notice` VALUES ('305', '4', '1', '12', '249', '1', '0', '2', '9', '/gov/check_set_check?item=4', '22', null, '审查通过', null, '2018-04-04 15:04:11', '2018-04-04 15:02:50', null);
INSERT INTO `item_work_notice` VALUES ('306', '4', '1', '12', '249', '1', '2', '3', '6', '/gov/check_set_check?item=4', '20', null, null, null, '2018-04-04 15:04:11', '2018-04-04 15:04:20', '2018-04-04 15:04:20');
INSERT INTO `item_work_notice` VALUES ('307', '4', '1', '12', '249', '1', '2', '3', '10', '/gov/check_set_check?item=4', '22', null, '审查通过', null, '2018-04-04 15:04:11', '2018-04-04 15:04:20', null);
INSERT INTO `item_work_notice` VALUES ('308', '4', '1', '13', '252', '0', '0', '1', '1', '/gov/check_item_start?item=4', '0', null, null, null, '2018-04-04 15:02:50', '2018-04-04 15:04:56', '2018-04-04 15:04:56');
INSERT INTO `item_work_notice` VALUES ('309', '4', '1', '13', '252', '1', '0', '1', '3', '/gov/check_item_start?item=4', '0', null, null, null, '2018-04-04 15:02:50', '2018-04-04 15:04:56', '2018-04-04 15:04:56');
INSERT INTO `item_work_notice` VALUES ('310', '4', '1', '13', '252', '1', '0', '1', '4', '/gov/check_item_start?item=4', '0', null, null, null, '2018-04-04 15:02:50', '2018-04-04 15:04:56', '2018-04-04 15:04:56');
INSERT INTO `item_work_notice` VALUES ('311', '4', '1', '13', '252', '1', '0', '2', '5', '/gov/check_item_start?item=4', '0', null, null, null, '2018-04-04 15:02:50', '2018-04-04 15:04:56', '2018-04-04 15:04:56');
INSERT INTO `item_work_notice` VALUES ('312', '4', '1', '13', '252', '1', '0', '2', '9', '/gov/check_item_start?item=4', '0', null, null, null, '2018-04-04 15:02:50', '2018-04-04 15:04:56', '2018-04-04 15:04:56');
INSERT INTO `item_work_notice` VALUES ('313', '4', '1', '13', '252', '1', '2', '3', '6', '/gov/check_item_start?item=4', '0', null, null, null, '2018-04-04 15:02:50', '2018-04-04 15:04:56', '2018-04-04 15:04:56');
INSERT INTO `item_work_notice` VALUES ('314', '4', '1', '13', '252', '1', '2', '3', '10', '/gov/check_item_start?item=4', '2', null, null, null, '2018-04-04 15:02:50', '2018-04-04 15:04:56', null);
INSERT INTO `item_work_notice` VALUES ('316', '4', '2', '14', '258', '1', '0', '2', '9', '/gov/initbudget?item=4', '0', null, null, null, '2018-04-04 15:04:56', '2018-04-04 15:08:29', '2018-04-04 15:08:29');
INSERT INTO `item_work_notice` VALUES ('317', '4', '2', '14', '258', '1', '2', '3', '10', '/gov/initbudget?item=4', '2', null, null, null, '2018-04-04 15:04:56', '2018-04-04 15:08:29', null);
INSERT INTO `item_work_notice` VALUES ('319', '4', '2', '17', '361', '1', '0', '2', '9', '/gov/ready_init_check?item=4', '23', null, '审查驳回', null, '2018-04-04 15:08:29', '2018-04-04 15:07:14', null);
INSERT INTO `item_work_notice` VALUES ('320', '4', '2', '17', '361', '1', '2', '3', '10', '/gov/ready_init_check?item=4', '22', null, '审查通过', null, '2018-04-04 15:08:29', '2018-04-04 15:08:52', null);
INSERT INTO `item_work_notice` VALUES ('322', '4', '2', '20', '259', '1', '0', '2', '9', '/gov/initbudget_edit?item=4', '0', null, null, null, '2018-04-04 15:07:14', '2018-04-04 15:09:43', '2018-04-04 15:09:43');
INSERT INTO `item_work_notice` VALUES ('323', '4', '2', '20', '259', '1', '2', '3', '10', '/gov/initbudget_edit?item=4', '2', null, null, null, '2018-04-04 15:07:14', '2018-04-04 15:09:43', null);
INSERT INTO `item_work_notice` VALUES ('325', '4', '2', '17', '361', '1', '0', '2', '9', '/gov/ready_init_check?item=4', '22', null, '审查通过', null, '2018-04-04 15:09:43', '2018-04-04 15:08:49', null);
INSERT INTO `item_work_notice` VALUES ('326', '4', '2', '17', '361', '1', '2', '3', '10', '/gov/ready_init_check?item=4', '22', null, '审查通过', null, '2018-04-04 15:09:43', '2018-04-04 15:10:13', null);
INSERT INTO `item_work_notice` VALUES ('328', '4', '2', '18', '362', '1', '0', '2', '9', '/gov/ready_prepare?item=4', '0', null, null, null, '2018-04-04 15:08:49', '2018-04-04 15:10:48', '2018-04-04 15:10:48');
INSERT INTO `item_work_notice` VALUES ('329', '4', '2', '18', '362', '1', '2', '3', '10', '/gov/ready_prepare?item=4', '1', null, null, null, '2018-04-04 15:08:49', '2018-04-04 15:10:48', null);
INSERT INTO `item_work_notice` VALUES ('330', '4', '2', '21', '363', '1', '0', '2', '5', '/gov/ready_funds?item=4', '0', null, null, null, '2018-04-04 15:10:48', '2018-04-04 15:14:32', '2018-04-04 15:14:32');
INSERT INTO `item_work_notice` VALUES ('331', '4', '2', '21', '363', '1', '0', '2', '9', '/gov/ready_funds?item=4', '0', null, null, null, '2018-04-04 15:10:48', '2018-04-04 15:14:32', '2018-04-04 15:14:32');
INSERT INTO `item_work_notice` VALUES ('332', '4', '2', '21', '363', '1', '2', '3', '6', '/gov/ready_funds?item=4', '0', null, null, null, '2018-04-04 15:10:48', '2018-04-04 15:14:32', '2018-04-04 15:14:32');
INSERT INTO `item_work_notice` VALUES ('333', '4', '2', '21', '363', '1', '2', '3', '10', '/gov/ready_funds?item=4', '2', null, null, null, '2018-04-04 15:10:48', '2018-04-04 15:14:32', null);
INSERT INTO `item_work_notice` VALUES ('334', '4', '2', '22', '364', '1', '0', '2', '5', '/gov/itemhouse?item=4', '0', null, null, null, '2018-04-04 15:10:48', '2018-04-04 15:20:03', '2018-04-04 15:20:03');
INSERT INTO `item_work_notice` VALUES ('335', '4', '2', '22', '364', '1', '0', '2', '9', '/gov/itemhouse?item=4', '0', null, null, null, '2018-04-04 15:10:48', '2018-04-04 15:20:03', '2018-04-04 15:20:03');
INSERT INTO `item_work_notice` VALUES ('336', '4', '2', '22', '364', '1', '2', '3', '6', '/gov/itemhouse?item=4', '0', null, null, null, '2018-04-04 15:10:48', '2018-04-04 15:20:03', '2018-04-04 15:20:03');
INSERT INTO `item_work_notice` VALUES ('337', '4', '2', '22', '364', '1', '2', '3', '10', '/gov/itemhouse?item=4', '2', null, null, null, '2018-04-04 15:10:48', '2018-04-04 15:20:03', null);
INSERT INTO `item_work_notice` VALUES ('339', '4', '2', '19', '365', '1', '0', '2', '9', '/gov/ready_prepare_check?item=4', '22', null, '审查通过', null, '2018-04-04 15:20:03', '2018-04-04 15:31:48', null);
INSERT INTO `item_work_notice` VALUES ('340', '4', '2', '19', '365', '1', '2', '3', '10', '/gov/ready_prepare_check?item=4', '22', null, '审查通过', null, '2018-04-04 15:20:03', '2018-04-04 15:33:11', null);
INSERT INTO `item_work_notice` VALUES ('342', '4', '2', '23', '279', '1', '0', '2', '9', '/gov/news_add?item=4', '0', null, null, null, '2018-04-04 15:31:48', '2018-04-04 15:36:11', '2018-04-04 15:36:11');
INSERT INTO `item_work_notice` VALUES ('343', '4', '2', '23', '279', '1', '2', '3', '10', '/gov/news_add?item=4', '2', null, null, null, '2018-04-04 15:31:48', '2018-04-04 16:21:57', null);
INSERT INTO `item_work_notice` VALUES ('347', '4', '2', '24', '375', '1', '0', '2', '9', '/gov/ready_range_check?item=4', '22', null, '审查通过', null, '2018-04-04 16:21:57', '2018-04-04 16:21:39', null);
INSERT INTO `item_work_notice` VALUES ('348', '4', '2', '24', '375', '1', '2', '3', '10', '/gov/ready_range_check?item=4', '22', null, '审查通过', null, '2018-04-04 16:21:57', '2018-04-04 16:22:34', null);
INSERT INTO `item_work_notice` VALUES ('349', '4', '3', '25', '376', '1', '0', '2', '9', '/gov/survey?item=4', '0', null, null, null, '2018-04-04 16:21:39', '2018-04-04 16:21:39', null);
INSERT INTO `item_work_notice` VALUES ('350', '4', '3', '25', '376', '1', '2', '3', '10', '/gov/survey?item=4', '0', null, null, null, '2018-04-04 16:21:39', '2018-04-04 16:21:39', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='通知公告';

-- ----------------------------
-- Records of news
-- ----------------------------
INSERT INTO `news` VALUES ('1', '3', '1', '西关片区棚户区改造项目房屋征收范围的公告', '2018-03-01', null, '西关片区棚户区改造项目房屋征收范围的公告', '<p><img src=\"/ueditor/php/upload/image/20180302/1519960168.jpg\" alt=\"1519960168.jpg\" width=\"316\" height=\"194\"/></p><p>西关片区棚户区改造项目房屋征收范围的公告</p><p><br/></p><p>西关片区棚户区改造项目房屋征收范围的公告</p>', '[\"\\/storage\\/180302\\/lzz2FqIqLjZDDv2arwjKhmm5JZmEiFDC4mX51hsK.jpeg\"]', '0', '22', '2018-03-02 10:11:23', '2018-03-02 11:10:47', null);
INSERT INTO `news` VALUES ('2', '1', '3', '房屋征收', '2018-04-07', '征收', '珍兽', '<p>征收</p>', '[\"\\/storage\\/180329\\/MWS46j0fqimhtHhmPgwBPvQwrET7MsxYfJE5uIDg.jpeg\"]', '0', '22', '2018-03-29 09:27:54', '2018-03-29 09:26:29', null);
INSERT INTO `news` VALUES ('3', '2', '3', '征收意见稿', '2018-03-31', '征收意见', '征收意见搞', '<p>内容</p>', '[\"\\/storage\\/180329\\/BKXoXoofTL6M6V4BR2ZDxyx0YhsAdx4PrV2GuRiC.jpeg\"]', '0', '22', '2018-03-29 10:52:01', '2018-03-29 10:52:01', null);
INSERT INTO `news` VALUES ('4', '3', '3', '征收公告', '2018-03-29', '征收公告', '征收高工', '<p>征收公告</p>', '[\"\\/storage\\/180329\\/3xDos7kZKIFduTgYvF1mlu6qhJ1QsYJhsyRKrrTI.jpeg\"]', '0', '22', '2018-03-29 11:01:37', '2018-03-29 11:01:37', null);
INSERT INTO `news` VALUES ('6', '1', '4', '测试项目20180404征收范围公告', '2018-04-04', '征收范围公告', '征收范围公告', '<p>征收范围公告</p>', '[\"\\/storage\\/180404\\/pmUYo61UrCKL8LifGYuyCSz7ct3JouMCfPAEW3JA.png\"]', '0', '22', '2018-04-04 16:21:57', '2018-04-04 16:21:39', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='兑付-协议';

-- ----------------------------
-- Records of pact
-- ----------------------------
INSERT INTO `pact` VALUES ('1', '1', '1', '1', '1', '71', '1', '{\"pay_pact\":\"<!DOCTYPE html>\\r\\n<html>\\r\\n\\r\\n<head>\\r\\n    <meta charset=\\\"UTF-8\\\">\\r\\n    <title><\\/title>\\r\\n    <style type=\\\"text\\/css\\\">\\r\\n        * {\\r\\n            margin: 0;\\r\\n            padding: 0;\\r\\n            font-size: 30px;\\r\\n            font-weight: 100;\\r\\n        }\\r\\n\\r\\n        tr {\\r\\n            line-height: 80px;\\r\\n        }\\r\\n\\r\\n        td {\\r\\n            padding: 5px 10px;\\r\\n        }\\r\\n\\r\\n        h1 {\\r\\n            text-align: center;\\r\\n            font-size: 40px;\\r\\n        }\\r\\n\\r\\n        .center_text {\\r\\n            text-align: center;\\r\\n        }\\r\\n\\r\\n        .wrap {\\r\\n            width: 794px;\\r\\n            height: 1158px;\\r\\n            margin: auto;\\r\\n        }\\r\\n\\r\\n        .div1 {\\r\\n            float: left;\\r\\n            box-sizing: border-box;\\r\\n            height: 40px;\\r\\n        }\\r\\n\\r\\n        .width380 {\\r\\n            width: 380px;\\r\\n        }\\r\\n\\r\\n        .width520 {\\r\\n            width: 520px;\\r\\n        }\\r\\n\\r\\n        .ov {\\r\\n            overflow: hidden;\\r\\n        }\\r\\n\\r\\n        .lineheight50 {\\r\\n            line-height: 50px;\\r\\n        }\\r\\n\\r\\n        .mt20px {\\r\\n            margin-top: 20px;\\r\\n        }\\r\\n\\r\\n        .mb20px {\\r\\n            margin-bottom: 20px;\\r\\n        }\\r\\n\\r\\n        .color66 {\\r\\n            color: #333;\\r\\n            font-weight: normal;\\r\\n            font-size: 24px;\\r\\n        }\\r\\n\\r\\n        .text_indent50 {\\r\\n            text-indent: 50px;\\r\\n        }\\r\\n\\r\\n        .div_border_bot {\\r\\n            height: 40px;\\r\\n            display: inline-block;\\r\\n            border-bottom: 2px solid #000;\\r\\n        }\\r\\n\\r\\n        .width100 {\\r\\n            width: 100px;\\r\\n        }\\r\\n\\r\\n        .width_100 {\\r\\n            width: 100%;\\r\\n        }\\r\\n\\r\\n        .width200 {\\r\\n            width: 200px;\\r\\n        }\\r\\n\\r\\n        .height40 {\\r\\n            height: 40px;\\r\\n        }\\r\\n\\r\\n        ul li {\\r\\n            list-style: none;\\r\\n        }\\r\\n\\r\\n        .table_a td {\\r\\n            text-align: center;\\r\\n        }\\r\\n    <\\/style>\\r\\n<\\/head>\\r\\n\\r\\n\\r\\n<body>\\r\\n<!--\\u5360\\u6ee1\\u4e00\\u9875-->\\r\\n<div class=\\\"wrap\\\">\\r\\n    <h1 style=\\\"padding-top: 50px;\\\">\\u897f\\u5173\\u7247\\u533a\\u68da\\u6237\\u533a\\u6539\\u9020\\u9879\\u76ee<\\/h1>\\r\\n    <h1 style=\\\"margin-top: 10px;\\\">\\u623f\\u5c4b\\u5f81\\u6536\\u8865\\u507f\\u5b89\\u7f6e\\u534f\\u8bae\\u4e66\\uff08\\u4e00\\uff09<\\/h1>\\r\\n    <div class=\\\"center_text\\\" style=\\\"margin-top: 500px;\\\">\\r\\n        \\u5f81\\u6536\\u5355\\u4f4d:\\r\\n        <span style=\\\"display: inline-block;width: 460px;height: 30px;border-bottom:3px solid #000 ;\\\">\\u79e6\\u5dde\\u533a\\u623f\\u5c4b\\u5f81\\u6536\\u8865\\u507f\\u7ba1\\u7406\\u5c40<\\/span>\\r\\n    <\\/div>\\r\\n    <div class=\\\"center_text\\\" style=\\\"margin-top: 140px;\\\">\\r\\n        \\u88ab\\u5f81\\u6536\\u4eba:\\r\\n        <span style=\\\"display: inline-block;width: 460px;height: 30px;border-bottom:3px solid #000 ;\\\">\\r\\n            \\u5f20\\u4e00\\r\\n        <\\/span>\\r\\n    <\\/div>\\r\\n    <div class=\\\"center_text\\\" style=\\\"margin-top: 100px;\\\">\\u79e6\\u5dde\\u533a\\u623f\\u5c4b\\u5f81\\u6536\\u8865\\u507f\\u7ba1\\u7406\\u5c40\\u5236<\\/div>\\r\\n    <div class=\\\"center_text\\\" style=\\\"margin-top: 50px;\\\">2018\\u5e7404\\u670801\\u65e5<\\/div>\\r\\n<\\/div>\\r\\n<div class=\\\"content\\\" style=\\\"width: 794px;margin: auto;\\\">\\r\\n    <h2 class=\\\"center_text\\\" style=\\\"line-height: 120px;\\\">\\u623f\\u5c4b\\u5f81\\u6536\\u8865\\u507f\\u5b89\\u7f6e\\u534f\\u8bae\\u4e66(\\u4e00)<\\/h2>\\r\\n    <div>\\r\\n        <div class=\\\"ov lineheight50 mb20px color66\\\">\\r\\n            <div class=\\\"div1\\\" style=\\\"width: 300px;\\\">\\u5f81\\u6536\\u5b9e\\u65bd\\u5355\\u4f4d(\\u7532\\u65b9):<\\/div>\\r\\n            <div class=\\\"div1\\\" style=\\\"width: 460px; padding: 0 15px;border-bottom: 2px solid black;\\\">\\u79e6\\u5dde\\u533a\\u623f\\u5c4b\\u5f81\\u6536\\u8865\\u507f\\u7ba1\\u7406\\u5c40<\\/div>\\r\\n        <\\/div>\\r\\n        <div class=\\\"ov lineheight50 color66\\\">\\r\\n            <div class=\\\"div1 mb20px \\\" style=\\\"width: 300px;\\\">\\u88ab \\u5f81 \\u6536 \\u4eba (\\u4e59\\u65b9)&nbsp;:<\\/div>\\r\\n            <div class=\\\"div1\\\" style=\\\"width: 460px;padding: 0 15px;border-bottom: 2px solid black;\\\">\\r\\n                \\u5f20\\u4e00\\r\\n            <\\/div>\\r\\n        <\\/div>\\r\\n    <\\/div>\\r\\n\\r\\n    <div class=\\\"color66\\\" style=\\\"line-height: 50px;text-indent: 50px;\\\">\\u6839\\u636e\\u300a\\u56fd\\u6709\\u571f\\u5730\\u4e0a\\u623f\\u5c4b\\u5f81\\u6536\\u4e0e\\u8865\\u507f\\u6761\\u4f8b\\u300b\\u3001\\u300a\\u7518\\u8083\\u7701\\u5b9e\\u65bd\\r\\n        &lt;\\u56fd\\u6709\\u571f\\u5730\\u4e0a\\u623f\\u5c4b\\u5f81\\u6536\\u4e0e\\u8865\\u507f\\u6761\\u4f8b&gt;\\u82e5\\u5e72\\u89c4\\u5b9a\\u300b\\u3001\\u300a\\u56fd\\u6709\\u571f\\u5730\\u4e0a\\u623f\\u5c4b\\u5f81\\u6536\\u8bc4\\u4f30\\u529e\\u6cd5\\u300b\\u53ca\\u300a\\u5929\\u6c34\\u5e02\\u79e6\\u5dde\\u533a\\u4eba\\u6c11\\u653f\\u5e9c\\u5173\\u4e8e\\u5929\\u6c34\\u4fe1\\u53f7\\u5382\\u7247\\u533a\\u571f\\u5730\\u719f\\u5316\\u9879\\u76ee\\u4e8c\\u671f\\u623f\\u5c4b\\u5f81\\u6536\\u8865\\u507f\\u5b89\\u7f6e\\u5b9e\\u65bd\\u65b9\\u6848\\u300b\\u7684\\u89c4\\u5b9a\\uff0c\\u7532\\u4e59\\u53cc\\u65b9\\u672c\\u7740\\u516c\\u5e73\\u5408\\u7406\\u3001\\u5e73\\u7b49\\u534f\\u5546\\u7684\\u539f\\u5219\\uff0c\\u5c31\\u4e59\\u65b9\\u4f4d\\u4e8e\\u8be5\\u9879\\u76ee\\u89c4\\u5212\\u533a\\u57df\\u5185\\u623f\\u5c4b\\u7684\\u5f81\\u6536\\u8865\\u507f\\u5b89\\u7f6e\\u8fbe\\u6210\\u5982\\u4e0b\\u534f\\u8bae\\u3002<\\/div>\\r\\n    <!--\\u8fd9\\u91cc\\u662f\\u534f\\u8bae\\u5185\\u5bb9-->\\r\\n    <div>\\r\\n        <!--\\u65e0\\u5217\\u8868\\u6837\\u5f0f-->\\r\\n        <div>\\r\\n            <h3 style=\\\"text-indent: 50px;line-height: 50px;\\\"> \\u4e00\\u3001\\u88ab\\u5f81\\u6536\\u623f\\u5c4b\\u73b0\\u72b6<\\/h3>\\r\\n            <div class=\\\"text_indent50 lineheight50 color66\\\">\\r\\n                \\u623f\\u5c4b\\u6240\\u5728\\u5730<div class=\\\"width200 height40 div_border_bot\\\">\\r\\n                    \\u6e1d\\u5317\\u533a\\u529b\\u534e\\u79d1\\u8c37\\r\\n                    1\\u680b\\r\\n                    1\\u5355\\u5143\\r\\n                    1\\u697c\\r\\n                    1\\u53f7\\r\\n                <\\/div>\\r\\n                \\uff0c\\u8bc1\\u8f7d\\u5efa\\u7b51\\u9762\\u79ef<div class=\\\"width200 height40 div_border_bot\\\">100.00<\\/div>\\u5e73\\u65b9\\u7c73\\r\\n                \\uff0c\\u5b9e\\u6d4b\\u9762\\u79ef<div class=\\\"width200 height40 div_border_bot\\\">120.00<\\/div>\\u5e73\\u65b9\\u7c73\\r\\n                \\uff0c\\u623f\\u5c4b\\u6240\\u6709\\u6743\\u4eba<div class=\\\"width200 height40 div_border_bot\\\">\\r\\n                                            \\u5f20\\u4e00\\r\\n                                    <\\/div>\\r\\n                \\uff0c\\u623f\\u5c4b\\u4ea7\\u6743\\u8bc1\\u53f7<div class=\\\"width200 height40 div_border_bot\\\">654321<\\/div>\\r\\n                \\uff0c\\u623f\\u5c4b\\u7684\\u6279\\u51c6\\u7528\\u9014<div class=\\\"width200 height40 div_border_bot\\\">\\u4f4f\\u5b85 <\\/div>\\r\\n                \\uff0c\\u623f\\u5c4b\\u7684\\u5b9e\\u9645\\u7528\\u9014<div class=\\\"width200 height40 div_border_bot\\\">\\u4f4f\\u5b85 <\\/div>\\r\\n                \\uff0c\\u623f\\u5c4b\\u7684\\u4ea7\\u6743\\u6027\\u8d28<div class=\\\"width200 height40 div_border_bot\\\">\\u79c1\\u4ea7 <\\/div>\\r\\n                \\uff0c\\u623f\\u5c4b\\u7684\\u7ed3\\u6784<div class=\\\"width200 height40 div_border_bot\\\">\\u94a2\\u6df7<\\/div>\\r\\n                \\uff0c\\u623f\\u5c4b\\u7684\\u603b\\u5c42\\u6570<div class=\\\"width100 height40 div_border_bot\\\">28<\\/div>\\r\\n                \\uff0c\\u623f\\u5c4b\\u6240\\u5728\\u697c\\u5c42<div class=\\\"width100 height40 div_border_bot\\\">12<\\/div>\\r\\n                \\uff0c\\u623f\\u5c4b\\u671d\\u5411<div class=\\\"width100 height40 div_border_bot\\\">\\u4e1c<\\/div>\\u3002\\r\\n            <\\/div>\\r\\n        <\\/div>\\r\\n        <div>\\r\\n            <h3 style=\\\"text-indent: 50px;line-height: 50px;\\\"> \\u4e8c\\u3001\\u8865\\u507f\\u65b9\\u5f0f<\\/h3>\\r\\n            <div class=\\\"text_indent50 lineheight50 color66\\\">\\r\\n                <div class=\\\"text_indent50 lineheight50 \\\">\\r\\n                    \\u4e59\\u65b9\\u9009\\u62e9\\u4ee5\\u4e0b\\u7684<div class=\\\"width100 height40 div_border_bot\\\">\\u201c\\u623f\\u5c4b\\u4ea7\\u6743\\u8c03\\u6362\\u201d<\\/div>\\u8865\\u507f\\u65b9\\u5f0f\\r\\n                <\\/div>\\r\\n                <ul>\\r\\n                    <li class=\\\"lineheight50\\\">1.\\u8d27\\u5e01\\u8865\\u507f<\\/li>\\r\\n                    <li class=\\\"lineheight50\\\">2.\\u623f\\u5c4b\\u4ea7\\u6743\\u8c03\\u6362<\\/li>\\r\\n                <\\/ul>\\r\\n            <\\/div>\\r\\n        <\\/div>\\r\\n        <div>\\r\\n            <h3 style=\\\"text-indent: 50px;line-height: 50px;\\\"> \\u4e09\\u3001\\u4e59\\u65b9\\u5f81\\u6536\\u6240\\u5f97\\u8865\\u507f\\u7684\\u660e\\u7ec6\\u3002<\\/h3>\\r\\n                                                                        <div>\\r\\n                    <p class=\\\"text_indent50 lineheight50 color66\\\">\\r\\n                        1\\u3001\\u5408\\u6cd5\\u623f\\u5c4b\\u53ca\\u9644\\u5c5e\\u7269\\uff1a\\r\\n                    <\\/p>\\r\\n                    <p class=\\\"text_indent50 lineheight50 color66\\\">\\r\\n                        \\r\\n                    <\\/p>\\r\\n                                            <table class=\\\"table_a color66\\\" border=\\\"1\\\" cellspacing=\\\"0\\\" style=\\\"width: 100%;page-break-before: auto;\\\">\\r\\n                            <thead>\\r\\n                            <tr style=\\\"line-height: 80px;\\\">\\r\\n                                <th style=\\\"line-height: 60px;\\\">\\u623f\\u5c4b\\u7c7b\\u578b<\\/th>\\r\\n                                <th style=\\\"line-height: 60px;\\\">\\u7ed3\\u6784<\\/th>\\r\\n                                <th style=\\\"line-height: 60px;\\\">\\u671d\\u5411<\\/th>\\r\\n                                <th style=\\\"line-height: 60px;\\\">\\u9762\\u79ef(\\u33a1)<\\/th>\\r\\n                                <th style=\\\"line-height: 60px;\\\">\\u8bc4\\u4f30\\u5355\\u4ef7 (\\u5143\\/\\u33a1)<\\/th>\\r\\n                                <th style=\\\"line-height: 60px;\\\">\\u8bc4\\u4f30\\u603b\\u4ef7 (\\u5143)<\\/th>\\r\\n                                <th style=\\\"line-height: 60px;font-size: 20px;\\\">\\r\\n                                    \\u8865\\u507f\\u603b\\u4ef7<br\\/>                                <\\/th>\\r\\n                            <\\/tr>\\r\\n                            <\\/thead>\\r\\n                            <tbody>\\r\\n                                                                                                <tr>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">\\u4f4f\\u5b85<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">\\u7816\\u6df7<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">\\u4e1c<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">120.00<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">10.00<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">1,200.00<\\/td>\\r\\n                                                                                    <td style=\\\"min-height: 80px;\\\">1,200.00<\\/td>\\r\\n                                                                            <\\/tr>\\r\\n                                \\r\\n                            \\r\\n                            <tr>\\r\\n                                <td style=\\\"font-size: 20px;\\\">\\u5408\\u8ba1<\\/td>\\r\\n                                <td>--<\\/td>\\r\\n                                <td>--<\\/td>\\r\\n                                <td>--<\\/td>\\r\\n                                <td>--<\\/td>\\r\\n                                <td>1,200.00<\\/td>\\r\\n                                <td>0.00<\\/td>\\r\\n                            <\\/tr>\\r\\n                            <\\/tbody>\\r\\n                        <\\/table>\\r\\n                                            <div class=\\\"text_indent50 lineheight50 color66\\\">\\r\\n                        \\u7ecf\\u6838\\u5b9a\\uff0c\\u4e59\\u65b9\\u5e94\\u5f97\\u5f81\\u6536\\u8865\\u507f\\u6b3e\\u5171\\u8ba1<div class=\\\"width200 height40 div_border_bot\\\">0.00<\\/div> \\u5143\\r\\n                        \\uff08\\u5927\\u5199\\uff1a<div class=\\\"width200 height40 div_border_bot\\\">\\u5706<\\/div>\\uff09\\u3002\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n                                                            <div>\\r\\n                    <p class=\\\"text_indent50 lineheight50 color66\\\">\\r\\n                        2\\u3001\\u516c\\u5171\\u9644\\u5c5e\\u7269\\uff1a\\r\\n                    <\\/p>\\r\\n                    <p class=\\\"text_indent50 lineheight50 color66\\\">\\r\\n                        \\r\\n                    <\\/p>\\r\\n                                            <table class=\\\"table_a color66\\\" border=\\\"1\\\" cellspacing=\\\"0\\\" style=\\\"width: 100%;page-break-before: auto;\\\">\\r\\n                            <thead>\\r\\n                            <tr style=\\\"line-height: 80px;\\\">\\r\\n                                <th style=\\\"line-height: 60px;\\\">\\u540d\\u79f0<\\/th>\\r\\n                                <th style=\\\"line-height: 60px;\\\">\\u8ba1\\u91cf<\\/th>\\r\\n                                <th style=\\\"line-height: 60px;\\\">\\u8865\\u507f\\u5355\\u4ef7<\\/th>\\r\\n                                <th style=\\\"line-height: 60px;\\\">\\u8865\\u507f\\u603b\\u4ef7 (\\u5143)<\\/th>\\r\\n                                <th style=\\\"line-height: 60px;\\\">\\u5e73\\u5206\\u6237\\u6570<\\/th>\\r\\n                                <th style=\\\"line-height: 60px;\\\">\\u6bcf\\u6237\\u8865\\u507f (\\u5143)<\\/th>\\r\\n                            <\\/tr>\\r\\n                            <\\/thead>\\r\\n                            <tbody>\\r\\n                                                                                                <tr>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">\\u7816<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">50.00 \\u5757<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">111.00<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">5,550.00<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">1<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">5,550.00<\\/td>\\r\\n                                    <\\/tr>\\r\\n                                                                    <tr>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">\\u5927\\u95e8<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">2.00 \\u6247<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">1,212.00<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">2,424.00<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">3<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">808.00<\\/td>\\r\\n                                    <\\/tr>\\r\\n                                \\r\\n                            \\r\\n                            <tr>\\r\\n                                <td style=\\\"font-size: 20px;\\\">\\u5408\\u8ba1<\\/td>\\r\\n                                <td>--<\\/td>\\r\\n                                <td>--<\\/td>\\r\\n                                <td>7,974.00<\\/td>\\r\\n                                <td>--<\\/td>\\r\\n                                <td>0.00<\\/td>\\r\\n                            <\\/tr>\\r\\n                            <\\/tbody>\\r\\n                        <\\/table>\\r\\n                                            <div class=\\\"text_indent50 lineheight50 color66\\\">\\r\\n                        \\u7ecf\\u6838\\u5b9a\\uff0c\\u4e59\\u65b9\\u5e94\\u5f97\\u5f81\\u6536\\u8865\\u507f\\u6b3e\\u5171\\u8ba1<div class=\\\"width200 height40 div_border_bot\\\">0.00<\\/div> \\u5143\\r\\n                        \\uff08\\u5927\\u5199\\uff1a<div class=\\\"width200 height40 div_border_bot\\\">\\u5706<\\/div>\\uff09\\u3002\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n                                                            <div>\\r\\n                    <p class=\\\"text_indent50 lineheight50 color66\\\">\\r\\n                        3\\u3001\\u5176\\u4ed6\\u8865\\u507f\\u4e8b\\u9879\\uff1a\\r\\n                    <\\/p>\\r\\n                    <p class=\\\"text_indent50 lineheight50 color66\\\">\\r\\n                        \\r\\n                    <\\/p>\\r\\n                                            <table class=\\\"table_a color66\\\" border=\\\"1\\\" cellspacing=\\\"0\\\" style=\\\"width: 100%;page-break-before: auto;\\\">\\r\\n                            <thead>\\r\\n                            <tr style=\\\"line-height: 80px;\\\">\\r\\n                                <th style=\\\"line-height: 60px;\\\">\\u540d\\u79f0<\\/th>\\r\\n                                <th style=\\\"line-height: 60px;\\\">\\u8ba1\\u91cf\\u5355\\u4f4d<\\/th>\\r\\n                                <th style=\\\"line-height: 60px;\\\">\\u6570\\u91cf<\\/th>\\r\\n                                <th style=\\\"line-height: 60px;\\\">\\u8865\\u507f\\u5355\\u4ef7<\\/th>\\r\\n                                <th style=\\\"line-height: 60px;\\\">\\u8865\\u507f\\u603b\\u4ef7 (\\u5143)<\\/th>\\r\\n                            <\\/tr>\\r\\n                            <\\/thead>\\r\\n                            <tbody>\\r\\n                                                                                                <tr>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">\\u5bbd\\u5e26<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">\\u6237<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">200.00<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">2.00<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">400.00<\\/td>\\r\\n                                    <\\/tr>\\r\\n                                                                    <tr>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">\\u5bbd\\u5e26<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">\\u6237<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">200.00<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">2.00<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">400.00<\\/td>\\r\\n                                    <\\/tr>\\r\\n                                                                    <tr>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">\\u5bbd\\u5e26<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">\\u6237<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">200.00<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">2.00<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">400.00<\\/td>\\r\\n                                    <\\/tr>\\r\\n                                                                    <tr>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">\\u5bbd\\u5e26<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">\\u6237<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">200.00<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">2.00<\\/td>\\r\\n                                        <td style=\\\"min-height: 80px;\\\">400.00<\\/td>\\r\\n                                    <\\/tr>\\r\\n                                \\r\\n                            \\r\\n                            <tr>\\r\\n                                <td style=\\\"font-size: 20px;\\\">\\u5408\\u8ba1<\\/td>\\r\\n                                <td>--<\\/td>\\r\\n                                <td>--<\\/td>\\r\\n                                <td>--<\\/td>\\r\\n                                <td>0.00<\\/td>\\r\\n                            <\\/tr>\\r\\n                            <\\/tbody>\\r\\n                        <\\/table>\\r\\n                                            <div class=\\\"text_indent50 lineheight50 color66\\\">\\r\\n                        \\u7ecf\\u6838\\u5b9a\\uff0c\\u4e59\\u65b9\\u5e94\\u5f97\\u5f81\\u6536\\u8865\\u507f\\u6b3e\\u5171\\u8ba1<div class=\\\"width200 height40 div_border_bot\\\">0.00<\\/div> \\u5143\\r\\n                        \\uff08\\u5927\\u5199\\uff1a<div class=\\\"width200 height40 div_border_bot\\\">\\u5706<\\/div>\\uff09\\u3002\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n                                                            <div>\\r\\n                    <p class=\\\"text_indent50 lineheight50 color66\\\">\\r\\n                        4\\u3001\\u56fa\\u5b9a\\u8d44\\u4ea7\\uff1a\\r\\n                    <\\/p>\\r\\n                    <p class=\\\"text_indent50 lineheight50 color66\\\">\\r\\n                        \\r\\n                    <\\/p>\\r\\n                                        <div class=\\\"text_indent50 lineheight50 color66\\\">\\r\\n                        \\u7ecf\\u6838\\u5b9a\\uff0c\\u4e59\\u65b9\\u5e94\\u5f97\\u5f81\\u6536\\u8865\\u507f\\u6b3e\\u5171\\u8ba1<div class=\\\"width200 height40 div_border_bot\\\">0.00<\\/div> \\u5143\\r\\n                        \\uff08\\u5927\\u5199\\uff1a<div class=\\\"width200 height40 div_border_bot\\\">\\u5706<\\/div>\\uff09\\u3002\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n                                                            <div>\\r\\n                    <p class=\\\"text_indent50 lineheight50 color66\\\">\\r\\n                        5\\u3001\\u7b7e\\u7ea6\\u5956\\u52b1\\uff08\\u4f4f\\u5b85\\uff09\\uff1a\\r\\n                    <\\/p>\\r\\n                    <p class=\\\"text_indent50 lineheight50 color66\\\">\\r\\n                        \\r\\n                    <\\/p>\\r\\n                                        <div class=\\\"text_indent50 lineheight50 color66\\\">\\r\\n                        \\u7ecf\\u6838\\u5b9a\\uff0c\\u4e59\\u65b9\\u5e94\\u5f97\\u5f81\\u6536\\u8865\\u507f\\u6b3e\\u5171\\u8ba1<div class=\\\"width200 height40 div_border_bot\\\">0.00<\\/div> \\u5143\\r\\n                        \\uff08\\u5927\\u5199\\uff1a<div class=\\\"width200 height40 div_border_bot\\\">\\u5706<\\/div>\\uff09\\u3002\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n                        <div class=\\\"text_indent50 lineheight50 color66\\\">\\r\\n                \\u7efc\\u5408\\u4ee5\\u4e0a\\u6240\\u8ff0\\uff0c\\u4e59\\u65b9\\u5e94\\u5f97\\u8865\\u507f\\u8d44\\u91d1\\u5171\\u8ba1\\uff1a<div class=\\\"width200 height40 div_border_bot\\\">0.00<\\/div> \\u5143\\r\\n                \\uff08\\u5927\\u5199\\uff1a<div class=\\\"width200 height40 div_border_bot\\\">\\u5706<\\/div>\\uff09\\u3002\\r\\n            <\\/div>\\r\\n        <\\/div>\\r\\n        <div>\\r\\n            <h3 style=\\\"text-indent: 50px;line-height: 50px;\\\"> \\u56db\\u3001\\u4e59\\u65b9\\u4ea7\\u6743\\u8c03\\u6362\\u623f\\u5c4b\\u5b89\\u7f6e\\u60c5\\u51b5\\uff08\\u4ee5\\u4e0b\\u7b80\\u79f0\\u5b89\\u7f6e\\u623f\\uff09<\\/h3>\\r\\n            <ul>\\r\\n                <li class=\\\"lineheight50 text_indent50 color66\\\">1.\\u4ea7\\u6743\\u8c03\\u6362\\u6807\\u51c6\\u5b89\\u7f6e\\u9762\\u79ef\\u3002\\u88ab\\u5f81\\u6536\\u4eba\\u4ee5\\u5176\\u5408\\u6cd5\\u623f\\u5c4b\\u7684\\u8bc4\\u4f30\\u8865\\u507f\\u603b\\u4ef7\\u52a0\\u5956\\u52b1\\u8d44\\u91d1\\uff0c\\u4ee5\\u5b89\\u7f6e\\u4ef7\\u8d2d\\u4e70\\u4ea7\\u6743\\u8c03\\u6362\\u5b89\\u7f6e\\u623f\\u5c4b\\uff0c\\u6240\\u80fd\\u8d2d\\u4e70\\u5230\\u7684\\u6700\\u5927\\u4ea7\\u6743\\u8c03\\u6362\\u5b89\\u7f6e\\u623f\\u9762\\u79ef\\uff0c\\u5373\\u4e3a\\u8be5\\u6237\\u7684\\u4ea7\\u6743\\u8c03\\u6362\\u6807\\u51c6\\u5b89\\u7f6e\\u9762\\u79ef\\u3002\\u5177\\u4f53\\u8ba1\\u7b97\\u65b9\\u5f0f\\u4e3a\\uff1a\\u4ea7\\u6743\\u8c03\\u6362\\u6807\\u51c6\\u5b89\\u7f6e\\u9762\\u79ef\\ufe66\\uff08\\u8bc4\\u4f30\\u8865\\u507f\\u603b\\u4ef7\\uff0b\\u5956\\u52b1\\u8d44\\u91d1\\uff09\\u00f7\\u4ea7\\u6743\\u8c03\\u6362\\u5b89\\u7f6e\\u623f\\u5c4b\\u7684\\u5b89\\u7f6e\\u4ef7\\u3002<\\/li>\\r\\n                <li class=\\\"lineheight50 text_indent50 color66\\\">2.\\u4ea7\\u6743\\u8c03\\u6362\\u5b89\\u7f6e\\u529e\\u6cd5\\u3002\\u4ee5\\u88ab\\u5f81\\u6536\\u4eba\\u4ea7\\u6743\\u8c03\\u6362\\u6807\\u51c6\\u5b89\\u7f6e\\u9762\\u79ef\\u4e3a\\u4f9d\\u636e\\uff0c\\u5728\\u5b9e\\u9645\\u5b89\\u7f6e\\u8fc7\\u7a0b\\u4e2d\\u4ee5\\u53ef\\u4f9b\\u9009\\u62e9\\u7684\\u4ea7\\u6743\\u8c03\\u6362\\u623f\\u5c4b\\u7684\\u5b9e\\u6709\\u9762\\u79ef\\u4e3a\\u6807\\u51c6\\uff0c\\u4e92\\u627e\\u5dee\\u4ef7\\uff1a\\u2460\\u5728\\u4ea7\\u6743\\u8c03\\u6362\\u6807\\u51c6\\u5b89\\u7f6e\\u9762\\u79ef\\u4ee5\\u5185\\u7684\\u90e8\\u5206\\uff0c\\u4ee5\\u4ea7\\u6743\\u8c03\\u6362\\u5b89\\u7f6e\\u623f\\u5c4b\\u7684\\u5b89\\u7f6e\\u4f18\\u60e0\\u4ef7\\u7ed3\\u7b97\\u3002\\u2461\\u8d85\\u51fa\\u4ea7\\u6743\\u8c03\\u6362\\u6807\\u51c6\\u5b89\\u7f6e\\u9762\\u79ef\\u7684\\u90e8\\u5206\\uff0c\\u5728\\u4ea7\\u6743\\u8c03\\u6362\\u5b89\\u7f6e\\u4f18\\u60e0\\u4ef7\\u7684\\u57fa\\u7840\\u4e0a\\u5206\\u522b\\u6309\\u4e0d\\u540c\\u7b49\\u6b21\\u9010\\u6bb5\\u4e0a\\u6d6e\\uff1a<\\/li>\\r\\n            <\\/ul>\\r\\n            <table class=\\\"table_a color66\\\" border=\\\"1\\\" cellspacing=\\\"0\\\" style=\\\"width: 100%;page-break-before: auto;\\\">\\r\\n                <thead>\\r\\n                <tr style=\\\"line-height: 80px;\\\">\\r\\n                    <th style=\\\"line-height: 60px;\\\">\\u6bb5\\u6b21<\\/th>\\r\\n                    <th style=\\\"line-height: 60px;\\\">\\u8d77\\u59cb\\u9762\\u79ef\\uff08\\u4e0d\\u5305\\u542b\\uff09\\uff08\\u33a1\\uff09<\\/th>\\r\\n                    <th style=\\\"line-height: 60px;\\\">\\u622a\\u6b62\\u9762\\u79ef\\uff08\\u5305\\u542b\\uff09\\uff08\\u33a1\\uff09<\\/th>\\r\\n                    <th style=\\\"line-height: 60px;\\\">\\u4e0a\\u6d6e\\u6bd4\\u4f8b\\uff08%\\uff09<\\/th>\\r\\n                <\\/tr>\\r\\n                <\\/thead>\\r\\n                <tbody>\\r\\n                                                                                        <tr>\\r\\n                                <td style=\\\"min-height: 80px;\\\">1<\\/td>\\r\\n                                <td style=\\\"min-height: 80px;\\\">0.00<\\/td>\\r\\n                                <td style=\\\"min-height: 80px;\\\">15.00<\\/td>\\r\\n                                <td style=\\\"min-height: 80px;\\\">10.00<\\/td>\\r\\n                            <\\/tr>\\r\\n                        \\r\\n                                                                        <tr>\\r\\n                                <td style=\\\"min-height: 80px;\\\">2<\\/td>\\r\\n                                <td style=\\\"min-height: 80px;\\\">15.00<\\/td>\\r\\n                                <td style=\\\"min-height: 80px;\\\">25.00<\\/td>\\r\\n                                <td style=\\\"min-height: 80px;\\\">20.00<\\/td>\\r\\n                            <\\/tr>\\r\\n                        \\r\\n                                                                        <tr>\\r\\n                                <td style=\\\"min-height: 80px;\\\">3<\\/td>\\r\\n                                <td style=\\\"min-height: 80px;\\\">25.00<\\/td>\\r\\n                                <td style=\\\"min-height: 80px;\\\">30.00<\\/td>\\r\\n                                <td style=\\\"min-height: 80px;\\\">30.00<\\/td>\\r\\n                            <\\/tr>\\r\\n                        \\r\\n                                                                        <tr>\\r\\n                                <td style=\\\"min-height: 80px;\\\">4<\\/td>\\r\\n                                <td style=\\\"min-height: 80px;\\\">30.00<\\/td>\\r\\n                                <td style=\\\"min-height: 80px;\\\" colspan=\\\"2\\\">\\uff08\\u8d85\\u51fa\\u90e8\\u95e8\\u6309\\u8bc4\\u4f30\\u5e02\\u573a\\u4ef7\\u7ed3\\u7b97\\uff09<\\/td>\\r\\n                            <\\/tr>\\r\\n                        \\r\\n                    \\r\\n                                <\\/tbody>\\r\\n            <\\/table>\\r\\n            <div class=\\\"text_indent50 lineheight50 color66\\\">3.\\u4ea7\\u6743\\u8c03\\u6362\\u623f\\u5c4b\\u53ca\\u4e0a\\u6d6e\\u8ba1\\u7b97\\u660e\\u7ec6\\u3002<\\/div>\\r\\n                        <div class=\\\"text_indent50 lineheight50 color66\\\">\\r\\n                \\u4e59\\u65b9\\u6240\\u5f97\\u8865\\u507f\\u8d44\\u91d1\\u4e4b\\u4e2d\\uff0c\\u53ef\\u8c03\\u6362\\u5b89\\u7f6e\\u623f\\u9762\\u79ef\\u7684\\u8d44\\u91d1 = \\u5408\\u6cd5\\u623f\\u5c4b\\u53ca\\u9644\\u5c5e\\u7269 + \\u5408\\u6cd5\\u4e34\\u5efa + \\u516c\\u5171\\u9644\\u5c5e\\u7269 + \\u7b7e\\u7ea6\\u5956\\u52b1\\uff0c\\u5171\\u8ba1\\uff1a\\r\\n                <div class=\\\"width200 height40 div_border_bot\\\">0.00<\\/div> \\u5143\\r\\n                \\uff08\\u5927\\u5199\\uff1a<div class=\\\"width200 height40 div_border_bot\\\">\\u5706<\\/div>\\uff09\\r\\n            <\\/div>\\r\\n            <table class=\\\"table_a color66\\\" border=\\\"1\\\" cellspacing=\\\"0\\\" style=\\\"width: 100%;page-break-before: auto;\\\">\\r\\n                <thead>\\r\\n                <tr style=\\\"line-height: 80px;\\\">\\r\\n                    <th style=\\\"line-height: 60px;\\\">\\u623f\\u53f7<\\/th>\\r\\n                    <th style=\\\"line-height: 60px;\\\">\\u9762\\u79ef\\uff08\\u33a1\\uff09<\\/th>\\r\\n                    <th style=\\\"line-height: 60px;\\\">\\u5b89\\u7f6e\\u5355\\u4ef7\\uff08\\u5143\\/\\u33a1\\uff09<\\/th>\\r\\n                    <th style=\\\"line-height: 60px;\\\">\\u5b89\\u7f6e\\u603b\\u4ef7\\uff08\\u5143\\uff09<\\/th>\\r\\n                    <th style=\\\"line-height: 60px;\\\">\\u4e0a\\u6d6e\\u9762\\u79ef\\uff08\\u33a1\\uff09<\\/th>\\r\\n                    <th style=\\\"line-height: 60px;\\\">\\u4e0a\\u6d6e\\u623f\\u6b3e\\uff08\\u5143\\uff09<\\/th>\\r\\n                    <th style=\\\"line-height: 60px;\\\">\\u623f\\u5c4b\\u603b\\u4ef7\\uff08\\u5143\\uff09<\\/th>\\r\\n                <\\/tr>\\r\\n                <\\/thead>\\r\\n                <tbody>\\r\\n                                                                                                    <tr>\\r\\n                            <td style=\\\"min-height: 80px;\\\">\\r\\n                                2-\\r\\n                                2-\\r\\n                                2-\\r\\n                                2\\r\\n                            <\\/td>\\r\\n                            <td style=\\\"min-height: 80px;\\\">100.00<\\/td>\\r\\n                            <td style=\\\"min-height: 80px;\\\">5,000.00<\\/td>\\r\\n                            <td style=\\\"min-height: 80px;\\\">500,000.00<\\/td>\\r\\n                            <td style=\\\"min-height: 80px;\\\">400.00<\\/td>\\r\\n                            <td style=\\\"min-height: 80px;\\\">95,000.00<\\/td>\\r\\n                            <td style=\\\"min-height: 80px;\\\">595,000.00<\\/td>\\r\\n                        <\\/tr>\\r\\n                                                    <tr>\\r\\n                                <td colspan=\\\"7\\\">\\r\\n                                    <table class=\\\"table_a color66\\\" border=\\\"1\\\" cellspacing=\\\"0\\\" style=\\\"width: 100%;page-break-before: auto;\\\">\\r\\n                                        <caption>\\u4e0a\\u6d6e\\u623f\\u6b3e\\u8ba1\\u7b97\\u660e\\u7ec6<\\/caption>\\r\\n                                        <thead>\\r\\n                                        <tr>\\r\\n                                            <th>\\u4e0a\\u6d6e\\u9762\\u79ef\\uff08\\u33a1\\uff09<\\/th>\\r\\n                                            <th>\\u8bc4\\u4f30\\u5e02\\u573a\\u4ef7\\uff08\\u5143\\/\\u33a1\\uff09<\\/th>\\r\\n                                            <th>\\u5b89\\u7f6e\\u4f18\\u60e0\\u4ef7\\uff08\\u5143\\/\\u33a1\\uff09<\\/th>\\r\\n                                            <th>\\u4e0a\\u6d6e\\u6bd4\\u4f8b\\uff08%\\uff09<\\/th>\\r\\n                                            <th>\\u4e0a\\u6d6e\\u91d1\\u989d\\uff08\\u5143\\uff09<\\/th>\\r\\n                                        <\\/tr>\\r\\n                                        <\\/thead>\\r\\n                                        <tbody>\\r\\n                                                                                <tr>\\r\\n                                            <td>15.00<\\/td>\\r\\n                                            <td>6,000.00<\\/td>\\r\\n                                            <td>5,000.00<\\/td>\\r\\n                                            <td>10.00<\\/td>\\r\\n                                            <td>7,500.00<\\/td>\\r\\n                                        <\\/tr>\\r\\n                                                                                <tr>\\r\\n                                            <td>10.00<\\/td>\\r\\n                                            <td>6,000.00<\\/td>\\r\\n                                            <td>5,000.00<\\/td>\\r\\n                                            <td>20.00<\\/td>\\r\\n                                            <td>10,000.00<\\/td>\\r\\n                                        <\\/tr>\\r\\n                                                                                <tr>\\r\\n                                            <td>5.00<\\/td>\\r\\n                                            <td>6,000.00<\\/td>\\r\\n                                            <td>5,000.00<\\/td>\\r\\n                                            <td>30.00<\\/td>\\r\\n                                            <td>7,500.00<\\/td>\\r\\n                                        <\\/tr>\\r\\n                                                                                <tr>\\r\\n                                            <td>70.00<\\/td>\\r\\n                                            <td>6,000.00<\\/td>\\r\\n                                            <td>5,000.00<\\/td>\\r\\n                                            <td>0.00<\\/td>\\r\\n                                            <td>70,000.00<\\/td>\\r\\n                                        <\\/tr>\\r\\n                                                                                <tr>\\r\\n                                            <td>15.00<\\/td>\\r\\n                                            <td>6,000.00<\\/td>\\r\\n                                            <td>5,000.00<\\/td>\\r\\n                                            <td>10.00<\\/td>\\r\\n                                            <td>7,500.00<\\/td>\\r\\n                                        <\\/tr>\\r\\n                                                                                <tr>\\r\\n                                            <td>10.00<\\/td>\\r\\n                                            <td>6,000.00<\\/td>\\r\\n                                            <td>5,000.00<\\/td>\\r\\n                                            <td>20.00<\\/td>\\r\\n                                            <td>10,000.00<\\/td>\\r\\n                                        <\\/tr>\\r\\n                                                                                <tr>\\r\\n                                            <td>5.00<\\/td>\\r\\n                                            <td>6,000.00<\\/td>\\r\\n                                            <td>5,000.00<\\/td>\\r\\n                                            <td>30.00<\\/td>\\r\\n                                            <td>7,500.00<\\/td>\\r\\n                                        <\\/tr>\\r\\n                                                                                <tr>\\r\\n                                            <td>70.00<\\/td>\\r\\n                                            <td>6,000.00<\\/td>\\r\\n                                            <td>5,000.00<\\/td>\\r\\n                                            <td>0.00<\\/td>\\r\\n                                            <td>70,000.00<\\/td>\\r\\n                                        <\\/tr>\\r\\n                                                                                <tr>\\r\\n                                            <td>15.00<\\/td>\\r\\n                                            <td>6,000.00<\\/td>\\r\\n                                            <td>5,000.00<\\/td>\\r\\n                                            <td>10.00<\\/td>\\r\\n                                            <td>7,500.00<\\/td>\\r\\n                                        <\\/tr>\\r\\n                                                                                <tr>\\r\\n                                            <td>10.00<\\/td>\\r\\n                                            <td>6,000.00<\\/td>\\r\\n                                            <td>5,000.00<\\/td>\\r\\n                                            <td>20.00<\\/td>\\r\\n                                            <td>10,000.00<\\/td>\\r\\n                                        <\\/tr>\\r\\n                                                                                <tr>\\r\\n                                            <td>5.00<\\/td>\\r\\n                                            <td>6,000.00<\\/td>\\r\\n                                            <td>5,000.00<\\/td>\\r\\n                                            <td>30.00<\\/td>\\r\\n                                            <td>7,500.00<\\/td>\\r\\n                                        <\\/tr>\\r\\n                                                                                <tr>\\r\\n                                            <td>70.00<\\/td>\\r\\n                                            <td>6,000.00<\\/td>\\r\\n                                            <td>5,000.00<\\/td>\\r\\n                                            <td>0.00<\\/td>\\r\\n                                            <td>70,000.00<\\/td>\\r\\n                                        <\\/tr>\\r\\n                                                                                <tr>\\r\\n                                            <td>15.00<\\/td>\\r\\n                                            <td>6,000.00<\\/td>\\r\\n                                            <td>5,000.00<\\/td>\\r\\n                                            <td>10.00<\\/td>\\r\\n                                            <td>7,500.00<\\/td>\\r\\n                                        <\\/tr>\\r\\n                                                                                <tr>\\r\\n                                            <td>10.00<\\/td>\\r\\n                                            <td>6,000.00<\\/td>\\r\\n                                            <td>5,000.00<\\/td>\\r\\n                                            <td>20.00<\\/td>\\r\\n                                            <td>10,000.00<\\/td>\\r\\n                                        <\\/tr>\\r\\n                                                                                <tr>\\r\\n                                            <td>5.00<\\/td>\\r\\n                                            <td>6,000.00<\\/td>\\r\\n                                            <td>5,000.00<\\/td>\\r\\n                                            <td>30.00<\\/td>\\r\\n                                            <td>7,500.00<\\/td>\\r\\n                                        <\\/tr>\\r\\n                                                                                <tr>\\r\\n                                            <td>70.00<\\/td>\\r\\n                                            <td>6,000.00<\\/td>\\r\\n                                            <td>5,000.00<\\/td>\\r\\n                                            <td>0.00<\\/td>\\r\\n                                            <td>70,000.00<\\/td>\\r\\n                                        <\\/tr>\\r\\n                                                                                <\\/tbody>\\r\\n                                    <\\/table>\\r\\n                                <\\/td>\\r\\n                            <\\/tr>\\r\\n                                            \\r\\n                                <\\/tbody>\\r\\n            <\\/table>\\r\\n                <div class=\\\"text_indent50 lineheight50 color66\\\">\\r\\n                    \\u7efc\\u5408\\u4ee5\\u4e0a\\u7edf\\u8ba1\\uff0c\\u4e59\\u65b9\\u987b\\u4ea4\\u7eb3\\u623f\\u6b3e\\u5171\\u8ba1\\r\\n                    <div class=\\\"width200 height40 div_border_bot\\\">595,000.00<\\/div> \\u5143\\r\\n                    \\uff08\\u5927\\u5199\\uff1a<div class=\\\"width200 height40 div_border_bot\\\">\\u4f0d\\u62fe\\u7396\\u4e07\\u4f0d\\u4edf\\u5706<\\/div>\\uff09\\u3002\\r\\n                                        \\u4e0a\\u8ff0\\u623f\\u6b3e\\u548c\\u4e0a\\u6d6e\\u6b3e\\u5728\\u4e59\\u65b9\\u5e94\\u5f97\\u8865\\u507f\\u8d44\\u91d1\\u4e2d\\u76f4\\u63a5\\u62b5\\u6263\\uff0c\\u62b5\\u6263\\u540e\\r\\n                                            \\u4e59\\u65b9\\u987b\\u5411\\u7532\\u65b9\\u8865\\u4ea4\\r\\n                        <div class=\\\"width200 height40 div_border_bot\\\">595,000.00<\\/div> \\u5143\\r\\n                        \\uff08\\u5927\\u5199\\uff1a<div class=\\\"width200 height40 div_border_bot\\\">\\u4f0d\\u62fe\\u7396\\u4e07\\u4f0d\\u4edf\\u5706<\\/div>\\uff09\\u3002\\r\\n                                    <\\/div>\\r\\n                    <\\/div>\\r\\n        <!--\\u4e59\\u65b9\\u5185\\u5bb9-->\\r\\n        <div>\\r\\n            <h3 style=\\\"text-indent: 50px;line-height: 50px;\\\"> \\u4e94\\u3001\\u4e59\\u65b9\\u7684\\u4fdd\\u8bc1<\\/h3>\\r\\n            <ul>\\r\\n                <li class=\\\"lineheight50 text_indent50 color66\\\">1.\\u5411\\u7532\\u65b9\\u63d0\\u4f9b\\u7684\\u6240\\u6709\\u4ea7\\u6743\\u4e66\\u8bc1\\u6750\\u6599\\u53ca\\u5176\\u4ed6\\u76f8\\u5173\\u8bc1\\u660e\\u6750\\u6599\\uff0c\\u5747\\u5c5e\\u5ba2\\u89c2\\u3001\\u771f\\u5b9e\\uff0c\\u5426\\u5219\\uff0c\\u4e59\\u65b9\\u613f\\u627f\\u62c5\\u4e00\\u5207\\u6cd5\\u5f8b\\u8d23\\u4efb\\u3002<\\/li>\\r\\n                <li class=\\\"lineheight50 text_indent50 color66\\\">2.\\u4e0d\\u9690\\u7792\\u88ab\\u5f81\\u6536\\u623f\\u5c4b\\u7684\\u4ea7\\u6743\\u7ea0\\u7eb7\\u6216\\u62b5\\u62bc\\u62c5\\u4fdd\\u7b49\\u72b6\\u51b5\\uff0c\\u9690\\u7792\\u6216\\u63d0\\u4f9b\\u6750\\u6599\\u4e0d\\u5b9e\\u4ea7\\u751f\\u7684\\u6cd5\\u5f8b\\u8d23\\u4efb\\u7531\\u4e59\\u65b9\\u627f\\u62c5\\u3002<\\/li>\\r\\n            <\\/ul>\\r\\n        <\\/div>\\r\\n        <div>\\r\\n            <h3 style=\\\"text-indent: 50px;line-height: 50px;\\\"> \\u516d\\u3001\\u8fdd\\u7ea6\\u8d23\\u4efb<\\/h3>\\r\\n            <div class=\\\"lineheight50 text_indent50 color66\\\">\\u672c\\u534f\\u8bae\\u751f\\u6548\\u540e\\uff0c\\u53cc\\u65b9\\u5e94\\u5171\\u540c\\u9075\\u5b88\\uff0c\\u5982\\u6709\\u4e00\\u65b9\\u8fdd\\u7ea6\\u6216\\u9020\\u6210\\u5bf9\\u65b9\\u635f\\u5931\\u8005\\uff0c\\u5fc5\\u987b\\u8d54\\u507f\\u635f\\u5931\\u548c\\u627f\\u62c5\\u8fdd\\u7ea6\\u8d23\\u4efb\\u3002<\\/div>\\r\\n            <ul>\\r\\n                <li class=\\\"lineheight50 text_indent50 color66\\\">\\r\\n                    1.\\u56e0\\u7532\\u65b9\\u7684\\u539f\\u56e0\\uff08\\u4e0d\\u53ef\\u6297\\u62d2\\u56e0\\u7d20\\u9664\\u5916\\uff09\\u672a\\u6309\\u534f\\u8bae\\u7ea6\\u5b9a\\u5411\\u4e59\\u65b9\\u652f\\u4ed8\\u5f81\\u6536\\u8865\\u507f\\u6b3e\\u7684\\uff0c\\u7532\\u65b9\\u5e94\\u5f53\\u627f\\u62c5\\u903e\\u671f\\u652f\\u4ed8\\u7684\\u6c11\\u4e8b\\u8d23\\u4efb\\uff0c\\u6309\\u672a\\u652f\\u4ed8\\u91d1\\u989d\\u6bcf\\u65e5\\u4e07\\u5206\\u4e4b<div class=\\\"width100 height40 div_border_bot \\\">\\u4e09<\\/div>\\u7684\\u6bd4\\u4f8b\\u652f\\u4ed8\\u8fdd\\u7ea6\\u91d1\\u3002\\r\\n                <\\/li>\\r\\n                <li class=\\\"lineheight50 text_indent50 color66\\\">2.\\u4e59\\u65b9\\u672a\\u6309\\u671f\\u5411\\u7532\\u65b9\\u7f34\\u7eb3\\uff08\\u7ed3\\u6e05\\uff09\\u4ea7\\u6743\\u8c03\\u6362\\u623f\\u5c4b\\u5dee\\u4ef7\\u6216\\u672a\\u5728\\u7ea6\\u5b9a\\u7684\\u671f\\u9650\\u5185\\u5b8c\\u6210\\u642c\\u8fc1\\u5e76\\u79fb\\u4ea4\\u623f\\u5c4b\\u53ca\\u623f\\u5c4b\\u6743\\u5c5e\\u8bc1\\u7b49\\uff0c\\u4e59\\u65b9\\u5e94\\u5f53\\u627f\\u62c5\\u8fdd\\u7ea6\\u8d23\\u4efb\\uff0c\\u7532\\u65b9\\u6709\\u6743\\u5728\\u4e59\\u65b9\\u7684\\u5f81\\u6536\\u8865\\u507f\\u6240\\u5f97\\u4e2d\\u6309\\u7167\\u6bcf\\u65e5\\u4e07\\u5206\\u4e4b<div class=\\\"div_border_bot height40 width100\\\">\\u4e09<\\/div>\\u7684\\u6bd4\\u4f8b\\u6263\\u9664\\u3002\\r\\n                <\\/li>\\r\\n            <\\/ul>\\r\\n        <\\/div>\\r\\n        <div>\\r\\n            <h3 style=\\\"text-indent: 50px;line-height: 50px;\\\"> \\u4e03\\u3001\\u5176\\u5b83\\u6761\\u6b3e<\\/h3>\\r\\n            <ul>\\r\\n                <li class=\\\"lineheight50 text_indent50 color66\\\">\\u81ea\\u672c\\u534f\\u8bae\\u7b7e\\u8ba2\\u540e\\uff0c\\u4e59\\u65b9\\u987b\\u5728 <div class=\\\"div_border_bot height40 width100\\\">15\\u65e5<\\/div>\\u5185\\u5c06\\u88ab\\u5f81\\u6536\\u623f\\u5c4b\\u53ca\\u5b85\\u9662\\u5185\\u7684\\u8d22\\u7269\\u642c\\u51fa\\uff0c\\u5e76\\u53ca\\u65f6\\u5c06\\u6240\\u6709\\u7684\\u5efa\\u7b51\\u7269\\u3001\\u6784\\u7b51\\u7269\\u53ca\\u5730\\u4e0a\\u9644\\u7740\\u7269\\u79fb\\u4ea4\\u7ed9\\u7532\\u65b9\\uff0c\\u4e59\\u65b9\\u4e0d\\u5f97\\u64c5\\u81ea\\u62c6\\u9664\\u3002\\u5982\\u4e59\\u65b9\\u64c5\\u81ea\\u62c6\\u9664\\uff0c\\u7532\\u65b9\\u6709\\u6743\\u4ece\\u4e59\\u65b9\\u8865\\u507f\\u6b3e\\u4e2d\\u4f5c\\u4ef7\\u6263\\u9664\\uff0c\\u5e76\\u7531\\u4e59\\u65b9\\u81ea\\u884c\\u627f\\u62c5\\u64c5\\u81ea\\u62c6\\u9664\\u9020\\u6210\\u7684\\u4e00\\u5207\\u540e\\u679c\\uff1a\\u7ea0\\u7eb7\\u3001\\u8fdd\\u7ea6\\u3001\\u5b89\\u5168\\u95ee\\u9898\\u7b49\\u3002<\\/li>\\r\\n                <li class=\\\"lineheight50 text_indent50 color66\\\">2.\\u4e59\\u65b9\\u642c\\u8fc1\\u7ed3\\u675f\\u540e\\uff0c\\u7ecf\\u7532\\u65b9\\u9a8c\\u6536\\u5408\\u683c\\uff0c\\u4e00\\u6b21\\u6027\\u5411\\u4e59\\u65b9\\u5151\\u4ed8\\u5f81\\u6536\\u8865\\u507f\\u8d44\\u91d1\\u3002<\\/li>\\r\\n                <li class=\\\"lineheight50 text_indent50 color66\\\">3.\\u88ab\\u5f81\\u6536\\u623f\\u5c4b\\u4ea4\\u4ed8\\u524d\\u4ea7\\u751f\\u7684\\u6c34\\u8d39\\u3001\\u7535\\u8d39\\u3001\\u7269\\u4e1a\\u8d39\\u3001\\u7535\\u8bdd\\u8d39\\u3001\\u6709\\u7ebf\\u7535\\u89c6\\u8d39\\u7b49\\u76f8\\u5173\\u8d39\\u7528\\u7531\\u4e59\\u65b9\\u81ea\\u884c\\u627f\\u62c5\\uff0c\\u5e76\\u8d1f\\u8d23\\u7ed3\\u6e05\\u6240\\u4ea7\\u751f\\u7684\\u76f8\\u5173\\u8d39\\u7528\\u3002<\\/li>\\r\\n                <li class=\\\"lineheight50 text_indent50 color66\\\">4.\\u672c\\u534f\\u8bae\\u7b7e\\u8ba2\\u4e4b\\u65e5\\uff0c\\u4e59\\u65b9\\u987b\\u5c06\\u88ab\\u5f81\\u6536\\u623f\\u5c4b\\u4ea7\\u6743\\u8bc1\\u539f\\u4ef6\\u7b49\\u76f8\\u5173\\u8bc1\\u660e\\u6750\\u6599\\u4ea4\\u4ed8\\u7ed9\\u7532\\u65b9\\uff0c\\u7531\\u7532\\u65b9\\u7edf\\u4e00\\u5230\\u623f\\u5c4b\\u767b\\u8bb0\\u7b49\\u90e8\\u95e8\\u529e\\u7406\\u623f\\u5c4b\\u4ea7\\u6743\\u8bc1\\u7684\\u767b\\u8bb0\\u6ce8\\u9500\\u624b\\u7eed\\u3002\\u5982\\u4e59\\u65b9\\u4e0d\\u53ca\\u65f6\\u4ea4\\u4ed8\\u6216\\u62d2\\u7edd\\u4ea4\\u4ed8\\uff0c\\u9020\\u6210\\u540e\\u7eed\\u4ea7\\u6743\\u65e0\\u6cd5\\u529e\\u7406\\u6216\\u4ea7\\u751f\\u7684\\u4e00\\u5207\\u8d23\\u4efb\\uff0c\\u5747\\u7531\\u4e59\\u65b9\\u81ea\\u884c\\u627f\\u62c5\\u3002<\\/li>\\r\\n                <li class=\\\"lineheight50 text_indent50 color66\\\">5.\\u623f\\u6b3e\\u7684\\u4ea4\\u7eb3\\u53ca\\u5b89\\u7f6e\\u623f\\u5c4b\\u5165\\u4f4f\\u624b\\u7eed\\u7684\\u529e\\u7406\\u3002\\u7532\\u4e59\\u53cc\\u65b9\\u7ed3\\u6e05\\u4ee5\\u4e0a\\u5404\\u9879\\u8d39\\u7528\\u540e\\uff0c\\u7532\\u65b9\\u4e3a\\u4e59\\u65b9\\u51fa\\u5177\\u76f8\\u5173\\u5165\\u4f4f\\u8bc1\\u660e\\uff0c\\u5e76\\u534f\\u52a9\\u4e59\\u65b9\\u529e\\u7406\\u6709\\u5173\\u5165\\u4f4f\\u624b\\u7eed\\u3002<\\/li>\\r\\n            <\\/ul>\\r\\n        <\\/div>\\r\\n        <div>\\r\\n            <h3 style=\\\"text-indent: 50px;line-height: 50px;\\\"> \\u516b\\u3001\\u4e89\\u8bae\\u7684\\u5904\\u7406<\\/h3>\\r\\n            <div class=\\\"lineheight50 text_indent50 color66\\\">\\u672c\\u534f\\u8bae\\u5728\\u5c65\\u884c\\u8fc7\\u7a0b\\u4e2d\\u5982\\u53d1\\u751f\\u4e89\\u8bae\\uff0c\\u53cc\\u65b9\\u5e94\\u5148\\u884c\\u534f\\u5546\\u89e3\\u51b3\\uff0c\\u534f\\u5546\\u4e0d\\u6210\\uff0c\\u53ef\\u5411\\u6709\\u7ba1\\u8f96\\u6743\\u7684\\u4eba\\u6c11\\u6cd5\\u9662\\u63d0\\u8d77\\u8bc9\\u8bbc\\u3002<\\/div>\\r\\n        <\\/div>\\r\\n        <div>\\r\\n            <h3 style=\\\"text-indent: 50px;line-height: 50px;\\\">\\u4e5d\\u3001\\u534f\\u8bae\\u751f\\u6548\\u53ca\\u6301\\u6709<\\/h3>\\r\\n            <div class=\\\"lineheight50 text_indent50 color66\\\">\\u672c\\u534f\\u8bae\\u81ea\\u7532\\u4e59\\u53cc\\u65b9\\u7b7e\\u8ba2\\u4e4b\\u65e5\\u8d77\\u751f\\u6548\\u3002\\u672c\\u534f\\u8bae\\u4e00\\u5f0f\\u516d\\u4efd\\uff0c\\u7532\\u65b9\\u6267\\u4e94\\u4efd\\uff0c\\u4e59\\u65b9\\u6267\\u4e00\\u4efd\\uff0c\\u5177\\u6709\\u540c\\u7b49\\u6cd5\\u5f8b\\u6548\\u529b\\u3002<\\/div>\\r\\n        <\\/div>\\r\\n        <div>\\r\\n            <h3 style=\\\"text-indent: 50px;line-height: 50px;\\\"> \\u5341\\u3001\\u672a\\u5c3d\\u4e8b\\u5b9c<\\/h3>\\r\\n            <div class=\\\"lineheight50 text_indent50 color66\\\">\\u672c\\u534f\\u8bae\\u672a\\u5c3d\\u4e8b\\u5b9c\\u6309\\u7167\\u56fd\\u6709\\u571f\\u5730\\u4e0a\\u623f\\u5c4b\\u5f81\\u6536\\u76f8\\u5173\\u6cd5\\u5f8b\\u6cd5\\u89c4\\u6267\\u884c\\uff0c\\u672a\\u4f5c\\u51fa\\u660e\\u786e\\u89c4\\u5b9a\\u7684\\uff0c\\u7531\\u7532\\u3001\\u4e59\\u53cc\\u65b9\\u53e6\\u884c\\u534f\\u5546\\u540e\\u7b7e\\u8ba2\\u8865\\u5145\\u534f\\u8bae\\uff0c\\u8865\\u5145\\u534f\\u8bae\\u4e0e\\u672c\\u534f\\u8bae\\u5177\\u6709\\u540c\\u7b49\\u6cd5\\u5f8b\\u6548\\u529b\\u3002<\\/div>\\r\\n        <\\/div>\\r\\n        <div>\\r\\n            <h3 style=\\\"text-indent: 50px;line-height: 50px;\\\"> \\u5341\\u4e00\\u3001\\u7f34\\u6b3e\\u8d26\\u53f7<\\/h3>\\r\\n            <div class=\\\"lineheight50 text_indent50 color66\\\">\\u6237&nbsp;&nbsp;&nbsp;&nbsp;\\u540d\\uff1a\\u5929\\u6c34\\u5e02\\u79e6\\u5dde\\u533a\\u623f\\u5c4b\\u5f81\\u6536\\u8865\\u507f\\u7ba1\\u7406\\u5c40<\\/div>\\r\\n            <div class=\\\"lineheight50 text_indent50 color66\\\">\\u5f00\\u6237\\u884c\\uff1a\\u5170\\u5dde\\u94f6\\u884c\\u5929\\u6c34\\u5206\\u884c\\u8425\\u4e1a\\u90e8<\\/div>\\r\\n            <div class=\\\"lineheight50 text_indent50 color66\\\">\\u8d26&nbsp;&nbsp;&nbsp;&nbsp;\\u53f7\\uff1a101822000392832<\\/div>\\r\\n        <\\/div>\\r\\n        <div style=\\\"margin-top: 100px;\\\">\\r\\n            <div class=\\\"lineheight50 text_indent50 color66\\\">\\u9644\\u4ef6\\uff1a1.\\u623f\\u5c4b\\u5f81\\u6536\\u8865\\u507f\\u5151\\u4ed8\\u8868<\\/div>\\r\\n            <div class=\\\"lineheight50 text_indent50 color66\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.\\u623f\\u5730\\u4ea7\\u4ef7\\u683c\\u8bc4\\u4f30\\u5206\\u6237\\u8868<\\/div>\\r\\n                        <div class=\\\"lineheight50 text_indent50 color66\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.\\u8d44\\u4ea7\\u8bc4\\u4f30\\u62a5\\u544a<\\/div>\\r\\n                    <\\/div>\\r\\n    <\\/div>\\r\\n<\\/div>\\r\\n<!--\\u6ee1\\u4e00\\u9875\\u7684-->\\r\\n<div class=\\\"wrap ov\\\" style=\\\"height: 1158px;background: tan;\\\">\\r\\n    <div class=\\\"ov\\\" style=\\\"width: 50%;margin-left: 5%; float: left;height: 160px;line-height: 160px;\\\">\\u7532&nbsp;&nbsp;&nbsp;&nbsp;\\u65b9\\uff08\\u76d6\\u7ae0\\uff09\\uff1a<\\/div>\\r\\n    <div class=\\\"ov\\\" style=\\\"width: 45%; float: left;height: 160px;line-height: 160px;\\\">\\u7532&nbsp;&nbsp;&nbsp;&nbsp;\\u65b9\\uff08\\u76d6\\u7ae0\\uff09\\uff1a<\\/div>\\r\\n    <div class=\\\"ov\\\" style=\\\"width: 50%;margin-left: 5%; float: left;height: 160px;line-height: 160px;\\\">\\u6cd5\\u5b9a\\u4ee3\\u8868\\u4eba\\uff08\\u7b7e\\u5b57\\uff09\\uff1a<\\/div>\\r\\n    <div class=\\\"ov\\\" style=\\\"width: 45%; float: left;height: 160px;line-height: 160px;\\\">\\u4e59\\u65b9\\u4ee3\\u8868\\uff08\\u7b7e\\u5b57\\uff09\\uff1a<\\/div>\\r\\n    <div class=\\\"ov\\\" style=\\\"width: 100%;margin-left: 5%; height: 160px;line-height: 160px;\\\">\\u5206\\u7ba1\\u9886\\u5bfc\\uff08\\u7b7e\\u5b57\\uff09\\uff1a<\\/div>\\r\\n    <div class=\\\"ov\\\" style=\\\"width: 50%;margin-left: 5%; float: left;height: 160px;line-height: 160px;\\\">\\u7ecf \\u529e \\u4eba\\uff08\\u7b7e\\u5b57\\uff09\\uff1a<\\/div>\\r\\n    <div class=\\\"ov\\\" style=\\\"width: 45%; float: left;height: 160px;line-height: 160px;\\\">\\u53d7 \\u59d4 \\u6258 \\u4eba\\uff08\\u7b7e\\u5b57\\uff09\\uff1a<\\/div>\\r\\n    <div class=\\\"ov\\\" style=\\\"width: 50%;margin-left: 5%; float: left;height: 160px;line-height: 160px;\\\">\\r\\n        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\u5e74&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\u6708&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\u65e5\\r\\n    <\\/div>\\r\\n    <div class=\\\"ov\\\" style=\\\"width: 45%; float: left;height: 160px;line-height: 160px;\\\">\\r\\n        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\u5e74&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\u6708&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\u65e5\\r\\n    <\\/div>\\r\\n<\\/div>\\r\\n\\r\\n<\\/body>\\r\\n\\r\\n<\\/html>\\r\\n<script src=\\\"http:\\/\\/127.0.0.1:8008\\/js\\/jquery-1.11.3.min.js\\\"><\\/script>\\r\\n<script type=\\\"text\\/javascript\\\">\\r\\n    var height_a = 1158;\\r\\n    var content_obj=$(\\\".content\\\");\\r\\n    for(var i = 0; i < content_obj.length; i++) {\\r\\n        var num_a = Math.ceil(content_obj.eq(i).height() \\/ height_a);\\r\\n        content_obj.eq(i).css(\\\"height\\\", height_a * num_a + \\\"px\\\");\\r\\n    }\\r\\n<\\/script>\",\"pay_table\":\"<!DOCTYPE html>\\r\\n<html>\\r\\n\\r\\n<head>\\r\\n    <meta charset=\\\"UTF-8\\\">\\r\\n    <title><\\/title>\\r\\n<\\/head>\\r\\n<style>\\r\\n    * {\\r\\n        margin: 0;\\r\\n        padding: 0;\\r\\n    }\\r\\n<\\/style>\\r\\n\\r\\n<body style=\\\"position: relative;\\\">\\r\\n<!--2480*3508-->\\r\\n<div id=\\\"one-a4\\\" style=\\\"width: 1000px;min-height:1158px;margin: auto;text-align: center;\\\">\\r\\n    <h2>\\u897f\\u5173\\u7247\\u533a\\u68da\\u6237\\u533a\\u6539\\u9020\\u9879\\u76ee \\u623f\\u5c4b\\u5f81\\u6536\\u8865\\u507f\\u6b3e\\u5151\\u4ed8\\u5230\\u6237\\u8868<\\/h2>\\r\\n    <div class=\\\"title\\\" style=\\\"width: 1000px;display: inline-block;height: auto;margin-top: 20px;\\\">\\r\\n        <p style=\\\"float: left;\\\">\\u6cf0\\u5dde\\u533a\\u623f\\u5c4b\\u5f81\\u6536\\u8865\\u507f\\u7ba1\\u7406\\u5c40<\\/p>\\r\\n        <p style=\\\"float: right;\\\">2018\\u5e7404\\u670801\\u65e5<\\/p>\\r\\n    <\\/div>\\r\\n    <div id=\\\"title\\\" style=\\\"display: block;width: 1000px;height: auto;margin-top: 20px;\\\">\\r\\n        <table border=\\\"1\\\" cellspacing=\\\"0\\\" style=\\\"width: 100%;line-height: 32px;\\\" id=\\\"old-table\\\">\\r\\n            <thead>\\r\\n            <tr>\\r\\n                <th colspan=\\\"2\\\">\\u88ab\\u5f81\\u6536\\u4eba<\\/th>\\r\\n                <th colspan=\\\"2\\\">\\u5f20\\u4e00<\\/th>\\r\\n                <th>\\u8eab\\u4efd\\u8bc1\\u53f7<\\/th>\\r\\n                <th colspan=\\\"3\\\">123456789<\\/th>\\r\\n            <\\/tr>\\r\\n            <\\/thead>\\r\\n            <tbody>\\r\\n                                                            <td rowspan=\\\"2\\\" id=\\\"one-ele\\\">\\r\\n                        1.\\u5408\\u6cd5\\u623f\\u5c4b\\u53ca\\u9644\\u5c5e\\u7269\\r\\n                    <\\/td>\\r\\n                    <td>\\u623f\\u5c4b\\u7c7b\\u578b<\\/td>\\r\\n                    <td>\\u623f\\u5c4b\\u7ed3\\u6784<\\/td>\\r\\n                    <td>\\u9762\\u79ef\\uff08\\u33a1\\uff09<\\/td>\\r\\n                    <td>\\u8bc4\\u4f30\\u5355\\u4ef7\\uff08\\u5143\\/\\u33a1\\uff09<\\/td>\\r\\n                    <td>\\u8bc4\\u4f30\\u603b\\u4ef7\\uff08\\u5143\\uff09<\\/td>\\r\\n                    <td>\\u8865\\u507f\\u91d1\\u989d\\uff08\\u5143\\uff09<\\/td>\\r\\n                    <td>\\u8865\\u507f\\u5c0f\\u8ba1 \\uff08\\u5143\\uff09<\\/td>\\r\\n                                            <tr>\\r\\n                            <td>\\u4f4f\\u5b85<\\/td>\\r\\n                            <td>\\u7816\\u6df7<\\/td>\\r\\n                            <td>120.00<\\/td>\\r\\n                            <td>10.00<\\/td>\\r\\n                            <td>1,200.00<\\/td>\\r\\n                            <td>\\r\\n                                                                    1,200.00\\r\\n                                                            <\\/td>\\r\\n                                                        <td rowspan=\\\"1\\\">\\r\\n                                                                0.00\\r\\n                            <\\/td>\\r\\n                                                    <\\/tr>\\r\\n                                                        \\r\\n                                                <tr class=\\\"one-big-title\\\">\\r\\n                        <td rowspan=\\\"3\\\">\\r\\n                            2.\\u516c\\u5171\\u9644\\u5c5e\\u7269\\r\\n                        <\\/td>\\r\\n                        <td>\\u540d\\u79f0<\\/td>\\r\\n                        <td>\\u8ba1\\u91cf<\\/td>\\r\\n                        <td>\\u8865\\u507f\\u5355\\u4ef7<\\/td>\\r\\n                        <td>\\u8865\\u507f\\u603b\\u4ef7\\uff08\\u5143\\uff09<\\/td>\\r\\n                        <td>\\u5e73\\u5206\\u6237\\u6570<\\/td>\\r\\n                        <td>\\u6bcf\\u6237\\u8865\\u507f\\uff08\\u5143\\uff09<\\/td>\\r\\n                        <td>\\u8865\\u507f\\u5c0f\\u8ba1\\uff08\\u5143\\uff09<\\/td>\\r\\n                    <\\/tr>\\r\\n                                            <tr>\\r\\n                            <td>\\u7816<\\/td>\\r\\n                            <td>50.00\\u5757<\\/td>\\r\\n                            <td>111.00<\\/td>\\r\\n                            <td>5,550.00<\\/td>\\r\\n                            <td>1<\\/td>\\r\\n                            <td>5,550.00<\\/td>\\r\\n                                                            <td rowspan=\\\"2\\\">\\r\\n                                                                        0.00\\r\\n                                <\\/td>\\r\\n                                                    <\\/tr>\\r\\n                                            <tr>\\r\\n                            <td>\\u5927\\u95e8<\\/td>\\r\\n                            <td>2.00\\u6247<\\/td>\\r\\n                            <td>1,212.00<\\/td>\\r\\n                            <td>2,424.00<\\/td>\\r\\n                            <td>3<\\/td>\\r\\n                            <td>808.00<\\/td>\\r\\n                                                    <\\/tr>\\r\\n                                                        \\r\\n                                                <tr class=\\\"one-big-title\\\">\\r\\n                        <td rowspan=\\\"5\\\">\\r\\n                            3.\\u5176\\u4ed6\\u8865\\u507f\\u4e8b\\u9879\\r\\n                        <\\/td>\\r\\n                        <td>\\u540d\\u79f0<\\/td>\\r\\n                        <td>\\u8ba1\\u91cf\\u5355\\u4f4d<\\/td>\\r\\n                        <td>\\u6570\\u91cf<\\/td>\\r\\n                        <td>\\u8865\\u507f\\u5355\\u4ef7<\\/td>\\r\\n                        <td>\\u8865\\u507f\\u603b\\u4ef7\\uff08\\u5143\\uff09<\\/td>\\r\\n                        <td colspan=\\\"2\\\">\\u8865\\u507f\\u5c0f\\u8ba1\\uff08\\u5143\\uff09<\\/td>\\r\\n                    <\\/tr>\\r\\n                                            <tr>\\r\\n                            <td>\\u5bbd\\u5e26<\\/td>\\r\\n                            <td>\\u6237<\\/td>\\r\\n                            <td>200.00<\\/td>\\r\\n                            <td>2.00<\\/td>\\r\\n                            <td>400.00<\\/td>\\r\\n                                                            <td rowspan=\\\"4\\\" colspan=\\\"2\\\">\\r\\n                                                                        0.00\\r\\n                                <\\/td>\\r\\n                                                    <\\/tr>\\r\\n                                            <tr>\\r\\n                            <td>\\u5bbd\\u5e26<\\/td>\\r\\n                            <td>\\u6237<\\/td>\\r\\n                            <td>200.00<\\/td>\\r\\n                            <td>2.00<\\/td>\\r\\n                            <td>400.00<\\/td>\\r\\n                                                    <\\/tr>\\r\\n                                            <tr>\\r\\n                            <td>\\u5bbd\\u5e26<\\/td>\\r\\n                            <td>\\u6237<\\/td>\\r\\n                            <td>200.00<\\/td>\\r\\n                            <td>2.00<\\/td>\\r\\n                            <td>400.00<\\/td>\\r\\n                                                    <\\/tr>\\r\\n                                            <tr>\\r\\n                            <td>\\u5bbd\\u5e26<\\/td>\\r\\n                            <td>\\u6237<\\/td>\\r\\n                            <td>200.00<\\/td>\\r\\n                            <td>2.00<\\/td>\\r\\n                            <td>400.00<\\/td>\\r\\n                                                    <\\/tr>\\r\\n                                                        \\r\\n                                                                                        <tr class=\\\"one-big-title\\\">\\r\\n                        <td>4.\\u56fa\\u5b9a\\u8d44\\u4ea7<\\/td>\\r\\n                        <td colspan=\\\"2\\\">\\u8865\\u507f\\u91d1\\u989d\\uff08\\u5143\\uff09<\\/td>\\r\\n                        <td colspan=\\\"5\\\">0.00<\\/td>\\r\\n                    <\\/tr>\\r\\n                                    \\r\\n                                                <tr class=\\\"one-big-title\\\">\\r\\n                        <td rowspan=\\\"2\\\">\\r\\n                            5.\\u7b7e\\u7ea6\\u5956\\u52b1\\uff08\\u4f4f\\u5b85\\uff09\\r\\n                        <\\/td>\\r\\n                        <td colspan=\\\"1\\\">\\u5408\\u6cd5\\u9762\\u79ef\\uff08\\u33a1\\uff09<\\/td>\\r\\n                        <td colspan=\\\"1\\\">\\u5956\\u52b1\\u5355\\u4ef7\\uff08\\u5143\\/\\u33a1\\uff09<\\/td>\\r\\n                        <td colspan=\\\"2\\\">\\u5956\\u52b1\\u91d1\\u989d\\uff08\\u5143\\uff09<\\/td>\\r\\n                        <td colspan=\\\"3\\\">\\u5956\\u52b1\\u5c0f\\u8ba1\\uff08\\u5143\\uff09<\\/td>\\r\\n                    <\\/tr>\\r\\n                    <tr>\\r\\n                        <td colspan=\\\"1\\\">120.00<\\/td>\\r\\n                        <td colspan=\\\"1\\\">800.00<\\/td>\\r\\n                        <td colspan=\\\"2\\\">0.00<\\/td>\\r\\n                        <td colspan=\\\"3\\\">0.00<\\/td>\\r\\n                    <\\/tr>\\r\\n                                                        \\r\\n            \\r\\n            <tr class=\\\"one-big-title\\\">\\r\\n                <td colspan=\\\"2\\\">\\u4ee5\\u4e0a\\u8865\\u507f\\u603b\\u4ef7\\uff08\\u5143\\uff09<\\/td>\\r\\n                <td colspan=\\\"2\\\">\\r\\n                                        0.00\\r\\n                <\\/td>\\r\\n                <td colspan=\\\"4\\\">\\u5927\\u5199\\uff1a\\u5706<\\/td>\\r\\n            <\\/tr>\\r\\n                            <tr>\\r\\n                    <td colspan=\\\"2\\\">\\u5176\\u4e2d\\u53ef\\u4ea7\\u6743\\u8c03\\u6362\\u603b\\u4ef7\\uff1a<\\/td>\\r\\n                    <td colspan=\\\"2\\\">0.00<\\/td>\\r\\n                    <td colspan=\\\"4\\\">\\u5927\\u5199\\uff1a\\u5706<\\/td>\\r\\n                <\\/tr>\\r\\n\\r\\n                <tr>\\r\\n                    <td rowspan=\\\"2\\\">\\u5b89\\u7f6e\\u623f<\\/td>\\r\\n                    <td>\\u623f\\u53f7<\\/td>\\r\\n                    <td>\\u9762\\u79ef\\uff08\\u33a1\\uff09<\\/td>\\r\\n                    <td>\\u5b89\\u7f6e\\u5355\\u4ef7\\uff08\\u5143\\/\\u33a1\\uff09<\\/td>\\r\\n                    <td>\\u5b89\\u7f6e\\u603b\\u4ef7\\uff08\\u5143\\uff09<\\/td>\\r\\n                    <td>\\u4e0a\\u6d6e\\u9762\\u79ef\\uff08\\u33a1\\uff09<\\/td>\\r\\n                    <td>\\u4e0a\\u6d6e\\u623f\\u6b3e\\uff08\\u5143\\uff09<\\/td>\\r\\n                    <td>\\u623f\\u5c4b\\u603b\\u4ef7\\uff08\\u5143\\uff09<\\/td>\\r\\n                <\\/tr>\\r\\n                                                                        <tr>\\r\\n                        <td>2<\\/td>\\r\\n                        <td>100.00<\\/td>\\r\\n                        <td>5,000.00<\\/td>\\r\\n                        <td>500,000.00<\\/td>\\r\\n                        <td>400.00<\\/td>\\r\\n                        <td>95,000.00<\\/td>\\r\\n                        <td>595,000.00<\\/td>\\r\\n                    <\\/tr>\\r\\n                                <tr>\\r\\n                    <td>\\u5408\\u8ba1\\uff1a<\\/td>\\r\\n                    <td>\\u5b89\\u7f6e\\u603b\\u4ef7\\uff08\\u5143\\uff09<\\/td>\\r\\n                    <td colspan=\\\"3\\\">595,000.00<\\/td>\\r\\n                    <td colspan=\\\"4\\\">\\u5927\\u5199\\uff1a\\u4f0d\\u62fe\\u7396\\u4e07\\u4f0d\\u4edf\\u5706<\\/td>\\r\\n                <\\/tr>\\r\\n                                <tr>\\r\\n                    <td colspan=\\\"2\\\">\\u5b89\\u7f6e\\u540e\\u7ed3\\u4f59\\uff1a<\\/td>\\r\\n                    <td colspan=\\\"3\\\">-595,000.00<\\/td>\\r\\n                    <td colspan=\\\"4\\\"> \\u8d1f \\u4f0d\\u62fe\\u7396\\u4e07\\u4f0d\\u4edf\\u5706<\\/td>\\r\\n                <\\/tr>\\r\\n                        <tr class=\\\"one-big-title\\\">\\r\\n                <td colspan=\\\"8\\\">\\r\\n                    <span style=\\\"text-align: left;display: block;width: 30%;float: left;\\\">\\u5206\\u7ba1\\u9886\\u5bfc\\u7b7e\\u5b57\\uff1a<\\/span>\\r\\n                    <span style=\\\"text-align: left;display: block;width: 30%;float: left;\\\">\\u5f81\\u6536\\u80a1\\u8d1f\\u8d23\\u4eba\\uff1a<\\/span>\\r\\n                    <span style=\\\"text-align: left;display: block;width: 30%;float: left;\\\">\\u5b89\\u7f6e\\u80a1\\u8d1f\\u8d23\\u4eba\\uff1a<\\/span>\\r\\n                <\\/td>\\r\\n            <\\/tr>\\r\\n            <tr class=\\\"one-big-title\\\">\\r\\n                <td colspan=\\\"8\\\">\\r\\n                    <span style=\\\"text-align: left;display: block;width: 25%;float: left;\\\">\\u793e\\u7a33\\u529e\\u8d1f\\u8d23\\u4eba\\uff1a<\\/span>\\r\\n                    <span style=\\\"text-align: left;display: block;width: 25%;float: left;\\\">\\u590d\\u6838\\u4eba\\uff1a<\\/span>\\r\\n                    <span style=\\\"text-align: left;display: block;width: 25%;float: left;\\\">\\u7ecf\\u529e\\u4eba\\uff1a<\\/span>\\r\\n                    <span style=\\\"text-align: left;display: block;width: 25%;float: left;\\\">\\u88ab\\u5f81\\u6536\\u4eba\\uff1a<\\/span>\\r\\n                <\\/td>\\r\\n            <\\/tr>\\r\\n\\r\\n            <\\/tbody>\\r\\n        <\\/table>\\r\\n    <\\/div>\\r\\n<\\/div>\\r\\n\\r\\n<\\/body>\\r\\n\\r\\n<\\/html>\",\"estate_pic\":null,\"assets_pic\":[\"\\/storage\\/180321\\/BLcZekN0ORFQyJbh9wKvEqTTqoQqMNWXgOGLOjEP.jpeg\"]}', null, null, '170', '0', '2018-04-09 10:47:34', '2018-04-09 15:40:18', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8 COMMENT='兑付-汇总';

-- ----------------------------
-- Records of pay
-- ----------------------------
INSERT INTO `pay` VALUES ('25', '1', '2', '1', '1', '1', '1', '0', '13479.00', '[\"\\/storage\\/180321\\/oSPhQPfNZk5KSLvT2C4ARwanadbjlGuEvVTuxh4S.png\"]', '2018-03-21 10:57:49', '2018-03-21 10:57:49', null);
INSERT INTO `pay` VALUES ('71', '1', '1', '1', '1', '1', '0', '0', '12958.00', null, '2018-04-03 11:50:02', '2018-04-08 15:14:03', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 COMMENT='兑付-建筑';

-- ----------------------------
-- Records of pay_building
-- ----------------------------
INSERT INTO `pay_building` VALUES ('18', '1', '1', '1', '2', '1', '1', '4', '0', '20', '', '100.00', '1', '2', '0', '南', '10', '8000.00', '800000.00', '2018-03-06 19:31:33', '2018-03-06 19:31:33', null);
INSERT INTO `pay_building` VALUES ('21', '1', '1', '1', '2', '1', '1', '4', '0', '23', '', '100.00', '2', '1', '0', '东', '20', '0.00', '0.00', '2018-03-08 15:15:03', '2018-03-08 15:15:03', null);
INSERT INTO `pay_building` VALUES ('22', '1', '1', '1', '2', '1', '1', '5', '0', '23', '', '100.00', '1', '2', '0', '东', '21', '8000.00', '800000.00', '2018-03-08 15:15:03', '2018-03-08 15:15:03', null);
INSERT INTO `pay_building` VALUES ('23', '1', '2', '1', '1', '4', '2', '6', '2', '24', '90', '2121.00', '1', '1', '1', '南', '35', '1.00', '2121.00', '2018-03-21 10:56:44', '2018-03-21 10:56:44', null);
INSERT INTO `pay_building` VALUES ('24', '1', '2', '1', '1', '4', '2', '6', '2', '25', '90', '2121.00', '1', '1', '1', '南', '35', '1.00', '2121.00', '2018-03-21 10:57:49', '2018-03-21 10:57:49', null);
INSERT INTO `pay_building` VALUES ('28', '1', '1', '1', '1', '4', '4', '4', '1', '44', '90', '120.00', '1', '1', '1', '东', '12', '10.00', '1200.00', '2018-04-02 16:05:36', '2018-04-02 16:05:36', null);
INSERT INTO `pay_building` VALUES ('29', '1', '1', '1', '1', '4', '4', '4', '1', '45', '90', '120.00', '1', '1', '1', '东', '12', '10.00', '1200.00', '2018-04-02 16:48:40', '2018-04-02 16:48:40', null);
INSERT INTO `pay_building` VALUES ('30', '1', '1', '1', '1', '4', '4', '4', '1', '46', '90', '120.00', '1', '1', '1', '东', '12', '10.00', '1200.00', '2018-04-02 16:51:03', '2018-04-02 16:51:03', null);
INSERT INTO `pay_building` VALUES ('31', '1', '1', '1', '1', '4', '4', '4', '1', '47', '90', '120.00', '1', '1', '1', '东', '12', '10.00', '1200.00', '2018-04-02 17:30:39', '2018-04-02 17:30:39', null);
INSERT INTO `pay_building` VALUES ('52', '1', '1', '1', '1', '4', '4', '4', '1', '68', '90', '120.00', '1', '1', '1', '东', '12', '10.00', '1200.00', '2018-04-03 11:15:41', '2018-04-03 11:15:41', null);
INSERT INTO `pay_building` VALUES ('53', '1', '1', '1', '1', '4', '4', '4', '1', '69', '90', '120.00', '1', '1', '1', '东', '12', '10.00', '1200.00', '2018-04-03 11:31:46', '2018-04-03 11:31:46', null);
INSERT INTO `pay_building` VALUES ('54', '1', '1', '1', '1', '4', '4', '4', '1', '70', '90', '120.00', '1', '1', '1', '东', '12', '10.00', '1200.00', '2018-04-03 11:45:07', '2018-04-03 11:45:07', null);
INSERT INTO `pay_building` VALUES ('55', '1', '1', '1', '1', '4', '4', '4', '1', '71', '90', '120.00', '1', '1', '1', '东', '12', '10.00', '1200.00', '2018-04-03 11:50:02', '2018-04-03 11:50:02', null);

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
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
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
  `total` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT '房源安置总值',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `household_id` (`household_id`),
  KEY `land_id` (`land_id`),
  KEY `building_id` (`building_id`),
  KEY `house_id` (`house_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='兑付-安置房';

-- ----------------------------
-- Records of pay_house
-- ----------------------------
INSERT INTO `pay_house` VALUES ('1', '1', '2', '1', '1', '2', '100.00', '6000.00', '5000.00', '500000.00', '0.00', '500000.00', '2018-03-26 15:05:00', '2018-03-26 15:05:00', null);
INSERT INTO `pay_house` VALUES ('10', '1', '1', '1', '1', '2', '100.00', '6000.00', '5000.00', '500000.00', '95000.00', '595000.00', '2018-04-04 10:41:55', '2018-04-04 10:41:55', null);

-- ----------------------------
-- Table structure for pay_house_bak
-- ----------------------------
DROP TABLE IF EXISTS `pay_house_bak`;
CREATE TABLE `pay_house_bak` (
  `item_id` int(11) NOT NULL COMMENT ' 项目ID',
  `household_id` int(11) NOT NULL,
  `land_id` int(11) NOT NULL COMMENT ' 项目地块ID',
  `building_id` int(11) NOT NULL COMMENT ' 楼栋ID',
  `house_id` int(11) NOT NULL COMMENT '房源ID',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `house_type` tinyint(4) DEFAULT NULL COMMENT '1安置房   2周转房',
  `area` decimal(20,2) NOT NULL COMMENT '面积',
  `market` decimal(10,2) NOT NULL COMMENT ' 市场评估价',
  `price` decimal(10,2) NOT NULL COMMENT ' 安置优惠价',
  `amount` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT '安置优惠总价',
  `amount_plus` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT '优惠上浮总额',
  `total` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT '房源安置总值'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='兑付-备选安置房';

-- ----------------------------
-- Records of pay_house_bak
-- ----------------------------
INSERT INTO `pay_house_bak` VALUES ('1', '1', '1', '1', '1', '2018-04-03 15:42:38', '2018-04-03 15:42:38', null, '1', '90.00', '5000.00', '4000.00', '0.00', '0.00', '0.00');
INSERT INTO `pay_house_bak` VALUES ('1', '1', '1', '1', '2', '2018-04-03 15:42:47', '2018-04-03 15:42:47', null, '1', '100.00', '6000.00', '5000.00', '0.00', '0.00', '0.00');

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
INSERT INTO `pay_house_plus` VALUES ('1', '1', '1', '1', '1', '0.00', '15.00', '8.41', '5000.00', '4000.00', '10.00', '1000.00', '3364.00', '2018-03-26 15:05:00', '2018-03-26 15:05:00', null);
INSERT INTO `pay_house_plus` VALUES ('1', '1', '1', '1', '1', '0.00', '15.00', '8.41', '5000.00', '4000.00', '10.00', '1000.00', '3364.00', '2018-03-26 19:05:14', '2018-03-26 19:05:14', null);
INSERT INTO `pay_house_plus` VALUES ('1', '1', '1', '1', '2', '0.00', '15.00', '15.00', '6000.00', '5000.00', '10.00', '1000.00', '7500.00', '2018-04-04 08:25:43', '2018-04-04 08:25:43', null);
INSERT INTO `pay_house_plus` VALUES ('1', '1', '1', '1', '2', '15.00', '25.00', '10.00', '6000.00', '5000.00', '20.00', '1000.00', '10000.00', '2018-04-04 08:25:43', '2018-04-04 08:25:43', null);
INSERT INTO `pay_house_plus` VALUES ('1', '1', '1', '1', '2', '25.00', '30.00', '5.00', '6000.00', '5000.00', '30.00', '1000.00', '7500.00', '2018-04-04 08:25:43', '2018-04-04 08:25:43', null);
INSERT INTO `pay_house_plus` VALUES ('1', '1', '1', '1', '2', '30.00', '0.00', '70.00', '6000.00', '5000.00', '0.00', '1000.00', '70000.00', '2018-04-04 08:25:43', '2018-04-04 08:25:43', null);
INSERT INTO `pay_house_plus` VALUES ('1', '1', '1', '1', '2', '0.00', '15.00', '15.00', '6000.00', '5000.00', '10.00', '1000.00', '7500.00', '2018-04-04 10:22:14', '2018-04-04 10:22:14', null);
INSERT INTO `pay_house_plus` VALUES ('1', '1', '1', '1', '2', '15.00', '25.00', '10.00', '6000.00', '5000.00', '20.00', '1000.00', '10000.00', '2018-04-04 10:22:14', '2018-04-04 10:22:14', null);
INSERT INTO `pay_house_plus` VALUES ('1', '1', '1', '1', '2', '25.00', '30.00', '5.00', '6000.00', '5000.00', '30.00', '1000.00', '7500.00', '2018-04-04 10:22:14', '2018-04-04 10:22:14', null);
INSERT INTO `pay_house_plus` VALUES ('1', '1', '1', '1', '2', '30.00', '0.00', '70.00', '6000.00', '5000.00', '0.00', '1000.00', '70000.00', '2018-04-04 10:22:14', '2018-04-04 10:22:14', null);
INSERT INTO `pay_house_plus` VALUES ('1', '1', '1', '1', '2', '0.00', '15.00', '15.00', '6000.00', '5000.00', '10.00', '1000.00', '7500.00', '2018-04-04 10:32:22', '2018-04-04 10:32:22', null);
INSERT INTO `pay_house_plus` VALUES ('1', '1', '1', '1', '2', '15.00', '25.00', '10.00', '6000.00', '5000.00', '20.00', '1000.00', '10000.00', '2018-04-04 10:32:22', '2018-04-04 10:32:22', null);
INSERT INTO `pay_house_plus` VALUES ('1', '1', '1', '1', '2', '25.00', '30.00', '5.00', '6000.00', '5000.00', '30.00', '1000.00', '7500.00', '2018-04-04 10:32:22', '2018-04-04 10:32:22', null);
INSERT INTO `pay_house_plus` VALUES ('1', '1', '1', '1', '2', '30.00', '0.00', '70.00', '6000.00', '5000.00', '0.00', '1000.00', '70000.00', '2018-04-04 10:32:22', '2018-04-04 10:32:22', null);
INSERT INTO `pay_house_plus` VALUES ('1', '1', '1', '1', '2', '0.00', '15.00', '15.00', '6000.00', '5000.00', '10.00', '1000.00', '7500.00', '2018-04-04 10:41:55', '2018-04-04 10:41:55', null);
INSERT INTO `pay_house_plus` VALUES ('1', '1', '1', '1', '2', '15.00', '25.00', '10.00', '6000.00', '5000.00', '20.00', '1000.00', '10000.00', '2018-04-04 10:41:55', '2018-04-04 10:41:55', null);
INSERT INTO `pay_house_plus` VALUES ('1', '1', '1', '1', '2', '25.00', '30.00', '5.00', '6000.00', '5000.00', '30.00', '1000.00', '7500.00', '2018-04-04 10:41:55', '2018-04-04 10:41:55', null);
INSERT INTO `pay_house_plus` VALUES ('1', '1', '1', '1', '2', '30.00', '0.00', '70.00', '6000.00', '5000.00', '0.00', '1000.00', '70000.00', '2018-04-04 10:41:55', '2018-04-04 10:41:55', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='兑付-其他补偿事项';

-- ----------------------------
-- Records of pay_object
-- ----------------------------
INSERT INTO `pay_object` VALUES ('1', '1', '1', '1', '1', '1', '1', '1', '68', '宽带', '户', '200', '2.00', '400.00', '2018-04-03 11:15:41', '2018-04-03 11:15:41', null);
INSERT INTO `pay_object` VALUES ('2', '1', '1', '1', '1', '1', '1', '1', '69', '宽带', '户', '200', '2.00', '400.00', '2018-04-03 11:31:46', '2018-04-03 11:31:46', null);
INSERT INTO `pay_object` VALUES ('3', '1', '1', '1', '1', '1', '1', '1', '70', '宽带', '户', '200', '2.00', '400.00', '2018-04-03 11:45:07', '2018-04-03 11:45:07', null);
INSERT INTO `pay_object` VALUES ('4', '1', '1', '1', '1', '1', '1', '1', '71', '宽带', '户', '200', '2.00', '400.00', '2018-04-03 11:50:02', '2018-04-03 11:50:02', null);

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
  `amount` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT '补偿金额',
  `portion` decimal(10,2) DEFAULT '100.00' COMMENT '被征收户补偿比例（%）',
  `total` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT '被征收户补偿金额',
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
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COMMENT='兑付-科目';

-- ----------------------------
-- Records of pay_subject
-- ----------------------------
INSERT INTO `pay_subject` VALUES ('23', '1', '1', '1', '2', '20', '0', '1', '0', '', '800000.00', '100.00', '0.00', '110', '2018-03-06 15:26:53', '2018-03-21 12:00:00', null);
INSERT INTO `pay_subject` VALUES ('24', '1', '1', '1', '2', '20', '0', '17', '0', '', '3453.00', '100.00', '0.00', '111', '2018-03-06 19:31:33', '2018-03-21 12:00:00', null);
INSERT INTO `pay_subject` VALUES ('29', '1', '1', '1', '2', '23', '0', '1', '0', '', '800000.00', '100.00', '0.00', '112', '2018-03-08 15:15:03', '2018-03-08 15:15:03', null);
INSERT INTO `pay_subject` VALUES ('30', '1', '1', '1', '2', '23', '0', '4', '0', '', '6358.00', '100.00', '0.00', '113', '2018-03-08 15:15:03', '2018-03-08 15:15:03', null);
INSERT INTO `pay_subject` VALUES ('31', '1', '2', '1', '1', '24', '0', '1', '0', '', '2121.00', '100.00', '0.00', '110', '2018-03-21 10:56:44', '2018-03-21 10:56:44', null);
INSERT INTO `pay_subject` VALUES ('32', '1', '2', '1', '1', '24', '0', '6', '0', '', '5000.00', '100.00', '0.00', '110', '2018-03-21 10:56:44', '2018-03-21 10:56:44', null);
INSERT INTO `pay_subject` VALUES ('33', '1', '2', '1', '1', '24', '0', '4', '0', '', '6358.00', '100.00', '0.00', '110', '2018-03-21 10:56:44', '2018-03-21 10:56:44', null);
INSERT INTO `pay_subject` VALUES ('34', '1', '2', '1', '1', '25', '0', '1', '0', '', '2121.00', '100.00', '0.00', '110', '2018-03-21 10:57:49', '2018-03-21 10:57:49', null);
INSERT INTO `pay_subject` VALUES ('35', '1', '2', '1', '1', '25', '0', '6', '0', '', '5000.00', '100.00', '0.00', '110', '2018-03-21 10:57:49', '2018-03-21 10:57:49', null);
INSERT INTO `pay_subject` VALUES ('36', '1', '2', '1', '1', '25', '0', '4', '0', '', '6358.00', '100.00', '0.00', '110', '2018-03-21 10:57:49', '2018-03-21 10:57:49', null);
INSERT INTO `pay_subject` VALUES ('69', '1', '1', '1', '1', '71', '0', '1', '0', '', '1200.00', '100.00', '0.00', '110', '2018-04-03 11:50:02', '2018-04-03 11:50:02', null);
INSERT INTO `pay_subject` VALUES ('70', '1', '1', '1', '1', '71', '0', '6', '0', '', '5000.00', '100.00', '0.00', '110', '2018-04-03 11:50:02', '2018-04-03 11:50:02', null);
INSERT INTO `pay_subject` VALUES ('71', '1', '1', '1', '1', '71', '0', '4', '0', '', '6358.00', '100.00', '0.00', '110', '2018-04-03 11:50:02', '2018-04-03 11:50:02', null);
INSERT INTO `pay_subject` VALUES ('72', '1', '1', '1', '1', '71', '0', '5', '0', '', '400.00', '100.00', '0.00', '110', '2018-04-03 11:50:02', '2018-04-03 11:50:02', null);
INSERT INTO `pay_subject` VALUES ('73', '1', '1', '1', '1', '71', '0', '11', '0', null, '0.00', '100.00', '0.00', '110', '2018-04-03 11:51:40', '2018-04-08 15:14:03', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='兑付-临时周转房';

-- ----------------------------
-- Records of pay_transit
-- ----------------------------
INSERT INTO `pay_transit` VALUES ('1', '1', '1', '1', '1', '23', '0', '3', '2018-03-26 15:05:00', '2018-03-26 15:05:00', null);
INSERT INTO `pay_transit` VALUES ('2', '1', '1', '1', '1', '23', '0', '3', '2018-03-26 19:05:14', '2018-03-26 19:05:14', null);

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
  `subject_id` int(11) NOT NULL COMMENT '补偿科目ID',
  `pact_id` int(11) NOT NULL DEFAULT '0' COMMENT '公产单位协议ID',
  `total_id` int(11) NOT NULL DEFAULT '0' COMMENT '兑付总单ID',
  `calculate` text NOT NULL COMMENT '计算公式',
  `amount` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT '补偿金额',
  `portion` decimal(10,2) DEFAULT '20.00' COMMENT '公房单位补偿比例（%）',
  `total` decimal(30,2) NOT NULL DEFAULT '0.00' COMMENT '公房单位补偿金额',
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
INSERT INTO `role_menu` VALUES ('2', '40', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '41', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '42', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '43', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '44', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '45', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '46', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '47', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '48', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '49', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '50', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '51', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '56', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '57', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '58', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '59', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '60', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '61', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '62', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '63', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '64', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '65', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '66', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '67', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '68', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '72', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '73', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '74', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '75', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '76', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '77', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '78', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '79', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '81', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '82', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '83', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '84', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '85', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '86', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '87', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '88', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '89', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '90', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '91', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '92', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '93', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '94', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '95', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '96', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '97', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '98', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '99', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '100', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '101', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '102', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '103', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '104', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '105', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '106', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '107', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '108', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '109', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '110', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '111', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '112', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '113', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '114', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '115', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '116', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '117', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '118', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '119', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '120', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '121', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '122', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '123', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '124', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '125', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '126', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '127', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '128', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '129', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '130', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '131', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '132', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '133', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '134', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '135', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '136', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '137', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '138', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '139', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '140', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '141', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '142', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '143', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '144', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '145', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '146', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '147', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '148', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '150', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '152', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '154', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '156', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '158', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '159', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '160', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '161', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '162', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '163', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '164', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '165', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '166', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '167', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '168', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '169', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '170', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '171', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '172', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '173', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '174', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '175', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '176', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '177', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '178', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '179', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '180', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '181', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '182', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '183', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '184', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '185', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '186', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '187', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '188', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '189', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '190', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '191', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '192', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '193', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '194', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '195', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '196', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '197', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '198', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '199', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '200', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '201', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '202', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '203', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '204', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '205', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '206', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '207', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '208', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '209', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '210', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '211', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '212', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '214', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '215', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '216', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '217', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '218', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '219', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '220', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '221', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '222', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '223', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '224', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '225', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '226', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '228', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '229', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '230', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '231', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '232', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '233', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '234', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '235', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '236', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '237', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '238', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '239', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '240', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '241', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '242', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '243', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '244', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '245', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '246', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '247', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '248', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '249', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '250', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '251', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '252', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '253', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '254', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '255', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '256', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '257', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '258', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '259', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '260', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '261', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '262', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '268', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '270', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '271', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '272', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '273', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '274', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '275', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '277', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '278', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '279', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '280', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '281', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '287', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '288', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '289', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '290', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '291', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '292', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '293', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '297', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '298', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '299', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '300', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '302', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '303', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '304', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '305', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '306', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '309', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '310', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '311', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '314', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '343', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '344', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '345', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '346', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '347', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '348', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '349', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '350', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '354', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '355', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '356', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '357', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '358', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '359', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '360', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '361', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '362', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '363', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '364', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '365', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '366', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '367', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '368', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '369', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '370', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '371', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '372', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '373', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '374', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '375', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '376', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '377', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '378', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '379', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '380', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '381', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '382', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '383', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '384', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '388', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '389', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '390', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '391', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '392', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '393', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '394', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '396', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '397', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '398', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '399', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '400', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '401', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '402', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '403', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '404', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '405', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '406', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '407', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '408', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '409', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '410', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '411', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '412', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '413', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '414', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '415', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '416', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '417', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '418', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '420', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '421', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '422', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '424', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '439', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '440', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '442', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '443', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '444', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '447', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '448', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '460', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '462', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '463', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '467', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '468', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '469', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '470', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '471', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '472', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '473', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '475', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '476', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '477', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '478', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '479', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '480', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '482', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '484', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '485', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '486', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '487', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '488', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '489', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '490', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '491', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '492', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '493', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '494', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '495', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '496', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '497', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '498', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '499', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '500', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '501', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '505', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '506', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '507', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '508', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('2', '509', '2018-04-04 13:53:56', '2018-04-04 13:53:56');
INSERT INTO `role_menu` VALUES ('3', '40', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '41', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '42', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '43', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '44', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '45', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '46', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '47', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '48', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '49', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '50', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '51', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '56', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '57', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '58', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '59', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '60', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '61', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '62', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '63', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '64', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '65', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '66', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '67', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '68', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '72', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '73', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '74', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '75', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '76', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '77', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '78', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '79', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '81', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '82', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '83', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '84', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '85', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '86', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '87', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '88', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '89', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '90', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '91', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '92', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '93', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '94', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '95', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '96', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '97', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '98', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '99', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '100', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '101', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '102', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '103', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '104', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '105', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '106', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '107', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '108', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '109', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '110', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '111', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '112', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '113', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '114', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '115', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '116', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '117', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '118', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '119', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '120', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '121', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '122', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '123', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '124', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '125', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '126', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '127', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '128', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '129', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '130', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '131', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '132', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '133', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '134', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '135', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '136', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '137', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '138', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '139', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '140', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '141', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '142', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '143', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '144', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '145', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '146', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '147', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '148', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '150', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '152', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '154', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '156', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '158', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '159', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '160', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '161', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '162', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '163', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '164', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '165', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '166', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '167', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '168', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '169', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '170', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '171', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '172', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '173', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '174', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '175', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '176', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '177', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '178', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '179', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '180', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '181', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '182', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '183', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '184', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '185', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '186', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '187', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '188', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '189', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '190', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '191', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '192', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '193', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '194', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '195', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '196', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '197', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '198', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '199', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '200', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '201', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '202', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '203', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '204', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '205', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '206', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '207', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '208', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '209', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '210', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '211', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '212', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '214', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '215', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '216', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '217', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '218', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '219', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '220', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '221', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '222', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '223', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '224', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '225', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '226', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '228', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '229', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '230', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '231', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '232', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '233', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '234', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '235', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '236', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '237', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '238', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '239', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '240', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '241', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '242', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '243', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '244', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '245', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '246', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '247', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '248', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '249', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '250', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '251', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '252', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '253', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '254', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '255', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '256', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '257', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '258', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '259', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '260', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '261', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '262', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '268', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '270', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '271', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '272', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '273', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '274', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '275', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '277', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '278', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '279', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '280', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '281', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '287', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '288', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '289', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '290', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '291', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '292', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '293', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '297', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '298', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '299', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '300', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '302', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '303', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '304', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '305', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '306', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '309', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '310', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '311', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '314', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '343', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '344', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '345', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '346', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '347', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '348', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '349', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '350', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '354', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '355', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '356', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '357', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '358', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '359', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '360', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '361', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '362', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '363', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '364', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '365', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '366', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '367', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '368', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '369', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '370', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '371', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '372', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '373', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '374', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '375', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '376', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '377', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '378', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '379', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '380', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '381', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '382', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '383', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '384', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '388', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '389', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '390', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '391', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '392', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '393', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '394', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '396', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '397', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '398', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '399', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '400', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '401', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '402', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '403', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '404', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '405', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '406', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '407', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '408', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '409', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '410', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '411', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '412', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '413', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '414', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '415', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '416', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '417', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '418', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '420', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '421', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '422', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '424', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '439', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '440', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '442', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '443', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '444', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '447', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '448', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '460', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '462', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '463', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '467', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '468', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '469', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '470', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '471', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '472', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '473', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '475', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '476', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '477', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '478', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '479', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '480', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '482', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '484', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '485', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '486', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '487', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '488', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '489', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '490', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '491', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '492', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '493', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '494', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '495', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '496', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '497', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '498', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '499', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '500', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '501', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '505', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '506', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '507', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '508', '2018-04-04 13:54:06', '2018-04-04 13:54:06');
INSERT INTO `role_menu` VALUES ('3', '509', '2018-04-04 13:54:06', '2018-04-04 13:54:06');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='拆除委托';

-- ----------------------------
-- Records of tear
-- ----------------------------
INSERT INTO `tear` VALUES ('1', '1', '2018-03-22', '[\"\\/storage\\/180322\\/x0hG4WrO4YMexV024qEMxKZZyon2f6AoI5tTb7Mt.png\"]', '20', '2018-03-22 10:16:22', '2018-03-22 10:16:22', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='社会风险评估调查话题';

-- ----------------------------
-- Records of topic
-- ----------------------------
INSERT INTO `topic` VALUES ('1', '调查话题1', null, '2018-02-22 17:17:23', '2018-02-22 17:17:23', null);
INSERT INTO `topic` VALUES ('2', '测试话题', null, '2018-03-28 14:51:57', '2018-03-28 14:51:59', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='人员管理';

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', '0', '1', 'demo', 'eyJpdiI6ImhOTm1oa3JHQzduR2JqbzdLY1NEckE9PSIsInZhbHVlIjoiTlpaTFVmdjlNbUFLMjN2Q3hzYW1RZz09IiwibWFjIjoiYzc3M2VhZWEyYjg5NTMzYjMyNmFmNjg2ZDNiNjIyMjMwOTYyZjMxMzlhZDE5MWJmNDIxMTUxNzZjYzk4YjRlNSJ9', '0860480D-B2FB-C834-2336-F4A9B0DB5AA9', '测试演示账号', null, null, null, '2018-04-04 09:12:00', '127.0.0.1', '3GBdrBJ5u31xVGocSIZIo36NzWnJP1b19c2s2Z3P', '2018-04-04 11:19:43', '2018-02-05 09:38:29', '2018-04-04 11:19:43', null);
INSERT INTO `user` VALUES ('3', '1', '1', 'admin', 'eyJpdiI6IlpzbzB5UUJvc2d6dWZSVlZvQmtIWXc9PSIsInZhbHVlIjoiclM5WkdYVk1sc0FQZ1lzbHRwVnY1dz09IiwibWFjIjoiMzNiNjZiYWZiMjEyZjAwNDkyMzFjZDEwN2I1Mzk3ZWJhNmRkYWMyZmE1MjQ2M2RmOWJiOTE5ODgxMjQzM2QwOCJ9', '0860480D-B2FB-C834-2336-F4A9B0DB5AA8', '我是主管', null, null, null, '2018-04-08 15:45:07', '::1', 'xpicRzwPHyIYEN4BSHUvCS67Adq0VexDdTqip1ik', '2018-04-08 16:58:38', '2018-02-05 09:38:29', '2018-04-08 16:58:38', null);
INSERT INTO `user` VALUES ('4', '1', '1', 'user', 'eyJpdiI6IlJCTXJaOFN3MWxOeUdqZWwyZ0JkTHc9PSIsInZhbHVlIjoia1wvd1EzTzY1MlE2WENwcUNid3M5aGc9PSIsIm1hYyI6IjI0NTAwNjA1OWY4MDg2NGRhNjE1YjhiMGEyYzIzY2FkNTk2NmRmYWNkMWM4ZDBhNmRjY2ZiOWM0ODI5YzJmNzIifQ==', '0860480D-B2FB-C834-2336-F4A9B0DB5AA1', '测试超管', null, null, null, '2018-04-09 14:36:29', '127.0.0.1', 'exE4A378MqLBiMIvZDFs3G9BiVr0MI35sAj69DFc', '2018-04-09 16:49:46', '2018-02-05 09:38:29', '2018-04-09 16:49:46', null);
INSERT INTO `user` VALUES ('5', '1', '2', 'main', 'eyJpdiI6IlwvUmg3Vnk3S2loQUhtaFk4QTFMWUh3PT0iLCJ2YWx1ZSI6InZPOG5zYmlDcGZkbm9BTHlSZXNGakE9PSIsIm1hYyI6IjFmYzlmOWFmZTFlYjllMWYyMGQwYmQwNGViODA5OTZlYzBiNDlkZGQ1Y2EzYjBlYmU4MjczYzVkZDk2MjlkN2MifQ==', '06F043FD-D1CA-FDC3-1CFA-D6B4F669453B', '主管是我', null, null, null, '2018-04-04 15:06:24', '127.0.0.1', '6cHGQyZdi5MU4fhTtye8toaotbuyHOBZcanU8EeG', '2018-04-04 15:06:59', '2018-02-27 16:50:35', '2018-04-04 15:06:59', null);
INSERT INTO `user` VALUES ('6', '1', '3', 'second', 'eyJpdiI6IktiZVJFejdpbk8wbVh3VFN3MkxidkE9PSIsInZhbHVlIjoiQitpZGN6UXVNTmR5aklqTmVWeHRpQT09IiwibWFjIjoiZDFjM2E4ZjgzMGI4MjQyNjNhNjc3ODI4ZDA0ZmJmZDNkNmNmOGVmYTBmYjBhMmEwMzI1ZjYzM2ZmNzkxNjllMSJ9', 'BA43A48B-A125-1B88-B194-12C4F2ADFC1D', '我是分管', null, null, null, null, null, null, null, '2018-02-27 16:51:51', '2018-02-27 16:51:51', null);
INSERT INTO `user` VALUES ('7', '4', '4', 'resettle', 'eyJpdiI6IkwrMXRWRHRDaTJjeTY2TmVJUk1MWFE9PSIsInZhbHVlIjoiUGJ5cyt0cEFLS0lCdGdjQmRkZkoyZz09IiwibWFjIjoiYjUyZjVmNjJmNmFlMjEwZThmY2VmMWNiZjdlOTNkMmJiOTViMTZkMzc2MGY3MWE2NzgzN2Q4NDczMzFiMmNkZSJ9', 'AFE32CCA-C87E-D703-F577-254D58C08BB6', '安置', null, null, null, '2018-03-14 13:51:05', '127.0.0.1', 'XoR8xdN6HBrytkRtAxaMN6r7eKrhDM2t7d2KxurQ', '2018-03-14 13:52:59', '2018-02-27 16:52:32', '2018-03-14 13:52:59', null);
INSERT INTO `user` VALUES ('8', '5', '5', 'funds', 'eyJpdiI6Im5PbDRicSswbzBIaEdFaGxRWTk0NHc9PSIsInZhbHVlIjoiTXFwMlVxWHpUZ1h3ZlNwRG0wUkhNdz09IiwibWFjIjoiOGEyNmI2OGE2MGQyMGFmODE1OThiZDUzZjU5NjVjOWU1OTEwODBhNGViYWYxMzIzMzg3ODYxZGQ2YmQ1MmUwNSJ9', 'C7A3C540-74F1-64E1-041A-A91D9A7D078B', '账务', null, null, null, null, null, null, null, '2018-02-27 16:53:04', '2018-02-27 16:53:04', null);
INSERT INTO `user` VALUES ('9', '1', '2', 'ceshi', 'eyJpdiI6Ik1yUTV4TXVTMkEzNWM5N2wwOHk2Y1E9PSIsInZhbHVlIjoiZGZacmpmbEV6eFMxQ3ZHRTN2Q1Q3UT09IiwibWFjIjoiZTE2ZjFhMGJhMDdjMmJmZmNkYjMzMzUzYzQyM2MxNjczZmNmY2M3NTI5OGQ0YTZmYTVlZjc1OGY3OTQ4ZDllYiJ9', '9CFC1C2B-D54D-5E62-30CF-826975549415', '张三', '13012341234', '1@qq.com', '描述', '2018-04-09 16:22:52', '127.0.0.1', 'mvzsxGcu8varK0I0ayoDuijBF7HYvDyGUj58fELg', '2018-04-09 16:22:57', '2018-03-28 17:26:07', '2018-04-09 16:22:57', null);
INSERT INTO `user` VALUES ('10', '1', '3', 'ceshi2', 'eyJpdiI6IkJERXFreG1NUmNvOEQzckgwZk5EY3c9PSIsInZhbHVlIjoiUHN1ejZ3WmZIYUJ5YjNYZStLUTRkUT09IiwibWFjIjoiZGJhZjFiZGQ5NGI3ZjQyOWYwZWYxNzdlMDU3NzgwYTEyYzA1OTFjOWQwMzMwYjAzOGRmNThhOTVhYzcyMzExMSJ9', '0CCA8A02-BD0F-55C6-4304-AF0F3045FBA7', '李四', '13012345678', '1@qq.com', '描述', '2018-04-08 09:09:07', '127.0.0.1', '9JANWbwKlqb9p1kUoHhHXcbbyU5ICILh9FhRp2A2', '2018-04-08 09:16:48', '2018-03-28 17:27:02', '2018-04-08 09:16:48', null);
