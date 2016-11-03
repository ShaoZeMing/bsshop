<?php
namespace Back\Model;

use Think\Model\RelationModel;


class SettingModel extends RelationModel
{
    protected $_link =[
        'option'=>[
            'mapping_type' => self::HAS_MANY,
            'class_name'  => 'SettingOption',
            'foreign'   =>'setting_id',
        ]
    ];

}