<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	
	<title></title>

<style type="text/css">
.every {font-family:verdana; padding-left:200px; /* padding-bottom:15pt; */ padding-top:10pt; margin:0;}
.every li{display:inline; margin-right:10px;}

body{padding:0; margin:0;}
.main{padding-left:10px;}
.inpclred{ border: 1px solid red; background-color:#ffeeee; } /* Стиль выделения элемента с ошибкой */
.inpcl{ border: 1px solid #aaaaaa; margin-top:3px;}
.submbutton{width:304px; height:50px; font-size:15pt; font-weight:600; margin-top:8px;}

br{line-height:1px;}

.fieldtitle {padding-right:5px; text-align:right; width:195px; float:left; margin-top:0; margin-bottom:0;}
input {width:300px; font-family:verdana; /*color:#0099AA;*/ font-size:9pt;}
select { width:304px; font-family:verdana; /*color:#0099AA;*/ font-size:9pt;}
textarea{ width:300px; height:100px; font-family:verdana; /*color:#0099AA;*/ font-size:9pt;}
fieldset{border: 1px solid #aaaaaa; width:302px; margin:0; padding:0; padding-top:4px; padding-bottom:8px;}hr {height:3px; border:0; color:#000000; background-color:#000000;}
p.to_print {/*background:#ffddee;*/ padding:0px 0px 0px 0px; font:bold 16px arial; width:500px; text-align:right;}
a:link {color: #0000CC;}
a:visited {color: #0000CC;}
a:hover {color: #0097FF;}
</style>
<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
<meta http-equiv="cache-control" content="no-cache" />
</head>
<body>
<div class="main" style="padding-top:15px;">
<form name="canv" method="get" action="hand_desk_auto.php">

	<p class="fieldtitle">Высота [мм]</p>
	<input type="text" class="inpcl" name="h" value="1000" />
	<br clear="all" />

	<p class="fieldtitle">Ширина [мм]</p>
	<input type="text" class="inpcl" name="w" value="2000" />
	<br clear="all" />

	<p class="fieldtitle">Шаг по вертикали [мм]</p>
	<input type="text" class="inpcl" name="sth" value="" />
	<br clear="all" />

	<p class="fieldtitle">Шаг по горизонтали [мм]</p>
	<input type="text" class="inpcl" name="stw" value="" />
	<br clear="all" />

	<p class="fieldtitle">Шагов по вертикали [шт]</p>
	<input type="text" class="inpcl" name="qh" value="" />
	<br clear="all" />

	<p class="fieldtitle">Шагов по горизонтали [шт]</p>
	<input type="text" class="inpcl" name="qw" value="" />
	<br clear="all" />

	<p class="fieldtitle">&nbsp;</p>
	<input type="submit" class="submbutton" value="Ку! ->" />
	<br clear="all" />

</form>
</div>
</body>
