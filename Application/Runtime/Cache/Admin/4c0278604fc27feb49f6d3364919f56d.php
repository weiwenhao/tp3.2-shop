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
    <form name="main_form" method="POST" action="/Admin/Authority/edit/auth_id/3.html" enctype="multipart/form-data" >
    	<input type="hidden" name="auth_id" value="<?php echo $data['auth_id']; ?>" />
        <table cellspacing="1" cellpadding="3" width="100%">
			<tr>
				<td class="label">上级权限：</td>
				<td>
					<select name="parent_id">
						<option value="0">顶级权限</option>
						<?php foreach ($parentData as $k => $v): ?> 
						<?php if($v['auth_id'] == $data['auth_id'] || in_array($v['auth_id'], $children)) continue ; ?> 
						<option <?php if($v['auth_id'] == $data['parent_id']): ?>selected="selected"<?php endif; ?> value="<?php echo $v['auth_id']; ?>"><?php echo str_repeat('--------/', $v['level']).$v['auth_name']; ?></option>
						<?php endforeach; ?>					</select>
				</td>
			</tr>
            <tr>
                <td class="label">权限名称 ：</td>
                <td>
                    <input  type="text" name="auth_name" value="<?php echo $data['auth_name']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">模块：</td>
                <td>
                    <input  type="text" name="module" value="<?php echo $data['module']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">控制器：</td>
                <td>
                    <input  type="text" name="controller" value="<?php echo $data['controller']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">操作方法：</td>
                <td>
                    <input  type="text" name="action" value="<?php echo $data['action']; ?>" />
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