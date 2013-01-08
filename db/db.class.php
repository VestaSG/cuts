<?php
include_once(FUNC_DIR . "/writelog.func.php");

class queryarray // ����� ������� ���������� ������� select... (������ ������ ������ � ������ ������ ��)
{
	var $response; // ������ ������ �� ������
	var $num; // ���������� ����� � �������

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

class db // ����� ���� ������
{
	var $host; // ��� �����
	var $mysqllog; // ����� ��� ������� � ������� MySQL
	var $mysqlpass; // ������ ��� ������� � ������� MySQL
	var $bd; // ��� ���� ������
	var $tab; // ��� �������
	var $query; // ������ �������
	var $selected; // ������ ��������� �� �� ������
	var $conn; // ������������� ����������
	var $resparr; // ������ ������� �� �������
	var $num; // ���������� �������

	function writelog($strlog) // ������� ������� �����
	{
		if(LOG_STATUS != 0)
		{
			$dt = date("Y-m-d H:i:s");
			$micro = " " . substr(microtime(), 2, 3) . "";
			if(LOG_STATUS == 1)
			{
			// ����� ���� �� �����
				$log = $dt . $micro . "; " . $strlog . " <br>";
				echo($log);
				return true;
			}
		}
		return false;
	}

	function db($log, $pass, $the_host, $thebase) // �����������
	{
		$this->writelog("class " . __CLASS__ . "; function " . __FUNCTION__ . " (constructor)"); // ������ ����

		$this->host = $the_host;
		$this->mysqllog = $log;
		$this->mysqlpass = $pass;

		$this->serverconnect();
		$this->setdb($thebase);
	}

	function execute() // ���������� ������ �������
	{
		$this->writelog("class " . __CLASS__ . "; function " . __FUNCTION__); // ������ ����

		//	echo("��������� ������<br>");

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
			{ // ���� ��� select, �� ����� �������� ������� �����
				$num = mysql_num_rows($resp); // ���������� �����
				$this->resparr[$this->num] = new queryarray();
				++$this->num; // ��������� ���������� ���������� ����������� select
				$thisnum = $this->num - 1; // ������ �������� ������� � ������� resparr[]
				if($num)
				{
					//	echo("������ ������� ������<br>");
					for($it = 0; $it < $num; ++$it) // ���������� ������� �����������
					{
						$therow = mysql_fetch_array($resp);
						$this->resparr[$thisnum]->addrow($therow);
					}
				}
				return $this->num - 1; // ���� ��������� ������� select, �� ���������� id ����������
			}
			//	echo("������ ��������<br>");
			return true;
		}
		//	echo("������ ��������<br>");
		return false;
	}

	function outcount($querynum="notset") // ������� ������� �������
	//	$querynum - ����� �������
	{
		$this->writelog("class " . __CLASS__ . "; function " . __FUNCTION__); // ������ ����

		if(!$this->num){return false;}
		if("$querynum" == "notset") {$querynum = $this->num - 1;} // ����� ���������� �������
		return $this->resparr[$querynum]->getcount();
	}

	function out($num, $nam, $querynum="notset") // ������� �������� �������
	//	$querynum - ����� �������
	//	$num - ����� ������ ������
	//	$nam - ��� ���������� � ������ (��� ���� ��)
	{
		$this->writelog("class " . __CLASS__ . "; function " . __FUNCTION__); // ������ ����

		if(!$this->num){return false;}
		if("$querynum" == "notset") {$querynum = $this->num - 1;} // ����� ���������� �������
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
		$this->writelog("class " . __CLASS__ . "; function " . __FUNCTION__); // ������ ����

		if($qry){ $this->query = $qry; }
		if($this->query != "nan") { return $this->execute(); }
		return false;
	}

	function setdb($thebase) // ��������� ���������� (�����) �� � ����������
	{
		$this->writelog("class " . __CLASS__ . "; function " . __FUNCTION__); // ������ ����

		$this->query = "nan"; // ��������� ������ ������� � �������� ��������� (��� �������)
		$this->bd = $thebase;
		$this->dbconnect();
	}

	function serverconnect() // �-� ���������� � MySQL-��������
	{
		$this->writelog("class " . __CLASS__ . "; function " . __FUNCTION__); // ������ ����

		$the_host = $this->host;
		$log = $this->mysqllog;
		$pass = $this->mysqlpass;

		// ��������� ���������� � �������� MySQL
		$this->conn = mysql_connect($the_host, $log, $pass)
		or die("������ ��� ���������� � MySQL ��������<br>");
	}

	function dbconnect() // �-� ���������� � ��
	{
		$this->writelog("class " . __CLASS__ . "; function " . __FUNCTION__); // ������ ����

			// ��������� ���������� � ��
		mysql_select_db($this->bd, $this->conn)
		or die("������ ��� ���������� � �� <br>" . $this->bd);
		$this->resparr = array();
		$this->num = 0; // � ������� ������ ���
		//	echo("���������� � ��<br>");
	}

	function istab($tname) // �-� �������� ������� ������� � ��
	{
		$this->writelog("class " . __CLASS__ . "; function " . __FUNCTION__); // ������ ����
		return mysql_query("SELECT * FROM $tname LIMIT 0;");
	}

	function isfield($tabname, $fieldname) // �-� �������� ������� ���� � �������
	{
		$this->writelog("class " . __CLASS__ . "; function " . __FUNCTION__); // ������ ����
		return mysql_query("SELECT $fieldname FROM $tabname LIMIT 0;");
	}

	function disconnect() // ���������� ���������� � MySQL-��������
	{
		$this->writelog("class " . __CLASS__ . "; function " . __FUNCTION__); // ������ ����

		mysql_close($this->conn);
		$this->query = "nan"; // ��������� ������ ������� � �������� ��������� (��� �������)
		$this->num = 0; // � ������� ������ ���
		unset($this->resparr); // ���������� ������� �����������
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
