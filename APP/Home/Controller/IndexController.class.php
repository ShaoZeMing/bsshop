<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){

        $this->display();



    }


    public function ajax(){

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
        }
    }
}