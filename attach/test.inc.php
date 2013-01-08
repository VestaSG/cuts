<?php
include_once( dirname(__FILE__) . "/../dir.conf.php" );
include_once( MAIN_CL_DIR."/conf.php" );
include_once( DB_MODUL."/db.inc.php" );
include_once( LOGIN_MODUL."/login/login.inc.php" );
include_once( MENU_MODUL . "/menu.inc.php" );

include_once( "attach.inc.php" );

$frm = new htmlform("atttest");
$frmList = array();
$frm->set_action("test.inc.php?a=do&pid=37");
$frm->morein("enctype=\"multipart/form-data\"");

$att->FormPlus($frm, $frmList);

$frm->addf(ftype_subm);

if($_GET["a"] == "form")
{
	include("test.form.php");
}
if($_GET["a"] == "do")
{
	include("test.do.php");
}
?>
