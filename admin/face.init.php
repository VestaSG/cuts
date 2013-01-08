<?php
$partarr = $mobj_loc->treeBuilding($userstat);
$l = count($partarr);
$lusers = $loginObjAdmin->load();

$outpage = ADMIN_MODUL . "/main.admin.form.php";
if($_GET["a"] == "main") // умолчательное значение, заданное явно
{
	$outpage = ADMIN_MODUL . "/main.admin.form.php";
}
if($_GET["a"] == "hr")
{
	$outpage = ADMIN_MODUL . "/hr/face.inc.php";
}
?>
