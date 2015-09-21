Zepto(function($){
	//发布推荐
	$('.admin_list_table .rec_btn').click(function(){
		var $end_time=parseInt($(this).prev().val());
		if(!$end_time){
			alert('先输入要推荐多少天，为一个整数');
			return false;
		}
		$.post('/Uuu/save_recommend', {'id': $(this).data('id'),'end_time':$end_time}, function(data){
			  if(data.status==1){
				  location.reload();
			  }else{
				  alert(data.info);
			  }
		},'json')
	});
	//取消推荐
	$('.admin_list_table .cancel_rec_btn').click(function(){
		$.post('/Uuu/cancel_recommend', {'id': $(this).data('id')}, function(data){
			  if(data.status==1){
				  location.reload();
			  }else{
				  alert(data.info);
			  }
		},'json')
	});
	//删除推荐
	$('.admin_list_table .del_btn').click(function(){
		$.post('/Uuu/delete_recommend', {'id': $(this).data('id')}, function(data){
			  if(data.status==1){
				  location.reload();
			  }else{
				  alert(data.info);
			  }
		},'json')
	});
	
	//保存URL
	$('.admin_list_table .save_url_btn').click(function(){
		var $url=$(this).prev().val();
		if(!$url){
			alert('先输入完整地址！');
			return false;
		}
		$.post('/Uuu/save_pic_ad_url', {'id': $(this).data('id'),'url':$url}, function(data){
			alert(data.info);
		},'json')
	});
    //上传图片广告
    $('.ad_pic_up').change(function(){
		if ($(this).val() == '') {
			return false;
		}else{
			var allow_types='jpg|jpeg|png|bmp|gif';
			var reg=new RegExp('(?:'+allow_types+')$','i');
			if(this.value&&!(reg.test(this.value))){
				alert("请上传"+allow_types+"格式的文件");
			    $(this).val('');
			    return false;
			}
			var $form='form[id="'+$(this).data('id')+'"]';
			$($form).submit();
		}
    });
	//推荐图片
	$('.admin_list_table .pic_rec_btn').click(function(){
		var $end_time=parseInt($(this).prev().val());
		if(!$end_time){
			alert('先输入要推荐多少天，为一个整数');
			return false;
		}
		$.post('/Uuu/save_pic_ad_recommend', {'id': $(this).data('id'),'end_time':$end_time}, function(data){
			  if(data.status==1){
				  location.reload();
			  }else{
				  alert(data.info);
			  }
		},'json')
	});
	//恢复默认
	$('.admin_list_table .use_default').click(function(){
		$.post('/Uuu/set_default_pic_ad', {'id': $(this).data('id')}, function(data){
			  if(data.status==1){
				  location.reload();
			  }else{
				  alert(data.info);
			  }
		},'json')
	});
	
	
	
	
	
})