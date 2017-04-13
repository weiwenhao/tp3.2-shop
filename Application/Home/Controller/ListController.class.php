<?php
namespace Home\Controller;
class ListController extends NavController {
    public function catList(){
        $cat_id = I('get.cat_id');
        /********根据cat_id和筛选条件已分页形式搜索出商品**********/
        $data = D('Admin/goods')->getGoodsByCatId($cat_id);
        /**
         * 这里不能直接使用 $data['data']['goods_id'] 因为其只有和分页偏移量一样的数量
         * 而我们用来制作筛选条件的商品id应该是当前分类下的所有商品id,因此在getGoodsByCatId
         * 方法中封装一个goods_id数据
         */
        $goods_id = $data['goods_id']; //字符串格式
        /***********根据上面检索出的商品id拼凑出筛选条件****************/
        $condition_data = D('Admin/goods')->getConditionBygoodsId($goods_id);
        $this->assign(array(
            'condition_data' => $condition_data,
        ));
        $this->assign($data);
        $this->assign(array(
            'index' => 0,
            '_page_title'=>'商品列表页',
            '_page_keywords'=>'商品列表页',
            '_page_title'=>'商品列表页',
        ));
        $this->display();
    }
    public function keyList(){
        $key = I('get.key');
        /********根据key和筛选条件已分页形式搜索出商品**********/
        $data = D('Admin/goods')->getGoodsByKey($key);
        /**
         * 这里不能直接使用 $data['data']['goods_id'] 因为其只有和分页偏移量一样的数量
         * 而我们用来制作筛选条件的商品id应该是当前分类下的所有商品id,因此在getGoodsByCatId
         * 方法中封装一个goods_id数据
         */
        $goods_id = $data['goods_id']; //字符串格式
        /***********根据上面检索出的商品id拼凑出筛选条件****************/
        $condition_data = D('Admin/goods')->getConditionBygoodsId($goods_id);
        $this->assign(array(
            'condition_data' => $condition_data,
        ));
        $this->assign($data);
        $this->assign(array(
            'index' => 0,
            '_page_title'=>'商品列表页',
            '_page_keywords'=>'商品列表页',
            '_page_title'=>'商品列表页',
        ));
        $this->display();
    }
}