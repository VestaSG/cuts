<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	
		<title>Ошибка <?=$err ?></title>

		<style type="text/css">
body{margin:0; padding:0;}
.errtxt{color:#aa0000; margin-left:200px;}

<?php
include("css.top.useradmin.form.php");
?>

a:link {color: #0000CC;}
a:visited {color: #0000CC;}
a:hover {color: #0097FF;}
		</style>

		<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
		<meta http-equiv="cache-control" content="no-cache" />
	</head>
	<body>
<?php
include("top.useradmin.form.php");
?>
		<p class="errtxt"><?=$not ?>. <a href="./useradmin.inc.php">Вернитесь к началу</a></p>
	</body>
</html>
