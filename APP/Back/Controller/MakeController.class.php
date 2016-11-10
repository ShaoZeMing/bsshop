<?php
namespace Back\Controller;

use Think\Controller;
use Think\Page;

//生成代码控制器
class MakeController extends Controller
{
    /**
     * 添加动作
     */
    public function make()
    {
        if (IS_POST) {
            //获取数据
            $module = ucfirst(I('post.module', 'Back', 'trim'));       //将模型数据转换为首字母大写
            $table_i = strtolower(I('post.controller', '', 'trim'));   //将所有输入表名
            $model = $controller = implode('', array_map('ucfirst', explode('_', $table_i)));
            $title = (I('post.title', '', 'trim'));
            if (!$table_i) {
                $this->error('表名必须！');
                return;
            }
            //

            //获得表字段详情
            $field_info = M()->query('SHOW FULL COLUMNS FROM ' . C('DB_PREFIX') . $table_i);
            //遍历获得每个字段描述信息储存到一个数组中。

            p($field_info);die;
            $fd = '';        //接收定义搜索字段
            foreach ($field_info as $v) {
                //查询主键字段
                if ($v['key'] == 'PRI') {
                    $pk = $v['field'];
                }
                //定义可被搜索筛选的字段
                if (in_array(substr($v['type'], 0, 3), ['var', 'cha', 'tex'])) {
                    $fd .= $v['field'] . ',';
                }
                //获取排序字段

                //若有描述排序，用该字段
                if (!empty($v['comment']) && (stripos($v['comment'], '排序') || stripos($v['comment'], 'sort'))) {
                    $sort = $v['field'];
                    //若字段中含有sort,以该字段排序
                } elseif (stripos($v['field'], 'sort')) {
                    $sort = $v['field'];
                    //否则以主键默认排序
                } elseif ($v['key'] == 'PRI') {
                    $sort = $v['field'];
                }
                //获得描述|字段名
                if ($v['key'] == 'PRI') {
                    continue;
                }
                $field_comment[] = empty($v['comment']) ? $v['field'] : $v['comment'];
                $fields[] = $v['field'];   //获得字段
            }
            $fd = rtrim($fd, ',');  //将数组转换为字符串以便于替换



            //生成控制器
            //要替换的占位符
            $search = ['___MODULE_', '___TABLE_', '___PK_', '___TITLE_', '___TABLEI_', '___FD_', '___SORT_'];
            //替换的数据
            $replace = [$module, $model, $pk, $title, $table_i, $fd, $sort];
            //模板文件目录路劲
            $md_dir = APP_PATH . $module . '/';
            //提换数据获得新数据
            $controller_class = str_replace($search, $replace, file_get_contents($md_dir . 'Code/controller_tpl.php'));
            if (!is_dir($md_dir . 'Controller/')) {
                mkdir($md_dir . 'Controller/', 0775, true);
            }

            //生成控制器代码
            $res = file_put_contents($md_dir . 'Controller/' . $model . 'Controller.class.php', $controller_class);
            if ($res) {
                echo $md_dir . 'Controller/' . $model . 'Controller.class.php' . '生成控制器成功！<br>';
            }


            ///***********生成lists模板文件**********/

            //提换数据获得新数据
            $list_head_html = file_get_contents($md_dir . 'Code/list_head_tpl.html');
            $list_body_html = file_get_contents($md_dir . 'Code/list_body_tpl.html');
            //遍历字段信息
            $head_html = $body_html = '';
            foreach ($field_comment as $k => $v) {
                $search = ['___FIELD_COMMENT_', '___FIELD_'];
                $replace = [$v, $fields[$k]];
                $head_html .= str_replace($search, $replace, $list_head_html);
                $body_html .= str_replace($search, $replace, $list_body_html);
            }
            //要替换的占位符
            $search = ['___MODULE_', '___TABLE_', '___PK_', '___TITLE_', '___TABLEI_', '___LIST_HEAD_', '___LIST_BODY_','___SORT_'];
            //替换的数据
            $replace = [$module, $model, $pk, $title, $table_i, $head_html, $body_html,$sort];
            $lists_html = str_replace($search, $replace, file_get_contents($md_dir . 'Code/lists_tpl.html'));
            if (!is_dir($md_dir . 'View/' . $model . '/')) {
                mkdir($md_dir . 'View/' . $model . '/', 0775, true);
            }

            //生成模板文件
            $res = file_put_contents($md_dir . 'View/' . $model . '/' . 'lists.html', $lists_html);
            if ($res) {
                echo $md_dir . 'View/' . $model . '/' . 'lists.html' . '生成lists模板成功！<br>';
            }

            /***********生成add模板文件****************/
            //提换数据获得新数据
            $add_body_html = file_get_contents($md_dir . 'Code/add_body_tpl.html');
            $ajax_rules_html = file_get_contents($md_dir . 'Code/ajax_rules_tpl.html');
            $ajax_message_html = file_get_contents($md_dir . 'Code/ajax_messages_tpl.html');
            //遍历字段信息
            //遍历字段信息
            $fd_arr = explode(',',$fd);
            $rules_html = $message_html = '';
            foreach ($fd_arr as $v) {
                $search = ['___JFD_','___PK_'];
                $replace = [$v,$pk];
                $rules_html .= str_replace($search, $replace, $ajax_rules_html);
                $message_html .= str_replace($search, $replace, $ajax_message_html);
            }

           $add_body = '';
            foreach ($field_comment as $k => $v) {
                $search = ['___FIELD_COMMENT_', '___FIELD_'];
                $replace = [$v, $fields[$k]];
                $add_body .= str_replace($search, $replace, $add_body_html);
            }
            //要替换的占位符
            $search = ['___MODULE_', '___TABLE_', '___PK_', '___TITLE_', '___TABLEI_', '___ADD_HTML_','___SORT_','___AJAX_RULES_','___AJAX_MESSAGE_'];
            //替换的数据
            $replace = [$module, $model, $pk, $title, $table_i, $add_body,$sort,$rules_html,$message_html];
            $add_html = str_replace($search, $replace, file_get_contents($md_dir . 'Code/add_tpl.html'));
            if (!is_dir($md_dir . 'View/' . $model . '/')) {
                mkdir($md_dir . 'View/' . $model . '/', 0775, true);
            }

            //生成模板文件
            $res = file_put_contents($md_dir . 'View/' . $model . '/' . 'add.html', $add_html);
            if ($res) {
                echo $md_dir . 'View/' . $model . '/' . 'add.html' . '生成add模板成功！<br>';
            }


            /***********生成edit模板文件****************/
            //提换数据获得新数据
            $edit_body_html = file_get_contents($md_dir . 'Code/add_body_tpl.html');
            $ajax_rules_html = file_get_contents($md_dir . 'Code/ajax_rules_tpl.html');
            $ajax_message_html = file_get_contents($md_dir . 'Code/ajax_messages_tpl.html');
            //遍历字段信息
            //遍历字段信息
            $fd_arr = explode(',',$fd);
            $rules_html = $message_html = '';
            foreach ($fd_arr as $v) {
                $search = ['___JFD_','___PK_'];
                $replace = [$v,$pk];
                $rules_html .= str_replace($search, $replace, $ajax_rules_html);
                $message_html .= str_replace($search, $replace, $ajax_message_html);
            }

            $edit_body = '';
            foreach ($field_comment as $k => $v) {
                $search = ['___FIELD_COMMENT_', '___FIELD_'];
                $replace = [$v, $fields[$k]];
                $edit_body .= str_replace($search, $replace, $edit_body_html);
            }
            //要替换的占位符
            $search = ['___MODULE_', '___TABLE_', '___PK_', '___TITLE_', '___TABLEI_', '___EDIT_HTML_','___SORT_','___AJAX_RULES_','___AJAX_MESSAGE_'];
            //替换的数据
            $replace = [$module, $model, $pk, $title, $table_i, $edit_body,$sort,$rules_html,$message_html];
            $edit_html = str_replace($search, $replace, file_get_contents($md_dir . 'Code/edit_tpl.html'));
            if (!is_dir($md_dir . 'View/' . $model . '/')) {
                mkdir($md_dir . 'View/' . $model . '/', 0775, true);
            }

            //生成模板文件
            $res = file_put_contents($md_dir . 'View/' . $model . '/' . 'edit.html', $edit_html);
            if ($res) {
                echo $md_dir . 'View/' . $model . '/' . 'edit.html' . '生成edit模板成功！<br>';
            }


        } else {
            $this->display();
        }

    }
}