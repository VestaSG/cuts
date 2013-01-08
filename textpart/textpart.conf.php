<?php
// define("DIR_CONF", "../dir.conf.php");
?>
<?php
define("TEXTTAB", "text_tab");
// поля таблицы пользователей
define("texttab_id", "id"); // id
define("texttab_head", "name"); // Поле заголовка
define("texttab_body", "body"); // Тело
define("texttab_in", "inid"); // Раздел, в котором данный является подразделом
define("texttab_date", "dtt"); // Дата создания
define("texttab_moddate", "moddtt"); // Дата изменения
define("texttab_ishid", "ishid"); // Является ли раздел скрытым
define("texttab_attid", "attachid"); // Идентификатор приаттаченного файла
define("texttab_lang", "lang"); // Язык раздела

// Внешние пути
define("pub_tex_face", SITE_INDEX . "?pid=" . $mobj->outid());
define("pub_tex_addfile", pub_tex_face . "&amp;a=adf");
define("pub_tex_delfile", pub_tex_face . "&amp;a=df");
?>
