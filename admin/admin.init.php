<?php
$adminObj = new admin($dbobject);
$adminObj->SetPart($mobj->outid());

$loginObjAdmin = new user($dbobject); // локальный объект пользователей
$mobj_loc = new menu($dbobject); // локальный объект разделов
?>
