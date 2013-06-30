<div class="album">
	<script>
		$(function(){
			$(".album table a").click(album_manager_click);
		});
	</script>
	<table>
		<thead>
			<tr><th>ID</th><th>名字</th><th>公开</th><th>状态</th><th>管理</th></tr>
		</thead>
		<tbody>
<?php $i=0; foreach(get_lib("LibAlbum")->album_list() as $v){?>
			<tr class="tr_<?php echo $i++%2?>"><td><?php echo $v['id']?></td><td><?php echo $v['name']?></td><td><?php echo $v['public']?></td><td><a href="#status_<?php echo $v['id']?>_<?php echo $v['status']?>"><?php echo $v['status']?"发布":"草稿"?></a></td><td><a href="#del_<?php echo $v['id']?>">删除</a>&nbsp;<a href="<?php echo get_url("User/edit/".$v['id'])?>">编辑</a></td></tr>
<?php }?>
		</tbody>
	</table>
</div>