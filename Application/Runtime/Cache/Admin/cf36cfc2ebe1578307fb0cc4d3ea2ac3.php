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
    <form name="main_form" method="POST" action="/Admin/Role/edit/role_id/1.html" enctype="multipart/form-data" >
    	<input type="hidden" name="role_id" value="<?php echo $data['role_id']; ?>" />
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">角色名称：</td>
                <td>
                    <input  type="text" name="role_name" value="<?php echo $data['role_name']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">权限列表：</td>
                <td>
                    <?php foreach ($auth_data as $k=> $v):?>
                        <?php echo str_repeat('--------/',$v['level']);?>
                        <input <?php echo 'level="'.$v['level'].'"'; ?>
                            type="checkbox" name="auth_ids[]"
                            value="<?php echo $v['auth_id']?>"
                            <?php if(in_array($v['auth_id'],$auth_ids)){echo "checked='checked'";}?>
                        >
                        <?php echo $v['auth_name'];?>
                        <br>
                    <?php endforeach;?>
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


<script type="text/javascript" src="/Public/Admin/Js/jquery-1.7.1.js"></script>
<script>
    $('input:checkbox').click(function () {
        //得到当前的复选框的选中状态
        var bool = $(this).prop('checked');
        //得到当前复选框的level值
        var level = $(this).attr('level');
        //选中 当前选中元素的所有子元素(同一类型中的元素)
        $(this).nextAll(':checkbox').each(function (k,v) {
            //k是索引,从0开始  v是所有满足nextAll条件的dom对象
            //当前level需要大于选中的level才被选中
            if( $(v).attr('level') > level ){
                $(v).prop('checked',bool);
            }else{
                //跳出each循环
                return false;
            }

        })
        //选中 当前选中元素的所有父元素(同一类型中的元素)
        $(this).prevAll(':checkbox').each(function (k,v) {
            //k是索引,从0开始  v是所有满足prevAll条件的dom对象
            //当前level需要大于选中的level才被选中
            if( $(v).attr('level') < level ){
                //level数字越小等级越高
                $(v).prop('checked',true); //将找到的复选框勾选
                level--; //将需找的等级提高一级
            }

        })
    });
</script>
<!--页脚区域-->
<div id="footer">
    共执行 7 个查询，用时 0.028849 秒，Gzip 已禁用，内存占用 3.219 MB<br />
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>