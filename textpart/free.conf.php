<?php
// ����� ����
$free_read = 1;
$free_edit = 2;
$free_del = 3;

$deffree = false; // ���� �� ����� ��-���������
$freeset = array();
$adressfree = array();

$i = 0;
$adressfree[$free_read] = $i;
$freeset[$i] = array();
$freeset[$i]["val"] = $free_read;
$freeset[$i]["title"] = "������";
$freeset[$i]["is"] = true;

++$i;
$adressfree[$free_edit] = $i;
$freeset[$i] = array();
$freeset[$i]["val"] = $free_edit;
$freeset[$i]["title"] = "��������������";
$freeset[$i]["is"] = $deffree;

++$i;
$adressfree[$free_del] = $i;
$freeset[$i] = array();
$freeset[$i]["val"] = $free_del;
$freeset[$i]["title"] = "��������";
$freeset[$i]["is"] = $deffree;
?>
