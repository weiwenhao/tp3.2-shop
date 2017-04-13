--创建goods表
CREATE TABLE `wwh_goods` (
`goods_id`  mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '商品id' ,
`goods_name`  varchar(150) NOT NULL COMMENT '商品名称' ,
`market_price`  decimal(10,2) NOT NULL COMMENT '市场价格' ,
`shop_price`  decimal(10,2) NOT NULL COMMENT '本店价格' ,
`goods_desc`  longtext NULL COMMENT '商品描述' ,
`is_on_sale`  enum('1','0') NOT NULL DEFAULT '1' COMMENT '是否上架' ,
`is_on_delete`  enum('1','0') NOT NULL DEFAULT '1' COMMENT '是否放入回收站' ,
`addtime`  datetime NOT NULL COMMENT '添加时间' ,
PRIMARY KEY (`goods_id`),
INDEX `shop_price` (`shop_price`) ,
INDEX `addtime` (`addtime`) ,
INDEX `is_on_sale` (`is_on_sale`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8
--更新goods表
ALTER TABLE `wwh_goods`
ADD COLUMN `goods_img`  varchar(150) NOT NULL COMMENT '原图' AFTER `is_on_delete`,
ADD COLUMN `sm_goods_img`  varchar(150) NOT NULL COMMENT '小图' AFTER `logo`,
ADD COLUMN `mid_goods_img`  varchar(150) NOT NULL COMMENT '中图' AFTER `sm_logo`,
ADD COLUMN `big_goods_img`  varchar(150) NOT NULL COMMENT '大图' AFTER `mid_logo`,
ADD COLUMN `mbig_goods_img`  varchar(150) NOT NULL COMMENT '特大图' AFTER `big_logo`


--创建brand表
DROP TABLE IF EXISTS wwh_brand;
CREATE TABLE `wwh_brand` (
`brand_id`  mediumint  UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '品牌id' ,
`brand_name`  varchar(30) NOT NULL COMMENT '品牌名称' ,
`site_url`  varchar(150) NOT NULL DEFAULT '' COMMENT '官方网址' ,
`logo`  varchar(150) NOT NULL DEFAULT '' COMMENT '品牌logo' ,
PRIMARY KEY (`brand_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8
COMMENT '品牌';

--为goods表增加brand_id字段
ALTER TABLE `wwh_goods`
ADD COLUMN `brand_id`  mediumint UNSIGNED NOT NULL AUTO_INCREMENT AFTER `mbig_goods_img`,
ADD INDEX `brand_id` (`brand_id`) ;


--会员级别表 级别id 级别名称 积分下限 积分上限 
DROP TABLE IF EXISTS wwh_member_level;
CREATE TABLE `wwh_member_level` (
`level_id`  mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '级别id' ,
`level_name`  varchar(30) NOT NULL COMMENT '级别名称' ,
`jifen_bottom`  mediumint UNSIGNED NOT NULL COMMENT '积分下限' ,
`jifen_top`  mediumint UNSIGNED NOT NULL COMMENT '积分上限' ,
PRIMARY KEY (`level_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8
COMMENT '会员级别';

--会员价格表  商品id 级别id 价格
DROP TABLE IF EXISTS wwh_member_price;
CREATE TABLE `wwh_member_price` (
`goods_id`  mediumint UNSIGNED NOT NULL COMMENT '商品id' ,
`level_id`  mediumint UNSIGNED NOT NULL COMMENT '级别id' ,
`member_price`  decimal(10,2) NOT NULL COMMENT '会员价格' ,
INDEX `goods_id` (`goods_id`) ,
INDEX `level_id` (`level_id`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8
COMMENT '会员价格';


--商品相册表
DROP TABLE IF EXISTS wwh_goods_pic;
CREATE TABLE `wwh_goods_pic` (
`pic_id`  mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id' ,
`pic` varchar(150) NOT NULL  COMMENT '原图' ,
`big_pic` varchar(150) NOT NULL  COMMENT '大图' ,
`mid_pic` varchar(150) NOT NULL  COMMENT '中图' ,
`sm_pic` varchar(150) NOT NULL  COMMENT '小图' ,
`goods_id`  mediumint UNSIGNED NOT NULL COMMENT '商品id' ,
PRIMARY KEY (pic_id),
KEY goods_id(goods_id)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8
COMMENT '商品相册';


--商品分类表
--创建brand表
DROP TABLE IF EXISTS wwh_category;
CREATE TABLE `wwh_category` (
`cat_id`  mediumint  UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分类id' ,
`cat_name`  varchar(30) NOT NULL COMMENT '分类名称' ,
`pid`  mediumint  UNSIGNED NOT NULL   COMMENT '父级id' ,
PRIMARY KEY (`cat_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8
COMMENT '商品分类';

--商品-分类表
DROP TABLE IF EXISTS wwh_goods_cat;
CREATE TABLE `wwh_goods_cat`(
`goods_id`  mediumint  UNSIGNED NOT NULL COMMENT '商品id' ,
`cat_id`  mediumint  UNSIGNED NOT NULL COMMENT '分类id' ,
KEY goods_id(`goods_id`),
KEY cat(`cat_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8
COMMENT '扩展分类';

--建立属性类型表
CREATE TABLE `wwh_attr_type`(
`type_id`  mediumint  UNSIGNED NOT NULL  AUTO_INCREMENT COMMENT '类型id' ,
`type_name`  VARCHAR(30) NOT NULL COMMENT '类型名称' ,
PRIMARY KEY (type_id)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8
COMMENT '属性类型';

--建立属性表
CREATE TABLE `wwh_attribute`(
`attr_id`  mediumint  UNSIGNED NOT NULL  AUTO_INCREMENT COMMENT '属性id' ,
`attr_name`  VARCHAR(30) NOT NULL COMMENT '属性名称' ,
`attr_type`  ENUM('唯一','可选') NOT NULL COMMENT '属性类型' ,
`attr_option_value`  VARCHAR(300) NOT NULL DEFAULT '' COMMENT '属性可选值' ,
`type_id`  mediumint UNSIGNED NOT NULL COMMENT '类型id' ,
PRIMARY KEY (attr_id),
KEY type_id(`type_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8
COMMENT '属性类型';

--创建商品-属性表
CREATE TABLE `wwh_goods_attr`(
`goods_attr_id`  mediumint  UNSIGNED NOT NULL  AUTO_INCREMENT COMMENT '商品-属性id' ,
`goods_id`  mediumint  UNSIGNED NOT NULL COMMENT '商品id' ,
`attr_id`  mediumint  UNSIGNED NOT NULL COMMENT '属性id' ,
`attr_value`  VARCHAR(150) NOT NULL COMMENT '属性值' ,
PRIMARY KEY (`goods_attr_id`),
KEY goods_id(`goods_id`),
KEY attr_id(`attr_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8
COMMENT '商品-属性';

--创建商品库存表
CREATE TABLE `wwh_goods_number`(
`goods_id`  mediumint  UNSIGNED NOT NULL COMMENT '商品id' ,
`goods_number` mediumint  UNSIGNED NOT NULL DEFAULT '0' COMMENT '库存量' ,
`goods_attr_ids`  VARCHAR(150) NOT NULL COMMENT '属性值' ,
KEY goods_id(`goods_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8
COMMENT '库存量';









--                                        RABC
--创建权限表
CREATE TABLE `wwh_authority`(
`auth_id`  mediumint  UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '权限id ' ,
`auth_name`  VARCHAR(30)  NOT NULL COMMENT '权限名称 ' ,
`module` VARCHAR(30)  NOT NULL DEFAULT '' COMMENT '模块' ,
`controller` VARCHAR(30)  NOT NULL DEFAULT '' COMMENT '控制器' ,
`action` VARCHAR(30)  NOT NULL DEFAULT '' COMMENT '操作方法' ,
`parent_id`  mediumint  UNSIGNED NOT NULL DEFAULT '0' COMMENT '父级id' ,
PRIMARY KEY (`auth_id`),
KEY parent_id(`parent_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8
COMMENT '权限';

--创建角色表
CREATE TABLE `wwh_role`(
`role_id`  mediumint  UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '角色id ' ,
`role_name` VARCHAR(30)  NOT NULL COMMENT '角色名称' ,
PRIMARY KEY (`role_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8
COMMENT '角色';

--创建管理员表并插入超级管理员
CREATE TABLE `wwh_admin`(
`admin_id`  mediumint  UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '管理员id ' ,
`admin_name` VARCHAR(30)  NOT NULL COMMENT '管理员名称' ,
`password` CHAR(32)  NOT NULL COMMENT '密码' ,
PRIMARY KEY (`admin_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8
COMMENT '管理员';
INSERT INTO `wwh_admin` VALUES(0,'root',md5('root'));

--创建角色-权限表
CREATE TABLE `wwh_role_auth`(
`role_id`  mediumint  UNSIGNED NOT NULL COMMENT '角色id ' ,
`auth_id`  mediumint  UNSIGNED NOT NULL COMMENT '权限id ' ,
KEY role_id(`role_id`),
KEY auth_id(`auth_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8
COMMENT '角色-权限';

--创建角色-权限表
CREATE TABLE `wwh_admin_role`(
`admin_id`  mediumint  UNSIGNED NOT NULL COMMENT '管理员id ' ,
`role_id`  mediumint  UNSIGNED NOT NULL COMMENT '角色id ' ,
KEY admin_id(`admin_id`),
KEY role_id(`role_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8
COMMENT '管理员-角色';

--权限表测试数据
INSERT INTO `wwh_authority` (`auth_id`, `auth_name`, `module`, `controller`, `action`, `parent_id`) VALUES
(1, '商品模块', '', '', '', 0),
(2, '商品列表', 'Admin', 'Goods', 'lst', 1),
(3, '添加商品', 'Admin', 'Goods', 'add', 2),
(4, '修改商品', 'Admin', 'Goods', 'edit', 2),
(5, '删除商品', 'Admin', 'Goods', 'delete', 2),
(6, '分类列表', 'Admin', 'Category', 'lst', 1),
(7, '添加分类', 'Admin', 'Category', 'add', 6),
(8, '修改分类', 'Admin', 'Category', 'edit', 6),
(9, '删除分类', 'Admin', 'Category', 'delete', 6),
(10, 'RBAC', '', '', '', 0),
(11, '权限列表', 'Admin', 'Privilege', 'lst', 10),
(12, '添加权限', 'Privilege', 'Admin', 'add', 11),
(13, '修改权限', 'Admin', 'Privilege', 'edit', 11),
(14, '删除权限', 'Admin', 'Privilege', 'delete', 11),
(15, '角色列表', 'Admin', 'Role', 'lst', 10),
(16, '添加角色', 'Admin', 'Role', 'add', 15),
(17, '修改角色', 'Admin', 'Role', 'edit', 15),
(18, '删除角色', 'Admin', 'Role', 'delete', 15),
(19, '管理员列表', 'Admin', 'Admin', 'lst', 10),
(20, '添加管理员', 'Admin', 'Admin', 'add', 19),
(21, '修改管理员', 'Admin', 'Admin', 'edit', 19),
(22, '删除管理员', 'Admin', 'Admin', 'delete', 19),
(23, '类型列表', 'Admin', 'Type', 'lst', 1),
(24, '添加类型', 'Admin', 'Type', 'add', 23),
(25, '修改类型', 'Admin', 'Type', 'edit', 23),
(26, '删除类型', 'Admin', 'Type', 'delete', 23),
(27, '属性列表', 'Admin', 'Attribute', 'lst', 23),
(28, '添加属性', 'Admin', 'Attribute', 'add', 27),
(29, '修改属性', 'Admin', 'Attribute', 'edit', 27),
(30, '删除属性', 'Admin', 'Attribute', 'delete', 27),
(31, 'ajax删除商品属性', 'Admin', 'Goods', 'ajaxDelGoodsAttr', 4),
(32, 'ajax删除商品相册图片', 'Admin', 'Goods', 'ajaxDelImage', 4),
(33, '会员管理', '', '', '', 0),
(34, '会员级别列表', 'Admin', 'MemberLevel', 'lst', 33),
(35, '添加会员级别', 'Admin', 'MemberLevel', 'add', 34),
(36, '修改会员级别', 'Admin', 'MemberLevel', 'edit', 34),
(37, '删除会员级别', 'Admin', 'MemberLevel', 'delete', 34),
(38, '品牌列表', 'Admin', 'Brand', 'lst', 1);


--会员表 (该表的增删改查应该在前台)
CREATE TABLE `wwh_member`(
`member_id`  mediumint  UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '会员id ' ,
`member_name` VARCHAR(30)  NOT NULL COMMENT '会员名称' ,
`password` CHAR(32)  NOT NULL COMMENT '密码' ,
`logo` VARCHAR(150)  NOT NULL  DEFAULT '' COMMENT '头像' ,
`jifen` mediumint UNSIGNED NOT NULL DEFAULT '0 ' COMMENT '积分' ,
PRIMARY KEY (`member_id`),
KEY jifen(`jifen`)
)ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8
COMMENT '会员表';

--购物车表(前台表)
CREATE TABLE `wwh_cart`(
`catr_id`  mediumint  UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
`member_id`  mediumint UNSIGNED NOT NULL  COMMENT '会员id ',
`goods_id` mediumint UNSIGNED NOT NULL COMMENT '商品id',
`goods_attr_id` VARCHAR(50) NOT NULL DEFAULT '' COMMENT '商品属性id' ,
`shop_number` mediumint UNSIGNED NOT NULL COMMENT '购买数量' ,
PRIMARY KEY (`catr_id`),
KEY member_id(`member_id`)
)ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8
COMMENT '购物车';

--订单表(前后台共同维护表)
CREATE TABLE `wwh_order`(
`order_id`  mediumint  UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '订单id',
`member_id`  mediumint UNSIGNED NOT NULL  COMMENT '会员id ',
`shr_name`  VARCHAR(30) NOT NULL COMMENT '收货人姓名',
`shr_tel`  VARCHAR(30) NOT NULL COMMENT '收货人手机',
`shr_pr`  VARCHAR(30) NOT NULL COMMENT '所在省',
`shr_city`  VARCHAR(30) NOT NULL COMMENT '所在市',
`shr_area`  VARCHAR(30) NOT NULL COMMENT '所在区',
`shr_address`  VARCHAR(150) NOT NULL COMMENT '收货人详细地址',
`pay_way` enum('货到付款','在线支付') NOT NULL DEFAULT '货到付款' COMMENT '支付方式',
`add_time` int UNSIGNED NOT NULL COMMENT '下单时间',
`pay_status` enum('是','否') NOT NULL DEFAULT '否' COMMENT '支付状态',
`total_price` DECIMAL(10,2) NOT NULL  COMMENT '订单总价',
`post_status` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '发货状态:0-未发货,1-已发货,2-已收到货',
`post_number` VARCHAR(30) NOT NULL DEFAULT '' COMMENT '快递单号',
PRIMARY KEY (`order_id`),
KEY member_id(`member_id`),
KEY add_time(`add_time`)
)ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8
COMMENT '订单表';

--订单商品表
CREATE TABLE `wwh_order_goods`(
`order_goods_id` mediumint  UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '订单商品id',
`order_id`  mediumint  UNSIGNED NOT NULL  COMMENT '订单id',
`goods_id` mediumint UNSIGNED NOT NULL  COMMENT '商品id ',
`goods_attr_id` VARCHAR(30)  NOT NULL DEFAULT '' COMMENT '商品属性id',
`shop_price` DECIMAL(10,2)  NOT NULL COMMENT '购买价格',
PRIMARY KEY (`order_goods_id`),
KEY order_id(`order_id`),
KEY goods_id(`goods_id`)
)ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8
COMMENT '订单-商品表';

--商品评论表
CREATE TABLE `wwh_comment`(
`comment_id` mediumint  UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '评论id',
`goods_id`  mediumint  UNSIGNED NOT NULL  COMMENT '商品id',
`member_id`  mediumint  UNSIGNED NOT NULL  COMMENT '会员id',
`comment_content` VARCHAR(200) NOT NULL  COMMENT '评论内容 ',
`level` tinyint UNSIGNED NOT NULL  COMMENT '评价级别1-5 ',
`agree_count` SMALLINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '赞同次数',
`add_time` DATETIME  NOT NULL COMMENT '评论时间',
PRIMARY KEY (comment_id),
KEY goods_id(`goods_id`)
)ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8
COMMENT '商品评论表';

--评论回复表
CREATE TABLE `wwh_reply`(
`reply_id` mediumint  UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '回复id',
`comment_id`  mediumint  UNSIGNED NOT NULL  COMMENT '评论id',
`member_id`  mediumint  UNSIGNED NOT NULL  COMMENT '会员id',
`reply_content` VARCHAR(200) NOT NULL  COMMENT '回复内容 ',
`add_time` DATETIME  NOT NULL COMMENT '回复',
PRIMARY KEY (`reply_id`),
KEY comment_id(`comment_id`)
)ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8
COMMENT '评论回复表';

--商品印象表
CREATE TABLE `wwh_trait`(
`trait_id` mediumint  UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '印象id',
`goods_id`  mediumint  UNSIGNED NOT NULL  COMMENT '商品id',
`trait_name` VARCHAR(15) NOT NULL  COMMENT '印象名称',
`trait_count` tinyint UNSIGNED NOT NULL  DEFAULT '1' COMMENT '印象次数',
PRIMARY KEY (`trait_id`),
KEY goods_id(`goods_id`)
)ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8
COMMENT '商品印象表';