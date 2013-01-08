<?php
for($menui = 2; $menui < $mleng; ++$menui)
{
// добавить разницу в зависимости от режима просмотра/редактирования
// именно сюда, так как разделы пользователи и транспорт имеют только один режим
	$partarr[$menui]["link"] = SITE_INDEX . "?pid=" . $partarr[$menui]["id"];
}
/*
++$i;
$allparts[$i]["dir"] = SITE_INDEX . "wincalc/";
$allparts[$i]["name"] = "Оконный калькулятор";
*/
$l = count($partarr);
?>
