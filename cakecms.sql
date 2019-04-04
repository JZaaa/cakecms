/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.1.29-MariaDB : Database - cakecms
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
  `plugin` varchar(20) DEFAULT NULL COMMENT '插件',
  `controller` varchar(20) NOT NULL COMMENT '控制器',
  `action` varchar(20) NOT NULL COMMENT '行为',
  `params` varchar(100) DEFAULT NULL COMMENT '其他参数串',
  `url` varchar(100) DEFAULT NULL COMMENT '直接跳转链接',
  `sort` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `menus` */

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`description`,`is_super`,`role_menu`,`role_auth`) values 
(1,'超级管理员','超级管理员',1,'','');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`role_id`,`username`,`password`,`nickname`,`status`,`login_count`,`login_ip`,`created`,`modified`) values 
(1,1,'admin','$2y$10$HGHnQVGnUvLqKfOF3Yg0kuiV2XwMkp9OlzAlxdYc69sKoS.e.EgDG','超级管理员',1,0,'','2019-04-04 14:01:29','2019-04-04 14:01:29');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
