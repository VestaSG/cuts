<?php
$admin = false;
$toptext = "";
$hreffromhere = SITE_INDEX;
$outform = "index.form.php";
$userstat = $login_obj->out_status();
if( $login_obj->islogin() )
{
	$admin = true;
	$toptext = "<a href=\"" . SITE_INDEX . "login/useradmin/useradmin.inc.php?uid=" . $login_obj->outid() . "\">" . $login_obj->out_nic() . "</a>";
	if(!$toptext) { $toptext = $login_obj->out_log(); }
	$toptext = $toptext . "&nbsp;&nbsp;<a class=\"forout\" href=\"" . SITE_INDEX . "login/authorization/aut.do.php?logout=logout\">�����</a>";
} else
{
	$toptext = "�� �� ������������. <a href=\"" . AUT_INDEX . "\">�������������</a>";
}
if( 1 > $userstat )
{
//	unset($partarr[0]);
}
if(!$_GET["pid"])
{
	$mobj->loadDefault();
}
else
{
	$mobj->load($_GET["pid"]);
}

if( 1 > $mobj->outcount() )
{
	$hreffromhere = SITE_ERR_404;
	$outform = MAIN_CL_DIR . "/htmldo.php";
}
else
{
	if( (!$mobj->out(parttab_visible)) && (1 > $userstat) )
	{
		$hreffromhere = SITE_ERR_404;
		$outform = MAIN_CL_DIR . "/htmldo.php";
	} else
	{
		$outform = $mobj->OutModulFace($mobj->out(parttab_modul), "face"); // ������� �������� ������
	}
}
// echo($outform);
// ------- ���� ����������� ���� --------
$login_obj->setpart( $mobj->outid() ); // ������
// ------- END: ���� ����������� ���� --------
?>
