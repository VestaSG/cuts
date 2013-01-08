<?php
include_once( dirname(__FILE__) . "/../../dir.conf.php" );

include_once(DB_MODUL . "/db.inc.php");
include_once(LOGIN_MODUL . "/login/login.inc.php");

include(LOGIN_MODUL . "/authorization/aut.conf.php");
include(LOGIN_MODUL . "/authorization/aut.init.php");
if( $login_obj->islogin() )
{
	include(LOGIN_MODUL . "/authorization/true.aut.form.php");
}
else
{
	include(LOGIN_MODUL . "/authorization/aut.form.php");
}
?>
