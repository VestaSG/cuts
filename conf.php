<?php
// ���������
setlocale(LC_ALL, 'ru_RU.CP1251');
// setlocale(LC_ALL, 'ru_RU.UTF-8');
define("META_charset", "windows-1251"); // ���� meta
define("DB_collate", "cp1251_general_ci"); // db fields collate

ini_set('display_errors', 1); // ���������� ������
ini_set('error_reporting', E_ALL & ~E_NOTICE); // ��������������
// ini_set('error_reporting', E_ERROR); // ������������ ������

// ���������� ������
define("SITE_INDEX", "/cut-fork/"); // ������, � ����������� �� ������ �����
define("AUT_INDEX", SITE_INDEX."login/authorization/aut.inc.php");
define("USERS_INDEX", SITE_INDEX."login/useradmin/useradmin.inc.php");
define("NEWPART_INDEX", SITE_INDEX."menu/edit.menu.inc.php");
define("NEWUSER_INDEX", SITE_INDEX."login/useradmin/useradmin.inc.php?u=new");
define("SITE_ERR_404", SITE_INDEX."?err=404"); // ������ ������ ��� ��������
define("SITE_ERR_403", SITE_INDEX."?err=403");

// �������� ������
// define("PREF_TAB", ""); // ������� ���� ������
define("PREF_TAB", "cl_");
?>
