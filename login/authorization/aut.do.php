<?php
include_once( dirname(__FILE__) . "/../../dir.conf.php" );

include_once(DB_MODUL . "/db.inc.php");
include_once(LOGIN_MODUL . "/login/login.inc.php");

include(LOGIN_MODUL . "/authorization/aut.conf.php");
// include_once(LOGIN_MODUL . "/authorization/aut.class.php");
include(LOGIN_MODUL . "/authorization/aut.init.php");

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
	{ //  ”ничтожение сессии
	unset($_SESSION[SESS_login]);
	unset($_SESSION[SESS_pass]);
	session_destroy();
	
	$logvalue = 0;
	$passvalue = 0;
	}
$login_obj->setuser($logvalue, $passvalue);
if( ( !$login_obj->islogin() ) && ( $_GET["logout"] != "logout" ) ) { $hreffromhere = "aut.inc.php?err=err"; }
else{$hreffromhere = SITE_INDEX;}
// $hreffromhere = "aut.test.php"; // јдрес, на который нужно перейти после выполнени€ действий
?>

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1251">
<meta http-equiv="Cache-Control" content="no-cache">
	<meta http-equiv="refresh" content="0; URL=<?=$hreffromhere ?>">
</head>
