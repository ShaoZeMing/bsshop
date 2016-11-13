<?php
namespace Home\Controller;

use Home\Cart\Cart;
use Think\Controller;
use Think\Verify;

class MemberController extends Controller
{
    //登陆方法
    public function login()
    {
        if (IS_POST) {
            // 校验验证码
            $t_verify = new Verify;
            if (!$t_verify->check(I('post.verify'))) {
                $this->error('请填写正确的验证码', U('/login'));
            }

            // 获取用户输入的数据
            $email = I('post.email_phone');
            $password = I('post.member_pwd');
            // 校验
            $m_member = M('Member');
            // 先使用邮箱地址或电话号码，查询用户
            $cond['member_email'] = $email;
            $cond['member_telephone'] = $email;
            $cond['_logic'] = 'OR';// 或者
            $row = $m_member->where($cond)->find();// 仅需要一条
            if (!$row) {
                // 邮箱，号码，都没有匹配
                $this->error('登陆信息错误');
            }

            // 再校验密码
            if ($row['member_pwd'] != md5($password)) {
                $this->error('登陆信息错误');
            }

            // 校验通过
            // 可以登陆
            // session中，存储登陆标志
            unset($row['member_pwd']);
            session('member', $row);

            // 登录成功
            $cart = new Cart();// use Home\Cart\Cart;
            $cart->mergeCookieGoods();// 合并cookie中的商品

            // 重定向到目标页
            // 判断session中是否存在login_target
            if ($login_target = session('login_target')) {
                $this->redirect($login_target, [], 0);
            } else {
                $this->redirect('/center', [], 0);
            }
        } else {
            $this->display();

        }
    }

//注册方法
    public function register()
    {
        if (IS_POST) {
            p($_POST);
            $member = D('Member');

            if (!$member->create()) {
                $this->error('注册失败, ' . implode('<br>', $member->getError()));
            };
            if ($member->add()) {
                session('member', $_POST);
                if ($login_target = session('login_target')) {
                    $this->redirect($login_target, [], 0);
                } else {
                    $this->redirect('/center', [], 0);
                }
            } else {
                $this->error($member->getError());
            }
        } else {
            $this->display();
        }

    }

    public function center()
    {
        p(session('member'));

        echo '用户主页！';
//        $this->display();
    }

    public function logout()
    {
        session('member', null);
        $this->redirect('/login', [], 0);

    }


    public function verify()
    {
        $config = array(
            'codeSet' => '1234567890',             // 验证码字符集合
            'fontSize' => 16,              // 验证码字体大小(px)
            'imageH' => 34,               // 验证码图片高度
            'imageW' => 120,               // 验证码图片宽度
            'length' => 4,               // 验证码位数
            'fontttf' => '4.ttf',              // 验证码字体，不设置随机获取
            'reset' => false,           // 验证成功后是否重置
        );
        $v = new Verify($config);
        $v->entry();
    }
}