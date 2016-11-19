<?php
/**
 * Created by PhpStorm.
 * User: 4d4k
 * Date: 2016/11/11
 * Time: 21:34
 */

namespace Home\Cart;


class Cart
{
    public $_goods_list=[];

    /*
     * 初始化购物车
     * */
    public function __construct()
    {
        $this->initCart();

    }

    /*
     * 初始化配置
     * */
    private function initCart(){

        // 从cookie或者数据表中读取数据
        // 根据用户的登录状态判断
        if ($member = session('member')) {
            // 从数据表获取
            $cond['member_id'] = $member['member_id'];
            $rows = M('CartGoods')->field('goods_id, goods_product_id, product_num')->where($cond)->select();
            // 拼凑成 goods_id:goods_product_id这种下标
            $goods_list = [];
            foreach($rows as $goods) {
                // 拼凑key
                $goods_key = $goods['goods_id'] . ':' . $goods['goods_product_id'];
                $goods_list[$goods_key] = $goods;
            }

        } else {
            $goods_list = unserialize(cookie('cart_goods_list'));
        }

        // 存储到$this->goods_list中
        $this->_goods_list = $goods_list ? $goods_list : [];
    }


    /*
  * 析构函数，处理购物车数据并
  * */
    public function __destruct(){

        $this->saveCart();
    }

    /*
     * 更新购物车
     * */
    public function saveCart()
    {
        // 存储到cookie中
        if ($member = session('member')) {
            $cart_goods = M('CartGoods');
            // 用户处于登录状态
            // 遍历所有的购物车中的商品, 
            $cart_goods_list = [];// 操作过主键
            foreach ($this->_goods_list as $key => $goods) {
                // 判断该商品是否存在于数据表中
                $cond['member_id'] = $member['member_id'];
                $cond['goods_id'] = $goods['goods_id'];
                $cond['goods_product_id'] = $goods['goods_product_id'];
                // 查询判断
                // 记录当前处理过的所购的商品的ID
                if ($cart_goods->where($cond)->find()) {
                    $cart_goods_list[] = $cart_goods->cart_goods_id;
                    // 数据存在
                    // (ORM) AR模式语法更新
                    $cart_goods->product_num = $goods['product_num'];
                    $cart_goods->save();
                } else {
                    // 没有找到
                    $data = $cond;
                    $data['product_num'] = $goods['product_num'];
                    $cart_goods_list[] = $cart_goods->add($data);
                }
            }

            // 删除没有操作过的
            $cond = [
                'member_id' => $member['member_id'],
                'cart_goods_id' => ['not in', $cart_goods_list],
            ];
            $cart_goods->where($cond)->delete();
        }else {
            // 存储到cookie中
            cookie('cart_goods_list', serialize($this->_goods_list), ['expire' => 30 * 24 * 3600]);
        }
    }


    /*
    * 添加购物车
    * */
    public function addGoods($goods_id,$goods_product_id=0,$product_num=1){
        $goods_key=$goods_id.':'.$goods_product_id;

        if(isset($this->_goods_list[$goods_key])){
            $this->_goods_list[$goods_key]['product_num'] += $product_num;
        }else{
            $this->_goods_list[$goods_key]=[
                'goods_id' => $goods_id,
                'goods_product_id' => $goods_product_id,
                'product_num'  =>$product_num,
            ];
        }
        return true;
    }



    /**
     * 合并cookie中的商品到, 数据表中.
     * @return [type] [description]
     */
    public function mergeCookieGoods()
    {
        // 从cookie中获取
        $goods_list = unserialize(cookie('cart_goods_list'));
        // 合并到goods_list属性中:
        $this->goods_list = array_merge($this->_goods_list, $goods_list ? $goods_list : []);
    }


    /*
  * s删除购物车
  * */
    public function getCartList(){

        $m_goods=D('Goods');
        $m_product_option=D('ProductOptionView');
        $return_goods_list=[];
        foreach ($this->_goods_list as $key=>$goods){
            $goods_info=$m_goods->field('goods_id,goods_name,goods_image_thumb,goods_price')->find($goods['goods_id']);
            $option_list = $m_product_option->getProAttr($goods['goods_product_id']); //获得货品选项和值

            $goods_info['option_list']=$option_list;    //放入该货品中，
            $goods_info = array_merge($goods_info,$goods);  //合并购物车数据
            //获取货品对应的价格
            $goods_info['product_price']=$m_goods->getPrice($goods['goods_id'],$goods['goods_option_id']);
            $return_goods_list[$key]=$goods_info;
        }

        return $return_goods_list;

    }


    public function getCartInfo()
    {
        $total_price = 0;
        $total_weight = 0;// 以g计算单位
        $m_goods = D('Goods');

        foreach($this->_goods_list as $key=>$goods) {
            $row = $m_goods->field('goods_weight, weight_unit_name')->join('left join __WEIGHT_UNIT__  using(weight_unit_id)')->find($goods['goods_id']);

            switch ($row['weight_unit_name']) {
                case '克':
                    $total_weight += $row['goods_weight']*$goods['product_num'];
                    break;
                case '千克':
                    $total_weight += $row['goods_weight']*1000*$goods['product_num'];
                    break;
                case '500克(斤)':
                    $total_weight += $row['goods_weight']*500*$goods['product_num'];
                    break;
            }
            $member = session('member');
            $total_price += $m_goods->getPrice($goods['goods_id'], $goods['goods_product_id'], $member?$member['member_id']:0)*$goods['product_num'];
        }

        return ['total_price'=>$total_price, 'total_weight'=>$total_weight];
    }

    //获得购物车全部数据
    public function getGoodsListRaw()
    {
        return $this->goods_list;
    }



    /**
     * [removeGoods description]
     * @param  [type]  $goods_id         [description]
     * @param  integer $goods_product_id [description]
     * @return [type]                    [description]
     */
    public function removeGoods($goods_id, $goods_product_id=0)
    {
        $goods_key = $goods_id . ':' . $goods_product_id;
        if (isset($this->_goods_list[$goods_key])) {
            // 删除即可
            unset($this->_goods_list[$goods_key]);
            return true;
        } else {
            $this->error = '商品(货品)不存在';
            return false;
        }

    }

    private $error;
    public function getError()
    {
        return $this->error;
    }

    public function clearGoods()
    {


    }
    /*
     * 清空购物车
     * */
    public function clearCart(){

    }

}