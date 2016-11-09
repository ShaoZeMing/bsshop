<?php

namespace Back\Model;

use Think\Model;


class GoodsModel extends Model
{

    protected $_auto = [
        ['goods_created_at', 'time', self::MODEL_INSERT, 'function'],
        ['goods_updated_at', 'time', self::MODEL_BOTH, 'function'],
    ];
}