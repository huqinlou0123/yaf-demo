<?php
/**
 * 发布
 * @author huqinlou0123
 * @version 2015-2-28
 */
class PublishController extends Yaf_Controller_Abstract {
	
	//生成验证码
   	public function indexAction() {
   		$labels=mypdo()->query('SELECT * FROM `tz0632`.`labels`');
   		$this->getView()->assign("labels",$labels);
   	}
   
   	//生成验证码
   	public function verifyAction(){
		$img=new Image;
		$img->buildImageVerify(50,25);
   	}
	
   	//保存
   	public function saveAction(){   		
	   	if($this->getRequest()->getMethod()!='POST'){
	   		error('非法操作！');
	   	}
   		if(empty(I('post.verify_code'))||($_SESSION['verify']!=I('post.verify_code'))){
   			error('验证码填写不正确！');
   		}
   		$_SESSION['verify']=null;//防止用一个验证码反复提交
   		
   		$content=trim(I('post.content'));
   		if(empty($content)){
   			error('内容不能为空！');
   		}
   		if(mb_strlen($content,'utf8')>80){
   			error('内容需在80个字符内！');
   		}
   		$labels=get_labels(I('post.labels'));
   		if( !empty($_FILES['pic']['name']) ) {
   			$result=upload('publish');
   			if($result['status']){
   				$path=$result['info'];
   			}else{
   				error($result['info']);
   			}
   		}
   		$end_time=get_end_time(I('post.end_time','2d'));
   		$create_time=time();
   		$result=mypdo()->query("INSERT INTO `tz0632`.`infos` (`content`, `pic`, `labels`, `create_time`, `end_time`) 
   				VALUES ('$content', '$path', '$labels', '$create_time', '$end_time');");   		
   		if($result){
   			success('','/');
   		}else{
   			error('未知错误，请联系网站管理员！');
   		}
   	}
   
   
}
?>