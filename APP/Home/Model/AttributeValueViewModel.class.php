<?php

namespace Home\Model;

use Think\Model\ViewModel;


class AttributeValueViewModel extends ViewModel
{
    public $viewFields = array(
        'GoodsAttributeValue'=>array('_as'=>'gav','goods_id','goods_attribute_id','goods_attribute_value','is_option','_type'=>'LEFT'),
        'GoodsAttribute'=>array('_as'=>'ga','goods_attribute_name','goods_attribute_sort','goods_type_id','attribute_type_id','_on'=>'gav.goods_attribute_id = ga.goods_attribute_id','_type'=>'LEFT'),
        'AttributeType'=>array('_as'=>'at','attribute_type_name','_on'=>'ga.attribute_type_id = at.attribute_type_id'),
//        'User'=>array('name'=>'username','_on'=>'User.id=Blog.user_id'),

  );


    //获得数据，
    function getAttribute($goods_id){
        $attr_info =$this->where(['goods_id'=>$goods_id])->select();
        // 遍历属性列表
        // 获取属性对应的预设值列表
        // 将可选的选项属性, 独立存储.
        $option_list = [];
        foreach($attr_info as $key=>$attribute) {
            // 获取属性对应的预设值列表
            // 判断是否为多选属性
            if ($attribute['attribute_type_name'] == 'select') {
                $attr_info[$key]['option'] = M('AttributeOption')->where(['attribute_option_id'=>['in', $attribute['goods_attribute_value']]])->select();
            }else{
                $attr_info[$key]['option'][]=['attribute_option_name'=>$attribute['goods_attribute_value'],'goods_attribute_id'=>$attribute['goods_attribute_id']];
            }
            // 将可选的选项属性, 独立存储.
            // 判断是否为选项
            if ($attribute['is_option'] == '1') {
                $option_list[] = $attr_info[$key];
            }
        }

        return $option_list;
    }


}