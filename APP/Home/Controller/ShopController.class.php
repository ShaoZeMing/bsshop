<?php

namespace Home\Controller;


class ShopController extends CommonController
{

    public function index()
    {
              
        // 推荐商品数据
        $m_goods = D('Goods');
//        p( $m_goods->getPromote());die;
        $this->assign('promote_goods_list', $m_goods->getPromote());

        // 展示首页模板
        $this->display();
        
    }

    /**
     * 搜索相关功能
     * @return [type] [description]
     */
    public function search()
    {
        // 用户所填写的关键词
        $query = I('q', '', 'trim');

        // 搜索(不满足自动加载)
        require VENDOR_PATH . 'XunSearch/lib/XS.php';
        $project = 'goods';
        $xs = new XS($project);
        $search = $xs->search;
        // 是否模糊搜索
        // $search->setFuzzy(true);
        $search->setQuery($query);
        // 排序
        // $search->setSort('sort_number', 'ASC');
        // limit
        // $pagesize = 12;
        // $page = I('p', '1', 'intval');// 考虑过界问题
        // $offset = ($page-1) * $pagesize;
        // $search->setLimit($pagesize, $offset);
        $docs = $search->search();

        // 总记录数, 当前匹配的记录数
        $count = $search->getLastCount();
        $total = $search->getDbTotal();
        // 如果搜索匹配数量较少, 给出用户建议:
        if ($count <= 3) {
            // 需要给出建议
           $words1 = $search->getExpandedQuery($query, 3);
           $words2 = $search->getCorrectedQuery($query);
           // 合并两组词, 取出重复词即可
           $words = array_unique(array_merge($words1, $words2));
        }

    }

    /**
     * 商品详细信息
     */
    public function goods()
    {

        $goods_id = I('get.goods_id', 0, 'trim');
        if ($goods_id == 0) {
            $this->redirect('/index', [], 0);
        }

//        p($goods_id);die;
        $m_goods = D('Goods');

        // 获取商品信息
        $goods = $m_goods->find($goods_id);
        $this->assign('goods', $goods);

//        p($goods);die;
        // 面包屑信息
        $breadcrumb = $m_goods->getBreadcrumb($goods_id);
        $this->assign('breadcrumb', $breadcrumb);
        // dump($breadcrumb);die;
         
        // 图像展示
        $this->assign('image_list', M('GoodsImage')->where(['goods_id'=>$goods_id])->select());

        $this->display();
    }
}