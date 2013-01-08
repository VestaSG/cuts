<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>

		<title>Index</title>
<?php
// Цвет главной страницы от времени суток
$body_ground = "#ffffff";
/*
$h_now = date("H");
if( (23 <= $h_now) || (4 > $h_now) )
{
	$body_ground = "#000011";
}
if( (4 <= $h_now) && (7 >= $h_now) )
{
	$body_ground = "#d0ddff";
}
if( (23 > $h_now) && (20 <= $h_now) )
{
	$body_ground = "#ccccdd";
}
*/
// END: Цвет главной страницы от времени суток
?>
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

ul{margin-left:0px; padding-left:0;}
li{padding-bottom:3pt;}

a:link {color: #0000CC;}
a:visited {color: #0000CC;}
a:hover {color: #0097FF;}

li.hidli a:link {color: #aaaaaa;}
li.hidli a:visited {color: #aaaaaa;}
li.hidli a:hover {color: #0097FF;}

a.hr:link, a.hr:visited, li.hidli a.hr:link, li.hidli a.hr:visited {color:red;}
a.hr:hover, li.hidli a.hr:hover {color: #0097FF;}

/* Разметка main */
div.main{padding-right:30px; padding-left:50px; }
div.main div {float:left; height:100%; padding-left:0; padding-right:0; width:45%; min-width:200px; }
div.main div ul {margin-left:-5px;}
div.main div ul li {padding-left:5px;}
div.main div.r-main{padding-left:40px;}
.hlist {font-size: 12pt; font-family:Verdana; /*font-weight: normal;*/ padding: 0; margin: 0;}
		</style>

		<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
		<meta http-equiv="cache-control" content="no-cache" />
	</head>
	<body>
<?php
include(ADMIN_MODUL . "/admin.index.form.php");

if(404 == $_GET["err"])
{
	include(INDEX_DIR . "/404err.form.php");
}
if(403 == $_GET["err"])
{
	include( INDEX_DIR . "/403err.form.php");
}
?>
	<div class="main">
		<div class="l-main">
			<h1 class="hlist">Разделы</h1>
			<ul>
<?php
for($i = 0; $i < $l; ++$i)
{
	if( isset($partarr[$i]) )
	{
		$liclass = "";
		if(!$partarr[$i]["vis"])
		{
			$liclass = " class=\"hidli\"";
		}
?>
				<li<?=$liclass ?>>
<?php
			if(0 < $userstat)
			{
?>
					<a class="hr" href="<?= adm_pub_hr . "&amp;" . part_id . "=" . $partarr[$i]["id"]; ?>">права</a>&nbsp;
<?php
			}
?>
					<a href="<?=$partarr[$i]["link"] ?>"><?=$partarr[$i]["name"] ?></a>
				</li>
<?php
	}
}
?>
			</ul>
		</div>
<?php
if(0 < $userstat)
{
?>
		<div class="r-main">
			<h1 class="hlist">Пользователи</h1>
			<ul>
<?php
	for($i=0; $i < $lusers; ++$i)
	{
?>
			<li><a href="login/useradmin/useradmin.inc.php?u=<?=$loginObjAdmin->outid($i); ?>"><?=$loginObjAdmin->out(logtab_nic, $i); ?></a></li>
<?php
	}
?>
			</ul>
		</div>
<?php
}
?>
	</div>

	</body>
</html>
