<?php
include_once("db.class.php");

define("START_MOD", 2); // Поумолчательный режим

class trashManager extends db // Класс контроля запросов к БД
{
//#############################################
var $proquery; // Запрос подлежащий обработке
var $themode; // Текущий режим работы объекта класса: 1 - режим фильтра; 2 - прямой режим
var $may; // Статус запроса (если true, то запрос уже обработан)
var $querytype; // Тип запроса (select, delete и тд...)
//#############################################
function trashManager($log, $pass, $the_host, $thebase) // Конструктор
	{
$this->writelog("class trashManager; function trashManager (constructor)"); // Запись лога

	$this->db($log, $pass, $the_host, $thebase);
	$this->setmod(START_MOD);
	$this->may = false;
	$this->querytype = "нету";
	}

//#############################################
function setmod($mod) // Установка режима
	// 1 ~ обычный режим (фильтры)
	// 2 ~ прямой режим (без фильтров)
	{
$this->writelog("class trashManager; function setmod"); // Запись лога

	$this->themode = $mod;
	}

//#############################################
function delrows() // Модификация запросов delete
	{
$this->writelog("class trashManager; function delrows"); // Запись лога

	if($this->querytype != 3) { return false; }
	// запрос вида "DELETE * FROM tab WHERE что-'то';"
	// привести к виду "UPDATE tab SET del='del' WHERE что-то;"
preg_match_all("/DELETE[^;]+FROM ([^ ]+)(;|$|[ ]+)([^;]*)(;|$)/Usi", $this->proquery, $regmas);
	
$siz = sizeof($regmas[1]);
$upd = "";
	for ($i = 0; $i < $siz; $i++)
		{
		$upd.= "UPDATE " . $regmas[1][$i] . " SET del='del' " . $regmas[3][$i] . "; ";
		}
$this->query = $upd;
$this->may = 1;
return true;
	}
	
//#############################################
function tabcreate() // Модификация запросов create table
	{
$this->writelog("class trashManager; function tabcreate"); // Запись лога

	if($this->querytype != 1) { return false; }
// CREATE TABLE table ( del CHAR( 3 ) , ......................
preg_match_all("/(CREATE TABLE[^;]*)\(([^;]*);/Usi", $this->proquery, $regmas);
	
$siz = sizeof($regmas[1]);
$upd = ""; // Тело непосредственного запроса
	for ($i = 0; $i < $siz; $i++)
		{
		$upd.= $regmas[1][$i] . " ( del CHAR( 3 ) , " . $regmas[2][$i] . "; ";
		}
$this->query = $upd;
$this->may = 1;
	}

//#############################################
function select() // Модификация запросов select
// Выбирать все, кроме deleted
	{
$this->writelog("class trashManager; function select"); // Запись лога

	if($this->querytype != 4) { return false; }
preg_match_all("/SELECT[^;]+FROM ([^ ]*)(;|$|[ ]+)(WHERE)*([^;]*)(;|$)/Usi", $this->proquery, $regmas);
	
$siz = sizeof($regmas[1]);
$upd = ""; // Тело непосредственного запроса
	for ($i = 0; $i < $siz; $i++)
		{
		$upd.= "SELECT * FROM " . $regmas[1][$i] . " WHERE del != 'del' ";
if($regmas[3][$i]) { $upd.= " AND "; }
		$upd.=  $regmas[4][$i] . "; ";
		}
$this->query = $upd;
$this->may = 1;
return true;
	}

//#############################################
function addrows() // Модификация запросов insert
	{
$this->writelog("class trashManager; function addrows"); // Запись лога

	if($this->querytype != 5) { return false; }
preg_match_all("/(INSERT|REPLACE) INTO ([^ ]+)( VALUES[^;]*)\(([^;]*);/Usi", $this->proquery, $regmas);
	
$siz = sizeof($regmas[1]);
$upd = "";
	for ($i = 0; $i < $siz; $i++)
		{
		$upd.= $regmas[1][$i] . " INTO " . $regmas[2][$i] . $regmas[3][$i] . " ( 'not', " . $regmas[4][$i] . "; ";
		}
$this->query = $upd;
$this->may = 1;
return true;
	}

//#############################################
function updatrows()
	{
$this->writelog("class trashManager; function updatrows"); // Запись лога
	}

//#############################################
function qtype() // Установка назначения запроса
// 1 ~ Создание новой таблицы
// 2 ~ Модификация имеющейся
// 3 ~ Удаление из таблицы
// 4 ~ select
// 5 ~ Добавление записей в таблицу
	{
$this->writelog("class trashManager; function qtype"); // Запись лога

$pro = strtolower($this->proquery); // Строчку в нижний регистр!
//	if( stripos($pro, "union") ) { return "un"; }
	if( (substr_count($pro, "create")) && (substr_count($pro, "table")) ) { $this->querytype = 1; return 1; }
	if( substr_count($pro, "update") ) { $this->querytype = 2; return 2; }
	if( substr_count($pro, "delete") ) { $this->querytype = 3; return 3; }
	if( substr_count($pro, "select") ) { $this->querytype = 4; return 4; }
	if( (substr_count($pro, "insert")) || (substr_count($pro, "replace")) ) { $this->querytype = 5; return 5; }
	}

//#############################################
function setquery($pro) // запрос
	{
$this->writelog("class trashManager; function setquery"); // Запись лога

$this->proquery = $pro;
return $this->execute();
	}

//#############################################
function execute()
	{
$this->writelog("class trashManager; function execute"); // Запись лога

if($this->themode == 1)
		{
	// query processing
$processquery = $this->proquery;
	$qstst = $this->qtype();
//	echo($this->querytype . "<br>" );
$processquery = str_replace("     ", " ", $processquery);
$processquery = str_replace("    ", " ", $processquery);
$processquery = str_replace("   ", " ", $processquery);
$processquery = str_replace("  ", " ", $processquery);
$this->proquery = $processquery;
// сюда функции процессинга
$processed = 0;
if( $this->delrows() ) { ++$processed; }
if( $this->tabcreate() ) { ++$processed; }
if( $this->select() ) { ++$processed; } // Если запрос select, то функция возвращает номер ответа, под которым он записан в массив ответов
if( $this->addrows() ) { ++$processed; }
if( $this->updatrows() ) { ++$processed; }
if($processed == 0) { $this->query = $this->proquery; $this->may = true; }
		} else { $this->query = $this->proquery; $this->may = true; }
if($this->may) { return db::execute(); }
return false;
	}

//#############################################
function setdelfield($intab) // Модификация таблицы (добавление поля del)
	{
$this->writelog("class trashManager; function setdelfield"); // Запись лога

if(!$this->setquery("SELECT * FROM $intab LIMIT 1 ; "))
		{
$addquery = "ALTER TABLE $intab ADD COLUMN del CHAR( 3 ) FIRST;";
$setquery = "UPDATE $intab SET del = 'not' ;";

	$modis = $this->themode; // Запомним текущий режим
$this->setmod(2); // Установим прямой режим

if( $this->setquery($addquery) )
{ if( $this->setquery($setquery) ) { $this->setmod($modis); return true; } }
		$this->setmod($modis); // Вернем на место режим
		}
	return false;
	}

//#############################################
function clear($tab) // Очистка корзины
	{
$this->writelog("class trashManager; function clear"); // Запись лога

	$modis = $this->themode; // Запомним текущий режим
$this->setmod(2); // Установим прямой режим
$retn = $this->setquery("DELETE * FROM $tab WHERE del = 'del';");
$this->setmod($modis); // Вернем на место режим
return $retn;
}

//#############################################
function backall($tab) // Восстановление всего
	{
$this->writelog("class trashManager; function backall"); // Запись лога

	$modis = $this->themode; // Запомним текущий режим
$this->setmod(2); // Установим прямой режим
$retn = $this->setquery("UPDATE $tab SET del='not' ;");
$this->setmod($modis); // Вернем на место режим
return $retn;
	}

//#############################################
function showdel($tab) // Показать удаленные
	{
$this->writelog("class trashManager; function showdel"); // Запись лога

	$modis = $this->themode; // Запомним текущий режим
$this->setmod(2); // Установим прямой режим
$retn = $this->setquery("SELECT * FROM $tab WHERE del = 'del' ;"); // Выберем все удаленные
$this->setmod($modis); // Вернем на место режим
return $retn;
	}
}
?>
