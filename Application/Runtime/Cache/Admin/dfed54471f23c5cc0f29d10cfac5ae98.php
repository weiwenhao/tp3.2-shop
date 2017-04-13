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


<div class="main-div">
    <form name="main_form" method="POST" action="/index.php/Admin/Category/edit/cat_id/16/p/1.html" enctype="multipart/form-data" >
    	<input type="hidden" name="cat_id" value="<?php echo $data['cat_id']; ?>" />
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">分类名称：</td>
                <td>
                    <input  type="text" name="cat_name" value="<?php echo $data['cat_name']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">父级分类：</td>
                <td>
                    <select name="pid" id="">
                    <option value="0">顶级分类</option>
                    <?php foreach($cat_data as $k => $v):?>
                        <?php if( !in_array($v['cat_id'],$not_cat_ids) && $v['cat_id'] != $data['cat_id'] ):?>
                             <?php
 $selected = ''; if($v['cat_id'] == $data['pid']){ $selected = 'selected="selected"'; } ?>

                            <option <?php echo $selected;?> value="<?php echo $v['cat_id'];?>">
                                <?php echo str_repeat('---/',$v['level']).$v['cat_name'];?>
                            </option>
                        <?php endif;?>
                    <?php endforeach;?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label">是否推荐到首页楼层：</td>
                <td>
                    <input type="radio" name="is_floor" value="是" <?php if($data['is_floor']=='是'){echo 'checked="checked"';}?>/>是
                    <input type="radio" name="is_floor" value="否" <?php if($data['is_floor']=='否'){echo 'checked="checked"';}?>/>否
                </td>
            </tr>
            <tr>
                <td colspan="99" align="center">
                    <input type="submit" class="button" value=" 确定 " />
                    <input type="reset" class="button" value=" 重置 " />
                </td>
            </tr>
        </table>
    </form>
</div>


<script>
</script>
<!--页脚区域-->
<div id="footer">
    共执行 7 个查询，用时 0.028849 秒，Gzip 已禁用，内存占用 3.219 MB<br />
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>