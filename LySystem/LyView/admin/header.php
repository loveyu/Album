<html>
<head>
	<title><?php get_template()->the_title(); ?></title>
<?php get_template()->the_head("\t");?>
	<script>
		URL = "<?=get_url()?>";
		USER = {id:<?=get_user_id()?>,user:"<?=get_user_name()?>"};
		$(function() {
			var tabs = $( "#admin" ).tabs();
			tabs.find( ".ui-tabs-nav" ).sortable({
				axis: "x",
				stop: function() {
					tabs.tabs( "refresh" );
				}
			});
			user_manger_load();
			$("#tabs_user_add form").ajaxForm(user_add);
			$("#tabs_site_setting form").ajaxForm(setting_post);
		});
	</script>
</head>
<body>
<div id="container">
	<div id="header" class="clearfix">
		<h1>后台管理中心</h1>
		<div class="user" class="clearfix">
			<p>欢迎:<strong><?=get_user_name()?></strong></p>
			<ul>
				<li><a href="<?=get_url()?>">网站首页</a></li>
				<li><a href="<?=get_url('User')?>">用户中心</a></li>
			</ul>
		</div>
	</div>