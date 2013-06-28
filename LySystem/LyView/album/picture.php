<div id="picture">
	<h2><?=$info['title']?></h2>
	<div class="image">
		<img src="<?=get_pic($info['pic_file'])?>" alt="<?=$info['title']?>" />
		<p><?=$info['description']?></p>
	</div>
	<div class="info">
		<p class="user">用户:<a title="查看用户" href="<?=get_url('user_'.$info['user_id'])?>"><?=$info['user_name']?></a></p>
		<p class="tag">标签:<?=get_tags($info['tag'])?></p>
		<p class="album">画册:<a title="所属图集" href="<?=get_url('album_'.$info['album_id'])?>"><?=$info['album_name']?></a></p>
	</div>
</div>