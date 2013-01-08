<?php
$hreffromhere = "test.inc.php?a=form";
$att->FormParse($frm, $frmList);
$att->save();
include(MAIN_CL_DIR . "/htmldo.php");
?>
