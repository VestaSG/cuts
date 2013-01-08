<?php
$the_host = 'localhost'; // Host name
$mysqluser = "serzh28"; // Имя доступа к MySQL-серверу
$the_pass = ''; // Пароль доступа к MySQL-серверу
$base_name = "cut-fork"; // Имя БД

define("LOG_STATUS", 0); // Способ ведение логов. 0 ~ Логи отключены. 1 ~ Вывод логов в обозреватель, 2 ~ Запись логов в файл определенный LOG_FILE, 3 ~ Запись логов в таблицу БД, определенную LOG_TAB
define("LOG_FILE", "logs.txt");
define("LOG_TAB", "syslogtab");
define("SQLLOG_STATUS", 0); // 0 ~ Логи отключены., 1 ~ Запись логов в файл определенный SQLLOG_FILE
define("SQLLOG_FILE",  LOGS_DIR . "/mysqllogs.txt");
?>
