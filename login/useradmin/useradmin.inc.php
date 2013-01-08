<?php
include_once(dirname(__FILE__) . "/../../dir.conf.php");

include_once(DB_MODUL."/db.inc.php");
include_once(LOGIN_MODUL . "/login/login.inc.php");
include_once(MENU_MODUL . "/menu.inc.php");

include(LOGIN_MODUL . "/useradmin/useradmin.conf.php");
include(LOGIN_MODUL . "/useradmin/useradmin.init.php");
include(LOGIN_MODUL . "/useradmin/adminform.useradmin.init.php");

if($isread)
{
	if($err)
	{
		include(LOGIN_MODUL . "/useradmin/err.init.php");
		include(LOGIN_MODUL . "/useradmin/err.form.php");
		exit(" ");
	}

	if($inctype == 1)
	{
		include(LOGIN_MODUL . "/useradmin/list.useradmin.form.php");
	}

	if($inctype == 2)
	{
		include(LOGIN_MODUL . "/useradmin/user.useradmin.conf.php");
		include(LOGIN_MODUL . "/useradmin/user.useradmin.init.php");
		include(LOGIN_MODUL . "/useradmin/list.useradmin.form.php");
	}

	if($inctype == 3)
	{
		include(LOGIN_MODUL . "/useradmin/list.useradmin.form.php");
	}

	if($inctype == 4)
	{
		include(LOGIN_MODUL . "/useradmin/freelist.useradmin.form.php");
	}

	if($inctype == 5)
	{
		include(LOGIN_MODUL . "/useradmin/user.useradmin.conf.php");
		include(LOGIN_MODUL . "/useradmin/user.useradmin.init.php");
		include(LOGIN_MODUL . "/useradmin/user.useradmin.form.php");
	}
}
else
{
	include(LOGIN_MODUL . "/useradmin/aut.form.php");
}
?>
