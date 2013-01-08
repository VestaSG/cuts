<?php
include_once( MAIN_CL_DIR . "/conf.php");
$partid = 5;
$deffree = false;

// Имена переменных окружения
define("user_id", "u");
define("part_id", "p");
define("err", "err");

// Ошибки
define("user_err", "1"); // нет пользователя
define("part_err", "2"); // нет раздела
define("free_err", "3"); // нет права
?>
