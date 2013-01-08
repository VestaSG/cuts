<?php
// набор прав
$free_read = 1;
$free_edit = 2;
$free_del = 3;

$deffree = false; // Есть ли права по-умолчанию
$freeset = array();
$adressfree = array();

$i = 0;
$adressfree[$free_read] = $i;
$freeset[$i] = array();
$freeset[$i]["val"] = $free_read;
$freeset[$i]["title"] = "Чтение";
$freeset[$i]["is"] = true;

++$i;
$adressfree[$free_edit] = $i;
$freeset[$i] = array();
$freeset[$i]["val"] = $free_edit;
$freeset[$i]["title"] = "Редактирование";
$freeset[$i]["is"] = $deffree;

++$i;
$adressfree[$free_del] = $i;
$freeset[$i] = array();
$freeset[$i]["val"] = $free_del;
$freeset[$i]["title"] = "Удаление";
$freeset[$i]["is"] = $deffree;
?>
