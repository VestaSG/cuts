<?php
session_start();

$logvalue = 0;
$passvalue = 0;
$thepart = 0;

if( isset($_SESSION[SESS_login]) && isset($_SESSION[SESS_pass]) )
	{
	$logvalue = $_SESSION[SESS_login];
	$passvalue = $_SESSION[SESS_pass];
	}
$login_obj = new user($dbobject);
$login_obj->setuser($logvalue, $passvalue);
?>
