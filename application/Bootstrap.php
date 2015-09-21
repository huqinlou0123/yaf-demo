<?php
/**
 * 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */
class Bootstrap extends Yaf_Bootstrap_Abstract{
	public function _initConst() {
		define("VIEW_PATH",APP_PATH.'/application/views');
	}	
	public function _initFunction() {
		require_once APP_PATH.'/application/common/function.php';
	}
	public function _initSession(){
		session_start();
	}
}