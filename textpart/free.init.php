<?php
// включать после free.conf.php текущего модуля
$countrights = count($freeset);
for($ir = 0; $ir < $countrights; ++$ir)
{
	$freeset[$ir]["is"] = $login_obj->is_logfree($freeset[$ir]["val"]);
}
?>
