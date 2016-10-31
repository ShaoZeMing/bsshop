<?php
/**
 * Created by PhpStorm.
 * User: 4d4k
 * Date: 2016/10/11
 * Time: 20:10
 */

namespace Home\Model;

use Think\Model;

class MemberModel extends Model
{
    // 开启批量验证
    protected $patchValidate = true;
    protected $_validate = [
        // [验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间],
        ['member_email', 'require', '邮箱必须'],
        ['member_email', 'email', '邮箱规则必须正确'],
        ['member_email', '', '邮箱不能重复', 0, 'unique',1],

        ['member_name', 'require', '姓名必须'],
        ['member_name', '4,32', '姓名必须使用4-32个字符', 0, 'length'],
        ['member_name', '', '姓名不能重复', 0, 'unique',1],

        ['member_pwd', 'require', '密码必须'],
        ['member_pwd', '6,32', '密码长度要在6-32个字符间', 0, 'length'],
//        ['member_pwd', '/^[\w_!@#\$%\^&\*()]+$/', '密码仅由数字字母及_!@#$%^&*()符号组成', 0, 'regex'],
//        ['member_pwd', 'checkPasswordStrong', '密码必须要包含字母，数字，特殊符号中两种或两种一种上', 0, 'callback'],
        ['member_pwd', 'pwd', '两次输入的密码一致', 0, 'confirm'],


        ['agree', 'require', '请阅读隐私政策', 0, '', 1],
        ['agree', '1', '请同意隐私政策', 0, 'equal', 1],

    ];

    // 验证规则


    protected $_auto = array(
        array('member_pwd', 'md5', 3, 'function'),
        array('member_ip', 'get_client_ip', 3, 'function'),
        array('member_time', 'time', 1, 'function')
    );

    /**
     * 验证密码强度的自定义方法规则
     * @param  [type] $password [description]
     * @return [type]           [description]
     */
//    public function checkPasswordStrong($password)
//    {
//
//        $strong = 0;//
//        if (preg_match('/\d/', $password)) {
//            ++ $strong;
//        }
//        if (preg_match('/[a-z]/i', $password)) {
//            ++ $strong;
//        }
//        if (preg_match('/[!@#$%^&*()_]/', $password)) {
//            ++ $strong;
//        }
//
//        if ($strong >= 2) {
//            return true; // 通过
//        } else {
//            return false; // 未通过
//        }
//
//    }

}