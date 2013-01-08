<?php
class ffield
{
	var $id; // id в массиве формы
	var $type; // submit; textarea; text; button и т.д. input - нет
	var $subunit; // id родительской единицы
	var $name; // им€ пол€
	var $htmlid; // id пол€
	var $htmlstyle; // текст в параметре style
	var $title; // ѕодпись
	var $cssclass;
	var $value;
	var $checkstatus; // только дл€ check, radio, option(select)
	var $disabled;
	var $tabindex; // int
	var $signature; // ѕодпись пол€
	var $out; // —трока дл€ вывода формы
	var $members; // подъединицы
	var $pattern; // шаблон
	var $tabs;
	var $onblur;
	var $onchange;
	var $onclick;

	function __construct($tp, $ptrn)
	{
		$this->type = $tp;
		$this->pattern = $ptrn;
		$this->signature = "&nbsp;";
		$this->patterns = array();
		$this->members = array();
		$this->set_tabs("\t");
	}

	function processing()
	{
		$out = $this->pattern;
		if( ((ftype_check == $this->type) || (ftype_radio == $this->type)) && (!$this->htmlid) )
		{ // автоматический id дл€ label`s флажков
			$this->set(PTTRN_id, $this->name);
		}

		// то что определ€етс€ универсальным способом
		$out = str_replace("%tab%", $this->tabs, $out);
		$out = str_replace(PTTRN_class, $this->cssclass, $out);
		$out = str_replace(PTTRN_style, $this->htmlstyle, $out);
		$out = str_replace(PTTRN_name, $this->name, $out);
		$out = str_replace(PTTRN_id, $this->htmlid, $out);
		$out = str_replace(PTTRN_title, $this->title, $out);
		$out = str_replace(PTTRN_tabindex, $this->tabindex, $out);
		$out = str_replace(PTTRN_onblur, $this->onblur, $out);
		$out = str_replace(PTTRN_onchange, $this->onchange, $out);
		$out = str_replace(PTTRN_onclick, $this->onclick, $out);
		if($this->disabled) { $out = str_replace(PTTRN_disabled, "disabled=\"disabled\"", $out); }
			else { $out = str_replace(PTTRN_disabled, "", $out); }

		// то что по-разному
		$out = str_replace(PTTRN_signature, $this->signature, $out);
//		$out = str_replace(PTTRN_selected, $this->, $out);
		if($this->checkstatus)
		{
			if($this->type == ftype_check)
			{
				$out = str_replace(PTTRN_selected, "checked=\"checked\"", $out);
			}
			if($this->type == ftype_radio)
			{
				$out = str_replace(PTTRN_selected, "checked=\"checked\"", $out);
			}
			if($this->type == ftype_selunit)
			{
				$out = str_replace(PTTRN_selected, "selected=\"selected\"", $out);
			}
		} else { $out = str_replace(PTTRN_selected, "", $out); }

		// уборка незаполненных параметров
		$out = str_replace("style=\"\"", "", $out);
		$out = str_replace("class=\"\"", "", $out);
		$out = str_replace("id=\"\"", "", $out);
		$out = str_replace("value=\"\"", "", $out);
		$out = str_replace("tabindex=\"\"", "", $out);
		$out = str_replace("name=\"\"", "", $out);
		$out = str_replace("title=\"\"", "", $out);
		$out = str_replace("onblur=\"\"", "", $out);
		$out = str_replace("onchange=\"\"", "", $out);

		// уборка лишних пробелов
		while(strstr($out ,"  ")) { $out = str_replace("  ", " ", $out); }
		$out = str_replace("\" >", "\">", $out);

		$out = str_replace("%opt%", $this->out_subs(), $out);
		$this->out = str_replace(PTTRN_value, $this->value, $out); // в самом конце, так как может быть очень длинным и затруднить поиск и другие замены; кроме того, нельз€ измен€ть значение пол€
	}
	function set_member($inid)
	{
		$this->members[] = $inid;
		return ($this->count_members() - 1);
	}

	function set_selected_member($mid)
	{
		$this->members[$mid]->set(PTTRN_selected, true);
	}

	function select_by_value($val)
	{
		$allmemb = $this->count_members();
		for($i = 0; $i < $allmemb; ++$i)
		{
			if( $val == $this->members[$i]->out_value() )
			{
				$this->set_selected_member($i);
				return true;
			}
		}
		return false;
	}

	function count_members()
	{
		return count($this->members);
	}

	function set($param, $val)
	{
		if($val) // «десь убиваютс€ строки-нули "0"
		{
			if($param == PTTRN_name)
			{
				$this->name = $val;
				return true;
			}
			if($param == PTTRN_id)
			{
				$this->htmlid = $val;
				return true;
			}
			if($param == PTTRN_style)
			{
				$this->htmlstyle = $val;
				return true;
			}
			if($param == PTTRN_class)
			{
				$this->cssclass = $val;
				return true;
			}
			if($param == PTTRN_title)
			{
				$this->title = $val;
				return true;
			}
			if( ($param == PTTRN_selected) || ($param == "checked") || ($param == "selected") )
			{
				$this->checkstatus = true;
				return true;
			}
			if($param == PTTRN_disabled)
			{
				$this->disabled = true;
				return true;
			}
			if($param == PTTRN_tabindex)
			{
				$this->tabindex = $val;
				return true;
			}
			if($param == PTTRN_signature)
			{
				$this->signature = $val;
				return true;
			}
			if($param == PTTRN_onblur)
			{
				$this->onblur = $val;
				return true;
			}
			if($param == PTTRN_onchange)
			{
				$this->onchange = $val;
				return true;
			}
			if($param == PTTRN_onclick)
			{
				$this->onclick = $val;
				return true;
			}
		}
		if($param == PTTRN_value)
		{
			$this->value = $val;
			return true;
		}
		return false;
	}

	function set_tabs($tab)
	{
		$this->tabs = $tab . "\t";
	}
	function show()
	{
		if(!$this->out)
		{
			$this->processing();
		}
		echo($this->out);
	}

	function out_show()
	{
		if(!$this->out)
		{
			$this->processing();
		}
		return $this->out;
	}

	function out_value()
	{
		return $this->value;
	}
	function out_id()
	{
		return $this->htmlid;
	}

	function out_subs()
	{
		$subs_str = "";
		$i = $this->count_members();
		for($it = 0; $it < $i; ++$it)
		{
			$subs_str = $subs_str . $this->members[$it]->out_show();
		}
		return $subs_str;
	}

	function from_post()
	{
		$this->value = $_POST[$this->name];
	}
	function from_get()
	{
		$this->value = $_GET[$this->name];
	}
}

class htmlform
{
	var $fields; // массив полей
	var $lfields; // длинна массива полей

	var $formname;
	var $actmethod;
	var $actway;
	var $onsubm;
	var $text;
	var $patterns; // шаблоны строк дл€ вывода
	var $tabs;
	var $moreinform; // еще параметры в форму

	function __construct($fname)
	{
		$this->fields = array();
		$this->lfields = 0;
		$this->formname = $fname;
		$this->actmethod = "post";
		$this->actway = "#";

		// определение типов
		$this->set_pattern(ftype_hr, "%tab%<hr />\n\n");
		$this->set_pattern(ftype_div, "%tab%<div id=\"" . PTTRN_id . "\" class=\"" . PTTRN_class . "\"></div>\n\n");
		$this->set_pattern(ftype_text, "%tab%<p class=\"fieldtitle\">" . PTTRN_signature . "</p>\n%tab%" . "<input type=\"text\" " . PTTRN_disabled . " class=\"" . PTTRN_class . "\" style=\"" . PTTRN_style . "\" name=\"" . PTTRN_name . "\" id=\"" . PTTRN_id . "\" title=\"" . PTTRN_title . "\" tabindex=\"" . PTTRN_tabindex . "\" value=\"" . PTTRN_value . "\" onblur=\"" . PTTRN_onblur . "\" onchange=\"" . PTTRN_onchange . "\" />\n%tab%<br clear=\"all\" />\n\n");
		$this->set_pattern(ftype_hid, "%tab%<input type=\"hidden\" " . PTTRN_disabled . " name=\"" . PTTRN_name . "\" id=\"" . PTTRN_id . "\" value=\"" . PTTRN_value . "\" />\n");
		$this->set_pattern(ftype_textar, "%tab%<p class=\"fieldtitle\">" . PTTRN_signature . "</p>\n%tab%<textarea " . PTTRN_disabled . " class=\"" . PTTRN_class . "\" style=\"" . PTTRN_style . "\" name=\"" . PTTRN_name . "\" id=\"" . PTTRN_id . "\" title=\"" . PTTRN_title . "\" tabindex=\"" . PTTRN_tabindex . "\" onblur=\"" . PTTRN_onblur . "\">" . PTTRN_value . "</textarea>\n%tab%<br clear=\"all\" />\n\n");
		$this->set_pattern(ftype_check, "%tab%<p class=\"fieldtitle\">&nbsp;</p>\n%tab%<input type=\"checkbox\" " . PTTRN_disabled . " class=\"" . PTTRN_class . "\" " . PTTRN_selected . " style=\"width:auto; " . PTTRN_style . "\" name=\"" . PTTRN_name . "\" id=\"" . PTTRN_id . "\" title=\"" . PTTRN_title . "\" tabindex=\"" . PTTRN_tabindex . "\" value=\"" . PTTRN_value . "\" onblur=\"" . PTTRN_onblur . "\" onchange=\"" . PTTRN_onchange . "\" /><label for=\"" . PTTRN_id . "\">" . PTTRN_signature . "</label>\n%tab%<br clear=\"all\" />\n\n");
		$this->set_pattern(ftype_select, "%tab%<p class=\"fieldtitle\">" . PTTRN_signature . "</p>\n%tab%<select " . PTTRN_disabled . " class=\"" . PTTRN_class . "\" style=\"" . PTTRN_style . "\" name=\"" . PTTRN_name . "\" id=\"" . PTTRN_id . "\" title=\"" . PTTRN_title . "\" tabindex=\"" . PTTRN_tabindex . "\" onblur=\"" . PTTRN_onblur . "\" onchange=\"" . PTTRN_onchange . "\">\n%opt%%tab%</select>\n" . "%tab%<br clear=\"all\" />\n\n");
		$this->set_pattern(ftype_subm, "%tab%<p class=\"fieldtitle\">" . PTTRN_signature . "</p>\n%tab%<input " . PTTRN_disabled . " type=\"submit\" class=\"" . PTTRN_class . "\" style=\"" . PTTRN_style . "\" name=\"" . PTTRN_name . "\" id=\"" . PTTRN_id . "\" title=\"" . PTTRN_title . "\" tabindex=\"" . PTTRN_tabindex . "\" value=\"" . PTTRN_value . "\" onblur=\"" . PTTRN_onblur . "\" />\n%tab%<br clear=\"all\" />\n\n");
		$this->set_pattern(ftype_radio, "%tab%\t<input type=\"radio\" " . PTTRN_disabled . " id=\"" . PTTRN_id . "\" name=\"" . PTTRN_name . "\" value=\"" . PTTRN_value . "\" style=\"width:auto; margin-left:5px;\" /><label for=\"" . PTTRN_id . "\" onblur=\"" . PTTRN_onblur . "\">" . PTTRN_signature . "</label>\n%tab%<br clear=\"all\" />\n");
		$this->set_pattern(ftype_selunit, "%tab%\t<option value=\"" . PTTRN_value . "\" " . PTTRN_selected . ">" . PTTRN_signature . "</option>\n");
		$this->set_pattern(ftype_radiogroup, "%tab%<p class=\"fieldtitle\">&nbsp;</p>\n%tab%<fieldset style=\"" . PTTRN_style . "\">\n\t%tab%<legend>" . PTTRN_signature . "</legend>\n%opt%%tab%</fieldset>\n%tab%<br clear=\"all\" />\n\n");
//		$this->set_pattern(ftype_dtt, "%tab%<p class=\"fieldtitle\">" . PTTRN_signature . "</p>\n%tab%" . "<input type=\"datetime-local\" " . PTTRN_disabled . " class=\"" . PTTRN_class . "\" style=\"" . PTTRN_style . "\" name=\"" . PTTRN_name . "\" id=\"" . PTTRN_id . "\" title=\"" . PTTRN_title . "\" tabindex=\"" . PTTRN_tabindex . "\" value=\"" . PTTRN_value . "\" onblur=\"" . PTTRN_onblur . "\" onchange=\"" . PTTRN_onchange . "\" />\n%tab%<br clear=\"all\" />\n%tab%<script type=\"text/javascript\"> if(document.getElementById(\"" . PTTRN_id . "\").type == \"datetime-local\") { document.getElementById(\"" . PTTRN_id . "\").value = \"" . PTTRN_value . "\".replace(/ /, \"T\"); } </script>\n\n");
		$this->set_pattern(ftype_dtt, "%tab%<p class=\"fieldtitle\">" . PTTRN_signature . "</p>\n%tab%" . "<input type=\"datetime\" " . PTTRN_disabled . " class=\"" . PTTRN_class . "\" style=\"" . PTTRN_style . "\" name=\"" . PTTRN_name . "\" id=\"" . PTTRN_id . "\" title=\"" . PTTRN_title . "\" tabindex=\"" . PTTRN_tabindex . "\" value=\"" . PTTRN_value . "\" onblur=\"" . PTTRN_onblur . "\" onchange=\"" . PTTRN_onchange . "\" />\n%tab%<br clear=\"all\" />\n\n");
		$this->set_pattern(ftype_dt, "%tab%<p class=\"fieldtitle\">" . PTTRN_signature . "</p>\n%tab%" . "<input type=\"date\" " . PTTRN_disabled . " class=\"" . PTTRN_class . "\" style=\"" . PTTRN_style . "\" name=\"" . PTTRN_name . "\" id=\"" . PTTRN_id . "\" title=\"" . PTTRN_title . "\" tabindex=\"" . PTTRN_tabindex . "\" value=\"" . PTTRN_value . "\" onblur=\"" . PTTRN_onblur . "\" onchange=\"" . PTTRN_onchange . "\" />\n%tab%<br clear=\"all\" />\n\n");
		$this->set_pattern(ftype_file, "%tab%<p class=\"fieldtitle\">" . PTTRN_signature . "</p>\n%tab%" . "<input type=\"file\" " . PTTRN_disabled . " class=\"" . PTTRN_class . "\" style=\"" . PTTRN_style . "\" name=\"" . PTTRN_name . "\" id=\"" . PTTRN_id . "\" title=\"" . PTTRN_title . "\" tabindex=\"" . PTTRN_tabindex . "\" onblur=\"" . PTTRN_onblur . "\" />\n%tab%<br clear=\"all\" />\n\n");
		$this->set_pattern(ftype_button, "%tab%<p class=\"fieldtitle\">" . PTTRN_signature . "</p>\n%tab%<input " . PTTRN_disabled . " type=\"button\" class=\"" . PTTRN_class . "\" style=\"" . PTTRN_style . "\" name=\"" . PTTRN_name . "\" id=\"" . PTTRN_id . "\" title=\"" . PTTRN_title . "\" tabindex=\"" . PTTRN_tabindex . "\" value=\"" . PTTRN_value . "\" onblur=\"" . PTTRN_onblur . "\" onclick=\"" . PTTRN_onclick . "\" />\n%tab%<br clear=\"all\" />\n\n");
	}

	function morein($str_in)
	{
		$this->moreinform = $str_in;
	}

	function set_onsubm($act)
	{
		$this->onsubm = $act;
	}

	function set_action($act)
	{
		$this->actway = $act;
	}

	function addf($tp) // ќб€зателен тип
	{
		$this->fields[$this->lfields] = new ffield($tp, $this->patterns[$tp]);
		if( ($tp == ftype_text) || ($tp == ftype_textar) || ($tp == ftype_select) || ($tp == ftype_dtt) )
		{
			$this->set_param(PTTRN_class, "inpcl", $this->lfields);
		}
		if($tp == ftype_subm)
		{
			$this->set_param(PTTRN_class, "submbutton", $this->lfields);
		}
		$this->fields[$this->lfields]->set_tabs($this->tabs);

		++$this->lfields;
		return $this->lfields - 1;
	}

	function set_pattern($tp, $pttrn)
	{
		$this->patterns[$tp] = $pttrn;
		return true;
	}

	function set_tab($quanty)
	{ // количество отступов, добавл€емое перед фомой
		$this->tabs = "";
		for($i = 0; $i < $quanty; ++$i)
		{
			$this->tabs = $this->tabs . "\t";
		}
	}

	function set_type($tp, $pttrn)
	{
		return $this->set_pattern($tp, $pttrn);
	}

	function set_param($par, $val, $id=-1)
	{
		if($id == -1){$id = $this->lfields - 1;}
/*		if( ( ($this->fields[$id]->type == ftype_radiogroup) || ($this->fields[$id]->type == ftype_select) ) && ($par == PTTRN_value) )
		{
			// ”становка активного юнита
		}

*/		if( (PTTRN_name == $par) && (!$this->fields[$id]->id) )
		{
			$this->fields[$id]->set(PTTRN_id, $val);
		}
		$this->fields[$id]->set($par, $val);
	}

	function set_for_all($par, $val)
	{
		for($i=0; $i < $this->lfields; ++$i)
		{
			$this->fields[$i]->set($par, $val);
		}
	}

	function set_member($value, $sign, $inid = -1)
	{
		if($inid == -1){$inid = $this->lfields - 1;}
		$inidtype = $this->fields[$inid]->type;
		if(($inidtype != ftype_radiogroup) && ($inidtype != ftype_select))
		{ return false; }
		$subnew = 0;
		if($this->fields[$inid]->type == ftype_radiogroup)
		{
			$subnew = new ffield(ftype_radio, $this->patterns[ftype_radio]);
		}
		if($this->fields[$inid]->type == ftype_select)
		{
			$subnew = new ffield(ftype_selunit, $this->patterns[ftype_selunit]);
		}
		$subnew->set(PTTRN_id, $this->fields[$inid]->name . "_" . ($this->fields[$inid]->count_members() + 1) );
		$subnew->set(PTTRN_name, $this->fields[$inid]->name);
		$subnew->set(PTTRN_value, $value);
		$subnew->set(PTTRN_signature, $sign);
		$subnew->set_tabs($this->tabs);

		return $this->fields[$inid]->set_member($subnew);
	}

	function set_select($mid, $inid=-1)
	{
		if($inid == -1){$inid = $this->lfields - 1;}
		$this->fields[$inid]->set_selected_member($mid);
	}

	function select_by_value($val, $inid=-1)
	{
		if($inid == -1){$inid = $this->lfields - 1;}
		$thetp = $this->fields[$inid]->type; // тип
		if( ($thetp == ftype_radiogroup) || ($thetp == ftype_select) )
		{
			return $this->fields[$inid]->select_by_value($val);
		}
		return false;
	}

	function from_post()
	{
		for($i = 0; $i < $this->lfields; ++$i)
		{
			$this->fields[$i]->from_post();
		}
	}
	function from_get()
	{
		for($i = 0; $i < $this->lfields; ++$i)
		{
			$this->fields[$i]->from_get();
		}
	}

	function load()
	{
		if($this->actmethod == "post")
		{
			$this->from_post();
		}
		if($this->actmethod == "get")
		{
			$this->from_get();
		}
	}

	function showf()
	{
		$opentag = $this->tabs . "<form name=\"" . $this->formname . "\" method=\"" . $this->actmethod . "\" action=\"" . $this->actway . "\" onsubmit=\"" . $this->onsubm . "\" " . $this->moreinform . ">" . $this->text . "\n\n"; // ‘ормирование открывающего тега формы
		$closetag = $this->tabs . "</form>\n";
		echo($opentag);
		for($i = 0; $i < $this->lfields; ++$i)
		{
			$this->fields[$i]->show();
		}
		echo($closetag);
	}
/**
 * @todo “ребуетс€ переработка класса ffield атрибуты не отдельными пол€ми класса, а массив
	function out($param, $i_field)
	{
		return $this->fields[$i_field]->out_value();
	}
*/
	function out_value($i_field)
	{
		return $this->fields[$i_field]->out_value();
	}
	function out_id($i_field)
	{
		return $this->fields[$i_field]->out_id();
	}

	function out_formname()
	{
		return $this->formname;
	}
}
?>
