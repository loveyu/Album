<div id="tabs_user_add">
	<form action="<?php echo get_url("Admin/ajax/user_add")?>" method="post">
		<p><label>用户名:<input name="user" type="text" value="" /></label></p>
		<p><label>密码:<input name="password" type="password" value="" /></label></p>
		<p><label>确认密码:<input name="confirm" type="password" value="" /></label></p>
		<p><label>邮箱:<input name="email" type="text" value="" /></label></p>
		<p><label>审核状态:<select name="active"><option value="false">待审核</option><option value="true">已审核</option></select></label></p>
		<p><label>权限:<select name="power"><option value="user">用户</option><option value="admin">管理员</option></select></label></p>
		<p><button type="submit">添加用户</button></p>
	</form>
</div>