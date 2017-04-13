## 基于ThinkPhp3.2 仿京东商城

> 前台地址 `/` 或`/Home/Index/index`
>
> 后台地址 ` /Admin`  未开启注册入口,密码加密方式 md5,超级管理员id为0 ,请手动在数据库中导入一条超级管理员
>



### 预览

**前台demo:**  [shop.weiwenhao.xyz][1]

![](http://i4.buimg.com/567571/ebdea78b0fe51e6b.png)



![](http://omjq5ny0e.bkt.clouddn.com/17-4-13/8927769-file_1492082906785_be9b.png)









### 部署

使用了pathinfo路由并隐藏了入口文件 index.php

- 将php.ini 中的  `cgi.fix_pathinfo=0`更改为`cgi.fix_pathinfo=1`
- nginx需要重写访问规则,并且设置支持pathinfo路由,在高版本的如: nginx1.10已经默认支持

```
#nginx1.10配置如下
server {
	listen 80;
	listen [::]:80;
	#域名配置
	server_name localhost;
	#站点根目录配置
	root /home/www/shop;
	index  index.html index.php;

	location / {
	    #隐藏index.php
		if (!-e $request_filename) {
			rewrite ^/(.*)$ /index.php/$1;
		}
	}
	
	#修改为 .php$为 php
	location ~ \.php {
        include snippets/fastcgi-php.conf;
		fastcgi_pass unix:/var/run/php/php7.1-fpm.sock;
    }

}
```


### 附件

个人对项目的总结和常用配置文件 在 DataAndConfig 目录下


[1]: http://shop.weiwenhao.xyz
[2]: shop.weiwenhao.xyz/Admin