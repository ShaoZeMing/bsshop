<?php

namespace Home\Model;

use Think\Model;

class CategoryModel extends Model
{

    /**
     * 得到嵌套结构的分类数据
     * @param int $max 最大层级数
     * @return [type] [description]
     */
    public function getNested($max=3)
    {

        // 获取前台可以展示的全部分类
        $list = $this->where(['category_is_used'=>'1'])->order('category_sort')->select();
        // dump($list);
        // 递归形成需要的数据格式
//        p($list);die;
        return $this->nested($list, 0, 0, $max);
    }

    public function nested($list, $category_id, $deep=0, $max=null)
    {
        // 存储是当前分类下的所有的后代分类
        $nested = [];
        foreach($list as $row) {

            if ($row['category_parent_id'] == $category_id) {
                // 继续查找分类的子分类
                // 判断当前是否超过了最大深度
                if ($deep < ($max-1)) {// < 2
                    // <2 执行后代的分类查找
                    $row['children'] = $this->nested($list, $row['category_id'], $deep+1, $max);
                }
                // 将当前的分类记录下拉
                $nested[] = $row;
            }
        }

        return $nested;
    }
}