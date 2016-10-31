<?php
return array(
	//'配置项'=>'配置值'
//
    'TMPL_ACTION_ERROR'     =>  'Common/jump_error', // 默认错误跳转对应的模板文件
    'TMPL_ACTION_SUCCESS'   =>  'Common/jump_success', // 默认成功跳转对应的模板文件
    'URL_MODEL'             =>  2,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
    'URL_ROUTER_ON'         =>  true,   // 是否开启URL路由
    'URL_ROUTE_RULES'       =>  array(
        'login' =>'Member/login',
        'register' =>'Member/register',
        'center' =>'Member/center',
        'verify' =>'Member/verify',
    ), // 默认路由规则 针对模块
);