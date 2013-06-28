<?php get_core()->view("admin/header");?>
<div id="admin">
	<ul>
		<li><a href="#tabs_user_manger">用户管理</a></li>
		<li><a href="#tabs_user_add">添加用户</a></li>
		<li><a href="#tabs_site_setting">网站设置</a></li>
	</ul>
<?php
	get_core()->view("admin/user_manger");
	get_core()->view("admin/user_add");
	get_core()->view("admin/site_setting");
?>
</div>
<?php get_core()->view("admin/footer");?>