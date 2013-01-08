<?php
include_once(FUNC_DIR . "/writelog.func.php");
include_once(FUNC_DIR . "/strisint.func.php");

// ������������ �����:
define("TAB_TYPE_DEFAULT", "MyISAM");
define("TABFIELDS_NAME", "name");
define("TABFIELDS_TYPE", "type");
define("TABFIELDS_KEY", "iskey");
define("TABFIELDS_FFT", "fft"); // FORM FIELD TYPE (��� ���� �����)
define("TABFIELDS_FFSign", "ffs"); // FORM FIELD Signature (������� ���� �����)
define("UNIKEY", "id");
define("KEYTYPE", "INT");
/**
����� ������������� �������� ������� ������ ��������� ����.
�������� ����� �������� ������ ���� INT.
 * @package dbunit
 * @version 1.0
 * @author ������ ������ �����������
*/
class dbtabl
{
	protected $tosave; // �����. ������ ��� ����������
	protected $dbo; // ������ ��
	protected $select_id; // id ������� select
	protected $tabname; // ��� �������
	protected $tabtype; // ��� ������� (MyISAM, InnoDB � ��.)
	protected $ifields; // priv
	protected $keyfield; // �������� ����. INT
	protected $tabfields; // ������ ����� ���������: $tabfields[i][name], $tabfields[i][type] ("CHAR ( 250 )"), $tabfields[i][key] (true/false)
	protected $fields_id; // ������ ����� ���������: $tabfields[i][name], $tabfields[i][type] ("CHAR ( 250 )"), $tabfields[i][key] (true/false)

	function __construct($db_obj) // � ����������� �������� � ������ �� ������������
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		$this->dbo = $db_obj;
		$this->tosave = array();
		$this->tabfields = array();
		$this->fields_id = array();
		$this->keyfield = UNIKEY;
		$this->ifields = 0;
		$this->tabtype = TAB_TYPE_DEFAULT;
	}

	function __call($funcname, $vararray)
	{
		writelog("class " . __CLASS__ . "; function $funcname NOT FOUND");
		return false;
	}

	protected function set_tabname($nm)
	{
		$this->tabname = $nm;
	}

	function out_tabname()
	{
		return $this->tabname;
	}

	protected function set_tabtype($nm)
	{
		$this->tabtype = $nm;
	}

	/**
	 * ������� ����������� ������ ���� �������. ��� ������������� � ������������� �����������.
	 * @param string $name - ��� ����
	 * @param string $type - ��� ����
	 * @param bool $iskey - ���� �������� ������
	 * @return bool
	 */
	final protected function add_field($name, $type, $iskey=false, $FormFieldType=false, $FormFieldSign="")
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		if($name == UNIKEY){ return false; }
		$this->tabfields[$this->ifields] = array();
		$this->tabfields[$this->ifields][TABFIELDS_NAME] = $name;
		$this->tabfields[$this->ifields][TABFIELDS_TYPE] = $type;
		$this->tabfields[$this->ifields][TABFIELDS_KEY] = $iskey;
		// �������� ��� ����
		$this->tabfields[$this->ifields][TABFIELDS_FFT] = $FormFieldType;
		$this->tabfields[$this->ifields][TABFIELDS_FFSign] = $FormFieldSign;

		$this->fields_id[$name] = $this->ifields;
		++$this->ifields;
		return true;
	}

	/**
	 * ��������� ������� ���� ������. ���� ������� ������� ������� ��� ��� ���� - ������� true
	 * @return bool
	 */
	protected function core_install()
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		$does = 0;
		if( !$this->dbo->istab($this->tabname) )
		{
			$create_query = "CREATE TABLE " . $this->tabname . " ( " . $this->keyfield . " " . KEYTYPE . " NOT NULL AUTO_INCREMENT , PRIMARY KEY ( " . $this->keyfield . " ) ) TYPE = " . $this->tabtype . ";";
			if($this->dbo->setquery($create_query)) // ������ �������� ������� � ��
			{
				++$does;
			}
		}
		for($i = 0; $i < $this->ifields; ++$i)
		{
			$collate = " COLLATE '" .DB_collate. "'";
			if(substr_count(strtolower($this->tabfields[$i][TABFIELDS_TYPE]), "blob"))
			{
				$collate = "";
			}
			$add_query = "ALTER TABLE " . $this->tabname . " ADD " . $this->tabfields[$i][TABFIELDS_NAME] . " " .$this->tabfields[$i][TABFIELDS_TYPE]. $collate . ";";
			if($this->dbo->setquery($add_query)) // ������ ���������� ���� � �������
			{
				++$does;
			}
		}
		return $does;
	}

	public function install()
	{
		writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		if ( $this->core_install() ) { echo("���������� ������� " . $this->tabname . "<br />\n"); }
		else { echo("�� ������� ���������� ��� ������� ������� " . $this->tabname . "<br />\n"); }
	}

	/**
	 * ������� �������� ��������� ������
	*/
	function del($delid)
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		return $this->dbo->setquery("DELETE FROM " . $this->tabname . " WHERE " . $this->keyfield . " = $delid ;");
	}

	/**
	 * ������� ��������� �������� ���� ��� ����������� ������
	 * @todo ������������� SQL-��������
	*/
	function set($fieldname, $value)
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		if( !isset($this->fields_id[$fieldname]) && ($fieldname != $this->keyfield) )
		{return false;}
		if($fieldname == $this->keyfield)
		{
			if( $value ) // �� ����
			{
				if( str_is_int($value) ) // ������ �����
				{
					$this->tosave[$fieldname] = $value;
					return true;
				}
			}
			return false;
		}

		$fType = strtolower($this->tabfields[$this->fields_id[$fieldname]][TABFIELDS_TYPE]);
		if( ( "datetime" == $fType ) || ( "date" == $fType ) )
		{
			if( "NOW()" == strtoupper($value) )
			{
				$this->tosave[$fieldname] = $value;
				return true;
			}
		}
		// ���� ������������� SQL-��������
		$this->tosave[$fieldname] = $this->set_specialchars($value);
		return true;
	}

	/**
	 * ������� html-��������� ��� ������� ��������� ��������
	 * @param string $value
	 * @return string
	 */
	protected function set_specialchars($value)
	{
		writelog("class " . __CLASS__ . "; function " . __FUNCTION__);

		return "'" . htmlspecialchars($value, ENT_QUOTES) . "'";
	}

	protected function direct_set($fieldname, $value)
	{
		writelog("class " . __CLASS__ . "; function " . __FUNCTION__);

		$this->tosave[$fieldname] = "'" . $value . "'";
		return true;
	}

	function clone_set($fieldname, $value)
	{
		writelog("class " . __CLASS__ . "; function " . __FUNCTION__);

		$this->tosave[$fieldname] = $value;
		return true;
	}

	/**
	 * ������� ����������/��������� ������
	*/
	function save($id=0)
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		if($id)
		{
			$this->set($this->keyfield, $id);
		}
		if( $this->tosave[$this->keyfield] )
		{
			return $this->save_this();
		}
		return $this->save_new();
	}

	/**
	 * ������� ���������� ����� ������
	*/
	protected function save_new()
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		$tab = $this->tabname;
		$fields = "";
		$vals = "";

		foreach ($this->tosave as $k => $value)
		{
			if($k != $this->keyfield)
			{
				if($fields == "")
				{
					$fields = $fields . $k;
					$vals = $vals . $value;
				}
				else
				{
					$fields = $fields . ", " . $k;
					$vals = $vals . ", " . $value;
				}
			}
		}
		$qwery = "INSERT INTO $tab ( $fields ) VALUES ( $vals );";
		if($this->dbo->setquery($qwery))
		{
			return mysql_insert_id($this->dbo->conn);
		}
		return false;
	}


	/**
	 * ������� ��������� ������������ ������
	*/
	protected function save_this()
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		$tab = $this->tabname;
		$fields = "";
		foreach ($this->tosave as $k => $value)
		{
			if($k != $this->keyfield)
			{
				if($fields == "")
				{
					$fields = $fields . $k . "=" . $value;
				}
				else
				{
					$fields = $fields . ", " . $k . "=" . $value;
				}
			}
		}
		$qwery = "UPDATE $tab SET $fields WHERE " . $this->keyfield . " = " . $this->tosave[$this->keyfield] . ";";
		if($this->dbo->setquery($qwery))
		{ return $this->tosave[$this->keyfield]; }
		else { return false; }
	}

	/**
	 * ������� ������� ����������, �������������� ��� ����������.
	 */
	function clear_2_save()
	{
		unset($this->tosave);
		$this->tosave = array();
	}

	/**
	 * ������� ��������� id ��������� ����������� � ������� ������
	*/
	function get_lost_id()
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		$this->dbo->setquery( "SELECT " . $this->keyfield . " FROM " . $this->tabname . " ORDER BY " . $this->keyfield . " DESC LIMIT 1 ;" );
		return $this->dbo->out(0, $this->keyfield);
	}

	/**
	 * ������� �������� �������
	*/
	function load($id=0)
	{
		if($id)
		{
			if( !str_is_int($id) )
			{return 0;}
			$this->select_id = $this->dbo->setquery( $this->setselect($this->keyfield . " = $id") );
		} else
		{
			$this->select_id = $this->dbo->setquery( $this->setselect() );
		}

		return $this->outcount();
	}

	/**
	 * ���������� ���������� ���������� �� ���� �������
	 * @return int
	 */
	function outcount()
	{
		if(isset($this->select_id))
		{
			return $this->dbo->outcount($this->select_id);
		}
		return 0;
	}

	/**
	 * �������� ������� ��� ������������ ������� �� ������ ������� (select)
	 * @param string $param - ������, ������� ��� "id='15'" ��� "dtt = '05-10-2008'" � �. �.
	 * @return string
	 */
	protected function setselect($param = "1 = 1")
	{
		$outq = "SELECT * FROM " . $this->tabname . " WHERE $param ;";
		return $outq;
	}

	/**
	 * ������� �������� �������� ����
	 * @param string $tabfield - ��� ����
	 * @param int $rowid - �������
	 * @return string
	 */
	function out($tabfield, $rowid=0)
	{
		return $this->dbo->out($rowid, $tabfield, $this->select_id);
	}

	function outid($rowid=0)
	{
		return $this->dbo->out($rowid, $this->keyfield, $this->select_id);
	}
}

define("UNIPID", "pid");
include_once(FORM_MODUL . "/form.inc.php");
/**
����� ������������� �������� ������� ���� ���� INT, ������� ������ id ������� � �������.
*/
class modultab extends dbtabl
{
	var $curpart;
	var $defFormSignatures; // ��������� ������� ����� �����

	function __construct($db)
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		parent::__construct($db);
		$this->add_field(UNIPID, "INT");
	}

	function SetPart($cp)
	{
		if(str_is_int($cp))
		{
			$this->curpart = $cp;
			return true;
		}
		return false;
	}

	function OutCurPart()
	{
		return $this->curpart;
	}

	protected function /* SetPidSelect */ setselect($wheres="", $ordlims="")
	// ������� ��� �������, ��� ��� ������ ����� ����� ���������� � ������� "AND"
	{
		$param = "";
		if($wheres)
		{ $param = " AND $wheres "; }
		$param = "$param $ordlims";
		$q = UNIPID . " = " . $this->curpart . " $param";
		return parent::setselect($q);
	}

	function check4pid($id)
	{
		return $this->load($id);
	}

	protected function save_new()
	{
		if(!$this->curpart)
		{
			echo("<p style=\"color:red;\">������ �� ����������</p>");
			return false;
		}
		else
		{
			$this->set(UNIPID, $this->curpart);
			return parent::save_new();
		}
	}

	protected function save_this()
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		if(!$this->curpart)
		{
			echo("<p style=\"color:red;\">������ �� ����������</p>");
			return false;
		}
		else
		{
			$tmpselect = $this->select_id;
			$savereturn = false;
			if($this->load($this->tosave[$this->keyfield]))
			{
				$savereturn = parent::save_this();
			}
			$this->select_id = $tmpselect;
		}
		return $savereturn;
	}

	function del($delid)
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		if( str_is_int($delid) )
		{
			return $this->dbo->setquery("DELETE FROM " . $this->tabname . " WHERE " . UNIPID . " = " . $this->curpart . " AND " . $this->keyfield . " = $delid ;");
		}
		return false;
	}

/**
 * ������� ��� �������� ���� ������� �� �������, ����������� � �������� �������
 * @return <bool>
 */
	function delForPart()
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		if($this->curpart) // ���� ������ ���������
		{
			return $this->dbo->setquery("DELETE FROM " . $this->tabname . " WHERE " . UNIPID . " = " . $this->curpart . " ;");
		}
		return false;
	}

// ������ � ������
	function FormPlus(htmlform &$dForm, &$dFormList)
	{ // ���������� ����� � �����
		$dFormList["sub_" . UNIKEY] = $dForm->addf(ftype_hid);
		$dForm->set_param(PTTRN_name, "sub_" . UNIKEY);

		for($pli = 0; $pli < $this->ifields; ++$pli)
		{
			if( $this->tabfields[$pli][TABFIELDS_FFT] )
			{
				$dFormList["sub_" . $this->tabfields[$pli][TABFIELDS_NAME]] = $dForm->addf($this->tabfields[$pli][TABFIELDS_FFT]);
				$dForm->set_param(PTTRN_name, "sub_" . $this->tabfields[$pli][TABFIELDS_NAME]);
				if(ftype_check == $this->tabfields[$pli][TABFIELDS_FFT])
				{ // value �������� - ������ = 1
					$dForm->set_param(PTTRN_value, 1, $dFormList["sub_" . $this->tabfields[$pli][TABFIELDS_NAME]]);
				}

				// ������� �����
				$dForm->set_param( PTTRN_signature, $this->tabfields[$pli][TABFIELDS_FFSign] );
				$this->plusOthers($dForm, $dFormList, $pli);
			}
		}
	}

	/**
	 * ��������� ���������� ��� ���������� ����
	 * @param htmlform $dForm
	 * @param array $dFormList
	 * @param int $thefieldid
	 * @return bool
	 */
	protected function plusOthers(htmlform &$dForm, &$dFormList, $thefieldid)
	{
		return false;
	}

	function FormComplete(htmlform &$dForm, &$dFormList)
	{ // ���������� �����
		$dForm->set_param(PTTRN_value, $this->out(UNIKEY), $dFormList["sub_" . UNIKEY]);
		for($pli = 0; $pli < $this->ifields; ++$pli)
		{
			if( $this->tabfields[$pli][TABFIELDS_FFT] )
			{
				$isselected = 1;
				switch ($this->tabfields[$pli][TABFIELDS_FFT])
				{
					case ftype_select: $isselected = $dForm->select_by_value($this->out($this->tabfields[$pli][TABFIELDS_NAME]), $dFormList["sub_" . $this->tabfields[$pli][TABFIELDS_NAME]]); break;
					case ftype_check: $dForm->set_param(PTTRN_selected, $this->out($this->tabfields[$pli][TABFIELDS_NAME]), $dFormList["sub_" . $this->tabfields[$pli][TABFIELDS_NAME]]); break;
					default: $dForm->set_param(PTTRN_value, $this->out($this->tabfields[$pli][TABFIELDS_NAME]), $dFormList["sub_" . $this->tabfields[$pli][TABFIELDS_NAME]]); break;
				}
				// *todo: ����� �������� ��������, ������� � ������������ ������ ����� �����������
				$this->resetsOthers($dForm, $dFormList, $pli, $isselected);
			}
		}
	}

	/**
	 * �������������� ����������� ��� ���������� �����
	 * @param htmlform $dForm
	 * @param array $dFormList
	 * @param int $thefieldid
	 * @param int $isselected - ��������� �������
	 * @return type bool
	 */
	protected function resetsOthers(htmlform &$dForm, &$dFormList, $thefieldid, $isselected)
	{ // ������������� ���������� ������ ����� ��� ��������� �������� ������...
		return false;
	}

	function FormParse(htmlform &$dForm, &$dFormList)
	{ // ������ �����
		$dForm->load(); // �������� �������� �����, ���������� �� �������
		$this->set(UNIKEY, $dForm->out_value($dFormList["sub_" . UNIKEY]));
		for($pli = 0; $pli < $this->ifields; ++$pli)
		{
			if( $this->tabfields[$pli][TABFIELDS_FFT] )
			{
				$this->parseCases($dForm, $dFormList, $pli);
			}
		}
	}

	protected function parseCases(htmlform &$dForm, &$dFormList, $thefieldid)
	{
		switch ($this->tabfields[$thefieldid][TABFIELDS_FFT])
		{
			default: $this->defParseCase($dForm, $dFormList, $thefieldid); break;
		}
	}

	protected function defParseCase(htmlform &$dForm, &$dFormList, $thefieldid)
	{
		$this->set($this->tabfields[$thefieldid][TABFIELDS_NAME], $dForm->out_value($dFormList["sub_" . $this->tabfields[$thefieldid][TABFIELDS_NAME]]));
	}
// END: ������ � ������

	/**
	 * ��������� ������ ������
	 * @param int $rowid
	 * @return array
	 */
	function outrow($rowid)
	{
		$outarr = array();
		if(0 > $rowid)
		{
			foreach ($this->tabfields as $value)
			{
				$outarr[] = $value[TABFIELDS_NAME];
			}
		}
		else
		{
			foreach ($this->tabfields as $value)
			{
				$outarr[] = $this->dbo->out($rowid, $value[TABFIELDS_NAME], $this->select_id);
			}
		}
		return $outarr;
	}
}
?>
