<?php
// Редатирование пользователя (ник, статус), удаление, создание нового
include_once( dirname(__FILE__) . "/../../dir.conf.php" );

include_once( DB_MODUL."/db.inc.php" );
include_once( LOGIN_MODUL."/login/login.inc.php" );
include(LOGIN_MODUL."/useradmin/useradmin.conf.php");
include_once(LOGIN_MODUL."/user.class.php");
include(LOGIN_MODUL."/useradmin/useradmin.init.php");
include(LOGIN_MODUL."/useradmin/user.useradmin.conf.php");
include(LOGIN_MODUL."/useradmin/user.useradmin.init.php");

$hreffromhere = "useradmin.inc.php?" . err . "=" . free_err;
if($_GET["del"])
{
	if($isdel)
	{
		$uadm->deluser($_GET["del"]);
		$hreffromhere = "useradmin.inc.php";
	}
}
else
{
	if(!$new)
	{
		if($isedit)
		{
			$stat = $_POST["$logform_stat"];
			$nic = $_POST["$logform_nic"];

			$uadm->save_nic($in_user, $nic);
			$uadm->save_stat($in_user, $stat);

			$hreffromhere = "useradmin.inc.php?" . user_id . "=" . $in_user;
		}
	}
	else
	{
		if($iscreit)
		{
			$newlog = $_POST["$logform_log"];
			$newpass = $_POST["$logform_pas"];

			$uadm->adduser($newlog, $newpass);

			$hreffromhere = "useradmin.inc.php";
		}
	}
}

include(LOGIN_MODUL."/htmldo.php");
?>
