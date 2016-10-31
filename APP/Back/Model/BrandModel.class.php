<?php


namespace Back\Model;
use Think\Model;
class BrandModel extends Model
{
    // 自动验证规则
    protected $_validate = [
        ['brand_name', 'require', '品牌名称必须填写'],
        ['brand_name', '', '品牌名称不能重复', 0, 'unique',1],
        ['brand_sort', 'number', '排序字段需要使用数字'],
    ];
    // 自动完成规则
    protected $_auto = [
        ['brand_created_at', 'time', self::MODEL_INSERT, 'function'],
        ['brand_updated_at', 'time', self::MODEL_BOTH, 'function'],
    ];
}