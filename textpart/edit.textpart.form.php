<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Cache-Control" content="no-cache" />
	<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
	<title><?=$thettl ?></title>
	<style type="text/css">
body{padding:0; margin:0;}
.main{padding-left:20px; padding-bottom:10px;}
p{font-family:verdana;}

.inpcl
{
	margin-top:2px;
	border: 1px solid #aaaaaa;
	background-color:#ffffff;
}
.submbutton
{
	width:504px;
	height:70px;
	font-size:18pt;
	font-weight:600;
	margin-top:8px;
}
.fieldtitle
{
	padding-right:5px;
	text-align:right;
	width:195px;
	float:left;
	margin-top:0;
	margin-bottom:0;
}
input
{
	width:500px;
	font-family:verdana;
	/*color:#0099AA;*/
	font-size:9pt;
}
select
{
	width:304px;
	font-family:verdana;
	/*color:#0099AA;*/
	font-size:9pt;
}
textarea
{
	margin-top:2px;
	width:500px;
	height:400px;
	font-family:verdana;
	/*color:#0099AA;*/
	font-size:9pt;
}
.partform {padding-left:20px; padding-bottom:0; padding-top:10px; display:none;}
.partform .inpcl
{
	margin-top:2px;
	border: 1px solid #aaaaaa;
	background-color:#ffffff;
}
.partform .submbutton
{
	width:304px;
	height:50px;
	font-size:18pt;
	font-weight:600;
	margin-top:8px;
}
.partform .fieldtitle
{
	font-size:10pt;
	padding-right:5px;
	text-align:right;
	width:195px;
	float:left;
	margin-top:0;
	margin-bottom:0;
}
.partform input
{
	width:300px;
	font-family:verdana;
	/*color:#0099AA;*/
	font-size:9pt;
}
.partform select
{
	width:304px;
	font-family:verdana;
	/*color:#0099AA;*/
	font-size:9pt;
}
.partform textarea
{
	margin-top:2px;
	width:300px;
	height:200px;
	font-family:verdana;
	/*color:#0099AA;*/
	font-size:9pt;
}

.jpart a.jact
{
/*	float:right;
*/	margin-left:220px;
	margin-bottom:20px;
	text-decoration:none;
	border-bottom:1px dashed;
}
.jpart a.jact:link {color:#0000CC;}
.jpart a.jact:visited {color: #0000CC;}
.jpart a.jact:hover {color: #0097FF;}

<?php include(TEXT_MODUL . "/css.top.form.php"); ?>
	</style>
</head>
<body>
	<?php include(TEXT_MODUL . "/top.form.php"); ?>
	<div class="jpart">
		<script type="text/javascript">
function hsm()
{
	pf = document.getElementById("partform");
	if("block" == pf.style.display)
	{
		pf.style.display = "none";
	}
	else
	{
		pf.style.display = "block";
	}
}
		</script>
		<a class="jact" href="#" onclick="hsm()">Раздел</a>
		<div class="partform" id="partform">
			<?php include(MENU_MODUL . "/light.edit.menu.inc.php"); ?>
		</div>
		<hr />
	</div>
<?php
		/* content & beforecontent */
/*		div.content {padding:40px 15px 0 15px;}
		div.content div {float:left; height:100%;}
		div.content div.c0 {width:4%; min-width:30px;}
		div.content div.c0 br {line-height:1px;}
		div.content div.c1 {width:23%; font:11px verdana;}
		div.content div.c2 {width:45%; padding-left:8px;}
		div.content div.c3 {width:23%; float:right;}
		div.content div.c3 a {font:bold 15px arial;}
		div.content div.c4 {width:62%; float:left; padding-left:7px;}
		div.content div.c5 {width:72%; float:left;}
		div.content div.indent {height:30px;}
*/
/*
	<div class="content">
		<!-- left column -->
		<div class="c1">
			Последнее обновление: сегодня, 30 августа		</div>
		<!-- END: left column -->
		<div class="c0"><br /></div>
		<!-- center column -->
		<div class="c2">
		</div>
		<!-- END: center column -->
		<div class="c0"><br /></div>
		<!-- right column -->
		<div class="c3">&nbsp;</div>
		<!-- END: right column -->
		<br clear="all" />
	</div>
	<br clear="all" />
	<!-- footer -->
	<!-- / footer -->
*/
?>	<div class="main">
		<?php $textpart->showf(); ?>
	</div>	
</body>
</html>
