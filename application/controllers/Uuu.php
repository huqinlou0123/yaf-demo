<?php
/**
 * 管理
 * @author huqinlou0123
 */
class UuuController extends Yaf_Controller_Abstract {
	//登录
   	public function indexAction(){
   		if($this->getRequest()->getMethod()=='POST'){
   			if((I('post.useranme')=='admin')&&(I('post.password')=='123456')){
   				$_SESSION['auth']=1;
   				success('登录成功！','/Uuu/recommend');
   			}else{
   				error('帐号或密码错误！','/Uuu');
   			}
   		}else{
	   		if(!empty($_SESSION['auth'])){
	   			success('已登录，跳转至管理页面！','/Uuu/recommend');
	   		}
   		}
   	}
   	
   	//推荐
   	public function recommendAction(){
   		$this->check_auth();
   		$count=mypdo()->query("SELECT COUNT(*) AS count FROM tz0632.infos");
   		$count=$count[0]['count'];
   		
   		$page_now=I('get.p','0','intval');
   		if($page_now>1){
   			$limit_start=($page_now-1)*10;
   		}else{
   			$limit_start=0;
   		}
   		$infos=mypdo()->query("SELECT * FROM tz0632.infos ORDER BY `id` DESC LIMIT $limit_start,10");
   		$page=new Pager;
   		$page->PageCount=ceil($count/10);
   		
   		$page->AbsolutePage=$page_now;
   		$this->getView()->assign("page",$page->ToString());
   		$this->getView()->assign("infos",$infos);   		
   	}
   	//图片推荐
   	public function pictureadAction(){
   		$this->check_auth();
   		$datas=mypdo()->query("SELECT * FROM tz0632.ad_pic");
   		$this->getView()->assign("datas",$datas);
   		
   	}
   	//退出
   	public function loginoutAction(){
   		$this->check_auth();
   		$_SESSION['auth']=null;
   		success('退出成功！','/Uuu');
   	}

   	
   	
   	//推荐发布 -- ajax
   	public function save_recommendAction(){
   		$this->check_auth();
   		if($this->getRequest()->getMethod()=='POST'){
   			$id=I('post.id',0,'intval');
   			$end_time=I('post.end_time',0,'intval');
   			if(empty($id)||empty($end_time)){
   				ajax_error('参数错误！');
   			}
   			$end_time=time()+$end_time*3600*24;
   			$info=mypdo()->query("UPDATE `tz0632`.`infos` SET `end_time`='$end_time' , `recommend`='1' WHERE `id`='$id';");
   			if($info){
   				ajax_sucess('推荐成功！');
   			}else{
   				ajax_error('推荐失败！');
   			}
   		}else{
   			ajax_error('非法操作！');
   		}
   	}
   	//取消推荐 -- ajax
   	public function cancel_recommendAction(){
   		$this->check_auth();
   		if($this->getRequest()->getMethod()=='POST'){
   			$id=I('post.id',0,'intval');
   			if(empty($id)){
   				ajax_error('参数错误！');
   			}
   			$info=mypdo()->query("UPDATE `tz0632`.`infos` SET `recommend`='0' WHERE `id`='$id';");
   			if($info){
   				ajax_sucess('取消成功！');
   			}else{
   				ajax_error('取消失败！');
   			}
   		}else{
   			ajax_error('非法操作！');
   		}
   	}
   	//删除发布 -- ajax   	
   	public function delete_recommendAction(){
   		$this->check_auth();
   	   	if($this->getRequest()->getMethod()=='POST'){
   			$id=I('post.id',0,'intval');
   			if(empty($id)){
   				ajax_error('参数错误！');
   			}
   			$info=mypdo()->query("DELETE FROM `tz0632`.`infos` WHERE `id`='$id';");
   			if($info){
   				ajax_sucess('删除成功！');
   			}else{
   				ajax_error('删除失败！');
   			}
   		}else{
   			ajax_error('非法操作！');
   		}
   	}
   	//保存广告图片地址要
   	public function save_pic_ad_urlAction(){
   		if($this->getRequest()->getMethod()=='POST'){
   			$id=I('post.id',0,'intval');
   			$url=I('post.url');
   			if(empty($id)||empty($url)){
   				ajax_error('参数错误！');
   			}
   			$info=mypdo()->query("UPDATE `tz0632`.`ad_pic` SET `url`='$url' WHERE `id`='$id';");
   			if($info){
   				ajax_sucess('保存成功！');
   			}else{
   				ajax_error('保存失败！');
   			}
   		}else{
   			ajax_error('非法操作！');
   		}
   	}
   	
   	//上传图片
   	public function save_pic_adAction(){
   		$this->check_auth();
   		if($this->getRequest()->getMethod()=='POST'){
   			$id=I('post.id','0','intval');
   			empty($id)&&error('参数错误！');
   			$result=upload('ad');
   			if(!$result['status']){
   				error($result['status']);
   			}
   			$path=$this->thumb($result['info']);
   			$info=mypdo()->query("UPDATE `tz0632`.`ad_pic` SET `path`='$path' WHERE `id`='$id';");
   			if(!$info){
   				error('保存失败！');
   			}
   			success('上传成功');
   		}
   	}
   	
   	//保存推荐图片 -- ajax
   	public function save_pic_ad_recommendAction(){
   		$this->check_auth();
   		if($this->getRequest()->getMethod()=='POST'){
   			$id=I('post.id',0,'intval');
   			$end_time=I('post.end_time',0,'intval');
   			if(empty($id)||empty($end_time)){
   				ajax_error('参数错误！');
   			}
   			$end_time=time()+$end_time*3600*24;
   			$info=mypdo()->query("UPDATE `tz0632`.`ad_pic` SET `end_time`='$end_time' WHERE `id`='$id';");
   			if($info){
   				ajax_sucess('推荐成功！');
   			}else{
   				ajax_error('推荐失败！');
   			}
   		}else{
   			ajax_error('非法操作！');
   		}
   	}
   	//恢复默认
   	public function set_default_pic_adAction(){
   		$this->check_auth();
   		if($this->getRequest()->getMethod()=='POST'){
   			$id=I('post.id',0,'intval');
   			if(empty($id)){
   				ajax_error('参数错误！');
   			}
   			$info=mypdo()->query("UPDATE `tz0632`.`ad_pic` SET `path`=NULL ,`end_time`=NULL WHERE `id`='$id';");
   			if($info){
   				ajax_sucess('取消成功！');
   			}else{
   				ajax_error('取消失败！');
   			}
   		}else{
   			ajax_error('非法操作！');
   		}
   	}
   	
   	//检查权限
   	private function check_auth(){
   		if(empty($_SESSION['auth'])){
   			error('没有登录！','/Uuu');
   		}
   	}
   	
   	//缩略图
   	private function thumb($path){
   		$new_path=APP_PATH.'/public'.$path;
   		$img=new Image();
   		$result=$img->thumb($new_path,$new_path,300,90);
   		if($result){
   			return $path;
   		}else{
   			error('缩略失败！');
   		}
   	}
   
   
}
?>