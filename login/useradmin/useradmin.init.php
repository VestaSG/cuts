<?php
// ------- ���� �����������  ���� --------
$login_obj->setpart($partid); // ������
$isedit = $deffree;
$isread = $deffree;
$isdel = $deffree;
$iscreit = $deffree;

$isread = $login_obj->is_logfree(freevalue_reed);
$isedit = $login_obj->is_logfree(freevalue_edit);
$isdel = $login_obj->is_logfree(freevalue_del);
$iscreit = $login_obj->is_logfree(freevalue_maid);
// ------- END: ���� �����������  ���� --------

$uadm = new user($dbobject);
?>
