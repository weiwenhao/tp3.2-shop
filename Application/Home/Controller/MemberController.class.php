<?php
namespace Home\Controller;
use Think\Controller;
class MemberController extends Controller {
    public function regist(){
        if(IS_POST){
            $model = D('member');
            if( $model->create( I('post.'),1) ){//自动验证
                if( $model->add() ){//入库操作
                    $this->success('注册成功!',U('login'),2);
                    die;
                }
            }
            $this->error($model->getError());
        }
        //通用信息分配
        $this->assign(array(
            '_page_title'=>'会员注册',
            '_page_keywords'=>'京西注册',
            '_page_description'=>'京西注册',
        ));
        $this->display();
    }

    public function login(){
        if(IS_POST){
            $model = D('member');
            if( $model->field('member_name,password,captcha')->create( I('post.'),4) ){//自动验证
                if($model->checkLogin()){
                    //跳转之前进行判断,查看session中是否有地址信息
                    if(session('returnURL')){
                        $this->success('登录成功!',U(session('returnURL')),2);
                        //清空session中的地址
                        session('returnURL',null);
                        die;
                    }

                    $this->success('登录成功!',U('/'),2);
                    die;
                }
            }
            $this->error($model->getError());
        }

        //通用信息分配
        $this->assign(array(
            '_page_title'=>'会员登录',
            '_page_keywords'=>'京西登录',
            '_page_description'=>'京西登录',
        ));
        $this->display();
    }

    public function logout(){
        D('member')->logout(); //调用模型中退出方法
        $this->redirect('/');
    }
    /**
     * 验证码
     */
    public function captcha(){
        ob_clean();
        $Verify = new \Think\Verify();
        $Verify->fontSize = 20;
        $Verify->length   = 4;
        $Verify->useImgBg = true;
        $Verify->useNoise = false;
        $Verify->entry();
    }
}