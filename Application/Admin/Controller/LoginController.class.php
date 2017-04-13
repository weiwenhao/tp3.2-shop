<?php
namespace Admin\Controller;
use Think\Controller;
/**
 * 登录控制器
 */
class LoginController extends Controller{
    public function login(){
       $model = D('Admin');
        if(IS_POST){
            //自动验证
            if( $model->field('admin_name,password,captcha')->create(I('post.'),4) ){
                //登录验证
                if($model->checkLogin()){
                    //通过进行界面跳转
                    $this->success('登录成功,页面跳转中...',U('Index/index'));
                    die;
                }
            }
            //登录失败的错误提示
            $this->error($model->getError());

        }
        $this->display();
    }

    /**
     * 退出后台
     */
    public function logout(){
        //session(null);  这里直接清空跳转,和调用模型中的方法跳转有什么分别吗
        //调用退出方法
        D('admin')->logout();
        //跳转到登陆界面
        $this->redirect('login');
        //$this->redirect(U('login'));//这样写不行
        // redirect(U('Login/login'));
        //控制器的redirect方法和redirect函数的区别在于前者是用URL规则定义跳转地址，后者是一个纯粹的URL地址。
        die;
    }

    /**
     * 生成验证码操作方法
     */
    public function captcha(){
        ob_clean(); //清除缓冲区中的数据
        $Verify =  new \Think\Verify();
        $Verify->fontSize =20;
        $Verify->length   = 4;
        $Verify->useNoise = true; // 关闭验证码杂点
        $Verify->entry();
    }
}