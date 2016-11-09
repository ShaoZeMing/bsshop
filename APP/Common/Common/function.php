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
    S($key,null);
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


//删除文件，当文件删除后目录为空时，递归将空目录删除
function del_File($file)
{
    if (is_file($file)) {
        unlink($file);
        $file = dirname($file);
    }
    if (is_dir($file)) {
        $p = @opendir($file);
        $i = 0;
        while (readdir($p)) {
            $i++;
        }
        closedir($p);
        if ($i <= 2) {
            $father_dir = dirname($file);
            @rmdir($file);
            del_File($father_dir);
        }
    }
}

////删除目录下所有子目录和文件
function delDirAll($dir){
    if(is_dir($dir)){
        $dir_res=opendir($dir);
        while(($filename=readdir($dir_res)) !== false){
            if($filename != '.' && $filename != '..'){
                $url=$dir.'/'.$filename;
                if(is_dir($url)){
                    delDirAll($url);
                }else{
                    unlink($url);
                }
            }
        }
        closedir($dir_res);     //一定要关闭资源，否则报错
        rmdir($dir);

    }elseif(is_file($dir)){
        unlink($dir);
    }
}
