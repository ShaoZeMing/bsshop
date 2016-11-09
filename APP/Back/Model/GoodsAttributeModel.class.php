<?php

namespace Back\Model;
use Think\Model\RelationModel;

class GoodsAttributeModel extends RelationModel
{

    protected $_link = [
        'option'    => [
            'mapping_type'  => self::HAS_MANY,
            'class_name'    => 'AttributeOption',
            'foreign_key'   => 'goods_attribute_id',
        ]
    ];
}