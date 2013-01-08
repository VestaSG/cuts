<?php
// CONFIG
// Таблица изменений
define("TAB_changes", "changes"); // Имя таблицы
// имена полей таблицы изменений
define("changes_id", "id");
define("changes_tabname", "tab");
define("changes_uid", "uid");
define("changes_uname", "uname");
define("changes_dtt", "dtt");
define("changes_pid", "pid");

// Таблица присвоенных значений
define("TAB_setvals", "change_units"); // Имя таблицы
// имена полей таблицы
define("setvals_id", "id");
define("setvals_cangeid", "chid");
define("setvals_cellname", "cell");
define("setvals_val", "val");

// CLASS
class history
{
	var $dbo; // объект БД
	//var $changes; // изменения $changes[id]["id"] $changes[id]["date"] $changes[id]["user"] 
	// массив не нужен. он существует в объекте работы с БД
	var $forid; // в каком разделе изменения
	var $dbid; // id запроса выборки из БД
	var $histleng; // количество событий в выбранном разделе истории
}

class change
{
	var $dbo; // объект БД
	var $id; // id изменения
	var $dbid; // id запроса выборки из БД
	var $unitsleng; // количество операций в изменении
	var $tab; // В какой таблице изменение
	var $uid; // Пользователь
	var $vals; // массив новых изменений
	var $newvalsleng; // сколько уже новых значений

	function change($dbobj)
	{
		$this->dbo = $dbobj;
		$this->vals = array();
		$this->newvalsleng = 0;
	}

	function setid($id)
	{
//		$outq = "SELECT * FROM " . TABNAME . " WHERE $param ;";
		$this->dbo->setquery($outq);
	}
	
	function setval($cellname, $setval)
	{
		$this->vals[$this->newvalsleng][setvals_cellname] = $cellname;
		$this->vals[$this->newvalsleng][setvals_val] = $setval;
		++$this->newvalsleng;
	}
	
	function savequery($forchid) // priv
	{ // ф-я формирования запроса добавления значений полей
		$q = "";
		for($it = 0; $it < $this->newvalsleng; ++$it)
		{
			$q = $q . "INSERT INTO " . TAB_setvals . " ( " . setvals_cangeid . ", " . setvals_cellname . ", " . setvals_val . " ) VALUES ('$forchid', '" . $this->vals[$it][setvals_cellname] . "', '" . $this->vals[$it][setvals_val] . "') ; ";
		}
		return $q;
	}

	function lost_chengeid() // priv
	{ // последнее добавленное изменение
		$this->dbo->setquery( "SELECT ". changes_id ." FROM " . TAB_changes . " ORDER BY ". changes_id ." DESC LIMIT 1 ;" );
		return $this->dbo->out(0, changes_id);
	}

	function savechange($uid, $pid, $uname, $tab)
	{
		if($this->newvalsleng > 0)
		{
			$insq = "INSERT INTO " . TAB_changes . " VALUES (NULL, '$tab', $uid, '$uname', NOW(), $pid)";
			$this->dbo->setquery($insq);
			$this->dbo->setquery($this->savequery($this->lost_chengeid()));
		}
	}
}

// INIT
?>
