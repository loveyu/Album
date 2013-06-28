<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="zh-CN">
<head>
	<title><?php $_LibTemplate->the_title()?></title>
<?php $_LibTemplate->the_head("\t")?>
	<script>
		URL = "<?=get_url()?>";
<?php if (is_login()) { ?>
		USER = {id:<?=get_user_id()?>, user:"<?=get_user_name()?>"};
<?php }?>
	</script>
</head>
<body>
<div id="container">
	<div id="header">
		<a class="album" href="<?=get_url("album")?>">图汇</a>
		<a class="home" href="<?=get_url()?>">主页</a>
		<img class="logo" src="<?=get_file_url("css/img/logo.png")?>" alt="logo_cwhy" />
		<div class="message">
			<h1><?=get_site_name()?></h1>
			<p><?=get_site_description()?></p>
		</div>
		<div class="menu">
			<ul>
				<li><a href="<?=get_url("User")?>">用户中心</a></li>
<?php if(!is_login()){?>
				<li><a href="<?=get_url("login")?>">登录</a></li>
				<li><a href="<?=get_url("register")?>">注册</a></li>
<?php }else{?>
<?php if(is_admin()){?>
				<li><a href="<?=get_url("Admin")?>">管理中心</a></li>
<?php }?>
				<li><a href="<?=get_url("logout")?>">登出</a></li>
<?php }?>

			</ul>
		</div>
	</div>
	<div id="body">
	<!--header end-->
