<?php
//数组中不要使用下划线等字符，以免出错
$config = array(
	//你的之定义设置
	'picture' => array(
		'max_size' => 1048576,	//最大文件
		'path'=>'pic',	//文件路径
		'big'=>800,	//大图片宽度
		'middle'=>400,	//中等宽度
		'small'=>200//小图宽度
	),
	'album'=>array(
		'one_page' => 2//每页显示数量
	),

	//下面为禁止修改的系统设置
	//系统保留设置
	'system' => array(
		'404_page' => array('Error','e404'), //404页面，留空默认系统
		'cookie_prefix' => '', //COOKIE前缀,留空为空
		'cookie_domain' => '', //COOKIE域名,留空为默认包含全部子域
		'cookie_hash' => 'Test^&#@#*)(', //COOKIE加密字符串，留空不加密
		"router" => array( //路由选择器
			//支持正则表达式,使用preg_match_all();匹配，对仅有一次的匹配结果的进行替换，对应的值为数组的序号，用[0]表示完全匹配的结果
			//"/Topic-([0-9]+)-([0-9]+)\.html/"	=> "Topic/main/[1]/[2]",测试实例
			"/register/" => "Login/register",
			"/logout/" => "Login/logout",
			"/album/" => "Album",
			"/album_([0-9]+)/" => "Album/album_id/[1]",
			"/album\/page_([0-9]+)/" => "Album/main/[1]",
			"/picture_([0-9]+)/" => "Album/picture/[1]",
			"/user_([0-9]+)/" => "Album/user/[1]",
		)
	),
	//数据库设置  数据库使用 PDO进行连接，未安装该拓展请自行开启
	'sql' => array(
		'database_type' => 'mysql', //服务器类型 支持 mysql sqlite pgsql mssql sybase
		'server' => 'localhost', //服务器地址
		'username' => 'root', //用户名
		'password' => '123456', //密码
		'database_file' => '', //数据库文件,	SqLite 专有文件
		'charset' => 'utf8', //编码
		'database_name' => 'core', //数据库名
		'option' => array( //PDO选项
			PDO::ATTR_CASE => PDO::CASE_NATURAL
		),
	),
);
?>