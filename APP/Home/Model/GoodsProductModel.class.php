<?php

namespace Home\Model;

use Think\Model\RelationModel;

class GoodsProductModel extends RelationModel
{

    protected $_link = [
        'option'    => [
            'mapping_type' => self::HAS_MANY,
            'class_name'    => 'ProductOption',
            'foreign_key'   => 'goods_product_id',
        ],
    ];
}