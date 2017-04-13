<?php
return array(
	//'配置项'=>'配置值'
    //页面静态化
    'HTML_CACHE_ON'     =>     false, // 开启静态缓存
    'HTML_FILE_SUFFIX'  =>     '.shtml', // 设置静态缓存文件后缀
    'HTML_CACHE_RULES'  =>     array( // 定义静态缓存规则
        'index:index'   =>     array('index', '86400'),
        'index:goods'   =>     array('goods{goods_id}',60*30)
    )
);