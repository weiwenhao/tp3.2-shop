<?php
return array(
	//'配置项'=>'配置值'
    /* 数据库设置 */
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => '127.0.0.1', // 服务器地址
    'DB_NAME'   => 'wwh_shop', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => 'root', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => 'wwh_', // 数据库表前缀
    'DEFAULT_FILTER'  => 'trim,htmlspecialchars', // 默认参数过滤方法 用于I函数...
    'DEFAULT_MODULE' => 'Home',
    'DEFAULT_CONTROLLER'=>  'Index', // 默认控制器名称
    'DEFAULT_ACTION' => 'index',
    'SHOW_PAGE_TRACE' => true,//开启后才会在界面显示debug信息
    'URL_MODEL'             =>  2,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
    'URL_CASE_INSENSITIVE' =>false,	//始终开启u函数生成的url区分大小写

    //图片的配置
    'IMAGE_CONFIG' => array(
        'maxSize'   =>   1024*1024 ,// 设置附件上传大小
        'exts'      =>   array('jpg', 'gif', 'png', 'jpeg'),// 设置附件上传类型
        'rootPath'  =>   './Public/Uploads/', // 设置附件上传根目录
        'viewPath'  =>   '/Public/Uploads/',//浏览器中显示图片的根路径   应该是一个绝对路径,通过ip访问过来的 这里在项目上线后需要更改
    ),

);
