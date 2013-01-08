<?php
// include_once("../db/db.inc.php");

include("login.conf.php");
include_once("login.class.php");
include("login.init.php");

$logvalue;
$passvalue;
// if( isset($_SESSION[SESS_login]) && isset($_SESSION[SESS_pass]) )
if( isset($_POST[SESS_login]) && isset($_POST[SESS_pass]) )
	{
	$_SESSION[SESS_login] = $_POST[SESS_login];
	$_SESSION[SESS_pass] = $_POST[SESS_pass];
	$logvalue = $_SESSION[SESS_login];
	$passvalue = $_SESSION[SESS_pass];
	}
if( $_GET["logout"] == "logout" )
	{ //  Уничтожение сессии
	unset($_SESSION[SESS_login]);
	unset($_SESSION[SESS_pass]);
	session_destroy();
	
	$logvalue = 0;
	$passvalue = 0;
	}

if(!$hreffromhere)
	{
$hreffromhere = "/"; // Адрес, на который нужно перейти после выполнения действий
	}
?>

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1251">
<meta http-equiv="Cache-Control" content="no-cache">
	<meta http-equiv="refresh" content="0; URL=<?=$hreffromhere ?>">
</head>
