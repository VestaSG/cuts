<?php
include_once( TEXT_MODUL . "/textpart.conf.php" );
include_once( TEXT_MODUL . "/textpart.class.php" );
include_once( TEXT_MODUL . "/textpart.init.php" );

$tp->set(texttab_in, $menupart); // ���������� �����. � ������� save() ������ menu
$tp->save();
?>
