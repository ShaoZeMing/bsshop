<?php

namespace Home\Model;

use Think\Model\ViewModel;


class ProductOptionViewModel extends ViewModel
{
    public $viewFields = array(
        'ProductOption'=>array('_as'=>'po','goods_product_id','_type'=>'LEFT'),
        'AttributeOption'=>array('_as'=>'ao','attribute_option_name','_on'=>'po.attribute_option_id = ao.attribute_option_id','_type'=>'LEFT'),
        'GoodsAttribute'=>array('_as'=>'ga','goods_attribute_name','_on'=>'ga.goods_attribute_id = ao.goods_attribute_id'),
//        'User'=>array('name'=>'username','_on'=>'User.id=Blog.user_id'),

  );


    //获得数据，
    function getProAttr($product_id){
        $attr_info =$this->where(['goods_product_id'=>$product_id])->select();
        return $attr_info;
    }


}