create database bsshop charset=utf8;
set names utf8
use bsshop;

drop table if exists ming_member;
-- 会员表
create table ming_member
(
	member_id int unsigned auto_increment, -- ID
	member_email varchar(255), -- 邮箱
	member_telephone varchar(16), -- 电话
	member_password varchar(64) not null default '', -- 密码
	member_name varchar(64) not null default '', -- 名称
	member_is_newsletter tinyint not null default 0, -- 订阅否
	primary key (member_id),
	unique key (member_email),
	unique key (member_telephone),
	unique key (member_name)
) charset=utf8;

drop table if exists ming_event;
-- 促销活动表
create table ming_event
(
	event_id int unsigned auto_increment, -- ID
	event_name varchar(64) not null default '', -- 活动名称
	primary key (event_id)
) charset=utf8;

drop table if exists ming_event_member;
-- 活动会员关联表
create table ming_event_member
(
	event_member_id int unsigned auto_increment, -- ID
	event_id int unsigned not null default 0, -- 活动ID
	member_id int unsigned not null default 0, -- 会员ID
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
	member_login_log_id int unsigned auto_increment, -- ID
	member_id varchar(100)  not null default '', -- 登陆账号
	login_time int not null default 0, -- 登陆时间
	login_ip int unsigned not null default 0, -- 登陆IP
	login_error_number int unsigned not null default 0, -- 错误次数
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
	session_id varchar(255) NOT NULL, -- SESSION_KEY
	session_expire int(11) NOT NULL, -- 过期时间
	session_data blob, -- SESSION数据值
	UNIQUE KEY `session_id` (`session_id`)
) charset=utf8;



-- 商品分类表
drop table if exists ming_category;
create table ming_category (
	category_id int unsigned auto_increment, -- ID
	category_name varchar(32) not null default '', -- 分类名称
	category_parent_id int unsigned not null default 0, -- 父类ID
	category_sort int not null default 0, -- 排序
	category_image varchar(255) not null default '', -- 分类图片
	category_image_thumb varchar(255) not null default '', -- 分类小图
	category_is_used boolean not null default 1, -- tinyint(1)
	category_is_nav tinyint not null default 1, -- 顶级分类
	category_meta_name varchar(255) not null default '', -- SEO标题
	category_meta_keywords varchar(255) not null default '', -- SEO关键字
	category_meta_description varchar(1024) not null default '', -- SEO描述
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
	brand_id int unsigned auto_increment, -- ID
	brand_name varchar(32) not null default '', -- 品牌名称
	brand_logo varchar(255) not null default '', -- 品牌logo
	brand_logo_ori varchar(255) not null default '', -- 品牌logo原图
	brand_sort int not null default 0, -- 排序

	brand_created_at int not null default 0, -- 创建时间
	brand_updated_at int not null default 0, -- 修改时间
	primary key (brand_id),
	index (brand_sort),
	index (brand_name)
) charset=utf8;


drop table if exists ming_setting_type;

-- 配置项类型（不提供管理接口）
create table ming_setting_type (
	setting_type_id int unsigned auto_increment, -- ID
	setting_type_name varchar(32) not null default '', -- 类型名称
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
	setting_group_id int unsigned auto_increment,     -- ID
	setting_group_name varchar(32) not null default '',-- 分组标题
	primary key (setting_group_id)
) charset=utf8;
-- 加入测试数据
insert into ming_setting_group values (1, '商店设置');-- ['goods_count']
insert into ming_setting_group values (2, '安全配置');-- [goods_count']


drop table if exists ming_setting;
-- 配置项
create table ming_setting (
	setting_id int unsigned not null auto_increment, -- ID
	setting_key varchar(32) not null default '', -- 配置的KEY
	setting_name varchar(32) not null default '', -- 配置名称
	setting_value varchar(255) not null default '', -- 配置的值
	setting_type_id int unsigned not null default 0, -- 输入框类型
	setting_group_id int unsigned not null default 0, -- 配置分组
	setting_sort int not null default 0, -- 排序
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
	setting_option_id int unsigned auto_increment,-- ID
	setting_option__name varchar(32) not null default '', -- 显示内容
	setting_id int unsigned not null default 0,-- 选项ID
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
	length_unit_id int unsigned auto_increment, -- ID
	length_unit_name varchar(32) not null default '', -- 长度单位
	primary key (length_unit_id)
) charset=utf8;
insert into ming_length_unit values (1, '厘米');
insert into ming_length_unit values (2, '毫米');
insert into ming_length_unit values (3, '英寸');
insert into ming_length_unit values (4, '米');


drop table if exists ming_weight_unit;
-- 重量单位
create table ming_weight_unit (
	weight_unit_id int unsigned auto_increment, -- ID
	weight_unit_name varchar(32) not null default '', -- 重量单位
	primary key (weight_unit_id)
) charset=utf8;
insert into ming_weight_unit values (1, '克');
insert into ming_weight_unit values (2, '千克');
insert into ming_weight_unit values (3, '500克(斤)');

drop table if exists ming_weight_unit;
-- 税类型	
create table ming_tax (
	tax_id int unsigned auto_increment, -- ID
	tax_name varchar(32) not null default '', --  税类名称
	primary key (tax_id)
) charset=utf8;
insert into ming_tax values (1, '免税产品');
insert into ming_tax values (2, '缴税产品');


drop table if exists ming_stock_status;
-- 库存状态
create table ming_stock_status (
	stock_status_id int unsigned auto_increment, -- ID
	stock_status_name varchar(32) not null default '', -- 状态名称
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
	goods_id int unsigned auto_increment, -- ID
	goods_name varchar(64) not null default '', -- 商品名称
	goods_image varchar(255) not null default '', -- 商品图片
	goods_image_thumb varchar(255) not null default '', -- 商品小图
	goods_SKU varchar(16) not null default '', -- 库存单位
	goods_UPC varchar(255) not null default '', -- 商品代码
	goods_price decimal(10, 2) not null default 0.0, -- 商品价格
	goods_quantity int unsigned not null default 0, -- 商品库存
	goods_minimum int unsigned not null default 1, -- 最小起订数
	goods_subtract tinyint not null default 1, -- 减库存否
	goods_is_shipping tinyint not null default 1, -- 是否配送
	goods_date_available date not null default '0000-00-00', -- 供货日期
	goods_length int unsigned not null default 0, -- 商品长度
	goods_width int unsigned not null default 0, -- 商品宽度
	goods_height int unsigned not null default 0, -- 商品高度
	goods_weight int unsigned not null default 0, -- 商品重量
	goods_status tinyint not null default 1, -- 是否锁定
	goods_sort int not null default 0, -- 排序
	goods_description text, -- 商品描述
	goods_is_deleted tinyint not null default 0, -- 是否已删除
	
	goods_meta_name varchar(255) not null default '', -- SEO标题
	goods_meta_keywords varchar(255) not null default '', -- SEO关键字
	goods_meta_description varchar(1024) not null default '', -- SEO描述
	length_unit_id int unsigned not null default 0, -- 长度单位
	weight_unit_id int unsigned not null default 0, -- 重量单位
	tax_id int unsigned not null default 0, -- 税类型
	stock_status_id int unsigned not null default 0, -- 库存状态
	brand_id int unsigned not null default 0, -- 所属品牌
	category_id int unsigned not null default 0, -- 所属分类

	goods_created_at int not null default 0, -- 创建时间
	goods_updated_at int not null default 0, -- 修改时间

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
