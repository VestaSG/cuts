<?php
$the_host = 'localhost'; // Host name
$mysqluser = "serzh28"; // ��� ������� � MySQL-�������
$the_pass = ''; // ������ ������� � MySQL-�������
$base_name = "cut-fork"; // ��� ��

define("LOG_STATUS", 0); // ������ ������� �����. 0 ~ ���� ���������. 1 ~ ����� ����� � ������������, 2 ~ ������ ����� � ���� ������������ LOG_FILE, 3 ~ ������ ����� � ������� ��, ������������ LOG_TAB
define("LOG_FILE", "logs.txt");
define("LOG_TAB", "syslogtab");
define("SQLLOG_STATUS", 0); // 0 ~ ���� ���������., 1 ~ ������ ����� � ���� ������������ SQLLOG_FILE
define("SQLLOG_FILE",  LOGS_DIR . "/mysqllogs.txt");
?>
