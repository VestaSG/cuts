<?php
$autopage = DESK_MODUL . "/list.cut.inc.php";
if($_GET["a"] == "list") // умолчательное значение, заданное явно
{
	$autopage = DESK_MODUL . "/list.cut.inc.php";
}
if( ($_GET["a"] == "edit") || ($_GET["a"] == "do") )
{
	$autopage = DESK_MODUL . "/edit.cut.inc.php";
}
if($_GET["a"] == "jedit")
{
	$autopage = DESK_MODUL . "/edit.desk.inc.php";
}
if($_GET["a"] == "jdo")
{
	$autopage = DESK_MODUL . "/edit.desk.do.php";
}
if($_GET["a"] == "jdel")
{
	$autopage = DESK_MODUL . "/del.edit.desk.do.php";
}
if($_GET["a"] == "rtf")
{
	$autopage = DESK_MODUL . "/rtf.print.desk.inc.php";
}
if($_GET["a"] == "lblack")
{
	$autopage = DESK_MODUL . "/black.list.cut.inc.php";
}
if( ($_GET["a"] == "2b") || ($_GET["a"] == "f2b") )
{
	$autopage = DESK_MODUL . "/close.desk.inc.php";
}
?>
