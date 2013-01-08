<?php
$cutorderObj = new cutorder($dbobject);
$cutorderObj->SetPart($mobj->outid());

$cutunitObj = new cutunit($dbobject);
$cutunitObj->SetPart($mobj->outid());
?>
