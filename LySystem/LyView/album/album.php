<div id="album">
	<script>
		$(function(){
			$(".album_list_image").colorbox({rel:'画廊', transition:"fade"});
		});
	</script>
	<div class="info">
		<div class="title">
			<h2><?php echo $album['name']?></h2>
		</div>
		<div class="user">
			<p>用户:<a href="<?php echo get_url("user_".$user['id'])?>" title="查看用户信息"><?php echo $user['user']?></a><?php
	if(get_user_id()==$user['id']){
		echo "<a class=\"edit\" href=\"",get_url("user/edit/".$album['id']),"\" title=\"编辑图集\">编辑</a>";
	}
				?></p>
		</div>
	</div>
<?php foreach($list as $v){?>
	<div class="list">
		<div class="image">
			<h4><a href="<?php echo get_url("picture_".$v['id'])?>" title="查看图片详情"><?php echo $v['title']?></a></h4>
			<a class="album_list_image" href="<?php echo get_pic($v['file'])?>"><img src="<?php echo get_pic_big($v['file'])?>" alt="<?php echo $v['title']?>" /></a>
			<p><?php echo $v['description']?></p>
		</div>
		<div class="tag">
			<p>标签:<?php echo get_tags($v['tag'])?></p>
		</div>
	</div>
<?php }?>
</div>