<?php
include_once(DBUNIT_MODUL . "/table.class.php");
//-------------------------------------
define("cut_weight", 4);
//-------------------------------------
class cutorder extends modultab
{
	function __construct($bd)
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		parent::__construct($bd);
		$this->set_tabname(TAB_CUTORDER);
		$this->add_field(TAB_CUTORDER_name, "CHAR( 80 )", 0, ftype_text, "Номер");
		$this->add_field(TAB_CUTORDER_price, "DOUBLE", 0, ftype_text, "Цена реза [руб/м]");
		$this->add_field(TAB_CUTORDER_company, "CHAR( 255 )", 0, ftype_text, "Покупатель");
		$this->add_field(TAB_CUTORDER_dt, "DATE", 0, ftype_dt, "Дата");
		$this->add_field(TAB_CUTORDER_tmc, "CHAR( 255 )", 0, ftype_text, "Наименование ТМЦ");
		$this->add_field(TAB_CUTORDER_lcut, "INT");
		$this->add_field(TAB_CUTORDER_w, "INT", 0, ftype_text, "Длина (по-горизонтали)");
		$this->add_field(TAB_CUTORDER_h, "INT", 0, ftype_text, "Ширина (по-вертикали)");
		$this->add_field(TAB_CUTORDER_th, "INT", 0, ftype_text, "Толщина");
		$this->add_field(TAB_CUTORDER_quanty, "INT", 0, ftype_text, "Количество исходных заготовок");
		$this->add_field(TAB_CUTORDER_scale, "INT", 0, ftype_text, "Масштаб: 1/");
		$this->add_field(TAB_CUTORDER_closed, "BOOL", 0, ftype_check, "Закрыт");
	}

	function load_open_list()
	{
		$this->select_id = $this->dbo->setquery( $this->setselect(TAB_CUTORDER_closed . " = 0", "ORDER BY " . UNIKEY . " DESC") );
		return $this->outcount();
	}
	function load_closed_list()
	{
		$this->select_id = $this->dbo->setquery( $this->setselect(TAB_CUTORDER_closed . " = 1", "ORDER BY " . UNIKEY . " DESC") );
		return $this->outcount();
	}

	function toblack($invoice_num)
	{
		if($invoice_num)
		{
			$this->clear_2_save();
			$this->set(TAB_CUTORDER_closed, 1);
			return $this->save($invoice_num);
		}
	}
}
//-------------------------------------
class cutunit extends modultab
{
	function __construct($bd)
	{
	writelog("class " . __CLASS__ . "; function " . __FUNCTION__);
		parent::__construct($bd);
		$this->set_tabname(TAB_CUTDESKS);
		$this->add_field(TAB_CUTDESKS_order, KEYTYPE);
		$this->add_field(TAB_CUTDESKS_h, "INT");
		$this->add_field(TAB_CUTDESKS_w, "INT");
		$this->add_field(TAB_CUTDESKS_t, "INT");
		$this->add_field(TAB_CUTDESKS_l, "INT");
		$this->add_field(TAB_CUTDESKS_attantion, "BOOL");
		$this->add_field(TAB_CUTDESKS_ingroup, "INT");
	}

	function load_for_order($ordId)
	{
		$this->select_id = $this->dbo->setquery( $this->setselect(TAB_CUTDESKS_order . " = $ordId", "ORDER BY " . TAB_CUTDESKS_ingroup . " ASC") );
		return $this->outcount();
	}
}
?>
