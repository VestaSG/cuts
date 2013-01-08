<?php
include_once("db.class.php");

define("START_MOD", 2); // ��������������� �����

class trashManager extends db // ����� �������� �������� � ��
{
//#############################################
var $proquery; // ������ ���������� ���������
var $themode; // ������� ����� ������ ������� ������: 1 - ����� �������; 2 - ������ �����
var $may; // ������ ������� (���� true, �� ������ ��� ���������)
var $querytype; // ��� ������� (select, delete � ��...)
//#############################################
function trashManager($log, $pass, $the_host, $thebase) // �����������
	{
$this->writelog("class trashManager; function trashManager (constructor)"); // ������ ����

	$this->db($log, $pass, $the_host, $thebase);
	$this->setmod(START_MOD);
	$this->may = false;
	$this->querytype = "����";
	}

//#############################################
function setmod($mod) // ��������� ������
	// 1 ~ ������� ����� (�������)
	// 2 ~ ������ ����� (��� ��������)
	{
$this->writelog("class trashManager; function setmod"); // ������ ����

	$this->themode = $mod;
	}

//#############################################
function delrows() // ����������� �������� delete
	{
$this->writelog("class trashManager; function delrows"); // ������ ����

	if($this->querytype != 3) { return false; }
	// ������ ���� "DELETE * FROM tab WHERE ���-'��';"
	// �������� � ���� "UPDATE tab SET del='del' WHERE ���-��;"
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
function tabcreate() // ����������� �������� create table
	{
$this->writelog("class trashManager; function tabcreate"); // ������ ����

	if($this->querytype != 1) { return false; }
// CREATE TABLE table ( del CHAR( 3 ) , ......................
preg_match_all("/(CREATE TABLE[^;]*)\(([^;]*);/Usi", $this->proquery, $regmas);
	
$siz = sizeof($regmas[1]);
$upd = ""; // ���� ����������������� �������
	for ($i = 0; $i < $siz; $i++)
		{
		$upd.= $regmas[1][$i] . " ( del CHAR( 3 ) , " . $regmas[2][$i] . "; ";
		}
$this->query = $upd;
$this->may = 1;
	}

//#############################################
function select() // ����������� �������� select
// �������� ���, ����� deleted
	{
$this->writelog("class trashManager; function select"); // ������ ����

	if($this->querytype != 4) { return false; }
preg_match_all("/SELECT[^;]+FROM ([^ ]*)(;|$|[ ]+)(WHERE)*([^;]*)(;|$)/Usi", $this->proquery, $regmas);
	
$siz = sizeof($regmas[1]);
$upd = ""; // ���� ����������������� �������
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
function addrows() // ����������� �������� insert
	{
$this->writelog("class trashManager; function addrows"); // ������ ����

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
$this->writelog("class trashManager; function updatrows"); // ������ ����
	}

//#############################################
function qtype() // ��������� ���������� �������
// 1 ~ �������� ����� �������
// 2 ~ ����������� ���������
// 3 ~ �������� �� �������
// 4 ~ select
// 5 ~ ���������� ������� � �������
	{
$this->writelog("class trashManager; function qtype"); // ������ ����

$pro = strtolower($this->proquery); // ������� � ������ �������!
//	if( stripos($pro, "union") ) { return "un"; }
	if( (substr_count($pro, "create")) && (substr_count($pro, "table")) ) { $this->querytype = 1; return 1; }
	if( substr_count($pro, "update") ) { $this->querytype = 2; return 2; }
	if( substr_count($pro, "delete") ) { $this->querytype = 3; return 3; }
	if( substr_count($pro, "select") ) { $this->querytype = 4; return 4; }
	if( (substr_count($pro, "insert")) || (substr_count($pro, "replace")) ) { $this->querytype = 5; return 5; }
	}

//#############################################
function setquery($pro) // ������
	{
$this->writelog("class trashManager; function setquery"); // ������ ����

$this->proquery = $pro;
return $this->execute();
	}

//#############################################
function execute()
	{
$this->writelog("class trashManager; function execute"); // ������ ����

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
// ���� ������� �����������
$processed = 0;
if( $this->delrows() ) { ++$processed; }
if( $this->tabcreate() ) { ++$processed; }
if( $this->select() ) { ++$processed; } // ���� ������ select, �� ������� ���������� ����� ������, ��� ������� �� ������� � ������ �������
if( $this->addrows() ) { ++$processed; }
if( $this->updatrows() ) { ++$processed; }
if($processed == 0) { $this->query = $this->proquery; $this->may = true; }
		} else { $this->query = $this->proquery; $this->may = true; }
if($this->may) { return db::execute(); }
return false;
	}

//#############################################
function setdelfield($intab) // ����������� ������� (���������� ���� del)
	{
$this->writelog("class trashManager; function setdelfield"); // ������ ����

if(!$this->setquery("SELECT * FROM $intab LIMIT 1 ; "))
		{
$addquery = "ALTER TABLE $intab ADD COLUMN del CHAR( 3 ) FIRST;";
$setquery = "UPDATE $intab SET del = 'not' ;";

	$modis = $this->themode; // �������� ������� �����
$this->setmod(2); // ��������� ������ �����

if( $this->setquery($addquery) )
{ if( $this->setquery($setquery) ) { $this->setmod($modis); return true; } }
		$this->setmod($modis); // ������ �� ����� �����
		}
	return false;
	}

//#############################################
function clear($tab) // ������� �������
	{
$this->writelog("class trashManager; function clear"); // ������ ����

	$modis = $this->themode; // �������� ������� �����
$this->setmod(2); // ��������� ������ �����
$retn = $this->setquery("DELETE * FROM $tab WHERE del = 'del';");
$this->setmod($modis); // ������ �� ����� �����
return $retn;
}

//#############################################
function backall($tab) // �������������� �����
	{
$this->writelog("class trashManager; function backall"); // ������ ����

	$modis = $this->themode; // �������� ������� �����
$this->setmod(2); // ��������� ������ �����
$retn = $this->setquery("UPDATE $tab SET del='not' ;");
$this->setmod($modis); // ������ �� ����� �����
return $retn;
	}

//#############################################
function showdel($tab) // �������� ���������
	{
$this->writelog("class trashManager; function showdel"); // ������ ����

	$modis = $this->themode; // �������� ������� �����
$this->setmod(2); // ��������� ������ �����
$retn = $this->setquery("SELECT * FROM $tab WHERE del = 'del' ;"); // ������� ��� ���������
$this->setmod($modis); // ������ �� ����� �����
return $retn;
	}
}
?>
