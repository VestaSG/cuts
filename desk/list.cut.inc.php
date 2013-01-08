<?php
$lOrders = $cutorderObj->load_open_list();

$closXmlForm = new htmlform("cclose");
$closXmlFormList = array();
$closXmlForm->set_action(cut_http_2black);
$closXmlForm->set_tab(3);
$closXmlForm->morein("enctype=\"multipart/form-data\"");

$closXmlFormList["xmlfile"] = $closXmlForm->addf(ftype_file);
	$closXmlForm->set_param(PTTRN_signature, "Выберите файл");
	$closXmlForm->set_param(PTTRN_name, "xmlfile");

$closXmlFormList["subm"] = $closXmlForm->addf(ftype_subm);
	$closXmlForm->set_param(PTTRN_value, "Загрузить");
	$closXmlForm->set_param(PTTRN_class, "bigbutton");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<title>Закзы на распиловку</title>

	<style type="text/css">
	.foot{padding-top:10px; font-size:8pt; color:#777777; border-top: 1px solid #777777; margin-top:20px; font-family:verdana;}
	.foot p{padding:0; padding-left:40px; padding-top:5px; margin:0;}


body{padding:0; margin:0;}
.main{padding-left:10px; padding-bottom:30px;}

h1{font-weight:400; font-family:verdana; color:#000000; font-size:18pt; padding-left:30px; /*padding-bottom:5px;*/ margin-bottom:45px;}

p{font-family:verdana; padding-left:30px; }
p.thetempl{ padding-top:0; padding-bottom:0; margin-top:25px; margin-bottom:0px; }
p.edittempl{ margin:0; padding-top:0px; padding-bottom:0px; font-size:15px; color: #000000; margin-bottom:0px; }
a:link {color: #006699;}
a:visited {color: #006699;}
a:hover {color: #0097FF;}
a.aedit {font-size:9px;}
a.aedit:link {color: #999999;}
a.aedit:visited {color: #999999;}
a.aedit:hover {color: #0097FF;}
a.newtmp{}
a.newtmp:link {color: #339900;}
a.newtmp:visited {color: #339900;}
a.newtmp:hover {color: #0097FF;}
.to_print {margin:0; margin-bottom:5px; padding:0px 0px 0px 200px; font:bold 16px arial;}
.to_print li{display:inline; margin-right:10px;}
.to_print li a:link {color: #000099;}
.to_print li a:visited {color: #000099;}
.to_print li a:hover {color: #0097FF;}

.bthetempl {padding-top:0; padding-bottom:0; margin-top:25px; margin-bottom:0px;}
.bthetempl a:link {color: #555555;}
.bthetempl a:visited {color: #555555;}
.bthetempl a:hover {color: #0097FF;}
	</style>

<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
<meta http-equiv="cache-control" content="no-cache" />
</head>

<body>
<?php
include(DESK_MODUL . "/header.desk.form.php");
?>
<div class="main">
<!--
<?php
$closXmlForm->showf();
?>
-->
<h1>Выберите заказ или <a class="newtmp" href="<?=cut_http_edit ?>">создайте новый</a></h1>
<?php
for($it = 0; $it < $lOrders; ++$it) // &nbsp;
{
// $itext = $agents[$it];
?>
<p class="thetempl">
	<a href="<?=cut_http_edit ?>&amp;<?=UNIKEY ?>=<?=$cutorderObj->outid($it) ?>">
<?=$cutorderObj->out(TAB_CUTORDER_name, $it) ?></a>
</p>
<p class="edittempl"><?=$cutorderObj->out(TAB_CUTORDER_company, $it) ?></p>
<?php
}
include(DESK_MODUL . "/ajax.js.form.php");
?>
<div id="lbl"></div>
<p id="albl" style="padding-top: 20px;"><a style="color:#990033" href="#" onclick="return loadblack();">Показать остальные</a></p>
<script type="text/javascript">
function loadblack()
{
	document.getElementById("albl").style.display = "none";
	document.getElementById("lbl").innerHTML = loadXMLDoc("<?=cut_http_lblack ?>");
	return false;
}
</script>
<?php
// include(DESK_MODUL . "/black.list.cut.inc.php");
?>
</div>
<?php
include(DESK_MODUL . "/foot.desk.form.php");
?>
</body>

</html>
