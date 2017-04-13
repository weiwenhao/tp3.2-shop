<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>管理中心 - <?php echo $_page_title;?> </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
    <link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo $_page_btn_link;?>"><?php echo $_page_btn_name; ?></a></span>
    <span class="action-span1"><a href="#">管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo $_page_title;?> </span>
    <div style="clear:both"></div>
</h1>

<!--内容区域-->


<div class="form-div">
    <form action="/Admin/Goods/lst" name="searchForm" method="get">
        <p>
            商品品牌: <?php showSelect('brand_id','brand','brand_id','brand_name',I('get.brand_id'));?>
        </p>
        <p>
            商品分类:
            <select name="cat_id" id="">
                <option value="0">请选择</option>
                <?php foreach($cat_data as $k => $v):?>
                <?php
 if($v['cat_id'] == I('get.cat_id',0)){ $selected = 'selected="selected"'; }else{ $selected = ''; } ?>

                <option <?php echo $selected;?> value="<?php echo $v['cat_id'];?>">
                    <?php echo str_repeat('---/',$v['level']).$v['cat_name'];?>
                </option>
            <?php endforeach;?>
            </select>
        </p>
        <p>
            商品名称: <input type="text" name="gn" value="<?php echo I('get.gn'); ?>" size="45">
        </p>
        <p>
            价　　格: <input type="text" name="fp" value="<?php echo I('get.fp'); ?>" size="8">  -
                     <input type="text" name="tp" value="<?php echo I('get.tp'); ?>" size="8">
        </p>
        <p>
            是否上架:
            <?php $ios = I('get.ios');?>
            <input type="radio" value="" name="ios" <?php if($ios === ""){echo "checked='checked'";}?>>全部
            <input type="radio" value="是" name="ios" <?php if($ios === "是"){echo "checked='checked'";}?>>是
            <input type="radio" value="否" name="ios" <?php if($ios === "否"){echo "checked='checked'";}?>>否

        </p>
        <p>
            添加时间:
            <input type="text" name="fa"  class="addtime" value="<?php echo I('get.fa'); ?>"> -
            <input type="text" name="ta"  class="addtime" value="<?php echo I('get.ta'); ?>">
        </p>
        <p>
            <?php $paixu = I('get.paixu');?>
             <input onclick="this.parentNode.parentNode.submit()" type="radio" name="paixu" value="at_asc" <?php if( $paixu=='at_asc' )echo "checked='checked'";?> >以添加时间升序
            <input onclick="this.parentNode.parentNode.submit()" type="radio" name="paixu" value="at_desc" <?php if( $paixu=='at_desc' )echo "checked='checked'";?>  >以添加时间降序
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input onclick="this.parentNode.parentNode.submit()" type="radio" name="paixu" value="sp_asc" <?php if( $paixu=='sp_asc' )echo "checked='checked'";?>>以市场价格升序
            <input onclick="this.parentNode.parentNode.submit()" type="radio" name="paixu" value="sp_desc" <?php if( $paixu=='sp_desc' )echo "checked='checked'";?>>以市场价格降序
        </p>
        <input type="submit" value=" 搜索 " class="button" />
    </form>

</div>

<!-- 商品列表 -->
<form method="post" action="" name="listForm" onsubmit="">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>编号</th>
                <th>商品名称</th>
                <th>商品品牌</th>
                <th>商品主分类</th>
                <th>扩展分类</th>
                <th>市场价格</th>
                <th>本店价格</th>
                <th>上架</th>
                <th>排序</th>
                <th>图片</th>
                <th>添加时间</th>
                <th>操作</th>
            </tr>
            <?php foreach($data as $k => $v): ?>
            <tr class="tron">
                <td align="center"><?php echo $v['goods_id']; ?></td>
                <td align="center" class="first-cell"><?php echo $v['goods_name']; ?></span></td>
                <td align="center"><?php echo $v['brand_name']; ?></td>
                <td align="center"><?php echo $v['cat_name']; ?></td>
                <td align="center"><?php echo $v['ext_cat_name']; ?></td>
                <td align="center"><span><?php echo $v['market_price']; ?></span></td>
                <td align="center"><span><?php echo $v['shop_price']; ?></span></td>
                <td align="center"><span><?php echo $v['is_onsale']; ?></span></td>
                <td align="center"><span><?php echo $v['sort_num']; ?></span></td>
                <td align="center"><span><?php echo showImage($v['sm_goods_img']); ?></span></td>
                <td align="center"><span><?php echo $v['addtime']; ?></span></td>
                <td align="center">
                    <a href="<?php echo U('goodsNum?goods_id='.$v['goods_id']); ?>" title="库存量">库存量</a>|
                    <a href="<?php echo U('edit?goods_id='.$v['goods_id']); ?>" title="编辑">编辑</a>|
                    <a href="<?php echo U('delete?goods_id='.$v['goods_id']); ?>" onclick="return confirm('你确定要删除吗?');" title="删除">删除</a>
                </td>
            </tr>
            <?php endforeach;?>

        </table>

    <!-- 分页开始 -->
        <table id="page-table" cellspacing="0">
            <tr>
                <td width="80%">&nbsp;</td>
                <td align="center" nowrap="true">
                   <?php echo $page; ?>
                </td>
            </tr>
        </table>
    <!-- 分页结束 -->
    </div>
</form>


<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/third-party/jquery.min.js"></script>
<script src="/Public/Admin/Js/tron.js"></script>
<!--引入时间插件-->
<link href="/Public/datetimepicker/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="utf-8" src="/Public/datetimepicker/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/datetimepicker/datepicker-zh_cn.js"></script>
<link rel="stylesheet" media="all" type="text/css" href="/Public/datetimepicker/time/jquery-ui-timepicker-addon.min.css" />
<script type="text/javascript" src="/Public/datetimepicker/time/jquery-ui-timepicker-addon.min.js"></script>
<script type="text/javascript" src="/Public/datetimepicker/time/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
<script>
    //在需要的地方使用时间插件
    $.timepicker.setDefaults($.timepicker.regional['zh-CN']);//设置语言
    $(".addtime").datetimepicker();
</script>
<!--页脚区域-->
<div id="footer">
    共执行 7 个查询，用时 0.028849 秒，Gzip 已禁用，内存占用 3.219 MB<br />
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>