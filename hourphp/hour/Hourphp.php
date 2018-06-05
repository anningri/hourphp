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
		$this->setReporting();
		
	}
	
	//删除敏感字符
	public function stripSlashesDeep($value)
	{
		$value = is_array($value) ? array_map(array(this,'stripSlashesDeep'),$value) : stripSlashes($value);
		return $value;
	}
	
	//检测敏感字符并删除
	public function removeMagicQuotes()
	{
		if(get_magic_quotes_gpc()){
			$_GET = isset($_GET) ? $this->stripSlashesDeep($_GET ) : '';
            $_POST = isset($_POST) ? $this->stripSlashesDeep($_POST ) : '';
            $_COOKIE = isset($_COOKIE) ? $this->stripSlashesDeep($_COOKIE) : '';
            $_SESSION = isset($_SESSION) ? $this->stripSlashesDeep($_SESSION) : '';
		}
	}
	
	/**检测自定义全局变量并移除。因为 register_globals 已经弃用，如果
     * 已经弃用的 register_globals 指令被设置为 on，那么局部变量也将
     * 在脚本的全局作用域中可用。 例如， $_POST['foo'] 也将以 $foo 的
     * 形式存在，这样写是不好的实现，会影响代码中的其他变量。 相关信息，
     * 参考: http://php.net/manual/zh/faq.using.php#faq.register-globals
	*/
	public function unregisterGlobals()
	{
		if(ini_get('register_globals')){
			$array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
			foreach($array as $value){
				if($_GLOBALS[$value]){
					unset($_GLOBALS[$value]);
				}
			}
		}
	}
	
	//检测开发环境
	public function setReporting()
	{
		if(APP_DEBUG === true){
			error_reporting(E_ALL);
			ini_set('display_errors','on');
		}else{
			error_reporting(E_ALL);
			ini_set('display_errors','on');
			ini_set('log_errors','on');
		}
		
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