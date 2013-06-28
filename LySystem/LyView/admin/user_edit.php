<?php
$user=get_user_info(get_core("LyGet")->get('id'));
if($user == false){
	echo "<h3 class='error'>信息获取出错</h3>";
}else{
?>
<form id="user_edit_form" action="<?=get_url("Admin/ajax/user_edit")?>" method="post">
	<p>用户ID:<span><?=$user['id']?></span></p>
	<p>用户名:<input name="user" value="<?=$user['user']?>" type="text" /></p>
	<p>邮箱:<input name="email" value="<?=$user['email']?>" type="text" /></p>
	<p>签名:<input name="signa" value="<?=$user['signa']?>" type="text" /></p>
	<p>主页:<input name="site" value="<?=$user['site']?>" type="text" /></p>
	<p><label>审核状态:<select name="active">
		<option value="false"<?=($user['active'])?"":" selected=\"selected\""?>>待审核</option>
		<option value="true"<?=($user['active'])?" selected=\"selected\"":""?>>已审核</option>
	</select></label></p>
	<p><label>权限:<select name="power">
		<option value="user"<?=($user['power']=="user")?" selected=\"selected\"":""?>>用户</option>
		<option value="admin"<?=($user['power']=="admin")?" selected=\"selected\"":""?>>管理员</option>
	</select></label></p>
	<input type="hidden" name="id" value="<?=$user['id']?>" />
	<button type="submit">更新信息</button>
</form>
<?php }?>