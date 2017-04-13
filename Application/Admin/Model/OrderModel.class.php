<?php
namespace Admin\Model;
use Think\Model;
class OrderModel extends Model
{
	protected $insertFields = array('shr_name','shr_tel','shr_pr','shr_city','shr_area','shr_address');
	protected $_validate = array(
		array('shr_name', 'require', '收货人姓名不能为空！', 1, 'regex', 3),
		array('shr_pr', 'require', '省份不能为空！', 1, 'regex', 3),
		array('shr_city', 'require', '所在市不能为空！', 1, 'regex', 3),
		array('shr_area', 'require', '所在区不能为空！', 1, 'regex', 3),
		array('shr_address', 'require', '详细地址不能为空！', 1, 'regex', 3),
        array('shr_tel', 'require', '手机号码不能为空！', 1, 'regex', 3),
//		array('shr_tel', 'number ', '手机号码格式错误！', 1, 'regex', 3),
		array('shr_tel', '11', '手机号码格式错误！', 1, 'length', 3),

	);
    public function _before_insert(&$data, &$options)
    {
        //在订单界面的数据插入数据库之前,对数据进行验证和补全(如,插入时间,会员id,订单总价)
        /****************验证*********************/
        /*这些验证是在order表单提交时进行的验证,而不是在购物车界面点击结算时进行的验证*/
        //登录验证
        $member_id = session('member_id');
        if($member_id === null){
            //记录当前控制器和操作方法(存储在session中)
            $this->error = '请先登录!';
            //跳转到登录界面
            return false;
        }
        //购物车商品是否为空验证(到这里必然已经登录,直接在数据库中取数据验证即可)
        $cart_data = M('cart')->where(array(
            'member_id' => array('eq',$member_id),
        ))->select();
        //购物车数据放在option中传递到插入之后的钩子函数,以便给后续调用,而不需要再次实例化模型,options就是用来存储额外的数据
        $options['cart_data'] = $cart_data;
        if(!$cart_data){
            $this->error = '购物车中没有商品!';
            return false;
        }
        //库存量验证,循环购物车中的每一件商品
        $total_price = 0;//记录商品总价
        $gn_model = M('goods_number');
        $g_model = D('Admin/goods');
        $options['g_model'] = $g_model;
        $options['gn_model'] = $gn_model;
        //加锁
        $this->fp = fopen('./LOCK/order.lock','r'); //打开锁文件
        flock($this->fp,LOCK_EX); //排他锁
        foreach ($cart_data as $k => $v){
            //得到用户选择的这件商品的这个属性的库存量
            $goods_id = $v['goods_id'];
            $goods_attr_id = $v['goods_attr_id'];//字符串,已经排序,并且取出来的应该是个空字符串才对
            //查出该属性的库存属性
            $gn_data = $gn_model->where(array(
                'goods_id' => array('eq',$goods_id),
                'goods_attr_ids' => $goods_attr_id,
            ))->find();
            //库存量判断
            if($gn_data['goods_number'] < $v['shop_number']){
                $this->error = '库存量不足';
            }
            //计算商品单价
            $goumai_price = $g_model->getRealityPrice($goods_id);
            $total_price += $v['shop_number']*$goumai_price;

        }
        //其他信息补全
        $data['member_id'] = $member_id;
        $data['add_time'] = time();
        $data['total_price'] = $total_price;
        //接下来要进行数据库的插入操作,和另外两张表的维护操作,因此在这里开启事务,事务方法属于模型,但影响范围是跨模型的
        $this->startTrans();

    }
    public function _after_insert($data, $options)
    {
        //在基本信息插入之后,根据插入的order_id,维护订单商品表
        $order_id = $data['order_id'];
        $cart_data = $options['cart_data'];
        $og_model = M('order_goods');
        foreach($cart_data as $k => $v){
            //制作shop_price数据,因为此时的shop_price已经固定了,所以可以直接存储在数据库中了
            $shop_price = $options['g_model']->getRealityPrice($v['goods_id']);
            //插入数据
            $ret = $og_model->add(array(
                'order_id' => $order_id,
                'goods_id' => $v['goods_id'],
                'goods_attr_id' => $v['goods_attr_id'],
                'shop_number' => $v['shop_number'],
                'shop_price' => $shop_price,
            ));
            if($ret === FALSE){ //增加操作返回新增加的记录的主键id,失败返回FALSE
                //回滚事务,返回FALSE
                $this->rollback();
                return FALSE;
            }
            //库存削减,通过商品id,和商品属性id确定一条库存属性
            $ret = $options['gn_model']->where(array(
                'goods_id' => array('eq',$v['goods_id']),
                'goods_attr_ids' => array('eq',$v['goods_attr_id']),
            ))->setDec('goods_number',$v['shop_number']);
            if($ret === FALSE){ //增加操作返回新增加的记录的主键id,失败返回FALSE
                //回滚事务,返回FALSE
                $this->rollback();
                return FALSE;
            }
            //清空购物车操作,为了以后的细化(比如只购买购物车中的个别数据)
            M('cart')->delete($v['cart_id']);
        }

        //两张表的数据修改完毕,提交事务
        $this->commit();
        //库存削减完毕,解锁
        flock($this->fp,LOCK_UN);
        fclose($this->fp); //关闭文件
    }
    /**
     * 会员支付成功后,更新支付状态等
     * 安全性考虑,用户可以模拟访问到模型中的方法吗?
     * @param int $order_id 订单id
     */
    public function paySuccess($order_id){
        //更新支付状态和支付时间
        $this->where(array(
            'order_id' => array('eq',$order_id),
        ))->setField(array(
            'pay_status' => '是',
            'pay_time' => time(),
        ));
        //更新会员积分
        $order_data = $this->where(array(
        'order_id' => array('eq',$order_id),
        ))->find();
        M('member')->where(array(
            'member_id' => array('eq',$order_data['member_id'])
        ))->setInc('jifen',$order_data['total_price']);
    }


    public function search($pageSize = 6)
    {
        /************************************* 翻页 ****************************************/
        $count = $this->alias('a')->where(array(
            'member_id'=>array('eq',session('member_id'))
        ))->count();
        $page = new \Think\Page($count, $pageSize);
        // 配置翻页的样式
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $data['page'] = $page->show();
        /************************************** 取数据 ******************************************/
        $data['data'] = $this
            ->field('a.order_id,a.shr_name,a.total_price,a.add_time,a.pay_status,group_concat(DISTINCT c.sm_goods_img) sm_goods_img')
            ->alias('a')
            ->join('LEFT JOIN __ORDER_GOODS__ b ON a.order_id=b.order_id')
            ->join('LEFT JOIN __GOODS__ c ON b.goods_id=c.goods_id')
            ->group('a.order_id')
            ->where(array(
                'member_id'=>array('eq',session('member_id'))
            ))
            ->limit($page->firstRow.','.$page->listRows)
            ->select();
        $data['noPayCount'] = $this->where(array(
            'pay_status' => array('eq','否'),
            'member_id'=>array('eq',session('member_id'))
        ))->count();
        return $data;
    }
}