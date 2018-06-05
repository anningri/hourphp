<?php
//应用程序目录
define('APP_PATH',str_replace('\\','/',__DIR__) .'/');
//网站域名
define('HTTP_SERVER','http://'.$_SERVER['SERVER_NAME'].'/');


define('APP_BASE',basename(dirname(__FILE__)));
if(APP_BASE == explode('/',$_SERVER['REQUEST_URI'])[1]){
	define('APP_URI',str_replace('/'.APP_BASE,'',$_SERVER['REQUEST_URI']));
}else{
	define('APP_URI',$_SERVER['REQUEST_URI']);
}
// 开启调试模式
define('APP_DEBUG',true);

// 加载框架文件
require APP_PATH . 'hour/Hourphp.php';

// 加载配置文件
$config = require APP_PATH . 'config/config.php';

// 实例化框架类
(new Hourphp($config))->run();
