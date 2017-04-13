# Host: localhost  (Version: 5.5.47)
# Date: 2017-02-23 12:45:36
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "wwh_admin"
#

DROP TABLE IF EXISTS `wwh_admin`;
CREATE TABLE `wwh_admin` (
  `admin_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员id ',
  `admin_name` varchar(30) NOT NULL COMMENT '管理员名称',
  `password` char(32) NOT NULL COMMENT '密码',
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='管理员';

#
# Data for table "wwh_admin"
#

INSERT INTO `wwh_admin` VALUES (0,'root','63a9f0ea7bb98050796b649e85481845'),(1,'123','202cb962ac59075b964b07152d234b70'),(2,'1234','81dc9bdb52d04dc20036dbd8313ed055'),(3,'12345','827ccb0eea8a706c4c34a16891f84e7b'),(4,'123456','e10adc3949ba59abbe56e057f20f883e');

#
# Structure for table "wwh_admin_role"
#

DROP TABLE IF EXISTS `wwh_admin_role`;
CREATE TABLE `wwh_admin_role` (
  `admin_id` mediumint(8) unsigned NOT NULL COMMENT '管理员id ',
  `role_id` mediumint(8) unsigned NOT NULL COMMENT '角色id ',
  KEY `admin_id` (`admin_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员-角色';

#
# Data for table "wwh_admin_role"
#

INSERT INTO `wwh_admin_role` VALUES (1,1),(1,2),(3,2),(4,1),(2,1),(2,3),(2,4);

#
# Structure for table "wwh_attribute"
#

DROP TABLE IF EXISTS `wwh_attribute`;
CREATE TABLE `wwh_attribute` (
  `attr_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '属性id',
  `attr_name` varchar(30) NOT NULL COMMENT '属性名称',
  `attr_type` enum('唯一','可选') NOT NULL COMMENT '属性类型',
  `attr_option_value` varchar(300) NOT NULL DEFAULT '' COMMENT '属性可选值',
  `type_id` mediumint(8) unsigned NOT NULL COMMENT '类型id',
  PRIMARY KEY (`attr_id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='属性类型';

#
# Data for table "wwh_attribute"
#

INSERT INTO `wwh_attribute` VALUES (2,'颜色','可选','富士白,玫瑰金,土豪金',1),(4,'厂商','唯一','',1),(5,'出版社','唯一','铁道出版社,人民出版社,商务出版社',2),(6,'操作系统','可选','ios,wp,安卓',1),(7,'作者','唯一','',2),(8,'屏幕尺寸','唯一','',1),(9,'尺寸','可选','12寸,15寸,18寸',2);

#
# Structure for table "wwh_authority"
#

DROP TABLE IF EXISTS `wwh_authority`;
CREATE TABLE `wwh_authority` (
  `auth_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '权限id ',
  `auth_name` varchar(30) NOT NULL COMMENT '权限名称 ',
  `module` varchar(30) NOT NULL DEFAULT '' COMMENT '模块',
  `controller` varchar(30) NOT NULL DEFAULT '' COMMENT '控制器',
  `action` varchar(30) NOT NULL DEFAULT '' COMMENT '操作方法',
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
  PRIMARY KEY (`auth_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COMMENT='权限';

#
# Data for table "wwh_authority"
#

INSERT INTO `wwh_authority` VALUES (1,'商品模块','','','',0),(2,'商品列表','Admin','Goods','lst',1),(3,'添加商品','Admin','Goods','add',2),(4,'修改商品','Admin','Goods','edit',2),(5,'删除商品','Admin','Goods','delete',2),(6,'分类列表','Admin','Category','lst',1),(7,'添加分类','Admin','Category','add',6),(8,'修改分类','Admin','Category','edit',6),(9,'删除分类','Admin','Category','delete',6),(10,'RBAC','','','',0),(11,'权限列表','Admin','Authority','lst',10),(12,'添加权限','Privilege','Admin','add',11),(13,'修改权限','Admin','Authority','edit',11),(14,'删除权限','Admin','Authority','delete',11),(15,'角色列表','Admin','Role','lst',10),(16,'添加角色','Admin','Role','add',15),(17,'修改角色','Admin','Role','edit',15),(18,'删除角色','Admin','Role','delete',15),(19,'管理员列表','Admin','Admin','lst',10),(20,'添加管理员','Admin','Admin','add',19),(21,'修改管理员','Admin','Admin','edit',19),(22,'删除管理员','Admin','Admin','delete',19),(23,'类型列表','Admin','Type','lst',1),(24,'添加类型','Admin','Type','add',23),(25,'修改类型','Admin','Type','edit',23),(26,'删除类型','Admin','Type','delete',23),(27,'属性列表','Admin','Attribute','lst',23),(28,'添加属性','Admin','Attribute','add',27),(29,'修改属性','Admin','Attribute','edit',27),(30,'删除属性','Admin','Attribute','delete',27),(31,'ajax删除商品属性','Admin','Goods','ajaxDelGoodsAttr',4),(32,'ajax删除商品相册图片','Admin','Goods','ajaxDelImage',4),(33,'会员管理','','','',0),(34,'会员级别列表','Admin','MemberLevel','lst',33),(35,'添加会员级别','Admin','MemberLevel','add',34),(36,'修改会员级别','Admin','MemberLevel','edit',34),(37,'删除会员级别','Admin','MemberLevel','delete',34),(38,'品牌列表','Admin','Brand','lst',1);

#
# Structure for table "wwh_brand"
#

DROP TABLE IF EXISTS `wwh_brand`;
CREATE TABLE `wwh_brand` (
  `brand_id` mediumint(9) NOT NULL AUTO_INCREMENT COMMENT '品牌id',
  `brand_name` varchar(30) NOT NULL COMMENT '品牌名称',
  `site_url` varchar(150) NOT NULL DEFAULT '' COMMENT '官方网址',
  `logo` varchar(150) NOT NULL DEFAULT '' COMMENT '品牌logo',
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='品牌';

#
# Data for table "wwh_brand"
#

INSERT INTO `wwh_brand` VALUES (1,'小米','www.xiaomi.com','Brand/2016-11-30/583ee2fe9a6a0.jpg'),(2,'酷派','kupai.com','Brand/2016-11-30/583ee944e2a63.jpg'),(4,'魅族','www.meizu.com','Brand/2016-11-30/583ee9189a7f5.jpg'),(5,'www','','Brand/2016-12-18/58567781c9fad.gif'),(6,'戴尔','www.zhongtong.com','Brand/2016-12-18/585679e5187af.gif'),(9,'erwer','','');

#
# Structure for table "wwh_cart"
#

DROP TABLE IF EXISTS `wwh_cart`;
CREATE TABLE `wwh_cart` (
  `cart_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `member_id` mediumint(8) unsigned NOT NULL COMMENT '会员id ',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品id',
  `goods_attr_id` varchar(50) NOT NULL DEFAULT '' COMMENT '商品属性id',
  `shop_number` mediumint(8) unsigned NOT NULL COMMENT '购买数量',
  PRIMARY KEY (`cart_id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='购物车';

#
# Data for table "wwh_cart"
#


#
# Structure for table "wwh_category"
#

DROP TABLE IF EXISTS `wwh_category`;
CREATE TABLE `wwh_category` (
  `cat_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `cat_name` varchar(30) NOT NULL COMMENT '分类名称',
  `pid` mediumint(8) unsigned NOT NULL COMMENT '父级id',
  `is_floor` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否推荐到楼层',
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='商品分类';

#
# Data for table "wwh_category"
#

INSERT INTO `wwh_category` VALUES (1,'家用电器',0,'是'),(2,'手机、数码、京东通信',0,'是'),(3,'电脑、办公',0,'是'),(4,'家居、家具、家装、厨具',0,'是'),(5,'男装、女装、内衣、珠宝',0,'否'),(6,'个护化妆',0,'否'),(8,'运动户外',0,'否'),(9,'汽车、汽车用品',0,'否'),(10,'母婴、玩具乐器',0,'否'),(11,'食品、酒类、生鲜、特产',0,'否'),(12,'营养保健',0,'否'),(13,'图书、音像、电子书',0,'否'),(14,'彩票、旅行、充值、票务',0,'否'),(15,'理财、众筹、白条、保险',0,'否'),(16,'大家电',1,'是'),(17,'生活电器',1,'否'),(18,'厨房电器',1,'否'),(19,'个护健康',1,'是'),(20,'五金家装',1,'是'),(21,'iphone',2,'否'),(22,'冰箱',16,'否'),(23,'大空调',16,'是'),(25,'佳能',2,'否'),(26,'电信sm卡',2,'是');

#
# Structure for table "wwh_comment"
#

DROP TABLE IF EXISTS `wwh_comment`;
CREATE TABLE `wwh_comment` (
  `comment_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论id',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品id',
  `member_id` mediumint(8) unsigned NOT NULL COMMENT '会员id',
  `comment_content` varchar(200) NOT NULL COMMENT '评论内容 ',
  `level` tinyint(3) unsigned NOT NULL COMMENT '评价级别1-5 ',
  `agree_count` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '赞同次数',
  `add_time` datetime NOT NULL COMMENT '评论时间',
  PRIMARY KEY (`comment_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COMMENT='商品评论表';

#
# Data for table "wwh_comment"
#

INSERT INTO `wwh_comment` VALUES (1,90,6,'测试一次',3,0,'2016-12-29 20:00:29'),(2,90,6,'测试一次',3,0,'2016-12-29 20:01:38'),(3,90,6,'为什么',4,0,'2016-12-29 20:22:29'),(4,90,6,'为什么',4,0,'2016-12-29 20:22:35'),(5,90,6,'为什么',4,0,'2016-12-29 20:22:49'),(6,90,6,'水电费',4,0,'2016-12-29 20:23:37'),(7,90,6,'水电费',3,0,'2016-12-29 20:23:45'),(8,90,6,'水电费而是公司的',5,0,'2016-12-29 20:23:58'),(9,90,6,'动画效果测试',5,0,'2016-12-29 20:33:29'),(10,90,6,'动画效果测试',5,0,'2016-12-29 20:34:29'),(11,90,6,'时代发生的',5,0,'2016-12-29 20:36:11'),(12,90,6,'而非为',5,0,'2016-12-29 20:37:35'),(13,90,6,'而是公司的',4,0,'2016-12-29 20:39:33'),(14,90,6,'水电费',5,0,'2016-12-29 20:42:14'),(15,90,6,'文体委',5,0,'2016-12-29 20:45:33'),(16,90,6,'文体委温柔',5,0,'2016-12-29 20:45:40'),(17,90,6,'文认为',5,0,'2016-12-29 20:46:11'),(18,90,6,'水电费',5,0,'2016-12-29 20:47:50'),(19,90,6,'双方的',3,0,'2016-12-29 20:48:35'),(20,90,6,'动画效果再次测试',5,0,'2016-12-29 20:50:06'),(21,90,6,'测试append是否可以追加jquery对象',5,0,'2016-12-29 20:51:44'),(22,90,6,'动画效果最终测试',5,0,'2016-12-29 20:53:44'),(23,90,5,'地方',5,0,'2015-12-30 09:33:26'),(24,91,5,'测试',5,0,'2015-12-30 09:51:19'),(25,91,5,'登陆弹出成功',5,0,'2015-12-30 09:51:35'),(26,91,5,'地方',5,0,'2015-12-30 09:53:45'),(27,18,5,'重置表单测试',4,0,'2015-12-30 09:56:00'),(28,90,5,'ajax翻页测试',5,0,'2015-12-30 11:40:32'),(29,21,5,'提交一条评论',5,0,'2015-12-30 11:47:33'),(30,21,5,'再来一条',3,0,'2015-12-30 11:47:44'),(31,90,5,'新发表的评论在最上方',5,0,'2015-12-30 11:49:16'),(32,18,5,'我要登录',5,0,'2015-12-30 14:22:10'),(33,18,5,'水电费',5,0,'2015-12-30 14:23:31'),(34,18,5,'水电费',5,0,'2015-12-30 14:23:38'),(35,18,5,'水电费',5,0,'2015-12-30 14:26:44'),(36,18,5,'双方都',5,0,'2015-12-30 14:27:03'),(37,18,5,',,，，，,,,',5,0,'2015-12-30 14:27:23'),(38,18,5,'gdgdfg',5,0,'2015-12-30 14:27:46'),(39,18,5,'wer',4,0,'2015-12-30 14:28:59'),(40,18,5,'sdf',4,0,'2015-12-30 14:29:08'),(41,18,5,'sdf',1,0,'2015-12-30 14:29:43'),(42,90,5,'很差劲',2,0,'2015-12-30 15:15:09'),(43,90,5,'印象测试',5,0,'2015-12-30 15:16:15'),(44,90,5,'测试',5,0,'2015-12-30 15:16:33'),(45,90,5,'大气',5,0,'2016-12-30 20:59:37'),(46,90,5,'dfsdfd',5,0,'2016-12-30 21:32:20'),(47,90,5,'sdf',5,0,'2016-12-30 21:32:27'),(48,90,5,'sdf',5,0,'2016-12-30 21:34:43'),(49,90,5,'sdfsd',5,0,'2016-12-30 21:35:00'),(50,90,5,'回复数量测试',5,0,'2016-12-30 21:40:36');

#
# Structure for table "wwh_goods"
#

DROP TABLE IF EXISTS `wwh_goods`;
CREATE TABLE `wwh_goods` (
  `goods_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `goods_name` varchar(150) NOT NULL COMMENT '商品名称',
  `market_price` decimal(10,2) NOT NULL COMMENT '市场价格',
  `shop_price` decimal(10,2) NOT NULL COMMENT '本店价格',
  `goods_desc` longtext COMMENT '商品描述',
  `promote_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '促销价格',
  `promote_start_date` datetime NOT NULL COMMENT '促销开始时间',
  `promote_end_date` datetime NOT NULL COMMENT '促销结束时间',
  `sort_num` smallint(5) unsigned NOT NULL DEFAULT '100' COMMENT '商品排序字段',
  `is_onsale` enum('是','否') NOT NULL DEFAULT '是' COMMENT '是否上架',
  `is_hot` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否热卖',
  `is_best` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否精品',
  `is_new` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否新品',
  `is_update` enum('1','0') NOT NULL DEFAULT '0' COMMENT '是否修改了字段',
  `is_ondelete` enum('1','0') NOT NULL DEFAULT '1' COMMENT '是否放入回收站',
  `goods_img` varchar(150) NOT NULL COMMENT '原图',
  `sm_goods_img` varchar(150) NOT NULL COMMENT '小图',
  `mid_goods_img` varchar(150) NOT NULL COMMENT '中图',
  `big_goods_img` varchar(150) NOT NULL COMMENT '大图',
  `mbig_goods_img` varchar(150) NOT NULL COMMENT '特大图',
  `brand_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '品牌id',
  `cat_id` mediumint(8) unsigned NOT NULL COMMENT '分类id',
  `type_id` mediumint(8) unsigned NOT NULL COMMENT '属性类型id',
  `addtime` datetime NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`goods_id`),
  KEY `shop_price` (`shop_price`),
  KEY `addtime` (`addtime`),
  KEY `brand_id` (`brand_id`),
  KEY `cat_id` (`cat_id`),
  KEY `is_onsale` (`is_onsale`) USING BTREE,
  KEY `promote_price` (`promote_price`) USING BTREE,
  KEY `promote_end_date` (`promote_end_date`) USING BTREE,
  KEY `is_new` (`is_new`),
  KEY `is_hot` (`is_hot`),
  KEY `is_best` (`is_best`),
  KEY `sort_num` (`sort_num`),
  KEY `promote_start_date` (`promote_start_date`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8;

#
# Data for table "wwh_goods"
#

INSERT INTO `wwh_goods` VALUES (18,'测试商品2',599.00,355.00,'<p>这只是一只考拉而已</p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',80,'是','是','是','是','0','1','Goods/2016-11-29/583d7adda462e.jpg','Goods/2016-11-29/sm_583d7adda462e.jpg','Goods/2016-11-29/mid_583d7adda462e.jpg','Goods/2016-11-29/big_583d7adda462e.jpg','Goods/2016-11-29/mbig_583d7adda462e.jpg',6,21,0,'2016-11-29 20:56:04'),(19,'测试商品3',0.00,233.00,'<p>                                                           </p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','是','否','0','1','Goods/2016-11-29/583d7b0d284b3.jpg','Goods/2016-11-29/sm_583d7b0d284b3.jpg','Goods/2016-11-29/mid_583d7b0d284b3.jpg','Goods/2016-11-29/big_583d7b0d284b3.jpg','Goods/2016-11-29/mbig_583d7b0d284b3.jpg',0,19,0,'2016-11-29 20:56:51'),(20,'测试商品4',0.00,5555.00,'<p>                                                           </p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','是','否','否','0','1','Goods/2016-11-29/583d7b2cc9615.jpg','Goods/2016-11-29/sm_583d7b2cc9615.jpg','Goods/2016-11-29/mid_583d7b2cc9615.jpg','Goods/2016-11-29/big_583d7b2cc9615.jpg','Goods/2016-11-29/mbig_583d7b2cc9615.jpg',0,0,0,'2016-11-29 20:57:24'),(21,'测试商品6',0.00,333.00,'<p>                                                           </p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',80,'是','是','否','否','0','1','Goods/2016-11-29/583d7b4ccacdc.jpg','Goods/2016-11-29/sm_583d7b4ccacdc.jpg','Goods/2016-11-29/mid_583d7b4ccacdc.jpg','Goods/2016-11-29/big_583d7b4ccacdc.jpg','Goods/2016-11-29/mbig_583d7b4ccacdc.jpg',0,0,0,'2016-11-29 20:57:51'),(23,'17',0.00,355.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',0,0,0,'2016-11-29 20:58:47'),(24,'3teddsf',0.00,666.00,'<p>                                                           </p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','是','是','0','1','Goods/2016-11-29/583d7b9c880bc.jpg','Goods/2016-11-29/sm_583d7b9c880bc.jpg','Goods/2016-11-29/mid_583d7b9c880bc.jpg','Goods/2016-11-29/big_583d7b9c880bc.jpg','Goods/2016-11-29/mbig_583d7b9c880bc.jpg',0,3,0,'2016-11-29 20:59:11'),(26,'dsfdsf',0.00,444.00,'<p>wfrasfasf</p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','是','0','1','Goods/2016-11-29/583d7bec8c94d.jpg','Goods/2016-11-29/sm_583d7bec8c94d.jpg','Goods/2016-11-29/mid_583d7bec8c94d.jpg','Goods/2016-11-29/big_583d7bec8c94d.jpg','Goods/2016-11-29/mbig_583d7bec8c94d.jpg',0,25,0,'2016-11-29 21:00:35'),(27,'233',0.00,355.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',0,0,0,'2016-11-29 21:34:45'),(28,'233',0.00,233.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',0,0,0,'2016-11-29 23:21:50'),(29,'srrf',0.00,2333.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',0,0,0,'2016-11-29 23:27:10'),(30,'fdsf',233.00,0.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',0,0,0,'2016-11-29 23:27:29'),(31,'ret',0.00,444.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',0,0,0,'2016-11-29 23:28:35'),(32,'344444',0.00,53.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',0,0,0,'2016-11-29 23:30:14'),(33,'344444',0.00,53.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',0,0,0,'2016-11-29 23:30:50'),(34,'344444',0.00,53.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',0,0,0,'2016-11-29 23:31:07'),(35,'errrer',0.00,0.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',0,0,0,'2016-11-29 23:34:28'),(36,'sss',34.00,53.00,'<p>                                                   </p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','Goods/2016-11-30/583ea26ad880a.jpg','Goods/2016-11-30/thumb_0_583ea26ad880a.jpg','Goods/2016-11-30/thumb_1_583ea26ad880a.jpg','Goods/2016-11-30/thumb_2_583ea26ad880a.jpg','Goods/2016-11-30/thumb_2_583ea26ad880a.jpg',2,0,0,'2016-11-30 17:57:04'),(37,'小米3',23.00,21.00,'<p>小米3 ;<br /></p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','Goods/2016-12-01/583f9ad61312d.jpg','Goods/2016-12-01/thumb_3_583f9ad61312d.jpg','Goods/2016-12-01/thumb_2_583f9ad61312d.jpg','Goods/2016-12-01/thumb_1_583f9ad61312d.jpg','Goods/2016-12-01/thumb_0_583f9ad61312d.jpg',1,0,0,'2016-12-01 11:36:56'),(38,'魅蓝3s',244.00,2424.00,'<p>                                                   </p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',4,0,0,'2016-12-01 11:39:27'),(40,'小妮3',344.00,300.00,'<p>小米3为发烧而<strong>生,是我用的最久的一步手机了</strong></p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','Goods/2016-12-01/584011f8100e7.jpg','Goods/2016-12-01/thumb_3_584011f8100e7.jpg','Goods/2016-12-01/thumb_2_584011f8100e7.jpg','Goods/2016-12-01/thumb_1_584011f8100e7.jpg','Goods/2016-12-01/thumb_0_584011f8100e7.jpg',1,0,0,'2016-12-01 20:05:21'),(42,'酷派大神f1',1599.00,999.00,'<p style=\"text-align:center;\"><strong>酷派,生来不同</strong></p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','Goods/2016-12-01/58402df570aff.jpg','Goods/2016-12-01/thumb_3_58402df570aff.jpg','Goods/2016-12-01/thumb_2_58402df570aff.jpg','Goods/2016-12-01/thumb_1_58402df570aff.jpg','Goods/2016-12-01/thumb_0_58402df570aff.jpg',4,0,0,'2016-12-01 22:04:41'),(43,'233',23.00,344.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',1,0,0,'2016-12-01 22:08:35'),(44,'23',44.00,44.00,'<p>234234</p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','Goods/2016-12-01/58402ef69c327.jpg','Goods/2016-12-01/thumb_3_58402ef69c327.jpg','Goods/2016-12-01/thumb_2_58402ef69c327.jpg','Goods/2016-12-01/thumb_1_58402ef69c327.jpg','Goods/2016-12-01/thumb_0_58402ef69c327.jpg',2,0,0,'2016-12-01 22:08:58'),(45,'23',44.00,44.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',1,0,0,'2016-12-01 22:09:27'),(46,'酷派大神分',233.00,244.00,'<p style=\"text-align:center;\">s的菲利克斯据了解</p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','Goods/2016-12-01/58402f775e795.jpg','Goods/2016-12-01/thumb_3_58402f775e795.jpg','Goods/2016-12-01/thumb_2_58402f775e795.jpg','Goods/2016-12-01/thumb_1_58402f775e795.jpg','Goods/2016-12-01/thumb_0_58402f775e795.jpg',2,0,0,'2016-12-01 22:11:05'),(47,'小米3',234.00,244.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',1,0,0,'2016-12-01 22:13:05'),(48,'吊死扶伤',233.00,242.00,'<p>文认为</p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','Goods/2016-12-01/5840300c339d5.jpg','Goods/2016-12-01/thumb_3_5840300c339d5.jpg','Goods/2016-12-01/thumb_2_5840300c339d5.jpg','Goods/2016-12-01/thumb_1_5840300c339d5.jpg','Goods/2016-12-01/thumb_0_5840300c339d5.jpg',1,0,0,'2016-12-01 22:13:33'),(50,'233',23.00,23.00,'<p>weqw</p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','Goods/2016-12-01/58403099722e3.jpg','Goods/2016-12-01/thumb_3_58403099722e3.jpg','Goods/2016-12-01/thumb_2_58403099722e3.jpg','Goods/2016-12-01/thumb_1_58403099722e3.jpg','Goods/2016-12-01/thumb_0_58403099722e3.jpg',1,0,0,'2016-12-01 22:15:54'),(51,'233',23.00,23.00,'<p>weqw</p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','Goods/2016-12-01/5840309a4c983.jpg','Goods/2016-12-01/thumb_3_5840309a4c983.jpg','Goods/2016-12-01/thumb_2_5840309a4c983.jpg','Goods/2016-12-01/thumb_1_5840309a4c983.jpg','Goods/2016-12-01/thumb_0_5840309a4c983.jpg',1,0,0,'2016-12-01 22:15:56'),(53,'4353',345.00,453.00,'<p>erte</p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','Goods/2016-12-01/584030c760c63.jpg','Goods/2016-12-01/thumb_3_584030c760c63.jpg','Goods/2016-12-01/thumb_2_584030c760c63.jpg','Goods/2016-12-01/thumb_1_584030c760c63.jpg','Goods/2016-12-01/thumb_0_584030c760c63.jpg',1,0,0,'2016-12-01 22:16:40'),(55,'4353',345.00,444.00,'<p>erte</p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','Goods/2016-12-02/5840e0f3a4083.jpg','Goods/2016-12-02/thumb_3_5840e0f3a4083.jpg','Goods/2016-12-02/thumb_2_5840e0f3a4083.jpg','Goods/2016-12-02/thumb_1_5840e0f3a4083.jpg','Goods/2016-12-02/thumb_0_5840e0f3a4083.jpg',1,0,0,'2016-12-01 22:16:44'),(57,'233',444.00,343.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',1,0,0,'2016-12-02 14:14:47'),(58,'233',444.00,343.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',1,0,0,'2016-12-02 14:18:02'),(59,'233',444.00,343.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',1,0,0,'2016-12-02 14:18:33'),(60,'233',444.00,343.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',1,0,0,'2016-12-02 14:19:17'),(61,'233',444.00,343.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',1,0,0,'2016-12-02 14:21:47'),(62,'233',444.00,343.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',1,0,0,'2016-12-02 14:23:38'),(67,'酷派2',999.00,995.00,'<p> 这是对商品相册添加的测试 </p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','Goods/2016-12-02/584128528221e.jpg','Goods/2016-12-02/thumb_3_584128528221e.jpg','Goods/2016-12-02/thumb_2_584128528221e.jpg','Goods/2016-12-02/thumb_1_584128528221e.jpg','Goods/2016-12-02/thumb_0_584128528221e.jpg',2,0,0,'2016-12-02 15:52:52'),(68,'233',23.00,323.00,'<p>213123<br /></p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',4,0,0,'2016-12-02 19:40:39'),(69,'233',11.00,233.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',1,0,0,'2016-12-02 19:46:31'),(70,'233',233.00,233.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',0,0,0,'2016-12-02 19:51:40'),(71,'233',244.00,233.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',0,0,0,'2016-12-02 20:01:46'),(72,'ipOne 7',2222.00,2222.00,'<p>                                                           </p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','Goods/2016-12-03/5842dd15721b7.jpg','Goods/2016-12-03/thumb_3_5842dd15721b7.jpg','Goods/2016-12-03/thumb_2_5842dd15721b7.jpg','Goods/2016-12-03/thumb_1_5842dd15721b7.jpg','Goods/2016-12-03/thumb_0_5842dd15721b7.jpg',2,2,0,'2016-12-03 22:56:24'),(73,'233',23.00,23.00,'<p>                                                           </p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',70,'是','否','是','否','0','1','Goods/2016-12-18/585671857bf11.jpg','Goods/2016-12-18/thumb_3_585671857bf11.jpg','Goods/2016-12-18/thumb_2_585671857bf11.jpg','Goods/2016-12-18/thumb_1_585671857bf11.jpg','Goods/2016-12-18/thumb_0_585671857bf11.jpg',1,20,2,'2016-12-04 13:24:34'),(74,'sdfs',3.00,42.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',1,18,0,'2016-12-04 13:26:34'),(76,'233',233.00,233.00,'<p>                                                           </p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',1,1,0,'2016-12-04 13:37:23'),(77,'231',123.00,123.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',1,1,0,'2016-12-04 13:38:48'),(79,'244',233.00,244.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',1,16,0,'2016-12-04 15:33:28'),(80,'245',235.00,235.00,'<p>                                                           </p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',2,16,0,'2016-12-04 15:34:45'),(81,'244',24.00,244.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',2,22,0,'2016-12-04 21:51:21'),(82,'srrf',355.00,544.00,'<p>                                                           </p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','是','否','0','1','Goods/2016-12-18/58565ebd7c5a2.jpg','Goods/2016-12-18/thumb_3_58565ebd7c5a2.jpg','Goods/2016-12-18/thumb_2_58565ebd7c5a2.jpg','Goods/2016-12-18/thumb_1_58565ebd7c5a2.jpg','Goods/2016-12-18/thumb_0_58565ebd7c5a2.jpg',1,11,2,'2016-12-04 21:52:02'),(83,'233',332.00,44.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',0,22,0,'2016-12-08 08:06:01'),(84,'233',332.00,44.00,'<p>                                                           </p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','是','否','0','1','Goods/2016-12-18/58565ea3667e4.jpg','Goods/2016-12-18/thumb_3_58565ea3667e4.jpg','Goods/2016-12-18/thumb_2_58565ea3667e4.jpg','Goods/2016-12-18/thumb_1_58565ea3667e4.jpg','Goods/2016-12-18/thumb_0_58565ea3667e4.jpg',6,22,0,'2016-12-08 08:09:48'),(88,'酷派背包',244.00,230.00,'<p>                               <span style=\"font-size:48px;\"><strong><span style=\"color:#4bacc6;font-family:\'楷体\', \'楷体_GB2312\', SimKai;\">佳能,感动常在</span></strong></span></p><p style=\"text-align:center;\"><span style=\"font-size:48px;\"><strong><span style=\"color:#4bacc6;font-family:\'楷体\', \'楷体_GB2312\', SimKai;\"><img src=\"http://localhost/wwh_shop/Public/umeditor1_2_2-utf8-php/php/upload/20161220/14822444415908.jpg\" alt=\"14822444415908.jpg\" /> </span></strong></span></p><p><span style=\"font-family:\'隶书\', SimLi;color:#ff0000;\"><span style=\"font-size:48px;\"><strong>吾王剑之所指,吾等心之所向!</strong></span></span></p><p style=\"text-align:left;\"><span style=\"font-size:48px;\"><strong><span style=\"color:#4bacc6;font-family:\'楷体\', \'楷体_GB2312\', SimKai;\"><br /></span></strong></span></p>',220.00,'2016-12-21 17:31:00','2016-12-31 20:36:00',100,'是','是','是','是','0','1','Goods/2016-12-20/58591487c2688.jpg','Goods/2016-12-20/thumb_3_58591487c2688.jpg','Goods/2016-12-20/thumb_2_58591487c2688.jpg','Goods/2016-12-20/thumb_1_58591487c2688.jpg','Goods/2016-12-20/thumb_0_58591487c2688.jpg',2,8,1,'2016-12-08 08:32:54'),(89,'钢之炼金术师',24.00,42.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',0,13,2,'2016-12-09 08:50:14'),(90,'呜呜呜',233.00,233.00,'<p>                                                           </p>',123.00,'2016-12-17 00:00:00','2016-12-31 00:00:00',100,'是','否','是','否','0','1','Goods/2016-12-18/5856019b08460.jpg','Goods/2016-12-18/thumb_3_5856019b08460.jpg','Goods/2016-12-18/thumb_2_5856019b08460.jpg','Goods/2016-12-18/thumb_1_5856019b08460.jpg','Goods/2016-12-18/thumb_0_5856019b08460.jpg',5,26,1,'2016-12-18 10:11:22'),(91,'我问问',123.00,123.00,'<p>                                                           </p>',99.00,'2016-12-17 00:00:00','2016-12-19 00:00:00',90,'是','否','是','否','0','1','Goods/2016-12-18/585601890dfe4.jpg','Goods/2016-12-18/thumb_3_585601890dfe4.jpg','Goods/2016-12-18/thumb_2_585601890dfe4.jpg','Goods/2016-12-18/thumb_1_585601890dfe4.jpg','Goods/2016-12-18/thumb_0_585601890dfe4.jpg',1,18,0,'2016-12-18 11:25:00'),(92,'去去去',233.00,222.00,'<p>                                                           </p>',222.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',80,'是','否','否','是','0','1','Goods/2016-12-18/5856123740b2f.jpg','Goods/2016-12-18/thumb_3_5856123740b2f.jpg','Goods/2016-12-18/thumb_2_5856123740b2f.jpg','Goods/2016-12-18/thumb_1_5856123740b2f.jpg','Goods/2016-12-18/thumb_0_5856123740b2f.jpg',1,17,0,'2016-12-18 12:36:07'),(93,'233',233.00,233.00,'<p>                                                           </p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',0,26,0,'2016-12-21 15:54:19'),(94,'小王',23.00,23.00,'<p>                                                           </p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','','1','Goods/2016-12-27/58625aaacc13e.jpg','Goods/2016-12-27/thumb_3_58625aaacc13e.jpg','Goods/2016-12-27/thumb_2_58625aaacc13e.jpg','Goods/2016-12-27/thumb_1_58625aaacc13e.jpg','Goods/2016-12-27/thumb_0_58625aaacc13e.jpg',2,20,1,'2016-12-27 20:12:07'),(95,'雅诗',233.00,230.00,'<p>                                                           </p>',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','','1','','','','','',6,17,2,'2016-12-27 20:13:35'),(96,'小爱',23.00,23.00,'',23.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',1,16,0,'2017-01-01 15:46:49'),(97,'雅诗2',0.00,233.00,'',0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00',100,'是','否','否','否','0','1','','','','','',0,16,0,'2017-01-01 17:06:25');

#
# Structure for table "wwh_goods_attr"
#

DROP TABLE IF EXISTS `wwh_goods_attr`;
CREATE TABLE `wwh_goods_attr` (
  `goods_attr_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品-属性id',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品id',
  `attr_id` mediumint(8) unsigned NOT NULL COMMENT '属性id',
  `attr_value` varchar(150) NOT NULL COMMENT '属性值',
  PRIMARY KEY (`goods_attr_id`),
  KEY `goods_id` (`goods_id`),
  KEY `attr_id` (`attr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 COMMENT='商品-属性';

#
# Data for table "wwh_goods_attr"
#

INSERT INTO `wwh_goods_attr` VALUES (9,88,2,'土豪金'),(10,88,2,'富士白'),(11,88,4,'富士康'),(12,88,6,'ios'),(13,88,6,'安卓'),(48,88,8,'5.6'),(49,89,5,'人民出版社'),(50,89,7,'爱德华'),(51,89,9,'12寸'),(52,94,2,'富士白'),(53,94,2,'土豪金'),(54,94,4,'比亚迪'),(55,94,6,'wp'),(56,94,6,'安卓'),(57,94,8,'7.0'),(58,95,5,'人民出版社'),(59,95,7,'郭德岗'),(60,95,9,'18寸'),(61,90,2,'富士白'),(62,90,2,'玫瑰金'),(63,90,4,'小黄'),(64,90,6,'安卓'),(65,90,8,'5.5'),(66,82,5,'铁道出版社'),(67,82,7,'为中华'),(68,82,9,'15寸'),(69,73,7,'莫言');

#
# Structure for table "wwh_goods_cat"
#

DROP TABLE IF EXISTS `wwh_goods_cat`;
CREATE TABLE `wwh_goods_cat` (
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品id',
  `cat_id` mediumint(8) unsigned NOT NULL COMMENT '分类id',
  KEY `goods_id` (`goods_id`),
  KEY `cat` (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='扩展分类';

#
# Data for table "wwh_goods_cat"
#

INSERT INTO `wwh_goods_cat` VALUES (79,20),(79,0),(91,22),(88,20),(90,2),(82,21),(82,19);

#
# Structure for table "wwh_goods_number"
#

DROP TABLE IF EXISTS `wwh_goods_number`;
CREATE TABLE `wwh_goods_number` (
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品id',
  `goods_number` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '库存量',
  `goods_attr_ids` varchar(150) NOT NULL COMMENT '属性值',
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='库存量';

#
# Data for table "wwh_goods_number"
#

INSERT INTO `wwh_goods_number` VALUES (88,91,'9,13'),(88,46,'9,12'),(88,100,'10,12'),(88,100,'10,13'),(91,54,''),(84,100,''),(90,43,'61,64'),(90,44,'62,64');

#
# Structure for table "wwh_goods_pic"
#

DROP TABLE IF EXISTS `wwh_goods_pic`;
CREATE TABLE `wwh_goods_pic` (
  `pic_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `pic` varchar(150) NOT NULL COMMENT '原图',
  `big_pic` varchar(150) NOT NULL COMMENT '大图',
  `mid_pic` varchar(150) NOT NULL COMMENT '中图',
  `sm_pic` varchar(150) NOT NULL COMMENT '小图',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品id',
  PRIMARY KEY (`pic_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='商品相册';

#
# Data for table "wwh_goods_pic"
#

INSERT INTO `wwh_goods_pic` VALUES (1,'goodsPic/2016-12-03/5842dd18e851e.jpg','goodsPic/2016-12-03/thumb_0_5842dd18e851e.jpg','goodsPic/2016-12-03/thumb_1_5842dd18e851e.jpg','goodsPic/2016-12-03/thumb_2_5842dd18e851e.jpg',72),(2,'goodsPic/2016-12-03/5842dd1b4217b.jpg','goodsPic/2016-12-03/thumb_0_5842dd1b4217b.jpg','goodsPic/2016-12-03/thumb_1_5842dd1b4217b.jpg','goodsPic/2016-12-03/thumb_2_5842dd1b4217b.jpg',72),(3,'goodsPic/2016-12-03/5842dd1fc6b97.jpg','goodsPic/2016-12-03/thumb_0_5842dd1fc6b97.jpg','goodsPic/2016-12-03/thumb_1_5842dd1fc6b97.jpg','goodsPic/2016-12-03/thumb_2_5842dd1fc6b97.jpg',72),(4,'goodsPic/2016-12-20/58591322b6192.jpg','goodsPic/2016-12-20/thumb_0_58591322b6192.jpg','goodsPic/2016-12-20/thumb_1_58591322b6192.jpg','goodsPic/2016-12-20/thumb_2_58591322b6192.jpg',88),(5,'goodsPic/2016-12-20/585913289cca3.jpg','goodsPic/2016-12-20/thumb_0_585913289cca3.jpg','goodsPic/2016-12-20/thumb_1_585913289cca3.jpg','goodsPic/2016-12-20/thumb_2_585913289cca3.jpg',88),(6,'goodsPic/2016-12-20/5859132cae2e4.jpg','goodsPic/2016-12-20/thumb_0_5859132cae2e4.jpg','goodsPic/2016-12-20/thumb_1_5859132cae2e4.jpg','goodsPic/2016-12-20/thumb_2_5859132cae2e4.jpg',88),(7,'goodsPic/2016-12-20/5859143c0ea3c.jpg','goodsPic/2016-12-20/thumb_0_5859143c0ea3c.jpg','goodsPic/2016-12-20/thumb_1_5859143c0ea3c.jpg','goodsPic/2016-12-20/thumb_2_5859143c0ea3c.jpg',88),(8,'goodsPic/2016-12-20/58591441dff33.jpg','goodsPic/2016-12-20/thumb_0_58591441dff33.jpg','goodsPic/2016-12-20/thumb_1_58591441dff33.jpg','goodsPic/2016-12-20/thumb_2_58591441dff33.jpg',88),(9,'goodsPic/2016-12-20/5859144558801.jpg','goodsPic/2016-12-20/thumb_0_5859144558801.jpg','goodsPic/2016-12-20/thumb_1_5859144558801.jpg','goodsPic/2016-12-20/thumb_2_5859144558801.jpg',88);

#
# Structure for table "wwh_max_goods_id"
#

DROP TABLE IF EXISTS `wwh_max_goods_id`;
CREATE TABLE `wwh_max_goods_id` (
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT 'shinx全文索引中的最大id',
  PRIMARY KEY (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "wwh_max_goods_id"
#

INSERT INTO `wwh_max_goods_id` VALUES (97);

#
# Structure for table "wwh_member"
#

DROP TABLE IF EXISTS `wwh_member`;
CREATE TABLE `wwh_member` (
  `member_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '会员id ',
  `member_name` varchar(30) NOT NULL COMMENT '会员名称',
  `password` char(32) NOT NULL COMMENT '密码',
  `face` varchar(150) NOT NULL DEFAULT '' COMMENT '头像',
  `jifen` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  PRIMARY KEY (`member_id`),
  KEY `jifen` (`jifen`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='会员';

#
# Data for table "wwh_member"
#

INSERT INTO `wwh_member` VALUES (5,'root','e10adc3949ba59abbe56e057f20f883e','/wwh_shop/Public/Home/images/user2.jpg',10017),(6,'1234','e10adc3949ba59abbe56e057f20f883e','/wwh_shop/Public/Home/images/user2.jpg',6666);

#
# Structure for table "wwh_member_level"
#

DROP TABLE IF EXISTS `wwh_member_level`;
CREATE TABLE `wwh_member_level` (
  `level_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '级别id',
  `level_name` varchar(30) NOT NULL COMMENT '级别名称',
  `jifen_bottom` mediumint(8) unsigned NOT NULL COMMENT '积分下限',
  `jifen_top` mediumint(8) unsigned NOT NULL COMMENT '积分上限',
  PRIMARY KEY (`level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='会员级别';

#
# Data for table "wwh_member_level"
#

INSERT INTO `wwh_member_level` VALUES (1,'注册会员',0,1000),(2,'银牌会员',1001,5000),(3,'金牌会员',5001,10000),(4,'钻石会员',10001,9999999);

#
# Structure for table "wwh_member_price"
#

DROP TABLE IF EXISTS `wwh_member_price`;
CREATE TABLE `wwh_member_price` (
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品id',
  `level_id` mediumint(8) unsigned NOT NULL COMMENT '级别id',
  `member_price` decimal(10,2) NOT NULL COMMENT '会员价格',
  KEY `goods_id` (`goods_id`),
  KEY `level_id` (`level_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员价格';

#
# Data for table "wwh_member_price"
#

INSERT INTO `wwh_member_price` VALUES (40,1,2424.00),(40,2,200.00),(40,3,100.00),(40,4,88.00),(41,1,959.00),(41,2,949.00),(41,3,939.00),(41,4,929.00),(42,1,959.00),(42,2,949.00),(42,3,939.00),(42,4,929.00),(45,1,342.00),(45,2,23.00),(45,3,234.00),(45,4,34.00),(46,1,242.00),(46,2,2342.00),(46,3,233.00),(46,4,2342.00),(47,1,2424.00),(47,2,2423.00),(47,3,2424.00),(47,4,233.00),(48,1,5233.00),(48,2,342.00),(48,3,2342.00),(48,4,23423.00),(50,1,32.00),(50,2,3.00),(50,3,23.00),(50,4,32.00),(51,1,32.00),(51,2,3.00),(51,3,23.00),(51,4,32.00),(53,1,453.00),(53,2,45.00),(53,3,345.00),(53,4,543.00),(55,1,8888.00),(55,2,88.00),(55,3,345.00),(55,4,88.00),(61,1,23.00),(61,2,232.00),(61,3,34.00),(61,4,2323.00),(62,1,23.00),(62,2,232.00),(62,3,34.00),(62,4,2323.00),(67,1,988.00),(67,2,977.00),(67,3,966.00),(67,4,955.00),(68,1,3.00),(68,2,23.00),(68,3,23.00),(68,4,33.00),(72,1,23.00),(72,2,24.00),(72,3,24.00),(72,4,4.00),(76,1,23.00),(76,2,24.00),(76,3,24.00),(76,4,4.00),(80,1,23.00),(80,2,24.00),(80,3,24.00),(80,4,4.00),(19,1,23.00),(19,2,24.00),(19,3,24.00),(19,4,4.00),(20,1,23.00),(20,2,24.00),(20,3,24.00),(20,4,4.00),(21,1,23.00),(21,2,24.00),(21,3,24.00),(21,4,4.00),(84,1,23.00),(84,2,24.00),(84,3,24.00),(84,4,4.00),(18,1,23.00),(18,2,24.00),(18,3,24.00),(18,4,4.00),(26,1,23.00),(26,2,24.00),(26,3,24.00),(26,4,4.00),(24,1,23.00),(24,2,24.00),(24,3,24.00),(24,4,4.00),(91,1,255.00),(91,2,255.00),(91,3,255.00),(91,4,255.00),(88,1,230.00),(88,2,225.00),(88,3,220.00),(88,4,215.00),(90,1,23.00),(90,2,24.00),(90,3,24.00),(90,4,4.00),(82,1,23.00),(82,2,24.00),(82,3,24.00),(82,4,4.00),(73,1,23.00),(73,2,24.00),(73,3,24.00),(73,4,4.00);

#
# Structure for table "wwh_order"
#

DROP TABLE IF EXISTS `wwh_order`;
CREATE TABLE `wwh_order` (
  `order_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `member_id` mediumint(8) unsigned NOT NULL COMMENT '会员id ',
  `shr_name` varchar(30) NOT NULL COMMENT '收货人姓名',
  `shr_tel` varchar(30) NOT NULL COMMENT '收货人手机',
  `shr_pr` varchar(30) NOT NULL COMMENT '所在省',
  `shr_city` varchar(30) NOT NULL COMMENT '所在市',
  `shr_area` varchar(30) NOT NULL COMMENT '所在区',
  `shr_address` varchar(150) NOT NULL COMMENT '收货人详细地址',
  `pay_way` enum('货到付款','在线支付') NOT NULL DEFAULT '货到付款' COMMENT '支付方式',
  `pay_time` int(10) unsigned NOT NULL COMMENT '支付时间',
  `add_time` int(10) unsigned NOT NULL COMMENT '下单时间',
  `pay_status` enum('是','否') NOT NULL DEFAULT '否' COMMENT '支付状态',
  `total_price` decimal(10,2) NOT NULL COMMENT '订单总价',
  `post_status` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '发货状态:0-未发货,1-已发货,2-已收到货',
  `post_number` varchar(30) NOT NULL DEFAULT '' COMMENT '快递单号',
  PRIMARY KEY (`order_id`),
  KEY `member_id` (`member_id`),
  KEY `add_time` (`add_time`)
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8 COMMENT='订单表';

#
# Data for table "wwh_order"
#

INSERT INTO `wwh_order` VALUES (92,5,'魏文豪','12345678901','北京','朝阳区','西三旗','sdsfsdfsd','货到付款',0,1482763905,'是',2807.00,'0',''),(93,5,'123','13168065609','北京','西城区','西三旗','sdsfsdfsd','货到付款',0,1482765382,'否',12.00,'0',''),(94,5,'魏文豪','12345678901','北京','朝阳区','西三旗','sdsfsdfsd','货到付款',0,1482763905,'否',2807.00,'0',''),(95,5,'魏文豪','12345678901','北京','朝阳区','西三旗','sdsfsdfsd','货到付款',0,1482763905,'否',2807.00,'0',''),(96,5,'魏文豪','12345678901','北京','朝阳区','西三旗','sdsfsdfsd','货到付款',0,1482763905,'否',2807.00,'0',''),(97,5,'魏文豪','12345678901','北京','朝阳区','西三旗','sdsfsdfsd','货到付款',0,1482763905,'否',2807.00,'0',''),(107,5,'魏文豪','12345678901','北京','朝阳区','西三旗','sdsfsdfsd','货到付款',0,1482763905,'是',2807.00,'0',''),(108,5,'魏文豪','12345678901','北京','朝阳区','西三旗','sdsfsdfsd','货到付款',0,1482763905,'是',2807.00,'0',''),(109,5,'魏文豪','12345678901','北京','朝阳区','西三旗','sdsfsdfsd','货到付款',0,1482763905,'是',2807.00,'0',''),(110,5,'魏文豪','12345678901','北京','朝阳区','西三旗','sdsfsdfsd','货到付款',0,1482763905,'是',2807.00,'0',''),(111,5,'魏文豪','12345678901','北京','朝阳区','西三旗','sdsfsdfsd','货到付款',0,1482763905,'是',2807.00,'0',''),(112,5,'魏文豪','12345678901','北京','朝阳区','西三旗','sdsfsdfsd','货到付款',0,1482763905,'是',2807.00,'0',''),(113,5,'魏文豪','12345678901','北京','朝阳区','西三旗','sdsfsdfsd','货到付款',0,1482763905,'是',2807.00,'0',''),(114,5,'魏文豪','12345678901','北京','东城区','西三旗','西三星期','货到付款',0,1482769880,'是',1290.00,'0',''),(115,5,'魏文豪','13168065609','北京','东城区','西三旗','西三星期','货到付款',0,1482916354,'是',1303.00,'0','');

#
# Structure for table "wwh_order_goods"
#

DROP TABLE IF EXISTS `wwh_order_goods`;
CREATE TABLE `wwh_order_goods` (
  `order_goods_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单商品id',
  `order_id` mediumint(8) unsigned NOT NULL COMMENT '订单id',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品id ',
  `goods_attr_id` varchar(30) NOT NULL DEFAULT '' COMMENT '商品属性id',
  `shop_number` mediumint(8) unsigned NOT NULL COMMENT '该商品的购买数量',
  `shop_price` decimal(10,2) NOT NULL COMMENT '单件商品购买价格',
  PRIMARY KEY (`order_goods_id`),
  KEY `order_id` (`order_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=175 DEFAULT CHARSET=utf8 COMMENT='订单-商品表';

#
# Data for table "wwh_order_goods"
#

INSERT INTO `wwh_order_goods` VALUES (166,92,90,'',5,12.00),(167,92,88,'9,12',2,150.00),(168,92,88,'9,13',1,129.00),(169,93,90,'',50,12.00),(170,114,88,'9,12',9,645.00),(171,114,88,'9,13',5,645.00),(172,115,90,'61,64',4,4.00),(173,115,90,'62,64',3,4.00),(174,115,91,'',5,255.00);

#
# Structure for table "wwh_reply"
#

DROP TABLE IF EXISTS `wwh_reply`;
CREATE TABLE `wwh_reply` (
  `reply_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '回复id',
  `comment_id` mediumint(8) unsigned NOT NULL COMMENT '评论id',
  `reply_content` varchar(200) NOT NULL COMMENT '回复内容 ',
  `add_time` datetime NOT NULL COMMENT '回复',
  PRIMARY KEY (`reply_id`),
  KEY `comment_id` (`comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='评论回复表';

#
# Data for table "wwh_reply"
#

INSERT INTO `wwh_reply` VALUES (1,50,'哈哈哈','0000-00-00 00:00:00'),(2,50,'二二而','0000-00-00 00:00:00');

#
# Structure for table "wwh_role"
#

DROP TABLE IF EXISTS `wwh_role`;
CREATE TABLE `wwh_role` (
  `role_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色id ',
  `role_name` varchar(30) NOT NULL COMMENT '角色名称',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='角色';

#
# Data for table "wwh_role"
#

INSERT INTO `wwh_role` VALUES (1,'商品管理员'),(2,'属性管理员'),(3,'类型管理员'),(4,'权限管理员');

#
# Structure for table "wwh_role_auth"
#

DROP TABLE IF EXISTS `wwh_role_auth`;
CREATE TABLE `wwh_role_auth` (
  `role_id` mediumint(8) unsigned NOT NULL COMMENT '角色id ',
  `auth_id` mediumint(8) unsigned NOT NULL COMMENT '权限id ',
  KEY `role_id` (`role_id`),
  KEY `auth_id` (`auth_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色-权限';

#
# Data for table "wwh_role_auth"
#

INSERT INTO `wwh_role_auth` VALUES (2,1),(2,23),(2,27),(2,28),(2,29),(2,30),(3,1),(3,23),(3,24),(3,25),(3,26),(3,27),(3,28),(3,29),(3,30),(4,10),(4,11),(4,12),(4,13),(4,14),(4,15),(4,16),(4,17),(4,18),(4,19),(4,20),(4,21),(4,22),(1,1),(1,2),(1,3);

#
# Structure for table "wwh_trait"
#

DROP TABLE IF EXISTS `wwh_trait`;
CREATE TABLE `wwh_trait` (
  `trait_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '印象id',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品id',
  `trait_name` varchar(15) NOT NULL COMMENT '印象名称',
  `trait_count` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '印象次数',
  PRIMARY KEY (`trait_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='商品印象表';

#
# Data for table "wwh_trait"
#

INSERT INTO `wwh_trait` VALUES (1,18,'我认为',2),(2,18,'玩儿',2),(3,18,'dsf',1),(4,18,'sdf',1),(5,90,'屏幕大',4),(6,90,'高级',2),(7,90,'大气',3),(8,90,'上档次',2);

#
# Structure for table "wwh_type"
#

DROP TABLE IF EXISTS `wwh_type`;
CREATE TABLE `wwh_type` (
  `type_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '类型id',
  `type_name` varchar(30) NOT NULL COMMENT '类型名称',
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='属性类型';

#
# Data for table "wwh_type"
#

INSERT INTO `wwh_type` VALUES (1,'手机'),(2,'书'),(3,'水瓶'),(4,'耳机');
