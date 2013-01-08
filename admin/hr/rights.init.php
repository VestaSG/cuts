<?php
$locUser = new user($dbobject);
$locUser->setpart( $_GET["p"] );
$locUser->init_frees($_GET["u"], $_GET["p"]);
$freearr = $locUser->outfreearray();
$lrights = count($freearr);
for($i = 0; $i < $lrights; ++$i)
{
	if($locUser->is_free($freearr[$i]["val"])) {$freearr[$i]["is"] = "checked=\"checked\"";}
}

$isedit = true; // Значение присваивается по результатам проверки прав пользователя в разделе
?>
