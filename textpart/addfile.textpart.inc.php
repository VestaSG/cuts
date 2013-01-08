<?php
include_once( ATTACH_MODUL."/attach.inc.php");

include_once( TEXT_MODUL . "/addfile.textpart.conf.php" );
include_once( TEXT_MODUL . "/addfile.textpart.init.php" );

if("adf" == $_GET["a"])
{
	include( TEXT_MODUL . "/addfile.textpart.form.php" );
}
if( ("dof" == $_GET["a"]) || ("df" == $_GET["a"]) )
{
	include_once( TEXT_MODUL . "/addfile.textpart.do.php" );
}
?>
