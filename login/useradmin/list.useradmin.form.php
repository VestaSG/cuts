<?php
// Список пользователей
// Ссылки ведут на список разделов, если раздел не определен
// Ссылки ведут на список прав, если раздел уже определен
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<title><?//= ?></title>

<style type="text/css">
body{margin:0; padding:0;}
.inpcl{ /* border: 1px solid #aaaaaa; background-color:#ffffff; */ width:400px; margin:0;}
.fieldtitle {padding-right:5px; text-align:right; border-width:0; width:195px; float:left; margin:0;}

<?php
include("css.top.useradmin.form.php");
?>

ul{margin-left:200px; padding-left:10pt;}
li{padding-bottom:3pt;}

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

if($inctype == 2)
{
include("user.useradmin.form.php");
echo("<hr />");
}
?>

<ul>
<?php
for($i = 0; $i < $lim; ++$i)
{
?>
<li><a href="<?=$listarray[$i]["href"] ?>"><?=$listarray[$i]["name"] ?></a></li>
<?php
}
?>
</ul>
</body>
</html>
