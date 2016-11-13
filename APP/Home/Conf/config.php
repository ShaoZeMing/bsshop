<?php
return array(
	//'配置项'=>'配置值'
//
    'DEFAULT_CONTROLLER'    =>  'Shop', // 默认控制器名称
    'DEFAULT_ACTION'        =>  'index', // 默认操作名称
    'TMPL_ACTION_ERROR'     =>  'Common/jump_error', // 默认错误跳转对应的模板文件
    'TMPL_ACTION_SUCCESS'   =>  'Common/jump_success', // 默认成功跳转对应的模板文件
    'URL_MODEL'             =>  2,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
    'URL_ROUTER_ON'         =>  true,   // 是否开启URL路由
    'URL_ROUTE_RULES'       =>  array(
        'login' =>'Member/login',    //登陆
        'register' =>'Member/register', //注册
        'center' =>'Member/center',   //用户中心
        'verify' =>'Member/verify',   //验证码
        'logout'	=> 'Member/logout', // 退出
        'index' => 'Shop/index',    //商品主页

        // 带参数的路由
        'goods/:goods_id\d'   => 'Shop/goods',

        'addGoods'  => 'Buy/addGoods',
        'cart'  => 'Buy/cart',
        'remove'    => 'Buy/removeGoods',
        'order' => 'Buy/order',
        'ajax'  => 'Buy/ajax',
        'checkout'  => 'Buy/checkout',
        'orderInfo/:order_sn' => 'Buy/orderInfo',
    ), // 默认路由规则 针对模块
);