<?php
$formfileout = "err.form.php";
if($freeset[$adressfree[$free_read]]["is"] && $freeset[$adressfree[$free_edit]]["is"])
{ // �������� ���� �������
$textpart = new htmlform("textpart");
// $textpart->set_action(SITE_INDEX . "textpart/edit.textpart.do.php?pid=" . $mobj->outid());
$textpart->set_action(SITE_INDEX . "?pid=" . $mobj->outid() . "&edit=do");

$tp->load_for($mobj->outid()); // ��������� ��������� ������

// ��������� �������
$tpform["h1"] = $textpart->addf(ftype_text);
	$textpart->set_param(PTTRN_signature, "���������");
	$textpart->set_param(PTTRN_name, "tpname");
	$textpart->set_param(PTTRN_value, $tp->out(texttab_head));

// ���� �������
$tpform["body"] = $textpart->addf(ftype_textar);
	$textpart->set_param(PTTRN_signature, "����");
	$textpart->set_param(PTTRN_name, "tpbody");
	$textpart->set_param(PTTRN_id, "tpbody");
	$textpart->set_param(PTTRN_value, $tp->out(texttab_body));

// id �������
$tpform["id"] = $textpart->addf(ftype_hid);
	$textpart->set_param(PTTRN_name, "tpid");
	$textpart->set_param(PTTRN_value, $tp->outid());

$textpart->addf(ftype_subm);
	$textpart->set_param(PTTRN_value, "���������");
	$textpart->set_param(PTTRN_class, "submbutton");

$thettl = $tp->out(texttab_head);
$part4edit = $mobj->outid(); // id ������� ��� ��������
$formfileout = TEXT_MODUL . "/edit.textpart.form.php";
$formfileout = TEXT_MODUL . "/new_edit.textpart.form.php"; // �������� �����
}
if($_GET["edit"] == "do")
{
	$formfileout = TEXT_MODUL . "/edit.textpart.do.php";
}
else
{
	// ������ � ��������
	$latt = $att->load_list_for();
	$attar = array();
	for($i=0; $i < $latt; ++$i)
	{
		$attar[$i] = array();
		$attar[$i]["href"] = "#";
		$attar[$i]["delhref"] = pub_tex_delfile . "&amp;" . UNIKEY . "=" . $att->out(UNIKEY, $i);
		$attar[$i]["src"]  = SITE_INDEX . "attach/show.attach.inc.php?id=" . $att->out(UNIKEY, $i);
		$attar[$i]["name"] = $att->out(TAB_ATTACH_name, $i);
		$attar[$i]["jsfunc"] = $att->out(UNIKEY, $i);
	}
}
?>
