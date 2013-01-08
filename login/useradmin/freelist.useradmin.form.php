<?php
// Задачи:
	// Список прав
	// Для отображения должны быть определены part и user
	// Контроль последнего пользователя
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<title><?//= ?></title>

<style type="text/css">
body{margin:0; padding:0;}
.inpcl{ border: 1px solid #aaaaaa; background-color:#ffffff; }
.fieldtitle {padding-right:5px; text-align:right; width:195px; float:left; margin-top:0; margin-bottom:0;}
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

	<form name="<?=$freelistform ?>" action="useradmin.do.php" method="post" onsubmit="return submiting();" onkeyup="thrueForm();" >

<?php
for($i = 0; $i < $l; ++$i )
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
<input type="submit" <?=$editbutton ?> name="<?=$logform_submit ?>" value="Установить права" />
<br clear="all" />
<input type="hidden" name="<?=part_id ?>" value="<?=$in_part ?>" />
<input type="hidden" name="<?=user_id ?>" value="<?=$in_user ?>" />

	</form>
</body>
</html>
