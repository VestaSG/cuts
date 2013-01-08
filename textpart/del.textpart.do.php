<?php
// Для включения другим
/*
include_once( TEXT_MODUL . "/textpart.conf.php" );
include_once( TEXT_MODUL . "/textpart.class.php" );
include_once( TEXT_MODUL . "/textpart.init.php" );
*/
$hreffromhere = SITE_INDEX . "?pid=" . $mobj->outid();
if($freeset[$adressfree[$free_del]]["is"])
{
	$tp->del_for($mobj->outid());
	$mobj->del($mobj->outid());

	$hreffromhere = SITE_INDEX;
}

include( TEXT_MODUL . "/htmldo.php" );
?>
