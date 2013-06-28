<div class="my_rand">
	<script>
		$(function(){
			$(".home_list").colorbox({rel:'画廊', transition:"fade"});
		});
	</script>
	<h2>我的随机图片秀</h2>
	<ul class="list clearfix">
		<?php foreach($list as $v){?>
		<li><a class="home_list" href="<?=get_pic_big($v['file'])?>" title="<?=$v['title']?>"><img src="<?=get_pic_small($v['file'])?>" alt="<?=$v['title']?>" /></a></li>
		<?php }?>
</div>
