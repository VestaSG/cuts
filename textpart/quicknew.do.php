<?php
include_once( TEXT_MODUL . "/textpart.conf.php" );
include_once( TEXT_MODUL . "/textpart.class.php" );
include_once( TEXT_MODUL . "/textpart.init.php" );

$tp->set(texttab_in, $menupart); // переменная опред. в функции save() класса menu
$tp->save();
?>
