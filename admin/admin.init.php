<?php
$adminObj = new admin($dbobject);
$adminObj->SetPart($mobj->outid());

$loginObjAdmin = new user($dbobject); // ��������� ������ �������������
$mobj_loc = new menu($dbobject); // ��������� ������ ��������
?>
