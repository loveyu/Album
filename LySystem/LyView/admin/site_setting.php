<div id="tabs_site_setting">
	<form action="<?=get_url("Admin/ajax/setting_post")?>" method="post">
		<p><label>网站标题:<input type="text" name="site_name" value="<?=get_site_name()?>" /></label></p>
		<p><label>网站描述:<input type="text" name="site_description" value="<?=get_site_description()?>" /></label></p>
		<p>是否允许注册:<select name="allow_register">
			<option value="true"<?=(get_lib("LibSetting")->get("allow_register")=="true")?' selected="selected"':""?>>允许</option>
			<option value="false"<?=(get_lib("LibSetting")->get("allow_register")=="false")?' selected="selected"':""?>>禁止</option>
		</select></p>
		<p><button type="submit">更新设置</button></p>
	</form>
</div>