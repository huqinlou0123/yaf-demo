Zepto(function($){

	var verifyimg = $(".verifyimg").attr("src");
	$(".verifyimg").click(function() {
		$(".verifyimg").attr("src",verifyimg + '/random=' + Math.random());
	});
	
	$('textarea[name=content]').on('keyup',function(e){
		var $obj=$(this);
		var curLength=$obj.val().length;
		if(curLength>80){ 
			var num=$obj.val().substr(0,80);
			$obj.val(num);
		}else{
			var left_lenght=80-$obj.val().length;
			$(".content_words_tips").text('内容还可输入'+left_lenght+'字');
		}
	});
	
	
	$('.labels p').click(function(){
		$(this).toggleClass('publishLabelSelect');
		var $labels='';
		$(".labels p").each(function(index){
			if($(this).hasClass("publishLabelSelect")){
				$labels+=$(this).data('id')+',';
			}
		});
		$('input[name="labels"]').val($labels);
	});
	$('.filters li').click(function(){
		$(this).toggleClass('f_d_select');
		var $labels='';
		$(".filters li").each(function(index){
			if($(this).hasClass("f_d_select")){
				$labels+=$(this).data('id')+',';
			}
		});
		location.href="/?labels="+$labels.replace(/(^\,)|(\,$)/g, "");
	});
	
	
})