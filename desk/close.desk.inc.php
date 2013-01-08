<?php
/*
Поля для выгрузки счетов для данного скрипта:
 * ПечатныйНомер
 * СостояниеПроцесса
*/
if($_GET["a"] == "f2b")
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<title>Загрузка счетов</title>

	<style type="text/css">
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

.fieldtitle {padding-right:5px; text-align:right; width:195px; float:left; margin-top:0; margin-bottom:0;}
input { width:300px; font-family:verdana; /*color:#0099AA;*/ font-size:9pt;}
select { width:304px; font-family:verdana; /*color:#0099AA;*/ font-size:9pt;}
textarea{ width:300px; height:100px; font-family:verdana; /*color:#0099AA;*/ font-size:9pt;}
.bigbutton{margin-top:10px; width:304px; height:50px; font-size:15pt; font-weight:600;}

p.info{font: 15px verdana; margin-bottom:0;}
ul.info{margin-top: 0;}
ul.info li{color:#aa0000; font: 12px verdana;}

.foot{padding-top:10px; font-size:8pt; color:#777777; border-top: 1px solid #777777; margin-top:20px; font-family:verdana;}
.foot p{padding:0; padding-left:40px; padding-top:5px; margin:0;}
	</style>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
</head>

<body>
<?php
	include(DESK_MODUL . "/header.desk.form.php");
?>
	<form name="atttest" method="post" action="<?=cut_http_2black ?>" onsubmit="" enctype="multipart/form-data">
	<p class="fieldtitle">Счета</p>
	<input type="file" name="xmlfile" />
	<br clear="all" />

	<p class="fieldtitle">&nbsp;</p>
	<input type="submit" class="bigbutton" value="Загрузить" />
	<br clear="all" />
</form>
	<p class="info">Завершение всех счетов списка без проверки их состояния. Формировать список из счетов, которые хотим завершить.</p>
	<p class="info">Поля для выгрузки счетов для данного скрипта:</p>
	<ul class="info">
		<li>ПечатныйНомер</li>
		<li>СостояниеПроцесса</li>
	</ul>
<?php
include(DESK_MODUL . "/foot.desk.form.php");
?>
</body>
<?php
}
if($_GET["a"] == "2b")
{
	$hreffromhere = cut_http_dir;
	$lopen = $cutorderObj->load_open_list();

	$dom = new DomDocument('1.0', 'UTF-8');
	$dom->load($_FILES["xmlfile"]["tmp_name"]); // Это счета
	$dom = $dom->getElementsByTagName("Data")->item(0);
	$outs = $dom->getElementsByTagName("Row");
	$louts = $outs->length;
	for($i=0; $i < $louts; ++$i)
	{
		for($i2 = 0; $i2 < $lopen; ++$i2)
		{
	//		if( ($cutorderObj->out(TAB_CUTORDER_name, $i2) == iconv( "UTF-8", "cp1251", $outs->item($i)->getAttribute("c30"))) && ("{Управление.Справочники.СостояниеПроцесса:Завершен}" == iconv( "UTF-8", "cp1251", $outs->item($i)->getAttribute("c106"))) )
			if($cutorderObj->out(TAB_CUTORDER_name, $i2))
			{
				if(substr_count($cutorderObj->out(TAB_CUTORDER_name, $i2), iconv("UTF-8", "cp1251", $outs->item($i)->getAttribute("c30"))))
				{
					$cutorderObj->toblack($cutorderObj->outid($i2));
//					break; // Может быть несколько заказов по одному счету, а так мы уничтожаем только один, первый попавшийся.
				}
			}
		}
	}
	include(MAIN_CL_DIR . "/htmldo.php");
}
?>
