<?php
// echo(PHP_VERSION);
// ini_set("max_input_vars", "10000"); // Прописать в php.ini

$saved = 0;
$twos = "";
$twosxml = array();
$groups = array();
$thegroup = 1;
for($i = 0; $i < $_POST["quanty"]; ++$i)
{
	if(!$groups[$i])
	{
		$groups[$i] = $thegroup;
		for($i2 = 0; $i2 < $_POST["quanty"]; ++$i2)
		{
			if( ($i2 != $i) && (!$groups[$i2]) )
			{
				if((($_POST["draggable".$i."-w"] == $_POST["draggable".$i2."-w"]) && ($_POST["draggable".$i."-h"] == $_POST["draggable".$i2."-h"])) || (($_POST["draggable".$i."-w"] == $_POST["draggable".$i2."-h"]) && ($_POST["draggable".$i."-h"] == $_POST["draggable".$i2."-w"])))
				{
					$groups[$i2] = $thegroup;
				}
			}
		}
		++$thegroup;
	}
}

for($i = 0; $i < $_POST["quanty"]; ++$i)
{
	$cutunitObj->clear_2_save();

	if($_POST["draggable".$i."-w"])
	{
		$cutunitObj->set(TAB_CUTDESKS_order, $_POST["cutid"]);
		$cutunitObj->set(TAB_CUTDESKS_w, $_POST["draggable".$i."-w"]);
		$cutunitObj->set(TAB_CUTDESKS_h, $_POST["draggable".$i."-h"]);
		$cutunitObj->set(TAB_CUTDESKS_l, $_POST["draggable".$i."-l"]);
		$cutunitObj->set(TAB_CUTDESKS_t, $_POST["draggable".$i."-t"]);
		$cutunitObj->set(TAB_CUTDESKS_ingroup, $groups[$i]);
		$cutunitObj->set(UNIKEY, $_POST["draggable".$i."-id"]);
		if(0 > $_POST["draggable".$i."-l"])
		{
			$cutunitObj->set(TAB_CUTDESKS_l, 0);
		}
		if(0 > $_POST["draggable".$i."-t"])
		{
			$cutunitObj->set(TAB_CUTDESKS_t, 0);
		}

		$sv = $cutunitObj->save();
		++$saved;
//		$twos = $twos . $i . "=" . $sv . ";";
//		$twosxml[$i]["id"] = "";
		$twosxml[$i]["dbid"] = $sv;
	}
}
// echo("q=".$saved.";".$twos);
// Переработка ответа в xml

header('Content-Type: text/xml'); // без этого понимает только Opera
echo("<?xml version=\"1.0\" encoding=\"Windows-1251\"?>\n");
?>
<sdesks>
<?php
for($i = 0; $i < $_POST["quanty"]; ++$i)
{
?>
	<dsk id="<?=$i ?>" dbid="<?=$twosxml[$i]["dbid"] ?>" />
<?php
}
?>
</sdesks>