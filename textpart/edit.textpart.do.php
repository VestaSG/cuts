<?php
$curpart = $_GET["pid"]; // �� ����, ���� do-���� ����� (index/index.do.php), � � ������� ������ ��� ������������
$login_obj->setpart($curpart);

$textpart->load();
$tp->set(texttab_head, $textpart->out_value($tpform["h1"]));
$tp->set(texttab_body, $textpart->out_value($tpform["body"]));
$tp->save($textpart->out_value($tpform["id"]));

$tp->load($textpart->out_value($tpform["id"]));
$hreffromhere = pub_tex_face;
include( TEXT_MODUL . "/htmldo.php");
?>
