<?php
$freeset = array();
$deffree = ""; // Строка, так как используется в форме. Другое значение - checked

$i = 0;
$freeset[$i] = array();
$freeset[$i]["val"] = $i + 1;
$freeset[$i]["title"] = "Чтение";
$freeset[$i]["is"] = $deffree;

++$i;
$freeset[$i] = array();
$freeset[$i]["val"] = $i + 1;
$freeset[$i]["title"] = "Редактирование";
$freeset[$i]["is"] = $deffree;

++$i;
$freeset[$i] = array();
$freeset[$i]["val"] = $i + 1;
$freeset[$i]["title"] = "Удаление";
$freeset[$i]["is"] = $deffree;

++$i;
$freeset[$i] = array();
$freeset[$i]["val"] = $i + 1;
$freeset[$i]["title"] = "Создание";
$freeset[$i]["is"] = $deffree;
?>
