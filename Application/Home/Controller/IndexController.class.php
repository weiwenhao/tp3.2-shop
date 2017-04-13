<?php
namespace Home\Controller;
class IndexController extends NavController {
    /**
     * 商场前台首页
     */
    public function index(){
        $model = D('Admin/goods');
        $promoteGoods = $model->getPromoteGoods();
        $hotGoods = $model->getHotGoods();
        $bestGoods = $model->getBestGoods();
        $newGoods = $model->getNewGoods();
        $floorData = $model->getFloor();
        $this->assign(array(
            'floorData'=>$floorData,
            'promoteGoods'=>$promoteGoods,
            'hotGoods'=>$hotGoods,
            'bestGoods'=>$bestGoods,
            'newGoods'=>$newGoods,
        ));
        //通用信息分配
        $this->assign(array(
            '_page_title'=>'京西商城',
            '_page_keywords'=>'京西商城',
            '_page_description'=>'京西商城',
            'index'=> 1,
        ));
        $this->display();
    }
    /**
     * 商品详情页
     */
    public function goods(){
        $goods_id = I('get.goods_id');
        //基础信息
        $data = D('goods')
            ->where(array(
            'goods_id' => array('eq',$goods_id),
        ))->find();
        //查找改商品的顶级分类,和二级分类数组
        $cat12 = D('Admin/category')->getCat12($data['cat_id']);
        //商品相册数据
        $goods_pic = M('goods_pic')->where(array(
            'goods_id' => $goods_id,
        ))->select();
        //商品属性(可选和唯一)
        $goods_attr = D('Admin/goods')->getAttr();
        //会员价格
        $member_price = M('member_price')
            ->field('a.*,b.level_name')
            ->alias('a')
            ->join('LEFT JOIN __MEMBER_LEVEL__ b ON a.level_id=b.level_id')
            ->where(array(
            'goods_id' => array('eq',$goods_id),
        ))->select();
        //浏览器图片配置文件
        $img_config = C('IMAGE_CONFIG');
        $this->assign(array(
            'member_price' => $member_price,
            'goods_attr' => $goods_attr,
            'viewPath' => $img_config['viewPath'],
            'goods_pic' => $goods_pic,
            'cat12' => $cat12,
            'data' => $data,
        ));
        //通用信息分配
        $this->assign(array(
            '_page_title'=>'商品界面',
            '_page_keywords'=>'商品界面',
            '_page_description'=>'商品界面',
            'index'=> 0,
        ));
        $this->display();
    }

    public function ajaxHistory(){
        $goods_id = I('get.goods_id');
        //首先需要明确,cookie中只能保存字符串,而我们需要保存的是商品id的数组,因此需要进行序列化
        $goods_ids = isset($_COOKIE['history_id'])?unserialize($_COOKIE['history_id']):array();
        array_unshift($goods_ids,$goods_id);
        //去重
        $goods_ids = array_unique($goods_ids);
        //截取长度,最多6个
        if(count($goods_ids) > 6){
            $goods_ids = array_slice($goods_ids,0,6);
        }
        //存回cookie中
        setcookie('history_id',serialize($goods_ids),time()+86400);
        //id数组转换成字符串
        $str = implode(',',$goods_ids);
        //这里数据库取数据会有默认排序
        $data = D('Admin/goods')->field('goods_id,goods_name,sm_goods_img')->where(array(
            'goods_id' => array('in',$goods_ids)
        ))->limit('6')->order("FIELD(goods_id,$str)")->select();
        //转化成json并输出
        echo json_encode($data);
    }

    /**
     * ajax判断登录状态
     */
    public function ajaxIfLogin(){
        if(session('member_name')){
            echo 1;
        }else{
            echo 0;
        }
    }

    /**
     * 获得当前浏览者的实际购买商品价格
     */
    public function ajaxPrice(){
        $goods_id = I('get.goods_id');
        //会员购买价格
        $data = D('Admin/goods')->getRealityPrice($goods_id);
        echo $data;
    }
}