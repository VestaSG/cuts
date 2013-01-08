<?php
$hreffromhere = SITE_INDEX . "?pid=" . $mobj->outid() . "&amp;edit=edit";
if("dof" == $_GET["a"])
{
	$att->FormParse($attForm, $attFormList);
	$att->save();
}
if("df" == $_GET["a"])
{
	if($_GET[UNIKEY] && str_is_int($_GET[UNIKEY]))
	{
		$att->del($_GET[UNIKEY]);
	}
}

include(MAIN_CL_DIR . "/htmldo.php");
?>
