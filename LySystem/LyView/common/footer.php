
<!--footer begin-->
	</div>
	<div id="footer">
		<p>&copy; CopyRight 2013<?php if(date("Y")>2013)echo " - ",date("Y");?>. <a href="<?php echo get_url()?>" title="<?php echo get_site_name()." - ".get_site_description()?>"><?php echo get_site_name()?></a>.
			页面执行 <?php echo get_core("LyTime")->get_second()?> 秒. 数据库查询 <?php echo get_core()->load_c_lib("CLibSql")->get_query_count()?> 次.
			Power by <a href="http://www.loveyu.org">Loveyu</a> & cwhy.
		</p>
	</div>
</div>
<?php $_LibTemplate->the_foot(); ?>
</body>
</html>