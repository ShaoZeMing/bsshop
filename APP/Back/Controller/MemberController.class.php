<?php

namespace Back\Controller;

use Think\Controller;
use Think\Page;

class MemberController extends Controller
{

	public function lists()
	{

		// 利用模型获取数据
		$m_member = M('Member');

		// 查询条件
		$cond = [];
		// $offset = ($page - 1) * $pagesize;
		// $m_member->limit("$offset, $pagesize")->select();
		
		$page = I('get.p', '1');
		$pagesize = 2;
		$rows = $m_member
				->where($cond)
				->page("$page, $pagesize")// 自动计算offset,
				->select();
		$this->assign('rows', $rows);

		// 获取总记录数
		$count = $m_member->where($cond)->count();// 合计
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


		// 展示分页列表
		$this->display(); 
		
	}


	public function multi()
	{
		// 获取操作类型
		$operate_type = I('post.operate_type', 'delete');

		// 获取所有的会员ID
		$selected = I('post.selected', []);

		// 依据操作类型, 执行不同的操作
		switch ($operate_type) {
			case 'mail':
			// 批量发送邮件
			// 将任务加入队列即可. 
			$redis = new \Redis;
			$redis->connect('127.0.0.1', '6379');
			$redis->auth('hellokang');
			// var_dump($selected);
			foreach($selected as $member_id) {
				$redis->lpush('member_list', $member_id);
			}
			break;
		}

		$this->success('已经加入邮件发送队列, 执行其他操作即可', U('list'));
	}
}