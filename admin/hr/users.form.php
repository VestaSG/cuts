<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>title</title>
		<style type="text/css">
body{padding:0; margin:0; background-color:<?=$body_ground ?>;}
.inpcl{ border: 1px solid #aaaaaa; background-color:#ffffff; }
.fieldtitle {padding-right:5px; text-align:right; width:195px; float:left; margin-top:0; margin-bottom:0;}
.errtxt{color:#aa0000; margin-left:200px;}
<?php
include( ADMIN_MODUL . "/admincss.index.form.php");

if($_GET["err"])
{
	include( ADMIN_MODUL . "/csserr.form.php");
}
?>

ul{margin-left:200px; padding-left:0;}
li{padding-bottom:3pt;}

li.hidli a:link {color: #aaaaaa;}
li.hidli a:visited {color: #aaaaaa;}
li.hidli a:hover {color: #0097FF;}

a:link {color: #0000CC;}
a:visited {color: #0000CC;}
a:hover {color: #0097FF;}
		</style>

		<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
		<meta http-equiv="cache-control" content="no-cache" />
	</head>
	<body>
<?php
include(ADMIN_MODUL . "/admin.index.form.php");
?>
		<ul>
<?php
for($i=0; $i < $lusers; ++$i)
{
?>
			<li><a href="<?= adm_pub_hr . "&amp;" . part_id . "=" . $_GET[part_id] . "&amp;" . user_id . "=" . $loginObjAdmin->outid($i) ; ?>"><?=$loginObjAdmin->out(logtab_nic, $i); ?></li>
<?php
}
?>
		</ul>
	</body>
</html>
