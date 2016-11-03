create database bsshop charset=utf8;
set names utf8
use bsshop;

drop table if exists ming_member;
-- 会员表
create table ming_member
(
	member_id int unsigned auto_increment COMMENT 'ID', -- ID
	member_email varchar(255) COMMENT '邮箱', -- 邮箱
	member_telephone varchar(16) COMMENT '电话', -- 电话
	member_password varchar(64) not null default '' COMMENT '密码', -- 密码
	member_name varchar(64) not null default '' COMMENT '名称', -- 名称
	member_is_newsletter tinyint not null default 0 COMMENT '订阅否', -- 订阅否
	primary key (member_id),
	unique key (member_email),
	unique key (member_telephone),
	unique key (member_name)
) charset=utf8;

drop table if exists ming_event;
-- 促销活动表
create table ming_event
(
	event_id int unsigned auto_increment COMMENT 'ID', -- ID
	event_name varchar(64) not null default '' COMMENT '活动名称', -- 活动名称
	primary key (event_id)
) charset=utf8;

drop table if exists ming_event_member;
-- 活动会员关联表
create table ming_event_member
(
	event_member_id int unsigned auto_increment COMMENT 'ID', -- ID
	event_id int unsigned not null default 0 COMMENT '活动ID', -- 活动ID
	member_id int unsigned not null default 0 COMMENT '会员ID', -- 会员ID
	primary key (event_member_id),
	index (event_id),
	index (member_id)

) charset=utf8;
insert into ming_event values (101, '2016双11');
insert into ming_event values (100, '2016国庆大促');
insert into ming_event_member values (null, 101, 14);
insert into ming_event_member values (null, 100, 14);
insert into ming_event_member values (null, 101, 17);


drop table if exists ming_member_login_log;
-- 会员登陆行为日志
create table ming_member_login_log(
	member_login_log_id int unsigned auto_increment COMMENT 'ID', -- ID
	member_id varchar(100)  not null default '' COMMENT '登陆账号', -- 登陆账号
	login_time int not null default 0 COMMENT '登陆时间', -- 登陆时间
	login_ip int unsigned not null default 0 COMMENT '登陆IP', -- 登陆IP
	login_error_number int unsigned not null default 0 COMMENT '错误次数', -- 错误次数
	primary key (member_login_log_id),
	index (member_id)
) charset=utf8;
insert into ming_member_login_log values (null, 11, unix_timestamp()-50000, inet_aton('22.45.163.11'), 0);
insert into ming_member_login_log values (null, 11, unix_timestamp()-10000, inet_aton('22.45.165.11'), 0);
insert into ming_member_login_log values (null, 11, unix_timestamp(), inet_aton('22.45.163.12'), 0);




drop table if exists ming_session;
-- session表
CREATE TABLE ming_session
(
	session_id varchar(255) NOT NULL COMMENT 'SESSION_KEY', -- SESSION_KEY
	session_expire int(11) NOT NULL COMMENT '过期时间', -- 过期时间
	session_data blob COMMENT 'SESSION数据值', -- SESSION数据值
	UNIQUE KEY `session_id` (`session_id`)
) charset=utf8;



	-- 商品分类表
	drop table if exists ming_category;
	create table ming_category (
		category_id int unsigned auto_increment COMMENT 'ID', -- ID
		category_name varchar(32) not null default '' COMMENT '分类名称', -- 分类名称
		category_parent_id int unsigned not null default 0 COMMENT '父类ID', -- 父类ID
		category_sort int not null default 0 COMMENT '排序', -- 排序
		category_image varchar(255) not null default '' COMMENT '分类图片', -- 分类图片
		category_image_thumb varchar(255) not null default '' COMMENT '分类小图', -- 分类小图
		category_is_used boolean not null default 1 COMMENT '是否习惯', -- tinyint(1)
		category_is_nav tinyint not null default 1 COMMENT '顶级分类', -- 顶级分类
		category_meta_name varchar(255) not null default '' COMMENT 'SEO标题', -- SEO标题
		category_meta_keywords varchar(255) not null default '' COMMENT 'SEO关键字', -- SEO关键字
		category_meta_description varchar(1024) not null default '' COMMENT 'SEO描述', -- SEO描述
		primary key (category_id),
		index (category_parent_id),
		index (category_sort)
	) charset=utf8;

	insert into ming_category values (1, '未分类', 0, -1, '', '', 0, 0, '', '', '');
	insert into ming_category values (5, '眼镜', 0, 0, '', '', 1, 1, '', '', '');
	insert into ming_category values (6, '男士眼镜', 5, 0, '', '', 1, 0, '', '', '');
	insert into ming_category values (7, '女士眼镜', 5, 0, '', '', 1, 0, '', '', '');
	insert into ming_category values (8, '飞行员眼镜', 5, 0, '', '', 1, 0, '', '', '');
	insert into ming_category values (9, '驾驶镜', 5, 0,'', '',  1, 0, '', '', '');
	insert into ming_category values (10, '太阳镜', 5, 0, '', '', 1, 0, '', '', '');
	insert into ming_category values (11, '图书', 0, 0, '', '', 1, 1, '', '', '');
	insert into ming_category values (12, '历史', 11, 0, '', '', 1, 0, '', '', '');
	insert into ming_category values (14, '科技', 11, 0, '', '', 1, 0, '', '', '');
	insert into ming_category values (15, '计算机', 11, 0, '', '', 1, 0, '', '', '');
	insert into ming_category values (16, '电子书', 11, 0, '', '', 1, 0, '', '', '');
	insert into ming_category values (17, '科普', 14, 0, '', '', 1, 0, '', '', '');
	insert into ming_category values (18, '建筑', 14, 0, '', '', 1, 0, '', '', '');
	insert into ming_category values (19, '工业技术', 14, 0, '', '', 1, 0, '', '', '');
	insert into ming_category values (20, '电子通信', 14, 0, '', '', 1, 0, '', '', '');
	insert into ming_category values (21, '自然科学', 14, 0, '', '', 1, 0, '', '', '');
	insert into ming_category values (22, '互联网', 15, 0, '', '', 1, 0, '', '', '');
	insert into ming_category values (23, '计算机编程', 15, 0, '', '', 1, 0, '', '', '');
	insert into ming_category values (24, '硬件，攒机', 15, 0, '', '', 1, 0, '', '', '');
	insert into ming_category values (25, '大数据', 15, 0, '', '', 1, 0, '', '', '');
	insert into ming_category values (26, '移动开发', 15, 0, '', '', 1, 0, '', '', '');
	insert into ming_category values (27, 'PHP', 15, 0, '', '', 1, 0, '', '', '');
	insert into ming_category values (28, '近代史', 12, 0, '', '', 1, 0, '', '', '');
	insert into ming_category values (29, '当代史', 12, 0, '', '', 1, 0, '', '', '');
	insert into ming_category values (30, '古代史', 12, 0, '', '', 1, 0, '', '', '');
	insert into ming_category values (31, '先秦百家', 12, 0, '', '', 1, 0, '', '', '');
	insert into ming_category values (32, '三皇五帝', 12, 0, '', '', 1, 0, '', '', '');
	insert into ming_category values (33, '励志', 16, 0, '', '', 1, 0, '', '', '');
	insert into ming_category values (34, '小说', 16, 0, '', '', 1, 0, '', '', '');
	insert into ming_category values (35, '成功学', 16, 0, '', '', 1, 0, '', '', '');
	insert into ming_category values (36, '经济金融', 16, 0, '', '', 1, 0, '', '', '');
	insert into ming_category values (37, '免费', 16, 0, '', '', 1, 0, '', '', '');


	drop table if exists ming_brand;
	-- 商品品牌 
	create table ming_brand
	(
		brand_id int unsigned auto_increment COMMENT 'ID', -- ID
		brand_name varchar(32) not null default '' COMMENT '品牌名称', -- 品牌名称
		brand_logo varchar(255) not null default '' COMMENT '品牌logo', -- 品牌logo
		brand_logo_ori varchar(255) not null default '' COMMENT '品牌logo原图', -- 品牌logo原图
		brand_sort int not null default 0 COMMENT '排序', -- 排序

		brand_created_at int not null default 0 COMMENT '创建时间', -- 创建时间
		brand_updated_at int not null default 0 COMMENT '修改时间', -- 修改时间
		primary key (brand_id),
		index (brand_sort),
		index (brand_name)
	) charset=utf8;


	drop table if exists ming_setting_type;

	-- 配置项类型（不提供管理接口）
	create table ming_setting_type (
		setting_type_id int unsigned auto_increment COMMENT 'ID', -- ID
		setting_type_name varchar(32) not null default '' COMMENT '类型名称', -- 类型名称
		primary key (setting_type_id)
	) charset=utf8;

	-- 加入测试数据
	insert into ming_setting_type values (1, 'text');-- 文本
	insert into ming_setting_type values (2, 'textarea');-- 大文本
	insert into ming_setting_type values (3, 'select');-- 单选
	insert into ming_setting_type values (4, 'select-multi');-- 多选


	drop table if exists ming_setting_group;
	-- 配置项分组（不提供管理接口）
	create table ming_setting_group (
		setting_group_id int unsigned auto_increment COMMENT 'ID',     -- ID
		setting_group_name varchar(32) not null default '' COMMENT '分组标题',-- 分组标题
		primary key (setting_group_id)
	) charset=utf8;
	-- 加入测试数据
	insert into ming_setting_group values (1, '商店设置');-- ['goods_count']
	insert into ming_setting_group values (2, '安全配置');-- [goods_count']


	drop table if exists ming_setting;
	-- 配置项
	create table ming_setting (
		setting_id int unsigned not null auto_increment COMMENT 'ID', -- ID
		setting_key varchar(32) not null default '' COMMENT '配置的KEY', -- 配置的KEY
		setting_name varchar(32) not null default '' COMMENT '配置名称', -- 配置名称
		setting_value varchar(255) not null default '' COMMENT '配置的值', -- 配置的值
		setting_type_id int unsigned not null default 0 COMMENT '输入框类型', -- 输入框类型
		setting_group_id int unsigned not null default 0 COMMENT '配置分组', -- 配置分组
		setting_sort int not null default 0 COMMENT '排序', -- 排序
		primary key (setting_id),
		index (setting_type_id),
		index (setting_group_id),
		index (setting_sort)
	) charset=utf8;
	-- 测试数据
	insert into ming_setting values (1, 'shop_name', '商店名称', 'BuyPlus(败家Shopping)', 1, 1,  0);
	insert into ming_setting values (2, 'allow_comment','是否允许商品评论', '5',  3, 1, 0);
	insert into ming_setting values (3, 'use_captcha','哪些页面使用验证码', '1,3',  4, 2, 0);
	insert into ming_setting values (4, 'mate_description', 'mate描述description', 'BuyPlus(败家Shopping), 用BuyPlus，不败家！', 2, 1, 0);
	insert into ming_setting values (5, 'brand_thumb_width', '品牌缩略图宽', '66', 1, 1, 0);
	insert into ming_setting values (6, 'brand_thumb_height','品牌缩略图高', '66',  1, 1, 0);


	drop table if exists ming_setting_option;
	-- 配置系统选项预设值
	create table ming_setting_option (
		setting_option_id int unsigned auto_increment COMMENT 'ID',-- ID
		setting_option__name varchar(32) not null default '' COMMENT '显示内容', -- 显示内容
		setting_id int unsigned not null default 0 COMMENT '选项ID',-- 选项ID
		primary key (setting_option_id),
		index (setting_id)
	) charset=utf8;
	insert into ming_setting_option values (1, '注册', 3);
	insert into ming_setting_option values (2, '登录', 3);
	insert into ming_setting_option values (3, '评论', 3);
	insert into ming_setting_option values (4, '生成订单', 3);
	insert into ming_setting_option values (5, '是', 2);
	insert into ming_setting_option values (6, '否', 2);




drop table if exists ming_length_unit;

-- 商品相关数据存储表
-- 仅仅提供数据存储, 和基本编辑, 没有额外的业务逻辑
-- 长度单位
create table ming_length_unit (
	length_unit_id int unsigned auto_increment COMMENT 'ID', -- ID
	length_unit_name varchar(32) not null default '' COMMENT '长度单位', -- 长度单位
	primary key (length_unit_id)
) charset=utf8;
insert into ming_length_unit values (1, '厘米');
insert into ming_length_unit values (2, '毫米');
insert into ming_length_unit values (3, '英寸');
insert into ming_length_unit values (4, '米');


drop table if exists ming_weight_unit;
-- 重量单位
create table ming_weight_unit (
	weight_unit_id int unsigned auto_increment COMMENT 'ID', -- ID
	weight_unit_name varchar(32) not null default '' COMMENT '重量单位', -- 重量单位
	primary key (weight_unit_id)
) charset=utf8;
insert into ming_weight_unit values (1, '克');
insert into ming_weight_unit values (2, '千克');
insert into ming_weight_unit values (3, '500克(斤)');

drop table if exists ming_weight_unit;
-- 税类型	
create table ming_tax (
	tax_id int unsigned auto_increment COMMENT 'ID', -- ID
	tax_name varchar(32) not null default '' COMMENT '税类名称', --  税类名称
	primary key (tax_id)
) charset=utf8;
insert into ming_tax values (1, '免税产品');
insert into ming_tax values (2, '缴税产品');


drop table if exists ming_stock_status;
-- 库存状态
create table ming_stock_status (
	stock_status_id int unsigned auto_increment COMMENT 'ID', -- ID
	stock_status_name varchar(32) not null default '' COMMENT '状态名称', -- 状态名称
	primary key (stock_status_id)
) charset=utf8;
insert into ming_stock_status values (1, '库存充足');
insert into ming_stock_status values (2, '1-3周');
insert into ming_stock_status values (3, '1-3天');
insert into ming_stock_status values (4, '脱销');
insert into ming_stock_status values (5, '预定');


-- 商品表
drop table if exists ming_goods;
create table ming_goods (
	goods_id int unsigned auto_increment COMMENT 'ID', -- ID
	goods_name varchar(64) not null default '' COMMENT '商品名称', -- 商品名称
	goods_image varchar(255) not null default '' COMMENT '商品图片', -- 商品图片
	goods_image_thumb varchar(255) not null default '' COMMENT '商品小图', -- 商品小图
	goods_SKU varchar(16) not null default '' COMMENT '库存单位', -- 库存单位
	goods_UPC varchar(255) not null default '' COMMENT '商品代码', -- 商品代码
	goods_price decimal(10, 2) not null default 0.0 COMMENT '商品价格', -- 商品价格
	goods_quantity int unsigned not null default 0 COMMENT '商品库存', -- 商品库存
	goods_minimum int unsigned not null default 1 COMMENT '最小起订数', -- 最小起订数
	goods_subtract tinyint not null default 1 COMMENT '减库存否', -- 减库存否
	goods_is_shipping tinyint not null default 1 COMMENT '是否配送', -- 是否配送
	goods_date_available date not null default '0000-00-00' COMMENT '供货日期', -- 供货日期
	goods_length int unsigned not null default 0 COMMENT '商品长度', -- 商品长度
	goods_width int unsigned not null default 0 COMMENT '商品宽度', -- 商品宽度
	goods_height int unsigned not null default 0 COMMENT '商品高度', -- 商品高度
	goods_weight int unsigned not null default 0 COMMENT '商品重量', -- 商品重量
	goods_status tinyint not null default 1 COMMENT '是否锁定', -- 是否锁定
	goods_sort int not null default 0 COMMENT '排序', -- 排序
	goods_description text COMMENT '商品描述', -- 商品描述
	goods_is_deleted tinyint not null default 0 COMMENT '是否已删除', -- 是否已删除
	
	goods_meta_name varchar(255) not null default '' COMMENT 'SEO标题', -- SEO标题
	goods_meta_keywords varchar(255) not null default '' COMMENT 'SEO关键字', -- SEO关键字
	goods_meta_description varchar(1024) not null default '' COMMENT 'SEO描述', -- SEO描述
	length_unit_id int unsigned not null default 0 COMMENT '长度单位', -- 长度单位
	weight_unit_id int unsigned not null default 0 COMMENT '重量单位', -- 重量单位
	tax_id int unsigned not null default 0 COMMENT '税类型', -- 税类型
	stock_status_id int unsigned not null default 0 COMMENT '库存状态', -- 库存状态
	brand_id int unsigned not null default 0 COMMENT '所属品牌', -- 所属品牌
	category_id int unsigned not null default 0 COMMENT '所属分类', -- 所属分类

	goods_created_at int not null default 0 COMMENT '创建时间', -- 创建时间
	goods_updated_at int not null default 0 COMMENT '修改时间', -- 修改时间

	primary key (goods_id),
	index (brand_id),
	index (category_id),
	index (tax_id),
	index (stock_status_id),
	index (length_unit_id),
	index (weight_unit_id),
	index (goods_sort),
	index (goods_name),
	index (goods_price),
	unique key (goods_UPC)
) charset=utf8;


drop table if exists ming_goods_image;

-- 商品图片
create table ming_goods_image (
	goods_image_id int unsigned auto_increment COMMENT '修改时间',
	goods_id int unsigned not null default 0 COMMENT '修改时间', -- 对应商品ID
	goods_image varchar(255) not null default '' COMMENT '修改时间', -- 商品原始图像
	goods_image_small varchar(255) not null default '' COMMENT '修改时间', -- 商品小图像
	goods_image_medium varchar(255) not null default '' COMMENT '修改时间', -- 商品中图像
	goods_image_big varchar(255) not null default '' COMMENT '修改时间', -- 商品大图像
	goods_sort int not null default 0 COMMENT '修改时间', -- 排序
	primary key (goods_image_id),
	index (goods_id),
	index (goods_sort)
) charset=utf8;


drop table if exists ming_goods_type;
-- 商品属性类型
create table ming_goods_type (
	goods_type_id int unsigned auto_increment COMMENT 'ID',
	goods_type_name varchar(32) not null default '' COMMENT '类型名称', -- 标题
	primary key (goods_type_id)
) charset=utf8;
insert into ming_goods_type values (1, '笔记本');
insert into ming_goods_type values (2, '眼镜');
insert into ming_goods_type values (3, '图书');


drop table if exists ming_goods_attribute;
	-- 商品属性
create table ming_goods_attribute (
	goods_attribute_id int unsigned auto_increment COMMENT 'ID',
	goods_attribute_name varchar(32) not null default '' COMMENT '商品属性名称', -- 标题
	goods_sort int not null default 0 COMMENT '排序', -- 排序
	goods_type_id int not null default 0 COMMENT '所属商品类型', -- 所属商品类型ID
	attribute_type_id int not null default 0 COMMENT '属型类型', -- 所属类型ID
	primary key (goods_attribute_id),
	index (goods_type_id),
	index (goods_sort),
	index (attribute_type_id)
) charset=utf8;
insert into ming_goods_attribute values (null, '内存', 0, 1, 2);
insert into ming_goods_attribute values (null, '镜片材质', 0, 2, 1);
insert into ming_goods_attribute values (null, '镜框材质', 0, 2, 1);
insert into ming_goods_attribute values (null, '作者', 0, 3, 1);
insert into ming_goods_attribute values (null, '出版社', 0, 3, 1);
insert into ming_goods_attribute values (null, '页数', 0, 3, 1);

drop table if exists ming_goods_attribute_value;
-- 商品与属性关联
create table ming_goods_attribute_value (
	goods_attribute_value_id int unsigned auto_increment COMMENT 'ID',
	goods_id int unsigned not null default 0 COMMENT '商品ID', -- 商品ID
	goods_attribute_id int unsigned not null default 0 COMMENT '属性ID', -- 属性ID
	goods_attribute_value varchar(255) not null default '' COMMENT '商品属性的值', -- 商品属性的值
	is_option tinyint not null default 0 COMMENT '是否是可选项', -- 是否是可选项
	primary key (goods_attribute_value_id),
	index (goods_id),
	index (goods_attribute_id)
) charset=utf8;


drop table if exists ming_attribute_type;
-- 商品属性类型
create table ming_attribute_type (
	attribute_type_id int unsigned auto_increment COMMENT 'ID',
	attribute_type_name varchar(32) not null default '' COMMENT '属性类型名称', -- 类型名
	primary key (attribute_type_id)
) charset=utf8;
insert into ming_attribute_type values (1, 'text'); -- 文本
insert into ming_attribute_type values (2, 'select'); -- 选择(多选)


-- 表的结构 `ming_goods_group`
--
drop table if exists `ming_goods_group`;

CREATE TABLE `ming_goods_group` (
  `goods_group_id` int(10) UNSIGNED NOT NULL COMMENT 'ID',
  `goods_group_name` varchar(100) NOT NULL DEFAULT '' COMMENT '分组名称',
   PRIMARY KEY (`goods_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='添加商品栏目分组';


drop table if exists ming_attribute_option;
-- 商品选项类属性的预设值
create table ming_attribute_option (
	attribute_option_id int unsigned auto_increment COMMENT 'ID',
	goods_attribute_id int unsigned not null default 0 COMMENT '所属商品属性', -- 所属的商品属性
	attribute_option_name varchar(255) not null default '' COMMENT '预设值', -- 预设值值部分
	primary key (attribute_option_id),
	index (goods_attribute_id)
) charset=utf8;
-- // 内存预设值测试数据
insert into ming_attribute_option values (null, 1, '4G');
insert into ming_attribute_option values (null, 1, '8G');
insert into ming_attribute_option values (null, 1, '16G');
insert into ming_attribute_option values (null, 1, '2G');
insert into ming_attribute_option values (null, 1, '12G');
insert into ming_attribute_option values (null, 1, '32G');


drop table if exists ming_goods_product;
-- 货品表
create table ming_goods_product
(
	goods_product_id int unsigned auto_increment COMMENT '修改时间',
	goods_id int unsigned not null default 0 COMMENT '对应商品',
	goods_product_quantity int not null default 0 COMMENT '库存量', 
	goods_product_price decimal(10, 2) not null default 0.0 COMMENT '货品价格',
	goods_price_operate enum('=', '-', '+') not null default '+' COMMENT '改价规则',
	goods_price_enabled tinyint not null default 1 COMMENT '是否启用',
	primary key (goods_product_id),
	index (goods_id)
) charset=utf8;


drop table if exists ming_product_option;
-- 货品选项表
create table ming_product_option
(
	product_option_id int unsigned auto_increment COMMENT 'ID',
	goods_product_id int unsigned not null default 0 COMMENT '货品所属',
	attribute_option_id int unsigned not null default 0 COMMENT '属性选项ID',
	primary key (product_option_id),
	index (goods_product_id),
	index (attribute_option_id)
)charset=utf8;