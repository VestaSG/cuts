<?php
// define("thepart", 2); // Раздел

$free_read = 1;

$deffree = false; // Есть ли права по-умолчанию
$freeset = array();
$adressfree = array();

$i = 0;
$adressfree[$free_read] = $i;
$freeset[$i] = array();
$freeset[$i]["val"] = $free_read;
$freeset[$i]["title"] = "Чтение";
$freeset[$i]["is"] = true;
?>
