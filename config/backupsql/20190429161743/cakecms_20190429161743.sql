/*
MySQL Database SQL Dump
数据库：cakecms
生成日期：2019-04-29 16:17:43
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

/*Table structure for table `articles` */

DROP TABLE IF EXISTS `articles`;

CREATE TABLE `articles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章内容表',
  `site_menu_id` int(11) NOT NULL COMMENT '所属栏目',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `color` varchar(10) DEFAULT NULL COMMENT '标题颜色',
  `subtitle` varchar(100) DEFAULT NULL COMMENT '副标题',
  `abstract` varchar(255) DEFAULT NULL COMMENT '摘要',
  `author` varchar(30) DEFAULT NULL COMMENT '作者',
  `source` varchar(30) DEFAULT NULL COMMENT '来源',
  `date` datetime DEFAULT NULL COMMENT '发布日期',
  `thumb` varchar(100) DEFAULT NULL COMMENT '缩略图',
  `content` text COMMENT '内容',
  `seo_keywords` varchar(100) DEFAULT NULL,
  `seo_description` varchar(200) DEFAULT NULL,
  `status` tinyint(2) unsigned NOT NULL DEFAULT '2' COMMENT '状态：1.发布，2.草稿',
  `istop` tinyint(2) unsigned NOT NULL DEFAULT '2' COMMENT '1.置顶',
  `visit` int(11) unsigned DEFAULT '0' COMMENT '访问数',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `site_menus_index` (`site_menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `articles` */

insert into `articles` (id,site_menu_id,title,color,subtitle,abstract,author,source,date,thumb,content,seo_keywords,seo_description,status,istop,visit,created,modified) values
('2','3','公司简介','','','','','','2019-04-28 15:29:20','files/image/20190428/5cc558053758f.jpg','<p>
	公司简介内容
</p>
<p>
	<img src="/github/cakecms/files/image/20190428/5cc55884d7bdd.jpg" alt="" />
</p>','','','1','2','4','2019-04-28 15:29:20','2019-04-29 14:50:31'),
('4','4','测试新闻','#3f51b5','123','这是测试新闻','admin','本站','2019-04-29 14:42:16','files/image/20190429/5cc69fb77dd6e.jpg','士大夫士大夫','','','1','1','19','2019-04-29 14:42:35','2019-04-29 15:55:52'),
('5','4','第二条新闻','','','','','','2019-04-29 15:22:00','','','','','1','2','4','2019-04-29 15:22:10','2019-04-29 15:55:40'),
('6','4','第三条新闻','','','','','','2019-04-29 15:22:13','','','','','1','2','4','2019-04-29 15:22:20','2019-04-29 15:49:37');

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
  `extend` varchar(20) DEFAULT NULL COMMENT 'router拓展参数，仅支持一位',
  `params` varchar(100) DEFAULT NULL COMMENT '其他参数串',
  `url` varchar(100) DEFAULT NULL COMMENT '直接跳转链接',
  `sort` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_show` tinyint(2) DEFAULT '1' COMMENT '是否可见,1.可见',
  `is_root` tinyint(2) DEFAULT '2' COMMENT '1.无法删除',
  PRIMARY KEY (`id`),
  KEY `parent_id_index` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `menus` */

insert into `menus` (id,parent_id,name,icon,plugin,controller,action,extend,params,url,sort,is_show,is_root) values
('1','0','首页','icon-home','Admin','Home','index','','','','254','1','1'),
('2','0','系统管理','icon-cog','','','','','','','0','1','1'),
('3','2','菜单管理','','Admin','Menus','index','','','','0','1','1'),
('4','2','服务器信息','','Admin','Home','serverEnv','','','','0','1','1'),
('5','2','数据库管理','','Admin','Cogs','database','','','','0','1','1'),
('6','2','系统用户','','Admin','Users','index','','','','0','1','1'),
('7','2','系统角色','','Admin','Roles','index','','','','0','1','1'),
('8','2','路由管理','icon-globe','Admin','Routers','index','','','','0','1','2'),
('9','0','内容管理','icon-pencil','','','','','','','0','1','2'),
('10','9','轮播图片','','Admin','Sliders','index','','','','0','1','2'),
('11','9','网站栏目','','Admin','SiteMenus','index','','','','0','1','2'),
('12','9','单页内容','','Admin','Articles','index','1','','','0','1','2'),
('14','9','列表内容','','Admin','Articles','index','2','','','0','1','2');

/*Table structure for table `options` */

DROP TABLE IF EXISTS `options`;

CREATE TABLE `options` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置表',
  `name` varchar(20) DEFAULT NULL COMMENT '配置名称',
  `key_field` varchar(30) NOT NULL COMMENT 'key值',
  `value_field` text COMMENT 'value值',
  `group` varchar(20) NOT NULL COMMENT '分组',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `role_routers` */

DROP TABLE IF EXISTS `role_routers`;

CREATE TABLE `role_routers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '路由权限表',
  `role_id` int(11) unsigned NOT NULL COMMENT '关联角色',
  `router` varchar(50) NOT NULL COMMENT '路由地址',
  PRIMARY KEY (`id`),
  KEY `role_id_index` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

/*Data for the table `role_routers` */

insert into `role_routers` (id,role_id,router) values
('7','2','Admin.Routers.delete'),
('13','2','Admin.Sliders.index'),
('5','2','Admin.Routers.index'),
('8','2','Admin.Home.serverEnv'),
('9','2','Admin.Cogs.database'),
('11','2','Admin.Roles.add'),
('14','2','Admin.Sliders.add'),
('15','2','Admin.Routers.edit'),
('16','2','Admin.Users.index'),
('17','2','Admin.Users.add');

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组表',
  `name` varchar(30) NOT NULL COMMENT '用户组名称',
  `description` varchar(50) DEFAULT NULL COMMENT '用户组描述',
  `is_super` tinyint(2) NOT NULL DEFAULT '2' COMMENT '超级权限，1:是，不可删除，拥有所有权限',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `roles` */

insert into `roles` (id,name,description,is_super) values
('1','超级管理员','超级管理员','1'),
('2','测试组','测试组','2');

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
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

/*Data for the table `routers` */

insert into `routers` (id,parent_id,level,name,router,sort) values
('1','0','1','系统管理','Admin.Cog','0'),
('2','1','2','路由管理','Admin.Routers','90'),
('3','2','3','浏览','Admin.Routers.index','90'),
('4','2','3','新增','Admin.Routers.add','80'),
('5','2','3','编辑','Admin.Routers.edit','70'),
('6','2','3','删除','Admin.Routers.delete','60'),
('7','1','2','系统角色','Admin.Roles','80'),
('8','7','3','浏览','Admin.Roles.index','90'),
('9','7','3','新增','Admin.Roles.add','80'),
('10','7','3','编辑','Admin.Roles.edit','70'),
('11','7','3','删除','Admin.Roles.delete','60'),
('12','1','2','系统用户','Admin.Users','70'),
('13','12','3','浏览','Admin.Users.index','90'),
('14','12','3','新增','Admin.Users.add','80'),
('15','12','3','编辑','Admin.Users.edit','70'),
('16','12','3','删除','Admin.Users.delete','60'),
('17','1','2','其他','Admin.Other','0'),
('18','17','3','数据库管理','Admin.Cogs.database','0'),
('19','17','3','服务器信息','Admin.Home.serverEnv','0'),
('20','1','2','菜单管理','Admin.Menus','60'),
('21','20','3','浏览','Admin.Menus.index','90'),
('22','20','3','新增','Admin.Menus.add','80'),
('23','20','3','编辑','Admin.Menus.edit','70'),
('24','20','3','删除','Admin.Menus.delete','60'),
('25','0','1','内容管理','Admin.Content','0'),
('26','25','2','轮播图片','Admin.Sliders','0'),
('27','26','3','浏览','Admin.Sliders.index','90'),
('28','26','3','新增','Admin.Sliders.add','80'),
('29','26','3','编辑','Admin.Sliders.edit','70'),
('30','26','3','删除','Admin.Sliders.delete','60'),
('31','25','2','网站栏目','Admin.SiteMenus','0'),
('32','31','3','浏览','Admin.SiteMenus.index','90'),
('33','31','3','新增','Admin.SiteMenus.add','80'),
('34','31','3','编辑','Admin.SiteMenus.edit','70'),
('35','31','3','删除','Admin.SiteMenus.delete','60'),
('36','25','2','单页/列表内容','Admin.Articles','0'),
('37','36','3','浏览','Admin.Articles.index','90'),
('38','36','3','新增','Admin.Articles.add','80'),
('39','36','3','编辑','Admin.Articles.edit','70'),
('40','36','3','删除','Admin.Articles.delete','60');

/*Table structure for table `site_menus` */

DROP TABLE IF EXISTS `site_menus`;

CREATE TABLE `site_menus` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '网站栏目表',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL COMMENT '栏目名称',
  `subname` varchar(30) DEFAULT NULL COMMENT '别名',
  `pic` varchar(100) DEFAULT NULL COMMENT 'banner图',
  `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '类型,1:单页, 2:列表',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态,1:显示，2:隐藏',
  `link` varchar(100) DEFAULT NULL COMMENT '外链',
  `sort` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `list_tpl` varchar(20) DEFAULT NULL COMMENT '列表模板',
  `content_tpl` varchar(20) NOT NULL COMMENT '内容模板',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id_index` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `site_menus` */

insert into `site_menus` (id,parent_id,name,subname,pic,type,status,link,sort,list_tpl,content_tpl,created,modified) values
('4','0','新闻中心','','','2','1','','0','list','list_view','2019-04-28 16:27:18','2019-04-29 15:30:00'),
('3','0','公司简介','info','files/image/20190428/5cc559ae7fa5f.jpg','1','1','','99','','single','2019-04-28 15:29:20','2019-04-28 16:27:36');

/*Table structure for table `sliders` */

DROP TABLE IF EXISTS `sliders`;

CREATE TABLE `sliders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '轮播图',
  `tag` varchar(20) NOT NULL COMMENT '标签，用于区分组',
  `pic` varchar(100) NOT NULL COMMENT '图片地址',
  `url` varchar(100) DEFAULT NULL COMMENT '跳转链接',
  `title` varchar(50) DEFAULT NULL COMMENT '标题',
  `sub` varchar(100) DEFAULT NULL COMMENT '描述',
  `sort` tinyint(2) NOT NULL DEFAULT '0' COMMENT '排序',
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tag_index` (`tag`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `sliders` */

insert into `sliders` (id,tag,pic,url,title,sub,sort,created) values
('4','home','files/image/20190429/5cc6b25e750b8.jpg','http://localhost:81/github/cakecms/page/index/3','','','0','2019-04-29 16:14:37'),
('2','home','files/image/20190429/5cc6ae5628078.jpg','','测','','0','2019-04-23 09:49:18');

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
('1','1','admin','$2y$10$HGHnQVGnUvLqKfOF3Yg0kuiV2XwMkp9OlzAlxdYc69sKoS.e.EgDG','超级管理员','1','32','::1','2019-04-04 14:01:29','2019-04-29 14:49:06'),
('2','2','test','$2y$10$m8dvZjdTipnzEIX/ulNWhOa7eS/X.HS/NGMxrTRJcdxX1P07yQi4O','测试员','1','14','::1','2019-04-17 14:13:45','2019-04-23 13:17:17');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
