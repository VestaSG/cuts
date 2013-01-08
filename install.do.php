<?php
function installecho($installObj)
{
	return $installObj->install();
}

include_once( dirname(__FILE__) . "/dir.conf.php" );

include_once( MAIN_CL_DIR."/conf.php" );
include_once( DB_MODUL."/db.inc.php" );
include_once( LOGIN_MODUL."/login/login.inc.php" );
include_once( MENU_MODUL . "/menu.inc.php" );
$mobj->load(1);

include( DBUNIT_MODUL . "/install.subjects.do.php");
include( HISTORY_MODUL . "/install.do.php");
include( LOGIN_MODUL."/install.login.do.php" );
include( MENU_MODUL . "/install.menu.do.php");
include( ATTACH_MODUL."/install.do.php" );
// Модули, добавленные в modul.conf.php модуля menu устанавливаются автоматически!

$inclist = $mobj->outInstallList();
foreach ($inclist as $incfile)
{
	include($incfile);
}
?>
