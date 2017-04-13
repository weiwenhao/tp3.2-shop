<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * 后台基础控制器
 * Class BaseController
 * @package Admin\Controller
 */
class BaseController extends Controller{
    //登陆限制,在构造方法中完成
    public function __construct()
    {
        //继承父类的构造方法,否则父类的构造方法会被重写
        parent::__construct();
        //登陆状态判断
        $admin_id = session('admin_id');
        if( !isset($admin_id)){
            $this->success('请先登陆',U('Login/login'));
            die;
        }
        //验证是否有权限访问当前控制器
        if( !D('authority')->checkAuth() && session('admin_id') != 0 && CONTROLLER_NAME != 'Index'){
            $this->error('无权访问');
            die;
        }
//        dump(D('authority')->getAuth()); die;
    }
}