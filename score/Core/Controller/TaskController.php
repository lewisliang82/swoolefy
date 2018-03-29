<?php
namespace Swoolefy\Core\Controller;

use Swoolefy\Core\Swfy;
use Swoolefy\Core\Object;
use Swoolefy\Core\MTime;
use Swoolefy\Core\Application;

class TaskController extends Object {
	/**
	 * $from_worker_id 记录当前任务由那个woker投递
	 * @see https://wiki.swoole.com/wiki/page/134.html
	 * @var null
	 */
	public $from_worker_id = null;

	/**
	 * $task_id 任务的ID
	 * @see  https://wiki.swoole.com/wiki/page/134.html
	 * @var null
	 */
	public $task_id = null;
	
	/**
	 * $config 应用层配置
	 * @var null
	 */
	public $config = null;

	/**
	 * $selfModel 控制器对应的自身model
	 * @var array
	 */
	public static $selfModel = [];

	/**
	 * __construct 初始化函数
	 */
	public function __construct() {

		Application::$app = $this;
		
		// 应用层配置
		$this->config = Swfy::$appConfig;
	}

	/**
	 * beforeAction 在处理实际action之前执行
	 * @return   mixed
	 */
	public function _beforeAction() {
		return true;
	}

	/**
	 * afterAction 在返回数据之前执行
	 * @return   mixed
	 */
	public function _afterAction() {
		return true;
	}

	/**
	 * __destruct 返回数据之前执行,重新初始化一些静态变量
	 */
	public function __destruct() {
		if(method_exists($this,'_afterAction')) {
			static::_afterAction();
		}
		// 初始化清除所有得单例model实例
		static::$selfModel = [];
		// 初始化静态变量
		MTime::clear();
		// 清空某些组件,每次请求重新创建
		self::clearComponent(self::$_destroy_components);

	}

	use \Swoolefy\Core\ComponentTrait,\Swoolefy\Core\ServiceTrait;
	
}