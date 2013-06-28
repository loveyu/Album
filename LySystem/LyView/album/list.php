<div id="album_list">
	<script>
		$(function(){
			$(".album_list_image").colorbox({rel:'画廊', transition:"fade"});
		});
	</script>
<?php foreach($list as $v){?>
	<div class="list">
		<div class="title">
			<h3><a href="<?=get_url("album_".$v['album_id'])?>" title="访问图集"><?=$v['title']?></a></h3>
		</div>
		<div class="user">
			<p>用户:<a href="<?=get_url("user_".$v['user_id'])?>" title="查看用户信息"><?=$v['user_name']?></a></p>
		</div>
		<div class="image">
			<a class="album_list_image" href="<?=get_pic_big($v['pic_file'])?>"><img src="<?=get_pic_big($v['pic_file'])?>" alt="<?=$v['title']?>" /></a>
		</div>
		<div class="tag">
			<p>标签:<?=get_tags($v['tag'])?></p>
		</div>
	</div>
<?php }?>
<?php
	if($count > 1){
		echo "<p class='page_nav'>";
			$_LibTemplate->the_pagination("album_list",get_url("album/page_[]"));
		echo "</p>";
	}
?>
</div>