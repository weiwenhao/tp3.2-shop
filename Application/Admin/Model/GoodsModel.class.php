<?php
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model{
    //规定create方法可以使用的字段
    protected $insertFields = 'goods_name,market_price,shop_price,goods_desc,promote_price,promote_start_date,promote_end_date,is_onsale,is_hot,is_best,is_new,sort_num,brand_id,cat_id,type_id';
    //规定更新时create方法可以接收的字段
    protected $updateFields = 'goods_id,goods_name,market_price,shop_price,goods_desc,promote_price,promote_start_date,promote_end_date,is_onsale,is_hot,is_best,is_new,sort_num,brand_id,cat_id,type_id';
    //定义验证规则,重写Model中的方法
    protected $_validate = array(
        array('goods_name','require','商品名称不能为空',1),
        array('cat_id','require','请选择商品分类',1),
        array('market_price','currency','市场价格必须是货币',1),
        array('shop_price','currency','本店价格必须是货币',1),
        array('promote_price','currency','促销价格必须是货币',0),
    );
    //使用钩子方法，对插入之前的数据做一些处理,如数据添加时间和图片略所图的制作
    protected function _before_insert(&$data, $options){
        //图片的接收和缩略图的制作
        if( $_FILES['goods_img']['name'] !== '' ){

            //调用封装的tp图片上传方法,返回图片和略缩图在服务器中的路径
            $img = uploadOne('goods_img', 'Goods', array(
                array(700, 700),
                array(350, 350),
                array(130, 130),
                array(50, 50),
            ));
            //如果图片制作成功则 $img['ok']返回int(1)  $img['images'] 返回一个array,如下
/*            array(2) {
                ["ok"] => int(1)
                ["images"] => array(5) {
                    [0] => string(34) "Goods/2016-11-30/583ea013925dd.jpg"
                    [1] => string(42) "Goods/2016-11-30/thumb_0_583ea013925dd.jpg"
                    [2] => string(42) "Goods/2016-11-30/thumb_1_583ea013925dd.jpg"
                    [3] => string(42) "Goods/2016-11-30/thumb_2_583ea013925dd.jpg"
                    [4] => string(42) "Goods/2016-11-30/thumb_3_583ea013925dd.jpg"
                 }
              }
*/
            if($img['ok'] == 1) {//把服务器中的图片地址存储在数据库中,数据库中的名字可以自定义,取图片的时候安装数据库中的字段名取数据即可
                //ps:略缩图从大到小,数据库对应顺序不要错了
                $data['goods_img'] = $img['images'][0];   // 原图地址
                $data['mbig_goods_img'] = $img['images'][1];   // 第一个缩略图地址
                $data['big_goods_img'] = $img['images'][2];   // 第二个缩略图地址
                $data['mid_goods_img'] = $img['images'][3];   // 第三个缩略图地址
                $data['sm_goods_img'] = $img['images'][4];   // 第四个缩略图地址
            }else {
                $this->error = $img['error']; //把错误封装在模型的 $error 中并返回false中端程序的执行
                return FALSE;
            }
        }
        //对goods_desc中的数据进行过滤
        $data['goods_desc'] = removeXSS($_POST['goods_desc']);
        if(empty($data['promote_start_date'])) {
            $data['promote_start_date'] = NULL;
        }
        if(empty($data['promote_end_date'])) {
            $data['promote_end_date'] = NULL;
        }
        //时间的制作和插入
        $data['addtime'] = date('Y-m-d H:i:s');
    }

    //使用钩子方法，对插入之后的数据做一些处理 ,比如会员价格表的插入
    protected function _after_insert($data, $options){
        $goods_id = $data['goods_id'];
        /******************添加会员价格************************/
        //得到拥有同一件商品的各种会员价格的一维数组
        $member_prices = I('post.member_price');
        //实例化会员价格表模型,以便插入数据
        $model = D('member_price');
        //循环遍历数组,添加商品价格
        foreach($member_prices as $k => $v ){
            //并且对用户填写的会员价格进行简单过滤,强制转换成浮点形,防止用户填写了abc之类的
            $v = (float)$v;
            //插入之前先进行判断用户是否填写了会员价格(即会员价格是否>0,当然 !=0也可以,但是不够严谨)
            if($v > 0){
                //调用add方法插入数据  $k 为 会员级别id,$v 为会员价格
                $model->add(array(
                    'goods_id' => $goods_id,
                    'level_id' => $k,
                    'member_price' => $v,
                ));
            }
        }

        /*****************添加相册*******************/
//dump($_FILES['pic']);
        //判断用户是否上传了图片
        if($_FILES['pic'][error][0] == 0){
            //调用封装的uploadOne函数把图片插入到数组中,这里把二维数组处理一下
            //重点 : 重新给$_FILES函数重新制作  制作实例:$_FILES[$imgName]['error']
           $pics = array();
           foreach($_FILES['pic']['name'] as $k => $v){
                $pics[] = array(
                    'name' => $_FILES['pic']['name'][$k],
                    'type' => $_FILES['pic']['type'][$k],
                    'tmp_name' => $_FILES['pic']['tmp_name'][$k],
                    'error' => $_FILES['pic']['error'][$k],
                    'size' => $_FILES['pic']['size'][$k],
                );
           }
//           dump($pics);die;
            //实例化商品相册表的模型
            $model=D('goods_pic');
            //循环给$_FILES赋值和调用
            foreach ($pics as $k => $v){
                $_FILES['pic'] = $v; //对$_FILES['图片名称']进行重新赋值,然后进行一张一张图片的插入
                //调用上传函数和略缩图制作
                $ret=uploadOne('pic',goodsPic,array(
                    //制作略缩图,从大到小
                    array(650,650),
                    array(350,350),
                    array(50,50),
                ));
                //把原图和略缩图路径分别存储到数组中
                if( $ret['ok'] == 1 ){
                    $model->add(array(
                        'pic' => $ret['images'][0],   // 原图地址
                        'big_pic' => $ret['images'][1],   // 第一个缩略图地址 ,从大到小
                        'mid_pic' => $ret['images'][2],   // 第二个缩略图地址
                        'sm_pic' => $ret['images'][3],   // 第三个缩略图地址
                        'goods_id' => $goods_id,
                    ));

                }
            }

        }

        /******************添加扩展分类****************************/
        $ext_cat_ids = I('post.ext_cat_ids');
        if($ext_cat_ids){
            $model = D('goods_cat');
            $ext_cat_ids = array_unique($ext_cat_ids); //去除数组中重复的值
            foreach ($ext_cat_ids as $k => $v){
                if($v != $data['cat_id'] && $v != ''){
                    $model->add(array(
                        'goods_id' => $goods_id,
                        'cat_id' => $v,
                    ));
                }

            }
        }

        /*******************添加商品属性***********************/
        $goods_attr = I('post.attr_value');
        $model = D('goods_attr');
        foreach ($goods_attr as $k => $v){
            $v = array_unique($v); //去除数组中重复的值
            //$k为attr_id
            foreach ($v as $k1=>$v1){
                if($v1){
                    //$v1为attr_value
                    $model->add(array(
                        'goods_id'=>$goods_id,
                        'attr_id'=>$k,
                        'attr_value'=>$v1,
                    ));
                }

            }
        }

    }

    //使用钩子方法，对修改之前的数据做一些处理,如数据添加时间和图片略所图的制作
    protected function _before_update(&$data, $options){
        $goods_id = $options['where']['goods_id'];
        //设置 is_update为1
        $data['is_update'] = 1;
        //设置sphinx索引中的 is_update字段为1 ,表示该索引已经被修改
        require ('./Tools/sphinxapi.php'); //载入类
        $sp = new \SphinxClient();//实例化一个无命名空间的类
        $sp->setServer('localhost', 9312); // 设置服务端，第一个参数sphinx服务器地址，第二个sphinx监听端口
        $ret = $sp->updateAttributes('goods',array('is_update'),array((int)$goods_id=>array(1))); //修改属性的值
//        dump($ret);die;
        //图片的接收和缩略图的制作
        if( $_FILES['goods_img']['name'] !== '' ){
            //调用封装的tp图片上传方法,返回图片和略缩图在服务器中的路径
            $img = uploadOne('goods_img', 'Goods', array(
                array(700, 700),
                array(350, 350),
                array(130, 130),
                array(50, 50),
            ));
            if($img['ok'] == 1) {//把服务器中的图片地址存储在数据库中,数据库中的名字可以自定义,取图片的时候安装数据库中的字段名取数据即可
                //ps:略缩图从大到小,数据库对应顺序不要错了
                $data['goods_img'] = $img['images'][0];   // 原图地址
                $data['mbig_goods_img'] = $img['images'][1];   // 第一个缩略图地址
                $data['big_goods_img'] = $img['images'][2];   // 第二个缩略图地址
                $data['mid_goods_img'] = $img['images'][3];   // 第三个缩略图地址
                $data['sm_goods_img'] = $img['images'][4];   // 第四个缩略图地址
            }else {
                $this->error = $img['error']; //把错误封装在模型的 $error 中并返回false中端程序的执行
                return FALSE;
            }
                //删除原有的图片,id从钩子函数的option参数中取出
                $img_data = $this->field('goods_img,sm_goods_img,mid_goods_img,big_goods_img,mbig_goods_img')
                                 ->find($goods_id);
           /* array(5) {
                ["goods_img"] => string(34) "Goods/2016-11-29/583d7b9c880bc.jpg"
                ["sm_goods_img"] => string(37) "Goods/2016-11-29/sm_583d7b9c880bc.jpg"
                ["mid_goods_img"] => string(38) "Goods/2016-11-29/mid_583d7b9c880bc.jpg"
                ["big_goods_img"] => string(38) "Goods/2016-11-29/big_583d7b9c880bc.jpg"
                ["mbig_goods_img"] => string(39) "Goods/2016-11-29/mbig_583d7b9c880bc.jpg"
            }*/
                deleteImage($img_data); //传入一个一维数组

        }

        //对goods_desc中的数据进行过滤
        $data['goods_desc'] = removeXSS($_POST['goods_desc']);

        /*
         * 如果没有选择促销时间则设置为NULL
         */
        if(empty($data['promote_start_date'])) {
            $data['promote_start_date'] = NULL;
        }
        if(empty($data['promote_end_date'])) {
            $data['promote_end_date'] = NULL;
        }
        //时间的制作和插入  修改中无需制作
        //$data['addtime'] = date('Y-m-d H:i:s');


        /*********************更新会员价格**************************/
        //首先删除原有的会员价格
        $model = D('member_price');
        $model->where('goods_id='.$goods_id)->delete();
        //更新新的会员价格,类似于添加
        //得到拥有同一件商品的各种会员价格的一维数组
        $member_prices = I('post.member_price');
        //循环遍历数组
        foreach($member_prices as $k => $v ){
            //并且对用户填写的会员价格进行简单过滤,强制转换成浮点形,防止用户填写了abc之类的
            $v = (float)$v;
            //插入之前先进行判断用户是否填写了会员价格(即会员价格是否>0,当然 !=0也可以,但是不够严谨)
            if($v > 0){
                //调用add方法插入数据  $k 为 会员级别id,$v 为会员价格
                $model->add(array(
                    'goods_id' => $goods_id,
                    'level_id' => $k,
                    'member_price' => $v,
                ));
            }
        }

        /*********************更新商品相册************************/
        //关键点1,不需要删除图片,已经在html界面动态删除了
        //关键点2,不替换替换图片,而是根据商品id直接添加新的图片进去,主键重新定义
        if($_FILES['pic'][error][0] == 0){
            //调用封装的uploadOne函数把图片插入到数组中,这里把二维数组处理一下
            //重点 : 重新给$_FILES函数重新制作  制作实例:$_FILES[$imgName]['error']
            $pics = array();
            foreach($_FILES['pic']['name'] as $k => $v){
                $pics[] = array(
                    'name' => $_FILES['pic']['name'][$k],
                    'type' => $_FILES['pic']['type'][$k],
                    'tmp_name' => $_FILES['pic']['tmp_name'][$k],
                    'error' => $_FILES['pic']['error'][$k],
                    'size' => $_FILES['pic']['size'][$k],
                );
            }
//           dump($pics);die;
            //实例化商品相册表的模型
            $model=D('goods_pic');
            //循环给$_FILES赋值和调用
            foreach ($pics as $k => $v){
                $_FILES['pic'] = $v;
                //调用上传函数和略缩图制作
                $ret=uploadOne('pic',goodsPic,array(
                    //制作略缩图,从大到小
                    array(650,650),
                    array(350,350),
                    array(50,50),
                ));
                //把原图和略缩图路径分别存储到数组中
                if( $ret['ok'] == 1 ){
                    $model->add(array(
                        'pic' => $ret['images'][0],   // 原图地址
                        'big_pic' => $ret['images'][1],   // 第一个缩略图地址 ,从大到小
                        'mid_pic' => $ret['images'][2],   // 第二个缩略图地址
                        'sm_pic' => $ret['images'][3],   // 第三个缩略图地址
                        'goods_id' => $goods_id,
                    ));

                }
            }

        }

        /*****************更新扩展分类**********************/
        $model = D('goods_cat');
        //删除原有的所有扩展分类
        $model->where(array(
                'goods_id'=>array('eq',$goods_id)
            ))->delete();
        //添加新的扩展分类
        $ext_cat_ids = I('post.ext_cat_ids');
        if($ext_cat_ids){
            $ext_cat_ids = array_unique($ext_cat_ids); //去除数组中重复的值
            foreach ($ext_cat_ids as $k => $v){
                if($v != $data['cat_id'] && $v != ''){
                    $model->add(array(
                        'goods_id' => $goods_id,
                        'cat_id' => $v,
                    ));
                }

            }
        }

        /*******************更新商品属性**************************/
        $model = D('goods_attr');
        $goods_attr_id = I('post.goods_attr_id');
        $attr_value = I('post.attr_value');
        $i = 0; //记录循环次数,以取出goods_id
        //循环插入
        foreach($attr_value as $k => $v){
            //$k 为attr_id
            $v = array_unique($v);
            foreach ($v as $k1 => $v1){
                if($v1){
                    $model->execute("REPLACE INTO `wwh_goods_attr` VALUES('$goods_attr_id[$i]',$goods_id,$k,'$v1')");
                }
                $i++;
            }
        }


    }

    protected function _before_delete($options){
       $goods_id = $options['where']['goods_id'];
        /************服务器中图片的删除*******************/
        //删除原有的图片,id从钩子函数的option参数中取出
        $img_data = $this->field('goods_img,sm_goods_img,mid_goods_img,big_goods_img,mbig_goods_img')->find($goods_id);
        deleteImage($img_data); //传入一个一维数组

        /***********会员价格的删除*********************/
        //首先删除原有的会员价格
        $model = D('member_price');
        $model->where('goods_id='.$goods_id)->delete();

        /*****************商品相册的删除******************/
        $model = D('goods_pic');
        //删除本地服务器中的相册 where条件这样写是因为tp框架内部在拼接where条件时会进行sql的过滤
        $gp_data = $model->field('pic,big_pic,mid_pic,sm_pic')
                         ->where(array(
                                'goods_id'=>array('eq',$goods_id)
                            ))->select();
        foreach ($gp_data as $k => $v){
            //循环删除图片
            deleteImage($v);
        }
        $model->where(array(
            'goods_id'=>array('eq',$goods_id),
        ))->delete();
        /********************删除goods_cat表中的商品分类******************************/
        $model = D('goods_cat');
        $model->where(array(
            'goods_id'=>array('eq',$goods_id)
        ))->delete();

        /************删除商品属性和库存量********************/
        D('goods_attr')->where(array(
            'goods_id'=>array('eq',$goods_id)
        ))->delete();

        D('goods_number')->where(array(
            'goods_id'=>array('eq',$goods_id)
        ))->delete();

    }

    //得到列表页的数据
    public function search(){
        //得到筛选数据,所有的搜索数据都是为了服务where条件,tp中的where()可以是一个数组,key值需要是数据表的字段名
        $where = array();

        /*商品分类 考虑扩展分类
            因为要关联别的表,这里不用cat_id直接搜索了,
            根据主表的cat_id找到goods_id, 然后再去goods_cat表,根据cat_id找到goods_id,然后合并即可

        */
        $cat_id = I('get.cat_id');
        if($cat_id){
            $goods_ids = $this->getGoodsIds($cat_id);
            $where['a.goods_id'] =array('IN',$goods_ids);
        }
        //商品品牌
        $brand_id = I('get.brand_id');
        if($brand_id){
          $where['a.brand_id'] =$brand_id;
        }
       //商品名称
        $gn = I('get.gn'); //这里一定要先用变量接收,在字符串中不会解析 "%{$I('get.gn')}%"
        if( $gn ){
            $where['goods_name'] = array('like',"%$gn%");  //变量为白色才是被解析的
        }
        //是否上架
        $ios = I('get.ios');
        if( $ios !== ""){
            $where['is_onsale'] = $ios;
        }
        //价格
        $fp = I('get.fp');
        $tp = I('get.tp');
        //要分成三种情况
        if($fp && $tp){
            //一个参数位想要传递两个参数,可以用数组的方式传递,无论是tp还是php都非常支持这种方式
            $where['a.shop_price'] = array('between',array($fp,$tp));
        }elseif($fp){
            $where['shop_price'] = array('EGT',$fp);
        }elseif($tp){
            $where['shop_price'] = array('ELT',$tp);
        }
        //添加时间筛选  时间比较可以直接用时间???   表单中的空格变成了+? get参数的转义和反转义
        $fa = I('get.fa');
        $ta = I('get.ta');
        //要分成三种情况
        if($fa && $ta){
            //一个参数位想要传递两个参数,可以用数组的方式传递,无论是tp还是php都非常支持这种方式
            $where['addtime'] = array('between',array($fa,$ta));
        }elseif($fa){
            $where['addtime'] = array('EGT',$fa);
        }elseif($ta){
            $where['addtime'] = array('ELT',$ta);
        }
        //排序制作
        $order = "a.goods_id desc";
        $paixu = I('get.paixu');
        if($paixu == 'at_asc'){
            $order = 'a.addtime asc';
        }elseif($paixu == 'at_desc'){
            $order = 'a.addtime desc';
        }elseif ($paixu == 'sp_asc'){
            $order = 'a.shop_price asc';
        }elseif ($paixu == 'sp_desc'){
            $order = 'a.shop_price desc';
        }
        //得到总的记录数
        $count = $this->alias('a')->where($where)->count();
        // 实例化分页类 传入总记录数和每页显示的记录数(5)
        $Page  = new \Think\Page($count,10);
        $Page->lastSuffix = false; // 最后一页是否显示总页数
        $Page->rollPage = 9; //当页数超过5页时显示首页和尾页
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('first','首页');
        $Page->setConfig('last','末页');


        //得到分页字符串
        $pageStr  = $Page->show();// 分页显示输出
        //拼接limit()字段
        $data = $this->order($order)
            ->field('a.*,b.brand_name,c.cat_name,group_concat(e.cat_name SEPARATOR "<br/>") ext_cat_name')
            ->alias('a')
            ->join('LEFT JOIN __BRAND__ b ON a.brand_id=b.brand_id')
            ->join('LEFT JOIN __CATEGORY__ c ON a.cat_id=c.cat_id')
            ->join('LEFT JOIN __GOODS_CAT__ d ON a.goods_id=d.goods_id')
            ->join('LEFT JOIN __CATEGORY__ e ON e.cat_id=d.cat_id')
//            ->where($str)   //字符串格式的where条件,tp中只允许使用一次
            ->where($where) //数组格式的where条件
            ->group('a.goods_id')
            ->limit($Page->firstRow.','.$Page->listRows)
            ->select();
        return array(
          'data' => $data,
          'page' => $pageStr
        );
    }

/*************************其他方法****************************/
    /**
     * 得到某个分类下的所有商品id,注意:前台调用该方法时,D('category')的实例化是在前台,而前台没有category这个模型,所以需要加上Admin来指向后台
     * @param $cat_id 传递一个分类id
     * @return array|mixed 一维索引数组,根据cat_id找到的该分类,和子分类,以及该分类和子分类的扩展分类的goods_id
     */
    public function getGoodsIds($cat_id){
        //先找主分类的goods_id
        $cat_ids = D('Admin/category')->getCatIds($cat_id);
        $cat_ids[] = $cat_id;
        //根据cat_ids查找goods_id
        $goods_ids = $this->field('goods_id')->where(
            array(
                'cat_id'=>array('IN',$cat_ids),
            )
        )->select();

        //根据cat_ids查找扩展分类
        $ext_goods_ids = D('goods_cat')->field('goods_id')->where(
            array(
                'cat_id'=>array('IN',$cat_ids),
            )
        )->select();
        //两个数组进行合并
        $_goods_ids = array_merge($goods_ids,$ext_goods_ids);
        //二维转一维
        $goods_ids = array();
        foreach ($_goods_ids as $k=>$v){
            $goods_ids[] = $v['goods_id'];
        }
        //消除数组中的重复值
        $goods_ids = array_unique($goods_ids);
        return $goods_ids;
    }

    /**
     * 获得促销商品
     * @param int $limit
     * @return mixed
     */
    public function getPromoteGoods($limit=5){
        //促销商品的要求是,当前时间在促销时间短内,当然前提是有上架
        $nowdata = date('Y-m-d H:i:s',time());
        $data=$this->field('goods_id,goods_name,promote_price,mid_goods_img')->where(array(
            'is_onsale' => array('EQ','是'),
            'promote_start_date'=>array('ELT',$nowdata),
            'promote_end_date'=>array('EGT',$nowdata),
        ))->limit($limit)->order('sort_num asc')->select();
        return $data;
    }

    /**
     * 获得热卖商品
     * @param int $limit
     * @return mixed
     */
    public function getHotGoods($limit=5){
        $data=$this->field('goods_id,goods_name,shop_price,mid_goods_img')->where(array(
            'is_onsale' => array('EQ','是'),
            'is_hot' => array('EQ','是'),
        ))->limit($limit)->order('sort_num asc')->select();
        return $data;
    }

    /**
     * 获得推荐商品(精品)
     * @param int $limit
     * @return mixed
     */
    public function getBestGoods($limit=5){
        $data=$this->field('goods_id,goods_name,shop_price,mid_goods_img')->where(array(
            'is_onsale' => array('EQ','是'),
            'is_best' => array('EQ','是'),
        ))->limit($limit)->order('sort_num asc')->select();
        return $data;
    }

    /**
     * 获得新品
     * @param int $limit
     * @return mixed
     */
    public function getNewGoods($limit=5){
        $data=$this->field('goods_id,goods_name,shop_price,mid_goods_img')->where(array(
            'is_onsale' => array('EQ','是'),
            'is_new' => array('EQ','是'),
        ))->limit($limit)->order('sort_num asc')->select();
        return $data;
    }

    /**
     * 得到前台首页商品楼层中的数据,是一个嵌套数组
     * @return $data 商品楼层中的数据
     */
    public function getFloor(){
        //首先得到顶级分类中,被推荐的分类
        $model = D('category');
        $data = $model->where(array(
            'is_floor' => array('eq','是'),
            'pid' => array('eq',0),
        ))->select();
        //为数组丰富二级分类
        foreach($data as $k => &$v){
            //查找当前顶级分类下的所有商品id
            $goods_ids = $this->getGoodsIds($v['cat_id']);
            if($goods_ids){
                //当前顶级分类中所拥有的品牌,取9个
                $brand_data = $this->field('DISTINCT b.brand_id,b.logo')
                    ->alias('a')
                    ->join('RIGHT JOIN __BRAND__ b ON a.brand_id=b.brand_id')
                    ->where(array(
                        'a.is_onsale' => array('eq','是'),
                        'a.goods_id' => array('in',$goods_ids),
                        'b.logo' => array('neq','')
                    ))
                    ->limit('9')
                    ->select();
            }else{
                $brand_data = array();
            }
            //查找当前顶级分类的二级分类(未被推荐的)
            $child_no_floor = $model->where(array(
                'is_floor'=> array('eq','否'),
                'pid' => array('eq',$v['cat_id']),
            ))->select();
            //查找当前顶级分类的二级分类(被推荐的)
            $child_floor = $model->where(array(
                'is_floor' => array('eq','是'),
                'pid' => array('eq',$v['cat_id']),
            ))->select();
            //为每个被推荐的分类数据中添加8件商品,考虑当前分类和子分类,以及拓展分类下的商品,在该模型中已经创建了该方法 getGoodsIds
            foreach ($child_floor as $k1 => &$v1){
                //找出当前分类下的所有商品id,返回一维数组
                $goods_ids = $this->getGoodsIds($v1['cat_id']);
                if($goods_ids){
                    $goods_data = $this->field('goods_id,goods_name,mid_goods_img,shop_price')->where(array(
                        'is_onsale' => array('eq','是'),
                        'is_best' => array('eq','是'),//被推荐到楼层的数据
                        'goods_id' => array('in',$goods_ids),
                    ))->limit('8')->order('sort_num')->select();
                    $v1['goods_data'] = $goods_data;
                }else{
                    $v1['goods_data'] = array();
                }

            }

            //把数据添加进数组中
            $v['brand_data'] = $brand_data;
            $v['child_no_floor'] = $child_no_floor;
            $v['child_floor'] = $child_floor;
        }
        return $data;
    }

    /**
     * 根据商品id得到该商品的属性,包括可选属性和唯一属性,并且对可选属性进行处理更便于前台遍历
     * @return array $data
     * $data['uni_attr']表示唯一属性
     * $data['opt_attr']表示可选属性
     */
    public function getAttr(){
        $goods_id = I('get.goods_id');
        $model = D('goods_attr');
        $data = array();
        //该商品的可选属性
        $opt_attr = $model->alias('a')
            ->field('a.*,b.attr_name,b.attr_type')
            ->join('LEFT JOIN __ATTRIBUTE__ b ON a.attr_id=b.attr_id')
            ->where(array(
                'b.attr_type' => array('eq','可选'),
                'goods_id' => array('eq',$goods_id),
        ))->select();
        //对可选属性进行处理,使相同的属性归到一个数组内
        foreach ($opt_attr as $k => $v){
            $data['opt_attr'][$v['attr_name']][] = $v;
        }
        //该商品的唯一属性
        $data['uni_attr'] = $model->alias('a')
            ->field('a.*,b.attr_name,b.attr_type')
            ->join('LEFT JOIN __ATTRIBUTE__ b ON a.attr_id=b.attr_id')
            ->where(array(
                'b.attr_type' => array('eq','唯一'),
                'goods_id' => array('eq',$goods_id),
            ))->select();

        return $data;
    }

    /**
     * 得到当前当前用户购买这某件商品的最低价格
     * @return int 会员价格,本店价格,商品价格中的最低价
     *
     */
    public function getRealityPrice($goods_id){

        //得到级别id
        $level_id = session('level_id');
        //查出这个商品在这个会员级别下的会员价格
        $mp_data = D('member_price')->field('member_price')->where(array(
            'goods_id' => array('eq',$goods_id),
            'level_id' => array('eq',$level_id),
        ))->find();
        if($mp_data){
            $member_price = $mp_data['member_price'];
        }else{
            $member_price = null;
        }
        //得到这件商品的促销价和本店价以及促销时间的数组数组
        $goods_data = D('goods')->field('shop_price,promote_start_date,promote_end_date,promote_price')->where(array(
            'goods_id' => array('eq',$goods_id),
        ))->find();
        //本店价
        $shop_price = $goods_data['shop_price'];
        $promote_price = $goods_data['promote_price'];
        $date = date('Y-m-d H:i:s',time());//当前时间
        //判断这件商品是否在促销期间
        if($goods_data['promote_start_date'] <= $date && $goods_data['promote_end_date'] > $date){
            //如果在促销期间,则一定有促销价格,和本店价格
            if($member_price != null){//如果有会员价格的话
                //返回会员价和促销价中的最低价并且价格不能是0
                if($promote_price != 0){
                    return min($member_price,$promote_price);
                }else{
                    return $member_price;
                }

            }else{//如果没有会员价格的话
                if($promote_price != 0){
                    return $promote_price;
                }else{
                    return $shop_price;
                }
            }
        }else{
            //如果不再促销期间
            if($member_price != null){
                return $member_price;
            }else{
                return $shop_price;
            }
        }


    }

    /**
     * 根据分类id找到当前分类下的所有商品(类似于上面的 search方法),此方法服务于前台商品列表页
     * @param $cat_id int 分类id
     * @return array  array['data']是商品数据数组 array['page']是分页字符串
     */
    public function getGoodsByCatId($cat_id){
        //得到筛选数据,所有的搜索数据都是为了服务where条件,tp中的where()可以是一个数组,key值需要是数据表的字段名
        $where = array();
        $where['a.is_onsale'] = array('eq','是'); //必须是上架的商品
        /*商品分类 考虑扩展分类
            因为要关联别的表,这里不用cat_id直接搜索了,
            根据主表的cat_id找到goods_id, 然后再去goods_cat表,根据cat_id找到goods_id,然后合并即可

        */

        $goods_ids = $this->getGoodsIds($cat_id);
        $goods_ids = implode(',',$goods_ids);
        $where['a.goods_id'] =array('IN',$goods_ids);

        //品牌筛选
        /*dump($_GET);die; 接收没有问题
        array(4) {
          ["cat_id"] => string(1) "1"
          ["attr_4"] => string(16) "厂商_富士康"
          ["attr_7"] => string(16) "作者_郭德岗"
          ["attr_6"] => string(19) "操作系统_安卓"
        }
        */
        $brand_name = I('get.brand_name');
        if($brand_name){
            $where['b.brand_name'] = array('eq',$brand_name);
        }
        //价格筛选
        $price = I('get.price');
        if($price){
            if(strpos($price,'以上') !==FALSE){
                //找到了以上
                $price = (int)$price;
                $where['a.shop_price'] = array('EGT',$price);
            }else{
                $arr = explode('-',$price);
                $where['a.shop_price'] = array('BETWEEN',$arr);
            }

        }

        //属性筛选
        $a_goods_id = null; //数组格式
        foreach ($_GET as $k=>$v){
            if(strpos($k,'attr_') === 0){
                //说明这条 $k是属性字段,
                $arr = explode('_',$v);
                $attr_value = $arr[1];
                //开始查询
                $ga_data = M('goods_attr')->field('GROUP_CONCAT(goods_id) goods_id ')->where(array(
                    'goods_id' => array('IN',$goods_ids),
                    'attr_value' => array('EQ',$attr_value)
                ))->find();
                $arr_goods_id = explode(',',$ga_data['goods_id']);
                //判断并存取到 a_goods_id中
                if($a_goods_id === null){
                    $a_goods_id = $arr_goods_id;
                }else{
                    $a_goods_id = array_intersect($a_goods_id,$arr_goods_id);
                   //判断交集后的是否还存在goods_id
                    if($a_goods_id == null){ //在当前属性下不在存在商品
                        break;
                    }
                }
            }
        }
        if($a_goods_id != null){
            $where['a.goods_id'] =array('IN',$a_goods_id);
        }

        //商品排序
        $order_key = 'xl';
        $order_value = 'desc';
        $order = I('get.order'); //默认已价格降序排序
        $arr = explode('_',$order);
        if($arr){
            if($arr[0] == 'time'){ //自己根据get参数来设置筛选条件,可以防止sql注入
                $order_key = 'addtime';
            }elseif($arr[0] == 'price'){
                $order_key = 'a.shop_price';
                if($arr[1] == 'asc'){
                    $order_value = 'asc';
                }
            }
        }
        //得到总的记录数 ,这里如果没有找到一条goods_id ,则 group_concat(goods_id)的值为null,count的值则为0
        $count = $this->field('count(goods_id) count,group_concat(goods_id) goods_id')->alias('a')
            ->join('LEFT JOIN __BRAND__ b ON a.brand_id=b.brand_id')
            ->where($where)->find();
        // 实例化分页类 传入总记录数和每页显示的记录数(12)
        $Page  = new \Think\Page($count['count'],12);
        $Page->lastSuffix = false; // 最后一页是否显示总页数
        $Page->rollPage = 9; //当页数超过5页时显示首页和尾页
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('first','首页');
        $Page->setConfig('last','末页');


        //得到分页字符串
        $pageStr  = $Page->show();// 分页显示输出
        //拼接limit()字段
        $data = $this  //已商品表为主导,商品不能重复,所以分组只能已主表中的数据
            ->field('a.goods_id,a.goods_name,a.shop_price,a.mid_goods_img,SUM(shop_number) xl')
            ->alias('a')
            ->join('LEFT JOIN __BRAND__ b ON a.brand_id=b.brand_id')
            ->join('LEFT JOIN __ORDER_GOODS__ c ON a.goods_id=c.goods_id')  //加上这条连表后主表数据开始有重复
            ->join('LEFT JOIN __ORDER__ d ON (c.order_id=d.order_id AND d.pay_status="是")')
            ->where($where) //数组格式的where条件
            ->group('a.goods_id')
            ->order($order_key.' '.$order_value) //默认销量降序
            ->limit($Page->firstRow.','.$Page->listRows)
            ->select();
        return array(
            'data' => $data,
            'page' => $pageStr,
            'goods_id' => $count['goods_id'],
        );
    }

    /**
     * 根据用户输入的搜索条件找到当前条件下的的所有商品,此方法服务于前台商品列表页
     * @param $key int 用户输入的字符串
     * @return array  array['data']是商品数据数组 array['page']是分页字符串
     */
    public function getGoodsByKey($key){
        //得到筛选数据,所有的搜索数据都是为了服务where条件,tp中的where()可以是一个数组,key值需要是数据表的字段名
        $where = array();
        $where['a.is_onsale'] = array('eq','是'); //必须是上架的商品
        /*商品分类 考虑扩展分类
            因为要关联别的表,这里不用cat_id直接搜索了,
            根据主表的cat_id找到goods_id, 然后再去goods_cat表,根据cat_id找到goods_id,然后合并即可

        */

        //引入sphinx todo 去掉sphinx
        /*require ('./Tools/sphinxapi.php'); //载入类
        $sp = new \SphinxClient();//实例化一个无命名空间的类
        $sp->setServer('localhost', 9312); // 设置服务端，第一个参数sphinx服务器地址，第二个sphinx监听端口
        $sp->setFilter('is_update',array(0));//sphinx中的字段过滤 ,只有 is_update为0的才能通过
        $res = $sp->query($key, 'goods'); // 执行查询，第一个参数查询的关键字，第二个查询的索引名称，mysql索引名称（这个也是在配置文件中定义的），多个索引名称以,分开，也可以用*表示所有索引。
        $goods_ids = array_keys($res['matches']);
        $goods_ids = (string)implode(',',$goods_ids);*/
        //根据key关键字查找出商品的ids ,字符串格式
        $goods = $this
            ->field('GROUP_CONCAT(DISTINCT a.goods_id) goods_ids')
            ->alias('a')
            ->join('LEFT JOIN __GOODS_ATTR__ b ON a.goods_id=b.goods_id')
            ->where(array(
            'a.goods_name' => array('EXP',"LIKE '%$key%' OR a.goods_desc LIKE '%$key%' OR b.attr_value LIKE '%$key%'"),
        ))
            ->find();
        $goods_ids = (string)$goods['goods_ids'];//确保goods_ids是字符串格式,而不是null

        $where['a.goods_id'] =array('IN',$goods_ids);

        //品牌筛选
        /*dump($_GET);die; 接收没有问题
        array(4) {
          ["cat_id"] => string(1) "1"
          ["attr_4"] => string(16) "厂商_富士康"
          ["attr_7"] => string(16) "作者_郭德岗"
          ["attr_6"] => string(19) "操作系统_安卓"
        }
        */
        $brand_name = I('get.brand_name');
        if($brand_name){
            $where['b.brand_name'] = array('eq',$brand_name);
        }
        //价格筛选
        $price = I('get.price');
        if($price){
            if(strpos($price,'以上') !==FALSE){
                //找到了以上
                $price = (int)$price;
                $where['a.shop_price'] = array('EGT',$price);
            }else{
                $arr = explode('-',$price);
                $where['a.shop_price'] = array('BETWEEN',$arr);
            }

        }

        //属性筛选
        $a_goods_id = null; //数组格式
        foreach ($_GET as $k=>$v){
            if(strpos($k,'attr_') === 0){
                //说明这条 $k是属性字段,
                $arr = explode('_',$v);
                $attr_value = $arr[1];
                //开始查询
                $ga_data = M('goods_attr')->field('GROUP_CONCAT(goods_id) goods_id ')->where(array(
                    'goods_id' => array('IN',$goods_ids),
                    'attr_value' => array('EQ',$attr_value)
                ))->find();
                $arr_goods_id = explode(',',$ga_data['goods_id']);
                //判断并存取到 a_goods_id中
                if($a_goods_id === null){
                    $a_goods_id = $arr_goods_id;
                }else{
                    $a_goods_id = array_intersect($a_goods_id,$arr_goods_id);
                    //判断交集后的是否还存在goods_id
                    if($a_goods_id == null){ //在当前属性下不在存在商品
                        break;
                    }
                }
            }
        }
        if($a_goods_id != null){
            $where['a.goods_id'] =array('IN',$a_goods_id);
        }

        //商品排序
        $order_key = 'xl';
        $order_value = 'desc';
        $order = I('get.order'); //默认已价格降序排序
        $arr = explode('_',$order);
        if($arr){
            if($arr[0] == 'time'){ //自己根据get参数来设置筛选条件,可以防止sql注入
                $order_key = 'addtime';
            }elseif($arr[0] == 'price'){
                $order_key = 'a.shop_price';
                if($arr[1] == 'asc'){
                    $order_value = 'asc';
                }
            }
        }
        //得到总的记录数 ,这里如果没有找到一条goods_id ,则 group_concat(goods_id)的值为null,count的值则为0
        $count = $this->field('count(goods_id) count,group_concat(goods_id) goods_id')->alias('a')
            ->join('LEFT JOIN __BRAND__ b ON a.brand_id=b.brand_id')
            ->where($where)->find();
        // 实例化分页类 传入总记录数和每页显示的记录数(12)
        $Page  = new \Think\Page($count['count'],12);
        $Page->lastSuffix = false; // 最后一页是否显示总页数
        $Page->rollPage = 9; //当页数超过5页时显示首页和尾页
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('first','首页');
        $Page->setConfig('last','末页');


        //得到分页字符串
        $pageStr  = $Page->show();// 分页显示输出
        //拼接limit()字段
        $data = $this  //已商品表为主导,商品不能重复,所以分组只能已主表中的数据
        ->field('a.goods_id,a.goods_name,a.shop_price,a.mid_goods_img,SUM(shop_number) xl')
            ->alias('a')
            ->join('LEFT JOIN __BRAND__ b ON a.brand_id=b.brand_id')
            ->join('LEFT JOIN __ORDER_GOODS__ c ON a.goods_id=c.goods_id')  //加上这条连表后主表数据开始有重复
            ->join('LEFT JOIN __ORDER__ d ON (c.order_id=d.order_id AND d.pay_status="是")')
            ->where($where) //数组格式的where条件
            ->group('a.goods_id')
            ->order($order_key.' '.$order_value) //默认销量降序
            ->limit($Page->firstRow.','.$Page->listRows)
            ->select();
        return array(
            'data' => $data,
            'page' => $pageStr,
            'goods_id' => $count['goods_id'],
        );
    }

    /**
     * @param $goods_id string 商品id
     * @return array
     */
    public function getConditionBygoodsId($goods_id){
            /*if(!$goods_id){
                $goods_id = '';
            }*/
            $goods_id = (string)$goods_id;
           //$goods_id是字符串格式
           $data = array();
           //品牌条件 ->根据商品id筛选出品牌即可,在首页中已经制作过
           //当前顶级分类中所拥有的品牌,取9个
           $data['brand'] = $this->field('DISTINCT b.brand_id,b.brand_name')
               ->alias('a')
               ->join('RIGHT JOIN __BRAND__ b ON a.brand_id=b.brand_id')
               ->where(array(
                   'a.goods_id' => array('in',$goods_id),
               ))
               ->select();

           //价格区间条件
           /**
            * 思路:得到这些商品的最高价,和最低价
            * 根据商品数量设计分段数,并实时计算出一个分段的商品价格区间
            * 分段数量必须>1
            */
           $price = $this->field('MAX(shop_price) max_price,MIN(shop_price) min_price')
               ->where(array(
                   'goods_id' => array('IN',$goods_id),
               ))->find();
           $max_price = $price['max_price'];
           $min_price = $price['min_price'];
           $qujian = $max_price - $min_price;
           $goods_count = count(explode(',',$goods_id));
           if($goods_count > 1){ //分段的最后一段为, 以上
               //分两段
               $fenduan = 2;
           }elseif($goods_count >= 5){
               //分4段
               $fenduan = 4;
           }elseif($goods_count >=10){
               //分6段
               $fenduan = 6;
           }
           if($fenduan > 1){ //分段大于1时才设置价格分段
               $duanPrice = floor($qujian/$fenduan);
               $fp = $min_price;
               for($i = 0;$i<$fenduan;++$i){
                   $data['price'][] = $fp.'-'.($fp+$duanPrice-1);
                   $fp = $fp+$duanPrice;
               }
               $data['price'][] = $fp.'以上'; //附加段
           }


           //商品属性条件
           $attr = D('goods_attr')->field('DISTINCT a.attr_value,a.attr_id,b.attr_name')
               ->alias('a')
               ->join('LEFT JOIN __ATTRIBUTE__ b ON a.attr_id=b.attr_id')
               ->where(array(
                   'goods_id' => array('IN',$goods_id),
               ))->select();
           //二维转三维
           foreach ($attr as $k => $v){
               $data['attr'][$v['attr_name']][] = $v;
           }
           return $data;


    }


}