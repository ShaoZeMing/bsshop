<?php

namespace Home\Model;

use Think\Model;

class GoodsModel extends Model
{
    /**
     * 获取推荐
     * @return [type] [description]
     */
    public function getPromote()
    {
        // 确定推荐商品的条件
        // 随机推荐
        $max_goods_id = $this->max('goods_id');
        $promote_number = getConfig('promote_goods_number', 4);
        // 获得随机的商品ID
        for($i=1, $n=$promote_number*3; $i<=$n; ++$i) {// 3备容错
            $rand_id[] = mt_rand(1, $max_goods_id);
        }

        // 利用随机的ID, 获取商品
        $list = $this->where(['is_deleted'=>0, 'status'=>1, 'goods_id'=>['in', $rand_id]])->limit($promote_number)->select();

        return $list;
    }

    /**
     * 获得该商品的导航数据
     */
    public function getBreadcrumb($goods_id)
    {
        // 获取当前分类ID
        $category_id = $this->where(['goods_id'=>$goods_id])->getField('category_id');

        $parents = $this->getParents($category_id);// 查找当前分类及其祖先分类
        return array_reverse($parents);// 反转数组,先展示顶级, 在展示末级
    }

    public function getParents($category_id) {
        static $parents = [];

        $m_category = M('Category');
        // 先获取当前分类信息, 确定是否为顶级分类, 
        $category = $m_category->find($category_id);
        // 存储当前的父级分类
        $parents[] = $category;
        if ($category['category_parent_id'] != '0') {
            // 不是顶级分类, 递归查找
            $this->getParents($category[' category_parent_id']);
        }

        return $parents;
    }

    /**
     * 计算商品的价格
     * @param  [type] $goods_id         [description]
     * @param  [type] $goods_product_id [description]
     * @param  [type] $member_id        [description]
     * @return [type]                   [description]
     */
    public function getPrice($goods_id, $goods_product_id=0, $member_id=0)
    {

        // 商品价格
        $goods_price = $this->where(['goods_id'=>$goods_id])->getField('goods_price');
        $real_price = $goods_price;

        // 货品价格
        if ($goods_product_id != 0) {
            // 有货品
            $m_goods_product = M('GoodsProduct');
            $m_goods_product->find($goods_product_id);
            // 操作, 浮动价格
            switch($m_goods_product->goods_price_operate) {
                case '=':
                    $real_price = $m_goods_product->goods_product_price;
                    break;
                case '+':
                    $real_price += $m_goods_product->goods_product_price;
                    break;
                case '-':
                    $real_price -= $m_goods_product->goods_product_price;
                    break;    
            }
        }

        // 会员价格
        // 活动价格

        return $real_price;
    }
}