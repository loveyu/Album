<div class="my_rand">
	<script>
		$(function(){
			$(".home_list").colorbox({rel:'画廊', transition:"fade"});
		});
	</script>
	<h2>我的随机图片秀</h2>
	<ul class="list clearfix">
		<?php foreach($list as $v){?>
		<li><a class="home_list" href="<?php echo get_pic_big($v['file'])?>" title="<?php echo $v['title']?>"><img src="<?php echo get_pic_small($v['file'])?>" alt="<?php echo $v['title']?>" /></a></li>
		<?php }?>
</div>
