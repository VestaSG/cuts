<?php
include_once(DBUNIT_MODUL . "/table.class.php");

define("PREF_TAB_TABSUBJ", PREF_TAB . "tabsubj_");
define("TAB_TABSUBJ", PREF_TAB_TABSUBJ . "core");

define("TAB_TABSUBJ_name", "name");

/**
 * ����� ������� ������. ��������� ������ history � ������������ ��� �����������.
 *
 * @author Vesta
 */
class tabsubjects extends dbtabl
{
	function __construct($db)
	{
		parent::__construct($db);
		$this->set_tabname(TAB_TABSUBJ);
		$this->add_field(TAB_TABSUBJ_name, "CHAR(255)");
	}

/**
 * ������� ���������� �������� � ������
 * @param <string> $subname - ��� ����������� �������
 * @return <int>
 */
	function addSubject($subname)
	{
		$isinreg = $this->checkSubjest($subname);
		if($isinreg)
		{
			return $isinreg;
		}
		else
		{
			$this->set(TAB_TABSUBJ_name, $subname);
			$this->dbo->setquery("LOCK TABLES " . $this->tabname . " WRITE;");
			$savd = $this->save();
			$this->dbo->setquery("UNLOCK TABLES;");
			return $savd;
		}
	}

/**
 * ������� �������� ������� ������ � ������ ������� � �������
 * @param <string> $subname - ��� ������� ��� ��������
 * @return <int> - id ������� � �������
 */
	function checkSubjest($subname)
	{
		$selid = $this->dbo->setquery( $this->setselect(TAB_TABSUBJ_name . " = '$subname'") );
		return $this->dbo->out(0, UNIKEY, $selid);
	}
}
?>
