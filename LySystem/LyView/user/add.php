<div id="user_add" title="创建一个新的画集">
	<script>
		$(function () {
			$("#user_add form").ajaxForm(function(data){
				if(data['status']){
					window.location.href = URL+"User/edit/"+data['message'];
				}else{
					alert(data['message']);
				}
			});
		});
	</script>
	<form action="<?php echo get_url("User/add_ajax")?>" method="post">
		<p><label>画集标题：<input name="title" value="" type="text"></label></p>
		<p><label>是否公开：<select name="public">
			<option value="yes">公开</option>
			<option value="no">私有</option>
		</select></label></p>
		<p>
			<button type="submit">创建</button>
		</p>
	</form>
</div>