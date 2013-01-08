<?php
// Проверка прав
// END: Проверка прав

// Форма
include_once( FORM_MODUL."/form.inc.php"); // класс формы
$partform = new htmlform("part");
$partform->set_action($formact);
$partform->set_tab(1);
$fieldindex = array();

// Имя раздела
$fieldindex["partname"] = $partform->addf(ftype_text);
	$partform->set_param(PTTRN_signature, "Заголовок");
	$partform->set_param(PTTRN_name, "partname");

// Тип
$fieldindex["modul"] = $partform->addf(ftype_select);
	$partform->set_param(PTTRN_name, "modul");
	$partform->set_param(PTTRN_signature, "Тип раздела");
		foreach ($mobj->modullist as $k => $value)
		{
			$partform->set_member($k."", $value["name"]);
		}
	$partform->set_member(-1, "Соответствует другому");

// Видимость
$fieldindex["partcont"] = $partform->addf(ftype_check);
	$partform->set_param(PTTRN_signature, "Видимый");
	$partform->set_param(PTTRN_name, "parthid");
	$partform->set_param(PTTRN_id, "ishid");
	$partform->set_param(PTTRN_value, "1");

// Морда
$fieldindex["partface"] = $partform->addf(ftype_check);
	$partform->set_param(PTTRN_signature, "Поумолчательный");
	$partform->set_param(PTTRN_name, "partface");
	$partform->set_param(PTTRN_id, "partface");
	$partform->set_param(PTTRN_value, "1");

// id раздела в таблице (если значения нет - создать новый)
$fieldindex["id"] = $partform->addf(ftype_hid);
	$partform->set_param(PTTRN_name, "partid");

// Submit
$partform->addf(ftype_subm);
	$partform->set_param(PTTRN_value, "Сохранить");
// END:Форма

// Заполнение формы при условиях
if( (($_GET["id"] == "new") || (!$_GET["id"])) && !$part4edit )
{

} else
{
	if( !$part4edit )
	{
		$part4edit = $_GET["id"];
	}
	if( str_is_int($part4edit) )
	{
		$mobj_loc = clone $mobj;
		$mobj_loc->load($part4edit);
		$partform->set_param(PTTRN_signature, "Тип раздела (нельзя изменять)", $fieldindex["modul"]);
		$partform->set_param(PTTRN_disabled, true, $fieldindex["modul"]);
		$partform->select_by_value($mobj_loc->out(parttab_modul), $fieldindex["modul"]);
		$partform->set_param(PTTRN_value, $mobj_loc->out(parttab_name), $fieldindex["partname"]);
		$partform->set_param(PTTRN_selected, $mobj_loc->out(parttab_visible), $fieldindex["partcont"]);
		$partform->set_param(PTTRN_selected, $mobj_loc->out(parttab_isface), $fieldindex["partface"]);
		$partform->set_param(PTTRN_value, $mobj_loc->outid(), $fieldindex["id"]);
	}
}
?>
