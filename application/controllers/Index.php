<?php

class IndexController extends Yaf_Controller_Abstract {
	
   	public function indexAction() {
   		$get_labels=get_labels(I('get.labels'));
   		$page=I('get.page',0,'intval');
   		if($page<=0){
   			$page=1;
   		}
   		$now=time();
   		
   		if(!empty($get_labels)){
   			$get_labels=explode(',', $get_labels);
   			$labels_where=' AND (';
   			foreach ($get_labels as $k=>$v){
   				$labels_where.=" FIND_IN_SET('$v',`labels`) OR";
   			}
   			$labels_where=trim($labels_where,' OR');
   			$labels_where.=' ) ';
   		}
   		$p_rs=mypdo()->query("SELECT * FROM tz0632.infos WHERE (`end_time` > $now) AND (`recommend` = 1)
   				 				ORDER BY `id` DESC LIMIT 0,5");
   		$p_r_count=count($p_rs);
   		$p_n_limit=35-$p_r_count;
   		if(!empty($page)){
   			$start_row=$p_n_limit*($page-1);
   		}else{
   			$start_row=0;
   		}
   		$p_ns=mypdo()->query("SELECT * FROM tz0632.infos WHERE (`end_time` > $now) AND (`recommend` = 0)$labels_where
   								ORDER BY `id` DESC LIMIT $start_row,$p_n_limit");
   		$labels=mypdo()->query('SELECT * FROM `tz0632`.`labels`');
   		$ad_pic=mypdo()->query("SELECT * FROM tz0632.ad_pic");
   		
   		
   		$this->assign_page_url($page,$p_ns,$get_labels);
   		$this->getView()->assign("ad_pic",$ad_pic);
   		$this->getView()->assign("get_labels",$get_labels);
   		$this->getView()->assign("labels",$labels);
   		$this->getView()->assign("p_rs",$p_rs);
   		$this->getView()->assign("p_ns",$p_ns);
   	}
   	
   	private function assign_page_url($page,$p_ns,$get_labels){
   		if($page<=1){
   			$pre_url='javascript:void(0);';
   		}else{
   			$pre_url='/?labels='.$get_labels.'&page='.($page-1);
   		}
   		if(empty($p_ns)){
   			$next_url='javascript:void(0);';
   		}else{
   			$next_url='/?labels='.$get_labels.'&page='.($page+1);
   		}
   		$this->getView()->assign("pre_url",$pre_url);
   		$this->getView()->assign("next_url",$next_url);
   	}
   	
   	
   	
}