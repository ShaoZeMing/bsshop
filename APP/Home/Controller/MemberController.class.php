<?php
namespace Home\Controller;
use Think\Controller;
use Think\Verify;

class MemberController extends Controller {
    //登陆方法
    public function login(){
        if(IS_POST){

            $this->error('我要返回，我西施');

        }else {
            $this->display();

        }
    }
//注册方法
    public function register(){
        if(IS_POST){
            p($_POST);
            $member = D('Member');

            if(!$member->create()){
                $this->error('注册失败, ' . implode('<br>', $member->getError()));
            };
           if($member->add()){
               $this->redirect('/center', [], 0);// 0立即跳转到U('/center', [])
           }else{
               $this->error($member->getError());
           }
        }else{
            $this->display();
        }

    }

    public function center(){

        echo '用户主页！';
//        $this->display();
}    






    public function verify(){
        $config =	array(
            'codeSet'   =>  '1234567890',             // 验证码字符集合
            'fontSize'  =>  16,              // 验证码字体大小(px)
            'imageH'    =>  34,               // 验证码图片高度
            'imageW'    =>  120,               // 验证码图片宽度
            'length'    =>  4,               // 验证码位数
            'fontttf'   =>  '4.ttf',              // 验证码字体，不设置随机获取
            'reset'     =>  false,           // 验证成功后是否重置
        );
        $v=new Verify($config);
        $v->entry();
    }
}