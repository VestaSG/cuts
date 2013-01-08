<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>title</title>
		<style type="text/css">
body{margin:0; padding:0;}
.inpcl{ border: 1px solid #aaaaaa; background-color:#ffffff; }
.fieldtitle {padding-right:5px; text-align:right; width:195px; float:left; margin-top:0; margin-bottom:0;}
.errtxt{color:#aa0000; margin-left:200px;}

<?php
// include("css.top.useradmin.form.php");
?>
div.topmenu{height:50pt; background-color:#000000; margin-bottom:15pt;}
div.topmenu a:visited{color: #0097FF;}
div.topmenu a:link{color: #0097FF;}
div.topmenu a:hover{color: #ffffff;}
div.topmenu .left{height:20pt; color:#ffffff; margin-bottom:0; margin-left:200px; width:400px; padding-top:5pt;}
<?php
// END: include("css.top.useradmin.form.php");
?>


a:link {color: #0000CC;}
a:visited {color: #0000CC;}
a:hover {color: #0097FF;}
		</style>
		<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
		<meta http-equiv="cache-control" content="no-cache" />
	</head>
	<body>
<div class="topmenu">
	<div class="left"><?=$toptext ?><br /><a href="<?=SITE_INDEX ?>">В начало</a></div>
</div>
	<form name="<?=$freelistform ?>" action="<?=$formaction ?>" method="post" onsubmit="return submiting();" onkeyup="thrueForm();" >
<?php
for($i = 0; $i < $lrights; ++$i)
{
?>
	<p class="fieldtitle">&nbsp;</p>
	<input class="auto" type="checkbox" <?=$freearr[$i]["is"] ?> name="fr<?=$i ?>" id="fr<?=$i ?>" value="<?=$freearr[$i]["val"] ?>" />
	<label for="fr<?=$i ?>"><?=$freearr[$i]["title"] ?></label>
	<br clear="all" />
<?php
}
$editbutton = "";
if(!$isedit){$editbutton = "disabled title=\"Нет права\"";}
?>

<p class="fieldtitle"><?=$title_submit ?>&nbsp;</p>
<input type="submit" <?=$editbutton ?> name="<?=$submitname ?>" value="Установить права" />
<br clear="all" />
<input type="hidden" name="p" value="<?=$in_part ?>" />
<input type="hidden" name="u" value="<?=$in_user ?>" />
	</form>

	</body>
</html>
