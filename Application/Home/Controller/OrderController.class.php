<?php
namespace Home\Controller;
use Think\Controller;
class OrderController extends Controller {
    public function __construct()
    {
        parent::__construct();
        //用户从购物车界面,跳到这里,在这里先进行登录验证
        if(session('member_id') == null){
            //在session中记录当前地址
            session('returnURL','Order/add');
            redirect(U('Member/login'));
            die;
        }
    }

    public function add(){

        //再判断一下购物车是否存在数据
        if(M('cart')->select() == null){
          $this->success('购物车中没有商品',U('/'),2);
//            $this->success('购物车中没有商品','/',2);
            die;
        }

        if(IS_POST){
            $model = D('Admin/order');
            if( $model->create(I('post.'),1) ){
                if( $order_id = $model-> add()){
                    //订单创建成功,直接跳转到支付界面,不需要按钮手动点击
                    redirect(U('alipay',array('order_id'=>$order_id)) );
                    die;
                }
            }
            $this->error($model->getError());
        }
        //购物车数据,使用这个方法,可以得到已经处理好的数据
        $cart_data = D('cart')->getCart();
        //通用信息分配
        $this->assign(array(
            'cart_data' => $cart_data,
            '_page_title'=>'核对订单信息',
        ));
        $this->display();
    }

    /**
     * 支付包接口
     */
    public function alipay(){
        //配置api
        $order_id = I('get.order_id');
        //修改,并载入支付接口文件
        require ('./alipay_api/alipayapi.php');
    }
    /**
     * 支付宝支付结果通知,需要在配置文件中将回调参数配置到该方法
     */
    public function notify(){
    /*
     *  这里接收支付宝的消息,支付宝将会将一段post请求发送到这里,但不需要我们手动接收
        我们也不知道需要接收什么post文件,而且也无法验证post文件是否是由支付宝发过来的(安全性)
        所以直接使用接口中提供的notify_url来处理支付宝的通知消息即可,然后自行在notify中添加
        业务逻辑
    */

        require ('./alipay_api/notify_url.php');
    }

    /**
     * 订单提交成功之后的支付界面
     */
    public function order_success(){
        //载入支付表单
        $this->display();
    }

}