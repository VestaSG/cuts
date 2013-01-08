<?php
$attForm = new htmlform("atttest");
$attFormList = array();
$attForm->set_action(SITE_INDEX . "?pid=" . $mobj->outid() . "&amp;a=dof");
$attForm->morein("enctype=\"multipart/form-data\"");

$att->FormPlus($attForm, $attFormList);

$attForm->addf(ftype_subm);
	$attForm->set_param(PTTRN_value, "Сохранить");
	$attForm->set_param(PTTRN_class, "bigbutton");
?>
