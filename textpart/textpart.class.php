<?php
include_once(DBUNIT_MODUL . "/table.class.php");

// Класс текстового раздела
class textpart extends dbtabl
{
	function __construct($bd)
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		parent::__construct($bd);
		$this->set_tabname(TEXTTAB);
		$this->add_field(texttab_head, "CHAR( 250 )");
		$this->add_field(texttab_body, "TEXT");
		$this->add_field(texttab_in, "INT");
		$this->add_field(texttab_date, "DATETIME");
		$this->add_field(texttab_moddate, "DATETIME");
		$this->add_field(texttab_ishid, "INT");
		$this->add_field(texttab_attid, "INT");
		$this->add_field(texttab_lang, "CHAR( 5 )");
	}

	function load_for($id)
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		if(str_is_int($id))
		{
			$this->select_id = $this->dbo->setquery($this->setselect(texttab_in . " = $id ORDER BY id DESC LIMIT 1 "));
			return $this->outcount();
		}
	}

	function del_for($id)
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		return $this->dbo->setquery("DELETE FROM " . $this->tabname . " WHERE " . texttab_in . " = $id ;");
	}

	function creat_new($pname, $pbody, $pinid, $hid, $attach, $lng)
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		// INSERT INTO tbl_name (col1,col2) VALUES(15,col1*2);
		// Сюда проверку переменных
		return $this->dbo->setquery("INSERT INTO " . TEXTTAB . " VALUES ( NULL, '$pname', '$pbody', $pinid, NOW(), NOW(), $hid, $attach, '$lng' ) ;"); // Запрос добавления в БД
	}

	function updatepart($pid, $pname, $pbody, $pinid, $hid)
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		$this->set(texttab_head, $pname);
		$this->set(texttab_body, $pbody);
		$this->set(texttab_in, $pinid);
		$this->set(texttab_ishid, $hid);
		return $this->save($pid);
	}

	function name_out($idout)
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		return $this->dbo->out($idout, "name", $this->select_id);
	}

	function body_out($idout=0)
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		$prepars = $this->dbo->out($idout, "body", $this->select_id);
		$prepars = str_replace("\r", "", $prepars);
//		return str_replace("\n", "<br>", $prepars);
		$prepars = str_replace("\n", "</p>\n<p>", $prepars);
		return preg_replace ("/(%img)([0-9]+)(%)/i", "<img src=\"" . SITE_INDEX . "attach/show.attach.inc.php?id=\${2}\" />", $prepars);
//		SITE_INDEX . "attach/show.attach.inc.php?id=" %img9%
	}

	function dtt_out($idout)
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		return $this->dbo->out($idout, "dtt", $this->select_id);
	}

	function moddtt_out($idout)
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		return $this->dbo->out($idout, "moddtt", $this->select_id);
	}

	function attach_out($idout)
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		return $this->dbo->out($idout, "attachid", $this->select_id);
	}

	function id_out($idout)
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		return $this->dbo->out($idout, "id", $this->select_id);
	}

	function inid_out($idout)
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		return $this->dbo->out($idout, "inid", $this->select_id);
	}

	function hid_out($idout)
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		return $this->dbo->out($idout, "ishid", $this->select_id);
	}

	function qwant_parts()
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		return $this->dbo->outcount($this->select_id);
	}
}
?>
