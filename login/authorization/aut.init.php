<?php
if($_GET["err"] == "err") { $errtext = "Вы ввели неверный login или пароль"; }

$unic = $login_obj->out_nic();
?>
