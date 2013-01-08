<?php
include_once("../../conf.php");
// Форма
$logformname = "logform";
$logformact = "aut.do.php";
// Логин
$title_log = "Имя";
$logform_log = SESS_login;
$logvalue_log = "";

// Пароль
$title_pas = "Пароль";
$logform_pas = SESS_pass;
$logvalue_pas = "";

// Кнопка
$title_submit = "";
$logform_submit = "sb";
$logvalue_submit = "Войти";

// Начальная страница сайта (для перехода после авторизации)
$hreffromhere = "aut.inc.php";

// Текст об ошибке
$errtext = "";
?>
