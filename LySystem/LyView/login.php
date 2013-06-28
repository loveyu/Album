<div id="login">
	<?php if (!is_login()): ?>
	<h3>用户登录</h3>
	<form action="<?=get_url("Login/post")?>" method="post">
		<p><label>用户:<input class="input" name="user" type="text" placeholder="用户名或邮箱"/></label></p>

		<p><label>密码:<input class="input" name="password" type="password"/></label></p>

		<p><label><input class="checkbox" type="checkbox" name="remember" value="ok"/><span>记住密码</span></label></p>

		<p class="submit">
			<button type="submit">登录</button>
		</p>
		<?php if (($err = get_core("LyGet")->get('error')) !== false) {
		$err = get_core("LySafe")->text($err);
		?>
		<p class="error">错误提示：<?=$err?></p>
		<?php }?>

		<input type="hidden" name="redirect" value="<?=get_redirect()?>"/>
	</form>
	<?php else: ?>
		<h3 class="notice">你已登录</h3>
	<?php endif;?>
</div>
