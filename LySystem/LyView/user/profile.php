<div id="profile">
	<script>
		$(function(){
			$("#profile form.edit").ajaxForm(function(data){
				if(data['status']){
					alert("更新信息成功");
				}else{
					alert("更新失败:"+data['message']);
				}
			});
			$("#profile_password").dialog({
				width:400,
				model:true,
				autoOpen:false
			});
			$("#profile .password_click").click(function(){
				$( "#profile_password" ).dialog( "open" );
			});
			$("#profile_password form").submit(profile_change_password);
		});
	</script>
	<form class="edit" action="<?=get_url("User/profile_edit")?>" method="post">
		<p><label>用户ID:<input type="text" value="<?=get_user_id()?>" disabled="disabled" /></label></p>
		<p><label>用户名:<input name="user" value="<?=get_user_name()?>" type="text" /></label></p>
		<p><label>邮箱:<input name="email" value="<?=get_user_email()?>" type="text" /></label></p>
		<p><label>签名:<input name="signa" value="<?=get_user_signa()?>" type="text" /></label></p>
		<p><label>主页:<input name="site" value="<?=get_user_site()?>" type="text" /></label></p>
		<p><button type="submit">更新资料</button></p>
	</form>
	<p><button class="password_click">修改密码</button></p>
	<div id="profile_password" title="修改密码">
		<form action="<?=get_url("User/profile_password")?>" method="post">
			<p><label>原始密码:<input name="password" type="password" /></label></p>
			<p><label>新的密码:<input name="new_password" type="password" /></label></p>
			<p><label>确认密码:<input name="confirm_password" type="password" /></label></p>
			<p><button type="submit">修改密码</button></p>
		</form>
	</div>
</div>