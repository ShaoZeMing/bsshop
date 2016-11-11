<?php

namespace Home\Controller;


class ShopController extends CommonController
{

    public function index()
    {

        // 推荐商品数据
        $m_goods = D('Goods');
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
        $m_goods = D('Goods');
        // 获取商品信息
        $goods = $m_goods->find($goods_id);
        $this->assign('goods', $goods);

/*        p($goods);die;

         dump($breadcrumb);die;

        利用了AJAX展示图像这个就不用了
         图像展示
       $this->assign('image_list', M('GoodsImage')->where(['goods_id' => $goods_id])->order('goods_sort')->select());

        获取所有属性
        $m_AVView = D('AttributeValueView');
        $goods_attr = $m_AVView->getAttribute($goods_id);
        $product_list = D('GoodsProduct')->where(['goods_id'=>$goods_id])->relation(true)->select();

        p($product_list);die;
        $this->assign('goods_attr', $goods_attr);*/
        $this->display();
    }

    public function ajax()
    {
        $operate = I('request.operate', null, 'trim');

        if (is_null($operate)) {
            $this->ajaxReturn(['error'=>1, 'errorInfo'=>'没有对应方法']);

        }
        switch ($operate) {
            // 获取商品属性值
            case 'goods_attr':
                $goods_id = I('request.goods_id', null);
                //获取商品所有属性
                $goods_attr = D('AttributeValueView')->getAttribute($goods_id);
                //获取货品所有属性与值
                $product_list = D('GoodsProduct')->where(['goods_id'=>$goods_id])->relation(true)->select();
                if ($goods_attr) {
                    $this->ajaxReturn(['error' => 0, 'msg' => $goods_attr,'pro'=> $product_list]);
                } else {
                    $this->ajaxReturn(['error' => 1, 'errorInfo' => '获取数据失败']);
                }
                break;
            // 获取商品图片
            case 'goods_image':
                $goods_id = I('request.goods_id', null);
                //获取所有图片
                $image = M('GoodsImage')->where(['goods_id' => $goods_id])->order('goods_sort')->select();
               //获取面包陷导航
                $breadcrumb = D('Goods')->getBreadcrumb($goods_id);
                if ($image) {
                    $this->ajaxReturn(['error' => 0, 'msg' => $image ,'bre'=>$breadcrumb]);
                } else {
                    $this->ajaxReturn(['error' => 1, 'errorInfo' => M('GoodsImage')->getError()]);
                }
                break;
        }

    }
}