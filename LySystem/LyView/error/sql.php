<html>
<head>
	<meta http-equiv="content-type" charset="utf-8" />
	<title>数据库连接异常</title>
</head>
<body>
	<h1 style="color: red;">数据库连接异常，请检查数据库连接</h1>
<?php
	if(isset($_GET['code'])){
		echo "<p>错误代码:<strong>",$_GET['code'],"</strong></p>";
	}
?>
</body>
</html>