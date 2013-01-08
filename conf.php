<?php
// Кодировки
setlocale(LC_ALL, 'ru_RU.CP1251');
// setlocale(LC_ALL, 'ru_RU.UTF-8');
define("META_charset", "windows-1251"); // теги meta
define("DB_collate", "cp1251_general_ci"); // db fields collate

ini_set('display_errors', 1); // Показывать ошибки
ini_set('error_reporting', E_ALL & ~E_NOTICE); // Разработческий
// ini_set('error_reporting', E_ERROR); // Неустранимые ошибки

// Клиентские адреса
define("SITE_INDEX", "/cut-fork/"); // Менять, в зависимости от адреса сайта
define("AUT_INDEX", SITE_INDEX."login/authorization/aut.inc.php");
define("USERS_INDEX", SITE_INDEX."login/useradmin/useradmin.inc.php");
define("NEWPART_INDEX", SITE_INDEX."menu/edit.menu.inc.php");
define("NEWUSER_INDEX", SITE_INDEX."login/useradmin/useradmin.inc.php?u=new");
define("SITE_ERR_404", SITE_INDEX."?err=404"); // адреса ошибок для браузера
define("SITE_ERR_403", SITE_INDEX."?err=403");

// Префиксы таблиц
// define("PREF_TAB", ""); // Префикс всех таблиц
define("PREF_TAB", "cl_");
?>
