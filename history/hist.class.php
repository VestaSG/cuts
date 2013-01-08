<?php
// CONFIG
// ������� ���������
define("TAB_changes", "changes"); // ��� �������
// ����� ����� ������� ���������
define("changes_id", "id");
define("changes_tabname", "tab");
define("changes_uid", "uid");
define("changes_uname", "uname");
define("changes_dtt", "dtt");
define("changes_pid", "pid");

// ������� ����������� ��������
define("TAB_setvals", "change_units"); // ��� �������
// ����� ����� �������
define("setvals_id", "id");
define("setvals_cangeid", "chid");
define("setvals_cellname", "cell");
define("setvals_val", "val");

// CLASS
class history
{
	var $dbo; // ������ ��
	//var $changes; // ��������� $changes[id]["id"] $changes[id]["date"] $changes[id]["user"] 
	// ������ �� �����. �� ���������� � ������� ������ � ��
	var $forid; // � ����� ������� ���������
	var $dbid; // id ������� ������� �� ��
	var $histleng; // ���������� ������� � ��������� ������� �������
}

class change
{
	var $dbo; // ������ ��
	var $id; // id ���������
	var $dbid; // id ������� ������� �� ��
	var $unitsleng; // ���������� �������� � ���������
	var $tab; // � ����� ������� ���������
	var $uid; // ������������
	var $vals; // ������ ����� ���������
	var $newvalsleng; // ������� ��� ����� ��������

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
	{ // �-� ������������ ������� ���������� �������� �����
		$q = "";
		for($it = 0; $it < $this->newvalsleng; ++$it)
		{
			$q = $q . "INSERT INTO " . TAB_setvals . " ( " . setvals_cangeid . ", " . setvals_cellname . ", " . setvals_val . " ) VALUES ('$forchid', '" . $this->vals[$it][setvals_cellname] . "', '" . $this->vals[$it][setvals_val] . "') ; ";
		}
		return $q;
	}

	function lost_chengeid() // priv
	{ // ��������� ����������� ���������
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
