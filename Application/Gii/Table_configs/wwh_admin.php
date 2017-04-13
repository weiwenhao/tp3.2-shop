<?php
return array(
	'tableName' => 'wwh_admin',    // 表名
	'tableCnName' => '管理员',  // 表的中文名
	'moduleName' => 'Admin',  // 代码生成到的模块
	'withPrivilege' => FALSE,  // 是否生成相应权限的数据
	'topPriName' => '',        // 顶级权限的名称
	'digui' => 0,             // 是否无限级（递归）
	'diguiName' => '',        // 递归时用来显示的字段的名字，如cat_name（分类名称）
	'pk' => 'admin_id',    // 表中主键字段名称
	/********************* 要生成的模型文件中的代码 ******************************/
	// 添加时允许接收的表单中的字段
	'insertFields' => "array('admin_name','password')",
	// 修改时允许接收的表单中的字段
	'updateFields' => "array('admin_id','admin_name','password')",
	'validate' => "
		array('admin_name', 'require', '管理员名称不能为空！', 1, 'regex', 3),
		array('admin_name', '1,30', '管理员名称的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('password', 'require', '密码不能为空！', 1, 'regex', 3),
		array('password', '1,12', '密码的值最长不能超过 12 个字符！', 1, 'length', 3),
	",
	/********************** 表中每个字段信息的配置 ****************************/
	'fields' => array(
		'admin_name' => array(
			'text' => '管理员名称',
			'type' => 'text',
			'default' => '',
		),
		'password' => array(
			'text' => '密码',
			'type' => 'password',
			'default' => '',
		),
	),
	/**************** 搜索字段的配置 **********************/
	'search' => array(
		array('admin_name', 'normal', '', 'like', '管理员名称'),
	),
);