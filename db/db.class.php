<?php
include_once(FUNC_DIR . "/writelog.func.php");

class queryarray // Класс массива результата запроса select... (объект класса входит в состав класса БД)
{
	var $response; // Массив ответа на запрос
	var $num; // Количество строк в запросе

	function queryarray()
	{
		$this->response = array();
		$this->num = 0;
	}

	function addrow($row)
	{
		$this->response[] = $row;
		++$this->num;
	}

	function getrow($it)
	{
		if($it < $this->num){return $this->response[$it];}
		return false;
	}

	function getcount()
	{
		return $this->num;
	}

	function getrowvar($it, $varnam)
	{
		if($it < $this->num)
		{
			$therow = $this->getrow($it);
			return $therow["$varnam"];
		}
		return false;
	}
}

class db // Класс базы данных
{
	var $host; // Имя хоста
	var $mysqllog; // Логин для доступа с серверу MySQL
	var $mysqlpass; // Пароль для доступа с серверу MySQL
	var $bd; // Имя базы данных
	var $tab; // Имя таблицы
	var $query; // Строка запроса
	var $selected; // Массив выбланных из БД данных
	var $conn; // Идентификатор соединения
	var $resparr; // Массив ответов на запросы
	var $num; // Количество ответов

	function writelog($strlog) // функция ведения логов
	{
		if(LOG_STATUS != 0)
		{
			$dt = date("Y-m-d H:i:s");
			$micro = " " . substr(microtime(), 2, 3) . "";
			if(LOG_STATUS == 1)
			{
			// Вывод лога на экран
				$log = $dt . $micro . "; " . $strlog . " <br>";
				echo($log);
				return true;
			}
		}
		return false;
	}

	function db($log, $pass, $the_host, $thebase) // Конструктор
	{
		$this->writelog("class " . __CLASS__ . "; function " . __FUNCTION__ . " (constructor)"); // Запись лога

		$this->host = $the_host;
		$this->mysqllog = $log;
		$this->mysqlpass = $pass;

		$this->serverconnect();
		$this->setdb($thebase);
	}

	function execute() // Выполнение общего запроса
	{
		$this->writelog("class " . __CLASS__ . "; function " . __FUNCTION__); // Запись лога

		//	echo("Выполняем запрос<br>");

		if($this->query != "nan")
		{
			$resp = mysql_query($this->query, $this->conn);
			$this->SqlLog($this->query);
			if(!$resp)
			{
				$this->writelog("Error in class db; function execute, error query: " . $this->query);
				return false;
			}

			if(substr(str_replace(" ", "", strtolower($this->query)), 0, 6) == "select")
			{ // Если был select, то можно смотреть сколько строк
				$num = mysql_num_rows($resp); // Количество строк
				$this->resparr[$this->num] = new queryarray();
				++$this->num; // Установка количества полученных результатов select
				$thisnum = $this->num - 1; // индекс текущего запроса в массиве resparr[]
				if($num)
				{
					//	echo("Запрос получил массив<br>");
					for($it = 0; $it < $num; ++$it) // Наполнение массива результатов
					{
						$therow = mysql_fetch_array($resp);
						$this->resparr[$thisnum]->addrow($therow);
					}
				}
				return $this->num - 1; // Если результат запроса select, то возвращать id последнего
			}
			//	echo("Запрос выполнен<br>");
			return true;
		}
		//	echo("Запрос неудачен<br>");
		return false;
	}

	function outcount($querynum="notset") // Возврат размера массива
	//	$querynum - номер запроса
	{
		$this->writelog("class " . __CLASS__ . "; function " . __FUNCTION__); // Запись лога

		if(!$this->num){return false;}
		if("$querynum" == "notset") {$querynum = $this->num - 1;} // Номер последнего запроса
		return $this->resparr[$querynum]->getcount();
	}

	function out($num, $nam, $querynum="notset") // Возврат значения массива
	//	$querynum - номер запроса
	//	$num - номер строки ответа
	//	$nam - имя переменной в строке (имя поля бд)
	{
		$this->writelog("class " . __CLASS__ . "; function " . __FUNCTION__); // Запись лога

		if(!$this->num){return false;}
		if("$querynum" == "notset") {$querynum = $this->num - 1;} // Номер последнего запроса
		//echo(count($this->resparr) . "<br>");
		return $this->resparr[$querynum]->getrowvar($num, $nam);
	}

	function cleen($sel_id)
	{
		if( isset($this->resparr[$sel_id]) )
		{
			unset($this->resparr[$sel_id]);
		}
	}

	function setquery($qry)
	{
		$this->writelog("class " . __CLASS__ . "; function " . __FUNCTION__); // Запись лога

		if($qry){ $this->query = $qry; }
		if($this->query != "nan") { return $this->execute(); }
		return false;
	}

	function setdb($thebase) // Установка параметров (имени) БД и соединение
	{
		$this->writelog("class " . __CLASS__ . "; function " . __FUNCTION__); // Запись лога

		$this->query = "nan"; // Установка строки запроса в исходное состояние (нет запроса)
		$this->bd = $thebase;
		$this->dbconnect();
	}

	function serverconnect() // Ф-я соединения с MySQL-сервером
	{
		$this->writelog("class " . __CLASS__ . "; function " . __FUNCTION__); // Запись лога

		$the_host = $this->host;
		$log = $this->mysqllog;
		$pass = $this->mysqlpass;

		// Выполняем соединение с сервером MySQL
		$this->conn = mysql_connect($the_host, $log, $pass)
		or die("Ошибка при соединении с MySQL сервером<br>");
	}

	function dbconnect() // Ф-я соединения с БД
	{
		$this->writelog("class " . __CLASS__ . "; function " . __FUNCTION__); // Запись лога

			// Выполняем соединение с БД
		mysql_select_db($this->bd, $this->conn)
		or die("Ошибка при соединении с БД <br>" . $this->bd);
		$this->resparr = array();
		$this->num = 0; // В массиве ничего нет
		//	echo("Соединение с БД<br>");
	}

	function istab($tname) // Ф-я проверки наличия таблицы в БД
	{
		$this->writelog("class " . __CLASS__ . "; function " . __FUNCTION__); // Запись лога
		return mysql_query("SELECT * FROM $tname LIMIT 0;");
	}

	function isfield($tabname, $fieldname) // Ф-я проверки наличия поля в таблице
	{
		$this->writelog("class " . __CLASS__ . "; function " . __FUNCTION__); // Запись лога
		return mysql_query("SELECT $fieldname FROM $tabname LIMIT 0;");
	}

	function disconnect() // Завершение соединения с MySQL-сервером
	{
		$this->writelog("class " . __CLASS__ . "; function " . __FUNCTION__); // Запись лога

		mysql_close($this->conn);
		$this->query = "nan"; // Установка строки запроса в исходное состояние (нет запроса)
		$this->num = 0; // В массиве ничего нет
		unset($this->resparr); // Ликвидация массива результатов
	}

	protected function SqlLog($logst)
	{
		if(SQLLOG_STATUS > 0)
		{
			$logst = date("Y-m-d H:i:s") . " \"" . $logst;
			$logst = str_replace("\n", " ", $logst);
			while(strstr($logst, "  "))
			{
				$logst = str_replace("  ", " ", $logst);
			}
			wrtxt(SQLLOG_FILE, $logst . "\"\n");
		}
	}
}
?>
