<?php
return array(
	'tableName' => 'wwh_category',    // 表名
	'tableCnName' => '商品分类',  // 表的中文名
	'moduleName' => 'Admin',  // 代码生成到的模块
	'withPrivilege' => FALSE,  // 是否生成相应权限的数据
	'topPriName' => '',        // 顶级权限的名称
	'digui' => 0,             // 是否无限级（递归）
	'diguiName' => '',        // 递归时用来显示的字段的名字，如cat_name（分类名称）
	'pk' => 'cat_id',    // 表中主键字段名称
	/********************* 要生成的模型文件中的代码 ******************************/
	// 添加时允许接收的表单中的字段
	'insertFields' => "array('cat_name','pid')",
	// 修改时允许接收的表单中的字段
	'updateFields' => "array('cat_id','cat_name','pid')",
	'validate' => "
		array('cat_name', 'require', '分类名称不能为空！', 1, 'regex', 3),
		array('cat_name', '1,30', '分类名称的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('pid', 'require', '父级id不能为空！', 1, 'regex', 3),
		array('pid', 'number', '父级id必须是一个整数！', 1, 'regex', 3),
	",
	/********************** 表中每个字段信息的配置 ****************************/
	'fields' => array(
		'cat_name' => array(
			'text' => '分类名称',
			'type' => 'text',
			'default' => '',
		),
		'pid' => array(
			'text' => '父级id',
			'type' => 'text',
			'default' => '',
		),
	),
	/**************** 搜索字段的配置 **********************/
	'search' => array(
		array('cat_name', 'normal', '', 'like', '分类名称'),
		array('pid', 'normal', '', 'eq', '父级id'),
	),
);