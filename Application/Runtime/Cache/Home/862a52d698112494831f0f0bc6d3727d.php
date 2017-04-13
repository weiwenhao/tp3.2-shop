<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <!--seo优化部分
         keywords:关键件  content="比如商品详情,商城"
         description:内容  content="家电,办公,生活用品,护理等"
        <meta name="" content="" />
    -->
    <meta name="keywords" content="<?php echo $_page_keywords; ?>" />
    <meta name="description" content="<?php echo $_page_description; ?>" />
    <title><?php echo $_page_title;?></title>
    <!--公共css部分-->
    <link rel="stylesheet" href="/Public/Home/style/base.css" type="text/css">
    <link rel="stylesheet" href="/Public/Home/style/global.css" type="text/css">
    <link rel="stylesheet" href="/Public/Home/style/header.css" type="text/css">
    <link rel="stylesheet" href="/Public/Home/style/bottomnav.css" type="text/css">
    <link rel="stylesheet" href="/Public/Home/style/footer.css" type="text/css">

    <!--公共js部分-->
    <script type="text/javascript" src="/Public/Home/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/Public/Home/js/header.js"></script>


</head>
<body>
<!-- 顶部导航 start -->
<div class="topnav">
    <div class="topnav_bd w1210 bc">
        <div class="topnav_left">

        </div>
        <div class="topnav_right fr">
            <ul>
                <li id="if_login"></li>
                <li class="line">|</li>
                <li><a href="<?php echo U('My/order');?>">我的订单</a></li>
                <li class="line">|</li>
                <li><a href="">客户服务</a></li>

            </ul>
        </div>
    </div>
</div>
<!-- 顶部导航 end -->

<div style="clear:both;"></div>

<!--内容区域-->
<!--引入布局文件-->

<!--引入特有样式文件-->
<link rel="stylesheet" href="/Public/Home/style/goods.css" type="text/css">
<link rel="stylesheet" href="/Public/Home/style/common.css" type="text/css">
<!--引入jqzoom css  -->
<link rel="stylesheet" href="/Public/Home/style/jqzoom.css" type="text/css">
<!--引入特有js文件-->
<script type="text/javascript" src="/Public/Home/js/goods.js"></script>
<script type="text/javascript" src="/Public/Home/js/jqzoom-core.js"></script>

<!-- jqzoom 效果 -->
<script type="text/javascript">
    $(function(){
        $('.jqzoom').jqzoom({
            zoomType: 'standard',
            lens:true,
            preloadImages: false,
            alwaysOn:false,
            title:false,
            zoomWidth:400,
            zoomHeight:400
        });
    })
</script>

<!--引入页头和页脚导航-->
<!-- 头部 start -->
<div class="header w1210 bc mt15">
    <!-- 头部上半部分 start 包括 logo、搜索、用户中心和购物车结算 -->
    <div class="logo w1210">
        <h1 class="fl"><a href="<?php echo U('/');?>"><img src="/Public/Home/Images/logo.png" alt="京西商城"></a></h1>
        <!-- 头部搜索 start -->
        <div class="search fl">
            <div class="search_form">
                <div class="form_left fl"></div>
                <form action="" name="serarch" method="get" class="fl">
                    <input type="text" name="key" id="key" class="txt" value="<?php echo isset($_GET['key'])?$_GET['key']:'请输入商品关键字';?>" />
                    <input onclick="location.href='<?php echo U('List/keyList','',FALSE);?>/key/'+$('#key').val()" type="button" class="btn" value="搜索"/>

                    <script>
//                        $('input[name="key"] ~ a').click(function () {
//                            var key = $('input[name="key"]').val();
//                            $(this).attr('href','<?php ?>///key/'+key);
//                        });
                        $('#key').keydown(function (event) {
                            if(event.keyCode == 13){
                                event.preventDefault();
                                window.location.href = '<?php echo U('List/keyList','',FALSE);?>/key/'+$('#key').val();
                            }
                        });
                    </script>
                </form>
                <div class="form_right fl"></div>
            </div>

            <div style="clear:both;"></div>

            <div class="hot_search">
                <strong>热门搜索:</strong>
                <a href="">D-Link无线路由</a>
                <a href="">休闲男鞋</a>
                <a href="">TCL空调</a>
                <a href="">耐克篮球鞋</a>
            </div>
        </div>
        <!-- 头部搜索 end -->

        <!-- 用户中心 start-->
        <div class="user fl">
            <dl>
                <dt>
                    <em></em>
                    <a href="">用户中心</a>
                    <b></b>
                </dt>
                <dd>
                    <div class="prompt">
                        您好，请<a href="">登录</a>
                    </div>
                    <div class="uclist mt10">
                        <ul class="list1 fl">
                            <li><a href="">用户信息></a></li>
                            <li><a href="">我的订单></a></li>
                            <li><a href="">收货地址></a></li>
                            <li><a href="">我的收藏></a></li>
                        </ul>

                        <ul class="fl">
                            <li><a href="">我的留言></a></li>
                            <li><a href="">我的红包></a></li>
                            <li><a href="">我的评论></a></li>
                            <li><a href="">资金管理></a></li>
                        </ul>

                    </div>
                    <div style="clear:both;"></div>
                    <div class="viewlist mt10">
                        <h3>最近浏览的商品：</h3>
                        <ul>
                            <li><a href=""><img src="/Public/Home/Images/view_list1.jpg" alt="" /></a></li>
                            <li><a href=""><img src="/Public/Home/Images/view_list2.jpg" alt="" /></a></li>
                            <li><a href=""><img src="/Public/Home/Images/view_list3.jpg" alt="" /></a></li>
                        </ul>
                    </div>
                </dd>
            </dl>
        </div>
        <!-- 用户中心 end-->

        <!-- 购物车 start -->
        <div class="cart fl">
            <dl>
                <dt id="getCart">
                    <a href="<?php echo U('Cart/lst');?>">去购物车结算</a>
                    <b></b>
                </dt>
                <dd>
                    <div class="prompt" id="cart">
                        <img src="/Public/Home/Images/loading.gif" width="100%" height="100%" alt="">
                    </div>
                </dd>
            </dl>
        </div>
        <!-- 购物车 end -->
    </div>
    <!-- 头部上半部分 end -->

    <div style="clear:both;"></div>

    <!-- 导航条部分 start -->
    <div class="nav w1210 bc mt10">
        <!--  商品分类部分 start-->
        <div class="category fl <?php if($index== '0'){ echo 'cat1';}?>"> <!-- 非首页，需要添加cat1类 -->
            <div class="cat_hd <?php if($index== '0'){ echo 'off';}?>" >  <!-- 注意，首页在此div上只需要添加cat_hd类，非首页，默认收缩分类时添加上off类，鼠标滑过时展开菜单则将off类换成on类 -->
                <h2>全部商品分类</h2>
                <em></em>
            </div>

            <div class="cat_bd <?php if($index== '0'){ echo 'none';}?>">
            <?php foreach($nav_data as $k => $v):?>
                <?php if($k <= 12):?>
                <div class="cat if($k==0){echo 'item1';}">
                    <h3><a href="<?php echo U('List/catList',array('cat_id'=>$v['cat_id']),FALSE);?>"><?php echo $v['cat_name'];?></a> <b></b></h3>
                    <div class="cat_detail">
                        <?php foreach($v['child'] as $k1 => $v1):?>
                            <dl class="dl_1st">
                            <dt><a href="<?php echo U('List/catList',array('cat_id'=>$v1['cat_id']),FALSE);?>"><?php echo $v1['cat_name'];?></a></dt>
                            <dd>
                                <?php foreach($v1['child'] as $k2=>$v2):?>
                                    <a href="<?php echo U('List/catList',array('cat_id'=>$v2['cat_id']),FALSE);?>"><?php echo $v2['cat_name'];?></a>
                                <?php endforeach;?>
                            </dd>
                        </dl>
                        <?php endforeach;?>
                    </div>
                </div>
                <?php endif;?>
            <?php endforeach;?>


            </div>

        </div>
        <!--  商品分类部分 end-->

        <div class="navitems fl">
            <ul class="fl">
                <li class="current"><a href="">首页</a></li>
                <li><a href="">电脑频道</a></li>
                <li><a href="">家用电器</a></li>
                <li><a href="">品牌大全</a></li>
                <li><a href="">团购</a></li>
                <li><a href="">积分商城</a></li>
                <li><a href="">夺宝奇兵</a></li>
            </ul>
            <div class="right_corner fl"></div>
        </div>
    </div>
    <!-- 导航条部分 end -->
</div>
<!-- 头部 end-->

<div style="clear:both;"></div>
<script>
    <?php $img_config = C('IMAGE_CONFIG');?>
    var viewPath = '<?php echo $img_config['viewPath'];?>';
    /***********************ajax获得购物车数据*************************/
    var cartDiv = $('#cart');
    $.ajax({
        type:'GET',
        url:'<?php echo U('Cart/ajaxgetCart');?>',
        dataType:'json',
        success:function (data) {
            if(data == ''){
                var html ='购物车中还没有商品，赶紧选购吧！';
            }else{
                var html ='<table width="100%">';
                var n = 0;
                $.each(data,function (k,v) {
                    n += v.xiaoji;
                    html += '<tr>';
                    html += '<td><img src="'+viewPath+v.sm_goods_img+'"></td>';
                    html += '<td><span style="font-size: 15px;">'+v.goods_name+'</span</td>';
                    html += '<td>&nbsp;&nbsp;&nbsp;<td/>';
                    html += '<td>￥'+v.goumai_price+'元&nbsp;*&nbsp;'+v.shop_number+'</td>';
                    html += '</tr>';
                })
                html += '<td></td> <td><span style="font-size: 18px;">合计:￥'+n+'元</span></td> <td></td> <td></td> <td ><a href="<?php echo U('Cart/lst');?>">去结算>>></a></td>'
                html += '</table>';
            }
            cartDiv.html(html);
        }
    });
</script>

<!-- 商品页面主体 start -->
<div class="main w1210 mt10 bc">
    <!-- 面包屑导航 start -->
    <div class="breadcrumb">
        <h2>当前位置：<a href="<?php echo U('index');?>">首页</a> >
            <?php foreach($cat12 as $k => $v):?>
                <a href=""><?php echo $v['cat_name']; ?></a> >
            <?php endforeach;?>
            <?php echo $data['goods_name']?>
        </h2>
    </div>
    <!-- 面包屑导航 end -->

    <!-- 主体页面左侧内容 start -->
    <div class="goods_left fl">
        <!-- 相关分类 start -->
        <div class="related_cat leftbar mt10">
            <h2><strong>相关分类</strong></h2>
            <div class="leftbar_wrap">
                <ul>
                    <li><a href="">笔记本</a></li>
                    <li><a href="">超极本</a></li>
                    <li><a href="">平板电脑</a></li>
                </ul>
            </div>
        </div>
        <!-- 相关分类 end -->

        <!-- 相关品牌 start -->
        <div class="related_cat	leftbar mt10">
            <h2><strong>同类品牌</strong></h2>
            <div class="leftbar_wrap">
                <ul>
                    <li><a href="">D-Link</a></li>
                    <li><a href="">戴尔</a></li>
                    <li><a href="">惠普</a></li>
                    <li><a href="">苹果</a></li>
                    <li><a href="">华硕</a></li>
                    <li><a href="">宏基</a></li>
                    <li><a href="">神舟</a></li>
                </ul>
            </div>
        </div>
        <!-- 相关品牌 end -->

        <!-- 热销排行 start -->
        <div class="hotgoods leftbar mt10">
            <h2><strong>热销排行榜</strong></h2>
            <div class="leftbar_wrap">
                <ul>
                    <li></li>
                </ul>
            </div>
        </div>
        <!-- 热销排行 end -->


        <!-- 浏览过该商品的人还浏览了  start 注：因为和list页面newgoods样式相同，故加入了该class -->
        <div class="related_view newgoods leftbar mt10">
            <h2><strong>浏览了该商品的用户还浏览了</strong></h2>
            <div class="leftbar_wrap">
                <ul>
                    <li>
                        <dl>
                            <dt><a href=""><img src="/Public/Home/Images/relate_view1.jpg" alt="" /></a></dt>
                            <dd><a href="">ThinkPad E431(62771A7) 14英寸笔记本电脑 (i5-3230 4G 1TB 2G独显 蓝牙 win8)</a></dd>
                            <dd><strong>￥5199.00</strong></dd>
                        </dl>
                    </li>

                    <li>
                        <dl>
                            <dt><a href=""><img src="/Public/Home/Images/relate_view2.jpg" alt="" /></a></dt>
                            <dd><a href="">ThinkPad X230i(2306-3V9） 12.5英寸笔记本电脑 （i3-3120M 4GB 500GB 7200转 蓝牙 摄像头 Win8）</a></dd>
                            <dd><strong>￥5199.00</strong></dd>
                        </dl>
                    </li>

                    <li>
                        <dl>
                            <dt><a href=""><img src="/Public/Home/Images/relate_view3.jpg" alt="" /></a></dt>
                            <dd><a href="">T联想（Lenovo） Yoga13 II-Pro 13.3英寸超极本 （i5-4200U 4G 128G固态硬盘 摄像头 蓝牙 Win8）晧月银</a></dd>
                            <dd><strong>￥7999.00</strong></dd>
                        </dl>
                    </li>

                    <li>
                        <dl>
                            <dt><a href=""><img src="/Public/Home/Images/relate_view4.jpg" alt="" /></a></dt>
                            <dd><a href="">联想（Lenovo） Y510p 15.6英寸笔记本电脑（i5-4200M 4G 1T 2G独显 摄像头 DVD刻录 Win8）黑色</a></dd>
                            <dd><strong>￥6199.00</strong></dd>
                        </dl>
                    </li>

                    <li class="last">
                        <dl>
                            <dt><a href=""><img src="/Public/Home/Images/relate_view5.jpg" alt="" /></a></dt>
                            <dd><a href="">ThinkPad E530c(33662D0) 15.6英寸笔记本电脑 （i5-3210M 4G 500G NV610M 1G独显 摄像头 Win8）</a></dd>
                            <dd><strong>￥4399.00</strong></dd>
                        </dl>
                    </li>
                </ul>
            </div>
        </div>
        <!-- 浏览过该商品的人还浏览了  end -->

        <!-- 最近浏览 start -->
        <div class="viewd leftbar mt10">
            <h2><a href="">清空</a><strong>最近浏览过的商品</strong></h2>
            <div class="leftbar_wrap" id="history">



            </div>
        </div>
        <!-- 最近浏览 end -->

    </div>
    <!-- 主体页面左侧内容 end -->

    <!-- 商品信息内容 start -->
    <div class="goods_content fl mt10 ml10">
        <!-- 商品概要信息 start -->
        <div class="summary">
            <h3><strong><?php echo $data['goods_name'];?></strong></h3>

            <!-- 图片预览区域 start -->
            <div class="preview fl">
                <div class="midpic">
                    <a href="<?php echo $viewPath.$data['mbig_goods_img']?>" class="jqzoom" rel="gal1">   <!-- 第一幅图片的大图 class 和 rel属性不能更改 -->
                       <?php showImage($data['big_goods_img']);?>               <!-- 第一幅图片的中图 -->
                    </a>
                </div>

                <!--使用说明：此处的预览图效果有三种类型的图片，大图，中图，和小图，取得图片之后，分配到模板的时候，把第一幅图片分配到 上面的midpic 中，其中大图分配到 a 标签的href属性，
                中图分配到 img 的src上。 下面的smallpic 则表示小图区域，格式固定，在 a 标签的 rel属性中，分别指定了中图（smallimage）和大图（largeimage），img标签则显示小图，按此格式循环生成即可，但在第一个li上，要加上cur类，同时在第一个li 的a标签中，添加类 zoomThumbActive  -->

                <div class="smallpic">
                    <a href="javascript:;" id="backward" class="off"></a>
                    <a href="javascript:;" id="forward" class="on"></a>
                    <div class="smallpic_wrap">
                        <ul>
                            <!--第一张图片区域(使用商品图片不使用相册循环)-->
                            <li class="cur">
                                <a class="zoomThumbActive" href="javascript:void(0);" rel="{gallery: 'gal1', smallimage: '<?php echo $viewPath.$data['big_goods_img'];?>',largeimage: '<?php echo $viewPath.$data['mbig_goods_img'];?>'}"><?php showImage($data['sm_goods_img'])?></a>
                            </li>
                            <!--相册中的图片-->
                            <?php foreach ($goods_pic as $k=>$v):?>
                                <li>
                                    <a href="javascript:void(0);" rel="{gallery: 'gal1', smallimage: '<?php echo $viewPath.$v['mid_pic'];?>',largeimage: '<?php echo $viewPath.$v['big_pic'];?>'}"><?php showImage($v['sm_pic'])?></a>
                                </li>
                            <?php endforeach;?>
                        </ul>
                    </div>

                </div>
            </div>
            <!-- 图片预览区域 end -->

            <!-- 商品基本信息区域 start -->
            <div class="goodsinfo fl ml10">
                <ul>
                    <li><span>商品编号： </span><?php echo $data['goods_id'];?></li>
                    <li class="market_price"><span>定价：</span><em>￥<?php echo $data['market_price'];?></em></li>
                    <li class="shop_price"><span>本店价：</span> <strong>￥<?php echo $data['shop_price'];?></strong> <a href="">(降价通知)</a></li>
                    <?php if($member_price): ?>
                        <li>
                            <span>会员价：</span>
                            <table width="20%" ">

                                    <?php foreach ($member_price as $k => $v):?>
                                        <tr>
                                            <td><?php echo $v['level_name'];?>:</td>
                                            <td >￥<?php echo $v['member_price'];?>元</td>
                                        </tr>
                                    <?php endforeach;?>

                            </table>
                        </li>
                    <?php endif;?>
                    <li class="shop_price"><span>购买价：</span> <strong  style="font-size: 30px" id="goumai_price"></strong></li>
                    <li><span>上架时间：</span>2012-09-12</li>
                    <li class="star"><span>商品评分：</span> <strong></strong><a href="">(已有21人评价)</a></li> <!-- 此处的星级切换css即可 默认为5星 star4 表示4星 star3 表示3星 star2表示2星 star1表示1星 -->
                </ul>
                <form action="<?php echo U('cart/add');?>" method="post" class="choose">
                    <input type="hidden" name="goods_id" value="<?php echo $data['goods_id'];?>">
                    <ul>
                        <?php foreach ($goods_attr['opt_attr'] as $k => $v):?>
                            <li class="product">
                            <dl>
                                <dt><?php echo $k;?>：</dt>
                                <dd>
                                    <?php foreach ($v as $k1 => $v1): ?>
                                    <a <?php if($k1 == 0){ echo 'class="selected"';}?> href="javascript:;"><?php echo $v1['attr_value'];?>
                                        <input type="radio" name="goods_attr_id['<?php echo $v1['attr_name']?>']" value="<?php echo $v1['goods_attr_id'];?>" <?php if($k1 == 0){ echo 'checked="checked"';}?> />
                                    </a>
                                    <?php endforeach;?>
                                </dd>
                            </dl>
                        </li>
                        <?php endforeach;?>
                        <li>
                            <dl>
                                <dt>购买数量：</dt>
                                <dd>
                                    <a href="javascript:;" id="reduce_num"></a>
                                    <input type="text" name="shop_number" value="1" class="amount"/>
                                    <a href="javascript:;" id="add_num"></a>
                                </dd>
                            </dl>
                        </li>

                        <li>
                            <dl>
                                <dt>&nbsp;</dt>
                                <dd>
                                    <input type="submit" value="" class="add_btn" />
                                </dd>
                            </dl>
                        </li>

                    </ul>
                </form>
            </div>
            <!-- 商品基本信息区域 end -->
        </div>
        <!-- 商品概要信息 end -->

        <div style="clear:both;"></div>

        <!-- 商品详情 start -->
        <div class="detail">
            <div class="detail_hd">
                <ul>
                    <li class="first"><span>商品介绍</span></li>
                    <li class="on"><span>商品评价</span></li>
                    <li><span>售后保障</span></li>
                </ul>
            </div>
            <div class="detail_bd">
                <!-- 商品介绍 start -->
                <div class="introduce detail_div none">
                    <div class="attr mt15">
                        <ul>
                            <li><span>商品名称：</span><?php echo $data['goods_name'];?></li>
                            <li><span>商品编号：</span><?php echo $data['goods_id'];?></li>
                            <?php foreach ($goods_attr['uni_attr'] as $k => $v):?>
                                <li><span><?php echo $v['attr_name'];?>：</span><?php echo $v['attr_value'];?></li>
                            <?php endforeach;?>
                        </ul>
                    </div>

                    <div class="desc mt10">
                        <!-- 此处的内容 一般是通过在线编辑器添加保存到数据库，然后直接从数据库中读出 -->
                       <?php echo $data['goods_desc'];?>
                    </div>
                </div>
                <!-- 商品介绍 end -->

                <!-- 商品评论 start -->
                <div class="comment detail_div mt10">
                    <div class="comment_summary">
                        <div class="rate fl">
                        </div>
                        <div class="percent fl">

                        </div>
                        <div class="buyer fl">
                            <dl>


                            </dl>
                        </div>
                    </div>
                    <div id="comment_list">

                    </div>




                    <!-- 分页信息 start -->
                    <div class="page mt20">

                    </div>
                    <!-- 分页信息 end -->

                    <!--  评论表单 start-->
                    <div class="comment_form mt20">
                        <form id="comment">
                            <input type="hidden" name="goods_id" value="<?php echo $data['goods_id'];?>">
                            <ul>
                                <li>
                                    <label for=""> 评分：</label>
                                    <input type="radio" name="level" value="5"/> <strong class="star star5"></strong>
                                    <input type="radio" name="level" value="4"/> <strong class="star star4"></strong>
                                    <input type="radio" name="level" value="3"/> <strong class="star star3"></strong>
                                    <input type="radio" name="level" value="2"/> <strong class="star star2"></strong>
                                    <input type="radio" name="level" value="1"/> <strong class="star star1"></strong>
                                </li>

                                <li>
                                    <label for="">评价内容：</label>
                                    <textarea name="comment_content" id="" cols="" rows=""></textarea>
                                </li>
                                <li id="yy_yx">


                                </li>
                                <li>
                                    <label for="">商品印象：</label>
                                    <input type="text" name="trait_name" /> <span>*多个印象请用逗号,隔开</span>
                                </li>
                                <li>
                                    <label for="">&nbsp;</label>
                                    <input onclick="ajaxAdd()" type="button" value="提交评论"  class="comment_btn"/>
                                </li>

                            </ul>
                        </form>
                    </div>
                    <!--  评论表单 end-->

                </div>
                <!-- 商品评论 end -->

                <!-- 售后保障 start -->
                <div class="after_sale mt15 none detail_div">
                    <div>
                        <p>本产品全国联保，享受三包服务，质保期为：一年质保 <br />如因质量问题或故障，凭厂商维修中心或特约维修点的质量检测证明，享受7日内退货，15日内换货，15日以上在质保期内享受免费保修等三包服务！</p>
                        <p>售后服务电话：800-898-9006 <br />品牌官方网站：http://www.lenovo.com.cn/</p>

                    </div>

                    <div>
                        <h3>服务承诺：</h3>
                        <p>本商城向您保证所售商品均为正品行货，京东自营商品自带机打发票，与商品一起寄送。凭质保证书及京东商城发票，可享受全国联保服务（奢侈品、钟表除外；奢侈品、钟表由本商城联系保修，享受法定三包售后服务），与您亲临商场选购的商品享受相同的质量保证。本商城还为您提供具有竞争力的商品价格和运费政策，请您放心购买！</p>

                        <p>注：因厂家会在没有任何提前通知的情况下更改产品包装、产地或者一些附件，本司不能确保客户收到的货物与商城图片、产地、附件说明完全一致。只能确保为原厂正货！并且保证与当时市场上同样主流新品一致。若本商城没有及时更新，请大家谅解！</p>

                    </div>

                    <div>
                        <h3>权利声明：</h3>
                        <p>本商城上的所有商品信息、客户评价、商品咨询、网友讨论等内容，是京东商城重要的经营资源，未经许可，禁止非法转载使用。</p>
                        <p>注：本站商品信息均来自于厂商，其真实性、准确性和合法性由信息拥有者（厂商）负责。本站不提供任何保证，并不承担任何法律责任。</p>

                    </div>
                </div>
                <!-- 售后保障 end -->

            </div>
        </div>
        <!-- 商品详情 end -->


    </div>
    <!-- 商品信息内容 end -->


</div>
<!-- 商品页面主体 end -->


<div style="clear:both;"></div>


<!--引入页头和页脚导航-->
<!-- 底部导航 start -->
<div class="bottomnav w1210 bc mt10">
    <div class="bnav1">
        <h3><b></b> <em>购物指南</em></h3>
        <ul>
            <li><a href="">购物流程</a></li>
            <li><a href="">会员介绍</a></li>
            <li><a href="">团购/机票/充值/点卡</a></li>
            <li><a href="">常见问题</a></li>
            <li><a href="">大家电</a></li>
            <li><a href="">联系客服</a></li>
        </ul>
    </div>

    <div class="bnav2">
        <h3><b></b> <em>配送方式</em></h3>
        <ul>
            <li><a href="">上门自提</a></li>
            <li><a href="">快速运输</a></li>
            <li><a href="">特快专递（EMS）</a></li>
            <li><a href="">如何送礼</a></li>
            <li><a href="">海外购物</a></li>
        </ul>
    </div>


    <div class="bnav3">
        <h3><b></b> <em>支付方式</em></h3>
        <ul>
            <li><a href="">货到付款</a></li>
            <li><a href="">在线支付</a></li>
            <li><a href="">分期付款</a></li>
            <li><a href="">邮局汇款</a></li>
            <li><a href="">公司转账</a></li>
        </ul>
    </div>

    <div class="bnav4">
        <h3><b></b> <em>售后服务</em></h3>
        <ul>
            <li><a href="">退换货政策</a></li>
            <li><a href="">退换货流程</a></li>
            <li><a href="">价格保护</a></li>
            <li><a href="">退款说明</a></li>
            <li><a href="">返修/退换货</a></li>
            <li><a href="">退款申请</a></li>
        </ul>
    </div>

    <div class="bnav5">
        <h3><b></b> <em>特色服务</em></h3>
        <ul>
            <li><a href="">夺宝岛</a></li>
            <li><a href="">DIY装机</a></li>
            <li><a href="">延保服务</a></li>
            <li><a href="">家电下乡</a></li>
            <li><a href="">京东礼品卡</a></li>
            <li><a href="">能效补贴</a></li>
        </ul>
    </div>
</div>
<!-- 底部导航 end -->
<div style="clear:both;"></div>

<!--点击弹出登录html代码 start-->
<link rel="stylesheet" type="text/css" href="/Public/dianjitanchu/css/normalize.css" />
<link type="text/css" rel="stylesheet" href="/Public/dianjitanchu/css/style.css" />
<style type="text/css">
    .tc{display: block;padding: 1em 1.5em;border: 3px solid #fff;font-weight: 700;margin: 50px auto;background:#1d7db1;color: #fff;}
    .tc a:hover{opacity: 0.6;}
</style>
<div id="gray"></div>
<div class="popup" id="popup">
    <div class="top_nav" id='top_nav'>
        <div align="center">
            <span>登录账号</span>
            <a class="guanbi"></a>
        </div>
    </div>
    <div class="min">
        <div class="tc_login">
            <div class="left">
                <h4 align="center">手机扫描</h4>
                <div align="center"><img src="/Public/dianjitanchu/Images/erweima.jpg" width="150" height="150" /></div>
                <dd>
                    <div align="center">扫描二维码登录</div>
                </dd>
            </div>
            <div class="right">
                <form method="POST" name="form_login" target="_top">
                    <div align="center">
                        <input type="text" name="member_name" id="name" required="required" placeholder="用户名" autocomplete="off" class="input_yh">
                        <input type="password" name="password" id="pass" required="required" placeholder="密码" autocomplete="off" class="input_mm">
                        <input type="text" name="captcha" id="name" required="required" placeholder="验证码" autocomplete="off" >
                        <div style="margin-top: 10px;">
                            <img style="cursor: pointer;" src="<?php echo U('Member/captcha');?>" alt="" onclick="this.src='<?php echo U('Member/captcha');?>#'+Math.random();"/>
                        </div>
                    </div>

                    <div align="center">
                        <input type="button" class="button" title="Sign In" value="登录">
                    </div>
                </form>

                <hr align="center" />
                <div align="center">期待更多功能 </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    //点击关闭按钮
    $("a.guanbi").click(function(){
        $("#gray").hide();
        $("#popup").hide();//查找ID为popup的DIV hide()隐藏
    })

    //窗口水平居中
    $(window).resize(function(){
        tc_center();
    });

    function tc_center(){
        var _top=($(window).height()-$(".popup").height())/2;
        var _left=($(window).width()-$(".popup").width())/2;

        $(".popup").css({top:_top,left:_left});
    }
</script>
<!--点击弹出登录框设置-->
<script type="text/javascript">
    $(document).ready(function(){

        $(".top_nav").mousedown(function(e){
            $(this).css("cursor","move");//改变鼠标指针的形状
            var offset = $(this).offset();//DIV在页面的位置
            var x = e.pageX - offset.left;//获得鼠标指针离DIV元素左边界的距离
            var y = e.pageY - offset.top;//获得鼠标指针离DIV元素上边界的距离
            $(document).bind("mousemove",function(ev){ //绑定鼠标的移动事件，因为光标在DIV元素外面也要有效果，所以要用doucment的事件，而不用DIV元素的事件

                $(".popup").stop();//加上这个之后

                var _x = ev.pageX - x;//获得X轴方向移动的值
                var _y = ev.pageY - y;//获得Y轴方向移动的值

                $(".popup").animate({left:_x+"px",top:_y+"px"},10);
            });

        });

        $(document).mouseup(function() {
            $(".popup").css("cursor","default");
            $(this).unbind("mousemove");
        });
    })
</script>
<!--登陆弹出end-->

<script>
    var isLogin = 0; //全局变量,用来记录登陆状态

    /********************ajax实现最近浏览过的商品*****************************/
    var div = $('#history');
    //读取浏览器中图片的根目录,保证数据的灵活性
    var viewPath = '<?php echo $viewPath;?>';
    $.ajax({
        type:'GET',
        url:'<?php echo U('ajaxHistory',array('goods_id'=>$data['goods_id']))?>',
        dataType:'json',
        success:function (data) {
            //字符串拼接并追加
            $.each(data,function (k,v) {
                var dl = '<dl><dt><a href="<?php echo U('goods','',FALSE).'/goods_id/';?>'+v.goods_id+'"><img src="'+viewPath+v.sm_goods_img+'" alt=""/></a></dt><dd><a href="<?php echo U('goods','',FALSE).'/goods_id/';?>'+v.goods_id+'">'+v.goods_name+'</a></dd></dl>'
                div.append(dl);
            })

        }
    });

    /**************************当前用户的实际购买价格****************************/
    var strong = $('#goumai_price');
    $.ajax({
        type:'GET',
        url:'<?php echo U('ajaxPrice',array('goods_id'=>$data['goods_id']))?>',
        dataType:'text',
        success:function (data) {
            //字符串拼接并追加
            strong.text(data);
        }
    });

    /********************ajax提交评论************************/
    function ajaxAdd() {
        //收集表单数据并拼接成jq中ajax中需要的格式
        var form = $('#comment').serialize();
        //ajax提交
        $.ajax({
            type:'POST',
            url:'<?php echo U('Comment/ajaxAdd');?>',
            data:form,
            dataType:'json',
            success:function (data) {
                //{info: "请先登录", status: 0, url: ""} 失败后返回的格式
                if(data.status == 0){
                    if(data.info == '请先登录'){  //ajax登录
                        $("#gray").show();
                        $("#popup").show();//查找ID为popup的DIV show()显示#gray
                        tc_center();
                        //为登陆按钮绑定一个按下事件
                        $('.button').click(function () {
                            //收集表单
                            var form = $('[name="form_login"]').serialize();
                            //ajax提交
                            $.ajax({
                                type:'POST',
                                url:'<?php echo U('Member/login');?>',
                                data:form,
                                dataType:'json',
                                success:function (data) {
                                    if(data.status == 1){
                                        //登陆成功后的操作
                                        //重置表单
                                        $('[name="form_login"]').trigger('reset');
                                        //关闭登陆窗口
                                        $("#gray").hide();
                                        $("#popup").hide();//查找ID为popup的DIV hide()隐藏
                                        //在全局变量记录登陆状态
                                        isLogin = 1; //1为登陆
                                    }else{
                                        //登陆失败后的操作
                                        alert(data.info);
                                    }

                                }
                            });
                        });

                    }else{
                        alert(data.info);
                    }

                }else{
                   /*{comment_id: "2", comment_content: "测试一次", level: "3", member_name: "1234",…}*/
                   //清空表单
                    $('#comment').trigger('reset');
                   //如果添加成功则拼接一条评论信息,并插入到 #comment_list的头部
                    var html = '<div class="comment_items mt10 none">' +
                        '<div class="user_pic"><dl><dt><a href=""><img src="'+data.info.member_face+'" alt="" /></a></dt> <dd><a href="">'+data.info.member_name+'</a></dd></dl></div>' +
                        '<div class="item"><div class="title"><span>'+data.info.add_time+'</span><strong class="star star'+data.info.level+'"></strong></div>' +
                        '<div class="comment_content"><dl><dt>评价内容：</dt><dd>'+data.info.comment_content+'</dd></dl></div>' +
                        '<div class="btns"><a href="" class="reply">回复(0)</a><a href="" class="useful">有用(0)</a></div></div>' +
                        '<div class="cornor"></div></div>';

                    html = $(html); //把html代码转化为jquery对象
                    $('#comment_list').prepend(html); //html追加
                    //动画效果
                    $("body").animate({
                        "scrollTop" : "720px"
                    },1000,function () {
                        html.fadeIn(2000);
                    }); //animate的第三个参数是成功之后的回调函数
                }
            }

        });
    }

    /**********************评论区列表页展示*********************/
    //通过ajax得到分页数据,包括某一页的数据,和总的页码数
    function fanye(p) {
        $.ajax({
            type:'GET',
            url:'<?php echo U('Comment/ajaxPage',array('goods_id'=>$data['goods_id']),false);?>/p/'+p,
            dataType:'json',
            success:function (data) {
                //先拼一页记录
                var html = '';
                $.each(data.pageData,function (k,v) {
                        html += '<div class="comment_items mt10">' +
                        '<div class="user_pic"><dl><dt><a href=""><img src="'+v.face+'" alt="" /></a></dt> <dd><a href="">'+v.member_name+'</a></dd></dl></div>' +
                        '<div class="item"><div class="title"><span>'+v.add_time+'</span><strong class="star star'+v.level+'"></strong></div>' +
                        '<div class="comment_content"><dl><dt>评价内容：</dt><dd>'+v.comment_content+'</dd></dl></div>' +
                        '<div class="btns"><a href="" class="reply">回复('+v.reply_count+')</a><a href="" class="useful">有用('+v.agree_count+')</a></div></div>' +
                        '<div class="cornor"></div></div>';
                })
                $('#comment_list').html(html);

                //拼页码字符串
                var pageNum = data.pageNum; //总的页码数
                if( p > pageNum){
                    p = pageNum;
                }
                if( p < 1){
                    p = 1;
                }
                var pageString = '<a href="javascript:void(0);" onclick="fanye(1)">首页</a>';
                pageString+= '<a href="javascript:void(0);" onclick="fanye('+(p-1)+')">上一页</a>';
                for(var i=1;i<=pageNum;++i){
                    if(i == p){
                        var cls = 'class="cur"';//class是关键字,不能使用,使用cls
                    }else{
                        var cls = '';
                    }
                    pageString += '<a href="javascript:void(0);" '+cls+' onclick="fanye('+i+')">'+i+'</a>';
                }
                pageString += '<a href="javascript:void(0);" onclick="fanye('+(p+1)+')">下一页</a>';
                pageString += '<a href="javascript:void(0);" onclick="fanye('+pageNum+')">尾页</a>';
                //将分页字符串追加到div中
                $('.page').html(pageString);

                if(p == 1){
                    //评价比例
                    var hao = ' <strong><em>'+data.hao+'</em>%</strong> <br /><span>好评度</span>';
                    $('.rate').html(hao);

                    var baifen = ' <dl> <dt>好评（'+data.hao+'%）</dt> <dd><div style="width:'+data.hao+'px;"></div></dd> </dl> <dl> <dt>中评（'+data.zhong+'%）</dt> <dd><div style="width:'+data.zhong+'px;"></div></dd> </dl> <dl> <dt>差评（'+data.cha+'%）</dt> <dd><div style="width:'+data.cha+'px;" ></div></dd> </dl>'
                    $('.percent').html(baifen);

                    //买家印象
                    var yx = '<dt>买家印象：</dt>';
                    $.each(data.yx_data,function (k,v) {
                        yx += '<dd><span>'+v.trait_name+'</span><em>('+v.trait_count+')</em></dd>';
                    })

                    $('.buyer dl').html(yx);

                    //已有印象再拼接一个复选框
                    var yy_yx = '<label for="">已有印象：</label>';
                    $.each(data.yx_data,function (k,v) {
                       yy_yx += '<input type="checkbox" name="yy_yx[]" value="'+v.trait_name+'">'+v.trait_name+'&nbsp;  ';
                    })
                    $('#yy_yx').append(yy_yx);
                }
            }
        });
    }
    fanye(1); //先调用一次函数得到第一页的数据



</script>

<!--页脚部分-->
<div style="clear:both;"></div>
<!-- 底部版权 start -->
<div class="footer w1210 bc mt15">
    <p class="links">
        <a href="">关于我们</a> |
        <a href="">联系我们</a> |
        <a href="">人才招聘</a> |
        <a href="">商家入驻</a> |
        <a href="">千寻网</a> |
        <a href="">奢侈品网</a> |
        <a href="">广告服务</a> |
        <a href="">移动终端</a> |
        <a href="">友情链接</a> |
        <a href="">销售联盟</a> |
        <a href="">京西论坛</a>
    </p>
    <p class="copyright">
        © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号
    </p>
    <p class="auth">
        <a href=""><img src="/Public/Home/Images/xin.png" alt="" /></a>
        <a href=""><img src="/Public/Home/Images/kexin.jpg" alt="" /></a>
        <a href=""><img src="/Public/Home/Images/police.jpg" alt="" /></a>
        <a href=""><img src="/Public/Home/Images/beian.gif" alt="" /></a>
    </p>
</div>
<!-- 底部版权 end -->


</body>
</html>
<script>
    var li = $('#if_login');
    $.ajax({
        type:'GET',
        url:'<?php echo U('Index/ajaxIfLogin')?>',
        dataType:'text',
        success:function (data) {
            if(data == 1){
                var html = '你好，<?php echo session('member_name');?>，欢迎来到京西！[<a href="<?php echo U('Member/logout');?>">退出</a>]';
            }else{
                var html = '您好，欢迎来到京西！[<a href="<?php echo U('Member/login');?>">登录</a>] [<a href="<?php echo U('Member/regist');?>">免费注册</a>] ';
            }
            li.html(html);
        }
    });
</script>