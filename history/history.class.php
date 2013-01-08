<?php
include_once(DBUNIT_MODUL . "/table.class.php");

class history extends dbtabl
{
	function __construct($db)
	{
		parent::__construct($db);
		$this->set_tabname(TAB_HISTVALUES);
		$this->add_field(TAB_HISTVALUES_subj, KEYTYPE);
		$this->add_field(TAB_HISTVALUES_idsubj, KEYTYPE);
		$this->add_field(TAB_HISTVALUES_eventid, KEYTYPE);
		$this->add_field(TAB_HISTVALUES_fieldname, "CHAR(255)");
		$this->add_field(TAB_HISTVALUES_user, KEYTYPE);
		$this->add_field(TAB_HISTVALUES_dtt, "DATETIME");
		$this->add_field(TAB_HISTVALUES_setint, "INT");
		$this->add_field(TAB_HISTVALUES_setdouble, "DOUBLE");
		$this->add_field(TAB_HISTVALUES_settext, "TEXT");
	}

	function addHistValue()
	{
		;
	}

	function get_lost_value($subjid, $subj, $fldname)
	{
		$loc_sel_id = $this->dbo->setquery( "SELECT " . TAB_HISTVALUES_settext . " FROM " . $this->tabname . " WHERE " .TAB_HISTVALUES_fieldname. " = '$fldname' AND " .TAB_HISTVALUES_idsubj. " = $subjid AND " .TAB_HISTVALUES_subj. " = $subj ORDER BY " . TAB_HISTVALUES_eventid . " DESC LIMIT 1 ;" );
		$cnt = $this->dbo->outcount($loc_sel_id);
		if($cnt)
		{
			return $this->dbo->out(0, TAB_HISTVALUES_settext, $loc_sel_id);
		}
		return false;
	}

	function get_lost_event()
	{
		$this->dbo->setquery( "SELECT " . TAB_HISTVALUES_eventid . " FROM " . $this->tabname . " ORDER BY " . TAB_HISTVALUES_eventid . " DESC LIMIT 1 ;" );
		return $this->dbo->out(0, TAB_HISTVALUES_eventid);
	}

	function getHistory($subj, $id)
	{
		$this->select_id = $this->dbo->setquery( "SELECT " . $this->tabname . ".*, " . LOGINTAB . ".nic FROM " . $this->tabname . " LEFT JOIN " . LOGINTAB . " ON " . $this->tabname . "." . TAB_HISTVALUES_user . " = " . LOGINTAB . ".id WHERE " . $this->tabname . "." . TAB_HISTVALUES_subj . " = $subj AND " . $this->tabname . "." . TAB_HISTVALUES_idsubj . " = $id ORDER BY " . $this->tabname . ".". TAB_HISTVALUES_dtt . " DESC ;" );

		$outar = array();
		$lAr = $this->outcount();
		for($i = 0; $i < $lAr; ++$i)
		{
			$outar[$i] = array();
			$outar[$i][TAB_HISTVALUES_fieldname] = $this->out(TAB_HISTVALUES_fieldname, $i);
			$outar[$i][TAB_HISTVALUES_user] = $this->out("nic", $i);
			$outar[$i][TAB_HISTVALUES_dtt] = $this->out(TAB_HISTVALUES_dtt, $i);
			$outar[$i][TAB_HISTVALUES_eventid] = $this->out(TAB_HISTVALUES_eventid, $i);
			$outar[$i]["val"] = false;
			if( $this->out(TAB_HISTVALUES_setint, $i) )
			{
				$outar[$i]["val"] = $this->out(TAB_HISTVALUES_setint, $i);
			}
			if( $this->out(TAB_HISTVALUES_setdouble, $i) )
			{
				$outar[$i]["val"] = $this->out(TAB_HISTVALUES_setdouble, $i);
			}
			if( $this->out(TAB_HISTVALUES_settext, $i) )
			{
				$outar[$i]["val"] = $this->out(TAB_HISTVALUES_settext, $i);
			}
		}
		return $outar;
	}
}
?>
