/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : user_auth

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2016-09-26 19:28:01
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `t_func`
-- ----------------------------
DROP TABLE IF EXISTS `t_func`;
CREATE TABLE `t_func` (
  `func_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) NOT NULL DEFAULT '0' COMMENT '0表示无父结点',
  `type` smallint(6) NOT NULL DEFAULT '0' COMMENT '0表示菜单,1表示按钮',
  `name` varchar(50) NOT NULL,
  `url` varchar(200) DEFAULT NULL COMMENT '链接地址,如果有,是这样的形式:/MODULE_NAME/CONTROLLER_NAME/ACTION_NAME,以上三个名称,在程序里边都可以获到,这样可以获取页面按钮',
  `btn` bigint(100) DEFAULT NULL COMMENT '按钮id,如果是按钮类型的,这是按钮的id',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序,越小的靠前',
  `icon` varchar(0) DEFAULT NULL COMMENT '图标地址',
  `system` char(10) NOT NULL DEFAULT 'home' COMMENT '区分是前端系统(home),还是系统管理员系统(admin)',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `use_yn` char(1) NOT NULL DEFAULT 'Y' COMMENT '是否有效',
  PRIMARY KEY (`func_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统功能表';

-- ----------------------------
-- Records of t_func
-- ----------------------------

-- ----------------------------
-- Table structure for `t_fund`
-- ----------------------------
DROP TABLE IF EXISTS `t_fund`;
CREATE TABLE `t_fund` (
  `fund_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '资产端名称',
  PRIMARY KEY (`fund_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='业务-资产端';

-- ----------------------------
-- Records of t_fund
-- ----------------------------
INSERT INTO `t_fund` VALUES ('1', '前隆');
INSERT INTO `t_fund` VALUES ('2', '用钱宝');

-- ----------------------------
-- Table structure for `t_group`
-- ----------------------------
DROP TABLE IF EXISTS `t_group`;
CREATE TABLE `t_group` (
  `group_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '数据分组名',
  `use_yn` char(1) NOT NULL DEFAULT 'Y' COMMENT '是否有效',
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='数据权限-分组表';

-- ----------------------------
-- Records of t_group
-- ----------------------------
INSERT INTO `t_group` VALUES ('1', '大连运营组', 'Y');
INSERT INTO `t_group` VALUES ('2', '北京管理组', 'Y');

-- ----------------------------
-- Table structure for `t_group_bus`
-- ----------------------------
DROP TABLE IF EXISTS `t_group_bus`;
CREATE TABLE `t_group_bus` (
  `group_id` bigint(20) NOT NULL,
  `bus_type` varchar(20) NOT NULL COMMENT '业务类型,例如:资产端 fund,资金端money ,还可以是创建人create_userid等等 ，这里可以根据需要定义',
  `set_type` varchar(50) NOT NULL DEFAULT 'equal' COMMENT '认默是等于，指等于bus_data,该值还可以是范围(between)，对应bus_start和bus_end了,后续还可以仔细扩展',
  `bus_data` varchar(100) DEFAULT '0' COMMENT '业务类型数据， 例如这里可以是资产端的id,或者资金端的id',
  `bus_start` varchar(100) DEFAULT NULL COMMENT '如果采用的是范围限定，这里是范围开始',
  `bus_end` varchar(100) DEFAULT NULL COMMENT '如果采用的是范围限定，这里是范围结束',
  UNIQUE KEY `group_bus` (`group_id`,`bus_type`,`set_type`,`bus_data`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='数据权限-业务表';

-- ----------------------------
-- Records of t_group_bus
-- ----------------------------
INSERT INTO `t_group_bus` VALUES ('1', 'fund', 'equal', '1', null, null);
INSERT INTO `t_group_bus` VALUES ('1', 'fund', 'equal', '2', null, null);
INSERT INTO `t_group_bus` VALUES ('2', 'fund', 'equal', '1', null, null);

-- ----------------------------
-- Table structure for `t_message`
-- ----------------------------
DROP TABLE IF EXISTS `t_message`;
CREATE TABLE `t_message` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `img_url` varchar(200) DEFAULT NULL,
  `content` varchar(4000) DEFAULT NULL,
  `use_yn` char(1) DEFAULT 'Y',
  `create_time` int(11) DEFAULT NULL,
  `create_userid` bigint(20) DEFAULT NULL,
  `fund_id` bigint(20) DEFAULT NULL COMMENT '所属资产端',
  `money_id` bigint(20) DEFAULT NULL COMMENT '所属资金端',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='公告信息表';

-- ----------------------------
-- Records of t_message
-- ----------------------------
INSERT INTO `t_message` VALUES ('1', 'aa', null, 'aaaaa', 'Y', null, null, '1', '1');
INSERT INTO `t_message` VALUES ('2', 'bb', null, 'bbbbb', 'Y', null, null, '1', '1');
INSERT INTO `t_message` VALUES ('3', 'cc', null, 'ccccc', 'Y', null, null, '1', '1');
INSERT INTO `t_message` VALUES ('4', 'dd', null, 'dddd', 'Y', null, null, '2', '2');

-- ----------------------------
-- Table structure for `t_money`
-- ----------------------------
DROP TABLE IF EXISTS `t_money`;
CREATE TABLE `t_money` (
  `money_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '资金端名称',
  PRIMARY KEY (`money_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='业务-资金端';

-- ----------------------------
-- Records of t_money
-- ----------------------------
INSERT INTO `t_money` VALUES ('1', '元丰小贷');
INSERT INTO `t_money` VALUES ('2', '漠河');

-- ----------------------------
-- Table structure for `t_role`
-- ----------------------------
DROP TABLE IF EXISTS `t_role`;
CREATE TABLE `t_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) DEFAULT NULL,
  `use_yn` char(1) NOT NULL DEFAULT 'Y' COMMENT '是否有效',
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Records of t_role
-- ----------------------------
INSERT INTO `t_role` VALUES ('1', '项目经理', 'Y');
INSERT INTO `t_role` VALUES ('2', '信贷专员', 'Y');

-- ----------------------------
-- Table structure for `t_role_func`
-- ----------------------------
DROP TABLE IF EXISTS `t_role_func`;
CREATE TABLE `t_role_func` (
  `role_id` bigint(20) NOT NULL,
  `func_id` bigint(20) NOT NULL,
  UNIQUE KEY `role_func` (`role_id`,`func_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='角色系统功能表';

-- ----------------------------
-- Records of t_role_func
-- ----------------------------

-- ----------------------------
-- Table structure for `t_user`
-- ----------------------------
DROP TABLE IF EXISTS `t_user`;
CREATE TABLE `t_user` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `pwd` varchar(100) DEFAULT NULL,
  `use_yn` char(1) NOT NULL DEFAULT 'Y' COMMENT '是否有效',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of t_user
-- ----------------------------
INSERT INTO `t_user` VALUES ('1', 'crg', 'c4ca4238a0b923820dcc509a6f75849b', 'Y');
INSERT INTO `t_user` VALUES ('2', 'jxj', 'c4ca4238a0b923820dcc509a6f75849b', 'Y');
INSERT INTO `t_user` VALUES ('3', 'gf', 'c4ca4238a0b923820dcc509a6f75849b', 'Y');
INSERT INTO `t_user` VALUES ('4', 'ww', 'c4ca4238a0b923820dcc509a6f75849b', 'Y');

-- ----------------------------
-- Table structure for `t_user_group`
-- ----------------------------
DROP TABLE IF EXISTS `t_user_group`;
CREATE TABLE `t_user_group` (
  `user_id` bigint(20) NOT NULL,
  `group_id` bigint(20) NOT NULL,
  UNIQUE KEY `user_group` (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户-数据权限分组表';

-- ----------------------------
-- Records of t_user_group
-- ----------------------------
INSERT INTO `t_user_group` VALUES ('1', '1');
INSERT INTO `t_user_group` VALUES ('2', '1');
INSERT INTO `t_user_group` VALUES ('3', '2');
INSERT INTO `t_user_group` VALUES ('4', '2');

-- ----------------------------
-- Table structure for `t_user_replace`
-- ----------------------------
DROP TABLE IF EXISTS `t_user_replace`;
CREATE TABLE `t_user_replace` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL COMMENT '被替代者',
  `replace_user_id` bigint(20) NOT NULL COMMENT '替代者',
  `time_start` bigint(20) NOT NULL COMMENT '替代的有效时间开始',
  `time_end` bigint(20) NOT NULL COMMENT '替代的有效时间结束',
  `status` bit(1) NOT NULL DEFAULT b'0' COMMENT '0申请中,1审核通过',
  `use_yn` char(1) NOT NULL DEFAULT 'Y' COMMENT '是否有效',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户替代表';

-- ----------------------------
-- Records of t_user_replace
-- ----------------------------

-- ----------------------------
-- Table structure for `t_user_role`
-- ----------------------------
DROP TABLE IF EXISTS `t_user_role`;
CREATE TABLE `t_user_role` (
  `user_id` bigint(20) NOT NULL,
  `role_id` bigint(20) NOT NULL,
  UNIQUE KEY `user_role` (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户角色表';

-- ----------------------------
-- Records of t_user_role
-- ----------------------------
INSERT INTO `t_user_role` VALUES ('1', '1');
INSERT INTO `t_user_role` VALUES ('2', '1');
INSERT INTO `t_user_role` VALUES ('3', '2');
INSERT INTO `t_user_role` VALUES ('4', '2');
