/*
MySQL Database SQL Dump
数据库：cakecms
生成日期：2019-04-18 16:55:39
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`cakecms` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `cakecms`;

/*Table structure for table `menus` */

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单表',
  `parent_id` int(11) unsigned NOT NULL COMMENT '父菜单',
  `name` varchar(30) NOT NULL COMMENT '菜单名称',
  `icon` varchar(20) DEFAULT NULL COMMENT '图标',
  `plugin` varchar(20) DEFAULT NULL COMMENT '插件',
  `controller` varchar(20) DEFAULT NULL COMMENT '控制器',
  `action` varchar(20) DEFAULT NULL COMMENT '行为',
  `params` varchar(100) DEFAULT NULL COMMENT '其他参数串',
  `url` varchar(100) DEFAULT NULL COMMENT '直接跳转链接',
  `sort` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_show` tinyint(2) DEFAULT '1' COMMENT '是否可见,1.可见',
  `is_root` tinyint(2) DEFAULT '2' COMMENT '1.无法删除',
  PRIMARY KEY (`id`),
  KEY `parent_id_index` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `menus` */

insert into `menus` (id,parent_id,name,icon,plugin,controller,action,params,url,sort,is_show,is_root) values
('1','0','首页','icon-home','Admin','Home','index','','','254','1','1'),
('2','0','系统管理','icon-cog','','','','','','0','1','1'),
('3','2','菜单管理','','Admin','Menus','index','','','0','1','1'),
('4','2','服务器信息','','Admin','Home','serverEnv','','','0','1','1'),
('5','2','数据库管理','','Admin','Cogs','database','','','0','1','1'),
('6','2','系统用户','','Admin','Users','index','','','0','1','1'),
('7','2','系统角色','','Admin','Roles','index','','','0','1','1'),
('8','2','路由管理','icon-globe','Admin','Routers','index','','','0','1','2');

/*Table structure for table `role_routers` */

DROP TABLE IF EXISTS `role_routers`;

CREATE TABLE `role_routers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '路由权限表',
  `role_id` int(11) unsigned NOT NULL COMMENT '关联角色',
  `router` varchar(50) NOT NULL COMMENT '路由地址',
  PRIMARY KEY (`id`),
  KEY `role_id_index` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组表',
  `name` varchar(30) NOT NULL COMMENT '用户组名称',
  `description` varchar(50) DEFAULT NULL COMMENT '用户组描述',
  `is_super` tinyint(2) NOT NULL DEFAULT '2' COMMENT '超级权限，1:是，不可删除，拥有所有权限',
  `role_menu` text COMMENT '可见菜单id集合',
  `role_auth` text COMMENT '按钮权限id集合',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `roles` */

insert into `roles` (id,name,description,is_super,role_menu,role_auth) values
('1','超级管理员','超级管理员','1','',''),
('2','测试组','测试组','2','1,2,4,5','');

/*Table structure for table `routers` */

DROP TABLE IF EXISTS `routers`;

CREATE TABLE `routers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '路由表',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `level` tinyint(2) NOT NULL DEFAULT '1' COMMENT '等级',
  `name` varchar(20) DEFAULT NULL COMMENT '名称',
  `router` varchar(50) NOT NULL COMMENT '路由,Plugin.Model.Action',
  `sort` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`router`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

/*Data for the table `routers` */

insert into `routers` (id,parent_id,level,name,router,sort) values
('1','0','1','基础模块','Admin','0'),
('2','1','2','其他','Cogs','0'),
('3','1','2','公共','Home','0'),
('4','1','2','菜单管理','Menus','0'),
('5','1','2','','RoleRouters','0'),
('6','1','2','角色权限','Roles','0'),
('7','1','2','路由管理','Routers','0'),
('8','1','2','系统用户','Users','0'),
('9','2','3','数据库备份','Admin.Cogs.database','0'),
('10','3','3','服务器信息','Admin.Home.serverEnv','0'),
('11','4','3','浏览','Admin.Menus.index','5'),
('12','4','3','新增','Admin.Menus.add','4'),
('13','4','3','编辑','Admin.Menus.edit','3'),
('14','4','3','删除','Admin.Menus.delete','2'),
('15','6','3','浏览','Admin.Roles.index','5'),
('16','6','3','新增','Admin.Roles.add','4'),
('17','6','3','编辑','Admin.Roles.edit','3'),
('18','6','3','删除','Admin.Roles.delete','2'),
('19','6','3','','Admin.Roles.menu','0'),
('20','7','3','浏览','Admin.Routers.index','5'),
('21','7','3','新增','Admin.Routers.add','4'),
('22','7','3','编辑','Admin.Routers.edit','3'),
('23','7','3','删除','Admin.Routers.delete','2'),
('24','7','3','初始化','Admin.Routers.reset','0'),
('25','7','3','自动加载','Admin.Routers.load','0'),
('26','8','3','浏览','Admin.Users.index','5'),
('27','8','3','新增','Admin.Users.add','4'),
('28','8','3','编辑','Admin.Users.edit','3'),
('29','8','3','删除','Admin.Users.delete','2');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户表',
  `role_id` int(11) NOT NULL COMMENT '关联用户组',
  `username` varchar(30) NOT NULL COMMENT '用户名',
  `password` varchar(100) NOT NULL COMMENT '密码',
  `nickname` varchar(30) NOT NULL COMMENT '昵称',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：1.正常  2.禁用',
  `login_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `login_ip` varchar(11) DEFAULT NULL COMMENT '最后登录ip',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert into `users` (id,role_id,username,password,nickname,status,login_count,login_ip,created,modified) values
('1','1','admin','$2y$10$HGHnQVGnUvLqKfOF3Yg0kuiV2XwMkp9OlzAlxdYc69sKoS.e.EgDG','超级管理员','1','9','::1','2019-04-04 14:01:29','2019-04-18 13:17:03'),
('2','2','test','$2y$10$KO7PetLfGt/6uxu91tjA0OVOyfnl1fKKfVwS7otxxn2wXMQSKkSnm','测试员','1','2','::1','2019-04-17 14:13:45','2019-04-17 14:15:18');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
