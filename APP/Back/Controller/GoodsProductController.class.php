<?php
namespace Back\Controller;

use Think\Controller;
use Think\Page;

class GoodsProductController extends Controller
{
    /**
     * 添加动作
     */
    public function add()
    {
        // 判断是否为POST数据提交
        if (IS_POST) {
            // 数据处理
            $model = D('GoodsProduct');
            $result = $model->create();    //创建数据对象

            if (!$result) {
                $this->error('数据添加失败: ' . $model->getError(), U('add'));
            }

            //添加数据
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
    /**
     * 编辑
     */
    public function lists()
    {


        $goods_id  = I('get.goods_id', 0, 'intval');

        // 当前商品信息
        $goods = M('Goods')->find($goods_id);
        $this->assign('goods', $goods);

        // 商品具有的选项
        $mm=M('GoodsAttributeValue');
        $option_rows =$mm->join('left join __GOODS_ATTRIBUTE__  using(goods_attribute_id)')
            ->where(['goods_id'=>$goods_id, 'is_option'=>1])
            ->select();
        $m_attr_option = M('AttributeOption');
//        echo $mm->getLastSql();
//        dump($option_rows);die;
        // value: 10,8,11,12
        // 遍历当前商品的全部选项
        foreach($option_rows as $key=>$option) {
            // 通过选项的$option['value']: 10,8,11,12, 获取选项的其他信息, 例如title
            $option_rows[$key]['value_list'] = $m_attr_option->where(['attribute_option_id'=>['in', $option['goods_attribute_value']]])->select();
        }

        $this->assign('option_rows', $option_rows);



        $model = D('GoodsProduct');
        // 分页, 搜索, 排序等
        // 搜索, 筛选, 过滤
        // 判断用户传输的搜索条件, 进行处理
        // $filter 表示用户输入的内容
        // $cond 表示用在模型中查询条件
        $cond = $filter = [];// 初始条件
        // 在生成代码的基础上, 自定义完成搜索条件
        $cond['goods_id'] = $goods_id;
        // 分配筛选数据, 到模板, 为了展示搜索条件
        $this->assign('filter', $filter);

        // 排序
        $sort = $order = [];
        // 考虑用户所传递的排序方式和字段
        // 在生成代码的基础上,自定义默认的排序字段(假设,表中存在sort_number字段, 不存在需要修改)
        // $order['field'] = I('get.field', 'sort_number', 'trim');// 初始排序, 字段
        // $order['type'] = I('get.type', 'asc', 'trim');// 初始排序, 方式

        if (!empty($order)) {
            $sort = $order['field'] . ' ' . $order['type'];
        }
        $this->assign('order', $order);

        // 分页
        $page = I('get.p', '1');// 当前页码
        $pagesize = 10;// 每页记录数\\

        $rows = $model->where($cond)->order($sort)->relation(true)->select();
        // 利用rows中的option['attribute_option_id']得到选项的title
//        p($rows);die;

        $m_attribute_option = M('AttributeOption');
        // 遍历货品
        foreach($rows as $key=>$product) {
            // 遍历货品中的选项
            foreach($product['option'] as $k=>$value) {
                // 利用选项主键检索
                $cond['attribute_option_id'] = $value['attribute_option_id'];
                // 选项标题字段
                $rows[$key]['option'][$k]['option_title'] = $m_attribute_option->where($cond)->getField('attribute_option_name');
            }
        }
//        p($option_rows);

//        p($rows);die;
        $this->assign('rows', $rows);

        $this->display();
    }

    /**
     * 编辑
     */
    public function edit()
    {

        if (! IS_POST) {
            $this->redirect('lists', [], 0);
        }

//        p($_POST);die;

        $goods_id = I('post.goods_id');
        $product_list = I('post.product', []);

        $m_goods_product = M('GoodsProduct');

        // 处理每个货品数据
        foreach($product_list as $product) {
            // 依次处理每个货品信息
            // 先处理product
            $product_data =[
                'goods_id'  => $goods_id,
                'goods_product_quantity'  => $product['product_quantity'],
                'goods_product_price'  => $product['product_price'],
                'goods_price_operate'  => $product['price_operate'],
                'goods_price_enabled'  => isset($product['enabled']) ? '1' : '0',
            ];
            $goods_product_id = $m_goods_product->add($product_data);

            // 再处理product_option
            // 处理成2维数组,
            $product_option_data = array_map(function($attribute_option_id) use($goods_product_id) {
                return [
                    'goods_product_id'  => $goods_product_id,
                    'attribute_option_id'   => $attribute_option_id,
                ];
            }, $product['option']);
            $m_product_option = M('ProductOption');
            // 一次性插入
            $m_product_option->addAll($product_option_data);
        }

        // 更新已经存在的货品信息
        $goods_product_list = I('post.option', []);
        foreach($goods_product_list as $goods_product_id => $product) {
            $product_data =[
                'goods_product_id'  => $goods_product_id,
                'goods_product_quantity'  => $product['goods_product_quantity'],
                'goods_product_price'  => $product['goods_product_price'],
                'goods_price_operate'  => $product['goods_price_operate'],
                'goods_price_enabled'  => isset($product['goods_price_enabled']) ? '1' : '0',
            ];
            // 更新数据即可
            $m_goods_product->save($product_data);
        }

        // 回到货品列表页面
        $this->redirect('lists', ['goods_id'=>$goods_id], 0);

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
                $cond = ['goods_product_id' => ['in', $selected]];
                M('GoodsProduct')->where($cond)->delete();
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
//
            $operate = I('request.operate', null, 'trim');

            if (is_null($operate)) {
                return ;
            }
            switch ($operate) {
                // 验证品牌名称唯一的操作
                case 'delete':
                    $goods_product_id = I('request.goods_product_id', []);
                    if (empty($goods_product_id)) {
                        $this->ajaxReturn(['error'=>0]);
                    }
                    if (M('GoodsProduct')->delete(implode(',', $goods_product_id))) {
                        $this->ajaxReturn(['error'=>0]);
                    } else {
                        $this->ajaxReturn(['error'=>1, 'errorInfo'=>M('GoodsProduct')->getError()]);
                    }

                    break;
            }
        }

}