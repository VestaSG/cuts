<?php
include_once(DBUNIT_MODUL . "/table.class.php");

class menu extends dbtabl
{
	var $modullist;
	protected $solomode; // инициирован один раздел
	protected $multimode; // инициировано дерево

	function __construct($db)
	{
		writelog("class " . __CLASS__ . "; function " . __FUNCTION__);

		parent::__construct($db);
		$this->set_tabname(PART_TAB);
		$this->add_field(parttab_inid, "INT");
		$this->add_field(parttab_modul, "INT");
		$this->add_field(parttab_name, "CHAR( 255 )");
		$this->add_field(parttab_index, "INT");
		$this->add_field(parttab_visible, "TINYINT");
		$this->add_field(parttab_folder, "CHAR( 255 )");
		$this->add_field(parttab_link, "CHAR( 255 )");
		$this->add_field(parttab_partmodul, "INT");
		$this->add_field(parttab_isface, "BOOL");
		$this->tabtype = TAB_TYPE_DEFAULT . " AUTO_INCREMENT=" . MENU_idstart;

		$this->modullist = array();
		include(MENU_MODUL . "/modul.conf.php"); // загрузка списка модулей

		$this->solomode = false;
		$this->multimode = false;
	}

	function outPid()
	{
		writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		$this->outid();
	}

	function load_tree($id=0, $ustat=0, $short=1) // параметр понадобится для вложенных разделов
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
/*		if($id)
		{
			$id = "WHERE ";
		} else
		{
			$id = "";
		}
*/
		return $this->load();
	}

	function load($id=0)
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		if($id)
		{
			$this->solomode = true;
			$this->multimode = false;
		}
		else
		{
			$this->solomode = false;
			$this->multimode = true;
		}
		return parent::load($id);
	}

	function loadDefault()
	{
		writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		$q = "SELECT * FROM " . $this->tabname . " WHERE " . parttab_isface . " > 0 LIMIT 1;";
		$this->select_id = $this->dbo->setquery( $q );
		$this->solomode = true;
		$this->multimode = false;
		return $this->outid();
	}

	function setDefault($id)
	{
		if($id && str_is_int($id))
		{
			$this->dbo->setquery("LOCK TABLES " . $this->tabname . " WRITE;");
			$this->dbo->setquery( "UPDATE " . $this->tabname . " SET " .parttab_isface." = 0;" );
			$this->dbo->setquery( "UPDATE " . $this->tabname . " SET " .parttab_isface." = 1 WHERE " . $this->keyfield . " = '$id'; " );
			$this->dbo->setquery("UNLOCK TABLES;");
		}
	}

	function lengparts()
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		return $this->outcount();
	}

	function add_modul($folder, $id)
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		$this->modullist[$id]["way"] = $folder;
		include($folder . "/modul.conf.php");
		$this->modullist[$id]["name"] = $modul_name;
		$this->modullist[$id]["face"] = $folder . "/" . $modul_main;
		$this->modullist[$id]["del"] = $folder . "/" . $modul_del;
		$this->modullist[$id]["install"] = $folder . "/" . $modul_install;
	}

	// Переопределить save
	// добавить добавление нового объекта модуля
/*	function save()
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		$menupart = parent::save();
		return $menupart;
	}
*/
	function set($fieldname, $value)
	{
		if(parttab_folder == $fieldname)
		{
			foreach ($this->modullist as $key => $themodul)
			{
				if($themodul["way"] == $value)
				{
					parent::set(parttab_modul, $key);
					break;
				}
			}
		}
		if(parttab_modul == $fieldname)
		{
			parent::set(parttab_folder, $this->modullist[$value]["way"]);
		}
		return parent::set($fieldname, $value);
	}

function del($id)
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		$thefrees = new free($this->dbo);
		$thefrees->delforpart($id);
		return parent::del($id);
	}

	function SetAllRights($user)
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		$qr = 0;
		if($this->solomode)
		{
			$thefrees = new free($this->dbo);
			$thefrees->del_up_frees($this->outid(), $user);
			$freear = $this->OutModulFrees();

			foreach ($freear as $v)
			{
				if( $thefrees->addfree( $user, $v["val"], $this->outid() ) )
				{++$qr;}
			}
		}
		return $qr;
	}

	function outModulDir()
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		if( 1 == $this->outcount() )
		{
			return $this->modullist[$this->out(parttab_modul)]["way"];
		}
		return false;
	}

	function outModulCount()
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		return count($this->modullist);
	}

	function outInstallList()
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		$outlist = array();
		foreach ($this->modullist as $fileway)
		{
			$outlist[] = $fileway["install"];
		}
		return $outlist;
	}

	function OutPartModul($prt) // pub
	// Получаем id раздела
	// возвращает массив возможных прав для раздела
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		if( 1 != $this->outcount() )
		{
			return false;
		}
		$backselect = $this->select_id; // запоминаем выборку
		$this->load($prt);
		$outvar = $this->out(parttab_modul); // отвечаем, какого модуля раздел
		$this->dbo->cleen($this->select_id);
		$this->select_id = $backselect; // восстановим выборку
		return $outvar;
	}

	function OutModulFace($themodul, $theface, $or="index.form.php")
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		if( isset($this->modullist[$themodul]) )
		{
			return $this->modullist[$themodul][$theface];
		}
		return $or;
	}

	function OutModulFrees($themodul=0)
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		if(!$themodul)
		{
			if($this->solomode)
			{
				$themodul = $this->out(parttab_modul);
			}
		}
		if( isset($this->modullist[$themodul]) )
		{
			include( $this->outModulDir() . "/free.conf.php" );
			return $freeset;
		}
	}

	function treeBuilding($ustat=0)
	// Формирование дерева для вывода
	{
		/**
		 * @todo: Выносить след. код в load_tree()
		 */
		// ->
		$q = "SELECT * FROM " . $this->tabname . " WHERE " . parttab_visible . " > 0;";
		if($ustat)
		{
			$q = $this->setselect();
		}
		$this->select_id = $this->dbo->setquery( $q );
		// <-

		$mleng = $this->outcount();
//		echo("<p style=\"color:red;\">$mleng</p>");
//		$mleng = $this->load_tree();
		$partarr = array();
		$i_part = 0;
/*
		if($ustat)
		{
			$partarr[$i_part]["id"] = $i_part + 1;
			$partarr[$i_part]["name"] = "Пользователи и права";
			$partarr[$i_part]["vis"] = true;
			$partarr[$i_part]["link"] = USERS_INDEX;
			++$i_part;
		}
*/
		for($menui = 0; $menui < $mleng; ++$menui)
		{
			$partarr[$i_part]["id"] = $this->out(parttab_id, $menui);
			$partarr[$i_part]["name"] = $this->out(parttab_name, $menui);
			$partarr[$i_part]["vis"] = $this->out(parttab_visible, $menui);
			$partarr[$i_part]["link"] = SITE_INDEX . "?pid=" . $partarr[$i_part]["id"];
			++$i_part;
		}
		return $partarr;
	}
}
?>
