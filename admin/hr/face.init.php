<?php
$outpage = ADMIN_MODUL . "/hr/parts.inc.php";
if( "do" == $_GET["b"] )
{
	$outpage = ADMIN_MODUL . "/hr/rights.do.php";
}
else
{
	if($_GET["p"] && str_is_int($_GET["p"]))
	{
		if($_GET["u"] && str_is_int($_GET["u"]))
		{
			$outpage = ADMIN_MODUL . "/hr/rights.inc.php";
		}
		else
		{
			$outpage = ADMIN_MODUL . "/hr/users.inc.php";
		}
	}
}

// ------- ���� �����������  ���� --------
$login_obj->setpart($mobj->outid()); // ������
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
