<?php
namespace Home\Controller;
use Think\Controller;
class CartController extends Controller {
    public function add(){
        $goods_id = I('post.goods_id');
        $model = D('cart');
        if( $model->create(I('post.'),1) ){
            if( $model-> add()){
                $this->success('添加成功',U('Index/goods',array('goods_id'=>$goods_id)),2);
                die;
            }
        }
        $this->error($model->getError());
    }

    public function lst(){

        $model = D('cart');
        $cart_data = $model->getCart();
        //数据分配
        $this->assign(array(
            'cart_data' => $cart_data,
        ));

        //通用信息分配
        $this->assign(array(
            '_page_title'=>'购物车',
            '_page_keywords'=>'购物车',
            '_page_description'=>'购物车',
        ));
        $this->display();
    }

    /**
     * 得到购物车数据
     * 输出json数据
     */
    public function ajaxgetCart(){
        $data = D('cart')->getCart();
        echo json_encode($data);
    }
}