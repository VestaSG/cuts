<?php
include_once( dirname(__FILE__) . "/../dir.conf.php" );

include_once( DB_MODUL."/db.inc.php" );

include_once( TEXT_MODUL . "/textpart.conf.php" );
include_once( TEXT_MODUL . "/textpart.class.php" );
include_once( TEXT_MODUL . "/textpart.init.php" );

include( TEXT_MODUL . "/free.inc.php" );

if($_GET["del"] == "del")
{
	include( TEXT_MODUL . "/del.textpart.do.php" );
}
else
{
	if(!$freeset[$adressfree[$free_read]]["is"])
	{
		$hreffromhere = SITE_ERR_403;
		include( TEXT_MODUL . "/htmldo.php" );
	}
	if( ($_GET["edit"] == "edit") || ($_GET["edit"] == "do") )
	{
		include_once( TEXT_MODUL . "/edit.textpart.inc.php" );
	}
	else
	{
		if(!$_GET["a"])
		{
			include_once( TEXT_MODUL . "/client.textpart.init.php" );
			include_once( TEXT_MODUL . "/client.textpart.form.php" );
		}
		if( ("adf" == $_GET["a"]) || ("df" == $_GET["a"]) || ("dof" == $_GET["a"]) ) // добавить/удалить файл
		{
			include_once( TEXT_MODUL . "/addfile.textpart.inc.php" );
		}
	}
}
?>
