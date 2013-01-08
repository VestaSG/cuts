<?php
define("pref_TAB_ATTACH", PREF_TAB . "attach_");
define("TAB_ATTACH", pref_TAB_ATTACH . "core");
define("TAB_ATTACH_name", "name");
define("TAB_ATTACH_href", "href");
define("TAB_ATTACH_body", "fbody");
define("TAB_ATTACH_isfree", "isfree");
define("TAB_ATTACH_mime", "mime");

include_once(DBUNIT_MODUL . "/table.class.php");
// Класс прикрепления файлов
class attach extends modultab
{
	function __construct($db)
	{
		writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		parent::__construct($db);
		$this->set_tabname(TAB_ATTACH);
		$this->add_field(TAB_ATTACH_name, "CHAR( 250 )", 0, ftype_text, TAB_ATTACH_name);
		$this->add_field(TAB_ATTACH_body, "MEDIUMBLOB", 0, ftype_file, "Файл");
		$this->add_field(TAB_ATTACH_isfree, "BOOL", 0, ftype_check, "Свободный");
		$this->add_field(TAB_ATTACH_mime, "CHAR( 50 )");
	}

	function showfile()
	{
		writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
/*		header('Content-Disposition: attachment; filename='.$fileName.'.rtf');
*/		header("Content-type: " . $this->out(TAB_ATTACH_mime) );
/*		header("Expires: 0");
	    header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
	    header("Pragma: public");
*/		echo(base64_decode($this->out(TAB_ATTACH_body)));
	}

	protected function parseCases(htmlform &$dForm, &$dFormList, $thefieldid)
	{
		writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		switch ($this->tabfields[$thefieldid][TABFIELDS_FFT])
		{
			case ftype_file:
				$fname = $_FILES["sub_" . $this->tabfields[$thefieldid][TABFIELDS_NAME]]["tmp_name"];
				$fmim = $_FILES["sub_" . $this->tabfields[$thefieldid][TABFIELDS_NAME]]["type"];
				$file = fopen($fname, "rb"); // Открываем файл для чтения в бинарном формате
				$str_file = fread($file, filesize("$fname")); // Считываем файл в переменную $str_file
				fclose($file); // Закрываем файл
				unlink("$fname"); // Удаляем файл
				$str_file = base64_encode($str_file); // Преобразуем эту строку в base64-формат
				$this->direct_set($this->tabfields[$thefieldid][TABFIELDS_NAME], $str_file);
				$this->set(TAB_ATTACH_mime, $fmim); // Совсем специфично!!!
				break;
			default: $this->defParseCase($dForm, $dFormList, $thefieldid); break;
		}
	}

	function load($id=0)
	{
		if($id)
		{
			if( !str_is_int($id) )
			{return 0;}
			$this->select_id = $this->dbo->setquery( "SELECT * FROM " . $this->tabname . " WHERE " . $this->keyfield . " = $id ;");
		} else
		{
			$this->select_id = $this->dbo->setquery( "SELECT * FROM " . $this->tabname );
		}

		return $this->outcount();
	}

	function load_list_for($pid=0, $isim=0)
	{
		if( str_is_int($pid) )
		{
			if(!$pid)
			{
				if($this->OutCurPart())
				{
					$pid = $this->OutCurPart();
				}
			}
		}
		else
		{
			return false;
		}
		$q = "SELECT " . $this->keyfield . ", " . TAB_ATTACH_name . ", " . TAB_ATTACH_isfree . ", " . TAB_ATTACH_mime . " FROM " . $this->tabname . " WHERE " . UNIPID . " = " . $pid . " ORDER BY " . $this->keyfield . " ;";
		if($isim)
		{
			$q = "SELECT * FROM " . $this->tabname . " WHERE " . UNIPID . " = " . $pid . " ORDER BY " . $this->keyfield . " ;";
		}
		$this->select_id = $this->dbo->setquery($q);
		return $this->outcount();
	}
}
?>
