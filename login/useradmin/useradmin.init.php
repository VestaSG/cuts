<?php
// ------- Блок определения  прав --------
$login_obj->setpart($partid); // Раздел
$isedit = $deffree;
$isread = $deffree;
$isdel = $deffree;
$iscreit = $deffree;

$isread = $login_obj->is_logfree(freevalue_reed);
$isedit = $login_obj->is_logfree(freevalue_edit);
$isdel = $login_obj->is_logfree(freevalue_del);
$iscreit = $login_obj->is_logfree(freevalue_maid);
// ------- END: Блок определения  прав --------

$uadm = new user($dbobject);
?>
