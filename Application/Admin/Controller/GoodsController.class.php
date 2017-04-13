<?php
namespace Admin\Controller;
class GoodsController extends BaseController {
    /**
     * 商品库存量管理 完成商品库存的增删改查
     */
    public function goodsNum(){
        $goods_id = I('get.goods_id');
        $model = D('goods_number');
        if(IS_POST){
            //执行插入之前先清空原来该商品id所对应的库存量
            $model->where(array(
                'goods_id'=>$goods_id,
            ))->delete();
            //进行数据的循环插入
            $goods_attr_ids = I('post.goods_attr_ids');
            $goods_number = I('post.goods_number');
            //两者的比例,即每插入一次goods_number,要插入多少次goods_attr_ids
            $ratin = count($goods_attr_ids)/count($goods_number);
            $_i = 0;//当前的循环次数,即应该插入第几个数据
            foreach($goods_number as $k=>$v){
                //制作goods_attr_ids数据
                $gaids = array();
                for($i=0;$i<$ratin;++$i){
                    $gaids[] = $goods_attr_ids[$_i]; //依次插入
                    $_i++;
                }
                //规定数组升序排序,防止取商品属性值的时候取错顺序
                sort($gaids,SORT_NUMERIC); //第二个参数是已数字的形式进行排序
                //数组转化成字符串
                $gaids = implode(',',$gaids);
                if( $v != ''){ //选择了对应的属性并且有填写库存量(0也可以)才进行插入
                    $model->add(array(
                        'goods_id'=>$goods_id,
                        'goods_number'=>$v,
                        'goods_attr_ids'=>$gaids
                    ));
                }

            }
            //修改成功,刷新界面
            $this->success('提交成功',U('goodsNum',array('goods_id'=>$goods_id)));
            die;
        }

        //获得商品属性搭配并展示数据
        $gnData = D('goods_attr')
            ->field('a.*,b.attr_name')
            ->alias('a')
            ->join('LEFT JOIN __ATTRIBUTE__ b ON a.attr_id=b.attr_id')
            ->where(array(
                'a.goods_id' => array('eq',$goods_id),
                'b.attr_type' => array('eq','可选'),
        ))->select();
        //二维变三维,把每种可选属性分开
        $_gnData = array();
        foreach ($gnData as $k=>$v){
            $_gnData[$v[attr_name]][] = $v;
        }

        //根据商品id获得已经拥有的商品库存
        $data = D('goods_number')->where(array(
            'goods_id' => array('eq',$goods_id),
        ))->select();
        //如果$data为空,则前台一条数据都不显示, 要求为空时至少显示一条数据


        //分配模板数据
        $this->assign(array(
            'data' => $data,
            'gnData'=>$_gnData,
            '_page_title' => '库存量',
            '_page_btn_name' => '商品列表',
            '_page_btn_link' => U('lst'),
        ));
        $this->display();
   }

    //商品添加方法
    public function add(){
        //判断用户是否提交了表达,IS_POST是tp自带常量
        if(IS_POST){
            //修改php脚本的响应时间,默认是30秒
            set_time_limit(0);
//            dump(I('post.'));die;
            //创建模型
            $model = D('goods');
            //收集表单数据,I()方法是过滤post数据,防止xss
            //create方法把数据收集到模型中,并进行验证第一个参数传递表单数据,第二个参数为1表示新建操作,2表示修改操作
            if( $model->create(I('post.'),1) ){
                //把表单数据插入到数据库中,如果已经使用了cerate方法,接收post数据,add方法则无需传递参数
                if( $model->add() ){
                    //添加成功进行2秒后调整,并停止向下运行
                    $this->success('添加成功',U('lst'));
                    die;
                }
            }
            //添加失败或者验证失败
            //得到模型中的错误信息
            $error = $model->getError();
            $this->error($error);
        }

        //得到会员级别,分配给模板
        $model = D('member_level');
        $ml_data = $model->order('jifen_top')->select();

        /*************商品分类*******************/
        $cat_data = D('category')->getCatData();

        //分配模板通用数据
        $this->assign(array(
            'cat_data' =>$cat_data,
            'ml_data' => $ml_data,
            '_page_title' => '添加新商品',
            '_page_btn_name' => '商品列表',
            '_page_btn_link' => U('lst'),
        ));
        //载入模板
        $this->display();
    }
    //商品列表
    public function lst(){
        $model = D('goods');
        //从模型中得到数据
        $data = $model->search();
        //分配数据 ,这里data是一个关联数组,拥有两个数据一个是商品信息的二维数组,一个是页码字符串
        $this->assign($data);

        $cat_data = D('category')->getCatData();
        //分配模板通用数据
        $this->assign(array(
            'cat_data' => $cat_data,
            '_page_title' => '商品列表',
            '_page_btn_name' => '添加新商品',
            '_page_btn_link' => U('add'),
        ));
        //载入模板
        $this->display();
    }
    //商品修改
    public function edit(){
        $goods_id = I('get.goods_id');
        //创建模型
        $model = D('goods');
        //判断用户是否提交了表达,IS_POST是tp自带常量
        if(IS_POST){
            if( $model->create(I('post.'),2) ){
                if( $model->save() !== false ){
                    //添加成功进行2秒后调整,并停止向下运行
                    $this->success('更新成功',U('lst'));
                    die;
                }
            }
            //添加失败或者验证失败
            //得到模型中的错误信息
            $error = $model->getError();
            $this->error($error);
        }
//        //接收get参数中的goods_id
//        $goods_id = I('get.goods_id');
        $data = $model->find($goods_id);
        $this->assign('data',$data);

        /*********************会员级别获取***********************/
        $model = D('member_level');
        $ml_data = $model->order('jifen_top')->select();

        /*********************会员价格获取***********************/

        //得到会员价格
        $model = D('member_price');
        $mp_data = $model->where(array(
            'goods_id'=>array('eq',$goods_id),
        ))->select();
        //把mp_data的二维数组转换成一维方便操作
        $_mp_data = array();
        foreach ($mp_data as $k => $v){ //$k是0,1,2..的索引, $v是包含会员价格表中的一条记录的一维数组
            $_mp_data[$v['level_id']] = $v['member_price'];
        }

        /**************商品相册数据获取*******************/
        $model = D('goods_pic');
        $gp_data = $model->where(array(
            'goods_id'=>array('eq',$goods_id),
        ))->select();

        /*************商品主分类*******************/
        $cat_data = D('category')->getCatData();

        /*************商品扩展分类*******************/
        $ext_cat_data = D('goods_cat')->where(
            array(
                'goods_id'=>array('eq',$goods_id),
            )
        )->select();

        /***************商品属性信息获取**********************/
        $attr_data = D('attribute')
            ->field('a.*,b.goods_attr_id,b.goods_id,b.attr_value')
            ->alias('a')
            ->join('LEFT JOIN __GOODS_ATTR__ b ON (a.attr_id=b.attr_id AND b.goods_id='.$goods_id.')') //但是在连表这里设置条件却不同,左边的所有行都会显示出来
            ->where(array(
                'a.type_id'=>array('eq',$data['type_id']),
                //'b.goods_id' => array('eq',$goods_id), 没有设置过的属性不具有商品id
        ))->select();
        //分配模板
        $this->assign(array(
            'attr_data' => $attr_data,
            'ext_cat_data' => $ext_cat_data,
            'cat_data' => $cat_data,
            'gp_data' => $gp_data,
            'mp_data' => $_mp_data,
            'ml_data' => $ml_data,
            '_page_title' => '商品修改',
            '_page_btn_name' => '商品列表',
            '_page_btn_link' => U('lst'),
        ));
        //载入模板
        $this->display();
    }

    public function delete($goods_id){
        $model = D('goods');
        if($model->delete($goods_id) !== false){
            $this->success('删除成功',U('lst'));
            die;
        }else{
            $error = $model->getError();
            $this->error('删除失败,'.$error);
        }

    }

    /**
     *服务于删除修改商品时,商品相册的ajax删除
     */
    public function picDel(){
        if(IS_POST){
            $pic_id = I('post.pic_id');
            //实例化商品相册模型
            $model = D('goods_pic');
            $data = $model->where(array(
                'pic_id'=>array('eq',$pic_id),
            ))->field('pic,big_pic,mid_pic,sm_pic')->find();
            //先删除服务器中的图片
            deleteImage($data);
            if( $model->delete($pic_id) !== false ){
                echo '{"result":1}';
            }else{
                echo '{"result":0}';
            }
        }
    }

    /**
     * 根据type_id得到对应的属,服务于添加修改商品时,切换商品类型时,商品属性的ajax切换
     * @return mixed 返回对应类型对应的属性值的二维数组json数据
     */
    public function getAttr(){
        $type_id = I('get.type_id');
        $model = D('attribute');
        $data = $model->where(
            array(
                'type_id' => array('eq',$type_id)
            )
        )->select();
        $jsonData = json_encode($data);
        echo $jsonData;
    }

    /**
     * 服务于修改商品时,ajax删除商品的某条属性及删除该属性对应的库存量
     */
    public function delAttr(){
        $goods_attr_id = I('get.goods_attr_id');
        $goods_attr_id = addslashes($goods_attr_id); //字符串过滤,防止sql注入
        $goods_id = I('get.goods_id');
        //根据goods_attr_id删除goods_attr表中记录
        D('goods_attr')->where(array(
            'goods_attr_id'=>array('eq',$goods_attr_id),
        ))->delete();
        //根据goods_attr_id删除商品库存表中数据
        D('goods_number')->where(array(
            'goods_id'=>array('eq',$goods_id),
            '_string'=> 'FIND_IN_SET('.$goods_attr_id.',goods_attr_ids)',
        ))->delete();
    }
}