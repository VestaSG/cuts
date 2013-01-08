<?php
$curpart = $_GET["pid"]; // не надо, если do-файл общий (index/index.do.php), а в модулях только его локализаторы
$login_obj->setpart($curpart);

$textpart->load();
$tp->set(texttab_head, $textpart->out_value($tpform["h1"]));
$tp->set(texttab_body, $textpart->out_value($tpform["body"]));
$tp->save($textpart->out_value($tpform["id"]));

$tp->load($textpart->out_value($tpform["id"]));
$hreffromhere = pub_tex_face;
include( TEXT_MODUL . "/htmldo.php");
?>
