<?php
$css_login = "login.css";
$scr_login = "login.form.php";

define("LOGINTAB", "logs");
// поля таблицы пользователей
define("logtab_log", "user");
define("logtab_pass", "pass");
define("logtab_nic", "nic");
define("logtab_stat", "stat");
define("logtab_salt", "salt"); // в БД: char (10)
define("logtab_mail", "email");
define("logtab_phone", "phone");

// Другие константы системы Login
define("logvalue_0", "Unauthorized");
define("SESS_login", "slog");
define("SESS_pass", "spas");

// *****************************************************************************

define("FREETAB", "freetab");
// поля таблицы прав
define("freetab_id", "id");
define("freetab_free", "free");
define("freetab_user", "iduser");
define("freetab_part", "idpart");

// Права
define("freevalue_reed", 1);
define("freevalue_edit", 2);
define("freevalue_del", 3);
define("freevalue_maid", 4);
?>
