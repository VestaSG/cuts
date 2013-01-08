<?php
$cutorderForm = new htmlform("cutorder");
$cutorderFormList = array();
$cutorderForm->set_action(cut_http_do);
$cutorderForm->set_tab(3);

$cutorderObj->FormPlus($cutorderForm, $cutorderFormList);
// button
$cutorderForm->addf(ftype_subm);
	$cutorderForm->set_param(PTTRN_value, "Сохранить");
	$cutorderForm->set_param(PTTRN_class, "bigbutton");
	$cutorderForm->set_param(PTTRN_id, "bigbutton");

	$cutorderForm->set_param(PTTRN_value, 2, $cutorderFormList["sub_".TAB_CUTORDER_scale]); // 1 - поумолчанию

if("do" == $_GET["a"])
{
	$cutorderObj->FormParse($cutorderForm, $cutorderFormList);
	$theid = $cutorderObj->save();
	$hreffromhere = cut_http_edit . "&amp;" . UNIKEY . "=" . $theid;
	include(MAIN_CL_DIR . "/htmldo.php");
}
else
{
	if( $_GET[UNIKEY] && str_is_int($_GET[UNIKEY]) )
	{
		$cutorderObj->load($_GET[UNIKEY]);
		$cutorderObj->FormComplete($cutorderForm, $cutorderFormList);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>

		<title><?=$ttl ?></title>

		<style type="text/css">
	.foot{padding-top:10px; font-size:8pt; color:#777777; border-top: 1px solid #777777; margin-top:20px; font-family:verdana;}
	.foot p{padding:0; padding-left:40px; padding-top:5px; margin:0;}


body{padding:0; margin:0;}
.main{padding-left:10px;}
.inpclred{ border: 1px solid red; background-color:#ffeeee; } /* Стиль выделения элемента с ошибкой */
.inpcl{ border: 1px solid #aaaaaa; background-color:#ffffff; }

.fieldtitle {padding-right:5px; text-align:right; width:195px; float:left; margin-top:0; margin-bottom:0;}
input { width:300px; font-family:verdana; /*color:#0099AA;*/ font-size:9pt;}
input[type="date"], input[type="datetime"]{width:auto;}
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
td{width: 130px; vertical-align:top;}
		</style>

		<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
		<meta http-equiv="cache-control" content="no-cache" />
	</head>
	<body>
<?php
include(DESK_MODUL . "/header.desk.form.php");
?>
		<div class="main">

			<ul class="to_print">
				<li>Удалить</li>
				<li><a href="<?=cut_http_rtf ?>&amp;<?=UNIKEY ?>=<?=$_GET[UNIKEY] ?>">Схема (rtf/Word)</li>
				<li><a href="<?=cut_http_jedit ?>&amp;<?=UNIKEY ?>=<?=$_GET[UNIKEY] ?>">Редактировать схему</a></li>
			</ul>

<?php
$cutorderForm->showf();
?>
		</div>
<?php
include(DESK_MODUL . "/foot.desk.form.php");
?>
	</body>
</html>
<?php
}
?>
