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
</div>

<!-- 商品列表 -->
<form method="post" action="/Admin/Goods/goodsNum/goods_id/88.html" name="listForm" onsubmit="">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
    <?php if (!$data):?>
                <tr>
                    <th>库存量</th>
                    <th>操作</th>
                </tr>
               <tr>
                   <td align="center"><input type="text" name="goods_number[]" value=""></td>
                   <td align="center">
                       <?php  if($key == 0){ $fuhao = '+'; }else{ $fuhao = '-'; } ?>
                       <input type="button" value="<?php echo $fuhao;?>" onclick="add_self(this)" />
                   </td>
               </tr>
                <tr>
                    <td align="center" colspan="2"><input type="submit" value="提交"></td>
                </tr>

    <?php else:?>

            <tr>
             <?php foreach($gnData as $k=>$v):?>
                <th><?php echo $k;?></th>
             <?php endforeach;?>
                <th>库存量</th>
                <th>操作</th>
            </tr>
        <?php foreach($data as $key => $value):?>
            <tr class="tron">
            <?php foreach($gnData as $k=>$v): ?>
                <td align="center">
                    <select name="goods_attr_ids[]">
                        <option value="">请选择</option>
                        <?php foreach($v as $k1=>$v1): ?>
                            <?php
 $goods_attr_ids = explode(',',$value['goods_attr_ids']); if(in_array($v1['goods_attr_id'],$goods_attr_ids) ){ $selected="selected='selected'"; }else{ $selected=''; } ?>
                            <option <?php echo $selected;?> value="<?php echo $v1['goods_attr_id'];?>"><?php echo $v1['attr_value'];?></option>
                        <?php endforeach;?>
                    </select>
                </td>
            <?php endforeach;?>
                <td align="center"><input type="text" name="goods_number[]" value="<?php echo $value['goods_number'];?>"></td>
                <td align="center">
                    <?php  if($key == 0){ $fuhao = '+'; }else{ $fuhao = '-'; } ?>
                    <input type="button" value="<?php echo $fuhao;?>" onclick="add_self(this)" />
                </td>
            </tr>
        <?php endforeach ?>

            <tr id="last-tr">
                <?php $count = count($gnData);?>
                <td align="center" colspan="<?php echo $count+2;?>"><input type="submit" value="提交"></td>
            </tr>
    <?php endif;?>
        </table>
    </div>
</form>


<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/third-party/jquery.min.js"></script>
<script src="/Public/Admin/Js/tron.js"></script>
<script>

    /*******************添加一行属性记录***********************/
    function add_self(input) {
        var tr = $(input).parent().parent();
        if($(input).val() == '+'){
            //克隆一行tr
            var newtr = tr.clone(true);
            //处理tr
            newtr.find('td').css('backgroundColor','');
            newtr.find('input[type="button"]').val('-');
            newtr.find('input[type="text"]').val('');
            newtr.find('option').removeAttr('selected');
            //处理鼠标移入移出事件
            //追加到最后一行之前
            $('#last-tr').before(newtr);
        }else{
            tr.remove();
        }
    }

</script>
<!--页脚区域-->
<div id="footer">
    共执行 7 个查询，用时 0.028849 秒，Gzip 已禁用，内存占用 3.219 MB<br />
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>