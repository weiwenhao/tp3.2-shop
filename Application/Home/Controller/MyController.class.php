<?php
namespace Home\Controller;
/**
 * 个人中心控制器
 * Class IndexController
 * @package Home\Controller
 */
class MyController extends NavController {
    public function order(){
        //登录验证
        //用户从购物车界面,跳到这里,在这里先进行登录验证
        if(session('member_id') == null){
            //在session中记录当前地址
            session('returnURL','My/'.ACTION_NAME); //ACTION_NAME为tp内置常量,记录了操作方法名称
            redirect(U('Member/login'));
            die;
        }
        //我的订单数据
        $data = D('Admin/order')->search();
        $this->assign($data);

        //通用信息
        $this->assign(array(
            'index' => 0,
        ));
        $this->display();
    }
}