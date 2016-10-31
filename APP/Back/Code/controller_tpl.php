<?php
namespace ___MODULE_\Controller;

use Think\Controller;
use Think\Page;

class ___TABLE_Controller extends Controller
{
    /**
     * 添加动作
     */
    public function add()
    {
        // 判断是否为POST数据提交
        if (IS_POST) {
            // 数据处理
            // $model = M('___PK_');
            $model = D('___TABLE_');
            $result = $model->create();

            if (!$result) {
                $this->error('数据添加失败: ' . $model->getError(), U('add'));
            }

            $result = $model->add();
            if (!$result) {
                $this->error('数据添加失败:' . $model->getError(), U('add'));
            }
            // 成功重定向到list页
            $this->redirect('lists', [], 0);
        } else {
            // 表单展示
            $this->display();
        }
    }


    /**
     * 列表相关动作
     */
    public function lists()
    {

        $model = D('___TABLE_');

        // 分页, 搜索, 排序等
        // 搜索, 筛选, 过滤
        // 判断用户传输的搜索条件, 进行处理
        // $filter 表示用户输入的内容
        // $cond 表示用在模型中查询条件
        $cond = [];// 初始条件
        $filter['filter____TABLEI__name'] = I('get.filter____TABLEI__name', '', 'trim');
        if($filter['filter____TABLEI__name'] !== '') {
            $cond['___TABLEI__name'] = ['like', '%'.$filter['filter____TABLEI__name'].'%'];// 适当考虑索引问题
        }
        // 分配筛选数据, 到模板, 为了展示搜索条件
        $this->assign('filter', $filter);

        // 排序
        // 考虑用户所传递的排序方式和字段
        $order['field'] = I('get.field', '___TABLEI__sort', 'trim');// 初始排序, 字段
        $order['type'] = I('get.type', 'asc', 'trim');// 初始排序, 方式

        $sort = [$order['field'] => $order['type']];
        // $sort = $order['field'] . ' ' . $order['type'];
        $this->assign('order', $order);

        // 分页
        $page = I('get.p', '1');// 当前页码
        $pagesize = 8;// 每页记录数\\

        // 获取总记录数
        $count = $model->where($cond)->count();// 合计
        $t_page = new Page($count, $pagesize);// use Think\Page;
        // 配置格式
        $t_page->setConfig('next', '&gt;');
        $t_page->setConfig('last', '&gt;|');
        $t_page->setConfig('prev', '&lt;');
        $t_page->setConfig('first', '|&lt;');
        $t_page->setConfig('theme', '<div class="col-sm-6 text-left"><ul class="pagination">%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% </ul></div><div class="col-sm-6 text-right">%HEADER%</div>');
        $t_page->setConfig('header', '显示开始 %FIRST_ROW% 到 %LAST_ROW% 之 %TOTAL_ROW% （总 %TOTAL_PAGE% 页）');
        // 生成HTML代码
        $page_html = $t_page->show();
        $this->assign('page_html', $page_html);
          
        $rows = $model->where($cond)->order($sort)->page("$page, $pagesize")->select();
        $this->assign('rows', $rows);


        $this->display();
    }

    /**
     * 编辑
     */
    public function edit()
    {

        if (IS_POST) {

            $model = D('___TABLE_');
            $result = $model->create();

            if (!$result) {
                $this->error('数据修改失败: ' . $model->getError(), U('edit'));
            }

            $result = $model->save();
            if (!$result) {
                $this->error('数据修改失败:' . $model->getError(), U('edit'));
            }
            // 成功重定向到list页
            $this->redirect('lists', [], 0);

        } else {

            // 获取当前编辑的内容
            $___PK_ = I('get.___PK_', '', 'trim');
            $this->assign('row', M('___TABLE_')->find($___PK_));

            // 展示模板
            $this->display();
        }
    }


    /**
     * 批处理
     */
    public function multi()
    {
        // 确定动作
        $operate = I('post.operate', 'delete', 'trim');
        // 确定ID列表
        $selected = I('post.selected', []);

        switch ($operate) {
            case 'delete':
                // 使用in条件, 删除全部的品牌
                $cond = ['___PK_' => ['in', $selected]];
                M('___TABLE_')->where($cond)->delete();
                $this->redirect('lists', [], 0);
                break;
            default:
                # code...
                break;
        }
    }


    /**
     * ajax的相关请求
     */
    public function ajax()
    {
        $operate = I('request.operate', null, 'trim');

        if (is_null($operate)) {
            return ;
        }

        switch ($operate) {
            // 验证品牌名称唯一的操作
            case 'checkBrandUnique':
                // 获取填写的品牌名称
                $title = I('request.___TABLE__name', '');
                $cond['___TABLE__name'] = $title;
                // 判断是否传递了___PK_
                $___PK_ = I('request.___PK_', null);
                if (!is_null($___PK_)) {
                    // 存在, 则匹配与当前ID不相同的记录
                    $cond['___PK_'] = ['neq', $___PK_];
                }
                // 获取模型后, 利用条件获取匹配的记录数
                $count = M('___PK_')->where($cond)->count();
                // 如果记录数>0, 条件为真, 说明存在记录, 重复, 验证未通过, 响应false
                echo $count ? 'false' : 'true';
            break;
        }
    }
}