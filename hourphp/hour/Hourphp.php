<?php
/** 
 *hourphp框架核心
 */
class Hourphp{
	protected $_config = [];
	
	public function __construct($config)
	{
		$this->_config = $config;
	}
	
	//运行程序
	public function run()
	{
		spl_autoload_register(array($this,'autoLoad'));
	}
	
	public static function autoLoad($class)
	{
		$frameworks = str_replace('\\','/',__DIR__) . '/' . $class . '.php';
		$controllers = APP_PATH . '/application/controllers/' . $class . '.php';
		$models = APP_PATH . 'application/models/' . $class . '.php';
		
		if(file_exists($frameworks)){
			//加载核心框架
			require $frameworks;
		}elseif(file_exists($controllers)){
			//加载应用控制器类
			require $controllers;
		}elseif(file_exists($models)){
			//加载应用模型类
			require $models;
		}else{
			//错误代码
		}
	}
}