<div id="picture">
	<h2><?php echo $info['title']?></h2>
	<div class="image">
		<img src="<?php echo get_pic($info['pic_file'])?>" alt="<?php echo $info['title']?>" />
		<p><?php echo $info['description']?></p>
	</div>
	<div class="info">
		<p class="user">用户:<a title="查看用户" href="<?php echo get_url('user_'.$info['user_id'])?>"><?php echo $info['user_name']?></a></p>
		<p class="tag">标签:<?php echo get_tags($info['tag'])?></p>
		<p class="album">画册:<a title="所属图集" href="<?php echo get_url('album_'.$info['album_id'])?>"><?php echo $info['album_name']?></a></p>
	</div>
</div>