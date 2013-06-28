<script>
	var ALBUM_ID = <?=$id?>;
	var PICTURE_URL = URL+"<?=str_replace("//","/",get_config("picture","path")."/")?>";
	$(function () {
		load_album_page(ALBUM_ID);
		$("#album_title_form").ajaxForm(album_ajax_update);
		$("#album_add_form").submit(album_add_picture);
	});
</script>
<div id="album_edit">
	<form id="album_title_form" class="clearfix" action="<?=get_url("User/album_edit")?>" method="post">
		<div><label>标题：<input name="name" type="text" value="" /></label></div>
		<div><label>公开状态: <select name="public"><option value="yes">公开</option><option value="no">私有</option></select></label></div>
		<div><label>发布状态: <select name="show"><option value="1">发布</option><option value="0">草稿</option></select></label></div>
		<div><button type="submit">更新状态</button></div>
		<input type="hidden" value="<?=$id?>" name="id" />
	</form>
	<div class="picture">

	</div>
	<div class="new">
		<form id="album_add_form" action="<?=get_url("User/picture_add")?>" class="clearfix" method="post" enctype="MULTIPART/FORM-DATA">
			<div class="img">
				<label>上传图片:<input name="file" type="file"></label>
			</div>
			<div class="form">
				<p><label>标题:<input name="title" value="" type="text" /></label></p>
				<p><label>标签:<input name="tags" value="" type="text" /></label></p>
				<div>
					<p>描述：</p>
					<textarea name="description" rows="5" cols="30"></textarea>
				</div>
				<p><button type="submit">添加</button></p>
				<input type="hidden" name="album" value="<?=$id?>" />
			</div>
		</form>
	</div>
</div>
