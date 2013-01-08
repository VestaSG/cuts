<?php
include_once( dirname(__FILE__) . "/../dir.conf.php" );
include_once( MAIN_CL_DIR."/conf.php" );
include_once( DB_MODUL."/db.inc.php" );
include_once( LOGIN_MODUL."/login/login.inc.php" );
include_once( MENU_MODUL . "/menu.inc.php" );
$mobj->load(1);

include_once( ATTACH_MODUL."/attach.inc.php");
if($_GET["id"] || str_is_int($_GET["id"]))
{
	$att->load($_GET["id"]);
	$att->showfile();
}
?>
