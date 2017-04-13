<?php
namespace Home\Model;
use Think\Model;
class CartModel extends Model
{
	protected $insertFields = array('goods_id','goods_attr_id','shop_number');
	protected $updateFields = array('cart_id','goods_id','goods_attr_id','shop_number');
	protected $_validate = array(
		array('goods_id', 'require', '请选择商品！', 1, 'regex', 3),
        array('shop_number','checkGoodsNum','库存量不足','1','callback',3)
	);

    /**
     * 验证用户加入购物车时,商品库存量是否充足
     * @param $goods_number
     */
    public function checkGoodsNum($shop_number){
        //得到用户选择的这件商品的这个属性的库存量
        $goods_id = I('post.goods_id');
        $goods_attr_id = I('post.goods_attr_id');//数组
        sort($goods_attr_id,SORT_NUMERIC); //数组升序排序
        if($goods_attr_id){
            $goods_attr_id = implode(',',$goods_attr_id);//数组转字符串
        }else{
            $goods_attr_id = '';
        }

        //查出该属性的库存属性
        $gn_data = M('goods_number')->where(array(
            'goods_id' => array('eq',$goods_id),
            'goods_attr_ids' => $goods_attr_id,
        ))->find();
//        dump(M('goods_number')->getLastSql());die;
        //因为上面使用了find方法,但此本次脚本创建的数据模型不会被覆盖,因为使用的是find不是本模型的
        //该商品的库存
        $goods_number = $gn_data['goods_number'];
        return ($shop_number <= $goods_number);
    }

    /**
     * 自定义改模型的添加数据库操作
     */
    public function add()
    {
        //明确一: 自动验证已经通过,没有使用find方法之前都可以使用模型中的表单数据,一旦使用了find方法,该数据则会被覆盖
        //判断用户是否登录
        $member_name = session('member_name');
        //已经经过表单验证的数据,一定要从数据模型中取出,不要通过post方法取出,不安全
        $goods_id = $this->goods_id;
        $goods_attr_id = $this->goods_attr_id; //数组格式
        sort($goods_attr_id,SORT_NUMERIC); //数组升序排序
        if($goods_attr_id){
            $goods_attr_id = implode(',',$goods_attr_id);//数组转字符串
        }else{
            $goods_attr_id = '';
        }

        $shop_number = $this->shop_number;
        if($member_name){ //用户已经登录 -> 加入到数据库中
            //判断数据库中是否存在该商品这个属性的数据 -> 查找数据库,能找到那就是有
            $cart_data = $this->where(array(
                'goods_id' => array('eq',$goods_id),
                'goods_attr_id' => array('eq',$goods_attr_id),
            ))->find(); //此时该模型中保存的数据已经被该find覆盖,仅限于$this->find;
            if($cart_data){//模型中存在,则叠加goods_num
                $cart_data['shop_number'] += $shop_number;
                //进行库存量判断
                if( $this->checkGoodsNum($cart_data['shop_number']) == false){
                    $this->error = '库存量不足';
                    return false;
                }
                $this->where(array(
                    'goods_id' => array('eq',$goods_id),
                    'goods_attr_id' => array('eq',$goods_attr_id),
                ))->setField('shop_number', $cart_data['shop_number']);//从新设置数据库中的shop_number字段
            }else{
                //不存在,则把该条数据加入到数据库中
                M('cart')->add(array(
                    'member_id' => session('member_id'),
                    'goods_id' => $goods_id,
                    'goods_attr_id' => $goods_attr_id,
                    'shop_number' => $shop_number,
                ));
            }
            return true;
        }else{//用户未登录 -> 存储到cookie中,使用二维数组的方式
            $cart_data = isset( $_COOKIE['cart_data'])?unserialize($_COOKIE['cart_data']):array();
            //制作一条购物信息
            $key = $goods_id.'-'.$goods_attr_id; //string(7) "88-9,12"

            //判断cookie中是否存在这条数据,判断依据:商品id和商品属性id相同,如果存在则goods_numer叠加
            if($cart_data[$key] != null ){
                //如果已经存在这个商品和属性,则取出其number,并叠加,
                $cart_data[$key] += $shop_number; //原来的数量,并叠加上现在的数量
                $cart_data[$key] = (string)$cart_data[$key];
                //进行库存量判断
                if( $this->checkGoodsNum($cart_data[$key]) == false){
                    $this->error = '库存量不足';
                    return false;
                }
            }else{
                //如果cookie中不存在这条数据,则进行数据的的cookie插入
                $cart_data[$key] = $shop_number;
            }
            //把添加好的数组存回cookie,有效期30天
            setcookie('cart_data',serialize($cart_data),time()+86400,'/');
            //返回添加成功
            return true;
        }
    }

    /**
     * 得到浏览者购物车中的数据
     * @return array $data 购物车数组
     */
    public function getCart(){
        $member_id = session('member_id');
        $member_name = session('member_name');
        $data = array(); //最终返回的data,cookie中和sql中取出的应该是相同的,第一步先统一
        if($member_name){//用户已经登录,从数据库中取出数据
            $data = D('cart')->alias('a')->where(array(
                'member_id' => array('eq',$member_id)
            ))->select();
        }else{//用户未登录,从cookie中取出数据
            $cart_data = isset($_COOKIE['cart_data'])?unserialize($_COOKIE['cart_data']):array();
            if($cart_data){
                //制作前台可以遍历的数组
                foreach($cart_data as $k => $v){
                    //$k : "88-10,3"  $v : 7(goods_number)
                    $arr = explode('-',$k);
                    $goods_id = $arr[0];
                    $goods_attr_id = $arr[1];//字符串格式9,12
                    $shop_number = $v;
                    $onedata['goods_id'] = $goods_id;
                    $onedata['goods_attr_id'] = $goods_attr_id;
                    $onedata['shop_number'] = $shop_number;
                    $data[] = $onedata;
                }
            }
        }
        //对$data中$v的数据进行完善处理,处理成需要遍历的数据,包括商品图片,名称,价格,小计等
        foreach ($data as $k => &$v){
            //$v : 一维数组,有goods_id,goods_attr_id,shop_number
            $goods_id = $v['goods_id'];
            $goods_attr_id = $v['goods_attr_id'];
            $shop_number = $v['shop_number'];
            $goods_data = D('goods')->field('goods_id,goods_name,sm_goods_img')->find($goods_id);
            $v['goods_id'] = $goods_data['goods_id'];
            $v['goods_name'] = $goods_data['goods_name'];
            $v['sm_goods_img'] = $goods_data['sm_goods_img'];
            $gd_data = D('goods_attr')->field('b.attr_name,a.attr_value')
                ->alias('a')
                ->join('LEFT JOIN __ATTRIBUTE__ b ON a.attr_id=b.attr_id')
                ->where(array(
                    'a.goods_attr_id' => array('in',$goods_attr_id)
                ))->select();  //得到一个二维数组
            $v['goods_attr_data'] = $gd_data;
            //商品单价,实际购买价格
            $goumai_price = D('Admin/goods')->getRealityPrice($goods_id);
            $v['goumai_price'] = $goumai_price;
            //小计
            $v['xiaoji'] = $goumai_price*$shop_number;
        }
        return $data;
    }


}