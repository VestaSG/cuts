<?php
include_once( dirname(__FILE__) . "/../dir.conf.php" );
include_once( MAIN_CL_DIR."/conf.php" );
include_once( DB_MODUL."/db.inc.php" );
include_once( LOGIN_MODUL."/login/login.inc.php");
include_once( FORM_MODUL."/form.inc.php");

include(MENU_MODUL . "/menu.inc.php");
include(MENU_MODUL . "/edit.menu.conf.php");
include(MENU_MODUL . "/edit.menu.init.php");
// include(MENU_MODUL . "/edit.menu.form.php");

$hreffromhere = SITE_INDEX; // куда перейти
$partform->load();
$menupart = 0; // редактируемый раздел
// $mobj->set( parttab_modul, $partform->out_value($fieldindex["modul"]) );
$mobj->set( parttab_visible, $partform->out_value($fieldindex["partcont"]) );
$mobj->set( parttab_name, $partform->out_value($fieldindex["partname"]) );
if( $partform->out_value($fieldindex["id"]) && str_is_int($partform->out_value($fieldindex["id"])) )
{
	$mobj->set( parttab_id, $partform->out_value($fieldindex["id"]) );
	$menupart = $mobj->save();
	$hreffromhere = SITE_INDEX . "?pid=" . $partform->out_value($fieldindex["id"]) . "&edit=edit";
}
else
{
	$mobj->set( parttab_modul, $partform->out_value($fieldindex["modul"]) );

	$menupart = $mobj->save();

	$mobj->load($menupart);
	include($mobj->outModulDir() . "/quicknew.do.php");

	$mobj->SetAllRights($login_obj->outid());
}
if( $partform->out_value($fieldindex["partface"]) )
{
	$mobj->setDefault($menupart);
}

// html для перехода
include(MAIN_CL_DIR . "/htmldo.php");
?>
