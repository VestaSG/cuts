<?php
// этот файл включен в корневой install.do.php

include_once(DB_MODUL."/db.inc.php");
include_once(LOGIN_MODUL."/login/login.inc.php");
$install_obj = new user($dbobject);
$install_obj->install();
$install_obj->installfree();

// $install_obj->adduser("vesta", "555800");
if(!$install_obj->adduser(0, 0)){echo("<p>Первый пользователь уже есть</p>");}
else
{
	$install_obj->save_nic(1, "default");
	$install_obj->save_stat(1, 1);
/*
	$install_obj->allfrees->addfree(1, freevalue_reed, 1);
	$install_obj->allfrees->addfree(1, freevalue_edit, 1);
	$install_obj->allfrees->addfree(1, freevalue_maid, 1);
	$install_obj->allfrees->addfree(1, freevalue_del, 1);

*/
}
?>
