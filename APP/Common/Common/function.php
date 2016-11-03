<?php
/**
 * Created by PhpStorm.
 * User: 4d4k
 * Date: 2016/10/11
 * Time: 20:05
 */
/*
 * 获取缓存配置项的值
 * */
function getConfig($key,$default=null){
    S(['type'=>'file']);
    if(!$value=S($key)){
        $value=M('Setting')->where(['setting_key' =>$key])->getField('setting_value');
        S($key,$value);
    }
    return is_null($value)?$default:$value;
}


function p($arr){
    echo '<pre>';
    print_r($arr);
    echo '</pre>';

}