<?php
// HTTP-директории
define("adm_pub_dir", SITE_INDEX . "?pid=" . $mobj->outid()); // Морда раздела
define("adm_pub_hr", adm_pub_dir . "&amp;a=hr"); // Права. u=1 - пользователь, p=1 - раздел
define("adm_pub_userdo", adm_pub_dir . "&amp;a=udo" ); // Обработчик пользователя
define("adm_pub_rightsdo", adm_pub_hr . "&amp;b=do" ); // Обработчик прав

// Имена переменных
define("user_id", "u");
define("part_id", "p");
define("err", "err");

// Ошибки
define("user_err", "1"); // нет пользователя
define("part_err", "2"); // нет раздела
define("free_err", "3"); // нет права
?>
