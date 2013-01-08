<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Cache-Control" content="no-cache" />
	<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
	<title><?=$tp->name_out(0) ?></title>
	<style type="text/css">
body{padding:0; margin:0;}
.main{padding-left:20px; padding-bottom:10px; padding-right:20px;}
p {
	font-family:verdana;
	color: #000000;
	font-size: 12px;
	text-align: justify;
	text-align-last: left;
	text-indent: 25pt;
	margin-top: 8pt;
	margin-bottom: 0pt;
}
h1 {
	font-family:verdana;
	font-weight:600;
	text-indent: 25pt;
	margin-bottom:12px;
}
<?php include(TEXT_MODUL . "/css.top.form.php"); ?>
	</style>
</head>
<body>
		<?php include(TEXT_MODUL . "/top.form.php"); ?>
	<div class="main">
		<h1><?=$tp->name_out(0) ?></h1>
<?php
if($tp->attach_out(0))
{
?>
		<p><?=$tp->attach_out(0) ?></p>
<?php
}
?>
		<p><?=$tp->body_out(0) ?></p>
	</div>
</body>
</html>
