<?php
// Файл для включения другим inc-файлом
include_once( FORM_MODUL."/form.inc.php");
include_once( ATTACH_MODUL."/attach.inc.php");

include( "edit.textpart.conf.php" );
include( "edit.textpart.init.php" );
include( $formfileout ); // определен в edit.textpart.init.php
/*include( "edit.perfin.conf.php" );
include( "edit.perfin.init.php" );
// include( $formfileout ); // определен в edit.textpart.init.php
*/
?>
