<div id="album">
	<script>
		$(function(){
			$(".album_list_image").colorbox({rel:'画廊', transition:"fade"});
		});
	</script>
	<div class="info">
		<div class="title">
			<h2><?=$album['name']?></h2>
		</div>
		<div class="user">
			<p>用户:<a href="<?=get_url("user_".$user['id'])?>" title="查看用户信息"><?=$user['user']?></a><?php
	if(get_user_id()==$user['id']){
		echo "<a class=\"edit\" href=\"",get_url("user/edit/".$album['id']),"\" title=\"编辑图集\">编辑</a>";
	}
				?></p>
		</div>
	</div>
<?php foreach($list as $v){?>
	<div class="list">
		<div class="image">
			<h4><a href="<?=get_url("picture_".$v['id'])?>" title="查看图片详情"><?=$v['title']?></a></h4>
			<a class="album_list_image" href="<?=get_pic($v['file'])?>"><img src="<?=get_pic_big($v['file'])?>" alt="<?=$v['title']?>" /></a>
			<p><?=$v['description']?></p>
		</div>
		<div class="tag">
			<p>标签:<?=get_tags($v['tag'])?></p>
		</div>
	</div>
<?php }?>
</div>