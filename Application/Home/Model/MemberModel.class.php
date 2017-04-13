<?php
namespace Home\Model;
use Think\Model;
class MemberModel extends Model
{
	protected $insertFields = array('member_name','password','password2','captcha','must');
	protected $updateFields = array('member_id','member_name','password','password2');
	protected $_validate = array(
		array('member_name', 'require', '用户名称不能为空！', 1, 'regex', 3),
		array('member_name', '', '用户名称已经存在！', 1, 'unique', 1),
		array('member_name', '3,20', '用户名称3-20位字符！', 1, 'length', 3),
		array('password', 'require', '密码不能为空！', 1, 'regex', 1),
        array('password', '6,20', '密码必须是6-20位字符！', 1, 'length', 3),
        array('password2','password','两次输入的密码不相同!',1,'confirm',3),//密码二次验证,该字段不加入数据库
        array('captcha', 'require', '验证码不能为空！', 1, 'regex', 1),
        array('captcha', 'checkCaptcha', '验证码错误！', 1, 'callback',1),
        array('must', 'require', '请勾选《用户注册协议》！', 1, 'regex', 1),
        //以下是create方法第二个参数为4时会进行验证的方法 , 即登录时进行的验证
        array('member_name', 'require', '用户名称不能为空！', 1, 'regex', 4),
        array('password', 'require', '密码不能为空！', 1, 'regex', 4),
		array('captcha', 'require', '验证码不能为空！', 1, 'regex', 4),
		array('captcha', 'checkCaptcha', '验证码错误！', 1, 'callback',4),
	);

    /**
     * 验证验证码是否正确
     * @param $code 用户输入的验证码,这里是验证规则captcha中的值
     * @return bool
     */
    public function checkCaptcha($code){
        //$code是验证规则中字段的值,表示用户输入的验证码
        $verify = new \Think\Verify();
        return $verify->check($code);
    }

    /**
     * 验证用户名和密码
     * @return bool
     */
    public function checkLogin(){
        /* dump($this->data);die; //$data中包含有 用户名信息和密码,不包括验证码 ,这是为什么????????????????
        解答:因为验证码不是数据库中的字段
        *array(2) {
             ["admin_name"] => string(3) "123"
             ["password"] => string(4) "1234"}*/
        $member_name = $this->member_name;
        $password = $this->password;
        $member_data = $this->where(array(
            'member_name'=>array('eq',$member_name),
        ))->find();
        if($member_data){
            if($member_data['password'] == md5($password) ){
                //把用户名和id和头像,保存在session中
                session('member_id',$member_data['member_id']);
                session('member_name',$member_data['member_name']);

                //todo 这里用户头像写写死了
                session('member_face','/Public/Home/Images/user2.jpg');

                /*************************计算一下该用户的会员等级*****************************/
                $jifen = $member_data['jifen'];
                $level_data = D('Admin/member_level')
                    ->field('level_id')
                    ->where(array(
                        'jifen_bottom' => array('ELT',$jifen),
                        'jifen_top' => array('EGT',$jifen)
                ))->find();
                //把级别id存储在session中
                session('level_id',$level_data['level_id']);

                /******************登录成功后,把cookie中的购物车数据存储到数据库中***********************/
                //取出cookie中的数据,存储到数据库中
                $c_cart_data = isset( $_COOKIE['cart_data'])?unserialize($_COOKIE['cart_data']):array();
                if($c_cart_data){//如果cookie中存在数据,则进行和购物车的合并
                   //将cookie中的数据和数据库中的数据进行合并
                   $model = M('cart'); //这里一定要调用到父类的add方法才行(既一个没有被重写过的model)
                   foreach ($c_cart_data as $k => $v){
                       //$k  : "88-9,12"  $v : 7
                       $arr = explode('-',$k);
                       $goods_id = $arr[0];
                       $goods_attr_id = $arr[1];//字符串格式9,12
                       $shop_number = $v;
                       //判断数据库中是否存在该条数据
                       //判断数据库中是否存在该商品这个属性的数据 -> 查找数据库,能找到那就是有
                       $db_cart_data = $model->where(array(
                           'goods_id' => array('eq',$goods_id),
                           'goods_attr_id' => array('eq',$goods_attr_id),
                       ))->find();
                       $db_shop_number = $db_cart_data['shop_number'];
                       if($db_cart_data){//模型中存在,则更新goods_num
                           $db_cart_data['shop_number'] += $shop_number;
                           //进行库存量判断
                           $gn_data = M('goods_number')->where(array( //查出该属性的库存数据
                               'goods_id' => array('eq',$goods_id),
                               'goods_attr_ids' => array('eq',$goods_attr_id)
                           ))->find();
                           //该商品的库存
                           if( $db_cart_data['shop_number'] > $gn_data['goods_number']){ //购买数量大于库存量
                               $db_cart_data['shop_number'] = max($db_shop_number,$shop_number);
                            }
                            //对数据库中的商品数量字段进行修改
                            $model->where(array(
                               'goods_id' => array('eq',$goods_id),
                               'goods_attr_id' => array('eq',$goods_attr_id),
                           ))->setField('shop_number', $db_cart_data['shop_number']);//从新设置数据库中的shop_number字段
                       }else{
                           //不存在,则把该条数据加入到数据库中
                            $model->add(array( //这里使用的是父类的构造方法
                               'member_id' => session('member_id'),
                               'goods_id' => $goods_id,
                               'goods_attr_id' => $goods_attr_id,
                               'shop_number' => $shop_number,
                           ));
                       }
                   }
                   //清空cookie中购物车的数值
                   cookie('cart_data',null);
                }
                /********************该方法的返回值*************************/
                return true; //checkLogin方法的最终返回值
            }
            $this->error = '密码错误!';
            return false;
        }
        $this->error = '用户名不存在';
        return false;
    }

    /**
     * 退出登录,清空session
     */
    public function logout(){
        session(null);
    }

	// 添加前
	protected function _before_insert(&$data, $option)
	{
        $data['password'] = md5($data['password']); //密码MD5加密
	}

	//添加后
    protected function _after_insert($data, $options)
    {

    }

    // 修改前
	protected function _before_update(&$data, $option)
	{




        //对密码进行MD5加密
            $data['password'] = md5($data['password']);

	}
	// 删除前
	protected function _before_delete($option)
	{



	}
	/************************************ 其他方法 ********************************************/
}