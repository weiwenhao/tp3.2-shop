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

<style>
    #ul_pic_list li{margin:10px;list-style-type:none;}
</style>
<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front" >通用信息</span>
            <span class="tab-back" >商品描述</span>
            <span class="tab-back" >会员价格</span>
            <span class="tab-back" >商品属性</span>
            <span class="tab-back" >商品相册</span>
        </p>
    </div>
    <div id="tabbody-div">
        <form enctype="multipart/form-data" action="/Admin/Goods/edit/goods_id/97.html" method="post">
            <input type="hidden" name="goods_id" value="<?php echo $data['goods_id'];?>">
            <!--基本信息-->
            <table width="90%" class="tab_table"  align="center">
                <tr>
                    <td class="label">商品品牌：</td>
                    <td>
                        <?php showSelect('brand_id','brand','brand_id','brand_name',$data['brand_id']);?>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品主分类：</td>
                    <td>
                        <select name="cat_id" id="">
                            <option value="0">请选择</option>
                            <?php foreach($cat_data as $k => $v):?>
                                <?php
 $selected = ''; if($v['cat_id'] == $data['cat_id']){ $selected = 'selected="selected"'; } ?>

                                <option <?php echo $selected;?> value="<?php echo $v['cat_id'];?>">
                                    <?php echo str_repeat('---/',$v['level']).$v['cat_name'];?>
                                </option>
                            <?php endforeach;?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品扩展分类：</td>
                    <td>
                        <input type="button" id="add_cat" value="添加一个">
                        <!--把已有的商品扩展分类显示出来-->
                        <?php foreach($ext_cat_data as $k => $ext_v): ?>
                            <li>
                                <select name="ext_cat_ids[]" >
                                    <option value="0">请选择</option>
                                    <?php foreach($cat_data as $k => $v):?>
                                    <?php
 $selected = ''; if($v['cat_id'] == $ext_v['cat_id']){ $selected = 'selected="selected"'; } ?>

                                    <option <?php echo $selected;?> value="<?php echo $v['cat_id'];?>">
                                    <?php echo str_repeat('---/',$v['level']).$v['cat_name'];?>
                                    </option>
                                    <?php endforeach;?>
                                </select>
                                <input type="button" value="删除" class="rm_cat" >
                            </li>
                        <?php endforeach;?>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品名称：</td>
                    <td><input type="text" name="goods_name" value="<?php echo $data['goods_name'];?>"size="30" />
                        <span class="require-field">*</span></td>
                </tr>

                <tr>
                    <td class="label">市场售价：</td>
                    <td>
                        <input type="text" name="market_price" size="8" value="<?php echo $data['market_price'];?>"/>
                    </td>
                </tr>
                <tr>
                    <td class="label">本店售价：</td>
                    <td>
                        <input type="text" name="shop_price" value="<?php echo $data['shop_price'];?>" size="20"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">促销价格：</td>
                    <td>
                        <input type="text" name="promote_price" value="<?php echo $data['promote_price'];?>" size="20"/>
                    </td>
                </tr>
                <tr>
                    <td class="label">促销时间：</td>
                    <td>
                        <input type="text" class="promote_date" name="promote_start_date" value="<?php echo $data['promote_start_date'];?>" size="20"/> 至
                        <input type="text" class="promote_date" name="promote_end_date" value="<?php echo $data['promote_end_date'];?>" size="20"/>
                    </td>
                </tr>
                <tr>
                    <td class="label">是否上架：</td>
                    <td>
                        <input type="radio" name="is_onsale" value="是" <?php if($data['is_onsale'] == '是') echo 'checked="checked"';?>/> 是
                        <input type="radio" name="is_onsale" value="否" <?php if($data['is_onsale'] == '否') echo 'checked="checked"';?>/> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">是否热卖：</td>
                    <td>
                        <input type="radio" name="is_hot" value="是" <?php if($data['is_hot'] == '是') echo 'checked="checked"';?> /> 是
                        <input type="radio" name="is_hot" value="否" <?php if($data['is_hot'] == '否') echo 'checked="checked"';?>/> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">是否精品：</td>
                    <td>
                        <input type="radio" name="is_best" value="是" <?php if($data['is_best'] == '是') echo 'checked="checked"';?>/> 是
                        <input type="radio" name="is_best" value="否" <?php if($data['is_best'] == '否') echo 'checked="checked"';?>/> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">是否新品：</td>
                    <td>
                        <input type="radio" name="is_new" value="是" <?php if($data['is_new'] == '是') echo 'checked="checked"';?>/> 是
                        <input type="radio" name="is_new" value="否" <?php if($data['is_new'] == '否') echo 'checked="checked"';?>/> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">排序数字：</td>
                    <td>
                        <input type="text" name="sort_num" value="<?php echo $data['sort_num'];?>" size="20"/>
                        <span>数字越小排名越靠前,每件商品数字间隔最好在10左右</span>
                    </td>
                </tr>

                <tr>
                    <td class="label">商品图片：</td>
                    <td>
                        <?php echo showImage($data['mid_goods_img']); ?><br>
                        <input type="file" name="goods_img" size="35" />
                    </td>
                </tr>
            </table>
            <!--商品描述-->
            <table style="display:none;" width="100%" class="tab_table" align="center">
                <tr>
                    <td>
                            <textarea name="goods_desc" cols="40" rows="3" id="goods_desc" style="width:800px;height:240px;">
                                <?php echo $data['goods_desc'];?>
                            </textarea>
                    </td>
                </tr>
            </table>
            <!--会员价格-->
            <table style="display:none;" width="90%" class="tab_table" align="center">
                <tr>
                    <td align="center">
                        <span class="require-field">--会员价格设为0则清空会员价格--</span>
                        <?php foreach($ml_data as $k => $v):?>
                        <p>
                            <?php echo $v['level_name'];?>:
                            <input type="text" name="member_price[<?php echo $v['level_id']; ?>]"
                                   value="<?php echo $mp_data[$v['level_id']]?>" size="10" /><br>
                        </p>
                        <?php endforeach;?>
                    </td>
                </tr>
            </table>
            <!--商品属性-->
            <table style="display:none;" width="90%" class="tab_table" align="center">
                <tr>
                    <td id="add_attr">
                        <?php showSelect('type_id','type','type_id','type_name',$data['type_id']);?>
                        <span class="require-field">* 以下属性请务必选择和填写,未选择或未填写的属性将不更新</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <ul id="attr_list">
                            <?php $attr_ids = array(); ?>
                            <?php foreach($attr_data as $k=>$v):?>
                                <li>
                                    <input type="hidden" name="goods_attr_id[]" value="<?php echo $v['goods_attr_id'];?>">
                                    <?php
 if($v['attr_type'] == '可选'): if(!in_array($v['attr_id'],$attr_ids)){ echo '<a href="#" onclick="add_self(this)">[+]</a>'; }else{ echo '<a href="#" onclick="add_self(this)">[-]</a>'; } $attr_ids[] = $v['attr_id']; endif;?>
                                    <?php echo $v['attr_name'];?>:
                                    <?php if($v['attr_option_value'] == ''):?>
                                        <input type="text" name="attr_value[<?php echo $v['attr_id'];?>][]" value="<?php echo $v['attr_value'];?>">
                                    <?php else:?>
                                        <select name="attr_value[<?php echo $v['attr_id'];?>][]">
                                                <option value="">请选择</option>
                                            <?php
 $v['attr_option_value'] = explode(',',$v['attr_option_value']); foreach($v['attr_option_value'] as $k1=>$v1): if($v['attr_value'] == $v1){ $selected = "selected='selected'"; }else{ $selected = ""; } ?>
                                                <option <?php echo $selected;?> value="<?php echo $v1;?>"><?php echo $v1;?></option>
                                            <?php
 endforeach; ?>

                                        </select>
                                    <?php endif;?>
                                </li>
                            <?php endforeach;?>
                        </ul>
                    </td>
                </tr>
            </table>
            <!--商品相册-->
            <table style="display:none;" width="90%" class="tab_table" align="center">
                <tr>
                    <td>
                        <input type="button" id="add_pic" value="添加一张">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php foreach($gp_data as $k => $v):?>
                        <p>
                            <?php showImage($v['mid_pic']);?>
                            <input pic_id="<?php echo $v['pic_id'];?>" type="button" value="删除" class="del_pic">
                        </p>
                        <?php endforeach;?>
                    </td>
                </tr>
                <tr id="pic_file">
                    <td align="center">

                    </td>
                </tr>
            </table>





            <div class="button-div">
                <input type="submit" value=" 确定 " class="button"/>
                <input type="reset" value=" 重置 " class="button" />
            </div>
        </form>
    </div>
</div>


<link href="/Public/umeditor1_2_2-utf8-php/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="/Public/Admin/Js/jquery-1.7.1.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/umeditor1_2_2-utf8-php/umeditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/umeditor1_2_2-utf8-php/umeditor.min.js"></script>
<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/lang/zh-cn/zh-cn.js"></script>
<!--引入时间插件-->
<link href="/Public/datetimepicker/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="utf-8" src="/Public/datetimepicker/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/datetimepicker/datepicker-zh_cn.js"></script>
<link rel="stylesheet" media="all" type="text/css" href="/Public/datetimepicker/time/jquery-ui-timepicker-addon.min.css" />
<script type="text/javascript" src="/Public/datetimepicker/time/jquery-ui-timepicker-addon.min.js"></script>
<script type="text/javascript" src="/Public/datetimepicker/time/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>


<script type="text/javascript">
    /**********************时间插件******************************/
    $.timepicker.setDefaults($.timepicker.regional['zh-CN']);//设置语言
    $(".promote_date").datetimepicker();
    /*********************在线编辑器****************************/
    var um = UM.getEditor('goods_desc',{
        initialFrameWidth:"100%",
        initialFrameHeight:"500",
    });

    /******************点击切换table效果实现*************************/
    //首先给给5个按钮分别添加点击事件
    $('#tabbar-div span').click(function () {
        var i = $(this).index();
        //先隐藏所有的class样式
        $('.tab_table').css('display','none');
        //显示点击的下标的对应的table
        $('.tab_table:eq('+i+')').css('display','');
        //找到原来的tab-front,讲其改成 tab-back,然后将现在点击的class属性改为tab-front
        $('.tab-front').attr('class','tab-back');
        $(this).attr('class','tab-front');


    });

    /*****************添加相册事件*********************/
    //点击添加一张按钮创建 file框
    $('#add_pic').click(function () {
        //this代表当前节点的dom对象
        $('#pic_file td').append('<p><input type="file" name="pic[]"></p>'); //在td节点中追加
    });


    /*******************删除相册事件*********************/
    $('.del_pic').click(function () {
        if(confirm('你确定要删除吗?') == false){
            return false;
        }
        //得到相册的pic_id;
        var pic_id = $(this).attr('pic_id');
        //触发一个ajax事件删除数据库路径,和数据库缓存
        var res = '';
         $.ajax({
             type:'POST',
             url:"<?php echo U('picDel');?>",
             data:'pic_id='+pic_id,
             dataType:'json',
             async:false,
             success:function (msg) {
                 res = msg;
             }
         });
        if(res.result == 1){
            $(this).parent().remove();
        }
    });

    /*******************添加扩展分类************************/
    $('#add_cat').click(function () {
        $(this).parent().append("<li><select name='ext_cat_ids[]'> <option value=''>请选择</option> <?php foreach($cat_data as $k => $v):?><option value=\"<?php echo $v['cat_id'];?>\"> <?php echo str_repeat('---/',$v['level']).$v['cat_name'];?></option> <?php endforeach;?></select></li>");
    });

    /*********************删除扩展分类***************************/
    $('.rm_cat').click(function () {
        $(this).parent().remove();
    })

    /***********************添加商品属性*****************************/
    $('#add_attr').find('select').change(function () {
        var ul = $('#attr_list');
        //清空ul下的html标签
        ul.html('');
        var str = '';
        $.ajax({
            type:'GET',
            dataType:'json',
            url:'<?php echo U("getAttr","",FALSE)?>/type_id/'+$(this).val(),
            success:function (data) {
                //二维数组,拼接成  <li>[+]attr_name:select<li>
                $.each(data,function (k,v) {
                    str += '<li>';
                    if(v.attr_type == '可选'){
                        str += '<a href="#" onclick="add_self(this)">[+]</a>';
                    }
                    //拼接下拉框或者输入框,根据可选值来判断
                    if(v.attr_option_value == ''){
                        str += v.attr_name+':<input type="text" value="" name="attr_value['+v.attr_id+'][]"/>';
                    }else{
                        str += v.attr_name+':<select name="attr_value['+v.attr_id+'][]">';
                        str += '<option value="">请选择</option>';
                        //把字符串转化成数组
                        v.attr_option_value = v.attr_option_value.split(',');
                        $.each(v.attr_option_value,function (k,v) {
                            str += '<option value="'+v+'">';
                            str +=  v;
                            str += '</option>';
                        });
                        str += '</select>';
                    }
                    str += '</li>';
                })

                //字符串追加
                ul.append(str);
            }
        });

    });

    /**********************添加和删除商品属性分类*********************/
    function add_self(a) {
        // $(a)  --> 把a转换成jquery中的对象，然后才能调用jquery中的方法
        // 先获取所在的li
        var li = $(a).parent();
        if($(a).text() == '[+]')
        {
            var newLi = li.clone();
            // +变-
            newLi.find("a").text('[-]');
            newLi.find('input[type="hidden"]').val('');
            newLi.find('option').removeAttr('selected');
            // 新的放在li后面
            li.after(newLi);
        }
        else{
            //先得到goods_attr_id
            var goods_attr_id =li.find('input[type="hidden"]').val()
            if( goods_attr_id != ''){
                //如果隐藏域中有id,提示用户是否要删除
                if(confirm('删除该属性的同时会删除该属性所对应库存量---你确定要删除吗?')) {
                    $.ajax({
                        type:'GET',
                        url:"<?php echo U('delAttr?goods_id='.$data['goods_id'],'',FALSE);?>/goods_attr_id/"+goods_attr_id,
                    });
                }else{
                    return false;
                }
            }
            li.remove();
        }

    }

</script>



<!--页脚区域-->
<div id="footer">
    共执行 7 个查询，用时 0.028849 秒，Gzip 已禁用，内存占用 3.219 MB<br />
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>