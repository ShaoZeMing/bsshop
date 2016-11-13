<?php

namespace Home\Controller;
use Home\Cart\Cart;
use Think\Controller;


class CommonController extends Controller
{


    public function _initialize()
    {
        // 数据的获取
        // 分类数据
        $m_category = D('Category');
        $category_list = $m_category->getNested();// nested嵌套
        $this->assign('category_list', $category_list);

        // 当前会员信息
        $this->assign('member', session('member'));
    }


    public function commonAjax(){

//        $cat=D('Category')->getNested();
//        p($cat);
//
        $operate = I('request.operate', null, 'trim');

        if (is_null($operate)) {
            return ;
        }
        switch ($operate) {
            // 验证品牌名称唯一的操作
            case 'category':

                if ($cat=D('Category')->getNested()) {
                    $this->ajaxReturn(['error'=>0,'msg' =>$cat]);
                } else {
                    $this->ajaxReturn(['error'=>1, 'errorInfo'=>D('Category')->getError()]);
                }
                break;
            // 添加购物新详情数据
            case 'addCart':
                $info=I('request.goodsInfo',[]);
                $goods_id =$info['goods_id'];
                $pro_id =$info['goods_product_id'];
                $cart = new Cart();
                $cart->addGoods($goods_id,$pro_id);
                if ($cart->addGoods($goods_id,$pro_id)) {
                    $this->ajaxReturn(['error'=>0,'msg' =>'添加购物车成功']);
                } else {
                    $this->ajaxReturn(['error'=>1, 'errorInfo'=>'添加购物车失败！']);
                }
                break;
        }
    }

    public function addGoods(){

    }

}