<?php
if($new)
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<title>Новый пользователь</title>

<style type="text/css">
body{margin:0; padding:0;}
.inpcl{ /* border: 1px solid #aaaaaa; background-color:#ffffff; */ width:400px;}
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
	if($iscreit)
	{
?>

	<form name="<?=$edituserform ?>" action="user.useradmin.do.php" method="post" >

<p class="fieldtitle"><?=$title_log ?>&nbsp;</p>
<input type="text" name="<?=$logform_log ?>" class="inpcl" value="" />
<br clear="all" />

<p class="fieldtitle"><?=$title_pas ?>&nbsp;</p>
<input type="text" name="<?=$logform_pas ?>" class="inpcl" value="" />
<br clear="all" />

<p class="fieldtitle"><?=$title_submit ?>&nbsp;</p>
<input type="submit" name="<?=$logform_submit ?>" value="Сохранить" />
<br clear="all" />
<input type="hidden" name="<?=user_id ?>" value="<?=$in_user ?>" />

<p class="fieldtitle">&nbsp;</p>

	</form>
<?php
	}
	else
	{
?>
<p class="fieldtitle">&nbsp;</p>
<p style="margin-top:10pt;">У Вас нет прав для создания нового пользователя</p>
<?php
	}
?>
</body>
</html>

<?php
}
else
{
$editbutton = "";
if(!$isedit){$editbutton = "disabled title=\"Нет права\"";}
?>
	<form name="<?=$edituserform ?>" action="user.useradmin.do.php" method="post" >

<p class="fieldtitle"><?=$title_stat ?>&nbsp;</p>
<input type="text" name="<?=$logform_stat ?>" class="inpcl" value="<?=$logform_stat_val ?>" />
<br clear="all" />

<p class="fieldtitle"><?=$title_nic ?>&nbsp;</p>
<input type="text" name="<?=$logform_nic ?>" class="inpcl" value="<?=$logform_nic_val ?>" />
<br clear="all" />

<p class="fieldtitle"><?=$title_submit ?>&nbsp;</p>
<input type="submit" <?=$editbutton ?> name="<?=$logform_submit ?>" value="Сохранить" />
<br clear="all" />
<input type="hidden" name="<?=user_id ?>" value="<?=$in_user ?>" />

<p class="fieldtitle">&nbsp;</p>
<p style="margin-top:10pt;">
<?php
if($isdel)
	{
?>
<a href="user.useradmin.do.php?del=<?=$in_user ?>">Удалить пользователя</a>
<?php
	}
else
	{
?>
<span style="color:#aaaaaa;" title="Нет права">Удалить пользователя</span>
<?php
	}
?>
</p>

	</form>
<?php
}
?>
