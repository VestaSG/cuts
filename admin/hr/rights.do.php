<?php
$hreffromhere = adm_pub_hr . "&amp;u=" . $_POST["u"] . "&amp;p=" . $_POST["p"];

$locUser = new user($dbobject);
$locUser->setpart( $_POST["p"] );
$in_part = $_POST["p"];
$in_user = $_POST["u"];
$locUser->delfrees($in_user, $in_part);
foreach ($_POST as $k => $value)
{
	if ( preg_match ("/fr([0-9]+)/Usi", $k) )
	{
		$locUser->addfree($in_user, $in_part, $value);
	}
}

include(MAIN_CL_DIR . "/htmldo.php");
?>
