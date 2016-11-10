<?php

namespace Home\Controller;
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
            // 获取商品详情数据
            case 'goods':

                if ($cat=D('Goods')->getNested()) {
                    $this->ajaxReturn(['error'=>0,'msg' =>$cat]);
                } else {
                    $this->ajaxReturn(['error'=>1, 'errorInfo'=>D('Category')->getError()]);
                }
                break;
        }
    }

}