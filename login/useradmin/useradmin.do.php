<?php
// Редактирование прав пользователя
include(dirname(__FILE__) . "/../../dir.conf.php");

include_once(DB_MODUL . "/db.inc.php");
include_once(LOGIN_MODUL . "/login/login.inc.php");

include(LOGIN_MODUL . "/useradmin/useradmin.conf.php");
include_once(LOGIN_MODUL . "/user.class.php");
include(LOGIN_MODUL . "/useradmin/useradmin.init.php");

$hreffromhere = "useradmin.inc.php?" . err . "=" . free_err;
if($isedit)
{
	$in_part = $_POST[part_id];
	$in_user = $_POST[user_id];

	$uadm->delfrees($in_user, $in_part);

	foreach ($_POST as $k => $value)
	{
		if ( preg_match ("/fr([0-9]+)/Usi", $k) )
		{
			$uadm->addfree($in_user, $in_part, $value);
		}
	}
	$hreffromhere = "useradmin.inc.php?" . part_id . "=$in_part" . "&" . user_id . "=$in_user";
}

include(LOGIN_MODUL . "/htmldo.php");
?>
