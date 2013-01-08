<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>title</title>
		<style type="text/css">
body{padding:0; margin:0;}
.main{padding-left:10px;}
.inpclred{ border: 1px solid red; background-color:#ffeeee; } /* Стиль выделения элемента с ошибкой */
.inpcl{ border: 1px solid #aaaaaa; background-color:#ffffff; }

.fieldtitle {padding-right:5px; text-align:right; width:195px; float:left; margin-top:0; margin-bottom:0;}
input { width:300px; font-family:verdana; /*color:#0099AA;*/ font-size:9pt;}
select { width:304px; font-family:verdana; /*color:#0099AA;*/ font-size:9pt;}
textarea{ width:300px; height:100px; font-family:verdana; /*color:#0099AA;*/ font-size:9pt;}
/*
hr {height:3px; border:0; color:#000000; background-color:#000000;}
*/
.to_print {margin:0; margin-bottom:5px; padding:0px 0px 0px 200px; font:bold 16px arial;}
.to_print li{display:inline; margin-right:10px;}
.to_print li a:link {color: #000099;}
.to_print li a:visited {color: #000099;}
.to_print li a:hover {color: #0097FF;}
a:link {color: #0000CC;}
a:visited {color: #0000CC;}
a:hover {color: #0097FF;}
.bigbutton{margin-top:10px; width:304px; height:50px; font-size:15pt; font-weight:600;}
<?php include(TEXT_MODUL . "/css.top.form.php"); ?>
		</style>
		<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
		<meta http-equiv="cache-control" content="no-cache" />
	</head>
	<body>
	<?php include(TEXT_MODUL . "/top.form.php"); ?>
		<div class="main">
<?
$attForm->showf();
?>
		</div>
	</body>
</html>
