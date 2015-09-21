<?php
//上传
function upload($path='publish'){
	$webpath='/uploads/'.$path.'/'.date('Y',time()).'/'.date('m',time()).'/';
	$path=APP_PATH.'/public'.$webpath;
	$upload=new Upload($path);
	$data=array();
	if($upload->upload()){
		$fileinfo=$upload->getUploadFileInfo();
		$path=$webpath.$fileinfo[0]['savename'];
		$data['status']=1;
		$data['info']=$path;
	}else{//上传失败
		$data['status']=0;
		$data['info']=$upload->getErrorMsg();
	}
	return $data;
}
//ajax成功返回
function ajax_sucess($info,$data=null){
	$array['status']=1;
	$array['info']=$info;
	if($data){
		$array['data']=$data;
	}
	echo json_encode($array);
	exit;
}
//ajax失败返回
function ajax_error($info,$data=null){
	$array['status']=0;
	$array['info']=$info;
	if($data){
		$array['data']=$data;
	}
	echo json_encode($array);
	exit;
}
//调试打印
function p($var){
	header("Content-type: text/html; charset=utf-8");
	echo '<pre>';
	print_r($var);
	echo '</pre>';
}
//截取字符串
function tz_substr($str,$length){
	if(mb_strlen($str,'utf-8')<$length){
		return $str;
	}else{
		return mb_substr($str,0,$length,'utf-8')."..";
	}
}
//计算结束时间
function get_end_time($end_time){
	switch ($end_time){
		case '2d' :
			return time()+3600*24*2;
			break;
		case '2w' :
			return time()+3600*24*7*2;
			break;
		case '2m' :
			return time()+3600*24*30*2;
			break;
		case '1y' :
			return time()+3600*24*365;
			break;
		default:
			return time()+3600*24*2;
			return ;
	}
}
//获取PDO对象
function mypdo(){
	$config  = new Yaf_Config_ini(APP_PATH . '/conf/application.ini','product');
	$config = $config->toArray();
	$config=$config['database'];
	$mypdo = new MyPDO($config['host'], $config['databaseName'], $config['username'], $config['password']);
	return $mypdo;
}
//拆分并组装以，号的标签
function get_labels($labels){
	$labels=explode(',',$labels);
	$labels_new='';
	foreach ($labels as $k => $v){
		if(!empty(intval($v))){
			$labels_new[]=intval($v);
		}
	}
	if(!empty($labels_new)){
		$labels_new=implode(',',$labels_new);
	}
	if(mb_strlen($labels_new,'utf8')>255){
		error('标签选择过多！');
	}
	return $labels_new;
}
//显示成功并跳转
function success($info="成功！",$url=null,$time=3){
	$view=new Yaf_View_Simple(VIEW_PATH);
	$url=$url?:I('server.HTTP_REFERER');
	$view->display("./success.phtml", array("info" =>$info,"url"=>$url,"time"=>$time));
	exit;
}
//显示错误并跳转
function error($info="错误！",$url=null,$time=3){
	$view=new Yaf_View_Simple(VIEW_PATH);
	$url=$url?:I('server.HTTP_REFERER');
	$view->display("./error.phtml", array("info" =>$info,"url"=>$url,"time"=>$time));
	exit;
}
/**
 * 获取输入参数 支持过滤和默认值
 * 使用方法:
 * I('id',0); 获取id参数 自动判断get或者post
 * I('post.name','','htmlspecialchars'); 获取$_POST['name']
 * I('get.'); 获取$_GET
 */
function I($name,$default='',$filter='htmlspecialchars') {
	static $_PUT	=	null;
	if(strpos($name,'.')) { // 指定参数来源
		list($method,$name) =   explode('.',$name,2);
	}
	switch(strtolower($method)) {
		case 'get'     :
			$input =& $_GET;
			break;
		case 'post'    :
			$input =& $_POST;
			break;
		case 'put'     :
			if(is_null($_PUT)){
				parse_str(file_get_contents('php://input'), $_PUT);
			}
			$input 	=	$_PUT;
			break;
		case 'request' :
			$input =& $_REQUEST;
			break;
		case 'session' :
			$input =& $_SESSION;
			break;
		case 'cookie'  :
			$input =& $_COOKIE;
			break;
		case 'server'  :
			$input =& $_SERVER;
			break;
		case 'globals' :
			$input =& $GLOBALS;
			break;
		default:
			return null;
	}
	if(''==$name) { // 获取全部变量
		$data       =   $input;
		$filters    =   isset($filter)?$filter:false;
		if($filters) {
			if(is_string($filters)){
				$filters    =   explode(',',$filters);
			}
			foreach($filters as $filter){
				$data   =   array_map_recursive($filter,$data); // 参数过滤
			}
		}
	}elseif(isset($input[$name])) { // 取值操作
		$data       =   $input[$name];
		$filters    =   isset($filter)?$filter:false;
		if($filters) {
			$filters    =   explode(',',$filters);
			if(is_array($filters)){
				foreach($filters as $filter){
					if(function_exists($filter)) {
						$data   =   is_array($data) ? array_map_recursive($filter,$data) : $filter($data); // 参数过滤
					}else{
						$data   =   filter_var($data,is_int($filter) ? $filter : filter_id($filter));
						if(false === $data) {
							return   isset($default) ? $default : null;
						}
					}
				}
			}
		}
	}else{ // 变量默认值
		$data       =    isset($default)?$default:null;
	}
	str_replace("'", '', $data);
	return $data;
}