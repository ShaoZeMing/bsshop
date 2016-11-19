<?php

namespace Home\Controller;

use Home\Cart\Cart;

class BuyController extends CommonController
{

    /*
     * 购物车展示页
     * */
    public function cart()
    {
        //获得购物车数据
        $cart = new Cart();
        $goods_list=$cart->getCartList();
        $total_price=$cart->getCartInfo();
        p(session('member'));
        $this->assign('goods_list',$goods_list);
        $this->assign('total_price',$total_price);
        // 展示首页模板
        $this->display();

    }

    public function removeGoods()
    {
        $cart = new Cart;
        $goods_id = I('request.goods_id');
        $goods_product_id = I('request.goods_product_id');

        $result = $cart->removeGoods($goods_id, $goods_product_id);

        if ($result) {
            $this->ajaxReturn(['error'=>0]);
        } else {
            $this->ajaxReturn(['error'=>1, 'errorInfo'=>$cart->getError()]);
        }
    }




}