<div id="login">
	<?php if (allow_register()): ?>
	<?php if (($err = get_core("LyGet")->get('error')) !== false) {
		$err = get_core("LySafe")->text($err);
		?>
		<script>
			$(function () {
				alert('<?php echo $err?>');
			});
		</script>
		<?php } ?>
	<h3>用户注册</h3>
	<form action="<?php echo get_url("Login/register_action")?>" method="post">
		<p><label>用户名:<input class="input" name="user" type="text"/></label></p>

		<p><label>密码：<input class="input" name="password" type="password"/></label></p>

		<p><label>确认密码:<input class="input" name="confirm" type="password"/></label></p>

		<p><label>邮箱:<input class="input" type="email" name="email"/></label></p>

		<p class="register">
			<button class="reg_submit" type="submit">注册</button>
		</p>
	</form>
	<?php else: ?>
	<h3 class="error">用户注册被关闭</h3>
	<?php endif;?>
</div>