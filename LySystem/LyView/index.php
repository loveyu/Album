<div id="home">
	<script>
		$(function(){
			$(".home_list").colorbox({rel:'画廊', transition:"fade"});
		});
	</script>
	<ul class="list clearfix">
<?php foreach($list as $v){?>
		<li><a class="home_list" href="<?=get_pic_big($v['file'])?>" title="<?=$v['title']?>"><img src="<?=get_pic_middle($v['file'])?>" alt="<?=$v['title']?>" /></a></li>
<?php }?>
	</ul>
</div>